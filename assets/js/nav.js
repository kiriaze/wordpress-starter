const nav = () => {
	// attaching nav click listenters to header(s), than checking if its the right elem
	let $headers = document.querySelectorAll('.header');

	const closeNav = (e) => {
		document.body.classList.remove('nav-open');
		// [...document.querySelectorAll('.header')].map(x => x.classList.remove('is-active'));
	}

	document.addEventListener('click', (e) => {
		if ( e.target.matches('data-close-nav') ) {
			closeNav();
		}
	});

	for (const $header of $headers) {

		$header.addEventListener('click', (e) => {

			let navItem = e.target.dataset.navItem;

			if ( navItem ) {

				// add current active class
				e.target.classList.add('is-active');
				
				// set body class for styling and overflow hidden
				document.body.classList.add('nav-open');

			}

		});

	}
}

export default nav;