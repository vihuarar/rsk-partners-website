<?php

namespace DeliciousBrains\WPMDB\Pro\BackgroundMigration;

use DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigration;
use DeliciousBrains\WPMDB\Data\Stage;

abstract class BackgroundTransferBase extends BackgroundMigration {
	/**
	 * Get a string that describes the stage in the context of the phase and the type of migration.
	 *
	 * @param string $phase Phase name, a.k.a. key.
	 * @param string $stage Stage name, a.k.a. key.
	 *
	 * @return string
	 */
	public function get_stage_desc( $phase, $stage ) {
		if ( self::INITIALIZATION_PHASE === $phase ) {
			switch ( $stage ) {
				case Stage::TABLES:
					return _x(
						'Scanning Database Tables to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::MEDIA_FILES:
					return _x(
						'Scanning Media Uploads to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::THEME_FILES:
					return _x(
						'Scanning Themes to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::PLUGIN_FILES:
					return _x(
						'Scanning Plugins to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::MUPLUGIN_FILES:
					return _x(
						'Scanning MU-Plugins to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::OTHER_FILES:
					return _x(
						'Scanning Other Files to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
				case Stage::ROOT_FILES:
					return _x(
						'Scanning Root Files to Transfer',
						'Stage description during initialization phase',
						'wp-migrate-db'
					);
			}
		}

		if ( self::PROCESSING_PHASE === $phase ) {
			switch ( $stage ) {
				case Stage::TABLES:
					return _x(
						'Transferring Database Tables',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
				case Stage::MEDIA_FILES:
					return _x(
						'Transferring Media Uploads',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
				case Stage::THEME_FILES:
					return _x( 'Transferring Themes', 'Stage description during processing phase', 'wp-migrate-db' );
				case Stage::PLUGIN_FILES:
					return _x( 'Transferring Plugins', 'Stage description during processing phase', 'wp-migrate-db' );
				case Stage::MUPLUGIN_FILES:
					return _x(
						'Transferring MU-Plugins',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
				case Stage::OTHER_FILES:
					return _x(
						'Transferring Other Files',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
				case Stage::ROOT_FILES:
					return _x(
						'Transferring Root Files',
						'Stage description during processing phase',
						'wp-migrate-db'
					);
			}
		}

		return parent::get_stage_desc( $phase, $stage );
	}
}
