<?php
/**
 * Home — Markets section.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$markets = array( 'Dallas', 'Houston', 'Phoenix', 'Tampa' );
$active  = 'Houston';
?>
<section class="tw-bg-rsk-blue tw-text-white tw-py-20 md:tw-py-24">
	<div class="tw-max-w-rsk tw-mx-auto tw-px-6">
		<h2 class="tw-font-serif tw-text-center tw-text-4xl md:tw-text-5xl tw-leading-tight tw-mb-12">
			Strategically Positioned in<br>
			<span class="tw-italic tw-font-normal">High Growth Markets</span>
		</h2>

		<div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4">
			<?php foreach ( $markets as $m ) :
				$is_on = ( $m === $active );
			?>
			<article class="<?php echo $is_on
				? 'tw-bg-rsk-navy-deep tw-ring-2 tw-ring-white tw-ring-inset'
				: 'tw-bg-rsk-navy hover:tw-bg-rsk-navy-deep tw-transition-colors'; ?> tw-text-center tw-py-7 tw-px-6">
				<h3 class="tw-font-serif tw-text-xl tw-m-0"><?php echo esc_html( $m ); ?></h3>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
