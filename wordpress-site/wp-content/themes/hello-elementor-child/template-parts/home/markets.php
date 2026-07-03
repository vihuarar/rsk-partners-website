<?php
/**
 * Home — Markets section.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$img = $args['img'];

$markets_cities = array(
	array( 'name' => 'Dallas',         'img' => 'city-dallas.webp' ),
	array( 'name' => 'Houston',        'img' => 'city-houston.webp' ),
	array( 'name' => 'Nashville',      'img' => 'city-nashville.webp' ),
	array( 'name' => 'Raleigh',        'img' => 'city-raleigh.webp' ),
	array( 'name' => 'Salt Lake City', 'img' => 'city-salt-lake-city.webp' ),
);

$markets_notes = array(
	'RSK targets markets with strong population growth, expanding employment sectors, and increasing demand for attainable housing.',
	'Our disciplined market selection process allows us to focus capital and development efforts where long-term demographic and economic trends support scalable residential growth.',
);
?>
<section class="rsk-markets tw-relative !tw-bg-[#141414] tw-text-white tw-pt-[clamp(6rem,14vw,12rem)] tw-pb-[clamp(4rem,8vw,7rem)] -tw-mt-[clamp(3rem,8vw,7rem)] tw-z-10 [clip-path:polygon(0_clamp(3rem,8vw,7rem),100%_0,100%_100%,0_100%)]" data-rsk-reveal>
	<div class="tw-max-w-rsk-wide tw-mx-auto tw-px-[clamp(1.5rem,4vw,4rem)]">
		<div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-[1.05fr_1fr] tw-gap-x-[clamp(2rem,5vw,5rem)] tw-gap-y-[clamp(2rem,4vw,3rem)] tw-items-center">

			<h2 class="rsk-reveal rsk-reveal--rise tw-font-serif tw-font-normal tw-text-[clamp(2.75rem,6vw,5.5rem)] tw-leading-[1.05] tw-tracking-tight tw-text-[#e9e6df] tw-m-0">
				Strategically Positioned in High Growth Markets
			</h2>

			<ul class="tw-list-none tw-p-0 tw-m-0 tw-flex tw-flex-col">
				<?php foreach ( $markets_notes as $i => $note ) : ?>
				<li class="rsk-reveal rsk-reveal--slide-right tw-flex tw-items-center tw-gap-[clamp(1rem,2.5vw,2rem)] tw-py-[clamp(1.5rem,3vw,2.5rem)] !tw-border-t-[2px] !tw-border-solid !tw-border-white/25 <?php echo $i === count( $markets_notes ) - 1 ? '!tw-border-b-[2px]' : ''; ?>" style="--rsk-reveal-delay:<?php echo 180 + $i * 140; ?>ms">
					<p class="tw-m-0 tw-flex-1 tw-font-sans tw-text-[clamp(0.95rem,1.1vw,1.15rem)] tw-leading-relaxed tw-text-white/85 tw-text-center">
						<?php echo esc_html( $note ); ?>
					</p>
					<button
						type="button"
						aria-label="Previous market <?php echo esc_attr( $i + 1 ); ?>"
						class="tw-shrink-0 tw-w-[clamp(58px,5.5vw,82px)] tw-h-[clamp(58px,5.5vw,82px)] tw-aspect-square tw-rounded-full !tw-border !tw-border-solid !tw-border-white/55 tw-flex tw-items-center tw-justify-center !tw-bg-transparent tw-transition hover:!tw-border-white focus:tw-outline-none focus-visible:tw-outline focus-visible:tw-outline-2 focus-visible:tw-outline-white"
					>
						<svg viewBox="0 0 24 24" class="tw-w-[clamp(1.7rem,2.1vw,2.4rem)] tw-h-[clamp(1.7rem,2.1vw,2.4rem)] tw-text-white/85" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<polyline points="15 6 9 12 15 18"></polyline>
						</svg>
					</button>
				</li>
				<?php endforeach; ?>
			</ul>

		</div>

		<!-- City carousel -->
		<div class="rsk-cities rsk-reveal rsk-reveal--rise-image tw-mt-[clamp(2.5rem,5vw,4rem)]" data-rsk-cities data-interval="3000" data-visible="5" data-active-index="2" style="--rsk-reveal-delay:280ms">
			<div class="rsk-cities__viewport">
				<ul class="rsk-cities__track tw-list-none tw-p-0 tw-m-0">
					<?php foreach ( $markets_cities as $i => $city ) : ?>
					<li class="rsk-cities__card" data-city-name="<?php echo esc_attr( $city['name'] ); ?>">
						<img
							class="rsk-cities__img !tw-max-w-none tw-object-cover"
							src="<?php echo esc_url( $img . '/' . $city['img'] ); ?>"
							alt=""
							loading="lazy"
						>
						<span class="rsk-cities__overlay" aria-hidden="true"></span>
						<span class="rsk-cities__label tw-font-sans tw-uppercase tw-tracking-[0.18em] tw-font-semibold tw-text-white">
							<?php echo esc_html( $city['name'] ); ?>
						</span>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
