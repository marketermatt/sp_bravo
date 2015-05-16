<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * admin ajax functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

// add the functions to the ajax action hook
if ( is_admin() ) {
	add_action( 'wp_ajax_sp_theme_save_ajax', 'sp_theme_save_ajax' );
	
	add_action( 'wp_ajax_sp_slider_options_ajax', 'sp_slider_options_ajax' );
	
	add_action( 'wp_ajax_sp_theme_upload', 'sp_theme_upload' );
	
	add_action( 'wp_ajax_sp_set_slide_media_object_ajax', 'sp_set_slide_media_object_ajax' );	
	
	add_action( 'wp_ajax_sp_sort_slides_ajax', 'sp_sort_slides_ajax' );
	
	add_action( 'wp_ajax_sp_remove_slide_media_ajax', 'sp_remove_slide_media_ajax' );	
	
	add_action( 'wp_ajax_sp_add_video_link_slide_ajax', 'sp_add_video_link_slide_ajax' );	
	
	add_action( 'wp_ajax_sp_add_content_slide_ajax', 'sp_add_content_slide_ajax' );
	
	add_action( 'wp_ajax_sp_get_slide_media_details_ajax', 'sp_get_slide_media_details_ajax' );	
	
	add_action( 'wp_ajax_sp_save_slide_settings_ajax', 'sp_save_slide_settings_ajax' );	
	
	add_action( 'wp_ajax_sp_save_slider_type_ajax', 'sp_save_slider_type_ajax' );	
	
	add_action( 'wp_ajax_sp_theme_reset_ajax', 'sp_theme_reset_ajax' );
	
	add_action( 'wp_ajax_sp_customizer_reset_ajax', 'sp_customizer_reset_ajax' );

	add_action( 'wp_ajax_sp_theme_config_reset_ajax', 'sp_theme_config_reset_ajax' );
	
	add_action( 'wp_ajax_sp_clear_star_ratings_ajax', 'sp_clear_star_ratings_ajax' );
	
	add_action( 'wp_ajax_sp_import_theme_settings_ajax', 'sp_import_theme_settings_ajax' );
	
	add_action( 'wp_ajax_sp_save_custom_styles_ajax', 'sp_save_custom_styles_ajax' );
	
	add_action( 'wp_ajax_sp_create_page_ajax', 'sp_create_page_ajax' );
	
	add_action( 'wp_ajax_sp_get_theme_settings_ajax', 'sp_get_theme_settings_ajax' );
	
	add_action( 'wp_ajax_sp_save_config_ajax', 'sp_save_config_ajax' );
	
	add_action( 'wp_ajax_sp_apply_config_ajax', 'sp_apply_config_ajax' );
	
	add_action( 'wp_ajax_sp_delete_config_ajax', 'sp_delete_config_ajax' );
	
	add_action( 'wp_ajax_sp_font_select_ajax', 'sp_font_select_ajax' );
	
	add_action( 'wp_ajax_sp_page_builder_get_module_ajax', 'sp_page_builder_get_module_ajax' );
	
	add_action( 'wp_ajax_sp_shortcode_input_form_ajax', 'sp_shortcode_input_form_ajax' );
	
	add_action( 'wp_ajax_sp_page_builder_content_tinymce_ajax', 'sp_page_builder_content_tinymce_ajax' );
	
	add_action( 'wp_ajax_sp_add_custom_product_tab_ajax', 'sp_add_custom_product_tab_ajax' );

	add_action( 'wp_ajax_sp_install_sample_data_ajax', 'sp_install_sample_data_ajax' );

}

/**
 * Function that process the data to be saved
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_theme_save_ajax() {
	global $spdata;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );
	unset( $form_data['action'] );
	unset( $form_data['_wpnonce'] );
	unset( $form_data['_wp_http_referer'] );

	// check if saved data has custom fonts
	if ( isset( $spdata['custom_fonts'] ) ) {
		// save custom fonts along with new theme settings data
		$form_data['custom_fonts'] = $spdata['custom_fonts'];
	}

	$saved = _sp_save_data( $form_data );

	// save the theme mods to theme settings
	_sp_save_theme_mods();
	
	echo 'done';	
	exit;	
}

/**
 * Function that sets the slide media object
 *
 * @access public
 * @since 3.0
 * @return json object the details of the attachment ( width, height, image tag )
 */
