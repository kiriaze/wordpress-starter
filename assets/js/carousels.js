import Swiper from 'swiper';

const carousels = () => {

	// pagination
	let carouselPagination = (swiper) => {

		// console.log(swiper, swiper.activeIndex, swiper.passedParams.slidesPerView);
		// pulled from swiper.js pagination..
		let total = swiper.params.loop ? Math.ceil((slidesLength - (swiper.loopedSlides * 2)) / swiper.params.slidesPerGroup) : swiper.snapGrid.length;
		let current = swiper.activeIndex || 0;
		// console.log((current + 1), total, swiper.snapIndex);

		current     = (current + 1) < 10 ? `0${(current + 1)}` : (current + 1);
		total       = total < 10 ? `0${total}` : total;

		let $pagiCurrent = swiper.el.querySelector('.carousel-pagination-current');
		let $pagiTotal   = swiper.el.querySelector('.carousel-pagination-total');

		let $progressBar = swiper.el.querySelector('.progress-bar__fill');

		if ( $pagiCurrent ) $pagiCurrent.innerText = current;
		if ( $pagiTotal ) $pagiTotal.innerText     = total;

		let progress = (current / total * 100);
		if ( $progressBar ) {
			// $progressBar.style = `width: ${progress}%`;
			$progressBar.style = `
				transform: translate3d(0px, 0px, 0px) scaleX( ${(current / total)} ) scaleY(1);
				transition-duration: 300ms;
			`;
		}
	}

	// single item carousels
	[...document.querySelectorAll('[data-carousel="hero-home"], [data-carousel="hero-pdp"], [data-carousel="story"]')].map((el, index) => {
		let swiperInstance = new Swiper(el, {
			effect: 'fade',
			spaceBetween: 0,
			slidesPerView: 1,
			on: {
				init: function() {
					carouselPagination(this);
				},
				slideChange: function() {
					carouselPagination(this);
				}
			},
			// navigation: {
			// 	nextEl: '.carousel__next',
			// 	prevEl: '.carousel__prev',
			// },
		});
		// this or navigation param both work
		// using below instead of navigation param incase we need extra navigation; e.g. arrows/carrots, on top of the mouse over area navigation
		el.addEventListener('click', (e) => {
			if ( e.target.matches('[data-carousel-next]') ) {
				swiperInstance.slideNext();
			}
			if ( e.target.matches('[data-carousel-prev]') ) {
				swiperInstance.slidePrev();
			}
		});
	});

	// blog post gallery
	let $postGallery = document.querySelector('.wp-block-gallery.gallery');
	if ( $postGallery ) {
		let postGallerySlides = [];
		let postGalleryItems  = $postGallery.children;
		[...postGalleryItems].map( i => {
			let slide = `<div class="swiper-slide">${i.querySelector('figure').outerHTML}</div>`;
			// console.log(slide);
			postGallerySlides.push(slide);
		});
		document.querySelector('.wp-block-gallery.gallery').innerHTML = `<div class="swiper-container post-gallery" data-cursor-canvas><div class="swiper-wrapper"></div></div>`;
		const postGallery = new Swiper('.post-gallery', {
			slidesPerView: 4,
			spaceBetween: 60,
			// breakpoints: {
			// 	1920: {
			// 		slidesPerView: 3,
			// 		spaceBetween: 60,
			// 	},
			// 	1680: {
			// 		slidesPerView: 2.5,
			// 		spaceBetween: 60,
			// 	},
			// 	960: {
			// 		slidesPerView: 2.25,
			// 		spaceBetween: 40,
			// 	},
			// 	780: {
			// 		slidesPerView: 1.2,
			// 		spaceBetween: 40,
			// 	}
			// }
		});
		postGallery.addSlide(1, postGallerySlides);
	}
	// 

}

export default carousels;