import PhotoSwipeLightbox from 'photoswipe/lightbox';

(function () {
	'use strict';

	/* ---------- Product gallery lightbox (PhotoSwipe) ---------- */
	if (document.querySelector('#rsk-pgal-gallery a[data-pswp-width]')) {
		const lightbox = new PhotoSwipeLightbox({
			gallery: '#rsk-pgal-gallery',
			children: 'a',
			pswpModule: () => import('photoswipe'),
			showHideAnimationType: 'fade',
			bgOpacity: 0.92,
			padding: { top: 40, bottom: 40, left: 20, right: 20 },
		});
		lightbox.init();
	}

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

	/* ---------- Parallax on What-We-Do product images ---------- */
	const parallaxFigures = document.querySelectorAll('[data-rsk-reveal] figure.rsk-reveal--rise-image');
	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	if (parallaxFigures.length && !reduceMotion && canHover) {
		parallaxFigures.forEach(function (fig) {
			const frame = fig.querySelector('.rsk-parallax__frame');
			const media = frame && frame.querySelector('img, video');
			if (!frame || !media) return;
			media.classList.add('rsk-parallax__media');

			frame.addEventListener('mousemove', function (e) {
				const r = frame.getBoundingClientRect();
				const x = ((e.clientX - r.left) / r.width) * 100;
				const y = ((e.clientY - r.top) / r.height) * 100;
				media.style.transformOrigin = x + '% ' + y + '%';
			});

			frame.addEventListener('mouseenter', function () {
				fig.classList.add('is-hovering');
			});

			frame.addEventListener('mouseleave', function () {
				fig.classList.remove('is-hovering');
				media.style.transformOrigin = '50% 50%';
			});
		});
	}

	/* ---------- City carousel (Markets) — sliding infinite ---------- */
	const citiesRoot = document.querySelector('[data-rsk-cities]');
	if (citiesRoot) {
		const track = citiesRoot.querySelector('.rsk-cities__track');
		const interval = parseInt(citiesRoot.getAttribute('data-interval'), 10) || 3000;
		const slideDuration = 700;
		let timer = null;
		let sliding = false;

		function trackGap() {
			return parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 0;
		}

		// Compute the middle visible index from the current CSS var. Mobile
		// shows 3 cards → middle=1, tablet shows 4 → middle=1, desktop shows
		// 5 → middle=2. Keeps the highlighted card visually centered at every
		// breakpoint instead of drifting to the right edge on small screens.
		function computeActiveIndex() {
			const visibleStr = getComputedStyle(citiesRoot).getPropertyValue('--rsk-cities-visible').trim();
			const visible = parseInt(visibleStr, 10) || 5;
			return Math.floor(visible / 2);
		}
		let activeIndex = computeActiveIndex();

		function markActive() {
			activeIndex = computeActiveIndex();
			const cards = Array.from(track.children);
			cards.forEach((c, i) => {
				c.classList.toggle('is-active', i === activeIndex);
			});
			const centerCard = cards[activeIndex];
			if (centerCard) {
				centerCard.classList.add('is-changing');
				setTimeout(() => centerCard.classList.remove('is-changing'), slideDuration + 250);
			}
		}

		let resizeTimer = null;
		window.addEventListener('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(markActive, 150);
		});

		function slideLeft() {
			if (sliding) return;
			const first = track.firstElementChild;
			if (!first) return;
			sliding = true;

			const stepDist = first.offsetWidth + trackGap();
			const clone = first.cloneNode(true);
			clone.classList.remove('is-active', 'is-changing');
			track.appendChild(clone);

			void track.offsetWidth;

			track.style.transition = `transform ${slideDuration}ms cubic-bezier(0.22, 1, 0.36, 1)`;
			track.style.transform = `translateX(-${stepDist}px)`;

			const finish = () => {
				track.removeEventListener('transitionend', finish);
				track.style.transition = 'none';
				track.style.transform = 'translateX(0)';
				if (track.firstElementChild) track.firstElementChild.remove();
				void track.offsetWidth;
				markActive();
				sliding = false;
			};
			track.addEventListener('transitionend', finish, { once: true });
		}

		function slideRight() {
			if (sliding) return;
			const last = track.lastElementChild;
			if (!last) return;
			sliding = true;

			const stepDist = last.offsetWidth + trackGap();
			const clone = last.cloneNode(true);
			clone.classList.remove('is-active', 'is-changing');
			track.insertBefore(clone, track.firstElementChild);

			// Immediately offset track left by stepDist so the visual state matches pre-slide.
			track.style.transition = 'none';
			track.style.transform = `translateX(-${stepDist}px)`;
			void track.offsetWidth;

			// Now animate back to 0 — the prepended clone slides in from the left.
			track.style.transition = `transform ${slideDuration}ms cubic-bezier(0.22, 1, 0.36, 1)`;
			track.style.transform = 'translateX(0)';

			const finish = () => {
				track.removeEventListener('transitionend', finish);
				track.style.transition = 'none';
				if (track.lastElementChild) track.lastElementChild.remove();
				void track.offsetWidth;
				markActive();
				sliding = false;
			};
			track.addEventListener('transitionend', finish, { once: true });
		}

		function step() { slideLeft(); }

		let resumeTimer = null;
		function scheduleResume(delay) {
			if (resumeTimer) clearTimeout(resumeTimer);
			resumeTimer = setTimeout(() => {
				resumeTimer = null;
				start();
			}, delay);
		}

		function handleCardClick(e) {
			const card = e.target.closest('.rsk-cities__card');
			if (!card) return;
			const cards = Array.from(track.children);
			const clickedIndex = cards.indexOf(card);
			if (clickedIndex < 0) return;

			// Always reset both the running interval and any pending resume timer.
			stop();
			if (resumeTimer) { clearTimeout(resumeTimer); resumeTimer = null; }

			// Clicking the active card (or clicking mid-slide) just resets the auto-timer.
			if (sliding || clickedIndex === activeIndex) {
				scheduleResume(interval);
				return;
			}

			if (clickedIndex > activeIndex) {
				slideLeft();
			} else {
				slideRight();
			}
			// Give the user a full interval to view the new center card before auto-advancing.
			scheduleResume(slideDuration + interval);
		}

		track.addEventListener('click', handleCardClick);

		function start() {
			stop();
			timer = setInterval(step, interval);
		}
		function stop() {
			if (timer) { clearInterval(timer); timer = null; }
			if (resumeTimer) { clearTimeout(resumeTimer); resumeTimer = null; }
		}

		document.addEventListener('visibilitychange', () => {
			if (document.hidden) stop(); else start();
		});
		citiesRoot.addEventListener('mouseenter', stop);
		citiesRoot.addEventListener('mouseleave', start);

		markActive();
		start();
	}

	/* ---------- Product gallery carousel ----------
	   Track holds N cards, only `data-visible` are shown at a time.
	   Prev/next buttons translate the track by one card width; auto-
	   advances on `data-interval`, pauses on hover, and wraps around
	   at both ends. */
	const pgals = document.querySelectorAll('[data-rsk-pgal]');
	pgals.forEach(function (root) {
		const track = root.querySelector('.rsk-pgal__track');
		const cards = root.querySelectorAll('.rsk-pgal__card');
		const prev  = root.querySelector('[data-rsk-pgal-prev]');
		const next  = root.querySelector('[data-rsk-pgal-next]');
		if (!track || !cards.length) return;

		const visible  = parseInt(root.getAttribute('data-visible'), 10) || 5;
		const interval = parseInt(root.getAttribute('data-interval'), 10) || 4500;
		const total    = cards.length;
		const maxIdx   = Math.max(0, total - visible);
		let idx = 0;
		let timer = null;

		const apply = function () {
			const card = cards[0];
			const gap  = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap || 0) || 0;
			const step = card.getBoundingClientRect().width + gap;
			track.style.transform = 'translate3d(-' + (step * idx) + 'px, 0, 0)';
		};

		const go = function (delta) {
			idx += delta;
			if (idx > maxIdx) idx = 0;
			if (idx < 0)      idx = maxIdx;
			apply();
		};

		const start = function () {
			if (reduceMotion || total <= visible) return;
			stop();
			timer = setInterval(function () { go(1); }, interval);
		};
		const stop = function () { if (timer) { clearInterval(timer); timer = null; } };

		if (prev) prev.addEventListener('click', function () { go(-1); start(); this.blur(); });
		if (next) next.addEventListener('click', function () { go(1);  start(); this.blur(); });
		root.addEventListener('mouseenter', stop);
		root.addEventListener('mouseleave', start);
		window.addEventListener('resize', apply);

		apply();
		start();
	});

	/* ---------- Scroll-reveal (re-triggers each time) ---------- */
	const reveals = document.querySelectorAll('.rsk-reveal');
	if (reveals.length && 'IntersectionObserver' in window) {
		const io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				entry.target.classList.toggle('is-visible', entry.isIntersecting);
			});
		}, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
		reveals.forEach(function (el) { io.observe(el); });
	} else {
		reveals.forEach(function (el) { el.classList.add('is-visible'); });
	}
})();
