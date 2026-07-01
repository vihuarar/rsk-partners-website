/** @type {import('tailwindcss').Config} */
module.exports = {
	/**
	 * `tw-` prefix avoids collisions with Hello Elementor / Elementor /
	 * any plugin that ships generic utility-class names (container, hidden,
	 * block, flex, etc.).
	 */
	prefix: 'tw-',

	/**
	 * Scan every PHP file in the child theme for Tailwind class names so
	 * the compiled CSS only ships what's actually used.
	 */
	content: [
		'./*.php',
		'./template-parts/**/*.php',
		'./includes/**/*.php',
	],

	corePlugins: {
		/**
		 * Preflight is Tailwind's CSS reset (resets margins on h1-h6, lists,
		 * etc.). Disabled here because Elementor and Hello Elementor already
		 * ship their own resets and we'd otherwise stomp on existing pages.
		 */
		preflight: false,
	},

	theme: {
		extend: {
			colors: {
				'rsk-navy':      '#0b2545',
				'rsk-navy-deep': '#061a36',
				'rsk-blue':      '#1f4e8c',
				'rsk-blue-soft': '#3d6db0',
				'rsk-cream':     '#f1ece4',
				'rsk-ink':       '#0e1a2b',
				'rsk-ink-soft':  '#4a5568',
			},
			fontFamily: {
				/* Resolves to the @font-face families enqueued by fonts.css */
				sans:  ['"DM Sans"', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'sans-serif'],
				serif: ['"Playfair Display"', 'Georgia', '"Times New Roman"', 'serif'],
			},
			maxWidth: {
				'rsk':       '1180px',
				'rsk-wide':  '1480px',
			},
		},
	},

	plugins: [],
};
