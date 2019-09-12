const lazyload = (params = {}) => {

	// height or padding required for img tags since they collapse;
	// in order for intersection observer to correctly fire
	// either wrap img in a .lazyload container with padding/height or set height on img
	// e.g. .lazyload img { height: 500px; } or .lazyload { padding-bottom: 60%; }
	
	// params = {
	// 	selector: '.lazyload',
	// 	offset: '0px 0px 0px 0px' // pos val triggers %/px before elem in view, neg val triggers after elem is %/px in view
	// }

	// let nested   = params.nested || false;
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
				if ( entry.target.dataset.src ) {
					loadImage(entry.target)
				} else {
					loadImage(entry.target.querySelector('[data-src]'))
				}
			}
		})
	}
	
	const observer = new IntersectionObserver(handleIntersection, config);

	const loadImage = (image) => {
		const src = image.dataset.src;
		fetchImage(src).then(() => {
			image.tagName === 'IMG' ?
				image.src = src :
				image.style.backgroundImage = 'url('+ src +')'; // these makes 2 requests..
			image.classList.add('lazyloaded');
		})
	}

	const fetchImage = (url) => {
		return new Promise((resolve, reject) => {
			const image = new Image();
			image.src = url; // these makes 2 requests..
			image.onload = resolve;
			image.onerror = reject;
		});
	}

	// images.forEach(image => {
	// 	observer.observe(image)
	// });

	// older browsers
	for (let i = 0; i < images.length; ++i) {
		observer.observe(images[i]);
	}

};

export default lazyload;