<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * Maintenance Mode Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function that redirects to maintenance page
 *
 * @access private
 * @since 3.0
 * @return maintenance page
 */
function sp_maintenance() {
	if ( sp_get_option( 'maintenance_enable', 'is', 'on'  ) ) {
		$ips = array_map( 'trim', explode( "\n", sp_get_option( 'maintenance_ips' ) ) );

		if ( sp_get_option( 'maintenance_redirect_to', 'isset' ) && sp_get_option( 'maintenance_redirect_to', 'is', 'maintenance page' ) ) {
			// if user is logged in and is an admin, don't continue
			if ( is_user_logged_in() && current_user_can( 'manage_options' ) )
				return;
			
			// if page does not exist, don't continue
			if ( is_null( sp_get_page_id_from_slug( 'maintenance' ) ) )
				return;

			if ( sp_check_ip( $ips ) == false && ! is_page( 'maintenance' ) ) {
				$page_id = get_permalink( sp_get_page_id_from_slug( 'maintenance' ) );
				if ( $page_id ) {
					wp_safe_redirect( $page_id  ); 
					exit;
				}
			}
		} elseif ( sp_get_option( 'maintenance_redirect_to', 'isset' ) && sp_get_option( 'maintenance_redirect_to', 'is', 'url' ) ) {
			// if user is logged in and is an admin, don't continue
			if ( is_user_logged_in() && current_user_can( 'manage_options' ) )
				return;
			
			if ( sp_check_ip( $ips ) == false && ( sp_get_option( 'maintenance_url', 'isset' )  && sp_get_option( 'maintenance_url' ) != '' ) ) {
				wp_redirect( sp_get_option( 'maintenance_url' ) ); 
				exit; 
			}
		}
	}
}

add_action( 'template_redirect', 'sp_maintenance', 0 );

/**
 * Function that checks ips
 *
 * @access private
 * @since 3.0
 * @return boolean true | false
 */
function sp_check_ip( $ips ) {
	// if current ip matches the settings
	if ( in_array( $_SERVER['REMOTE_ADDR'], $ips ) ) 
		return true;
		
	return false;
}