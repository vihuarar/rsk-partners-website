<?php
/**
 * Home — Contact section.
 *
 * @package HelloElementorChild
 *
 * @var array $args {
 *     @type string $img Assets/images URL.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$img = $args['img'];
?>
<section class="rsk-section rsk-contact">
	<div class="rsk-container rsk-grid rsk-grid--2">
		<div class="rsk-contact__copy">
			<h2>Contact</h2>
			<h3 class="rsk-italic">Work With Us</h3>
			<p>
				Investors, partners, and operators — reach out to explore
				opportunities with RSK Partners.
			</p>
			<a href="/contact" class="rsk-btn">Get in touch</a>
		</div>
		<div class="rsk-contact__media">
			<img src="<?php echo esc_url( $img . '/contact-house.jpg' ); ?>" alt="">
		</div>
	</div>
</section>
