// alerts
const alerts = () => {
	// since announcement-bar and cookie-bar use same storage,
	// either set it to localStorage with a timestamp like ageScreen modal,
	// or leave it per session, or even just set it once and forget it via localStorage
	let $alert = $('[data-alert]') || '';
	if ( $alert ) {
		
		for (var i = 0; i < $alert.length; i++) {
			let key         = $($alert[i]).attr('data-alert');
			let sessionItem = sessionStorage.getItem(key);
			if ( !sessionItem ) {
				$($alert[i]).addClass('is-active');
			} else {
				// $($alert[i]).hide();
				$($alert[i]).show();
			}
		}

		$alert.on('click', '[data-dismiss]', (e) => {
			
			e.preventDefault();
			
			let $currentAlert = $(e.currentTarget).closest('[data-alert]');
			let key           = $currentAlert.attr('data-alert');
			
			$currentAlert.slideToggle(300, () => {
				$currentAlert.removeClass('is-active');
			});

			// set sessionStorage if data-alert has value
			// check against sessionStorage
			let sessionItem = sessionStorage.getItem(key);
			if ( !sessionItem ) {
				// Save data to sessionStorage
				sessionStorage.setItem(key, 1);
			}

		});
	}
}

export default alerts;