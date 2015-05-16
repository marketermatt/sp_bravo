<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

//add_action( 'wp_enqueue_scripts', '_sp_ie_respond_js' );

/**
 * Enqueues scripts and styles for front-end IE 8 and below
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_ie_respond_js() {
	global $is_IE;
 
	// bail if not ie
	if ( ! $is_IE ) return;
 
	if ( ! function_exists( 'wp_check_browser_version' ) )
		include_once( ABSPATH . 'wp-admin/includes/dashboard.php' );
 
	// IE version conditional enqueue
	$version = wp_check_browser_version();
	
	if ( 0 > version_compare( intval( $version['version'] ) , 9 ) )
		wp_enqueue_script( apply_filters( 'sp_respond_js', 'respond_js' ), get_template_directory_uri() . '/js/respond.min.js', null, THEME_VERSION, false );
}

// only load this on frontend
if ( ! is_admin() )
	add_action( 'wp_enqueue_scripts', '_sp_scripts_styles' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_scripts_styles() {
	global $wp_scripts;

	// check if dev mode is on
	if ( SP_DEV === true )
		$suffix = '';
	else 
		$suffix = '.min';

	wp_enqueue_script( 'jquery' );
	
	// adds javascript threaded comment support
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// enqueue jquery ui
	wp_enqueue_script( 'jquery-ui-core' );

	// enqueue tabs
	wp_enqueue_script( 'jquery-ui-tabs' );

	// register and enqueue modernizr js
	wp_register_script( apply_filters( 'sp_modernizr_js', 'modernizr_js' ), get_template_directory_uri() . '/js/modernizr' . $suffix . '.js', null, '2.6.2', false );
	wp_enqueue_script( apply_filters( 'sp_modernizr_js', 'modernizr_js' ) );

	// load theme styles
	wp_enqueue_style( apply_filters( 'sp-theme-style', 'theme-style' ), get_stylesheet_uri() );

	// register and enqueue site js
	wp_register_script( apply_filters( 'sp_theme_js', 'theme_js' ), get_template_directory_uri() . '/js/main' . $suffix . '.js', null, THEME_VERSION, true );
	wp_enqueue_script( apply_filters( 'sp_theme_js', 'theme_js' ) );		

	// set variables if WOO plugin is active
	( sp_woo_exists() ) ? $woo_active = true : $woo_active = false; 

	// check float nav
	$float_nav =  sp_get_option( 'navigation_scroll_follow', 'is', 'on' ) ? 'on' : 'off';

	// check site layout boxed or full
	$site_layout = get_theme_mod( 'site_layout' );
	
	// localized js variables
	$localized_vars = array(
		'ajaxurl'							=> admin_url( 'admin-ajax.php' ),
		'ajaxCustomNonce'					=> wp_create_nonce( '_sp_nonce' ),
		'framework_url'						=> esc_url( FRAMEWORK_URL ),
		'theme_url'							=> esc_url ( THEME_URL ),
		'site_url'							=> esc_url( SITE_URL ),
		'wp_url'							=> esc_url( WP_URL ),
		'woo_active'						=> $woo_active,
		'is_mobile'							=> wp_is_mobile() ? 'yes' : 'no',
		'woo_ajax_cart_en'					=> get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes' ? true : false,
		'wishlist_no_items'					=> __( 'There are no items in your wishlist.', 'sp-theme' ),
		'wishlist_save_no_name_text'		=> __( 'Please enter a name for your wishlist.', 'sp-theme' ),
		'wishlist_confirm_entry_delete'		=> __( 'Are you sure you want to delete this wishlist entry?', 'sp-theme' ),
		'compare_no_items'					=> __( 'There are no items to compare.', 'sp-theme' ),
		'added_to_cart_text'				=> __( 'Item Added', 'sp-theme' ),
		'add_to_cart_text'					=> __( 'Add to Cart', 'sp-theme' ),
		'product_gallery_swap'				=> sp_get_option( 'product_image_gallery_swap' ) === 'on' ? true : false,
		'product_image_zoom'				=> sp_get_option( 'product_image_zoom' ) === 'on' ? true : false,
		'cart_url'							=> sp_woo_exists() ? apply_filters( 'woocommerce_get_cart_url', get_permalink( woocommerce_get_page_id( 'cart' ) ) ) : '',
		'woo_checkout_required_fields_msg'	=> __( 'Please fill in all required fields', 'sp-theme' ),
		
		// localized text
		'reset_email_sent'					=> __( 'Reset e-mail sent!', 'sp-theme' ),
		'core_theme_version'				=> THEME_VERSION,
		'core_framework_version'			=> FRAMEWORK_VERSION,
		'enter_all_required_fields_msg'		=> apply_filters( 'sp_enter_all_required_fields_msg', __( 'Please fill in all required fields.', 'sp-theme' ) ),
		'confirm_password_msg'				=> __( 'Password does not match.', 'sp-theme' ),
		'contact_form_please_select'		=> apply_filters( 'sp_contact_form_please_select_text', __( '--Please Select--', 'sp-theme' ) ),
		'float_nav'							=> $float_nav,
		'site_layout'						=> $site_layout
	);
	
	wp_localize_script( apply_filters( 'sp-localization', 'theme_js' ), 'sp_theme', $localized_vars );

	// remove layerslider css
	//wp_dequeue_style( 'layerslider_css' );

	return true;
}

if ( ! is_admin() && sp_woo_exists() ) 
	add_action( 'wp_enqueue_scripts', '_sp_ecommerce_scripts', 999 );

/**
 * Function that registers and enqueues ecommerce scripts
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_ecommerce_scripts() {
	// enqueue WooCommerce add to cart variation
	wp_enqueue_script( 'wc-add-to-cart-variation' );

	return true;
}

if ( ! is_admin() && sp_woo_exists() ) 
	add_action( 'wp_enqueue_scripts', '_sp_ecommerce_styles' );

/**
 * Function that registers and enqueues ecommerce styles
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_ecommerce_styles() {
	// register and enqueue ecommerce styles
	wp_register_style( apply_filters( 'sp_woocommerce_styles', 'woocommerce-styles' ), THEME_URL . 'css/theme-woocommerce-styles.css', null, THEME_VERSION );	
	wp_enqueue_style( apply_filters( 'sp_woocommerce_styles', 'woocommerce-styles' ) );

	return true;
}

// deregister all woo scripts to move them to the footer where they belong
if ( ! is_admin() && sp_woo_exists() ) 
	add_action( 'wp_enqueue_scripts', '_sp_deregister_woo_scripts', 100 );

/**
 * Function that removes woo scripts and styles
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_deregister_woo_scripts() {
	wp_dequeue_style( 'woocommerce_frontend_styles' );
	wp_dequeue_style( 'woocommerce-layout' );
	wp_dequeue_style( 'woocommerce-smallscreen' );
	wp_dequeue_style( 'woocommerce-general' );
	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	//wp_dequeue_style( 'woocommerce_chosen_styles' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
	wp_dequeue_script( 'wc-add-to-cart' ); // removing this and using our own so we can have ajax add to cart everywhere
	//wp_dequeue_script( 'wc-chosen' );
	wp_dequeue_script( 'chosen' );

	remove_filter( 'woocommerce_enqueue_styles', 'backwards_compat' );

	return true;
}

// loaded as first item in header to prevent FOUT
add_action( 'wp_head', '_sp_echo_google_fonts', 5 );

/**
 * Function that echos the google font script in header
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_echo_google_fonts() {
	// get theme default fonts
	global $sptheme_config;

	$fonts = array();
	if ( is_array( $sptheme_config['init']['fonts'] ) ) {
		foreach ( $sptheme_config['init']['fonts'] as $font ) {
			if ( count( $sptheme_config['init']['fonts'] ) > 1 )
				$fonts[] = $font['_attr']['name'];	
			else 
				$fonts[] = $font['name'];
		}
	}

	$defaultFonts = json_encode( apply_filters( 'sp_load_default_fonts', $fonts ) );
?>
<script type="text/javascript">
var spFonts = <?php echo sp_load_fonts(); ?>;

// merge the fonts
spFonts = spFonts.concat(<?php echo $defaultFonts; ?>);

// only load when necessary
if ( spFonts.length > 0 ) {

	WebFontConfig = {
		google: {
			families: spFonts
		}
	};

	var wf = document.createElement( 'script' );

	wf.src = ( 'https:' === document.location.protocol ? 'https' : 'http' ) + '://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js';

	wf.type = 'text/javascript';

	wf.async = 'true';

	var s = document.getElementsByTagName( 'script' )[0];

	s.parentNode.insertBefore( wf, s );
}
</script>
<?php
}

if ( ! is_admin() )
	add_action( 'wp_enqueue_scripts', '_sp_custom_styles' );

/**
 * Function that registers and enqueues custom styles but ensures to load at the end after all other styles
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_custom_styles() {
	$deps = array();
	
	if ( wp_style_is( 'sp_woocommerce_styles', 'queue' ) )
		array_unshift( $deps, 'sp_woocommerce_styles' );
	
	// if child theme is used	
	if ( is_child_theme() ) {
		// if font styles are used 
		if ( file_exists( get_stylesheet_directory() . '/css/font-styles.css' ) && filesize( get_stylesheet_directory() . '/css/font-styles.css' ) !== 0 ) { 
			// register and enqueue font styles
			wp_register_style( apply_filters( 'sp_font_styles', 'sp_font_styles' ), get_stylesheet_directory_uri() . '/css/font-styles.css', $deps, THEME_VERSION );
			wp_enqueue_style( apply_filters( 'sp_font_styles', 'sp_font_styles' ) );
		}

		// if customizer styles are used 
		if ( file_exists( get_stylesheet_directory() . '/css/customizer-styles.css' ) && filesize( get_stylesheet_directory() . '/css/customizer-styles.css' ) !== 0 ) { 
			// register and enqueue custom styles
			wp_register_style( apply_filters( 'sp_customizer_styles', 'sp_customizer_styles' ), get_stylesheet_directory_uri() . '/css/customizer-styles.css', $deps, THEME_VERSION );
			wp_enqueue_style( apply_filters( 'sp_customizer_styles', 'sp_customizer_styles' ) );
		}

		// if custom styles are used 
		if ( file_exists( get_stylesheet_directory() . '/css/custom-styles.css' ) && filesize( get_stylesheet_directory() . '/css/custom-styles.css' ) !== 0 ) { 
			// register and enqueue custom styles
			wp_register_style( apply_filters( 'sp_custom_styles', 'sp_custom_styles' ), get_stylesheet_directory_uri() . '/css/custom-styles.css', $deps, THEME_VERSION );
			wp_enqueue_style( apply_filters( 'sp_custom_styles', 'sp_custom_styles' ) );
		}

		// if user styles are used
		if ( file_exists( get_stylesheet_directory() . '/user-styles.css' ) ) {	
			// register and enqueue user styles	
			wp_register_style( apply_filters( 'sp_user_styles', 'sp_user_styles' ), get_stylesheet_directory() . '/user-styles.css', $deps, THEME_VERSION ); 
			wp_enqueue_style( apply_filters( 'sp_user_styles', 'sp_user_styles' ) );
		}		
	} else {
		// if font styles are used 
		if ( file_exists( get_template_directory() . '/css/font-styles.css' ) && filesize( get_template_directory() . '/css/font-styles.css' ) !== 0 ) { 
			// register and enqueue font styles
			wp_register_style( apply_filters( 'sp_font_styles', 'sp_font_styles' ), get_template_directory_uri() . '/css/font-styles.css', $deps, THEME_VERSION );
			wp_enqueue_style( apply_filters( 'sp_font_styles', 'sp_font_styles' ) );
		}

		// if customizer styles are used
		if ( file_exists( get_template_directory() . '/css/customizer-styles.css' ) && filesize( get_template_directory() . '/css/customizer-styles.css' ) !== 0 ) {	
			// register and enqueue customizer styles	
			wp_register_style( apply_filters( 'sp_customizer_styles', 'sp_customizer_styles' ), get_template_directory_uri() . '/css/customizer-styles.css', $deps, THEME_VERSION ); 
			wp_enqueue_style( apply_filters( 'sp_customizer_styles', 'sp_customizer_styles' ) );
		}

		// if custom styles are used
		if ( file_exists( get_template_directory() . '/css/custom-styles.css' ) && filesize( get_template_directory() . '/css/custom-styles.css' ) !== 0 ) {	
			// register and enqueue custom styles	
			wp_register_style( apply_filters( 'sp_custom_styles', 'sp_custom_styles' ), get_template_directory_uri() . '/css/custom-styles.css', $deps, THEME_VERSION ); 
			wp_enqueue_style( apply_filters( 'sp_custom_styles', 'sp_custom_styles' ) );
		}

		// if user styles are used
		if ( file_exists( get_template_directory() . '/user-styles.css' ) ) {	
			// register and enqueue user styles	
			wp_register_style( apply_filters( 'sp_user_styles', 'sp_user_styles' ), get_template_directory_uri() . '/user-styles.css', $deps, THEME_VERSION ); 
			wp_enqueue_style( apply_filters( 'sp_user_styles', 'sp_user_styles' ) );
		}		
	}
}

// only load this on backend
if ( is_admin() ) {
	add_action( 'admin_enqueue_scripts', '_sp_admin_scripts_styles' );
}

/**
 * Enqueues scripts and styles for back-end.
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_admin_scripts_styles() {
	global $pagenow;

	// check if dev mode is on
	if ( SP_DEV === true )
		$suffix = '';
	else 
		$suffix = '.min';

	// only load in widgets area
	if ( $pagenow === 'widgets.php' ) {
		// enqueue slider from WP
		wp_enqueue_script( 'jquery-ui-slider' );

		// enqueue the datepicker from WP
		wp_enqueue_script( 'jquery-ui-datepicker' );

		// register and enqueue widget scripts
		wp_register_script( apply_filters( 'sp_admin_widgets', 'sp-admin-widgets' ), THEME_URL . 'js/admin-widgets' . $suffix . '.js', null, FRAMEWORK_VERSION, true );
		wp_enqueue_script( apply_filters( 'sp_admin_widgets', 'sp-admin-widgets' ) );
	}	

	// only load in sp panel and slider panel
	if ( get_post_type() === 'sp-slider' || ( isset( $_GET['page'] ) && $_GET['page'] === 'sp' ) || get_post_type() === 'sp-contact-form' ) {

		// enqueue the sortable from WP
		wp_enqueue_script( 'jquery-ui-sortable' );

		// enqueue color picker
		wp_enqueue_script( 'wp-color-picker' );	

		// enqueue WP color picker styles
		wp_enqueue_style( 'wp-color-picker' );		

		// enqueue WP media uploader
		wp_enqueue_media();			

		// enqueue WP jQuery Ui Draggable
		wp_enqueue_script( 'jquery-ui-draggable' );		
	}

	// only load in sp panel
	if ( ( isset( $_GET['page'] ) && $_GET['page'] === 'sp' ) ) {
		// enqueue the datepicker from WP
		wp_enqueue_script( 'jquery-ui-datepicker' );

		// enqueue the tabs from WP
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	// only load in sp panel, page, post, portfolio, slider, testimonials
	if ( ( isset( $_GET['page'] ) && $_GET['page'] === 'sp' ) || get_post_type() === 'post' || get_post_type() === 'page' || get_post_type() === 'sp-portfolio' || get_post_type() === 'sp-slider' || get_post_type() === 'sp-testimonial' || get_post_type() === 'sp-contact-form' || get_post_type() === 'product' || get_post_type() === 'sp-faq' ) {	

		// enqueue the datepicker from WP
		wp_enqueue_script( 'jquery-ui-datepicker' );
		
		// enqueue the sortable from WP
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		// enqueue WP jQuery Ui Draggable
		wp_enqueue_script( 'jquery-ui-droppable' );	

		// register and enqueue sp panel admin scripts
		wp_register_script( apply_filters( 'sp_admin_js', 'admin_js' ), THEME_URL . 'js/admin-backend' . $suffix . '.js', null, FRAMEWORK_VERSION, true );
		wp_enqueue_script( apply_filters( 'sp_admin_js', 'admin_js' ) );
	}

	$localized_vars = array(
		'ajaxurl'										=> admin_url( 'admin-ajax.php' ),
		'ajaxCustomNonce'								=> wp_create_nonce( '_sp_nonce' ),
		'framework_url'									=> esc_url( FRAMEWORK_URL ),
		'theme_url'										=> esc_url ( THEME_URL ),
		'site_url'										=> esc_url( SITE_URL ),
		'wp_url'										=> esc_url( WP_URL ),
		'insert_media'									=> __( 'insert media', 'sp-theme' ),
		'theme_name'									=> THEME_SHORTNAME,
		'settings_import_msg'							=> __( 'This will overwrite all your settings.  Are you sure you want to import the theme settings from your last exported state?', 'sp-theme' ),
		'reset_settings_msg'							=>  __( 'Are you sure you want to reset to theme default settings?', 'sp-theme' ),
		'reset_customizer_settings_msg'					=>  __( 'Are you sure you want to reset all customized settings to their default values?', 'sp-theme' ),
		'reset_cache_msg'								=> __( 'Are you sure you want to empty the image cache folder?', 'sp-theme' ),
		'clear_stars_ratings_msg'						=> __( 'Are you sure you want to clear ALL product star ratings?', 'sp-theme' ),
		'media_uploaded_msg'							=>  __( 'Your image is uploaded, please click on "Save All"', 'sp-theme' ),
		'portfolio_template_msg'						=> __( 'You have selected a Portfolio Template.  To enable portfolio page options, please save the entry once with publish or save draft.', 'sp-theme' ), 		
		'apply_config_msg'								=> __( 'This will overwrite all your settings.  Are you sure you want to apply this configuration to your theme?', 'sp-theme' ),
		'delete_config_msg'								=> __( 'Are you sure you want to delete this configuration setting?', 'sp-theme' ),
		'maintenance_mode_msg'							=> __( 'Maintenance Mode Active', 'sp-theme' ),
		'page_builder_remove_column'					=> __( 'Warning, this column is not empty.  Are you sure you want to remove this column?', 'sp-theme' ),
		'page_builder_remove_row'						=> __( 'Warning, this row is not empty.  Are you sure you want to remove this row?', 'sp-theme' ),
		'page_builder_column_heading_text'				=> __( 'COLUMN', 'sp-theme' ),
		'page_builder_settings_done_text'				=> __( 'Done', 'sp-theme' ),
		'page_builder_settings_cancel_text'				=> __( 'Cancel', 'sp-theme' ),
		'page_builder_switcher_advanced_text'			=> __( 'Advanced Page Builder', 'sp-theme' ),
		'page_builder_switcher_default_text'			=> __( 'Default Editor', 'sp-theme' ),
		'custom_product_tabs_title_text'				=> __( 'Enter your title', 'sp-theme' ),
		'remove_alternate_product_image_text'			=> __( 'Remove Alternate Product Image', 'sp-theme' ),
		'set_alternate_product_image_text'				=> __( 'Set Alternate Product Image', 'sp-theme' ),
		'shortcodes_tinymce_title'						=> __( 'SP Shortcodes', 'sp-theme' ),
		'shortcodes_module'								=> json_encode( sp_shortcodes_module() ),
		'shortcodes_tinymce_icon'						=> THEME_URL . 'images/admin/shortcodes-icon.png',
		'shortcodes_tinymce_section_social_media'		=> __( 'Social Media', 'sp-theme' ),
		'shortcodes_tinymce_section_paths'				=> __( 'Paths &amp; URLs', 'sp-theme' ),
		'shortcodes_tinymce_section_products'			=> __( 'Products', 'sp-theme' ),
		'shortcodes_tinymce_section_sliders'			=> __( 'Sliders', 'sp-theme' ),
		'shortcodes_tinymce_section_forms'				=> __( 'Forms', 'sp-theme' ),
		'shortcodes_tinymce_section_boxes'				=> __( 'Boxes', 'sp-theme' ),
		'shortcodes_tinymce_section_formatting'			=> __( 'Formatting', 'sp-theme' ),
		'shortcodes_tinymce_section_audio_video'		=> __( 'Audio &amp; Video', 'sp-theme' ),
		'shortcodes_tinymce_shortcode_tab_content_msg'	=> __( 'ADD TAB CONTENT SHORTCODE HERE', 'sp-theme' ),
		'shortcodes_tinymce_shortcode_content_msg'		=> __( 'YOUR CONTENT HERE', 'sp-theme' ),
		'shortcodes_add_shortcode_button_text'			=> __( 'Add Shortcode', 'sp-theme' ),
		'shortcodes_module_setting_text'				=> __( 'Module Settings', 'sp-theme' ),
		'shortcodes_more_options_button_text'			=> __( 'More Options', 'sp-theme' ),
		'shortcodes_less_options_button_text'			=> __( 'Less Options', 'sp-theme' ),
		'contact_form_option_name'						=> __( 'Option Name', 'sp-theme' ),
		'contact_form_remove_option'					=> __( 'Remove', 'sp-theme' ),
		'contact_form_add_option'						=> __( 'Add Option', 'sp-theme' ),
		'contact_form_toggle_options'					=> __( 'Toggle Options', 'sp-theme' ),
		'confirm_install_sample_data_msg'				=> __( 'Are you sure you want to install the sample data?  This may overwrite contents already on your site.  Please note this process may take several minutes to complete.  Do not navigate away from this page until process is done.', 'sp-theme' ),
		'page_builder_default_editor_tab'               => apply_filters( 'wp_default_editor', 'tinymce' )
	);
	
	wp_localize_script( apply_filters( 'sp_admin_js', 'admin_js' ), 'sp_theme', $localized_vars );	

	// only load on menu page
	if ( $pagenow === 'nav-menus.php' ) {
		wp_register_script( apply_filters( 'sp_mega_menu', 'sp_mega_menu_js' ) , THEME_URL . 'js/admin-mega-menu' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), FRAMEWORK_VERSION, true );
		wp_enqueue_script( apply_filters( 'sp_mega_menu', 'sp_mega_menu_js' ) );

		wp_enqueue_media();
	}

	// enqueue admin styles
	wp_enqueue_style( 'sp_admin_style', THEME_URL . 'css/theme-admin-styles.css');	

}

add_action( 'customize_preview_init', '_sp_admin_customizer_preview_script' );

/**
 * Enqueues the customizer preview script
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_admin_customizer_preview_script() {
	global $sptheme_config;

	// check if dev mode is on
	if ( SP_DEV === true )
		$suffix = '';
	else 
		$suffix = '.min';

	// enqueue customizer script
	wp_enqueue_script( apply_filters( 'sp_customizer_preview_script', 'customizer_preview' ), THEME_URL . 'js/admin-customizer-preview' . $suffix . '.js', array( 'jquery','customize-preview', 'theme_js' ), THEME_VERSION, true );

	if ( is_array( $sptheme_config['init']['customizer'] ) ) {
		foreach ( $sptheme_config['init']['customizer'] as $setting ) {
    		$item[$setting['_attr']['id']] = array(
    			'std' => $setting['_attr']['std'],
    			'selector' => $setting['_attr']['selector'],
    			'property' => $setting['_attr']['property']
    		);
    	}
    }

	// localize the script
	$localized_vars = array(
		'customize_init' => $item,
		'site_title' => get_bloginfo( 'name' ),
		'logo_text'	=> __( 'Your Logo Here', 'sp-theme' ),
		'theme_url'	=> esc_url ( THEME_URL ),
		'saved' => get_theme_mods()
	);

	wp_localize_script( apply_filters( 'sp_customizer_preview_script', 'customizer_preview' ), 'sp_customize', $localized_vars );
}

add_action( 'customize_controls_enqueue_scripts', '_sp_admin_customize_controls_script' );

/**
 * Enqueues the customizer controls script
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_admin_customize_controls_script() {
	// check if dev mode is on
	if ( SP_DEV === true )
		$suffix = '';
	else 
		$suffix = '.min';

	// enqueue WP media uploader
	wp_enqueue_media();	
	
	// enqueue customizer script for control side
	wp_enqueue_script( apply_filters( 'sp_customizer_controls_script', 'customizer_controls' ), THEME_URL . 'js/admin-customizer-controls' . $suffix . '.js', null, THEME_VERSION, true );
	
	// localize the script
	$localized_vars = array(
		'ajaxurl'					=> admin_url( 'admin-ajax.php' ),
		'ajaxCustomNonce'			=> wp_create_nonce( '_sp_nonce' )
	);

	wp_localize_script( apply_filters( 'sp_customizer_controls_script', 'customizer_controls' ), 'sp_customize', $localized_vars );
}

add_action( 'customize_controls_print_styles', '_sp_admin_customize_controls_styles' );

/**
 * Loads the styles for customizer controls
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_admin_customize_controls_styles() {
	echo '<link rel="stylesheet" href="' . THEME_URL . 'css/theme-admin-customizer-controls-styles.css" />';
}

/**
 * Loads the script for shortcodes tinymce
 *
 * @access private
 * @since 3.0
 * @param array $plugin_array | existing plugins in tinymce
 * @return array $plugin_array | newly appended array
 */
function _sp_add_tinymce_plugin( $plugin_array ) {
	// check if dev mode is on
	if ( SP_DEV === true )
		$suffix = '';
	else 
		$suffix = '.min';

	$plugin_array['sp_shortcodes'] = THEME_URL . 'js/shortcodes-tinymce' . $suffix . '.js';

	wp_enqueue_script( 'jquery-ui-dialog' );

	return $plugin_array;
}