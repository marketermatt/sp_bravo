<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * include widgets
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/////////////////////////////////////////////////////
// include promotional widget
/////////////////////////////////////////////////////
if ( file_exists( THEME_PATH . 'sp-framework/inc/widgets/promotional-widget.php' ) ) {
	require_once( THEME_PATH . 'sp-framework/inc/widgets/promotional-widget.php' );
}

/////////////////////////////////////////////////////
// include facebook widget
/////////////////////////////////////////////////////
if ( file_exists( THEME_PATH . 'sp-framework/inc/widgets/facebook-widget.php' ) ) {
	require_once( THEME_PATH . 'sp-framework/inc/widgets/facebook-widget.php' );
}

/////////////////////////////////////////////////////
// include flickr widget
/////////////////////////////////////////////////////
if ( file_exists( THEME_PATH . 'sp-framework/inc/widgets/flickr-widget.php' ) ) {
	require_once( THEME_PATH . 'sp-framework/inc/widgets/flickr-widget.php' );
}

/////////////////////////////////////////////////////
// include twitter widget - for future use
/////////////////////////////////////////////////////
if ( file_exists( THEME_PATH . 'sp-framework/inc/widgets/twitter-widget.php' ) ) {
	require_once( THEME_PATH . 'sp-framework/inc/widgets/twitter-widget.php' );
}

/////////////////////////////////////////////////////
// include blog widget
/////////////////////////////////////////////////////
if ( file_exists( THEME_PATH . 'sp-framework/inc/widgets/blog-widget.php' ) ) {
	require_once( THEME_PATH . 'sp-framework/inc/widgets/blog-widget.php' );
}

add_action( 'widgets_init', 'sp_widgets' );

/**
 * Function that registers our widgets
 * 
 * @access private
 * @since 3.0
 * @return boolean true
 */
function sp_widgets() {
	register_widget( 'SP_Promotional_Widget' );
	register_widget( 'SP_Facebook_Widget' );
	register_widget( 'SP_Flickr_Widget' );
	register_widget( 'SP_Twitter_Widget' );
	register_widget( 'SP_Blog_Widget' );

	return true;
}