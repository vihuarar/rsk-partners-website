<?php
/**
 * Home — 5|5|5 Initiative section.
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

$initiative_stats = array(
	array( 'num' => '5K', 'label' => 'UNITS',  'nudge_x' => '-40%' ),
	array( 'num' => '5',  'label' => 'CITIES', 'nudge_x' => '-50%' ),
	array( 'num' => '5',  'label' => 'YEARS',  'nudge_x' => '-50%' ),
);
?>
<section class="rsk-initiative tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-hidden tw-bg-[#0e2953] tw-pb-[clamp(4rem,10vw,8rem)] [clip-path:polygon(0_0,100%_0,100%_calc(100%-clamp(3rem,8vw,7rem)),0_100%)]" data-rsk-reveal>
	<img
		class="!tw-absolute tw-inset-0 !tw-w-full !tw-h-full !tw-max-w-none tw-object-cover tw-object-center"
		src="<?php echo esc_url( $img . '/fondo-rsk.png' ); ?>"
		alt=""
		aria-hidden="true"
	>
	<div class="tw-absolute tw-inset-0 tw-bg-[#0e2953]/45" aria-hidden="true"></div>

	<div class="tw-relative tw-max-w-rsk-wide tw-mx-auto tw-px-[clamp(1.25rem,4vw,3.5rem)] tw-py-[clamp(3.5rem,9vh,7rem)]">
		<div class="tw-flex tw-flex-col md:tw-flex-row tw-items-center tw-gap-[clamp(2rem,5vw,4rem)]">

			<div class="tw-flex-1">

				<h2 class="rsk-reveal rsk-reveal--rise tw-font-serif tw-font-normal tw-text-white tw-text-[clamp(2.75rem,5.5vw,5.25rem)] tw-leading-[1.0] tw-m-0 tw-mb-[clamp(2rem,4vw,3.5rem)]">
					THE 5|5|5<br>
					INITIATIVE
				</h2>

				<div class="tw-flex tw-items-end tw-gap-[clamp(1.25rem,2.5vw,2.25rem)] tw-flex-wrap">
					<?php foreach ( $initiative_stats as $i => $stat ) : ?>
					<div class="rsk-reveal rsk-reveal--rise-image tw-flex tw-flex-col tw-items-center tw-gap-3 tw-shrink-0" style="--rsk-reveal-delay:<?php echo 200 + $i * 100; ?>ms">
						<div class="tw-w-[clamp(92px,10vw,124px)] tw-h-[clamp(92px,10vw,124px)] tw-shrink-0 tw-aspect-square tw-rounded-full !tw-border-2 !tw-border-solid !tw-border-white tw-flex tw-items-center tw-justify-center">
							<span
								class="tw-font-serif tw-text-white tw-text-[clamp(2rem,3.6vw,3.15rem)] tw-font-normal tw-inline-block"
								style="line-height:1; font-variant-numeric: lining-nums; font-feature-settings: 'lnum'; -webkit-font-feature-settings: 'lnum';"
							>
								<?php echo esc_html( $stat['num'] ); ?>
							</span>
						</div>
						<span class="tw-font-sans tw-text-white tw-text-[0.72rem] tw-tracking-[0.3em] tw-uppercase tw-font-semibold">
							<?php echo esc_html( $stat['label'] ); ?>
						</span>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="tw-hidden md:tw-block tw-self-stretch tw-flex-none tw-w-px tw-bg-white/25"></div>

			<div class="rsk-reveal rsk-reveal--fade tw-flex-1 md:tw-max-w-[38ch]" style="--rsk-reveal-delay:300ms">
				<p class="tw-m-0 tw-mb-5 tw-font-sans tw-text-white tw-text-[clamp(0.9rem,1.05vw,1rem)] tw-leading-relaxed tw-font-medium">
					The 5|5|5 Initiative is our commitment to expanding attainable housing across America&rsquo;s fastest-growing markets.
				</p>
				<p class="tw-m-0 tw-font-sans tw-text-white/80 tw-text-[clamp(0.85rem,0.95vw,0.95rem)] tw-leading-relaxed">
					Every project, hire, process improvement, and investment decision supports this mission. Our goal is not simply growth — it is scalable impact.
				</p>
			</div>

		</div>
	</div>
</section>
