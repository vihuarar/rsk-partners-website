<?php

namespace DeliciousBrains\WPMDB\Common\Cli;

use DeliciousBrains\WPMDB\Common\Transfers\Files\Util;
use Exception;
use WP_CLI;
use WP_CLI\ExitException;
use WP_Error;

/**
 * Migrate your database. Export full sites including database, media, themes, plugins, mu-plugins, other files, root files, and core files. Find and replace content with support for serialized data.
 */
class Command {
	/**
	 * Register our commands.
	 *
	 * @throws Exception
	 */
	public static function register() {
		WP_CLI::add_command( 'migratedb', WPMDBCLI_Deprecated::class ); // Deprecated
		WP_CLI::add_command( 'migrate', self::class );
	}

	/**
	 * Export local database to file.
	 *
	 * ## OPTIONS
	 *
	 * <output-file>
	 * : A file path to export to. Filename will be modified to end in .sql or
	 * .sql.gz if necessary.
	 *
	 * [--find=<strings>]
	 * : A comma separated list of strings to find when performing a string find
	 * and replace across the database.
	 *
	 *     Values should be quoted as needed, i.e. when using a comma in the
	 *     find/replace string.
	 *
	 *     The --replace=<strings> argument should be used in conjunction to specify
	 *     the replacement values for the strings found using this argument. The number
	 *     of strings specified in this argument should match the number passed into
	 *     --replace=<strings> argument.
	 *
	 * [--replace=<strings>]
	 * : A comma separated list of replace value strings to implement when
	 * performing a string find & replace across the database.
	 *
	 *     Should be used in conjunction with the --find=<strings> argument, see it's
	 *     documentation for further explanation of the find & replace functionality.
	 *
	 * [--case-sensitive-find]
	 * : A comma separated list of strings to find when performing a string find
	 * and replace across the database.
	 *
	 * [--case-sensitive-replace]
	 * : A comma separated list of replace value strings to implement when
	 * performing a string find & replace across the database.
	 *
	 * [--exclude-post-revisions]
	 * : Exclude post revisions from export.
	 *
	 * [--skip-replace-guids]
	 * : Do not perform a find & replace on the guid column in the wp_posts table.
	 *
	 * [--exclude-spam]
	 * : Exclude spam comments.
	 *
	 * [--gzip-file]
	 * : GZip compress export file.
	 *
	 * [--include-transients]
	 * : Include transients (temporary cached data).
	 *
	 * [--follow]
	 * : Follow the migration until it finishes, updating displayed details as they change, including showing progress bars.
	 *
	 *     This is the default, see [--no-follow] for the opposite method.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it finishes, instead, return control immediately leaving the migration to continue in the background.
	 *
	 *     Pressing `Ctrl+c` instead of using this flag will also result in the migration continuing in the background.
	 *     Use the `wp migrate status` command to check the status of the background migration.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate export ./export.sql \
	 *        --find=//example.local,/Users/me/Sites/example \
	 *        --replace=//example.com,/var/www/html
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function export( $args, $assoc_args ) {
		$assoc_args['action']      = 'savefile';
		$assoc_args['export_dest'] = Util::sanitize_file_path( $args[0] );

		if ( empty( $assoc_args['export_dest'] ) ) {
			WP_CLI::error(
				Display::cleanup_message(
					__( 'You must provide a destination filename.', 'wp-migrate-db' )
				)
			);
		}

		$assoc_args = self::configure_follow_flag( $assoc_args );
		$profile    = $this->_get_profile_data_from_args( $args, $assoc_args );

		if ( is_wp_error( $profile ) ) {
			WP_CLI::error( $profile );
		}

		$this->_perform_cli_migration( $profile, $assoc_args );
	}

	/**
	 * Run a find/replace on the database.
	 *
	 * ## OPTIONS
	 *
	 * [--find=<strings>]
	 * : A comma separated list of strings to find when performing a string find
	 * and replace across the database.
	 *
	 *     Values should be quoted as needed, i.e. when using a comma in the
	 *     find/replace string.
	 *
	 *     The --replace=<strings> argument should be used in conjunction to specify
	 *     the replacement values for the strings found using this argument. The number
	 *     of strings specified in this argument should match the number passed into
	 *     --replace=<strings> argument.
	 *
	 * [--replace=<strings>]
	 * : A comma separated list of replace value strings to implement when
	 * performing a string find & replace across the database.
	 *
	 *     Should be used in conjunction with the --find=<strings> argument, see it's
	 *     documentation for further explanation of the find & replace functionality.
	 *
	 * [--case-sensitive-find]
	 * : A comma separated list of strings to find when performing a string find
	 * and replace across the database.
	 *
	 * [--case-sensitive-replace]
	 * : A comma separated list of replace value strings to implement when
	 * performing a string find & replace across the database.
	 *
	 * [--exclude-post-revisions]
	 * : Exclude post revisions from the find & replace.
	 *
	 * [--skip-replace-guids]
	 * : Do not perform a find & replace on the guid column in the wp_posts table.
	 *
	 * [--exclude-spam]
	 * : Exclude spam comments.
	 *
	 * [--include-transients]
	 * : Include transients (temporary cached data).
	 *
	 * [--follow]
	 * : Follow the migration until it finishes, updating displayed details as they change, including showing progress bars.
	 *
	 *     This is the default, see [--no-follow] for the opposite method.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it finishes, instead, return control immediately leaving the migration to continue in the background.
	 *
	 *     Pressing `Ctrl+c` instead of using this flag will also result in the migration continuing in the background.
	 *     Use the `wp migrate status` command to check the status of the background migration.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate find-replace \
	 *        --find=//example.local,/Users/me/Sites/example \
	 *        --replace=//example.com,/var/www/html
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @subcommand find-replace
	 * @throws ExitException
	 */
	public function find_replace( $args, $assoc_args ) {
		$assoc_args['action'] = 'find_replace';

		$assoc_args = self::configure_follow_flag( $assoc_args );
		$profile    = $this->_get_profile_data_from_args( $args, $assoc_args );

		if ( is_wp_error( $profile ) ) {
			WP_CLI::error( $profile );
		}

		$this->_perform_cli_migration( $profile, $assoc_args );
	}

