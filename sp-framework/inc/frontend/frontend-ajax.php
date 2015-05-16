<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * frontend ajax functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

// add the functions to the ajax action hook
if ( is_admin() ) {
	add_action( 'wp_ajax_sp_submit_testimonial_ajax', 'sp_submit_testimonial_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_testimonial_ajax', 'sp_submit_testimonial_ajax' );

	add_action( 'wp_ajax_sp_submit_contact_form_ajax', 'sp_submit_contact_form_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_contact_form_ajax', 'sp_submit_contact_form_ajax' );	
	
	add_action( 'wp_ajax_sp_submit_register_form_ajax', 'sp_submit_register_form_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_register_form_ajax', 'sp_submit_register_form_ajax' );
	
	add_action( 'wp_ajax_sp_submit_login_form_ajax', 'sp_submit_login_form_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_login_form_ajax', 'sp_submit_login_form_ajax' );		
	
	add_action( 'wp_ajax_sp_submit_login_forgot_form_ajax', 'sp_submit_login_forgot_form_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_login_forgot_form_ajax', 'sp_submit_login_forgot_form_ajax' );	

	add_action( 'wp_ajax_sp_submit_change_password_form_ajax', 'sp_submit_change_password_form_ajax' );
	add_action( 'wp_ajax_nopriv_sp_submit_change_password_form_ajax', 'sp_submit_change_password_form_ajax' );

	add_action( 'wp_ajax_sp_product_share_ajax', 'sp_product_share_ajax' );
	add_action( 'wp_ajax_nopriv_sp_product_share_ajax', 'sp_product_share_ajax' );		
}

/**
 * Function that process the submitting of testimonials
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_submit_testimonial_ajax() {

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		wp_die( 'error' );
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_testimonial_submit_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_testimonial_submit' ) )
	     wp_die( 'error' );

	// build the options
	$post = array(
		'post_content'	=> $form_data['testimonial'],
		'post_status'	=> 'pending',
		'post_title'	=> __( 'Testimonial from', 'sp-theme' ) . ' ' . $form_data['testimonial_submitter_name'],
		'post_type'		=> 'sp-testimonial'
	);

	// create post and return post id
	$post_id = wp_insert_post( $post, false );

	// if post is created
	if ( $post_id ) {
		// update post meta
		update_post_meta( $post_id, '_sp_testimonial_submitter_name', $form_data['testimonial_submitter_name'] );
		update_post_meta( $post_id, '_sp_testimonial_submitter_email', $form_data['testimonial_submitter_email'] );

		// clear cache
		_sp_clear_testimonial_pending_notice_cache();

		$output = '';
		$output .= '<p class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . __( 'Testimonial Sent. Thank you!', 'sp-theme' ) . '</p>' . PHP_EOL;

		echo $output;
	}
	exit;
}

/**
 * Function that process the submitting of contact forms
 *
 * @access public
 * @since 3.0
 * @return boolean true/false
 */
