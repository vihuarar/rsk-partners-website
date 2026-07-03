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

$contact_socials = array(
	array( 'label' => 'Fb', 'href' => '#',        'name' => 'Facebook' ),
	array( 'label' => 'Ig', 'href' => '#',        'name' => 'Instagram' ),
	array( 'label' => 'X',  'href' => '#',        'name' => 'X (Twitter)' ),
);
?>
<section
	class="rsk-contact tw-relative tw-left-1/2 tw-right-1/2 -tw-mx-[50vw] tw-w-screen tw-overflow-hidden !tw-bg-[#224378] tw-text-white"
	data-rsk-reveal
>
	<div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-[1.15fr_1fr] tw-items-stretch tw-min-h-[clamp(24rem,55vh,42rem)]">

		<!-- LEFT: text block -->
		<div class="tw-relative tw-flex tw-flex-col tw-px-[clamp(1.75rem,5vw,5.5rem)] tw-py-[clamp(2rem,5vw,4rem)]">

			<h2 class="tw-font-serif tw-font-normal tw-text-white tw-leading-[0.95] tw-tracking-tight tw-m-0 tw-text-[clamp(2.75rem,6.5vw,6rem)]">
				Contact
			</h2>
			<p class="tw-mt-4 tw-max-w-[38ch] tw-font-sans tw-text-white/80 tw-text-[clamp(0.9rem,1vw,1.05rem)] tw-leading-relaxed">
				Whether you&rsquo;re an investor, broker, landowner, future resident, or future team member, we&rsquo;d love to connect.
			</p>

			<div class="tw-mt-auto tw-grid tw-grid-cols-1 md:tw-grid-cols-[1fr_auto] tw-gap-x-[clamp(1.5rem,3vw,3rem)] tw-gap-y-8 tw-items-end tw-pt-[clamp(3rem,6vw,5rem)]">
				<h3 class="tw-font-serif tw-font-normal tw-text-white tw-leading-[0.95] tw-tracking-tight tw-m-0 tw-text-[clamp(2.75rem,6.5vw,6rem)]">
					Partner<br>With&nbsp;Us
				</h3>

				<address class="tw-not-italic tw-font-sans tw-text-white/85 tw-text-[clamp(0.78rem,0.95vw,0.95rem)] tw-leading-[1.55] tw-space-y-4 tw-min-w-[16ch]">
					<div>
						<p class="tw-m-0 tw-uppercase tw-tracking-[0.14em] tw-text-white/60 tw-text-[0.7rem]">General Inquires</p>
						<a
							href="mailto:info@rskrealestatepartners.com"
							class="tw-text-white hover:tw-text-white/70 tw-transition-colors tw-underline-offset-4 hover:tw-underline"
						>info@rskrealestatepartners.com</a>
					</div>
					<div>
						<p class="tw-m-0 tw-uppercase tw-tracking-[0.14em] tw-text-white/60 tw-text-[0.7rem]">Career</p>
						<a
							href="mailto:Jobs@rskrealestatepartners.com"
							class="tw-text-white hover:tw-text-white/70 tw-transition-colors tw-underline-offset-4 hover:tw-underline"
						>Jobs@rskrealestatepartners.com</a>
					</div>
					<div>
						<p class="tw-m-0 tw-uppercase tw-tracking-[0.14em] tw-text-white/60 tw-text-[0.7rem]">Follow us</p>
						<ul class="tw-list-none tw-p-0 tw-m-0 tw-flex tw-gap-4 tw-mt-1">
							<?php foreach ( $contact_socials as $s ) : ?>
							<li class="tw-m-0">
								<a
									href="<?php echo esc_url( $s['href'] ); ?>"
									aria-label="<?php echo esc_attr( $s['name'] ); ?>"
									class="tw-text-white hover:tw-text-white/70 tw-transition-colors"
								><?php echo esc_html( $s['label'] ); ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</address>
			</div>
		</div>

		<!-- RIGHT: image -->
		<figure class="tw-relative tw-m-0 tw-h-full tw-min-h-[60vw] md:tw-min-h-0 tw-flex tw-items-stretch tw-justify-end tw-bg-[#224378] tw-overflow-hidden">
			<img
				class="!tw-h-full !tw-w-auto !tw-max-w-none tw-block"
				src="<?php echo esc_url( $img . '/contact-house.webp' ); ?>"
				alt=""
				loading="lazy"
			>
		</figure>

	</div>
</section>
