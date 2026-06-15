<?php

namespace DeliciousBrains\WPMDB\Common\Cli;

/**
 * WP-CLI Bar override class.
 *
 * This is needed in order to remove the timing details from the end of the bar
 * which are widely inaccurate and often leave artifacts when the message length
 * changes during a migration.
 */
class Bar extends \cli\progress\Bar {
	// phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore
	protected $_formatTiming = ']';

	/**
	 * Finish our Notification display. Should be called after the Notifier is
	 * no longer needed.
	 *
	 * Override to keep same interface as the other subclass of Notify that
	 * we have, Dots.
	 *
	 * @param bool $successful Was the monitored task completed? Default true. Currently unused.
	 */
	public function finish( $successful = true ) {
		parent::finish();
	}
}
