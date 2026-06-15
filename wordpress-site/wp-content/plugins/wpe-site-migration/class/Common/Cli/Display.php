<?php

namespace DeliciousBrains\WPMDB\Common\Cli;

use cli\Shell;
use DateTime;
use DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigration;
use DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigrationProcess;
use DeliciousBrains\WPMDB\Common\Util\Util;
use DeliciousBrains\WPMDB\Data\Stage;
use WP_CLI;
use WP_CLI\NoOp;

use function WP_CLI\Utils\format_items;

/**
 * CLI display utility functions.
 */
class Display {
	/**
	 * Cleanup message, replacing <br> with \n and removing HTML.
	 *
	 * @param string $message Error message.
	 *
	 * @return string
	 */
	public static function cleanup_message( $message ) {
		if ( empty( $message ) || ! is_string( $message ) ) {
			return '';
		}

		$message = html_entity_decode( $message, ENT_QUOTES );
		$message = preg_replace( '#<br\s*/?>#', "\n", $message );

		return trim( strip_tags( $message ) );
	}

	/**
	 * Display information for a migration.
	 *
	 * @param array  $items  Array of item arrays with label and info elements.
	 *                       Each item may optionally have a label_color and
	 *                       info_color element with a colorize color code.
	 * @param string $format Optional format to display data with, e.g. csv, table, json, yaml,
	 *                       default is our custom nice format.
	 */
	public static function display_migration( array $items, $format = 'nice' ) {
		switch ( $format ) {
			case 'csv':
			case 'table':
			case 'json':
			case 'yaml':
				format_items(
					$format,
					$items,
					[ 'label', 'info' ]
				);
				break;
			default:
				self::display_info_lines( $items );
		}
	}

