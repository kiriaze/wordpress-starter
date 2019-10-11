const tabs = () => {
	let $tabs        = document.querySelector('.tabs');
	if ( !$tabs ) return;
	let $tabNavItems = $tabs.querySelectorAll('[data-tab-item]');
	let $tabContents = $tabs.querySelectorAll('[data-tab-content]');

	// dispatch event
	// attach listeners to this event
	let tabs = new CustomEvent('tabUpdates', {
		'detail': {
			'desc': 'Tab panel is active.'
		}
	});

	for ( let $item of $tabNavItems ) {
		$item.addEventListener('click', (e) => {
			let tab = e.currentTarget.dataset.tabItem;
			let tabContent = document.querySelector(`[data-tab-content=${tab}]`);
			
			// console.log(tab);
			[...$tabNavItems].map(x => x.classList.remove('is-active'));
			e.currentTarget.classList.add('is-active');
			if ( tabContent ) {
				[...$tabContents].map(x => x.classList.remove('is-active'));
				tabContent.classList.add('is-active');
				
				// dispatch event
				document.dispatchEvent(tabs);
			}

		});
	}
}

export default tabs;