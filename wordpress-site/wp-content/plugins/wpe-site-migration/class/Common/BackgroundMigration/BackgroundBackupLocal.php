<?php

namespace DeliciousBrains\WPMDB\Common\BackgroundMigration;

class BackgroundBackupLocal extends BackgroundMigration {
	/**
	 * @inheritdoc
	 */
	protected static $type = 'backup_local';

	/**
	 * @inheritDoc
	 */
	protected function get_background_process_class() {
		return new BackgroundBackupLocalProcess( $this );
	}

	/**
	 * @inheritDoc
	 */
	public static function get_type_name() {
		return _x( 'Backup Database', 'Migration type name', 'wp-migrate-db' );
	}
}
