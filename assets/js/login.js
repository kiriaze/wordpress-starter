// accept hot module reloading
if ( module.hot ) {
	module.hot.accept();
}

// 
import '../scss/login.scss';

// 
import 'jquery';

$(document).ready( (e)=> {
	$('#user_login').attr('placeholder', 'Username');
	$('#user_pass').attr('placeholder', 'Password');
});
