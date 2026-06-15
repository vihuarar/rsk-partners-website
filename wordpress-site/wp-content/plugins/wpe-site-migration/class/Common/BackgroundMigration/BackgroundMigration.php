<?php

namespace DeliciousBrains\WPMDB\Common\BackgroundMigration;

use DeliciousBrains\WPMDB\Common\Error\ErrorLog;
use DeliciousBrains\WPMDB\Common\MigrationState\Migrations\CurrentMigrationState;
use DeliciousBrains\WPMDB\Common\MigrationState\StateFactory;
use DeliciousBrains\WPMDB\Common\Util\Util;
use DeliciousBrains\WPMDB\Data\Stage;

/**
 * Background Migration
 *
 * Base class for registered migrations.
 */
abstract class BackgroundMigration {
	const INITIALIZATION_PHASE = 'initialization';
	const PROCESSING_PHASE     = 'processing';

	/**
	 * Type (intent) of the subclass.
	 *
	 * Must be overridden by each subclass.
	 *
	 * @var string
	 */
	protected static $type = 'background-migration';

	/**
	 * Holds the background migration process that performs the tasks.
	 *
	 * @var BackgroundMigrationProcess
	 */
	protected $background_process;

	/**
	 * The error log, accessible to background process.
	 *
	 * @var ErrorLog
	 */
	public $error_log;

	/**
	 * Current migration state.
	 *
	 * @var CurrentMigrationState
	 */
	private $current_migration_state;

	/**
	 * Instantiate a Background Migration.
	 *
	 * @param ErrorLog $error_log
	 */
	public function __construct(
		ErrorLog $error_log
	) {
		$this->error_log          = $error_log;
		$this->background_process = $this->get_background_process_class();

		add_filter(
			'wpmdb_register_background_migrations',
			[ $this, 'filter_register_background_migrations' ]
		);
	}

	/**
	 * Get the type (intent) of the migration.
	 *
	 * @return string
	 */
	public static function get_type() {
		return static::$type;
	}

	/**
	 * Register this background migration.
	 *
	 * @param BackgroundMigration[] $migrations
	 *
	 * @return BackgroundMigration[]
	 */
	public function filter_register_background_migrations( $migrations ) {
		$migrations[ static::get_type() ] = $this;

		return $migrations;
	}

	/**
	 * Is the background migration active?
	 *
	 * @return bool
	 */
	public function is_active() {
		return $this->background_process->is_active();
	}

	/**
	 * Is the background migration paused?
	 *
	 * @return bool
	 */
	public function is_paused() {
		return $this->background_process->is_paused();
	}

	/**
	 * Is the background migration cancelled?
	 *
	 * @return bool
	 */
	public function is_cancelled() {
		return $this->background_process->is_cancelled();
	}

	/**
	 * Is the background migration processing?
	 *
	 * @return bool
	 */
	public function is_processing() {
		return $this->background_process->is_processing();
	}

	/**
	 * Start a background migration.
	 *
	 * @return void
	 *
	 * Note: Dynamically called by `\DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigrationManager::perform_action()`.
	 */
	public function handle_start() {
		if ( $this->is_active() ) {
			return;
		}

		$migration_state = $this->get_current_migration_state();
		$migration_state->update_state( [ 'started_at' => time() ] );

		do_action( 'wpmdb_migration_starting', $this->get_current_migration_state()->get( 'migration_id' ) );

		$task = $this->create_task();

		$this->background_process->push_to_queue( $task )->save()->dispatch();

		do_action( 'wpmdb_migration_started', $this->get_current_migration_state()->get( 'migration_id' ) );
	}

	/**
	 * Cancel a background migration.
	 *
	 * @return void
	 *
	 * Note: Dynamically called by `\DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigrationManager::perform_action()`.
	 */
	public function handle_cancel() {
		if ( ! $this->is_active() || $this->background_process->is_cancelled() ) {
			return;
		}

		$this->background_process->cancel();

		do_action( 'wpmdb_track_migration_cancel' );
	}

	/**
	 * Toggle pause or resume a background migration.
	 *
	 * @return void
	 *
	 * Note: Dynamically called by `\DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigrationManager::perform_action()`.
	 */
	public function handle_pause_resume() {
		if ( ! $this->is_active() || $this->background_process->is_cancelled() ) {
			return;
		}

		if ( $this->background_process->is_paused() ) {
			$this->background_process->resume();
		} else {
			$this->background_process->pause();
		}
	}

