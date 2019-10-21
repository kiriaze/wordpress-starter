const cursor = () => {
	
	let timeout;
	let $cursor = document.querySelector('.cursor');

	function moveCursor(e) {
		TweenLite.to($cursor, .3, {
			css: {
				x: e.clientX,
				y: e.clientY
			}
		});
	}

	// fade out cursor within here
	document.addEventListener('mouseleave', (e) => {
		// console.log('mouse has left');
		$cursor.classList.add('is-hidden');
	});

	document.addEventListener('mousemove', (e) => {

		// timer for when user is inactive
		clearTimeout(timeout);
		timeout = setTimeout(() => {
			// console.log('move your mouse');
			$cursor.classList.add('is-hidden');
		}, 3000);

		// // hide cursor when in proximity of outside the window
		// if (
		// 	(e.clientX + 100) > document.body.clientWidth ||
		// 	(e.clientY + 100) > window.innerHeight ||
		// 	e.clientX < 100 ||
		// 	e.clientY < 100
		// ) {
		// 	$cursor.classList.add('is-hidden');
		// }
		
		$cursor.classList.remove('style-1','style-2', 'is-hidden');

		if ( e.target.matches('.foobar') ) {
		
			// console.log('over foobar');
			$cursor.classList.add('style-1');
		
		} else if ( e.target.matches('a') ) {
		
			// console.log('over anchors');
			$cursor.classList.add('style-2');
		
		}
		
		moveCursor(e);

	});

}

export default cursor;