function sp_submit_contact_form_ajax() {

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_submit_contact_form_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_contact_form' ) )
	     die ( 'error' );

	if ( isset( $form_data['captcha_code'] ) ) {
		require_once( THEME_PATH . 'securimage/securimage.php' );

		// check captcha
		$securimage = new Securimage();

		if ( $securimage->check( $form_data['captcha_code'] ) === false ) {
			$output = array( 'sent' => false, 'redirect' => '', 'captcha' => apply_filters( 'sp_sc_contact_form_captcha_msg', __( 'Sorry, you must enter the correct captcha code as you see in the image.', 'sp-theme' ) ) );
			echo json_encode( $output );
			exit;
		}
	}
	
	// remove non form related items
	unset( $form_data['_sp_submit_contact_form_nonce'] );
	unset( $form_data['_wp_http_referer'] );
	unset( $form_data['captcha_code'] );

	$cf_id = absint( $form_data['cf_id'] );

	// get the list of saved post meta
	$email_to		= get_post_meta( $cf_id, '_sp_contact_form_email_to', true );
	$email_subject	= get_post_meta( $cf_id, '_sp_contact_form_email_subject', true );
	$redirect		= get_post_meta( $cf_id, '_sp_contact_form_redirect', true );
	$redirect_url	= get_post_meta( $cf_id, '_sp_contact_form_redirect_url', true );
	$header_text	= get_post_meta( $cf_id, '_sp_contact_form_header_text', true );
	$email_template	= get_post_meta( $cf_id, '_sp_contact_form_email_template', true );	

	if ( isset( $form_data['email'] ) && ! empty( $form_data['email'] ) ) {
		$from_email = sanitize_text_field( $form_data['email'] );
	} else {
		$from_email = $email_to;
	}	

	if ( ! isset( $email_subject ) || empty( $email_subject ) && isset( $form_data['subject'] ) && ! empty( $form_data['subject'] ) ) {
		$email_subject = sanitize_text_field( $form_data['subject'] );
	}
	
	// loop through submitted data
	foreach( $form_data as $k => $v ) {

		if ( is_array( $v ) ) {
			$items = implode( ',', $v );
			$email_template = str_replace( '[' . $k . ']', sanitize_text_field( $items ), $email_template );
		} else {
			$email_template = str_replace( '[' . $k . ']', sanitize_text_field( $v ), $email_template );
		}
	}

	// clean up the email template of unique tags that were not replaced
	$email_template = preg_replace( '/\[\w+]/', __( '[no input from user]', 'sp-theme' ), stripslashes( $email_template ) );

    // build email
    $to = $email_to;
    $subject = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' | ' . $header_text . ' | ' . $email_subject;
    $message = $email_template . PHP_EOL;
    
    $headers = 'From: ' . $from_email . ' <' . $from_email . '>';  

    // if mail was successfully sent
    if ( wp_mail( $to, $subject, $message, $headers ) ) {
    	// check if redirect is on
    	if ( isset( $redirect ) && $redirect === 'on' && isset( $redirect_url ) && ! empty( $redirect_url ) ) {
        	$url = wp_nonce_url( $redirect_url, 'sp-contact-form-redirect' );
        	$output = array( 'sent' => true, 'redirect' => $url );
    	} else {
    		$output = array( 'sent' => true, 'redirect' => '' );
    	}
    } else {
    	$output = array( 'sent' => false, 'redirect' => '' );
    }

    echo json_encode( $output );
    exit;
}

/**
 * Function that process the submitting of register forms
 *
 * @access public
 * @since 3.0
 * @return boolean true/false
 */
