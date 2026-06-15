<?php

namespace DeliciousBrains\WPMDB\Common\BackgroundMigration;

class BackgroundSaveFile extends BackgroundMigration {
	/**
	 * @inheritdoc
	 */
	protected static $type = 'savefile';

	/**
	 * @inheritDoc
	 */
	protected function get_background_process_class() {
		return new BackgroundSaveFileProcess( $this );
	}

	/**
	 * @inheritDoc
	 */
	public static function get_type_name() {
		return _x( 'Export', 'Migration type name', 'wp-migrate-db' );
	}
}