function sp_set_slide_media_object_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if attachment id is not passed
	if ( ! isset( $_POST['attachment_id'] ) )
		exit;

	$attachment_id = absint( $_POST['attachment_id'] );

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;
	
	$post_id = absint( $_POST['post_id'] );

	if ( isset( $_POST['size'] ) )
		$size = sanitize_text_field( $_POST['size'] );

	// set the attachment post's post parent
	add_post_meta( $attachment_id, '_sp_slide_post_parent', $post_id );

	// set the slide's sort order
	sp_set_slide_sort_order( $attachment_id, $post_id );
	
	// get the slide media display
	$output = sp_display_slide_media_object( $attachment_id, $post_id, $size );

	// clear cache
	_sp_clear_slider_cache( $post_id );

	// json encode the output
	echo json_encode( array( 'attachmentObject' => $output ) );
	exit;	
}

/**
 * Function that removes the slide media
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_remove_slide_media_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if attachment id is not passed
	if ( ! isset( $_POST['attachment_id'] ) )
		exit;

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	$attachment_id = absint( $_POST['attachment_id'] );
	$post_id = absint( $_POST['post_id'] );

	delete_post_meta( $attachment_id, '_sp_slide_post_parent', $post_id );

	// delete post meta
	sp_delete_slide_meta( $attachment_id, $post_id );

	// clear cache
	_sp_clear_slider_cache( $post_id );

	echo 'done';
	exit;
}

/**
 * Function that sort the slides
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_sort_slides_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	// bail if positions array is not passed
	if ( ! isset( $_POST['positions'] ) )
		exit;

	$post_id = absint( $_POST['post_id'] );
	$positions = $_POST['positions']; // array

	$i = 1;

	// loop through the new position array
	foreach( $positions as $attachment_id ) {
		// update the sort position
		update_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_sort_order', $i );

		$i++;
	}

	// clear cache
	_sp_clear_slider_cache( $post_id );

	echo 'done';
	exit;
}

/**
 * Function that adds a video link slide
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_add_video_link_slide_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	// bail if link is not passed
	if ( ! isset( $_POST['link'] ) )
		exit;

	// bail if title is not passed
	if ( ! isset( $_POST['title'] ) )
		exit;

	$post_id = absint( $_POST['post_id'] );
	$link = sanitize_text_field( $_POST['link'] );
	$title = sanitize_text_field( $_POST['title'] );
	$size = sanitize_text_field( $_POST['size'] );

	// inserts the media object
	$attachment_id = sp_insert_slide_media_link_object( $post_id, $title, $link );

	// set the slide's sort order
	sp_set_slide_sort_order( $attachment_id, $post_id );
	
	// get the slide media display
	$output = sp_display_slide_media_object( $attachment_id, $post_id, $size );

	// clear cache
	_sp_clear_slider_cache( $post_id );

	// json encode the output
	echo json_encode( array( 'attachmentObject' => $output ) );
	exit;
}

/**
 * Function that adds a content slide
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_add_content_slide_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	// bail if title is not passed
	if ( ! isset( $_POST['title'] ) )
		exit;

	$post_id = absint( $_POST['post_id'] );
	$title = sanitize_text_field( $_POST['title'] );
	$size = sanitize_text_field( $_POST['size'] );

	// inserts the media object
	$attachment_id = sp_insert_slide_media_content_object( $post_id, $title );

	// set the slide's sort order
	sp_set_slide_sort_order( $attachment_id, $post_id );
	
	// get the slide media display
	$output = sp_display_slide_media_object( $attachment_id, $post_id, $size );

	// clear cache
	_sp_clear_slider_cache( $post_id );

	// json encode the output
	echo json_encode( array( 'attachmentObject' => $output ) );
	exit;
}

/**
 * Function that gets the slide media detail
 *
 * @access public
 * @since 3.0
 * @return html $output
 */
function sp_get_slide_media_details_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if attachment id is not passed
	if ( ! isset( $_POST['attachment_id'] ) )
		exit;

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	$attachment_id = absint( $_POST['attachment_id'] );
	$post_id = absint( $_POST['post_id'] );	

	$output = sp_display_slide_media_details( $attachment_id, $post_id );

	echo json_encode( array( 'mediaDetail' => $output ) );
	exit;
}

