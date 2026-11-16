/**
 * Santa Claus walk – phpBB extension caforum/santaclauswalk
 *
 * Moves Santa from left to right across the header. Once he has completely
 * left on the right, he waits for the configured pause and comes back in from
 * the left. Speed is in pixels per second.
 *
 * Santa's progress is kept as a share of the crossing (0 = just entering on
 * the left, 1 = just gone on the right), not as a raw clock value. So:
 * - when the header changes width (window resized, scrollbar appearing,
 *   responsive style), he stays at the same relative place instead of jumping;
 * - when the visitor moves to another page of the board, his progress is
 *   carried over (sessionStorage) and advanced by the time spent loading, so
 *   his walk does not restart from the left edge.
 */
(function () {
	'use strict';

	var STORAGE_KEY = 'caforum_santaclauswalk';

	function readState() {
		try {
			var s = JSON.parse(window.sessionStorage.getItem(STORAGE_KEY));
			if (s && typeof s.f === 'number' && typeof s.w === 'number' && typeof s.at === 'number') {
				return s;
			}
		} catch (e) {}
		return null;
	}

	function writeState(s) {
		try {
			window.sessionStorage.setItem(STORAGE_KEY, JSON.stringify(s));
		} catch (e) {}
	}

	function start(stage) {
		var walker = stage.querySelector('.santaclaus-walker');
		if (!walker) {
			return;
		}

		// The stage is absolutely positioned over its parent (the header bar).
		var parent = stage.parentNode;
		if (parent && window.getComputedStyle(parent).position === 'static') {
			parent.style.position = 'relative';
		}

		var speed = Math.max(1, parseFloat(stage.getAttribute('data-speed')) || 60);
		var pauseSec = Math.max(0, parseFloat(stage.getAttribute('data-pause')) || 0);
		var mobileHide = parseInt(stage.getAttribute('data-mobile-hide'), 10) || 0;
		var testMode = stage.getAttribute('data-test') === '1';
		var info = stage.querySelector('.santaclaus-test-info');
		var reduceMotion = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
		var offsetSetting = parseInt(walker.style.bottom);

		// f: share of the crossing done (0..1). w: pause seconds left (> 0 = off-screen).
		var f = 0, w = 0, last = null;
		var saved = readState();
		var pending = saved ? (Date.now() - saved.at) / 1000 : 0;
		if (saved) {
			f = Math.min(Math.max(saved.f, 0), 1);
			w = Math.max(saved.w, 0);
		}

		function shouldHide() {
			if (mobileHide > 0 && window.innerWidth < mobileHide) {
				return true;
			}
			// Respect the visitor's "reduce motion" setting, except for admins testing.
			return !testMode && reduceMotion !== null && reduceMotion.matches;
		}

		/**
		 * Move Santa forward by dt seconds for a crossing of `distance` px.
		 * Whole cycles are skipped, so a long dt (tab in background, slow page
		 * load) costs nothing.
		 */
		function advance(dt, distance) {
			var walkTime = distance / speed;
			var cycle = walkTime + pauseSec;
			// Current time inside the cycle
			var t = w > 0 ? walkTime + (pauseSec - w) : f * walkTime;
			t = (t + dt) % cycle;
			if (t < walkTime) {
				f = t / walkTime;
				w = 0;
			} else {
				f = 0;
				w = cycle - t;
			}
			return cycle;
		}

		function save() {
			writeState({ f: f, w: w, at: Date.now() });
		}

		window.addEventListener('pagehide', save);
		document.addEventListener('visibilitychange', function () {
			if (document.visibilityState === 'hidden') {
				save();
			}
		});

		function frame(now) {
			var dt = last === null ? 0 : (now - last) / 1000;
			last = now;

			var hide = shouldHide();
			stage.classList.toggle('santaclaus-hidden', hide);
			snowcap.classList.toggle('santaclaus-hidden', hide);

			if (!hide) {
				var stageWidth = stage.clientWidth;
				var santaWidth = walker.offsetWidth;
				// Entering fully hidden on the left, leaving fully hidden on the right
				var distance = stageWidth + santaWidth;

				var cycle = advance(dt + pending, distance);
				pending = 0;
				var x = w > 0 ? -santaWidth : -santaWidth + f * distance;
				var walkerOffset = offsetSetting / 1280 * stageWidth;
				walker.style.bottom = walkerOffset + 'px';

				walker.style.transform = 'translate3d(' + x.toFixed(1) + 'px, 0, 0)';

				if (info) {
					info.textContent = 'x ' + Math.round(x) + ' / ' + stageWidth + ' px · ' +
						speed + ' px/s · ' + santaWidth + '×' + walker.offsetHeight + ' px · ' +
						'cycle ' + cycle.toFixed(1) + ' s' +
						(w > 0 ? ' · pause ' + Math.ceil(w) + ' s' : '');
				}
			} else {
				// Hidden (small screen, reduced motion): keep time running.
				pending += dt;
			}

			window.requestAnimationFrame(frame);
		}

		window.requestAnimationFrame(frame);
	}

	function init() {
		var stage 	= document.getElementById('santaclaus-stage');
		var snowcap = document.getElementById('snowcap');

		if (stage && window.requestAnimationFrame) {
			start(stage);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
