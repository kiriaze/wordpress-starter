const ui = () => {

	// alerts
	if ( $('.alert').length ) {
		$('.alert').on('click', '[data-dismiss]', (e) => {
			e.preventDefault();
			// $(e.currentTarget).closest('.alert').addClass('is-hidden');
			$(e.currentTarget).closest('.alert').slideUp();
		});
	}

	// video players...
	if ( $('.video-player').length )
	$('.video-player').on('click', '[data-video-trigger]', (e) => {
		$(e.currentTarget).closest('.video-player').addClass('is-active');
	});

	// copy link function
	// used in referrals view
	if ( $('[data-copy-link]').length )
	$('[data-copy-link]').on('click', (e) => {
		e.preventDefault();
		let $temp = $('<input>');
		$('body').append($temp);
		let link = $(e.currentTarget).attr('data-copy-link');
		$temp.val(link).select();
		document.execCommand('copy');
		$temp.remove();
		$(e.currentTarget).text('Copied!');
		setTimeout( () => {
			$(e.currentTarget).text('Copy Share Link');
		}, 1500);
	});

	// toggle password visibility,
	// login form, quiz, prescription flow
	let $pwToggle   = $('.toggle-password');
	if ( $pwToggle.length ) {	
		$pwToggle.on('click', (e) => {
			let $this = $(e.currentTarget);
			let $pw   = $(e.currentTarget).next('input');
			if ( $pw.attr('type') == 'password' ) {
				$pw.attr('type', 'text');
				// show/hide svg
				$this.find('svg:first-child').hide();
				$this.find('svg:last-child').show();
			} else {
				$pw.attr('type', 'password');
				// show/hide svg
				$this.find('svg:first-child').show();
				$this.find('svg:last-child').hide();
			}
		});
	}
	// 

	// select2 dropdowns used in checkout and account
	if ( $('.country_select, .state_select').length ) {
		// Re-init select2 on dropdowns, since we can't access WC's scripts
		$('.country_select, .state_select').select2({
			placeholder: 'Pick states',
			theme: 'material'
		});
	}

	// $('b[role="presentation"]').hide();
	// $(".select2-selection__arrow")
	// 	.addClass("material-icons")
	// 	.html("arrow_drop_down");

	// accordions
	if ( $('.accordion__item').length ) {

		$('.accordion__item').on('click', (e) => {

			// all can be opened
			$(e.currentTarget).find('div').slideToggle();
			$(e.currentTarget).toggleClass('is-active');
			
			// // only one can be opened
			// $('.accordion li').removeClass('is-active').not($(e.currentTarget)).find('div').slideUp();
			// $(e.currentTarget).find('div').slideDown();
			// $(e.currentTarget).toggleClass('is-active');

		});

		var urlParams = new URLSearchParams(window.location.search);

		if ( urlParams.has('accordion') ) {
			$('[data-accordion-item="'+ urlParams.get('accordion') +'"]').trigger('click');
		}
	}


};

export default ui;