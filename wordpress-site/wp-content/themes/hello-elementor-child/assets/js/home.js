(function () {
	'use strict';

	/* ---------- Hero slider ---------- */
	const slider = document.querySelector('[data-rsk-slider]');
	if (slider) {
		const slides = Array.from(slider.querySelectorAll('.rsk-hero__slide'));
		const dots   = Array.from(document.querySelectorAll('.rsk-hero__dot'));
		const AUTO_MS = 7000;
		let current = slides.findIndex(s => s.classList.contains('is-active'));
		if (current < 0) current = 0;
		let timer = null;

		function go(idx) {
			idx = ((idx % slides.length) + slides.length) % slides.length;
			slides.forEach((s, i) => {
				const on = i === idx;
				s.classList.toggle('is-active', on);
				if (on) s.removeAttribute('aria-hidden'); else s.setAttribute('aria-hidden', 'true');
			});
			dots.forEach((d, i) => {
				const on = i === idx;
				d.classList.toggle('is-active', on);
				d.setAttribute('aria-current', on ? 'true' : 'false');
			});
			current = idx;
		}

		function start() {
			stop();
			timer = setInterval(() => go(current + 1), AUTO_MS);
		}
		function stop() {
			if (timer) { clearInterval(timer); timer = null; }
		}

		dots.forEach(dot => {
			dot.addEventListener('click', () => {
				go(parseInt(dot.dataset.go, 10) || 0);
				start();
			});
		});

		const hero = slider.closest('.rsk-hero');
		if (hero) {
			hero.addEventListener('mouseenter', stop);
			hero.addEventListener('mouseleave', start);
		}

		if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			start();
		}
	}

	/* ---------- Who We Are accordion ---------- */
	const panel = document.querySelector('.rsk-who__panel');
	if (!panel) return;

	const items = Array.from(panel.querySelectorAll('.rsk-acc'));

	function activate(target) {
		items.forEach(function (item) {
			const toggle = item.querySelector('.rsk-acc__toggle');
			const isOn   = item === target;

			item.classList.toggle('is-active', isOn);
			if (toggle) toggle.setAttribute('aria-expanded', isOn ? 'true' : 'false');
		});
	}

	items.forEach(function (item) {
		const toggle = item.querySelector('.rsk-acc__toggle');
		if (!toggle) return;
		toggle.addEventListener('click', function () { activate(item); });
		toggle.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				activate(item);
			}
		});
	});
})();