function sp_submit_register_form_ajax() {

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_submit_register_form_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_register_form' ) )
	     die ( 'error' );

	$error_msg = array();
	$proceed = true;

	// if username exists log
	if ( isset( $form_data['username'] ) && $form_data['username'] !== '' ) {
		// if username too short
		if ( strlen( $form_data['username'] ) < 3 ) {
			$error_msg['username'] = apply_filters( 'sp_sc_register_form_username_too_short_msg', __( 'Sorry, your username is too short.  Please enter at least 3 characters.', 'sp-theme' ) );

			$proceed = false;			
		}

		// if not a valid username
		if ( username_exists( $form_data['username'] ) ) {
			$error_msg['username'] = apply_filters( 'sp_sc_register_form_non_valid_username_msg', __( 'Sorry, that username already exists.', 'sp-theme' ) );

			$proceed = false;
		}
	}

	// if email is not valid log
	if ( isset( $form_data['email'] ) && $form_data['email'] !== '' ) {
		// if not a valid email
		if ( ! is_email( $form_data['email'] ) ) {
			$error_msg['email'] = apply_filters( 'sp_sc_register_form_non_valid_email_msg', __( 'Sorry, you must enter a valid email.', 'sp-theme' ) );

			$proceed = false;
		}
	}

	// if not confirm email log
	if ( isset( $form_data['confirm_email'] ) && $form_data['confirm_email'] !== '' ) {
		if( $form_data['email'] != $form_data['confirm_email'] ) {
			$error_msg['confirm_email'] = apply_filters( 'sp_sc_register_form_email_not_confirmed_msg', __( 'Sorry, your email does not match.', 'sp-theme' ) );

			$proceed = false;
		}
	}

	// if email exists
	if ( isset( $form_data['email'] ) && $form_data['email'] !== '' ) {
		// if email exists log
		if ( email_exists( $form_data['email'] ) ) {
			$error_msg['email'] = apply_filters( 'sp_sc_register_form_email_exists_msg', __( 'Sorry, this email address already exists.', 'sp-theme' ) );

			$proceed = false;
		}
	}

	// check captcha
	if ( isset( $form_data['captcha_code'] ) ) {
		require_once( THEME_PATH . 'securimage/securimage.php' );

		// check captcha
		$securimage = new Securimage();

		if ( $securimage->check( $form_data['captcha_code'] ) === false ) {
			$error_msg['captcha'] = apply_filters( 'sp_sc_register_form_captcha_msg', __( 'Sorry, you must enter the correct captcha code as you see in the image.', 'sp-theme' ) );

			$proceed = false;
		}
	}
	
	if ( $proceed ) {
		// if all checks passed proceed to create user
		$random_password = wp_generate_password();
		$user_id = wp_create_user( $form_data['username'], $random_password, $form_data['email'] );

		// proceed if user created
		if ( is_int( $user_id ) ) {
			// update firstname if set
			if ( isset( $form_data['firstname'] ) && ! empty( $form_data['firstname'] ) )
				update_user_meta( $user_id, 'first_name', $form_data['firstname'] );

			// update lastname if set
			if ( isset( $form_data['lastname'] ) && ! empty( $form_data['lastname'] ) )
				update_user_meta( $user_id, 'last_name', $form_data['lastname'] );
		
			// build email
			$to = $form_data['email'];
			$subject = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' ' . __( 'Registration', 'sp-theme' );
			$message = __( 'Thank you for registering!', 'sp-theme' ) . PHP_EOL . PHP_EOL;
			$message .= '=========================================' . PHP_EOL;
			$message .= __( 'Username:', 'sp-theme' ) . ' ' . $form_data['username'] . PHP_EOL;
			$message .= __( 'Password:', 'sp-theme' ) . ' ' . $random_password . PHP_EOL;
			$message .= '=========================================' . PHP_EOL . PHP_EOL;
			$message .= __( 'Please keep this email in a safe place.', 'sp-theme' ) . PHP_EOL;

			// apply user filters
			$subject = apply_filters( 'sp_sc_register_form_email_subject', $subject, get_bloginfo( 'name' ) );
			$message = apply_filters( 'sp_sc_register_form_email_message', $message, $form_data['username'], $random_password );

			// convert to proper email format
			$email = str_replace( '*', '@', $form_data['from_email'] );

			$headers = sprintf( __( '%s', 'sp-theme' ) . ' ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <' . $email . '>', 'From:' ) . PHP_EOL;

			// if email sent successfully
			if ( wp_mail( $to, $subject, $message, $headers ) ) {
				$output = array( 'success_msg' => apply_filters( 'sp_sc_register_form_success_msg', __( 'Thank you for registering!  Please check your email for login credentials.', 'sp-theme' ) ) );
				echo json_encode( $output );
				exit;			
			} else {
				$output = array( 'error_msg' => apply_filters( 'sp_sc_register_form_create_failed_msg', __( 'Sorry, we cannot perform your request at this time.  Please try back later.', 'sp-theme' ) ) );
				echo json_encode( $output );
				exit;
			}

		} else {
			$output = array( 'error_msg' => apply_filters( 'sp_sc_register_form_create_failed_msg', __( 'Sorry, we cannot perform your request at this time.  Please try back later.', 'sp-theme' ) ) );
			echo json_encode( $output );
			exit;		
		}
	} else {
		echo json_encode( array( 'error_msg' => $error_msg ) );
		exit;
	}
}

/**
 * Function that process the submitting of login forms
 *
 * @access public
 * @since 3.0
 * @return boolean true/false
 */
