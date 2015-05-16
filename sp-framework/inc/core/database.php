<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * database functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

global $sptheme_config, $spdata;

/**
 * get the theme config XML data
 *
 * @access private
 * @since 3.0
 * @return array $config the array of default settings
 */
function _sp_get_theme_config() {
	$config = get_transient( THEME_SHORTNAME . 'config' );

	// put config into transient/cache for faster performance
	if ( false === $config || empty( $config ) || $config === NULL || ! isset( $config['config'] ) ) {
		/*
		-- some servers don't allow this
		$file = wp_remote_get( get_template_directory_uri() . '/theme-config.xml', array( 'sslverify' => false ) );
		$config	= wp_remote_retrieve_body( $file );
		*/

		$config = file_get_contents( get_template_directory() . '/theme-config.xml', true );
		$config	= sp_xml2array( $config );

		// check DEV mode
		if ( SP_DEV === false )
			set_transient( THEME_SHORTNAME . 'config', $config, 60*60*24*5 );
	}

	$config	= $config['config'];
  
	return $config;
}

$sptheme_config = _sp_get_theme_config();

/**
 * save the theme data
 * 
 * @access private
 * @since 3.0
 * @param array $data the data to be saved
 * @return boolean
 */
function _sp_save_data( $data = array() ) {

	// save google font styles
	_sp_save_google_font_styles();

	// sanitize the array db insert
	array_walk_recursive( $data, 'sp_clean_multi_array' );

	// be sure to encode and serialize the data
	return update_option( THEME_NAME . '_sp_data', base64_encode( maybe_serialize( $data ) ) ); 
}

/**
 * get the theme data
 * 
 * @access private
 * @since 3.0
 * @return array $data the XML data
 */
function _sp_get_data() {
	
	// gets the data from option table
	$data = get_option( THEME_NAME . '_sp_data' ); 
	
	// decodes and unserialize for use
	$data = maybe_unserialize( base64_decode( $data ) );
	
	// check if it is an array and if there are at least 1 option record
	if ( is_array( $data ) && count( $data ) >= 1 ) {
		// loop through the options as key/value pair
		foreach ( $data as $name => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $k => $v ) {
					$data[$name][$k] = ! is_array( $v ) ? stripslashes( $v ) : $v;	
				}
			} else {
				$data[$name] = ! is_array( $value ) ? stripslashes( $value ) : $value;	
			}
		}
	} 
	return $data;	
}

$spdata = _sp_get_data();

/**
 * function to save theme mods to theme settings
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_save_theme_mods() {	
	$spdata = _sp_get_data();

	// save theme mod settings into theme data
	$theme_mods = get_theme_mods(); // array

	// save the theme data with theme mods added
	$spdata['theme_mods'] = $theme_mods;
	_sp_save_data( $spdata );

	return true;	
}

/**
 * function to set initial default values for theme mods
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_init_theme_mods() {
	global $sptheme_config;

	foreach( $sptheme_config['init']['customizer'] as $setting ) {
		set_theme_mod( $setting['_attr']['id'], $setting['_attr']['std'] );
	}

	return true;
}

/**
 * function that updates the theme mods
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_update_theme_mods() {
	$data = _sp_get_data();

	$mods = $data['theme_mods'];

	if ( is_array( $mods ) && isset( $mods ) ) {
		foreach( $mods as $mod_name => $mod_value ) {
			set_theme_mod( $mod_name, $mod_value );
		}
	}

	return true;
}

/**
 * Function that removes duplicates from array
 * 
 * @access public
 * @since 3.0
 * @param array $fonts | the fonts data to save
 * @return string
 */
function sp_remove_duplicate_fonts( $spdata_arr ) {
	$fonts = $spdata_arr['custom_fonts'];
	$fonts = array_map( 'unserialize', array_unique( array_map( 'serialize', $fonts ) ) );

	$spdata_arr['custom_fonts'] = $fonts;

	return $spdata_arr;
}

