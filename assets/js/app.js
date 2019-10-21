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
import utility from './utility.js';

// 
import ui from './ui.js';
import forms from './forms.js';
import cursor from './cursor.js';

import smoothScrolling from './smoothScrolling.js';

import pageNavigation from './pageNavigation';

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
			setTimeout( () => {
				this.$html[0].classList.add('has-loaded');
			}, 1000);
			this.init();
			this.modules();
			this.mutationWatch();
		});
	}

	init() {

		// console.log('init...');
		debounce();
		throttle();

		ui();
		utility.init();
		pageNavigation();

		// menu();

		cursor();

		smoothScrolling('.main-content');

	}

	modules() {
		// these need to be rerun/reindexed
		skrolly({
			// selector: '[data-src]'
		});
		lazyload();
		// 
		forms();
		// modals();
		// carousels();

	}

	mutationWatch() {
		
		// DOM element we want to observe
		let targetNode = document.querySelector('[data-ajax-wrap]');

		if ( !targetNode ) return;

		// Options for the observer
		let config = {
			childList: true,
			// attributes: true,
			// attributeOldValue: true,
			// attributeFilter: ['class'],
		};

		// Callback will execute when mutations are observed
		let callback = (mutationsList) => {
			
			// rerun scripts..
			ui();
			this.modules();

			// // possibly match each mutations data-attr to match js callbacks
			// for(let mutation of mutationsList) {
			// 	console.log('something', mutation);
			// }
		};

		// Create a new observer, passing in the callback function
		let observer = new MutationObserver(callback);
		
		// Start observing the targetNode with the given configuration
		observer.observe(targetNode, config);
	}

}

new App();