function sp_submit_login_form_ajax() {

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_submit_login_form_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_login_form' ) )
	     die ( 'error' );

	$msg = '';
	$login = false;
	$redirect = '';
	$credentials = array();
	$credentials['user_login'] = $form_data['username'];
	$credentials['user_password'] = $form_data['password'];

	if ( isset( $form_data['rememberme'] ) && ! empty( $form_data['rememberme'] ) )
		$credentials['remember'] = true;

	$user = wp_signon( $credentials, false );

	// if login error
	if ( is_wp_error( $user ) ) {
		$msg = apply_filters( 'sp_sc_login_form_failed_msg', __( 'Sorry, your credentials do not match our system!', 'sp-theme' ) );
		
		$login = false;

	} else {
		// check redirect
		if ( isset( $form_data['redirect_to'] ) && ! empty( $form_data['redirect_to'] ) ) {
			$redirect = $form_data['redirect_to'];	

			$login = true;
		} else {
			$msg = apply_filters( 'sp_sc_login_form_success_msg', __( 'You are now logged in!', 'sp-theme' ) );	

			$login = true;
		}
	}

	echo json_encode( array( 'msg' => $msg, 'login' => $login, 'redirect' => $redirect ) );
	exit;
}

/**
 * Function that process the submitting of login forms
 *
 * @access public
 * @since 3.0
 * @return boolean true/false
 */
function sp_submit_login_forgot_form_ajax() {

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_submit_login_forgot_form_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_login_forgot_form' ) )
	     die ( 'error' );

	global $wpdb, $current_site;

	$msg = '';
	$sent = false;

	if ( ! isset( $form_data['user_login'] ) || empty( $form_data['user_login'] ) ) {
		$msg = apply_filters( 'sp_sc_login_forgot_form_empty', __( 'Please fill in your username or email.', 'sp-theme' ) );

	} elseif ( strpos( $form_data['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $form_data['user_login'] ) );

		if ( empty( $user_data ) )
			$msg = apply_filters( 'sp_sc_login_forgot_form_invalid', __( 'Sorry we can\'t find your credentials in our system.  Please contact us!', 'sp-theme' ) );
	} else {
		$login = trim( $form_data['user_login'] );
		$user_data = get_user_by( 'login', $login );
	}

	do_action( 'lostpassword_post' );

	if ( ! $user_data || ! empty( $msg ) ) {
		$msg = apply_filters( 'sp_sc_login_forgot_form_invalid', __( 'Sorry we can\'t find your credentials in our system.  Please contact us!', 'sp-theme' ) );
	}

	// if no msg set proceed
	if ( empty( $msg ) ) {

		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

		do_action( 'retrieve_password', $user_login );

		$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

		if ( ! $allow )
			$msg = apply_filters( 'sp_sc_login_forgot_form_not_allow', __( 'Sorry, password reset is not allowed for this user.', 'sp-theme' ) );

		//$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );

		// clear out previous keys
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $user_login ) );

		// Generate something random for a key...
		$key = wp_generate_password( 20, false );

		// hash the key
		$hash_key = wp_hash_password( $key );

		do_action( 'retrieve_password_key', $user_login, $key, $hash_key );
		
		// Now insert the new md5 key into the db
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hash_key ), array( 'user_login' => $user_login ) );

		// construct email
		$message = __( 'Someone requested that the password be reset for the following account:', 'sp-theme' ) . PHP_EOL . PHP_EOL;
		$message .= home_url( '/' ) . PHP_EOL . PHP_EOL;
		$message .= sprintf( __( 'Username: %s', 'sp-theme' ), $user_login ) . PHP_EOL . PHP_EOL;
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'sp-theme' ) . PHP_EOL . PHP_EOL;
		$message .= __( 'To reset your password, visit the following address:', 'sp-theme' ) . PHP_EOL . PHP_EOL;
		$message .= '<' . home_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . '>' . PHP_EOL;

		if ( is_multisite() )
			$blogname = $GLOBALS['current_site']->site_name;
		else
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

		$title = sprintf( __( '[%s] Password Reset', 'sp-theme' ), $blogname );

		$title = apply_filters( 'retrieve_password_title', $title );
		$message = apply_filters( 'retrieve_password_message', $message, $key );

		if ( $message && ! wp_mail( $user_email, $title, $message ) ) {
			$msg = apply_filters( 'sp_sc_login_forgot_form_send_failed', __( 'Sorry, this email could not be sent!', 'sp-theme' ) );
		} else {
			$msg = apply_filters( 'sp_sc_login_forgot_form_success', __( 'Email has been sent!  Please check your email for further instructions.', 'sp-theme' ) );

			$sent = true;
		}
	}

	echo json_encode( array( 'sent' => $sent, 'msg' => $msg ) );
	exit;
}

