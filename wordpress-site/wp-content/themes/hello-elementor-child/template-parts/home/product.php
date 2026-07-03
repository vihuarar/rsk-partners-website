<?php
/**
 * Home — Product section.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$img = $args['img'];

$product_gallery = array(
	'product-gallery-1.jpg',
	'product-gallery-2.jpg',
	'product-gallery-3.jpg',
	'product-gallery-4.jpg',
	'product-gallery-5.jpg',
);

$product_cols = array(
	array(
		'num'  => '01',
		'body' => 'Great housing creates better outcomes for everyone involved. Our communities incorporate features and finishes typically found in higher-priced developments while maintaining disciplined construction costs.',
	),
	array(
		'num'  => '02',
		'body' => 'This approach results in higher rents, faster lease-up, lower turnover, lower concessions, and stronger resident satisfaction across every market we build in.',
	),
	array(
		'num'  => '03',
		'body' => 'By designing around how people actually live, we create communities that outperform both operationally and financially — for residents and investors alike.',
	),
);
?>
<section class="rsk-product tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-hidden tw-bg-[#c9c5be]" data-rsk-reveal>
	<div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-[27%_46%_27%] tw-items-stretch md:tw-aspect-[16/5.5]">

		<!-- Left image -->
		<figure class="rsk-reveal rsk-reveal--slide-left tw-relative tw-m-0 tw-h-full tw-min-h-[60vw] md:tw-min-h-0">
			<img
				src="<?php echo esc_url( $img . '/product-interior-1.jpg' ); ?>"
				alt=""
				class="!tw-absolute tw-inset-0 !tw-w-full !tw-h-full tw-object-cover !tw-max-w-none"
				loading="lazy"
			>
			<!-- Slider dots -->
			<div class="tw-absolute tw-bottom-4 tw-left-4 tw-flex tw-gap-2 tw-z-10" aria-hidden="true">
				<span class="tw-block tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-white"></span>
				<span class="tw-block tw-w-1.5 tw-h-1.5 tw-rounded-full tw-border tw-border-white/80 tw-bg-transparent"></span>
			</div>
		</figure>

		<!-- Navy panel -->
		<div class="tw-relative tw-bg-[#0b1523] tw-text-white tw-flex tw-flex-col tw-px-[clamp(1.5rem,3vw,3rem)] tw-pt-[clamp(1rem,2vw,1.75rem)] tw-pb-[clamp(1.5rem,3vw,2.25rem)]">

			<p class="tw-m-0 tw-font-sans tw-text-[0.55rem] tw-font-medium tw-tracking-[0.3em] tw-uppercase tw-text-white/40 tw-text-right">RSK REAL ESTATE PARTNERS</p>

			<h2 class="rsk-reveal rsk-reveal--rise tw-font-serif tw-font-normal tw-text-[clamp(3rem,6.5vw,6rem)] tw-leading-none tw-tracking-tight tw-text-white tw-text-center tw-mt-[clamp(0.5rem,1.5vw,1.5rem)] tw-mb-[clamp(1rem,2vw,1.5rem)]" style="--rsk-reveal-delay:80ms">
				PRODUCT
			</h2>

			<div class="rsk-reveal rsk-reveal--fade tw-h-px tw-bg-white/20 tw-mb-[clamp(1rem,2vw,1.5rem)]" aria-hidden="true" style="--rsk-reveal-delay:200ms"></div>

			<div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-3 tw-gap-x-[clamp(1rem,2vw,2rem)] tw-gap-y-6">
				<?php foreach ( $product_cols as $i => $col ) : ?>
				<div class="rsk-reveal rsk-reveal--fade" style="--rsk-reveal-delay:<?php echo 260 + $i * 80; ?>ms">
					<p class="tw-m-0 tw-mb-2 tw-font-serif tw-italic tw-text-[clamp(1.15rem,1.5vw,1.6rem)] tw-leading-none tw-text-white/45">
						<?php echo esc_html( $col['num'] ); ?>/
					</p>
					<p class="tw-m-0 tw-font-sans tw-text-[clamp(0.7rem,0.85vw,0.85rem)] tw-leading-relaxed tw-text-white/80">
						<?php echo esc_html( $col['body'] ); ?>
					</p>
				</div>
				<?php endforeach; ?>
			</div>

			<!-- Gallery strip -->
			<ul class="rsk-reveal rsk-reveal--fade tw-mt-auto tw-pt-[clamp(1.25rem,2.5vw,2rem)] tw-list-none tw-p-0 tw-m-0 tw-grid tw-grid-cols-5 tw-gap-[clamp(0.35rem,0.6vw,0.65rem)]" aria-label="Product gallery" style="--rsk-reveal-delay:480ms">
				<?php foreach ( $product_gallery as $g ) : ?>
				<li class="tw-m-0">
					<a
						href="<?php echo esc_url( $img . '/' . $g ); ?>"
						class="tw-block tw-relative tw-overflow-hidden tw-aspect-[4/3] tw-ring-1 tw-ring-white/10 tw-transition tw-duration-500 hover:tw-ring-white/60 focus-visible:tw-outline focus-visible:tw-outline-2 focus-visible:tw-outline-white"
						target="_blank"
						rel="noopener"
					>
						<img
							src="<?php echo esc_url( $img . '/' . $g ); ?>"
							alt=""
							loading="lazy"
							class="!tw-absolute tw-inset-0 !tw-w-full !tw-h-full !tw-max-w-none tw-object-cover tw-transition-transform tw-duration-700 hover:tw-scale-110"
						>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- Right image -->
		<figure class="rsk-reveal rsk-reveal--slide-right tw-relative tw-m-0 tw-h-full tw-min-h-[60vw] md:tw-min-h-0" style="--rsk-reveal-delay:100ms">
			<img
				src="<?php echo esc_url( $img . '/product-interior-2.jpg' ); ?>"
				alt=""
				class="!tw-absolute tw-inset-0 !tw-w-full !tw-h-full tw-object-cover !tw-max-w-none"
				loading="lazy"
			>
		</figure>

	</div>
</section>