/**
 * Function that saves font data into theme data
 * 
 * @todo need to refactor this code as it is currently messy
 * @access public
 * @since 3.0
 * @param array $fonts | the fonts data to save
 * @return string
 */
function sp_save_custom_font_data( $fonts ) {
	// bail if $fonts is not set
	if ( ! isset( $fonts ) )
		return;

	global $spdata;

	$spdata['custom_fonts'] = $fonts;	
	
	// remove duplicates
	$spdata = sp_remove_duplicate_fonts( $spdata );

	_sp_save_data( $spdata );

	return true; 
}

/**
 * get init theme setting from XML
 * 
 * @access public
 * @since 3.0
 * @param string $item the item name to get
 * @param string $option the option for that item to get
 * @return string
 */
function sp_get_theme_init_setting( $item = '', $option = '' ) {
	global $sptheme_config;
	
	if ( isset( $sptheme_config['init'][$item]['_attr'][$option] ) )
		return $sptheme_config['init'][$item]['_attr'][$option];
	else
		return;
}

/**
 * update option function for init settings
 * 
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_update_init_options_function() {
	global $sptheme_config;

	/*** WOO COMMERCE plugin options ***/
	// product grid view image sizes
	if ( isset( $sptheme_config['init']['woo_product_catalog_image_size'] ) ) {
		update_option( 'shop_catalog_image_size', array( 'width' => sp_get_theme_init_setting( 'woo_product_catalog_image_size', 'width' ), 'height' => sp_get_theme_init_setting( 'woo_product_catalog_image_size', 'height' ), 'crop' => sp_get_theme_init_setting( 'woo_product_catalog_image_size', 'crop' ) ) );
	}
	
	// single product view image sizes
	if ( isset( $sptheme_config['init']['woo_product_single_image_size'] ) ) {
		update_option( 'shop_single_image_size', array( 'width' => sp_get_theme_init_setting( 'woo_product_single_image_size', 'width' ), 'height' => sp_get_theme_init_setting( 'woo_product_single_image_size', 'height' ), 'crop' => sp_get_theme_init_setting( 'woo_product_single_image_size', 'crop' ) ) ); 
	}
	
	// product gallery thumbnail image sizes
	if ( isset( $sptheme_config['init']['woo_product_thumbnails_size'] ) ) {
		update_option( 'shop_thumbnail_image_size', array( 'width' => sp_get_theme_init_setting( 'woo_product_thumbnails_size', 'width' ), 'height' => sp_get_theme_init_setting( 'woo_product_thumbnails_size', 'height' ), 'crop' => sp_get_theme_init_setting( 'woo_product_thumbnails_size', 'crop' ) ) );
	}
	
	/*** WP Blog image options ***/
	
	// set the default post thumbnail size
	if ( isset( $sptheme_config['init']['set_post_thumbnail_size'] ) ) {
		update_option( 'thumbnail_size_w', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'width' ) );
		update_option( 'thumbnail_size_h', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'height' ) );	
		
		// set the image crop option for blog featured images (not sure if this is still needed)
		update_option( 'thumbnail_crop', sp_get_theme_init_setting( 'set_post_thumbnail_size', 'crop' ) );
	}	

	// set the medium and large image sizes to zero to prevent WP from auto generating images
	update_option( 'medium_size_w', 0 );
	update_option( 'medium_size_h', 0 );
	update_option( 'large_size_w', 0 );
	update_option( 'large_size_h', 0 );

	// setup permalinks
	update_option( 'permalink_structure', '/%category%/%postname%/' );	

	// set to show avatars
	update_option( 'show_avatars', '1' );

	// flush permalink cache
	flush_rewrite_rules();

	// loop through any additional pages that need to be added 
	$add_page_count = count( $sptheme_config['init']['add_page'] ); // check how many pages to be added

	foreach ( $sptheme_config['init']['add_page'] as $page ) {
		if ( $add_page_count > 1 ) {
			$new_page_title = $page['_attr']['name'];
			$new_page_content = sprintf( __( '%s', 'sp-theme' ), $page['_attr']['content'] );
			if ( isset( $page['_attr']['file'] ) ) 
				$new_page_template = $page['_attr']['file'];
		} else {
			$new_page_title = $page['name'];
			$new_page_content = sprintf( __( '%s', 'sp-theme' ), $page['content'] );
			if ( isset( $page['file'] ) )
				$new_page_template = $page['file'];
		}

		$page_check = get_page_by_title( $new_page_title );
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
		);

		if ( ! isset( $page_check->ID ) ) {
			// add the page
			$new_page_id = wp_insert_post( $new_page );

			// turn off comments for created page
			$args = array(
				'ID' => $new_page_id,
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			);
			
			// update the page
			wp_update_post( $args );

			if ( ! empty( $new_page_template ) ) {
				update_post_meta( $new_page_id, '_wp_page_template', $new_page_template );
			}
		}
	}	

	return true;
}

