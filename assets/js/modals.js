const modals = () => {

	let $mfpClose = $('[data-mfp-close]');
	$mfpClose.on('click', (e) => {
		$.magnificPopup.close();
	});

	// Inline popups
	if ( $('[data-modal-trigger]').length )
	$('[data-modal-trigger]').magnificPopup({
		callbacks: {
			beforeOpen: function() {
				this.st.mainClass = this.st.el.attr('data-effect');
			},
		},
		fixedContentPos: true, // 
		removalDelay: 500, //delay removal by X to allow out-animation
		midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		closeMarkup: '<button class="mfp-close icon-close"><svg><use xlink:href="#icon-close"></use></svg></button>'
	});

}

export default modals;