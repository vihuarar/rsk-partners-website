<?php
/**
 * Hello Elementor Child - RSK Partners
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '1.0.4' );

add_action( 'wp_enqueue_scripts', function () {
	$parent_handle = 'hello-elementor';

	wp_enqueue_style(
		$parent_handle,
		get_template_directory_uri() . '/style.css',
		array(),
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	// Self-hosted brand fonts (site-wide, browser fetches files only when used).
	wp_enqueue_style(
		'rsk-fonts',
		get_stylesheet_directory_uri() . '/assets/css/fonts.css',
		array(),
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	// Tailwind utilities (site-wide). Compiled output — rebuild with `npm run build:css`.
	// Preflight is disabled and all utilities are `tw-`-prefixed to avoid Elementor conflicts.
	$tailwind_path = get_stylesheet_directory() . '/assets/css/tailwind.css';
	if ( file_exists( $tailwind_path ) ) {
		wp_enqueue_style(
			'rsk-tailwind',
			get_stylesheet_directory_uri() . '/assets/css/tailwind.css',
			array(),
			filemtime( $tailwind_path )
		);
	}

	wp_enqueue_style(
		'hello-elementor-child',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_handle, 'rsk-fonts' ),
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'rsk-home',
			get_stylesheet_directory_uri() . '/assets/css/home.css',
			array( 'hello-elementor-child' ),
			HELLO_ELEMENTOR_CHILD_VERSION
		);

		// PhotoSwipe stylesheet (lightbox for product gallery).
		wp_enqueue_style(
			'rsk-photoswipe',
			get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/photoswipe.css',
			array(),
			'5.4.4'
		);

		wp_enqueue_script(
			'rsk-home',
			get_stylesheet_directory_uri() . '/assets/js/home.js',
			array(),
			HELLO_ELEMENTOR_CHILD_VERSION,
			true
		);
	}
}, 20 );

/**
 * PhotoSwipe uses native ES modules. WordPress's default script tags don't
 * declare type="module", so we filter the tag for our home.js when it's on
 * the front page, and also let the browser resolve the two PhotoSwipe imports
 * from the local vendor directory via an import map.
 */
add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
	if ( 'rsk-home' === $handle ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}
	return $tag;
}, 10, 3 );

add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$base = get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/';
	?>
	<script type="importmap">
	{
		"imports": {
			"photoswipe": "<?php echo esc_url( $base . 'photoswipe.esm.js' ); ?>",
			"photoswipe/lightbox": "<?php echo esc_url( $base . 'photoswipe-lightbox.esm.js' ); ?>"
		}
	}
	</script>
	<?php
}, 5 );

/**
 * Force the child theme's front-page.php on the site's front page.
 *
 * Elementor Pro and Hello Elementor's "Elementor Header & Footer" page template
 * both hijack template_include to render Elementor canvas content, which would
 * otherwise replace our custom front-page.php. Running at PHP_INT_MAX ensures
 * this filter wins.
 */
add_filter( 'template_include', function ( $template ) {
	if ( is_front_page() ) {
		$front = get_stylesheet_directory() . '/front-page.php';
		if ( file_exists( $front ) ) {
			return $front;
		}
	}
	return $template;
}, PHP_INT_MAX );