	/**
	 * Create initial migration state and set up batch item that references it.
	 *
	 * @return array
	 */
	protected function create_task() {
		// Initial progress and target total bytes elements for grand total.
		$task = array(
			'started_by'  => get_current_user_id(),
			'started_at'  => time(),
			'initialized' => false,
			'total'       => array(
				'processed_bytes' => 0,
				'target_bytes'    => 0,
			),
		);

		// Associate current migration state with task item via migration_id.
		$migration_id = $this->current_migration_state->get( 'migration_id' );

		if ( empty( $migration_id ) ) {
			// Should never happen, but task will bail when it hits an empty array.
			return array();
		}

		$task['migration_id'] = $migration_id;

		// Add initial progress and target total bytes elements for each stage.
		foreach ( $this->current_migration_state->get( 'stages' ) as $stage ) {
			$task['stages'][] = array(
				'stage'       => $stage,
				'initialized' => false,
				'processed'   => false,
				'total'       => array(
					'processed_bytes' => 0,
					'target_bytes'    => 0,
				),
			);
		}

		return $task;
	}

	/**
	 * Get information about the migration.
	 *
	 * @return array
	 */
	public function get_info() {
		return [
			// TODO: Could add translatable text entries for name, status text etc coming from abstract/overridden functions.
			'type'          => static::get_type(),
			'is_active'     => $this->background_process->is_active(),
			'is_queued'     => $this->background_process->is_queued(),
			'is_processing' => $this->background_process->is_processing(),
			'is_paused'     => $this->background_process->is_paused(),
			'is_cancelled'  => $this->background_process->is_cancelled(),
			'current_task'  => $this->background_process->get_current_task(),
		];
	}

	/**
	 * Set current migration state from Migration ID.
	 *
	 * @param string $migration_id
	 *
	 * @return bool
	 */
	public function set_current_migration_state( $migration_id ) {
		$state                         = StateFactory::create( 'current_migration' );
		$this->current_migration_state = $state->load_state( $migration_id );

		// Is loaded state different from skeleton initial migration state?
		return ! empty( Util::array_diff_assoc_recursive(
			$this->current_migration_state->get_state(),
			$state->get_initial_state()
		) );
	}

	/**
	 * Get the migration's current state.
	 *
	 * @return CurrentMigrationState
	 */
	public function get_current_migration_state() {
		return $this->current_migration_state;
	}

	/**
	 * Refresh the BackgroundMigrationProcess's lock.
	 *
	 * @return void
	 */
	public function refresh_process_lock() {
		$this->background_process->lock_process( false );
	}

	/**
	 * Should any processing continue?
	 *
	 * @return bool
	 */
	public function should_continue() {
		return $this->background_process->should_continue();
	}

	/**
	 * Delete entire job queue.
	 *
	 * @return void
	 */
	public function delete() {
		$this->background_process->delete_all();
	}

	/**
	 * Get the string used to identify this migration type's background process.
	 *
	 * @return string
	 */
	public function get_background_process_identifier() {
		return $this->background_process->get_identifier();
	}

	/**
	 * Get the phase that the migration is currently on.
	 *
	 * @param array $task_item Task item data.
	 *
	 * @return string
	 */
	public static function get_current_phase( $task_item ) {
		if ( ! is_array( $task_item ) || empty( $task_item['initialized'] ) ) {
			return self::INITIALIZATION_PHASE;
		}

		return self::PROCESSING_PHASE;
	}

	/**
	 * Get the translatable name for the current migration phase.
	 *
	 * @param string $phase Current phase, initialization or processing.
	 *
	 * @return string
	 */
	public static function get_current_phase_name( $phase ) {
		if ( self::PROCESSING_PHASE === $phase ) {
			return _x( 'Processing', 'Migration phase', 'wp-migrate-db' );
		} else {
			return _x( 'Initializing', 'Migration phase', 'wp-migrate-db' );
		}
	}

	/**
	 * Get integer array element index for the stage that is currently initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return int|false
	 */
	public static function get_current_stage_idx( $item ) {
		if ( empty( $item ) || ! is_array( $item ) || empty( $item['stages'] ) ) {
			return false;
		}

		$complete_key = empty( $item['initialized'] ) ? 'initialized' : 'processed';

		foreach ( $item['stages'] as $idx => $stage ) {
			if ( empty( $stage[ $complete_key ] ) && ! empty( $stage['stage'] ) ) {
				return $idx;
			}
		}

		// All done, return last stage's index.
		return isset( $idx ) ? $idx : false;
	}

	/**
	 * Get the key name for the stage that is currently initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_current_stage( $item ) {
		$stage_idx = self::get_current_stage_idx( $item );

		if ( false !== $stage_idx && ! empty( $item['stages'][ $stage_idx ]['stage'] ) ) {
			return $item['stages'][ $stage_idx ]['stage'];
		}

		return '';
	}

	/**
	 * Get the name for the stage that is currently initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_current_stage_name( $item ) {
		return Stage::title( self::get_current_stage( $item ) );
	}

	/**
	 * Pluck a single stage's stats out of a task item by its key name.
	 *
	 * @param array  $item  Task item.
	 * @param string $stage Stage key name.
	 *
	 * @return false|array
	 */
	public static function get_stage_stats( $item, $stage ) {
		if ( empty( $item ) || ! is_array( $item ) || empty( $item['stages'] ) ) {
			return false;
		}

		foreach ( $item['stages'] as $stage_stats ) {
			if ( ! empty( $stage_stats['stage'] ) && $stage_stats['stage'] === $stage ) {
				return $stage_stats;
			}
		}

		return false;
	}

