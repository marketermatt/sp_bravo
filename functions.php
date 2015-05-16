<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 * if you want to add your own functions, create a child theme and add your functions in the functions.php file.
 *
 * include all the functions
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // no direct access
}

/////////////////////////////////////////////////////
// load the framework
/////////////////////////////////////////////////////
require_once( get_template_directory() . '/sp-framework/sp-framework.php' );

/////////////////////////////////////////////////////
// load theme specific functions
/////////////////////////////////////////////////////
if ( is_file( get_template_directory() . '/theme-functions/theme-functions.php' ) ) {
	require_once( get_template_directory() . '/theme-functions/theme-functions.php' );
}

/////////////////////////////////////////////////////
// load theme specific woocommerce functions
/////////////////////////////////////////////////////
if ( is_file( get_template_directory() . '/theme-functions/theme-woo-functions.php' ) && sp_woo_exists() ) {
	require_once( get_template_directory() . '/theme-functions/theme-woo-functions.php' );
}