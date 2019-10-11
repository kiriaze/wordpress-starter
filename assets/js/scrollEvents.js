import debounce from './debounce';
// scroll events: header, blog, etc.
const scrollEvents = () => {

	// header
	let $fixedHeader       = document.querySelector('.header--is-fixed');
	let $hero              = document.querySelector('.hero') || '';
	// offset either hero height or height of nav / 100px
	let headerScrollOffset = $hero ? $hero.offsetHeight : 100;
	
	// blog
	let $metaBar           = document.querySelector('.blog-meta-bar');
	let $blogProgress      = document.querySelector('.blog-progress-bar');
	let $postHero          = document.querySelector('.post-hero');
	let metaBarOffset      = $postHero ? $postHero.offsetTop : 150;
	
	// scrollspy
	let sections           = {};
	let $element           = document.querySelector('.element');
	let $scrollElems       = document.querySelectorAll('[data-scroll-target]');
	let scrollspyOffset    = $element ? ($element.offsetHeight + $fixedHeader.offsetHeight + 20) : '';
	for ( let section of $scrollElems ) {
		sections[section.dataset.scrollTarget] = section.offsetTop;
	}
	// 

	window.addEventListener('scroll', (e) => {

		let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
		let height    = document.documentElement.scrollHeight - document.documentElement.clientHeight;

		// header
		if ( $fixedHeader )
		if ( winScroll > headerScrollOffset ) {
			$fixedHeader.classList.add('is-revealed');
		} else {
			$fixedHeader.classList.remove('is-revealed');
		}
		//
		
		// blog scroll progress indicator
		// let height    = document.documentElement.scrollHeight - document.documentElement.clientHeight;
		let scrolled  = (winScroll / height) * 100;

		if ( $blogProgress ) {
			$blogProgress.style.width = scrolled + '%';
			if ( winScroll > metaBarOffset ) {
				$metaBar.classList.add('is-active');
			} else {
				$metaBar.classList.remove('is-active');
			}
		}
		// 

		// scrollspy
		if ( $element ) {
			if ( winScroll > headerScrollOffset ) {
				$element.classList.add('is-active');
			} else {
				$element.classList.remove('is-active');
			}
			// scrollspy
			for ( let i in sections ) {
				if ( (sections[i] - scrollspyOffset) <= winScroll ) {
					// console.log(i, sections[i]);
					[...document.querySelectorAll('.results-bar [data-scroll-to]')].map(x => x.classList.remove('is-active'));
					$element.querySelector('.results-bar [data-scroll-to="' + i + '"]').classList.add('is-active');
				}
			}
		}
	
	});

}

export default scrollEvents;