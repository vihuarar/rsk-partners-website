<?php
/**
 * Home — Product section.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_cols = array(
	array(
		'num'  => '01',
		'body' => "RSK's product strategy is centered around delivering thoughtfully designed housing that balances quality, functionality, durability, and affordability.",
	),
	array(
		'num'  => '02',
		'body' => "Our communities are intentionally designed to meet the evolving needs of middle-income residents seeking attainable ownership and rental opportunities in rapidly growing markets.",
	),
	array(
		'num'  => '03',
		'body' => "Through scalable construction systems, disciplined procurement strategies, and operational efficiency, we deliver housing that performs both financially and functionally.",
	),
);
?>
<section class="tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-x-hidden">
	<div class="tw-flex tw-flex-col md:tw-flex-row tw-min-h-[85vh]">

		<div class="tw-relative tw-flex-none tw-w-full md:tw-w-[46%] tw-min-h-[65vw] md:tw-min-h-0 tw-bg-[#c9c5be]">
			<div class="tw-absolute tw-bottom-6 tw-left-1/2 -tw-translate-x-1/2 tw-flex tw-gap-3" aria-hidden="true">
				<span class="tw-block tw-w-2 tw-h-2 tw-rounded-full tw-border tw-border-white/80 tw-bg-white"></span>
				<span class="tw-block tw-w-2 tw-h-2 tw-rounded-full tw-border tw-border-white/80 tw-bg-transparent"></span>
			</div>
		</div>

		<div class="tw-flex-1 tw-flex tw-flex-col">

			<div class="tw-flex-1 tw-bg-[#0b1523] tw-text-white tw-flex tw-flex-col tw-px-[clamp(2rem,5vw,5rem)] tw-pt-[clamp(1.5rem,3vw,2.5rem)] tw-pb-[clamp(1.5rem,3vw,2rem)]">

				<p class="tw-m-0 tw-font-sans tw-text-[0.62rem] tw-font-medium tw-tracking-[0.3em] tw-uppercase tw-text-white/35 tw-text-right">RSK REAL ESTATE PARTNERS</p>

				<h2 class="tw-font-serif tw-font-normal tw-text-[clamp(4rem,8.5vw,7.5rem)] tw-leading-none tw-tracking-tight tw-text-white tw-text-center tw-mt-auto tw-mb-[clamp(1.25rem,2.5vw,2rem)]">
					PRODUCT
				</h2>

				<div class="tw-h-px tw-bg-white/15 tw-mb-[clamp(1.5rem,3vw,2rem)]" aria-hidden="true"></div>

				<div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-3 tw-gap-x-[clamp(1.5rem,3vw,2.5rem)] tw-gap-y-8">
					<?php foreach ( $product_cols as $col ) : ?>
					<div>
						<p class="tw-m-0 tw-mb-3 tw-font-serif tw-italic tw-text-[1.75rem] tw-leading-none tw-text-white/50">
							<?php echo esc_html( $col['num'] ); ?>/
						</p>
						<p class="tw-m-0 tw-font-sans tw-text-[0.85rem] tw-leading-relaxed tw-text-white/75">
							<?php echo esc_html( $col['body'] ); ?>
						</p>
					</div>
					<?php endforeach; ?>
				</div>

			</div>

			<div class="tw-flex-none tw-min-h-[28vh] tw-bg-[#b8b4ad]"></div>

		</div>
	</div>
</section>
