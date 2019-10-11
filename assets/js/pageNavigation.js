const pageNavigation = () => {
	// ajax page navigation / content
	window.addEventListener('popstate', (e) => {
		// e.state is equal to the last url of item we clicked
		// console.log(e.target.location.href, e.state);
		// since it doesn't work page loads, navigates, then goes back,
		// we'll use e.target.location.href
		// if ( e.state !== null ) {
		if ( e.target.location.href !== null ) {
			pageTransition();
			// fetch(e.state)
			fetch(e.target.location.href)
				.then( response => response.text() )
				.then( body => {
					// console.log(body);
					// let content = parseData(body, e.state);
					let content = parseData(body, e.target.location.href);
					injectContent(content);
				});
		}
	});

	let $ajaxWrap  = document.querySelector('[data-ajax-wrap]');

	let closeNav = () => {
		document.body.classList.remove('nav-open');
	}

	let pageTransition = () => {
		
		// need to wrap in cb after done scrolling
		
		closeNav();

		// page/loading animation
		// 	TweenLite.to($menuBG, 0, {
		// 		y: '-100%'
		// 	});

		$ajaxWrap.classList.add('is-loading');
		window.scroll({
			top: 0,
			left: 0,
			// behavior: 'smooth'
		});
	}

	let injectContent = (content) => {
		setTimeout( () => {
			$ajaxWrap.innerHTML = content.querySelector('[data-ajax-wrap]').innerHTML;
			document.title = content.querySelector('title').innerText;
			$ajaxWrap.classList.remove('is-loading');
		}, 150);
	}

	let parseData = (data, url) => {
		// grab content
		const parser       = new DOMParser();
		const htmlDocument = parser.parseFromString(data, 'text/html');
		const content      = htmlDocument.documentElement;
		return content;
	}

	document.addEventListener('click', (e) => {
		// console.log(e, e.target, e.currentTarget);
		if ( 
			// rather than checking whether whats clicked is an actual anchor,
			// we check if whats clicked is a ancestor of an anchor tag and a data-ajax-links
			// and if so proceed
			e.target.closest('a') &&
			e.target.closest('[data-ajax-links]') 
		) {
			e.preventDefault();
			let url = e.target.closest('a').href;
			// console.log(url);
			if ( 
				url !== '' && 
				url !== window.location.href &&
				url !== undefined &&
				url !== 'javascript:;'
			) {
				pageTransition();
				fetch(url)
					.then( response => response.text() )
					.then( body => {
						let content = parseData(body, url);
						injectContent(content);
						// history state / update state
						history.pushState(url, null, url);
					});
			}
		}
	}, false);

}
export default pageNavigation;