/**
 * Function that saves the slide settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_save_slide_settings_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if attachment id is not passed
	if ( ! isset( $_POST['attachment_id'] ) )
		exit;

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	$attachment_id = absint( $_POST['attachment_id'] );
	$post_id = absint( $_POST['post_id'] );	
	
	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	// iterate through data and update post meta
	foreach( $form_data as $k => $v ) {
		if ( ! isset( $v ) || empty( $v ) || $v === 'none' )
			update_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_' . $k, '' );
		else
			update_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_' . $k, $v );

		// if font isset
		if ( $k === 'slogan_title_font' && isset( $v ) ) {
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel h3.slogan-title', 'font' => $v, 'variant' => $form_data['slogan_title_font_variant'], 'subset' => $form_data['slogan_title_font_subset'] ) );
		}

		// if font isset
		if ( $k === 'content_font' && isset( $v ) ) {
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel .content-text', 'font' => $v, 'variant' => $form_data['content_font_variant'], 'subset' => $form_data['content_font_subset'] ) );
		}

		// if font isset
		if ( $k === 'link_title_font' && isset( $v ) ) {
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel a.link-out', 'font' => $v, 'variant' => $form_data['link_title_font_variant'], 'subset' => $form_data['link_title_font_subset'] ) );
		}		

		// if font isset
		if ( $k === 'title_font' && isset( $v ) ) {
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel a.link-out', 'font' => $v, 'variant' => $form_data['title_font_variant'], 'subset' => $form_data['title_font_subset'] ) );
		}	

		// if font isset
		if ( $k === 'content_text_font' && isset( $v ) ) {
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel .content-text', 'font' => $v, 'variant' => $form_data['content_text_font_variant'], 'subset' => $form_data['content_text_font_subset'] ) );
		}					
	}

	// clear cache
	_sp_clear_slider_cache( $post_id );

	echo 'done';
	exit;	
}

/**
 * Function that saves the slider type
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_save_slider_type_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if post id is not passed
	if ( ! isset( $_POST['post_id'] ) )
		exit;

	// bail if slide type is not passed
	if ( ! isset( $_POST['type'] ) )
		exit;

	$post_id = absint( $_POST['post_id'] );
	$type = sanitize_text_field( $_POST['type'] );

	// update the slider's type
	update_post_meta( $post_id, '_sp_slider_type', $type );

	// clear cache
	_sp_clear_slider_cache( $post_id );

	echo 'done';
	exit;
}

/**
 * Function that resets all settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_theme_reset_ajax() {
	global $sptheme_config;
	
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// delete the transient
	delete_transient( THEME_SHORTNAME . 'config' );
	
	$sptheme_config = _sp_get_theme_config();

	// get the default settings array
	$data = sp_get_default_theme_settings();
	
	_sp_save_data( $data );
	sp_update_init_options_function();

	// remove all theme mods
	remove_theme_mods();

	// reset all theme mods to default values
	_sp_init_theme_mods();

	// delete the customizer css file
	_sp_delete_customizer_styles_css();

	// delete the font css file
	_sp_delete_font_styles_css();

	// delete the custom styles css file
	_sp_delete_custom_styles_css();

	echo "done";
	exit;
}

/**
 * Function that resets all customizer settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_customizer_reset_ajax() {
	global $spdata;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );
	
	// remove all theme mods
	remove_theme_mods();

	// delete theme mods from spdata
	unset( $spdata['theme_mods'] );
	_sp_save_data( $spdata );
	
	// delete the customizer css file
	_sp_delete_customizer_styles_css();

	// delete the font css file
	_sp_delete_font_styles_css();
	
	echo "done";
	exit;
}

/**
 * Function that resets theme config cache
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_theme_config_reset_ajax() {
	global $spdata;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );
	
	// delete the transient
	delete_transient( THEME_SHORTNAME . 'config' );

	// delete all page builder transients
	_sp_delete_page_builder_transients();
	
	echo "done";
	exit;
}

/**
 * Function that imports the theme settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_import_theme_settings_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if settings is not passed
	if ( ! isset( $_POST['settings'] ) )
		exit;

	$settings = sanitize_text_field( $_POST['settings'] );	

	// validate settings
	if ( isset( $settings ) && !empty( $settings ) && base64_encode( base64_decode( $settings ) ) === $settings ) {
		// update the option
		update_option( THEME_NAME . "_sp_data", $settings );

		echo 'done';
		exit;
	} else {
		echo 'error';
		exit;
	}
}

/**
 * Function that imports the theme settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_create_page_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );
	
	// bail if page template is not passed
	if ( ! isset( $_POST['page_template'] ) )
		exit;	

	// bail if page title is not passed
	if ( ! isset( $_POST['page_title'] ) )
		exit;

	$template = sanitize_text_field( $_POST['page_template'] );
	$new_page_title = sanitize_text_field( $_POST['page_title'] );

	$page_check = get_page_by_title( $new_page_title );

	$new_page = array(
		'post_type'		=> 'page',
		'post_title'	=> $new_page_title,
		'post_status'	=> 'publish',
		'post_author'	=> 1,
	);

	if ( ! isset( $page_check->ID ) ) {
		$new_page_id = wp_insert_post( $new_page );

		if ( ! empty( $template ) ) {
			update_post_meta( $new_page_id, '_wp_page_template', $template );
		}
	}
	
	echo 'done';
	exit;
}

/**
 * Function that gets the saved theme settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_get_theme_settings_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$saved_data = get_option( THEME_NAME . "_sp_data" );

	echo $saved_data;
	exit;
}

/**
 * Function that saves theme configuration
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_save_config_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if config name is not passed
	if ( ! isset( $_POST['config_name'] ) )
		exit;

	$config_name = sanitize_text_field( $_POST['config_name'] );

	// if it doesn't already exist
	if ( ! get_option( THEME_NAME . '_saved_config_' . $config_name ) ) {
		// get the current settings
		$settings = get_option( THEME_NAME . "_sp_data" );

		add_option( THEME_NAME . '_saved_config_' . $config_name, $settings, '', 'no' );

		echo 'done';
		exit;
	} else {
		echo 'error';
		exit;
	}
}

/**
 * Function that applies theme configuration
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_apply_config_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if config name is not passed
	if ( ! isset( $_POST['config_name'] ) )
		exit;

	$config_name = sanitize_text_field( $_POST['config_name'] );

	// checks if config exists
	if ( $settings = get_option( THEME_NAME . '_saved_config_' . $config_name ) ) {

		// update the theme settings
		update_option( THEME_NAME . '_sp_data', $settings );
		
		// update theme mods
		_sp_update_theme_mods();
		
		echo 'done';
		exit;
	} else {
		echo 'error';
		exit;
	}
}

/**
 * Function that delete theme configuration
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_delete_config_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	// bail if config name is not passed
	if ( ! isset( $_POST['config_name'] ) )
		exit;

	$config_name = sanitize_text_field( $_POST['config_name'] );

	// if it exists
	if ( get_option( THEME_NAME . '_saved_config_' . $config_name ) ) {

		// delete the option
		delete_option( THEME_NAME . '_saved_config_' . $config_name );

		echo 'done';
		exit;
	} else {
		echo 'error';
		exit;
	}
}

/**
 * Function that saves the custom styles
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function sp_save_custom_styles_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	 $styles = stripslashes( strip_tags( $_POST['styles'] ) );

	// bail if styles is not passed
	if ( ! isset( $styles ) )
		$styles = '';

	// save the styles
	sp_save_styles( 'custom-styles.css', $styles );

	echo 'done';
	exit;	
}

/**
 * Function that handles font variant and subsets
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_font_select_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$font = sanitize_text_field( $_POST['font'] );

	// get the font array
	$font = sp_get_font( $font );

	// proceed if font found
	if ( $font ) {
		$variants = '';
		$subsets = '';

		$variants .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;
		$subsets .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

		foreach( $font['variants'] as $variant ) {
			$variants .= '<option value="' . $variant . '">' . $variant . '</option>' . PHP_EOL;
		}

		foreach( $font['subsets'] as $subset ) {
			$subsets .= '<option value="' . $subset . '">' . $subset . '</option>' . PHP_EOL;
		}

		$font_attr = array( 'variants' => $variants, 'subsets' => $subsets );
		$font_attr = json_encode( $font_attr );

		echo $font_attr;
	}
	exit;
}

add_action( 'customize_save', '_sp_customize_save' );

/**
 * Function that saves the customize settings
 *
 * @access public
 * @since 3.0
 * @return string done
 */
