<?php
/**
 * Home — Hero section.
 *
 * @package HelloElementorChild
 *
 * @var array $args {
 *     @type string $img   Assets/images URL.
 *     @type string $video Assets/videos URL.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$img   = $args['img'];
$video = $args['video'];

$hero_slides = array(
	array(
		'title_html' => 'BUILDING THE<br>FUTURE OF ATTAINABLE<br><span class="rsk-hero__accent">HOUSING</span>',
		'body_html'  => '<strong>RSK Real Estate Partners</strong> develops high-quality residential communities through vertically integrated development, scalable execution, and data-driven market strategy.',
	),
	array(
		'title_html' => 'DESIGNED FOR GROWTH<br><span class="rsk-hero__accent">BUILT FOR SCALE</span>',
		'body_html'  => 'From acquisition to delivery, RSK builds attainable housing communities designed for today&rsquo;s evolving workforce and tomorrow&rsquo;s growing cities.',
	),
	array(
		'title_html' => 'MODERN HOUSING<br><span class="rsk-hero__accent">FOR THE MISSING MIDDLE</span>',
		'body_html'  => 'We create thoughtfully designed housing solutions in high-growth markets through disciplined underwriting, operational efficiency, and institutional-level execution.',
	),
);
?>
<section class="rsk-hero">
	<video
		class="rsk-hero__video"
		autoplay
		muted
		loop
		playsinline
		preload="auto"
		poster="<?php echo esc_url( $img . '/hero-house.jpg' ); ?>"
	>
		<source src="<?php echo esc_url( $video . '/rsk-home.mp4' ); ?>" type="video/mp4">
	</video>
	<div class="rsk-hero__overlay" aria-hidden="true"></div>

	<div class="rsk-hero__inner">
		<div class="rsk-hero__slides" data-rsk-slider>
			<?php foreach ( $hero_slides as $i => $slide ) :
				$is_active = ( 0 === $i );
			?>
			<article
				class="rsk-hero__slide<?php echo $is_active ? ' is-active' : ''; ?>"
				data-slide="<?php echo (int) $i; ?>"
				<?php echo $is_active ? '' : 'aria-hidden="true"'; ?>
			>
				<span class="rsk-hero__vline" aria-hidden="true"></span>

				<div class="rsk-hero__slide-content">
					<h1 class="rsk-hero__title">
						<?php echo $slide['title_html']; ?>
					</h1>

					<div class="rsk-hero__intro">
						<p class="rsk-hero__body">
							<?php echo $slide['body_html']; ?>
						</p>
					</div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

		<nav class="rsk-hero__dots" aria-label="Hero slides">
			<?php foreach ( $hero_slides as $i => $slide ) :
				$is_active = ( 0 === $i );
			?>
			<button
				type="button"
				class="rsk-hero__dot<?php echo $is_active ? ' is-active' : ''; ?>"
				data-go="<?php echo (int) $i; ?>"
				aria-label="<?php echo esc_attr( sprintf( 'Go to slide %d', $i + 1 ) ); ?>"
				aria-current="<?php echo $is_active ? 'true' : 'false'; ?>"
			></button>
			<?php endforeach; ?>
		</nav>
	</div>
</section>
