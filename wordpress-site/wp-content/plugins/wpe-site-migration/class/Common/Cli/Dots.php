<?php

namespace DeliciousBrains\WPMDB\Common\Cli;

use cli\Notify;

/**
 * WP-CLI Dots override class.
 *
 * This is needed in order to remove the timing details from the end of the dots
 * which are widely inaccurate and often leave artifacts when the message length
 * changes during a migration.
 */
class Dots extends \cli\notify\Dots {
	// phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore
	protected $_format = '{:msg} {:dots}';

	/**
	 * Finish our Notification display. Should be called after the Notifier is
	 * no longer needed.
	 *
	 * @param bool $successful Was the monitored task completed? Default true.
	 *
	 * @see cli\Notify::display()
	 */
	public function finish( $successful = true ) {
		// So we don't have to re-invent the wheel, save out the format,
		// append our done message to the format that the parent will use for
		// streaming out to STDOUT, and then swap back in the default format
		// in case instance is re-used after reset.
		$default_format = $this->_format;

		if ( $successful ) {
			$this->_format = $default_format . ' ' . _x(
					'Complete',
					'Appended to CLI Dots on finish',
					'wp-migrate-db'
				);
		}

		parent::finish();

		$this->_format = $default_format;
	}

	/**
	 * This method augments the base definition from cli\Notify to optionally
	 * allow passing a new message.
	 *
	 * @param int    $increment The amount to increment by.
	 * @param string $msg       The text to display next to the Notifier. (optional)
	 *
	 * @see cli\Notify::tick()
	 */
	public function tick( $increment = 1, $msg = null ) {
		if ( $msg ) {
			$this->_message = $msg;
		}

		Notify::tick( $increment );
	}
}
