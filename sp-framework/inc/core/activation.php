<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * theme activation functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/////////////////////////////////////////////////////
// load default theme settings
/////////////////////////////////////////////////////
add_action( 'after_switch_theme', '_sp_load_defaults' );

// function is run before init
if ( ! function_exists( '_sp_load_defaults' ) ) {

	/**
	 * function that loads default theme settings
	 *
	 * @access private
	 * @since 3.0
	 * @return boolean true
	 */
	function _sp_load_defaults() { 
		global $spthemeinfo;
		
		// get the theme settings data
		$data_exists = get_option( $spthemeinfo->Name . '_sp_data' );

		// if it does not exist then proceed
		if ( ! $data_exists ) {
			sp_init_db();

			sp_update_init_options_function();

			// clear the widgets area
			$widgets = get_option( 'sidebars_widgets' );

			unset( $widgets['site-top-widget'] );
			unset( $widgets['site-bottom-widget'] );
			unset( $widgets['page-top-widget'] );
			unset( $widgets['page-bottom-widget'] );
			unset( $widgets['sidebar-left-sitewide'] );
			unset( $widgets['sidebar-right-sitewide'] );	

			update_option( 'sidebars_widgets', $widgets );	

			// setup default values for theme mods
			_sp_init_theme_mods();				
		}

		// Activate the plugin if necessary
		if ( get_option( THEME_NAME . '_layerslider_activated', '0' ) == '0' ) {

			// Run activation script
			layerslider_activation_scripts();

			// Save a flag that it is activated, so this won't run again
			update_option( THEME_NAME . '_layerslider_activated', '1' );
		}

		return true;
	}
}