	/**
	 * Show the status of the current migration.
	 *
	 * [--format=<nice|csv|table|json|yaml>]
	 * : Optional format to display the status info in, default is "nice".
	 *
	 *     Does nothing if using the --follow option.
	 *
	 *     Accepted values:
	 *
	 *     * nice: Colorized list of label and info pairs.
	 *     * csv: Comma separated values.
	 *     * table: Table with label and info columns.
	 *     * json: JSON array of objects with label and info keys.
	 *     * yaml: YAML with multiple label and info pairs.
	 *
	 * [--follow]
	 * : Follow the migration until it finishes, updating displayed details as they change, including showing progress bars.
	 *
	 *     Overrides the --format option.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it finishes, instead, return control immediately leaving the migration to continue in the background.
	 *
	 *     This is the default, see [--follow] for the opposite method.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate status
	 *     wp migrate status --format=json
	 *     wp migrate status --follow
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function status( $args, $assoc_args ) {
		$format = empty( $assoc_args['format'] ) ? 'nice' : $assoc_args['format'];
		$follow = ! empty( $assoc_args['follow'] );

		$wpmdb_cli = $this->_get_cli_instance();

		if ( $follow ) {
			$wpmdb_cli->follow_migration_status();
		} else {
			$wpmdb_cli->display_migration_status( $format );
		}
	}

	/**
	 * Pause a running migration.
	 *
	 * [--follow]
	 * : Follow the migration until it pauses, and later finishes, updating displayed details as they change, including showing progress bars.
	 *
	 *     Using this flag will display the same details as the `status` command does when using the same flag.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it pauses, and later finishes, instead, return control immediately leaving the migration to pause itself in the background.
	 *
	 *     This is the default, see [--follow] for the opposite method.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate pause
	 *     wp migrate pause --follow
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function pause( $args, $assoc_args ) {
		$follow = ! empty( $assoc_args['follow'] );

		$wpmdb_cli = $this->_get_cli_instance();
		$result    = $wpmdb_cli->pause();

		if ( ! $result ) {
			WP_CLI::error(
				_x( 'No migration running.', 'CLI message', 'wp-migrate-db' )
			);
		}

		if ( $follow ) {
			$wpmdb_cli->follow_migration_status();
		}
	}

	/**
	 * Resume a paused migration.
	 *
	 * [--follow]
	 * : Follow the migration until it resumes, and later finishes, updating displayed details as they change, including showing progress bars.
	 *
	 *     Using this flag will display the same details as the `status` command does when using the same flag.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it resumes, and later finishes, instead, return control immediately leaving the migration to resume itself in the background.
	 *
	 *     This is the default, see [--follow] for the opposite method.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate resume
	 *     wp migrate resume --follow
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function resume( $args, $assoc_args ) {
		$follow = ! empty( $assoc_args['follow'] );

		$wpmdb_cli = $this->_get_cli_instance();
		$result    = $wpmdb_cli->resume();

		if ( ! $result ) {
			WP_CLI::error(
				_x( 'No migration running.', 'CLI message', 'wp-migrate-db' )
			);
		}

		if ( $follow ) {
			$wpmdb_cli->follow_migration_status();
		}
	}

	/**
	 * Cancel a running migration.
	 *
	 * [--follow]
	 * : Follow the migration until it cancels, updating displayed details as they change, including showing progress bars.
	 *
	 *     Using this flag will display the same details as the `status` command does when using the same flag.
	 *
	 * [--no-follow]
	 * : Do not follow the migration until it cancels, instead, return control immediately leaving the migration to cancel itself in the background.
	 *
	 *     This is the default, see [--follow] for the opposite method.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate cancel
	 *     wp migrate cancel --follow
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function cancel( $args, $assoc_args ) {
		$follow = ! empty( $assoc_args['follow'] );

		$wpmdb_cli = $this->_get_cli_instance();
		$result    = $wpmdb_cli->cancel();

		if ( ! $result ) {
			WP_CLI::error(
				_x( 'No migration running.', 'CLI message', 'wp-migrate-db' )
			);
		}

		if ( $follow ) {
			$wpmdb_cli->follow_migration_status();
		}
	}

	/**
	 * Dismiss a finished migration.
	 *
	 * When a migration finishes, its final status is shown in the admin dashboard
	 * and can be seen on the command line with the `status` subcommand.
	 *
	 * Use this subcommand to dismiss the migration so that it does not have to be
	 * dismissed in the admin dashboard. If you only use the command line, you do
	 * not need to dismiss the last finished migration before running a new migration.
	 *
	 * ## EXAMPLES
	 *
	 *     wp migrate dismiss
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @throws ExitException
	 */
	public function dismiss( $args, $assoc_args ) {
		$wpmdb_cli = $this->_get_cli_instance();
		$wpmdb_cli->dismiss();
	}

