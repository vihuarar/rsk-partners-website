# RSK Partners — Local WordPress Stack

Local Docker setup that mounts the WordPress site from `wordpress-site/` into an Apache + PHP 8.4 container, with a MySQL 8.4 container seeded from `mysql-backups/wp_rskrealestate.sql`.

## Layout

```
.
├── docker-compose.yml             # MySQL + WordPress services
├── Dockerfile                     # PHP 8.4 + Apache image (mysqli, gd, intl, zip, opcache…)
├── mysql-backups/
│   └── wp_rskrealestate.sql       # Auto-imported on first DB boot
├── scripts/
│   └── create-admin.sh            # Creates/resets a wp-admin administrator
└── wordpress-site/                # Bind-mounted into /var/www/html
    ├── wp-config.sample.php       # Template — copy to wp-config.php
    └── wp-config.php              # Real config (gitignored — contains secrets)
```

## First-time setup

### 1. Create `wp-config.php`

`wp-config.php` is gitignored because it holds DB credentials, WordPress auth salts, and WP Engine / Sucuri keys. Create your local copy from the template:

```bash
cp wordpress-site/wp-config.sample.php wordpress-site/wp-config.php
```

Then open `wordpress-site/wp-config.php` and fill in:

| Constant | What to put | Notes |
| --- | --- | --- |
| `DB_NAME` | `wp_rskrealestate` | Must match `MYSQL_DATABASE` in `docker-compose.yml`. |
| `DB_USER` | `rskrealestate` | Must match `MYSQL_USER` in `docker-compose.yml`. |
| `DB_PASSWORD` | the value of `MYSQL_PASSWORD` in `docker-compose.yml` | |
| `DB_HOST` / `DB_HOST_SLAVE` | leave as-is | Reads `WORDPRESS_DB_HOST` env var (set by Compose to `db:3306`); falls back to `127.0.0.1:3306` outside Docker. |
| `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` | fresh random strings | Easiest: open <https://api.wordpress.org/secret-key/1.1/salt/> in a browser and paste the generated block in. |
| `PWP_NAME` | `rskrealestate` | WP Engine install name; safe to leave as the project slug locally. |
| `WPE_APIKEY`, `WPE_CLUSTER_ID`, `WPE_SFTP_ENDPOINT`, `SUCURI_PLUG_KEY`, `SUCURI_PLUG_SALT` | leave empty | Production-only credentials; not needed for local dev. |

> The DB credentials and the docker-compose env vars must match exactly — change them in one place and you have to change them in the other.

### 2. Start the stack

```bash
docker compose up -d --build
```

First run builds the PHP image (~5 min) and imports the SQL dump (~30 sec). Subsequent starts are seconds.

- WordPress: <http://localhost:8080>
- MySQL (from host): `localhost:3307`, user `rskrealestate`, password matches `MYSQL_PASSWORD`

### 3. Create a wp-admin user

The dump's existing users have production password hashes you don't know. Create your own admin:

```bash
./scripts/create-admin.sh <username> <email> <password>
# example:
./scripts/create-admin.sh admin admin@rskpartners.local 'ChangeMe!2026'
```

Then log in at <http://localhost:8080/wp-admin/>.

The script is idempotent — re-running with the same username resets the password and forces the `administrator` role.

## Day-to-day commands

```bash
# Tail WordPress logs
docker compose logs -f wordpress

# Restart after a Dockerfile change
docker compose up -d --build

# Stop everything (keep the DB volume)
docker compose down

# Stop and WIPE the DB volume — next `up` re-imports the SQL dump from scratch
docker compose down -v

# Open a shell in the WordPress container
docker exec -it rsk_wordpress bash

# Open the MySQL CLI
docker exec -it rsk_mysql mysql -urskrealestate -p wp_rskrealestate
```

## Refreshing the database

To re-seed MySQL from a new dump:

1. Drop the new `.sql` file at `mysql-backups/wp_rskrealestate.sql` (replacing the existing one).
2. `docker compose down -v && docker compose up -d` — the volume wipe makes the entrypoint re-run the import.

## Known quirks (inherited from WP Engine)

This codebase was exported from WP Engine and ships with cache/host integrations that may misbehave locally. If you see white screens, fatal errors, or "Memcached not found":

- Rename `wordpress-site/wp-content/object-cache.php` — it expects a Memcached socket at `/tmp/memcached.sock` that doesn't exist locally.
- Rename `wordpress-site/wp-content/advanced-cache.php` and set `define('WP_CACHE', false)` in `wp-config.php` if Breeze (the WP Engine cache plugin) causes issues.
- Both `object-cache.php` and `advanced-cache.php` are listed in `.gitignore`, so renaming/removing them locally won't pollute the repo.

## What's ignored

- `wordpress-site/.gitignore` excludes: `wp-config.php`, `wp-content/uploads/` (218 MB of media), `wp-content/cache/`, log files, OS noise, WP Engine drop-ins, Wordfence logs, and the legacy `.wpress` migration archive.
- See that file for the full list.
