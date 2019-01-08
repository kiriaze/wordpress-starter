// accept hot module reloading
if ( module.hot ) {
	module.hot.accept();
}

// 
import '../scss/style.scss';

import 'jquery';

// Require the polyfill before requiring any other modules.
require('intersection-observer');

class App {

	constructor() {

		this.$window    = $(window);
		this.$document  = $(document);
		this.$body      = $('body');

		document.addEventListener('DOMContentLoaded', () => {
			this.init();
		});

	};

	init() {

		console.log('init');
		
		this.lazyload({
			// selector: '.lazyload',
			// offset: '0px 0px -200px 0px'
		});

	};

	throttle(fn, delay) {
		let lastCall = 0;
		return function (...args) {
			const now = (new Date).getTime();
			if (now - lastCall < delay) {
				return;
			}
			lastCall = now;
			return fn(...args);
		}
	};

	debounce(fn, delay) {
		let timerId;
		return function (...args) {
			if (timerId) {
				clearTimeout(timerId);
			}
			timerId = setTimeout(() => {
				fn(...args);
				timerId = null;
			}, delay);
		}
	};

	lazyload(params = {}) {

		// img tags or parent need to have a height/padding set to it as the are collapsed for intersection observer to correctly fire
		// e.g. .lazyload img
		
		// params = {
		// 	selector: '.lazyload',
		// 	offset: '0px 0px 0px 0px' // pos val triggers %/px before elem in view, neg val triggers after elem is %/px in view
		// }

		let nested   = params.nested || false;
		let selector = params.selector || '.lazyload';
		let offset   = params.offset || '0px 0px 0px 0px';
		const images = document.querySelectorAll(selector);
		
		const config = {
			rootMargin: offset,
			threshold: 0
		}; 
		
		const handleIntersection = (entries, observer) => {
			entries.forEach(entry => {
				if (entry.intersectionRatio > 0) {
					observer.unobserve(entry.target);
					loadImage(entry.target.querySelector('[data-src]'))
				}
			})
		}
		
		const observer = new IntersectionObserver(handleIntersection, config);

		const loadImage = (image) => {
			const src = image.dataset.src;
			fetchImage(src).then(() => {
				// entry.target.tagName === 'IMG' ?
				// 	entry.target.src = src :
				// 	entry.target.style.backgroundImage = 'url('+ src +')';
				image.src = src;
				image.classList.add('lazyloaded');
			})
		}

		const fetchImage = (url) => {
			return new Promise((resolve, reject) => {
				const image = new Image();
				image.src = url;
				image.onload = resolve;
				image.onerror = reject;
			});
		}

		images.forEach(image => {
			observer.observe(image)
		});

	};

}

new App();