<?php
if ( ! function_exists( '_recaptcha_qsencode' ) ) {
	require_once( rtrim( dirname( __FILE__ ), '/' ) . '/recaptchalib.php' );
}

header( "Content-type: application/json" );
$_data = Contact_Form::get_instance_data( @$_POST['instance'] );

if ( 'on' == $_data['contact_form_captcha'] ) {
	$resp   = null;
	$secret = get_option( 'wpmu_contact_form_private_key' );
	if ( empty( $secret ) ) {
		//Send error
		wp_send_json_error();
	}
	//Check version of recaptcha being used
	$version   = get_option( 'wpmu_contact_form_recaptcha_version', 'old' );
	$reCaptcha = new ReCaptcha( $secret );
	if ( $version == 'old' ) {
		$resp = $reCaptcha->check_answer(
			$secret,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]
		);
	} else {
		$response = ! empty( $_POST["g-recaptcha-response"] ) ? $_POST["g-recaptcha-response"] : '';
		$resp     = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$response
		);
	}
	if ( $resp->success ) {
		$resp->is_valid = 1;
	}
}

if ( empty( $_POST ) ) {
	return;
}
$email   = ! empty( $_POST['email'] ) ? $_POST['email'] : '';
$subject = ! empty( $_POST['subject'] ) ? cw_validate_subject( stripslashes( $_POST['subject'] ) ) : '';
$message = ! empty( $_POST['message'] ) ? stripslashes( $_POST['message'] ) : '';

$error = '';

if ( ! $subject ) {
	$error .= '<p>' . __( 'Please enter a subject.', 'contact_widget' ) . '</p>';
}

if ( ! $email ) {
	$error .= '<p>' . __( 'Please enter an e-mail address.', 'contact_widget' ) . '</p>';
}

if ( $email && ! cw_validate_email( $email ) ) {
	$error .= '<p>' . __( 'Please enter a valid e-mail address.', 'contact_widget' ) . '</p>';
}

/**
 * Validate email address
 *
 * @param $email
 *
 * @return bool|mixed
 */
function cw_validate_email( $email ) {

	if ( function_exists( 'filter_var' ) && defined( 'FILTER_VALIDATE_EMAIL' ) ) {
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

	$regex = '/([a-z0-9_.-]+)' .
	         '@' .
	         '([a-z0-9.-]+){1,255}' .
	         '.' .
	         "([a-z]+){2,10}/i";

	if ( $email == '' ) {
		return false;
	} else {
		$eregi = preg_replace( $regex, '', $email );
	}

	return empty( $eregi ) ? true : false;
}

function cw_validate_subject( $subject ) {
	return str_ireplace( array( "\r", "\n", "%0a", "%0d" ), '', stripslashes( $subject ) );
}

if ( $_data['contact_form_captcha'] == 'on' ) {
	if ( empty( $resp->is_valid ) || ! $resp->is_valid ) {
		$error .= '<p>' . __( 'Please enter a valid captcha.', 'contact_widget' ) . '</p>';
	}
}

$error = apply_filters( 'contact_form-validate_fields', $error, $_data );

//If any errors, return
if ( $error ) {
	echo json_encode( array(
		"status"  => 0,
		"message" => $error
	) );
}

if ( ! $error ) {
	$custom_email = trim( $_data['contact_form_admin_email'] );
	$admin_email  = $custom_email ? $custom_email : get_option( 'admin_email' );
	$headers      = 'MIME-Version: 1.0\r\n';
	$headers .= 'Content-type: text/html; charset=utf-8\r\n';

	if ( $_data['contact_form_generic_from'] == 'on' ) {
		$hostname = preg_replace( '/^www\./', '', parse_url( site_url(), PHP_URL_HOST ) );
		$user     = trim( $_data['contact_form_generic_from_user'] );
		$user     = $user ? preg_replace( '/[^-a-z0-9_.]/', '', strtolower( $user ) ) : 'noreply';
		$from     = "{$user}@{$hostname}";
		$reply_to = ( $_data['contact_form_generic_from_reply_to'] == 'on' ) ? $email : $from;
		if ( $_data['contact_form_generic_from_body'] == 'on' ) {
			$message = "From: {$email}\n<br />\n{$message}";
		}
	} else {
		$reply_to = $from = $email;
	}

	$headers .= "To: Site admin <{$admin_email}>\r\n";
	$headers .= "From: <{$from}>\r\n";
	$headers .= "Reply-To: <{$reply_to}>\r\n";

	$headers = apply_filters( 'contact_form-mail_headers', $headers );
	$subject = apply_filters( 'contact_form-mail_subject', $subject );
	$message = apply_filters( 'contact_form-mail_message', $message );

	$mail = wp_mail( $admin_email, $subject, $message, $headers );
	if ( $mail ) {
		$success = @$_data['contact_form_success_message'] ? '<p>' . $_data['contact_form_success_message'] . '</p>' : '<p>' . __( 'Your message has been sent. Thank you!', 'contact_widget' ) . '</p>';
		echo json_encode( array(
			"status"  => 1,
			"message" => $success,
		) );
	} else {
		echo json_encode( array(
			"status"  => 0,
			"message" => '<p>' . __( 'Mail not sent', 'contact_widget' ) . '</p>'
		) );
	}
}

?>