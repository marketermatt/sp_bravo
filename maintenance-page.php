<?php 
/* Template Name: Maintenance Page */

// redirect back to homepage if maintenance is not enabled
if ( sp_get_option( 'maintenance_enable', 'is', 'off' )  || ! sp_get_option( 'maintenance_enable', 'isset' ) ) {
	wp_safe_redirect( home_url() );
	exit;	
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js <?php echo sp_get_browser_agent();?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
// check design
if ( sp_get_option( 'maintenance_design', 'is', 'theme default' ) ) { ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() . '/css/theme-maintenance-styles.css'; ?>" />
<?php } ?>
<script type="text/javascript">
var days = '<?php esc_js( _e( 'Days', 'sp-theme' ) ); ?>';
var hours = '<?php esc_js( _e( 'Hours', 'sp-theme' ) ); ?>';
var minutes = '<?php esc_js( _e( 'Minutes', 'sp-theme' ) ); ?>';
var seconds = '<?php esc_js( _e( 'Seconds', 'sp-theme' ) ); ?>';
</script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js?ver=1.10.2'></script>
<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/maintenance.min.js?ver=3.0'></script>
<?php
// check if mobile ready is enabled
if ( sp_get_option( 'mobile_ready' ) ) {
	// check if mobile zoom is enabled
	if ( sp_get_option( 'mobile_zoom' ) ) { 
	?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php 
	} else { 
	?>
<meta name="viewport" content="width=device-width, intital-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php 
	} 
} // end mobile ready check

$nonce = isset( $_POST['_sp_maintenance_submit_email_nonce'] ) ? sanitize_text_field( $_POST['_sp_maintenance_submit_email_nonce'] ) : '';
if ( wp_verify_nonce( $nonce, 'sp_maintenance_submit_email' ) && isset( $_POST ) && isset( $_POST['submit_form'] ) && isset( $_POST['email'] ) && ! empty( $_POST['email'] )  ) {
	$email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$admin_email = apply_filters( 'sp_maintenance_notification_admin_email', get_bloginfo( 'admin_email' ) );

	$message = '';

	$to = $admin_email;
	$subject = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' ' . apply_filters( 'sp_maintenance_email_notification_subject', __( '- Maintenance Email Notification Request', 'sp-theme' ) );
	$headers = sprintf( __( '%s', 'sp-theme' ) . ' ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <' . $email . '>', 'From:' ) . PHP_EOL;

	$email_msg = '';
	$email_msg .= apply_filters( 'sp_maintenance_email_body_message', $email . sprintf( __( '%s', 'sp-theme' ), ' - has requested to be notified about the maintenance status.' ), $email );

	// if email is sent successfully
	if ( wp_mail( $to, $subject, $email_msg, $headers ) ) {
		$message .= apply_filters( 'sp_maintenance_email_notification_success_message', __( 'Thanks!  We\'ll keep you up to date with our status!', 'sp-theme' ) );
	} else {
		$message .= apply_filters( 'sp_maintenance_email_notification_fail_message', __( 'Sorry! We were unable to subscribe you at this time.  Please try again later.', 'sp-theme' ) );
	}
}
?>

</head>
<body>
	<noscript><p class="noscript"><?php _e( 'This site requires JavaScript.  Please enable it in your browser settings.', 'sp-theme' ); ?></p></noscript>

	<div id="maintenance">
		<?php while ( have_posts() ) : the_post(); ?>
            <div class="article">
            	<?php 
            	if ( sp_get_option( 'maintenance_logo', 'is', 'on' ) )
            		echo sp_display_logo(); 
            	?>

            	<?php if ( sp_get_option( 'maintenance_design', 'is', 'theme default' ) ) { ?>
                	<?php
                	if ( sp_get_option( 'maintenance_title', 'isset' ) ) {
                	?>
                		<header class="page-header">
                    		<h2 class="entry-title"><?php echo sp_get_option( 'maintenance_title' ); ?></h2>
                		</header>

                	<?php
                	}
            	} ?>

                <div class="entry-content clearfix">
            
                	<?php if ( sp_get_option( 'maintenance_countdown', 'is', 'on' ) ) { ?>
                    <div id="countdown" class="clearfix"></div>
                    <?php } ?>
                    <?php
                    if ( sp_get_option( 'maintenance_design', 'is', 'custom' ) ) {
                    ?>
                    <div class="content"><?php the_content(); ?></div><!--close text-->
                    <?php
                    }
                    ?>

                </div><!--close .entry-content-->

                <?php 
                if ( sp_get_option( 'maintenance_twitter_enable', 'is', 'on' ) ) { 
                	if ( sp_get_option( 'maintenance_twitter_account', 'isset' ) && strlen( sp_get_option( 'maintenance_twitter_account' ) ) ) { 
                	?>
                    	<p class="twitter-wrap"><a href="<?php echo sp_get_option( 'maintenance_twitter_account' ); ?>" title="<?php _e( 'Follow Us on Twitter', 'sp-theme' ); ?>" class="maintenance-twitter" target="_blank"><?php _e( 'Follow Us on Twitter', 'sp-theme' ); ?> <i class="icon-twitter" aria-hidden="true"></i></a></p>
					<?php 
					}
               	}

               	if ( sp_get_option( 'maintenance_email_notification', 'is', 'on' ) ) {
               	?>
               		<form class="email-form" action="#" method="post">
               			<p><label><?php _e( 'Submit your email to keep up to date', 'sp-theme' ); ?></label>
               				<input type="email" value="" name="email" /><br />
               				<button type="submit" name="submit_form"><?php _e( 'Send', 'sp-theme' ); ?></button>
               			</p>

               			<?php echo wp_nonce_field( 'sp_maintenance_submit_email', '_sp_maintenance_submit_email_nonce' ); ?>
               		</form>
               	<?php
               	}

               	// check if we need to display message
               	if ( isset( $message ) && ! empty( $message ) ) {
               	?>
               		<p class="message"><?php echo $message; ?></p>
               	<?php
               	}
               	?>

            </div><!--close .article-->
        <?php endwhile; // end of the loop. ?>
        
        <?php if ( sp_get_option( 'maintenance_countdown', 'is', 'on' ) ) { ?>
	        <input type="hidden" class="maintenance-datetime" value="<?php echo strlen( (string)sp_get_option( 'maintenance_datetime', 'isset' ) ) ? sp_get_option( 'maintenance_datetime' ) : '0'; ?>" />
	        <input type="hidden" class="maintenance-timezone" value="<?php echo strlen( (string)sp_get_option( 'maintenance_timezone', 'isset' ) ) ? sp_get_option( 'maintenance_timezone' ) : '0'; ?>" />
        <?php } ?>
    </div><!--close #maintenance-->	

</body>
</html>
