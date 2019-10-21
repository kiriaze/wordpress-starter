import 'parsleyjs';
const forms = () => {
	
	let $form = $('body [data-form]') || '';
	
	if ( ! $form.length ) return;

	$form.on('submit', (e) => {		
		
		e.preventDefault();
		
		let formData = new FormData(e.currentTarget);
		formData.append('form', e.currentTarget.dataset.form);
		formData.append('action', 'gform_entry');
		
		// // log each data obj by key/val
		// for (let pair of formData.entries()) {
		// 	console.log(pair[0]+ ', ' + pair[1]); 
		// }
		// return;

		if ( !$(e.currentTarget).parsley({
			trigger:      'change',
			successClass: 'has-success',
			errorClass:   'has-error',
			classHandler: function (el) {
				return el.$element.closest('.form-group'); // add error class to parent
			},
			errorsWrapper: '<div class="error-message"></div>',
			errorTemplate: '<span></span>',
		}).validate() ) return;

		$.ajax({
			type: 'POST',
			data: formData,
			url: adminAjax.ajax_url,
			contentType: false,
			processData: false,
			success: (response) => {
				
				response = JSON.parse(response);
				
				console.log(response);

				if ( response.is_valid ) {
					e.currentTarget.innerHTML = `<div class="response">${response['confirmation_message']}</div>`;
					e.currentTarget.querySelector('.response').style.display = 'block';
				}
			},
			error: (error) => {
				console.log(error);
			}
		});
	});

}

export default forms;