	/**
	 * Get the key name for the phase that was last active.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_last_phase( $item ) {
		return ! empty( $item['processed'] ) ? self::PROCESSING_PHASE : self::INITIALIZATION_PHASE;
	}

	/**
	 * Get the name for the phase that was last active.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_last_phase_name( $item ) {
		return self::get_current_phase_name( self::get_last_phase( $item ) );
	}

	/**
	 * Get integer array element index for the stage that was last initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return int|false
	 */
	public static function get_last_stage_idx( $item ) {
		if ( empty( $item ) || ! is_array( $item ) || empty( $item['stages'] ) ) {
			return false;
		}

		$complete_key = empty( $item['initialized'] ) ? 'initialized' : 'processed';

		foreach ( array_reverse( $item['stages'], true ) as $idx => $stage ) {
			if ( ! empty( $stage[ $complete_key ] ) && ! empty( $stage['stage'] ) ) {
				return $idx;
			}
		}

		// If all stages completed, get last stage's index.
		// Should never happen during initialization, but if it does, signifies
		// that initialization completed but failed to set flag for some reason.
		return count( $item['stages'] ) - 1;
	}

	/**
	 * Get the key name for the stage that was last initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_last_stage( $item ) {
		$stage_idx = self::get_last_stage_idx( $item );

		if ( false !== $stage_idx && ! empty( $item['stages'][ $stage_idx ]['stage'] ) ) {
			return $item['stages'][ $stage_idx ]['stage'];
		}

		return '';
	}

	/**
	 * Get the name for the stage that was last initializing or processing.
	 *
	 * @param array $item Task item.
	 *
	 * @return string
	 */
	public static function get_last_stage_name( $item ) {
		return Stage::title( self::get_last_stage( $item ) );
	}

	/**
	 * Get the activity status that the migration is currently in.
	 *
	 * @return string
	 */
	public function get_activity_status() {
		// This should be an impossible state, but just in case!
		if ( ! $this->is_active() ) {
			return 'inactive';
		}

		if ( $this->is_paused() ) {
			if ( $this->is_processing() ) {
				return 'pausing';
			}

			return 'paused';
		}

		if ( $this->is_cancelled() ) {
			if ( $this->is_processing() ) {
				return 'cancelling';
			}

			return 'cancelled';
		}

		return 'active';
	}

	/**
	 * Get the translatable name for the current migration activity status.
	 *
	 * @param string $activity_status Whether pausing, paused, resuming, cancelling etc.
	 *
	 * @return string
	 */
	public static function get_activity_status_name( $activity_status ) {
		switch ( $activity_status ) {
			case 'active':
				$name = _x( 'Active', 'Activity status', 'wp-migrate-db' );
				break;
			case 'pausing':
				$name = _x( 'Pausing...', 'Activity status', 'wp-migrate-db' );
				break;
			case 'paused':
				$name = _x( 'Paused', 'Activity status', 'wp-migrate-db' );
				break;
			case 'resuming':
				$name = _x( 'Resuming...', 'Activity status', 'wp-migrate-db' );
				break;
			case 'cancelling':
				$name = _x( 'Cancelling...', 'Activity status', 'wp-migrate-db' );
				break;
			case 'cancelled':
				$name = _x( 'Cancelled', 'Activity status', 'wp-migrate-db' );
				break;
			default:
				$name = _x( 'Inactive', 'Activity status', 'wp-migrate-db' );
		}

		return $name;
	}

	/**
	 * Get background process class.
	 *
	 * @return BackgroundMigrationProcess|null
	 */
	abstract protected function get_background_process_class();

	/**
	 * Get the migration type's translated name.
	 *
	 * @return string
	 */
	public static function get_type_name() {
		return _x( 'Unknown', 'Migration type name', 'wp-migrate-db' );
	}

	/**
	 * Get a string that describes the stage in the context of the phase and the type of migration.
	 *
	 * @param string $phase Phase name, a.k.a. key.
	 * @param string $stage Stage name, a.k.a. key.
	 *
	 * @return string
	 */
	public function get_stage_desc( $phase, $stage ) {
		if ( self::INITIALIZATION_PHASE === $phase && Stage::BACKUP === $stage ) {
			return _x(
				'Scanning Database Tables to Backup',
				'Stage description during initialization phase',
				'wp-migrate-db'
			);
		}

		if ( self::PROCESSING_PHASE === $phase ) {
			switch ( $stage ) {
				case Stage::BACKUP:
					return _x(
						'Creating Backup of Database Tables',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
				case Stage::FINALIZE:
					return _x( 'Finalizing', 'Stage description during processing phase', 'wp-migrate-db' );
			}
		}

		return self::get_current_phase_name( $phase ) . ' ' . Stage::title( $stage );
	}
}