function _sp_customize_save() {	
	global $sptheme_config;

	// continue only if nonce checks out
	check_ajax_referer( 'save-customize_' . get_stylesheet(), 'nonce' );

	$settings = stripslashes( $_POST['customized'] );
	$settings = json_decode( $settings, true );
	$styles = '';
	$fonts = array();

	// get existing theme mods
	$existing_mods = get_theme_mods();

	// merge in the existing saved settings with customizer posted ones
	$settings = array_merge( $existing_mods, $settings );
	
	// save the settings
	foreach( $settings as $setting_name => $setting_value ) {
		set_theme_mod( $setting_name, $setting_value );

		foreach( $sptheme_config['init']['customizer'] as $setting ) {				
			if ( $setting['_attr']['id'] === $setting_name && $setting_value !== $setting['_attr']['std'] && $setting['_attr']['selector'] !== 'none' && $setting['_attr']['property'] !== 'none' ) {
				// skip if value is custom or none
				if ( $setting_value === 'custom' || ( $setting_value === 'none' && ! preg_match( '/variant/', $setting_name ) ) )
					continue;

				// save fonts to theme data
				if ( $setting['_attr']['property'] === 'font-family' && isset( $setting_value ) && ! empty( $setting_value ) && ! sp_check_default_fonts( $setting_value ) ) {

					if ( isset( $settings[$setting_name . '_variant'] ) && $settings[$setting_name . '_variant'] !== 'none' )
						$variant = $settings[$setting_name . '_variant'];
					else 
						$variant = '';

					if ( is_array( $settings[$setting_name . '_subset'] ) && isset( $settings[$setting_name . '_subset'] ) && ! in_array( 'none', $settings[$setting_name . '_subset'] ) )
						$subset = $settings[$setting_name . '_subset'];
					else 
						$subset = '';

					// save custom fonts into theme data
					$fonts[] = array( 'selector' => $setting['_attr']['selector'], 'font' => $setting_value, 'variant' => $variant, 'subset' => $subset );					
				} else {
					if ( $setting_value === 'regular' )
						continue;

					// check background image
					if ( $setting['_attr']['property'] === 'background-image' && $setting_value === 'no-image' ) {
						$styles .= sp_generate_css( $setting['_attr']['selector'], $setting['_attr']['property'], 'none' ) . PHP_EOL;
					} else {
						$styles .= sp_generate_css( $setting['_attr']['selector'], $setting['_attr']['property'], $setting_value, $setting['_attr']['prefix'], $setting['_attr']['suffix'] ) . PHP_EOL;
					}
				}
			}
		}
	}

	// save fonts
	sp_save_custom_font_data( $fonts );

	// save the styles to file
	sp_save_styles( 'customizer-styles.css', $styles );

	// save the theme mods to theme settings
	_sp_save_theme_mods();

	exit;	
}

