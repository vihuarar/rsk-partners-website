<?php

namespace DeliciousBrains\WPMDB\Common\Compatibility\Layers\Platforms;

class Autoscale extends AbstractPlatform {
	/**
	 * @var string
	 */
	protected static $key = 'autoscale';

	public function __construct() {
		parent::__construct();
		add_filter( 'wpmdb_is_muplugin_externally_managed', [ $this, 'filter_is_muplugin_externally_managed' ] );
	}

	/**
	 * Are we running on this platform?
	 *
	 * @return bool
	 */
	public static function is_platform() {
		$is_platform = defined( 'WPE_PLATFORM_NAME' ) && 'autoscale' === strtolower( (string) WPE_PLATFORM_NAME );

		return apply_filters( 'wpmdb_is_platform_autoscale', $is_platform );
	}

	/**
	 * Filters the current platform key.
	 *
	 * @param string $platform
	 *
	 * @return string
	 */
	public function filter_platform( $platform ) {
		if ( static::is_platform() ) {
			return static::get_key();
		}

		return $platform;
	}

	/**
	 * Filter whether the mu-plugin is externally managed.
	 *
	 * Autoscale pre-installs the compatibility mu-plugin on a read-only filesystem.
	 *
	 * @param bool $is_managed
	 *
	 * @return bool
	 */
	public function filter_is_muplugin_externally_managed( $is_managed ) {
		if ( static::is_platform() ) {
			return true;
		}

		return $is_managed;
	}
}
