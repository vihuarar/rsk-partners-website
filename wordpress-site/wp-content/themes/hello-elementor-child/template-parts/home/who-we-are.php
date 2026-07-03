<?php
/**
 * Home — Who We Are section.
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

$who_items = array(
	array(
		'num'      => '01',
		'title'    => 'Data-Driven Site Selection',
		'subtitle' => 'Long-term demand, identified early',
		'body'     => 'We invest where long-term demographic, economic, and housing fundamentals support durable demand. Our research process evaluates population growth, employment trends, housing supply constraints, affordability metrics, and migration patterns to identify opportunities before they become obvious to the broader market.',
	),
	array(
		'num'      => '02',
		'title'    => 'Operational Excellence',
		'subtitle' => 'Execution is our competitive advantage',
		'body'     => 'Through disciplined planning, standardized processes, and rigorous oversight, we streamline development, control costs, expedite timelines, and improve project outcomes without sacrificing quality.',
	),
	array(
		'num'      => '03',
		'title'    => 'Systematic Development',
		'subtitle' => 'Repeatable processes, not one-off decisions',
		'body'     => 'We believe the best results come from repeatable processes, not one-off decisions. Every stage of development follows a structured framework designed to improve efficiency, reduce risk, and create consistency across every community we build.',
	),
	array(
		'num'      => '04',
		'title'    => '5|5|5 Initiative',
		'subtitle' => '5,000 Homes. 5 Markets. 5 Years.',
		'body'     => 'The 5|5|5 Initiative is our commitment to expanding attainable housing across America&rsquo;s fastest-growing markets. Every project, hire, process improvement, and investment decision supports this mission. Our goal is not simply growth — it is scalable impact.',
	),
);
?>
<section class="rsk-section rsk-who" data-rsk-reveal>
	<div class="rsk-container rsk-who__grid">
		<header class="rsk-who__heading rsk-reveal rsk-reveal--rise">
			<h2>
				<span>WHO</span><br>
				<span>WE&nbsp;ARE</span>
			</h2>
		</header>

		<figure class="rsk-who__media rsk-reveal rsk-reveal--rise-image" style="--rsk-reveal-delay:180ms">
			<div class="rsk-who__side" aria-hidden="true">
				<span class="rsk-who__rule rsk-who__rule--reveal"></span>
				<span class="rsk-who__label">RSK REAL ESTATE PARTNERS</span>
			</div>
			<video
				class="rsk-who__video"
				autoplay
				muted
				loop
				playsinline
				preload="auto"
				poster="<?php echo esc_url( $img . '/who-interior.jpg' ); ?>"
				aria-label="RSK Partners — Who we are"
			>
				<source src="<?php echo esc_url( $video . '/who-we-are-square.mp4' ); ?>" type="video/mp4">
			</video>
		</figure>

		<div class="rsk-who__panel tw-flex tw-flex-col tw-bg-rsk-cream">
			<?php foreach ( $who_items as $i => $item ) :
				$is_active = ( 0 === $i );
				$id        = 'rsk-who-' . $item['num'];
			?>
			<article
				class="rsk-acc tw-group tw-grid tw-grid-cols-[clamp(4.5rem,7vw,6rem)_minmax(0,1fr)] tw-items-stretch tw-flex-1 tw-basis-0 tw-bg-[#f1ece4] even:tw-bg-[#d2d4d6] tw-transition-colors<?php echo $is_active ? ' is-active' : ''; ?>"
			>
				<div
					class="tw-bg-rsk-navy tw-text-white/90 tw-flex tw-items-center tw-justify-center tw-font-serif tw-italic tw-text-[clamp(1.6rem,2.4vw,2.25rem)] tw-leading-none tw-py-4 tw-tracking-wide tw-select-none"
					aria-hidden="true"
				>
					<span class="tw-inline-block"><?php echo esc_html( $item['num'] ); ?></span><span class="tw-inline-block tw-ml-[-0.22em] tw-italic">/</span>
				</div>

				<div class="tw-flex tw-flex-col tw-items-center tw-px-[clamp(1.25rem,3vw,2.5rem)] tw-py-[clamp(1.25rem,2.4vw,1.85rem)] tw-text-center tw-text-rsk-ink">
					<button
						type="button"
						class="rsk-acc__toggle tw-flex tw-flex-col tw-items-center tw-gap-1.5 tw-w-full !tw-bg-transparent hover:!tw-bg-transparent focus:!tw-bg-transparent active:!tw-bg-transparent tw-appearance-none tw-border-0 tw-text-inherit tw-text-center tw-cursor-pointer tw-p-0 tw-transition-opacity hover:tw-opacity-80 focus:tw-outline-none focus-visible:tw-outline focus-visible:tw-outline-2 focus-visible:tw-outline-rsk-blue focus-visible:tw-outline-offset-4 [-webkit-tap-highlight-color:transparent]"
						aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="<?php echo esc_attr( $id ); ?>"
					>
						<span class="tw-font-serif tw-text-[clamp(1.6rem,2.6vw,2.4rem)] tw-leading-tight tw-text-rsk-navy"><?php echo esc_html( $item['title'] ); ?></span>
						<span class="tw-font-sans tw-font-medium tw-text-[clamp(0.85rem,1vw,1rem)] tw-text-rsk-blue-soft tw-tracking-wide"><?php echo esc_html( $item['subtitle'] ); ?></span>
					</button>

					<div
						id="<?php echo esc_attr( $id ); ?>"
						class="tw-grid tw-grid-rows-[0fr] group-[.is-active]:tw-grid-rows-[1fr] tw-opacity-0 group-[.is-active]:tw-opacity-100 tw-transition-all tw-duration-500 tw-ease-out tw-w-full"
					>
						<div class="tw-overflow-hidden">
							<div class="tw-pt-3 tw-max-w-[56ch] tw-mx-auto tw-font-sans tw-text-[clamp(0.9rem,1.05vw,1rem)] tw-leading-relaxed tw-text-rsk-ink">
								<p class="tw-m-0 [&_strong]:tw-font-semibold"><?php echo $item['body']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