/**
 * function to build the default settings array
 *
 * @access public
 * @since 3.0
 * @return array $data
 */
function sp_get_default_theme_settings() {
	global $sptheme_config;

	// get theme specific config xml
	$data = array();
	if ( isset( $sptheme_config['tab'] ) ) {
		foreach ( $sptheme_config['tab'] as $tabs ) {
			if ( isset( $tabs['panel'] ) ) {
				foreach ( $tabs['panel'] as $panels ) {
					if ( isset( $panels['wrapper'] ) ) {
						foreach ( $panels['wrapper'] as $wrappers ) {
							if ( isset( $wrappers['module'] ) ) {
								foreach ( $wrappers['module'] as $module ) {
									if ( isset( $module['_attr']['id'] ) && isset( $module['_attr']['std'] )  )
										$data[$module['_attr']['id']] = $module['_attr']['std'];
								}
							}
						}
					}
				}			
			}
		}
	}

	return $data;
}

/**
 * initialize the database for the first time called by config
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_init_db() {
	add_option( THEME_NAME . "_sp_data", '', '', 'yes' );

	// get the default settings array
	$data = sp_get_default_theme_settings();

	return _sp_save_data( $data );
}

/**
 * Function to delete the customizer styles css file
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_delete_customizer_styles_css() {
	if ( is_child_theme() ) {
		if ( file_exists( CHILD_THEME_CSS_PATH . 'customizer-styles.css' ) )
			@unlink( CHILD_THEME_CSS_PATH . 'customizer-styles.css' );
	} else {
		if ( file_exists( THEME_CSS_PATH . 'customizer-styles.css' ) )
			@unlink( THEME_CSS_PATH . 'customizer-styles.css' );
	}

	return true;
}

/**
 * Function to delete the font styles css file
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_delete_font_styles_css() {
	if ( is_child_theme() ) {
		if ( file_exists( CHILD_THEME_CSS_PATH . 'font-styles.css' ) )
			@unlink( CHILD_THEME_CSS_PATH . 'font-styles.css' );
	} else {
		if ( file_exists( THEME_CSS_PATH . 'font-styles.css' ) )
			@unlink( THEME_CSS_PATH . 'font-styles.css' );
	}

	return true;
}

/**
 * Function to delete custom styles entered in sp panel
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_delete_custom_styles_css() {
	if ( is_child_theme() ) {
		if ( file_exists( CHILD_THEME_CSS_PATH . 'custom-styles.css' ) )
			@unlink( CHILD_THEME_CSS_PATH . 'custom-styles.css' );
	} else {
		if ( file_exists( THEME_CSS_PATH . 'custom-styles.css' ) )
			@unlink( THEME_CSS_PATH . 'custom-styles.css' );
	}

	return true;
}

/**
 * Function to deletes all page builder transients
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_delete_page_builder_transients() {
	global $wpdb;

	$sql = $wpdb->get_col( $wpdb->prepare( "SELECT option_id FROM {$wpdb->options} WHERE option_name LIKE %s", '_transient_sp-page-builder-%' ) );

	// loop through and delete each transient

	foreach( $sql as $id ) {
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_id = %d", $id ) );
	}

	return true;
}