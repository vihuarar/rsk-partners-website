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
	array( 'num' => '5K', 'label' => 'UNITS' ),
	array( 'num' => '5',  'label' => 'CITIES' ),
	array( 'num' => '5',  'label' => 'YEARS' ),
);
?>
<section class="tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-hidden">
	<img
		class="tw-absolute tw-inset-0 tw-w-full tw-h-full tw-object-cover tw-object-center"
		src="<?php echo esc_url( $img . '/fondo-rsk.png' ); ?>"
		alt=""
		aria-hidden="true"
	>

	<div class="tw-relative tw-max-w-rsk-wide tw-mx-auto tw-px-[clamp(1.25rem,4vw,3.5rem)] tw-py-[clamp(3.5rem,9vh,7rem)]">
		<div class="tw-flex tw-flex-col md:tw-flex-row tw-items-center tw-gap-[clamp(2rem,5vw,4rem)]">

			<div class="tw-flex-1">

				<h2 class="tw-font-serif tw-font-normal tw-text-white tw-text-[clamp(2.75rem,5.5vw,5.25rem)] tw-leading-[1.0] tw-m-0 tw-mb-[clamp(2rem,4vw,3.5rem)]">
					THE 5|5|5<br>
					INITIATIVE
				</h2>

				<div class="tw-flex tw-gap-[clamp(1.25rem,2.5vw,2.25rem)] tw-flex-wrap">
					<?php foreach ( $initiative_stats as $stat ) : ?>
					<div class="tw-flex tw-flex-col tw-items-center tw-gap-3">
						<div class="tw-w-[clamp(88px,10vw,124px)] tw-h-[clamp(88px,10vw,124px)] tw-rounded-full tw-border tw-border-white/55 tw-flex tw-items-center tw-justify-center">
							<span class="tw-font-serif tw-text-white tw-text-[clamp(1.65rem,3.2vw,2.75rem)] tw-leading-none">
								<?php echo esc_html( $stat['num'] ); ?>
							</span>
						</div>
						<span class="tw-font-sans tw-text-white/65 tw-text-[0.68rem] tw-tracking-[0.28em] tw-uppercase tw-font-medium">
							<?php echo esc_html( $stat['label'] ); ?>
						</span>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="tw-hidden md:tw-block tw-self-stretch tw-flex-none tw-w-px tw-bg-white/25"></div>

			<div class="tw-flex-1 md:tw-max-w-[38ch]">
				<p class="tw-m-0 tw-mb-5 tw-font-sans tw-text-white tw-text-[clamp(0.9rem,1.05vw,1rem)] tw-leading-relaxed tw-font-medium">
					The 5|5|5 Initiative is RSK's long term commitment to scaling attainable housing across America's fastest-growing markets.
				</p>
				<p class="tw-m-0 tw-font-sans tw-text-white/80 tw-text-[clamp(0.85rem,0.95vw,0.95rem)] tw-leading-relaxed">
					This initiative represents more than growth targets — it reflects our belief that disciplined development, operational excellence, and innovative thinking can create meaningful impact at scale.
				</p>
			</div>

		</div>
	</div>
</section>
