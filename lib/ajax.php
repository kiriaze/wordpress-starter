<?php

/********************************************************
* MailChimp
********************************************************/

function newsletter_ajax_request() {

	if ( isset($_REQUEST) ) {

		// sp($_POST); return;

		// $list_id = '';
		// $api_key = '';
		// $email   = $_POST['email'];
		// $tags    = $_POST['tags'];
		// $source  = $_POST['source'];
		// $status  = 'subscribed'; // subscribed, cleaned, pending

		// $args = array(
		// 	'method' => 'PUT',
		// 	'headers' => array(
		// 		'Authorization' => 'Basic ' . base64_encode( 'user:'. $api_key )
		// 	),
		// 	'body' => json_encode(array(
		// 		'email_address' => $email,
		// 		'status'        => $status,
		// 		// 'tags'          => $tags,
		// 		'source'        => $source
		// 	))
		// );
		// $response = wp_remote_post( 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($email)), $args );

		// $body = json_decode( $response['body'] );
		
		// if ( $response['response']['code'] == 200 && $body->status == $status ) {
		// 	echo 'Thank you, ' . $body->merge_fields->FNAME . '. You have subscribed successfully';
		// } else {
		// 	foreach( $body->errors as $error ) {
		// 		echo '<p>Error: ' . $error->message . '</p>';
		// 	}
		// 	echo '<b>' . $response['response']['code'] . $body->title . ':</b> ' . $body->detail;
		// }

	}

	die();
}

add_action( 'wp_ajax_newsletter_ajax_request', 'newsletter_ajax_request' );
add_action( 'wp_ajax_nopriv_newsletter_ajax_request', 'newsletter_ajax_request' );