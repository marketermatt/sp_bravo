<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * setup
*/

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

if ( ! isset( $content_width ) ) $content_width = 625;

if ( ! function_exists( '_sp_theme_setup' ) ) {
	/**
	 * Function that sets the configuration of the theme
	 *
	 * @access private
	 * @since 3.0
	 * @return boolean true
	 */	
	function _sp_theme_setup() {
		global $sptheme_config;

		// add theme support menus
		if ( function_exists( 'add_theme_support' ) ) {
			// add menus
			add_theme_support( 'menus' );
			
			// Add default posts and comments RSS feed links to head
			add_theme_support( 'automatic-feed-links' );
			
			// add post thumbnails to posts and pages
			add_theme_support( 'post-thumbnails' );

			// add theme support for woocommerce
			add_theme_support( 'woocommerce' );
			
			// add post format since WP 3.1
			//add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

			add_theme_support( 'title-tag' );
			
			add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );

			// add theme support for html5 markup
			add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
		}
		
		if ( apply_filters( 'sp_load_editor_styles', true ) ) {
			// add editor styles
			add_editor_style( 'css/theme-editor-styles.css' );
		}
		
		// Register custom dynamic menus
		register_nav_menus( sp_nav_menus() );

		set_post_thumbnail_size( apply_filters( 'sp_blog_list_thumbnail_width_size', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'width' ) ), apply_filters( 'sp_blog_list_thumbnail_height_size', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'height' ) ), apply_filters( 'sp_blog_list_thumbnail_crop', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'crop' ) ) );

		// show notification only if update notification setting is on
		if ( sp_get_option( 'update_notification', 'isset' ) && sp_get_option( 'update_notification' ) === 'on' ) {
			// check theme and framework versions
			add_action( 'admin_notices', 'sp_theme_notification' );
			add_action( 'admin_notices', 'sp_framework_notification' );
		}

		load_theme_textdomain( 'sp-theme', get_template_directory() . '/languages' );
		
		// check if we need to display any notices
		if ( sp_have_theme_notices() && current_user_can( 'edit_theme_options' ) ) {
			add_action( 'admin_notices', 'sp_theme_notice' );
			add_action( 'admin_init', 'sp_remove_theme_notice' );
		}

		return true;	
	} // end setup function
}

add_action( 'after_setup_theme', '_sp_theme_setup' );

/**
 * Function that checks if there are any notices to display 
 *
 * @access public
 * @since 3.0.1
 * @return html $notification
 */
function sp_have_theme_notices() {
	$file = wp_remote_get( sp_ssl_protocol() . '://splashingpixels.s3.amazonaws.com/sp-theme-notices.xml', array( 'sslverify' => false ) );
	$notices = wp_remote_retrieve_body( $file );
	
	if ( isset( $notices ) && $notices != '' ) {
		// converts the notices xml to an array
		$notices = sp_xml2array( $notices );

		// check if message is set
		if ( isset( $notices['notice']['_attr']['message'] ) && ! empty( $notices['notice']['_attr']['message'] ) )
			return true;
		else
			return false;
	}

	return false;
}

if ( ! function_exists( 'sp_nav_menus' ) ) {
	/**
	 * grab theme init settings to generate nav menu
	 * 
	 * @access public
	 * @since 3.0
	 * @return array of all listing menus in the XML config file
	 */
	function sp_nav_menus() {
		global $sptheme_config;
		
		$menu = array();
		if ( is_array( $sptheme_config['init']['nav_menu'] ) ) {
			foreach ( $sptheme_config['init']['nav_menu'] as $nav ) {
					$menu[$nav['_attr']['name']] = sprintf( __( '%s', 'sp-theme' ), $nav['_attr']['title'] );	
			}
		}
		return $menu;
	}
}