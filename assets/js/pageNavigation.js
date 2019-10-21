const pageNavigation = () => {

	let $ajaxWrap   = document.querySelector('[data-ajax-wrap]');

	// fetch page with optional pushState update
	let fetchPage = (url, update=false) => {
		// 
		onStart();

		// wrap in animation or should we abstract
		TweenLite.to($ajaxWrap, .35, {
			opacity: 0,
			onComplete: () => {
				fetch(url)
					.then( response => response.text() )
					.then( body => {

						let content = parseData(body, url);
						injectContent(content);
						
						if ( update ) {
							// history state / update state
							history.pushState(url, null, url);
						}

					});
			}
		});
	}

	// abstracted method
	let onStart = () => {
		window.scroll({
			top: 0,
			left: 0
		});
	}

	let onComplete = () => {
		// 
		setTimeout( () => {
			// run page transitions
			TweenLite.to($ajaxWrap, .35, {
				opacity: 1
			});
		}, 150);
	}

	let injectContent = (content) => {

		$ajaxWrap.innerHTML = content.querySelector('[data-ajax-wrap]').innerHTML;
		document.title      = content.querySelector('title').innerText;

		// set doc height
		document.body.style.height = $ajaxWrap.clientHeight + 'px';

		// 
		onComplete();

	}

	let parseData = (data, url) => {
		// grab content
		const parser       = new DOMParser();
		const htmlDocument = parser.parseFromString(data, 'text/html');
		const content      = htmlDocument.documentElement;
		return content;
	}

	// ajax page navigation / content
	window.addEventListener('popstate', (e) => {
		// e.state is equal to the last url of item we clicked
		// console.log(e.target.location.href, e.state);
		// since it doesn't work page loads, navigates, then goes back,
		// we'll use e.target.location.href
		// if ( e.state !== null ) {
		if ( e.target.location.href !== null ) {
			fetchPage(e.target.location.href);
		}
	});

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
				fetchPage(url, true);
			}
		}
	}, false);

}
export default pageNavigation;