// textarea dynamic resizing / contact
const resizeTextarea = () => {
	let $textarea = document.querySelector('textarea');
	if ( $textarea )
	$textarea.addEventListener('input', (e) => {

		// Reset field height
		e.target.style.height = '';

		// Get the computed styles for the element
		var computed = window.getComputedStyle(e.target);

		// Calculate the height
		var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
			// + parseInt(computed.getPropertyValue('padding-top'), 10)
			+ e.target.scrollHeight
			// + parseInt(computed.getPropertyValue('padding-bottom'), 10)
			+ parseInt(computed.getPropertyValue('border-bottom-width'), 10);

		e.target.style.height = height + 'px';

	});
}

export default resizeTextarea;