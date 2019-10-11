import 'parsleyjs';
// dropdown form select / filter
const dropDown = () => {
	let $filters = document.querySelectorAll('[data-dropdown]');
	if ( $filters ) {
		[...$filters].map($filter => {

			// for tabbing into the select tag
			$filter.nextElementSibling.addEventListener('focus', (e) => {
				$filter.classList.add('dropdown-open');
			});

			// for tabbing into the select tag
			$filter.nextElementSibling.addEventListener('blur', (e) => {
				$filter.classList.remove('dropdown-open');
			});

			$filter.addEventListener('click', (e) => {

				// close every other filter thats open
				[...$filters].map( f => {
					if ( e.currentTarget !== f )
					f.classList.remove('dropdown-open');
				});

				// if filter is closed, open it, else close it
				if ( ! e.currentTarget.classList.contains('dropdown-open') ) {
					e.currentTarget.classList.add('dropdown-open');

					// temp solution to skrolly/translate3d issues (zindexing fucked)
					e.target.closest('.form-row').style.zIndex = '1';

				} else {
					e.currentTarget.classList.remove('dropdown-open');

					// temp solution to skrolly/translate3d issues (zindexing fucked)
					e.target.closest('.form-row').style.zIndex = '';
				}

				// if an option is clicked...
				if ( e.target.matches('li') ) {
					// set filter value
					let text = e.target.innerText;
					e.currentTarget.querySelector('[data-dropdown-value]').textContent = text;

					// set value of selected option to the real select elem
					if ( $filter.hasAttribute('data-select') ) {
						let val     = e.target.dataset.selectValue || '';
						let $select = $filter.parentNode.querySelector('select');
						$select.value = val;
					}

					// close this dropdown
					e.currentTarget.classList.remove('dropdown-open');

				}

			});

		});
	}

}

export default dropDown;