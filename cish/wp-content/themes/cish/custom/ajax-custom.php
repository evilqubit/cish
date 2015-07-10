<?php
// Send Event Register Email
function send_event_register_email() {
	$return = array('status'=>0, 'message'=>'');

	$spamCatcher = ( isset ( $_POST['ch'] ) ) ? $_POST['ch'] : '';
	if ( !empty ($spamCatcher) ){
		$return['message'] = 'Email sent';
		die( json_encode($return) );
	}
	
	$requiredFields = array('name', 'email', 'phone', 'mobile');
	$required = array();
	$emailMessage = '';
	
	$formEmail = sanitize_email( $_POST['email'] );
	if ( !$formEmail ){
		$return['message'] = 'Please add a valid email.';
		$return['required'] = array('email');
		die ( json_encode ( $return ) );
	}
	
	foreach ($requiredFields as $requiredField){
		if ( !isset($_POST[$requiredField]) ){
			$required[] = $requiredField;
		}
	}
	
	foreach ($_POST as $k=>$v){
		if ( $k != 'ch' && $k != 'action' ){
			if ( (in_array($k, $required) && trim($v) == '') ){
				$required[] = $k;
			}
			else{
				$emailMessage .= '<p><b>'.ucwords (str_replace('_',' ', $k)).'</b>: '.sanitize_text_field($v).'</p>';
			}
		}
	}
	
	if ( !empty($required) ){
		$return['message'] = 'Please fill the required fields.';
		$return['required'] = $required;
		die ( json_encode ( $return ) );
	}
	$event = array();
	$eventHasRegistration = 0;
	$eventID = ( isset($_POST['event']) ) ? intval ($_POST['event']) : 0;
	if ( $eventID > 0 ){
		$event = get_post($eventID, ARRAY_A);
		$emailMessage .= '<p><b>Event:</b>: '.$event['post_title'].'</p>';
		$eventHasRegistration = get_field('has_registration', $eventID);
	}
	if ( $eventID <= 0 || $eventHasRegistration <= 0 ){
		$return['message'] = 'This event has no registration process.';
		die ( json_encode ( $return ) );
	}
	
	$mailTo = esc_attr(get_site_option('admin_email'));
	$formName = sanitize_text_field( $_POST['name'] );
	$emailMessage .= '<p><b>Sent on</b>: '.date('d/m/Y - gA', time()).'</p>';
	$emailSubject = 'Event Register Email from '.$formName;
	$emailHeaders = 'From: CISH Notification <no-reply@mysite.com>\r\n';
	
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$email = wp_mail( $mailTo, $emailSubject, $emailMessage, $emailHeaders);
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	$return['status'] = 1;
	$return['message'] = 'Sent!';
	
	die ( json_encode($return) );
}

// Send Contact Email
function send_contact_email() {
	$return = array('status'=>0, 'message'=>'');

	$spamCatcher = ( isset ( $_POST['ch'] ) ) ? $_POST['ch'] : '';
	if ( !empty ($spamCatcher) ){
		$return['message'] = 'Email sent';
		die( json_encode($return) );
	}
	
	$formName = sanitize_text_field( $_POST['name'] );
	$contact_email = sanitize_text_field( $_POST['email'] );
	$contact_mobile = sanitize_email( $_POST['mobile'] );
	$contact_phone = sanitize_email( $_POST['phone'] );
	$contact_comment = sanitize_text_field( $_POST['comment'] );
	
	$requiredFields = array('name', 'email', 'comment');
	$required = array();
	$emailMessage = '';
	
	foreach ($requiredFields as $requiredField){
		if ( !isset($_POST[$requiredField]) ){
			$required[] = $requiredField;
		}
	}
	
	foreach ($_POST as $k=>$v){
		if ( $k != 'ch' && $k != 'action' ){
			if ( (in_array($k, $required) && trim($v) == '') ){
				$required[] = $k;
			}
			else{
				$emailMessage .= '<p><b>'.ucwords (str_replace('_',' ', $k)).'</b>: '.sanitize_text_field($v).'</p>';
			}
		}
	}
	if ( !empty($required) ){
		$return['message'] = 'Please fill the required fields.';
		$return['required'] = $required;
		die ( json_encode ( $return ) );
	}
	
	$mailTo = esc_attr(get_site_option('admin_email'));
	$emailMessage .= '<p><b>Sent on</b>: '.date('d/m/Y - gA', time()).'</p>';
	$emailSubject = 'Contact Email from '.$formName;
	$emailHeaders = 'From: CISH Notification <no-reply@mysite.com>\r\n';
	
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$email = wp_mail( $mailTo, $emailSubject, $emailMessage, $emailHeaders);
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	$return['status'] = 1;
	$return['message'] = 'Sent!';
	
	die ( json_encode($return) );
}

?>