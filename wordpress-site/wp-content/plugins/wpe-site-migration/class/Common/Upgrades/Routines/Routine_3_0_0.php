<?php

namespace DeliciousBrains\WPMDB\Common\Upgrades\Routines;

use DeliciousBrains\WPMDB\Common\BackgroundMigration\BackgroundMigrationManager;

/**
 * Class Routine_3_0_0
 *
 * @since 3.0.0
 */
class Routine_3_0_0 implements RoutineInterface {
	public function apply( &$profile ) {
		global $wpdb;

		// last_migration has moved from usermeta to options/sitemeta,
		// so we can clean up any last_migration records from usermeta.
		$identifier = BackgroundMigrationManager::LAST_MIGRATION_IDENTIFIER;
		$sql        = $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_key=%s", $identifier );

		$wpdb->query( $sql );
	}

	public function get_target_schema_version() {
		return "3.9.0";
	}
}