	/**
	 * Get profile data from CLI args.
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Named args.
	 *
	 * @return array|WP_Error
	 * @throws ExitException
	 */
	protected function _get_profile_data_from_args( $args, $assoc_args ) {
		$wpmdb_cli = $this->_get_cli_instance();

		return $wpmdb_cli->get_profile_data_from_args( $args, $assoc_args );
	}

	/**
	 * Perform CLI migration.
	 *
	 * @param mixed $profile    Profile key or array.
	 * @param array $assoc_args Named args.
	 *
	 * @return void
	 * @throws ExitException
	 */
	protected function _perform_cli_migration( $profile, array $assoc_args = [] ) {
		$this->maybe_assert_is_multisite_admin();

		$wpmdb_cli = $this->_get_cli_instance();
		$result    = $wpmdb_cli->cli_migration( $profile, $assoc_args );

		if ( is_wp_error( $result ) ) {
			WP_CLI::error( Display::cleanup_message( $result->get_error_message() ) );
		}

		if ( ! empty( $assoc_args['follow'] ) ) {
			$wpmdb_cli->follow_migration_status( true );
		}
	}

	/**
	 * Get an appropriate instance of the CLI class.
	 *
	 * This function has a side effect of instantiating the plugin global if not already set up.
	 *
	 * @return Cli|false|mixed|null
	 * @throws ExitException
	 */
	protected function _get_cli_instance() {
		$wpmdb_cli = null;

		if ( function_exists( 'wpmdb_pro_cli' ) ) {
			$wpmdb_cli = wpmdb_pro_cli();
		} elseif ( function_exists( 'wpmdb_cli' ) ) {
			$wpmdb_cli = wpmdb_cli();
		}

		// If no valid instance retrieved, bail.
		if ( empty( $wpmdb_cli ) ) {
			WP_CLI::error(
				__( 'WP Migrate CLI class not available.', 'wp-migrate-db-cli' )
			);
		}

		return $wpmdb_cli;
	}

	/**
	 * Configure follow/no-follow flag to pass validation.
	 *
	 * Currently, for backwards compatibility, we'll follow a migration unless told not to.
	 * Because we're using the --follow/--no-follow pattern, WP-CLI converts --no-follow
	 * to an empty --follow flag, which we need to deal with by unsetting to pass validation.
	 *
	 * @param array $assoc_args Named args.
	 *
	 * @return array
	 */
	public static function configure_follow_flag( $assoc_args ) {
		if ( isset( $assoc_args['follow'] ) && empty( $assoc_args['follow'] ) ) {
			unset( $assoc_args['follow'] );
		} else {
			$assoc_args['follow'] = true;
		}

		return $assoc_args;
	}

	/**
	 * Make sure we are in the admin context required for multisite migrations.
	 */
	protected function maybe_assert_is_multisite_admin() {
		// NOTE: is_admin(), not is_network_admin(), is required here.
		if ( is_multisite() && ! is_admin() ) {
			WP_CLI::error(
				__(
					'Running a migration needs admin privileges on a multisite, please run with "--context=admin".',
					'wp-migrate-db'
				)
			);
		}
	}
}

/**
 * Deprecated WP Migrate Lite command. Use migrate instead.
 */
class WPMDBCLI_Deprecated extends Command {
}
