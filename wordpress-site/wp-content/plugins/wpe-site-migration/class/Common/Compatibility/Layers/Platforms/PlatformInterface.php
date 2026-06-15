<?php

namespace DeliciousBrains\WPMDB\Common\Compatibility\Layers\Platforms;

interface PlatformInterface {
	public static function get_key();

	public static function is_platform();

	public function filter_platform( $platform );
}
