<?php

namespace DeliciousBrains\WPMDB\Common\BackgroundMigration;

class BackgroundFindReplace extends BackgroundMigration {
	/**
	 * @inheritdoc
	 */
	protected static $type = 'find_replace';

	/**
	 * @inheritDoc
	 */
	protected function get_background_process_class() {
		return new BackgroundFindReplaceProcess( $this );
	}

	/**
	 * @inheritDoc
	 */
	public static function get_type_name() {
		return _x( 'Find & Replace', 'Migration type name', 'wp-migrate-db' );
	}
}