	/**
	 * Returns an array of array items that can be used as display lines.
	 *
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return array
	 */
	public static function get_display_info_items( $task_item, $timestamp ) {
		// Something has gone wrong, bail.
		if ( ! self::data_valid( $task_item, $timestamp ) ) {
			return [];
		}

		$items = self::get_header_display_items( $task_item, $timestamp );

		if ( empty( $items ) ) {
			return $items;
		}

		if ( ! empty( $task_item['strings']['phase_name'] ) ) {
			$items[] = array(
				'label' => _x( 'Phase', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['strings']['phase_name'],
			);
		}

		if (
			! empty( $task_item['current_stage'] ) &&
			! empty( $task_item['strings']['current_stage_name'] )
		) {
			$items[] = array(
				'label' => _x( 'Stage', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['strings']['current_stage_name'],
			);
		} elseif (
			! empty( $task_item['last_stage'] ) &&
			! empty( $task_item['strings']['last_stage_name'] )
		) {
			$items[] = array(
				'label' => _x( 'Stage', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['strings']['last_stage_name'],
			);
		}

		return self::maybe_append_footer_display_items( $items, $task_item, $timestamp );
	}

	/**
	 * Are the task item and timestamp generally ok to use?
	 *
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return bool
	 */
	private static function data_valid( $task_item, $timestamp ) {
		if (
			is_array( $task_item ) &&
			! empty( $task_item['migration_id'] ) &&
			is_int( $timestamp )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Get initial static display items for a migration.
	 *
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return array
	 */
	public static function get_header_display_items( $task_item, $timestamp ) {
		// Something has gone wrong, bail.
		if ( ! self::data_valid( $task_item, $timestamp ) ) {
			return [];
		}

		$items[] = array(
			'label' => _x( 'Migration ID', 'CLI status info label', 'wp-migrate-db' ),
			'info'  => $task_item['migration_id'],
		);

		$profile_str = self::format_profile_info( $task_item );

		if ( ! empty( $profile_str ) ) {
			$items[] = array(
				'label' => _x( 'Profile', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $profile_str,
			);
		}

		if ( ! empty( $task_item['strings']['type_name'] ) ) {
			$items[] = array(
				'label' => _x( 'Type', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['strings']['type_name'],
			);
		}

		if ( ! empty( $task_item['url'] ) && ! empty( $task_item['type'] ) && 'push' === $task_item['type'] ) {
			$items[] = array(
				'label' => _x( 'To', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['url'],
			);
		}

		if ( ! empty( $task_item['url'] ) && ! empty( $task_item['type'] ) && 'pull' === $task_item['type'] ) {
			$items[] = array(
				'label' => _x( 'From', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['url'],
			);
		}

		$started_by_str = self::format_started_by_info( $task_item );

		if ( ! empty( $started_by_str ) ) {
			$items[] = array(
				'label' => _x( 'Started By', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $started_by_str,
			);
		}

		$started_at_str = self::format_started_at_info( $task_item );

		if ( ! empty( $started_at_str ) ) {
			$items[] = array(
				'label' => _x( 'Started At', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $started_at_str,
			);
		}

		return $items;
	}

	/**
	 * Maybe append final static display items to a migration.
	 *
	 * @param array $items     Current array of display items.
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return array
	 */
	public static function maybe_append_footer_display_items( $items, $task_item, $timestamp ) {
		// Something has gone wrong, bail.
		if ( ! self::data_valid( $task_item, $timestamp ) ) {
			return [];
		}

		$items[] = array(
			'label' => _x( 'Processed', 'CLI status info label', 'wp-migrate-db' ),
			'info'  => self::format_progress_info( $task_item ),
		);

		if ( ! empty( $task_item['activity_status'] ) && ! empty( $task_item['strings']['activity_status_name'] ) ) {
			$item = array(
				'label' => _x( 'Status', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $task_item['strings']['activity_status_name'],
			);

			switch ( $task_item['activity_status'] ) {
				case 'complete':
					$item['info_color'] = '%G';
					break;
				case 'failed':
				case 'incomplete':
					$item['info_color'] = '%R';
					break;
				default:
					$item['info_color'] = '%Y';
			}

			$items[] = $item;
		}

		$finished_at_str = self::format_finished_at_info( $task_item );

		if ( ! empty( $finished_at_str ) ) {
			$items[] = array(
				'label' => _x( 'Finished At', 'CLI status info label', 'wp-migrate-db' ),
				'info'  => $finished_at_str,
			);
		}

		$items[] = array(
			'label' => _x( 'Runtime', 'CLI status info label', 'wp-migrate-db' ),
			'info'  => self::format_runtime_info( $task_item, $timestamp ),
		);

		return self::maybe_append_error_display_items( $items, $task_item, $timestamp );
	}

	/**
	 * Maybe append display items for an error if appropriate.
	 *
	 * @param array $items     Current array of display items.
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return array
	 */
	private static function maybe_append_error_display_items( $items, $task_item, $timestamp ) {
		// Something has gone wrong, bail.
		if ( ! self::data_valid( $task_item, $timestamp ) ) {
			return [];
		}

		if ( BackgroundMigrationProcess::has_errors( $task_item ) ) {
			$error = BackgroundMigrationProcess::get_error( $task_item );

			if ( is_array( $error ) && ! empty( $error['code'] ) ) {
				$items[] = array(
					'label'       => _x( 'Error Code', 'CLI status info label', 'wp-migrate-db' ),
					'info'        => $error['code'],
					'label_color' => '%r',
					'info_color'  => '%R',
				);
			}

			if ( is_array( $error ) && ! empty( $error['message'] ) ) {
				$items[] = array(
					'label'       => _x( 'Error Message', 'CLI status info label', 'wp-migrate-db' ),
					'info'        => $error['message'],
					'label_color' => '%r',
					'info_color'  => '%R',
				);
			}

			$error_request_str = self::format_error_request( $error );

			if ( ! empty( $error_request_str ) ) {
				$items[] = array(
					'label'       => _x( 'Request', 'CLI status info label', 'wp-migrate-db' ),
					'info'        => $error_request_str,
					'label_color' => '%r',
					'info_color'  => '%R',
				);
			}

			$error_response_str = self::format_error_response( $error );

			if ( ! empty( $error_response_str ) ) {
				$items[] = array(
					'label'       => _x( 'Response', 'CLI status info label', 'wp-migrate-db' ),
					'info'        => $error_response_str,
					'label_color' => '%r',
					'info_color'  => '%R',
				);
			}
		}

		return $items;
	}

	/**
	 * Displays a single formatted info line.
	 *
	 * @param string $label       Label for the info, no ":" needed.
	 * @param string $info        Info to be displayed.
	 * @param string $label_color Color code to colorize label with, default '%m'.
	 * @param string $info_color  Color code to colorize info with, default '%N'.
	 *
	 * @return void
	 */
	private static function display_info_line( $label, $info, $label_color = '%m', $info_color = '%N' ) {
		$line = ! is_string( $label_color ) ? '%m' : $label_color;
		$line .= empty( $label ) ? '' : $label . ': ';
		$line .= ! is_string( $info_color ) ? '%N' : $info_color;
		$line .= $info;
		$line .= '%n';
		WP_CLI::log( WP_CLI::colorize( self::cleanup_message( $line ) ) );
	}

	/**
	 * Display data as formatted info lines.
	 *
	 * @param array $items Array of item arrays with label and info elements.
	 *                     Each item may optionally have a label_color and
	 *                     info_color element with a colorize color code.
	 *
	 * @return void
	 */
	private static function display_info_lines( array $items ) {
		foreach ( $items as $item ) {
			if ( ! is_array( $item ) || ! isset( $item['label'] ) || ! isset( $item['info'] ) ) {
				continue;
			}

			$label_color = isset( $item['label_color'] ) && is_string( $item['label_color'] ) ? $item['label_color'] : '%m';
			$info_color  = isset( $item['info_color'] ) && is_string( $item['info_color'] ) ? $item['info_color'] : '%N';

			self::display_info_line( $item['label'], $item['info'], $label_color, $info_color );
		}
	}

	/**
	 * Display progress for a migration with phase appropriate formats.
	 *
	 * @param array $task_item Data for a migration.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return bool Progress displayed without error.
	 */
	public static function display_progress( $task_item, $timestamp ) {
		// Something has gone wrong, bail.
		if ( ! self::data_valid( $task_item, $timestamp ) || empty( $task_item['phase'] ) ) {
			return false;
		}

		static $progress = null;
		static $last_phase = '';
		static $last_stage = '';
		static $last_value = 0;
		static $completed_stages_per_phase = [];

		$phase      = '';
		$stage      = '';
		$stage_desc = empty( $task_item['strings']['current_stage_desc'] ) ? '' : $task_item['strings']['current_stage_desc'];

		if ( ! empty( $task_item['strings']['phase_name'] ) ) {
			$phase = $task_item['phase'];
		}

		// Something has gone wrong, bail.
		if ( empty( $phase ) ) {
			if ( ! empty( $progress ) ) {
				$progress->finish( false );
			}

			return false;
		}

		// Ensure we display a new line of progress for each phase.
		if ( ! empty( $progress ) && ! empty( $last_phase ) && ! empty( $last_stage ) && $last_phase !== $phase ) {
			$completed_stages_per_phase[ $last_phase ][] = $last_stage;

			$last_stage_stats = BackgroundMigration::get_stage_stats( $task_item, $last_stage );

			// Dots class doesn't have ability to update message, so we need to recreate it if message changed,
			// and in this case we don't really know whether it changed or not, so we'll update anyway.
			// This phase type test isn't strictly necessary as we only have two phases, but just in case.
			if ( BackgroundMigration::INITIALIZATION_PHASE === $last_phase && Stage::show_progress( $last_stage ) ) {
				$message = self::get_progress_line_title(
					apply_filters( 'wpmdb_get_stage_desc', '', $task_item['type'], $last_phase, $last_stage ),
					$last_stage_stats['total']['target_bytes']
				);

				$progress = new Dots( $message, 10 );

				$progress->tick();
			}

			$progress->finish();
			$progress = null;
		}

		if ( ! empty( $task_item['current_stage'] ) && ! empty( $task_item['strings']['current_stage_name'] ) ) {
			$stage = $task_item['current_stage'];
		} elseif ( ! empty( $task_item['last_stage'] ) && ! empty( $task_item['strings']['last_stage_name'] ) ) {
			$stage = $task_item['last_stage'];
		}

		// Something has gone wrong, bail.
		if ( empty( $stage ) ) {
			if ( ! empty( $progress ) ) {
				$progress->finish( false );
			}

			return false;
		}

		$stage_stats = BackgroundMigration::get_stage_stats( $task_item, $stage );

		// Something has gone wrong, bail.
		if ( ! isset( $stage_stats['total']['processed_bytes'] ) && ! isset( $stage_stats['total']['target_bytes'] ) ) {
			if ( ! empty( $progress ) ) {
				$progress->finish( false );
			}

			return false;
		}

		// Ensure we display a new line of progress for each stage.
		if ( ! empty( $progress ) && ! empty( $last_phase ) && ! empty( $last_stage ) && $last_stage !== $stage ) {
			$completed_stages_per_phase[ $last_phase ][] = $last_stage;

			$last_stage_stats = BackgroundMigration::get_stage_stats( $task_item, $last_stage );

			// Dots class doesn't have ability to update message, so we need to recreate it if message changed,
			// and in this case we don't really know whether it changed or not, so we'll update anyway.
			if ( BackgroundMigration::INITIALIZATION_PHASE === $last_phase && Stage::show_progress( $last_stage ) ) {
				$message = self::get_progress_line_title(
					apply_filters( 'wpmdb_get_stage_desc', '', $task_item['type'], $last_phase, $last_stage ),
					$last_stage_stats['total']['target_bytes']
				);

				$progress = new Dots( $message, 10 );

				$progress->tick();
			}

			// Make sure progress bar message is up to date.
			if ( BackgroundMigration::PROCESSING_PHASE === $last_phase ) {
				$increment  = self::get_progress_bar_increment( $last_value, $last_stage_stats );
				$last_value += $increment;

				// Keep processing message short to allow room for progress bar.
				$message = self::format_processed_of_target_info(
					$last_stage_stats['total']['processed_bytes'],
					$last_stage_stats['total']['target_bytes']
				);

				$progress->tick( $increment, $message );
			}

			$progress->finish();
			$progress = null;
		}

		// Before displaying new progress, make sure to display any stages that may not have been displayed
		// because we're coming in mid-migration or data polling missed a quick stage.
		if ( empty( $progress ) ) {
			// We only have 2 phases, so if just switched or coming in during processing phase,
			// make sure all initialized stages displayed.
			if ( empty( $last_phase ) && BackgroundMigration::PROCESSING_PHASE === $phase ) {
				$last_phase = BackgroundMigration::INITIALIZATION_PHASE;
			}

			if (
				$last_phase !== $phase &&
				BackgroundMigration::INITIALIZATION_PHASE === $last_phase &&
				! empty( $task_item['stages'] )
			) {
				$completed_stages_per_phase = self::display_skipped_progress(
					$completed_stages_per_phase,
					$task_item,
					$timestamp,
					$last_phase
				);

				// Display total target bytes at end of initialization.
				self::display_info_line(
					_x( 'Total To Be Processed', 'CLI status info label', 'wp-migrate-db' ),
					self::format_bytes_for_display( $task_item['total']['target_bytes'] )
				);
			}

			// Check that we haven't skipped stages for current phase, up to current stage.
			$completed_stages_per_phase = self::display_skipped_progress(
				$completed_stages_per_phase,
				$task_item,
				$timestamp,
				$phase,
				$stage
			);
		}

		$message = self::get_progress_line_title( $stage_desc );

		if ( BackgroundMigration::INITIALIZATION_PHASE === $phase && Stage::show_progress( $stage ) ) {
			$message = self::get_progress_line_title( $stage_desc, $stage_stats['total']['target_bytes'] );
		}

		if ( BackgroundMigration::PROCESSING_PHASE === $phase && Stage::show_progress( $stage ) ) {
			// Display title line for each new processing stage.
			if ( empty( $progress ) ) {
				WP_CLI::log( WP_CLI::colorize( $message . " ...\r" ) );
			}

			// Keep processing message short to allow room for progress bar.
			$message = self::format_processed_of_target_info(
				$stage_stats['total']['processed_bytes'],
				$stage_stats['total']['target_bytes']
			);
		}

		// Depending on activity status, maybe append status to message if not active or finished.
		if (
			! empty( $task_item['activity_status'] ) &&
			'active' !== $task_item['activity_status'] &&
			! empty( $task_item['strings']['activity_status_name'] ) &&
			empty( $task_item['finished'] )
		) {
			// Append status so that stage is visible for paused, cancelled etc.
			$message .= ' %Y[' . $task_item['strings']['activity_status_name'] . ']%n';
		}

		// Display dots for initialization stage, but skip if progress will not be displayed, e.g. for finalize.
		// However, if displaying processing phase for a stage that doesn't get a progress bar, display dots instead.
		if (
			( BackgroundMigration::INITIALIZATION_PHASE === $phase && Stage::show_progress( $stage ) ) ||
			( BackgroundMigration::PROCESSING_PHASE === $phase && ! Stage::show_progress( $stage ) )
		) {
			if ( empty( $progress ) ) {
				$progress = new Dots( $message, 10 );
			}

			$progress->tick( 1, $message );
		}

		if ( BackgroundMigration::PROCESSING_PHASE === $phase && Stage::show_progress( $stage ) ) {
			if ( empty( $progress ) ) {
				$progress   = self::make_progress_bar( $message, self::get_progress_bar_total( $stage_stats ) );
				$last_value = 0;
			}

			$increment  = self::get_progress_bar_increment( $last_value, $stage_stats );
			$last_value += $increment;
			$progress->tick( $increment, $message );
		}

		// When finished, we either need to complete the progress display, or force a newline
		// due to the colorized message somehow stripping the newline before the next log line.
		if ( ! empty( $progress ) && ! empty( $task_item['activity_status'] ) && 'complete' === $task_item['activity_status'] ) {
			$progress->finish();
		} elseif ( ! empty( $task_item['finished'] ) ) {
			WP_CLI::log( "\r" );
		}

		$last_phase = $phase;
		$last_stage = $stage;

		return true;
	}

	/**
	 * Display progress lines for a given phase, returning array of completed stages by phase.
	 *
	 * @param array  $completed_stages_per_phase Already completed stages per phase, these will not be redisplayed.
	 * @param array  $task_item                  Data for a migration.
	 * @param int    $timestamp                  Unix timestamp for end of migration, or current time.
	 * @param string $phase                      Phase to display a progress line for.
	 * @param string $stage                      Stage to display progress up until for phase, default ALL.
	 *
	 * @return array Updated completed stages per phase.
	 */
	private static function display_skipped_progress(
		$completed_stages_per_phase,
		$task_item,
		$timestamp,
		$phase,
		$stage = 'ALL'
	) {
		foreach ( $task_item['stages'] as $stage_stats ) {
			if (
				! empty( $stage_stats['stage'] ) &&
				isset( $stage_stats['total']['processed_bytes'] ) &&
				isset( $stage_stats['total']['target_bytes'] ) &&
				(
					empty( $completed_stages_per_phase[ $phase ] ) ||
					! in_array( $stage_stats['stage'], $completed_stages_per_phase[ $phase ] )
				)
			) {
				// Got to current stage, skip it and the rest.
				if ( $stage_stats['stage'] === $stage ) {
					break;
				}

				// Skip displaying initialization of some stages, e.g. finalize.
				if ( BackgroundMigration::INITIALIZATION_PHASE === $phase && ! Stage::show_progress( $stage_stats['stage'] ) ) {
					$completed_stages_per_phase[ $phase ][] = $stage_stats['stage'];

					continue;
				}

				if ( BackgroundMigration::INITIALIZATION_PHASE === $phase ) {
					$message = self::get_progress_line_title(
						apply_filters( 'wpmdb_get_stage_desc', '', $task_item['type'], $phase, $stage_stats['stage'] ),
						$stage_stats['total']['target_bytes']
					);

					$progress = new Dots( $message, 10 );
				} else {
					$message = self::get_progress_line_title(
						apply_filters( 'wpmdb_get_stage_desc', '', $task_item['type'], $phase, $stage_stats['stage'] )
					);

					// Show title line and progress bar, or just dots if progress bar not appropriate.
					if ( Stage::show_progress( $stage_stats['stage'] ) ) {
						WP_CLI::log( WP_CLI::colorize( $message . " ...\r" ) );

						$progress = self::make_progress_bar(
							self::format_processed_of_target_info(
								$stage_stats['total']['processed_bytes'],
								$stage_stats['total']['target_bytes']
							),
							self::get_progress_bar_total( $stage_stats )
						);
					} else {
						$progress = new Dots( $message, 10 );
					}
				}

				$progress->finish();
				$completed_stages_per_phase[ $phase ][] = $stage_stats['stage'];
			}
		}

		return $completed_stages_per_phase;
	}

	/**
	 * Get formatted progress line title.
	 *
	 * @param string   $stage_desc Stage description.
	 * @param int|null $bytes      Optional bytes to be formatted and appended to title.
	 *
	 * @return string
	 */
	private static function get_progress_line_title( $stage_desc, $bytes = null ) {
		if ( ! is_string( $stage_desc ) || empty( $stage_desc ) ) {
			return __( 'Unknown Stage', 'wp-migrate-db-pro' );
		}

		$title = '%Y' . trim( $stage_desc ) . '%n';

		if ( is_int( $bytes ) ) {
			$title .= ' ' . self::format_bytes_for_display( $bytes );
		}

		return $title;
	}

	/**
	 * Get total for progress bar.
	 *
	 * @param array $stage_stats Stats for a stage.
	 *
	 * @return int
	 */
	private static function get_progress_bar_total( $stage_stats ) {
		return empty( $stage_stats['total']['target_bytes'] ) ? 0 : (int) $stage_stats['total']['target_bytes'];
	}

	/**
	 * Get increment value for progress bar.
	 *
	 * @param int   $last_value  The value that the progress bar was last set to.
	 * @param array $stage_stats Stats for a stage.
	 *
	 * @return int
	 */
	private static function get_progress_bar_increment( $last_value, $stage_stats ) {
		if ( empty( $last_value ) || ! is_int( $last_value ) ) {
			$last_value = 0;
		}

		$processed_bytes = empty( $stage_stats['total']['processed_bytes'] ) ? 0 : (int) $stage_stats['total']['processed_bytes'];

		return (int) max( $processed_bytes - $last_value, 0 );
	}

	/**
	 * Get formatted data regarding the saved migration profile used, if one used.
	 *
	 * @param array $task_item Current or last migration task item.
	 *
	 * @return string
	 */
	private static function format_profile_info( $task_item ) {
		if (
			! is_array( $task_item ) ||
			empty( $task_item['profile_id'] ) ||
			empty( $task_item['profile_name'] )
		) {
			return '';
		}

		return trim( $task_item['profile_name'] ) . ' (Profile ID: ' . $task_item['profile_id'] . ')';
	}

	/**
	 * Get formatted data regarding who started the migration.
	 *
	 * @param array $task_item Current or last migration task item.
	 *
	 * @return string
	 */
	private static function format_started_by_info( $task_item ) {
		if ( ! is_array( $task_item ) || empty( $task_item['started_by'] ) ) {
			return '';
		}

		$output = '';
		$user   = get_user_by( 'id', $task_item['started_by'] );

		if ( ! empty( $user ) && is_a( $user, 'WP_User' ) ) {
			$output = $user->display_name . ' (User ID: ' . $task_item['started_by'] . ')';
		}

		return $output;
	}

	/**
	 * Get formatted data regarding when the migration was started.
	 *
	 * @param array $task_item Current or last migration task item.
	 *
	 * @return string
	 */
	private static function format_started_at_info( $task_item ) {
		if ( ! is_array( $task_item ) || empty( $task_item['started_at'] ) ) {
			return '';
		}

		$output = gmdate( 'r', $task_item['started_at'] );

		if ( ! $output ) {
			return '';
		}

		return $output;
	}

	/**
	 * Get formatted data regarding when the migration finished.
	 *
	 * @param array $task_item Current or last migration task item.
	 *
	 * @return string
	 */
	private static function format_finished_at_info( $task_item ) {
		if ( ! is_array( $task_item ) || empty( $task_item['finished_at'] ) ) {
			return '';
		}

		$output = gmdate( 'r', $task_item['finished_at'] );

		if ( ! $output ) {
			return '';
		}

		return $output;
	}

	/**
	 * Get formatted data regarding how long the migration has run for.
	 *
	 * Output format example: 1Y 2M 3D 4h 5m 6s.
	 * Output does not start until a non-zero value is found, going from Year -> Second.
	 * After a value is found, all following units are shown, with zero as appropriate.
	 * E.g. 1h 0m 33s
	 * Adding the intervening/trailing zero values makes it easier to grok, and confirms
	 * that the output is complete.
	 *
	 * @param array $task_item Current or last migration task item.
	 * @param int   $timestamp Unix timestamp for end of migration, or current time.
	 *
	 * @return string
	 */
	private static function format_runtime_info( $task_item, $timestamp ) {
		if ( ! is_array( $task_item ) || empty( $task_item['started_at'] ) || ! is_int( $timestamp ) ) {
			return '???';
		}

		$interval = date_diff(
			date_timestamp_set( new DateTime(), $task_item['started_at'] ),
			date_timestamp_set( new DateTime(), $timestamp )
		);

		return Util::hr_interval( $interval );
	}

	/**
	 * Get formatted data regarding a task item's progress.
	 *
	 * @param array $task_item Current or last migration task item.
	 *
	 * @return string
	 */
	private static function format_progress_info( $task_item ) {
		$processed_bytes = empty( $task_item['total']['processed_bytes'] ) ? 0 : (int) $task_item['total']['processed_bytes'];
		$target_bytes    = empty( $task_item['total']['target_bytes'] ) ? 0 : (int) $task_item['total']['target_bytes'];

		$output = self::format_progress_percent_info( $processed_bytes, $target_bytes );
		$output .= ' (' . self::format_processed_of_target_info( $processed_bytes, $target_bytes ) . ')';

		return $output;
	}

	/**
	 * Get formatted percentage data regarding a task item's progress.
	 *
	 * @param int $processed_bytes Processed bytes.
	 * @param int $target_bytes    Target bytes to be processed.
	 *
	 * @return string
	 */
	private static function format_progress_percent_info( $processed_bytes, $target_bytes ) {
		$processed     = empty( $processed_bytes ) ? 0 : (int) $processed_bytes;
		$target        = empty( $target_bytes ) ? 0 : (int) $target_bytes;
		$progress_pcnt = 0 < $processed && 0 < $target ? round( ( $processed / $target ) * 100, 1 ) : 0;

		return $progress_pcnt . '%';
	}

	/**
	 * Format bytes ready for display as human-readable string.
	 *
	 * @param int $bytes Bytes value to be displayed.
	 *
	 * @return string
	 */
	private static function format_bytes_for_display( $bytes ) {
		$bytes = empty( $bytes ) ? 0 : (int) $bytes;

		return size_format( $bytes, 2 );
	}

	/**
	 * Get formatted processed of target data regarding a task item's progress.
	 *
	 * @param int $processed_bytes Processed bytes.
	 * @param int $target_bytes    Target bytes to be processed.
	 *
	 * @return string
	 */
	private static function format_processed_of_target_info( $processed_bytes, $target_bytes ) {
		$processed_str = self::format_bytes_for_display( $processed_bytes );
		$target_str    = self::format_bytes_for_display( $target_bytes );

		return $processed_str . ' / ' . $target_str;
	}

	/**
	 * Get formatted data regarding a task item's request error.
	 *
	 * The format somewhat mimics what is output in the web UI.
	 *
	 * @param array $error An error extracted from a task item.
	 *
	 * @return string
	 */
	private static function format_error_request( $error ) {
		if ( ! is_array( $error ) ) {
			return '';
		}

		$error_data = [];

		if ( ! empty( $error['data']['url'] ) ) {
			$error_data[] = $error['data']['url'];
		}

		if ( ! empty( $error['data']['method'] ) ) {
			$error_data[] = $error['data']['method'];
		}

		if ( ! empty( $error['data']['request_response']['response']['code'] ) ) {
			$error_data[] = $error['data']['request_response']['response']['code'];
		}

		return join( " | ", $error_data );
	}

	/**
	 * Get formatted data regarding a task item's request error response body.
	 *
	 * The format somewhat mimics what is output in the web UI.
	 *
	 * @param array $error An error extracted from a task item.
	 *
	 * @return string
	 */
	private static function format_error_response( $error ) {
		if (
			is_array( $error ) &&
			! empty( $error['data']['request_response']['body'] ) &&
			is_string( $error['data']['request_response']['body'] )
		) {
			return $error['data']['request_response']['body'];
		}

		return '';
	}

	/**
	 * Create a progress bar to display percent completion of a given operation.
	 *
	 * Progress bar is written to STDOUT, and disabled when command is piped. Progress
	 * advances with `$progress->tick()`, and completes with `$progress->finish()`.
	 *
	 * This function should be used instead of WP_CLI\Utils\make_progress_bar in order
	 * to use our override of cli\progress\Bar which removes the elapsed time and
	 * expected total time indicators from the end of the bar.
	 *
	 * @param string  $message  Text to display before the progress bar.
	 * @param integer $count    Total number of ticks to be performed.
	 * @param int     $interval Optional. The interval in milliseconds between updates. Default 100.
	 *
	 * @return Bar|\WP_CLI\NoOp
	 */
	private static function make_progress_bar( $message, $count, $interval = 100 ) {
		if ( Shell::isPiped() ) {
			return new NoOp();
		}

		return new Bar( $message, $count, $interval );
	}
}
