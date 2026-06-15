<?php

namespace DeliciousBrains\WPMDB\Pro\BackgroundMigration;

class BackgroundPush extends BackgroundTransferBase {
	/**
	 * @inheritdoc
	 */
	protected static $type = 'push';

	/**
	 * @inheritDoc
	 */
	protected function get_background_process_class() {
		return new BackgroundPushProcess( $this );
	}

	/**
	 * @inheritDoc
	 */
	public static function get_type_name() {
		return _x( 'Push', 'Migration type name', 'wp-migrate-db' );
	}
}
