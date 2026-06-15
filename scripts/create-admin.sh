#!/usr/bin/env bash
# Create (or update) a WordPress administrator user inside the rsk_wordpress container.
#
# Usage:
#   ./scripts/create-admin.sh <username> <email> <password>
#   ./scripts/create-admin.sh admin admin@example.com "S3cret!"
#
# If the user already exists, the password and role are reset to the values provided.

set -euo pipefail

CONTAINER="${WP_CONTAINER:-rsk_wordpress}"

if [[ $# -ne 3 ]]; then
  echo "Usage: $0 <username> <email> <password>" >&2
  exit 1
fi

USERNAME="$1"
EMAIL="$2"
PASSWORD="$3"

if ! docker ps --format '{{.Names}}' | grep -qx "$CONTAINER"; then
  echo "Container '$CONTAINER' is not running. Start the stack with:" >&2
  echo "  docker compose up -d" >&2
  exit 1
fi

docker exec -i \
  -e WP_NEW_USER="$USERNAME" \
  -e WP_NEW_EMAIL="$EMAIL" \
  -e WP_NEW_PASS="$PASSWORD" \
  "$CONTAINER" php -d error_reporting=E_ERROR -r '
define("WP_USE_THEMES", false);
$_SERVER["HTTP_HOST"] = "localhost";
$_SERVER["REQUEST_URI"] = "/";
require "/var/www/html/wp-load.php";

$username = getenv("WP_NEW_USER");
$email    = getenv("WP_NEW_EMAIL");
$password = getenv("WP_NEW_PASS");

$user_id = username_exists($username);
if (!$user_id) {
    $user_id = email_exists($email);
}

if ($user_id) {
    wp_set_password($password, $user_id);
    $user = new WP_User($user_id);
    $user->set_role("administrator");
    fwrite(STDOUT, "Updated existing user (id=$user_id, login=$username) — password reset and role set to administrator.\n");
} else {
    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        fwrite(STDERR, "Error: " . $user_id->get_error_message() . "\n");
        exit(1);
    }
    $user = new WP_User($user_id);
    $user->set_role("administrator");
    fwrite(STDOUT, "Created administrator (id=$user_id, login=$username, email=$email).\n");
}

fwrite(STDOUT, "Login at http://localhost:8080/wp-admin/\n");
'
