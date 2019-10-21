const accordions = () => {

	let $accordionItem    = $('body .accordion__item') || '';
	let $accordionLabel   = $('body .accordion__label') || '';
	
	if ( $accordionItem.length ) {

		$accordionLabel.off('click').on('click', (e) => {

			let $item             = $(e.currentTarget.parentNode);
			let $accordionContent = $item.find('.accordion__content');

			// all can be opened
			$accordionContent.slideToggle();
			$item.toggleClass('is-active');
			
			// // only one can be opened
			// $('.accordion li').removeClass('is-active');
			// $('.accordion li').not($item).find('.accordion__content').slideUp({
			// 	easing: 'swing'
			// });
			// $accordionContent.slideDown({
			// 	easing: 'swing'
			// });
			// $item.addClass('is-active');
			// 

		});

		var urlParams = new URLSearchParams(window.location.search);

		if ( urlParams.has('accordion') ) {
			$('[data-accordion-item="'+ urlParams.get('accordion') +'"]').trigger('click');
		}
	}
}

export default accordions;