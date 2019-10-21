import cleave from './cleave';
import scrollTo from './scrollTo';
import resizeTextarea from './resizeTextarea';

import tabs from './tabs';
import alerts from './alerts';
import dropDown from './dropDown';
import accordions from './accordions';

import scrollEvents from './scrollEvents';

const ui = () => {

	tabs();
	cleave();
	alerts();
	scrollTo();
	dropDown();
	accordions();
	scrollEvents();
	resizeTextarea();
	
};

export default ui;