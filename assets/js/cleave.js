import Cleave from 'cleave.js';
import 'parsleyjs';

const cleave = () => {
	// cleave wrapper for multiple instances
	const cleaveWrapper = (selector, {...options}) => {
		document.querySelectorAll(selector, options).forEach( (el) => {
			new Cleave(el, options);
		});
	}

	// Cleave input formatting

	// digits / postal / zip
	cleaveWrapper('[data-cleave-digits]', {
		numeral: true,
		numericOnly: true,
		delimiter: ''
	});

	// phone number
	cleaveWrapper('[data-cleave-phone]', {
		numericOnly: true,
		delimiterLazyShow: true,
		blocks: [0, 3, 0, 3, 4],
		delimiters: ["(", ")", " ", "-"]
	});
}

export default cleave;