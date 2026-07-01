<?php
/**
 * Home — What We Do section.
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

$what_paragraphs = array(
	'<strong class="tw-font-semibold">RSK</strong> develops modern residential communities tailored to the growing demand for attainable housing.',
	'By integrating development, construction oversight, operational systems, and market strategy under one platform, we are able to streamline execution, control costs, and accelerate delivery timelines without compromising quality.',
	'We focus on high-growth markets where affordability challenges, population growth, and economic expansion continue to drive long-term housing demand.',
);
$what_products = array(
	array(
		'type'    => 'image',
		'src'     => 'external-facade-first-image-what-we-do.png',
		'caption' => 'Single Family Homes',
	),
	array(
		'type'    => 'video',
		'src'     => 'facade-white-whose-portrait.mp4',
		'poster'  => 'external-facade-first-image-what-we-do.png',
		'caption' => 'Duplexes',
	),
	array(
		'type'    => 'image',
		'src'     => 'external-facade-third-image-what-we-do.png',
		'caption' => 'Townhomes',
	),
);
?>
<section class="tw-bg-[#ebe8e3] tw-py-[clamp(3rem,7vw,6rem)] tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-x-hidden">
	<div class="tw-max-w-rsk tw-mx-auto tw-px-[clamp(1rem,3vw,2rem)]">
		<div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-[minmax(0,1fr)_3fr] tw-gap-x-0 tw-gap-y-[clamp(2rem,4vw,3rem)] tw-items-start">

			<h2 class="tw-font-serif tw-text-[clamp(3rem,7.5vw,6rem)] tw-leading-[0.95] tw-text-rsk-blue tw-font-normal tw-m-0 tw-tracking-tight tw-relative tw-z-0">
				<span class="tw-block">WHAT</span>
				<span class="tw-block tw-ml-[clamp(1.5rem,5vw,4rem)] lg:tw-ml-[clamp(4rem,9vw,8rem)]">WE&nbsp;DO</span>
			</h2>

			<div class="tw-relative tw-z-10 tw-grid tw-grid-cols-1 sm:tw-grid-cols-[2fr_3fr] tw-gap-x-8 tw-gap-y-4 lg:tw-pl-6 tw-items-start">
				<p class="tw-m-0 tw-text-rsk-ink tw-font-sans tw-text-[0.95rem] tw-leading-relaxed">
					<?php echo $what_paragraphs[0]; ?>
				</p>
				<div class="tw-flex tw-flex-col tw-gap-4 tw-text-rsk-ink tw-font-sans tw-text-[0.95rem] tw-leading-relaxed">
					<p class="tw-m-0"><?php echo $what_paragraphs[1]; ?></p>
					<p class="tw-m-0"><?php echo $what_paragraphs[2]; ?></p>
				</div>
			</div>

			<div class="tw-relative tw-w-full tw-bg-black tw-text-white tw-flex tw-items-center lg:tw-self-center tw-px-[clamp(1.25rem,2.5vw,2rem)] tw-py-[clamp(1.25rem,2vw,1.75rem)] lg:before:tw-content-[''] lg:before:tw-absolute lg:before:tw-inset-y-0 lg:before:tw-right-full lg:before:tw-w-screen lg:before:tw-bg-black">
				<p class="tw-relative tw-m-0 tw-font-sans tw-font-normal tw-text-left tw-leading-[1.15] tw-text-[clamp(1.35rem,2vw,1.875rem)]">
					Our platform<br>specializes in:
				</p>
			</div>

			<div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-3 tw-gap-x-3 tw-gap-y-6">
				<?php foreach ( $what_products as $p ) : ?>
					<figure class="tw-m-0">
						<?php if ( 'video' === $p['type'] ) : ?>
							<video
								class="tw-w-full tw-aspect-[4/5] tw-object-cover tw-block tw-rounded-lg"
								autoplay muted loop playsinline preload="auto"
								poster="<?php echo esc_url( $img . '/' . $p['poster'] ); ?>"
								aria-label="<?php echo esc_attr( $p['caption'] ); ?>"
							>
								<source src="<?php echo esc_url( $video . '/' . $p['src'] ); ?>" type="video/mp4">
							</video>
						<?php else : ?>
							<img
								class="tw-w-full tw-aspect-[4/5] tw-object-cover tw-block tw-rounded-lg"
								src="<?php echo esc_url( $img . '/' . $p['src'] ); ?>"
								alt="<?php echo esc_attr( $p['caption'] ); ?>"
							>
						<?php endif; ?>
						<figcaption class="tw-pt-3 tw-text-center tw-text-sm tw-text-rsk-ink-soft tw-font-sans">
							<?php echo esc_html( $p['caption'] ); ?>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>