/**
 * Function that gets the page builder module
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_page_builder_get_module_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$module = sanitize_text_field( $_POST['module'] );
	$post_id = absint( $_POST['post_id'] );

	$module = _sp_get_page_builder_module( $post_id, $module );

	echo $module;
	exit;
}

/**
 * Function that gets the shortcode input form
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_shortcode_input_form_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$module = sanitize_text_field( $_POST['module'] );

	// bail if nothing passed
	if ( ! isset( $module ) || empty( $module ) )
		exit;

	$form = '';

	$form .= sp_shortcodes_input_form( $module );

	echo json_encode( array( 'form' => $form ) );
	exit;
}

/**
 * Function that generates the wp editor
 *
 * @access public
 * @since 3.0
 * @return string done | error
 */
function sp_page_builder_content_tinymce_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$content = stripslashes( $_POST['content'] );

	if ( ! isset( $content ) || empty( $content ) )
		$content = '';

	$settings = array(
		'textarea_name'	=> 'sp_pb_tinymce_textarea',
		'tinymce' 		=> true,
		'media_buttons' => true,
		'editor_class'	=> 'sp-tinymce-content'
	);

	$mce_id = 'pb_tinymce_' . strtolower( wp_generate_password( 6, false ) );

	// content
	ob_start();
	wp_editor( $content, $mce_id, $settings );
	$output = ob_get_clean();

	echo $output;
	exit;
}

/**
 * Function that handles the adding of product tab in backend
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */	
function sp_add_custom_product_tab_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );

	$tab = '<li class="tab"><a href="" class="tab-title">' . __( 'Untitled', 'sp-theme' ) . '</a><span class="edit-title"><input type="hidden" name="sp_product_tab_name[]" value="' . __( 'Untitled', 'sp-theme' ) . '" placeholder="' . esc_attr__( 'Enter Tab Name', 'sp-theme' ) . '" class="tab-name" /></span><a href="#" class="remove-tab" title="' . esc_attr__( 'Remove Tab', 'sp-theme' ) . '">&times;</a></li>' . PHP_EOL;

	$editor = '<div id="" class="tab-content">' . PHP_EOL;

	$settings = array(
		'textarea_name'	=> 'sp_product_tinymce_textarea[]',
		'tinymce' 		=> true,
		'media_buttons' => true,
		'editor_class'	=> 'sp-tinymce-content'
	);

	$content = '';

	$mce_id = 'pt_tinymce_' . strtolower( wp_generate_password( 6, false ) );

	// content
	ob_start();
	wp_editor( $content, $mce_id, $settings );
	$editor .= ob_get_clean();

	$editor .= '</div><!--close .tab-content-->' . PHP_EOL;

	echo json_encode( array( 'tab' => $tab, 'editor' => $editor, 'mce_id' => $mce_id ) );
	exit;
}

/**
 * Function that handles installing sample data
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */	
function sp_install_sample_data_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
	     die ( 'error' );
	
	require_once( THEME_PATH . 'theme-functions/sample-data/data-importer.php' );

	$response = '';

	$response .= sp_import_data();

	echo $response;
	exit;
}