/**
 * Function that shows share items ajax
 *
 * @access public
 * @since 3.0
 * @return html $output | social share buttons html
 */
function sp_product_share_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$product_id = absint( $_POST['product_id'] );

	$output = '';

	$output .= sp_social_media_share_buttons( $product_id );

	echo $output;
	exit;
}

/**
 * Function that shows share items ajax
 *
 * @access public
 * @since 3.0
 * @return html $output | social share buttons html
 */
function sp_submit_change_password_form_ajax() {
	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_sp_submit_change_password_form_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_change_password_form' ) )
	     die ( 'error' );

	global $current_user;

	$current_user = wp_get_current_user();

	$error_msg = array();
	$success_msg = '';
	$proceed = true;

	// if not all fields populated don't proceed
	if ( empty( $form_data['current_password'] ) || empty( $form_data['new_password'] ) || empty( $form_data['confirm_password'] ) ) {
		exit;
	}

	// check if current password is correct
	if ( ! wp_check_password( $form_data['current_password'], $current_user->user_pass, $current_user->ID ) ) {
		$error_msg['current_password'] = apply_filters( 'sp_sc_change_password_form_wrong_current_pass_msg', __( 'Sorry, you entered the wrong current password.', 'sp-theme' ) );

		$proceed = false;
	}

	// check if password needs to be strong
	if ( isset( $form_data['strong_password'] ) && $form_data['strong_password'] === 'true' ) {
		$error_msg['new_password'] = '';

		if ( strlen( $form_data['new_password'] ) < 8 ) {
			if ( ! empty( $error_msg['new_password'] ) )
				$sep = '<br />';
			else
				$sep = '';

			$error_msg['new_password'] .= $sep . apply_filters( 'sp_sc_change_password_form_strong_pass_length_msg', __( 'Sorry, your password needs to contain at least 8 characters.', 'sp-theme' ) );

			$proceed = false;
		}

		if ( false == preg_match( '/[a-zA-Z]/', $form_data['new_password'] ) ) {
			if ( ! empty( $error_msg['new_password'] ) )
				$sep = '<br />';
			else
				$sep = '';

			$error_msg['new_password'] .= $sep . apply_filters( 'sp_sc_change_password_form_strong_pass_uppercase_msg', __( 'Sorry, your password needs to contain both upper and lower case letters.', 'sp-theme' ) );

			$proceed = false;
		}

		if ( false == preg_match( '/[0-9]/', $form_data['new_password'] ) ) {
			if ( ! empty( $error_msg['new_password'] ) )
				$sep = '<br />';
			else
				$sep = '';

			$error_msg['new_password'] .= $sep . apply_filters( 'sp_sc_change_password_form_strong_pass_numbers_msg', __( 'Sorry, your password needs to contain at least one number.', 'sp-theme' ) );

			$proceed = false;
		}	

		if ( false == preg_match( '#[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\[\]\|\:\;\<\>\.\?\/\\\\]+#', $form_data['new_password'] ) ) {
			if ( ! empty( $error_msg['new_password'] ) )
				$sep = '<br />';
			else
				$sep = '';

			$error_msg['new_password'] .= $sep . apply_filters( 'sp_sc_change_password_form_strong_pass_numbers_msg', __( 'Sorry, your password needs to contain at least one special character such as "!, @, #, $".', 'sp-theme' ) );

			$proceed = false;
		}

		// if no errors unset new password
		if ( empty( $error_msg['new_password'] ) )
			unset( $error_msg['new_password'] );				
	}

	// if new password is not confirmed
	if( $form_data['new_password'] !== $form_data['confirm_password'] ) {
		$error_msg['confirm_password'] = apply_filters( 'sp_sc_change_password_form_password_not_confirmed_msg', __( 'Sorry, the passwords do not match.', 'sp-theme' ) );

		$proceed = false;
	}	

	// if no errors change the password
	if ( $proceed ) {
		wp_set_password( $form_data['new_password'], $current_user->ID );

		$success_msg = __( 'Your password has been changed and will be logged out.', 'sp-theme' );
	}

	echo json_encode( array( 'error_msg' => $error_msg, 'success_msg' => $success_msg ) );
	exit;	
}