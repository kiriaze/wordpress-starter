// accept hot module reloading
if ( module.hot ) {
	module.hot.accept();
}

////////////////////////////////////////////
// SCSS
////////////////////////////////////////////

// Modules
// import 'owl.carousel/dist/assets/owl.carousel.css';

// Core Styles
import '../scss/style.scss';

////////////////////////////////////////////
// JS
////////////////////////////////////////////

// Require the io polyfill before 
// requiring any other modules.
require('intersection-observer');

import 'jquery';

// Plugins
// import 'magnific-popup';

// 
import validator from 'validator';
import './tweenmax.min.js';

// Utilities
import io from './io.js';
import skrolly from './skrolly.js';
import lazyload from './lazyload.js';
import debounce from './debounce.js';
import throttle from './throttle.js';
import ui from './ui.js';
import utility from './utility.js';

// Views
// e.g. checkout

// Modules
// e.g. modals, carousel, menus, etc.
// import menu from './menu.js';

// app singleton
class App {

	constructor() {

		this.$window     = $(window);
		this.$document   = $(document);
		this.$html       = $('html');
		this.$body       = $('body');

		document.addEventListener('DOMContentLoaded', () => {
			this.$html[0].classList.add('has-loaded');
			this.init();
		});
	}

	init() {

		// console.log('init...');
		
		skrolly();
		lazyload();
		debounce();
		throttle();

		ui();
		utility();

		// menu();


		$('[data-close-overlay]').on('click', (e) => {
			$('[data-overlay]').removeClass('is-active');
		});

		$('.toggle-menu').on('click', (e) => {
			e.preventDefault();
			$('.menu-overlay').addClass('is-active');
		});

		$('.toggle-contact').on('click', (e) => {
			e.preventDefault();
			$('.contact-overlay').addClass('is-active');
		});

	};

}

new App();