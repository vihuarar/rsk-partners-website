<?php
/**
 * Front Page template — RSK Partners.
 *
 * Loads only on the site's front page (Settings → Reading → Static Page).
 * Sections live in template-parts/home/*.php — edit those to change content
 * or styling for a specific section without touching this orchestrator.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$assets = array(
	'img'   => get_stylesheet_directory_uri() . '/assets/images',
	'video' => get_stylesheet_directory_uri() . '/assets/videos',
);
?>

<main id="rsk-home" class="rsk-home">

	<?php
	$sections = array(
		'hero',
		'who-we-are',
		'what-we-do',
		'product',
		'initiative-555',
		'markets',
		'contact',
	);

	foreach ( $sections as $section ) {
		get_template_part( 'template-parts/home/' . $section, null, $assets );
	}
	?>

</main>

<?php
get_footer();
