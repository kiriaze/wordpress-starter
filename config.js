'use strict';

var src  	= './',
	dist 	= './',
	assets  = 'assets';

module.exports = {

	root: '/',

	src,

	dist,

	assets,
	
	entry: ['app', 'styleguide', 'login'],

	// match with package.json dependencies
	// $ npm install package --save
	dependencies: {
		'$': 'jquery',
		// 'THREE': 'three',
		// 'jQuery': 'jquery',
		// 'window.jQuery': 'jquery'
	},

	// swap commented out proxy/localhost if needing to access on other devices via ip address
	// 'localhost' || '0.0.0.0'
	proxy: false,
	localhost: '127.0.0.1', // for safari sake..
	// localhost: 'localhost',
	// proxy: true,
	// localhost: '0.0.0.0',

	port: {
		server: 8000,
		webpack: 3000
	}

};