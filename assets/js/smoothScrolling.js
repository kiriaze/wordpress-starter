// usage:
// body {
// 	overflow-x: hidden;
// 	overflow-y: scroll;
// }
// .main-content {
// 	overflow: hidden;
// 	position: fixed;
// 	width: 100%;
// 	top: 0;
// 	left: 0;
// 	will-change: transform;
// 	backface-visibility: hidden;
// 	perspective: 1000;
// 	transform-style: preserve-3d;
// 	background-color: #323a44;
// }

const smoothScrolling = ($el) => {

	/////////////////////////////////////////
	// version 1:
	/////////////////////////////////////////

	// First we get the elements we need, the body and our container on which
	// we are going to apply a smooth scroll. You will always need a container
	// to apply a smooth scroll. You will not be able to apply it directly to
	// the body.
	const body = document.body;
	const main = document.querySelector('.main-content');

	// We define variables we will need later. 
	// 2 variables to store the scroll position and 2 variables to store the 
	// container position.
	let sx = 0;
	let sy = 0;

	let dx = sx;
	let dy = sy;

	// The trick is to set a height to the body to keep the browser scroll bar.
	body.style.height = main.clientHeight + 'px';

	// Then we fix our container so it won't move when the user scrolls.
	// We will move it ourself with the Linear Interpolation and translations.
	main.style.position = 'fixed';
	main.style.top      = 0;
	main.style.left     = 0;

	// We bind a scroll event to the window to watch scroll position.
	window.addEventListener('scroll', onScroll);

	window.addEventListener('resize', onResize);

	function onResize() {
		body.style.height = main.clientHeight + 'px';
	}

	function onScroll() {
		// We only update the scroll position variables
		sx = window.pageXOffset;
		sy = window.pageYOffset;
	}

	// Then we start a `requestAnimationFrame` loop. 

	window.requestAnimationFrame(render);

	function render() {
		// We calculate our container position by using our Linear Interpolation method.

		dx = lerp(dx, sx, 0.07);
		dy = lerp(dy, sy, 0.07);

		dx = Math.floor(dx * 100) / 100;
		dy = Math.floor(dy * 100) / 100;

		// Finally we translate our container to its new positions.
		// Don't forget to add a minus sign because the container needs to move in 
		// the opposite direction of the window scroll.
		main.style.transform = `translate(-${dx}px, -${dy}px)`;

		// And we loop again.
		window.requestAnimationFrame(render);
	}

	// This is our Linear Interpolation method.
	function lerp(a, b, n) {
		return (1 - n) * a + n * b;
	}





	// /////////////////////////////////////////
	// // version 2:
	// /////////////////////////////////////////

	// $el = $el ? document.querySelector($el) : document.querySelector('.main-content');

	// var html = document.documentElement;
	// var body = document.body;

	// var scroller = {
	// 	target: $el,
	// 	ease: 0.05, // <= scroll speed
	// 	endY: 0,
	// 	y: 0,
	// 	resizeRequest: 1,
	// 	scrollRequest: 0,
	// };

	// var requestId = null;

	// TweenLite.set(scroller.target, {
	// 	rotation: 0.01,
	// 	force3D: true
	// });

	// window.addEventListener('load', onLoad);

	// function onLoad() {    
	// 	updateScroller();  
	// 	window.focus();
	// 	window.addEventListener('resize', onResize);
	// 	document.addEventListener('scroll', onScroll); 
	// }

	// function updateScroller() {
		
	// 	var resized = scroller.resizeRequest > 0;
			
	// 	if (resized) {    
	// 		var height = scroller.target.clientHeight;
	// 		body.style.height = height + 'px';
	// 		scroller.resizeRequest = 0;
	// 	}
				
	// 	var scrollY = window.pageYOffset || html.scrollTop || body.scrollTop || 0;

	// 	scroller.endY = scrollY;
	// 	scroller.y += (scrollY - scroller.y) * scroller.ease;

	// 	if ( Math.abs(scrollY - scroller.y) < 0.05 || resized ) {
	// 		scroller.y = scrollY;
	// 		scroller.scrollRequest = 0;
	// 	}
		
	// 	TweenLite.set(scroller.target, { 
	// 		y: -scroller.y 
	// 	});
		
	// 	requestId = scroller.scrollRequest > 0 ? requestAnimationFrame(updateScroller) : null;
	// }

	// function onScroll() {
	// 	scroller.scrollRequest++;
	// 	if (!requestId) {
	// 		requestId = requestAnimationFrame(updateScroller);
	// 	}
	// }

	// function onResize() {
	// 	scroller.resizeRequest++;
	// 	if (!requestId) {
	// 		requestId = requestAnimationFrame(updateScroller);
	// 	}
	// }


}

export default smoothScrolling;