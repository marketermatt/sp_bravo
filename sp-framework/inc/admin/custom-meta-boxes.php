<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * custom meta boxes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_action( 'add_meta_boxes', '_sp_custom_meta_boxes' );

/**
 * Function that adds the custom meta boxes
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_custom_meta_boxes() {
	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : ( isset( $_POST['post_ID'] ) ? $_POST['post_ID'] : '');

	$template_file = get_post_meta( $post_id, '_wp_page_template', TRUE );

	/////////////////////////////////////////////////////
	// portfolio sort position
	/////////////////////////////////////////////////////
	add_meta_box(
		'portfolio-sort-position',
		__( 'Sort Position', 'sp-theme' ),
		'_sp_custom_box_portfolio_sort_position',
		'sp-portfolio',
		'side',
		'low' 
	);

	/////////////////////////////////////////////////////
	// slider carousel shortcode
	/////////////////////////////////////////////////////
	add_meta_box(
		'carousel-shortcode',
		__( 'Carousel Shortcode', 'sp-theme' ),
		'_sp_custom_box_carousel_shortcode',
		'sp-slider',
		'side',
		'low' 
	);

	/////////////////////////////////////////////////////
	// wpautop post
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_auto_formatting_post',
		__( 'Auto Content Formating', 'sp-theme' ),
		'_sp_custom_box_wpautop',
		'post',
		'side',
		'low' 
	);

	/////////////////////////////////////////////////////
	// wpautop page
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_auto_formatting_page',
		__( 'Auto Content Formating', 'sp-theme' ), 
		'_sp_custom_box_wpautop',
		'page',
		'side',
		'low'
	);	

	/////////////////////////////////////////////////////
	// wpatup portfolio
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_auto_formatting_portfolio',
		__( 'Auto Content Formating', 'sp-theme' ), 
		'_sp_custom_box_wpautop',
		'sp-portfolio',
		'side',
		'low'
	);	

	/////////////////////////////////////////////////////
	// custom page layout page
	/////////////////////////////////////////////////////
	// don't show on maintenance page
	if ( $template_file !== 'maintenance-page.php' ) {
		add_meta_box(
			'sp_page_layout',
			__( 'Custom Sidebar Layout', 'sp-theme' ), 
			'_sp_custom_box_layout',
			'page',
			'side',
			'low'
		);	
	}

	/////////////////////////////////////////////////////
	// custom page layout post
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_post_layout',
		__( 'Custom Sidebar Layout', 'sp-theme' ), 
		'_sp_custom_box_layout',
		'post',
		'side',
		'low'
	);	

	/////////////////////////////////////////////////////
	// custom page layout portfolio
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_portfolio_layout',
		__( 'Custom Sidebar Layout', 'sp-theme' ), 
		'_sp_custom_box_layout',
		'sp-portfolio',
		'side',
		'low'
	);

	/////////////////////////////////////////////////////
	// custom page layout product
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_product_layout',
		__( 'Custom Sidebar Layout', 'sp-theme' ), 
		'_sp_custom_box_layout',
		'product',
		'side',
		'low'
	);

	// check if SEO enabled
	if ( sp_get_option( 'seo_enable', 'is', 'on' ) || ! sp_get_option( 'seo_enable', 'isset' ) ) {

		/////////////////////////////////////////////////////
		// seo post
		/////////////////////////////////////////////////////
		add_meta_box(
			'sp_seo_settings',
			__( 'Seo Settings', 'sp-theme' ),
			'_sp_custom_box_seo_settings',
			'post'
		);

		/////////////////////////////////////////////////////
		// seo page
		/////////////////////////////////////////////////////
		// don't show on maintenance page
		if ( $template_file !== 'maintenance-page.php' ) {
			add_meta_box(
				'sp_seo_settings',
				__( 'Seo Settings', 'sp-theme' ),
				'_sp_custom_box_seo_settings',
				'page'
			);
		}

		/////////////////////////////////////////////////////
		// seo woo product
		/////////////////////////////////////////////////////
		add_meta_box(
			'sp_seo_settings',
			__( 'Seo Settings', 'sp-theme' ),
			'_sp_custom_box_seo_settings',
			'product'
		);

		/////////////////////////////////////////////////////
		// seo portfolio
		/////////////////////////////////////////////////////
		add_meta_box(
			'sp_seo_settings',
			__( 'Seo Settings', 'sp-theme' ),
			'_sp_custom_box_seo_settings',
			'sp-portfolio'
		);
	}
	
	/////////////////////////////////////////////////////
	// testimonial submitter
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_testimonial_submitter',
		__( 'Testimonial Submitter', 'sp-theme' ),
		'_sp_custom_box_testimonial_settings',
		'sp-testimonial',
		'side',
		'core'
	);   

	/////////////////////////////////////////////////////
	// advanced page options
	/////////////////////////////////////////////////////
	// don't show on maintenance page
	if ( $template_file !== 'maintenance-page.php' ) {	
		add_meta_box(
			'sp_advanced_page_options',
			__( 'Advanced Options', 'sp-theme' ),
			'_sp_custom_box_advanced_page_options',
			'page'
		);
	}

	/////////////////////////////////////////////////////
	// advanced post options
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_advanced_post_options',
		__( 'Advanced Options', 'sp-theme' ),
		'_sp_custom_box_advanced_page_options',
		'post'
	);

	/////////////////////////////////////////////////////
	// advanced portfolio options
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_advanced_portfolio_options',
		__( 'Advanced Options', 'sp-theme' ),
		'_sp_custom_box_advanced_page_options',
		'sp-portfolio'
	);

	/////////////////////////////////////////////////////
	// advanced woo product options
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_advanced_woo_product_options',
		__( 'Advanced Options', 'sp-theme' ),
		'_sp_custom_box_advanced_page_options',
		'product'
	);

	/////////////////////////////////////////////////////
	// contact form shortcode
	/////////////////////////////////////////////////////
	add_meta_box(
		'contact-form-shortcode',
		__( 'Contact Form Shortcode', 'sp-theme' ),
		'_sp_custom_box_contact_form_shortcode',
		'sp-contact-form',
		'side',
		'low' 
	);

	/////////////////////////////////////////////////////
	// contact form general settings
	/////////////////////////////////////////////////////
	add_meta_box(
		'contact-form-settings',
		__( 'Contact Form Settings', 'sp-theme' ),
		'_sp_custom_box_contact_form_settings',
		'sp-contact-form',
		'normal',
		'high'
	);
	
	/////////////////////////////////////////////////////
	// contact form content
	/////////////////////////////////////////////////////
	add_meta_box(
		'contact-form-content',
		__( 'Contact Form Content', 'sp-theme' ),
		'_sp_custom_box_contact_form_content',
		'sp-contact-form',
		'normal',
		'high'
	); 

	/////////////////////////////////////////////////////
	// contact form messages
	/////////////////////////////////////////////////////
	add_meta_box(
		'contact-form-messages',
		__( 'Contact Form Messages', 'sp-theme' ),
		'_sp_custom_box_contact_form_messages',
		'sp-contact-form',
		'normal',
		'high'
	);

	/////////////////////////////////////////////////////
	// page builder page
	/////////////////////////////////////////////////////
	// don't show on maintenance page
	if ( $template_file !== 'maintenance-page.php' ) {	
		add_meta_box(
			'page-builder',
			__( 'Page Builder', 'sp-theme' ),
			'_sp_custom_box_page_builder',
			'page',
			'normal',
			'high'
		);
	}

	/////////////////////////////////////////////////////
	// alternate product image on hover
	/////////////////////////////////////////////////////
	/*
	add_meta_box(
		'sp_alternate_product_image',
		__( 'Alternate Product Image', 'sp-theme' ),
		'_sp_custom_box_alternate_product_image',
		'product',
		'side',
		'low' 
	);
	*/

	/////////////////////////////////////////////////////
	// custom product tabs
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_custom_product_tabs',
		__( 'Product Tabs Option', 'sp-theme' ),
		'_sp_custom_product_tabs',
		'product',
		'normal',
		'low' 
	);

	/////////////////////////////////////////////////////
	// featured video post
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_featured_video',
		__( 'Featured Video', 'sp-theme' ), 
		'_sp_custom_box_featured_video',
		'post',
		'side',
		'low'
	);	

	/////////////////////////////////////////////////////
	// faq sort order
	/////////////////////////////////////////////////////
	add_meta_box(
		'sp_faq_order',
		__( 'Sort Order', 'sp-theme' ), 
		'_sp_custom_box_faq_order',
		'sp-faq',
		'side',
		'low'
	);	

	return true;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_portfolio_sort_position( $post ) {
	wp_nonce_field( '_sp_process_meta_portfolio_sort_position', '_sp_meta_portfolio_sort_position_nonce' );	

	if ( $post->ID ) 
		$position = absint( get_post_meta( $post->ID, '_sp_portfolio_sort_position', true ) );

	$output = '';

	$output .= '<div class="settings-container">' . PHP_EOL;	
	$output .= '<label for="sort-position" class="howto">' . __( 'Enter the sort position of this portfolio entry:', 'sp-theme' ) . '</label>' . PHP_EOL;
	$output .= '<input type="text" value="' . esc_attr( $position ) . '" name="portfolio_sort_position" id="sort-position" class="widefat" />' . PHP_EOL;
	$output .= '</div>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_carousel_shortcode( $post ) {

	$output = '';

	$output .= '<div class="settings-container">' . PHP_EOL;	
	$output .= sp_get_slider_shortcode( $post->ID ) . PHP_EOL;
	$output .= '<p class="howto">' . __( 'Paste this shortcode on the page you want this carousel slider to show.', 'sp-theme' ) . '</p>' . PHP_EOL;	
	$output .= '</div>' . PHP_EOL;

	echo $output;
}

add_action( 'edit_form_after_editor', '_sp_custom_box_slider_settings' );

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_slider_settings() {
	global $post;

	// bail if not correct post type
	if ( get_post_type() != 'sp-slider' )
		return;

	wp_nonce_field( '_sp_process_meta_slider_settings', '_sp_meta_slider_settings_nonce' );	

	if ( $post->ID ) {

		$output = '';
		$output .= '<div class="slider-settings-container accordion">' . PHP_EOL;
		$output .= '<h3 class="header"><span class="caret-closed"></span>' . __( 'Carousel Settings', 'sp-theme' ) . '<small>' . __( 'Please use the "Publish/Update" button to your right sidebar to save the settings in this box.', 'sp-theme' ) . '</small></h3>' . PHP_EOL;
		$output .= '<div class="accordion-container postbox">' . PHP_EOL;

		$slider_array = sp_get_slider_settings( $post->ID );

		$output .= '<div class="options-container inner-container">' . PHP_EOL; 

		foreach( $slider_array as $key => $value ) {
			$context = '';

			if ( isset( $value['context'] ) )
				$context = $value['context'];

			$output .= '<div class="row ' . $context . '">' . PHP_EOL;
			$output .= '<div class="' . sp_column_css( '', '', '5', '', '' ) . '">' . PHP_EOL;
			$output .= '<label>' . $value['label'] . '</label><br />' . PHP_EOL;
			
			// check if setting is found if not use standard
			if ( isset( $value['saved_setting'] ) && $value['saved_setting'] != '' )
				$setting = $value['saved_setting'];
			else
				$setting = $value['std'];

			switch( $value['field_type'] ) {
				case 'radio':
					$output .= '<label>' . PHP_EOL;
					$output .= '<input type="radio" name="' . esc_attr( $key ) . '" value="on" ' . checked( $setting, 'on', false ) . '/> ' . __( 'On', 'sp-theme' ) . '</label>' . PHP_EOL;
					$output .= '<label>' . PHP_EOL;
					$output .= '<input type="radio" name="' . esc_attr( $key ) . '" value="off"  ' . checked( $setting, 'off', false ) . '/> ' . __( 'Off', 'sp-theme' ) . '</label>' . PHP_EOL;
					break;
				
				case 'text':
					$output .= '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $setting ) . '" class="widefat" />' . PHP_EOL;
					break;
				
				case 'select':
					$output .= '<select name="' . esc_attr( $key ) . '" class="select2-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;

					// loop through the select options
					foreach( $value['attr'] as $v ) {
						$output .= '<option value="' . esc_attr( $v ) . '" ' . selected( $v, $setting, false ) . '>' . $v . '</option>' . PHP_EOL;
					}
					$output .= '</select>' . PHP_EOL;
					break;
				
				case 'colorpicker':
					$output .= '<input type="text" value="' . esc_attr( $setting ) . '" class="sp-colorpicker widefat" name="' . esc_attr( $key ) . '" />' . PHP_EOL;
					break;	
				
				case 'font':
					$fonts = sp_get_google_fonts();
					$output .= '<select name="' . esc_attr( $key ) . '" class="select2-select font-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;
					$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

					// loop through the select options
					foreach( $fonts as $font ) {
						$output .= '<option value="' . esc_attr( $font['family'] ) . '" ' . selected( $setting, $font['family'], false ) . '>' . $font['family'] . '</option>' . PHP_EOL;
					}

					$output .= '</select>' . PHP_EOL;
					break;	

				case 'font-variant':
					$output .= '<select name="' . esc_attr( $key ) . '" class="select2-select font-variant-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;
					$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

					$font = sp_get_font( get_post_meta( $post->ID, '_sp_slider_title_font', true ) );

					if ( isset( $font ) && is_array( $font ) ) {
						foreach( $font['variants'] as $variant ) {
							$output .= '<option value="' . esc_attr( $variant ) . '" ' . selected( $setting, $variant, false ) . '>' . $variant . '</option>' . PHP_EOL;
						}
					}
															
					$output .= '</select>' . PHP_EOL;
					break;	

				case 'font-subsets':
					$output .= '<select name="' . esc_attr( $key ) . '[]" class="select2-select font-subset-select" multiple data-placeholder="' . __( '--Please Select--', 'sp-theme' ) . '">' . PHP_EOL;
					$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

					$font = sp_get_font( get_post_meta( $post->ID, '_sp_slider_title_font', true ) );

					if ( isset( $font ) && is_array( $font ) ) {
						foreach( $font['subsets'] as $subset ) {
							if ( is_array( $setting ) && in_array( $subset, $setting ) )
								$selected = 'selected="selected"';
							else 
								$selected = '';

							$output .= '<option value="' . esc_attr( $subset ) . '" ' . $selected . '>' . $subset . '</option>' . PHP_EOL;
						}
					}
															
					$output .= '</select>' . PHP_EOL;
					break;

				case 'text-size':
					$output .= '<div class="size-slider">' . PHP_EOL;
					$output .= '<div class="values">' . PHP_EOL;
					$output .= '<span class="min">1px</span>' . PHP_EOL;
					$output .= '<span class="max">50px</span>' . PHP_EOL;
					$output .= '<span class="value">1px</span>' . PHP_EOL;
					$output .= '</div>' . PHP_EOL;
					$output .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $setting ) . '" />' . PHP_EOL;
					$output .= '<div class="slider"></div>' . PHP_EOL;
					$output .= '<a href="#" title="' . esc_attr__( 'Default', 'sp-theme' ) . '" data-default="' . esc_attr( $value['std'] ) . '" class="default-size button button-small">' . __( 'Default', 'sp-theme' ) . '</a>' . PHP_EOL;
					$output .= '</div>' . PHP_EOL;
					break;																
			}

			$output .= '</div><!--close .column-->' . PHP_EOL;

			$output .= '<div class="' . sp_column_css( '', '', '7', '', '' ) . '">' . PHP_EOL;
			$output .= '<p class="howto">' . $value['desc'] . '</p>' . PHP_EOL;
			$output .= '</div><!--close .column-->' . PHP_EOL;

			$output .= '</div><!--close .row-->' . PHP_EOL;
		}

		$output .= '</div><!--close .inner-container-->' . PHP_EOL;

		$output .= '</div><!--close .accordion-container-->' . PHP_EOL;
		$output .= '</div><!--close .slider-settings-container-->' . PHP_EOL;

		echo $output;
	}
}

add_action( 'edit_form_after_editor', '_sp_custom_box_slider_media' );

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_slider_media() {
	global $post;

	// bail if not correct post type
	if ( get_post_type() != 'sp-slider' )
		return;

	wp_nonce_field( '_sp_process_meta_slider_media', '_sp_meta_slider_media_nonce' );

	$output = '';

	$output .= '<div class="slider-media-container">' . PHP_EOL;
	$output .= '<h3 class="header">' . __( 'Carousel Media', 'sp-theme' ) . ' <small>(' . __( 'You can drag and drop to re-sort the order of each slide.  Order goes from left to right.  Left being first to display.  Click on the image to edit the slide.', 'sp-theme' ) . ')</small></h3>' . PHP_EOL;
	$output .= '<div class="inner-container postbox">' . PHP_EOL;
	$output .= '<div class="preview-box sortable">' . PHP_EOL;
	$output .= sp_display_slide_media( $post->ID );
	$output .= '</div><!--close preview-box-->' . PHP_EOL;
	$output .= '<a title="' . esc_attr__( 'Media Upload', 'sp-theme' ) . '" class="button slider-media-upload" data-uploader_button_text="' . esc_attr__( 'Select File', 'sp-theme' ) . '" data-uploader_title="' . esc_attr__( 'Add Media', 'sp-theme' ) . '" data-post-id="' . esc_attr( $post->ID ) . '">' . __( 'Add Image Media', 'sp-theme' ) . '</a>' . PHP_EOL;
	
	$output .= '<a href="#" title="' . esc_attr__( 'Add Content Media', 'sp-theme' ) . '" class="button add-slide-content">' . __( 'Add Content Media', 'sp-theme' ) . '</a>' . PHP_EOL;

	$output .= '<a href="#" title="' . esc_attr__( 'Add Video Link', 'sp-theme' ) . '" class="button add-slide-video-link">' . __( 'Add External Video Link', 'sp-theme' ) . '</a>' . PHP_EOL;

	$output .= '<div class="content-media-container">' . PHP_EOL;
	$output .= '<span class="slide-content-title">' . __( 'Enter content title:', 'sp-theme' ) . '</span>' . PHP_EOL;
	$output .= '<input type="text" name="slide_content_title" value="" class="slide-content-title-input" placeholder="' . esc_attr__( 'add a title for your content.', 'sp-theme' ) . '" />' . PHP_EOL;
	$output .= '<button type="submit" class="button button-primary submit-slide-content" data-post-id="' . esc_attr( $post->ID ) . '">' . __( 'Add Slide Content', 'sp-theme' ) . '</button>' . PHP_EOL;	
	$output .= '</div><!--close .content-media-container-->' . PHP_EOL;	

	$output .= '<div class="video-link-container">' . PHP_EOL;
	$output .= '<span class="slide-url-title">' . __( 'Enter URL:', 'sp-theme' ) . '</span>' . PHP_EOL;
	$output .= '<input type="text" name="slide_video_link" value="" class="slide-video-link-input" placeholder="' . esc_attr__( 'add the URL of the link here.', 'sp-theme' ) . '" />' . PHP_EOL;
	$output .= '<span class="slide-link-title">' . __( 'Title:', 'sp-theme' ). '</span>' . PHP_EOL;
	$output .= '<input type="text" name="slide_video_link_title" value="" class="slide-video-link-title-input" placeholder="' . esc_attr__( 'add a title for this link.', 'sp-theme' ) . '" />' . PHP_EOL;
	$output .= '<button type="submit" class="button button-primary submit-slide-video-link" data-post-id="' . esc_attr( $post->ID ) . '">' . __( 'Add Video Link', 'sp-theme' ) . '</button>' . PHP_EOL;	
	$output .= '</div><!--close .video-link-container-->' . PHP_EOL;
	$output .= '</div><!--close .inner-container-->' . PHP_EOL;
	$output .= '</div><!--close .slider-media-container-->' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_slide_settings() {
	global $post;

	// bail if not correct post type
	if ( get_post_type() != 'sp-slider' )
		return;

	wp_nonce_field( '_sp_process_meta_slide_settings', '_sp_meta_slide_settings_nonce' );

	$output = '';

	$output .= '<div class="slide-settings-container">' . PHP_EOL;
	$output .= '<h3 class="header">' . __( 'Slide Settings', 'sp-theme' ) . '<small>' . __( 'Please use the "Save" button below to save the settings in this box.', 'sp-theme' ) . '</small></h3>' . PHP_EOL;
	$output .= '<div class="inner-container postbox">' . PHP_EOL;

	$output .= '</div><!--close .inner-container-->' . PHP_EOL;
	$output .= '<div class="alert"><i class="icon-ok" aria-hidden="true"></i><i class="icon-ban-circle" aria-hidden="true"></i></div>' . PHP_EOL;
	$output .= '</div><!--close .slide-settings-container-->' . PHP_EOL;

	echo $output;
}

add_action( 'edit_form_after_editor', '_sp_custom_box_slide_settings' );

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_wpautop( $post ) {
	wp_nonce_field( '_sp_process_meta_wpautop', '_sp_meta_wpautop_nonce' );	

	if ( $post->ID )
		$setting = get_post_meta( $post->ID, '_sp_disable_wpautop', true );

	$output = '';
	$output .= '<label for="sp-wpautop"><input type="checkbox" value="on" name="wpautop" id="sp-wpautop"' . checked( $setting, 'on', false ) . ' /> ' . __( 'Disable WP Auto Content Formatting:', 'sp-theme' ) . ' </label><p class="howto">' . __( 'When disabled, it will prevent WordPress from automatically injecting break and paragraph tags which can cause some layout issues.  This is mostly used when you are using HTML mode and want fine control by entering HTML code yourself.', 'sp-theme' ) . '</p>';

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_layout( $post ) {
	wp_nonce_field( '_sp_process_meta_site_layout', '_sp_meta_site_layout_nonce' );	
	
	if ( $post->ID ) {
		$layout = get_post_meta( $post->ID, '_sp_custom_layout', true );	
		$disable_sitewide_widgets = get_post_meta( $post->ID, '_sp_custom_layout_disable_sitewide_widgets', true );
	}

	$output = '';
	$output .= '<p class="howto">' . __( 'Use this setting to override the global sidebar settings for this page/post.', 'sp-theme' ) . '</p>' . PHP_EOL;
	$output .= '<select name="custom_layout" class="select2-select">' . PHP_EOL;
	$output .= '<option value="default" ' . selected( $layout, 'default', false ) . '>' . __( 'Use Global', 'sp-theme' ) . '</option>';
	$output .= '<option value="sidebar-left" ' . selected( $layout, 'sidebar-left', false ) . '>' . __( 'Sidebar Left', 'sp-theme' ) . '</option>';
	$output .= '<option value="sidebar-right" ' . selected( $layout, 'sidebar-right', false ) . '>' . __( 'Sidebar Right', 'sp-theme' ). '</option>';
	$output .= '<option value="both-sidebars" ' . selected( $layout, 'both-sidebars', false ) . '>' . __( 'Both Sidebars', 'sp-theme' ) . '</option>';
	$output .= '<option value="no-sidebars" ' . selected( $layout, 'no-sidebars', false ) . '>' . __( 'No Sidebars', 'sp-theme' ) . '</option>';
	$output .= '</select>' . PHP_EOL;
	$output .= '<p><label><input type="checkbox" name="disable_sitewide_widgets" value="on" ' . checked( $disable_sitewide_widgets, 'on', false ) . ' /> ' . __( 'Disable Sitewide Sidebar Widgets: ', 'sp-theme' ) . '</label>' . PHP_EOL;
	$output .= '</p>' . PHP_EOL;
	$output .= '<p class="howto">' . __( 'Check box to disable display of the sitewide sidebar widgets for this page/post.', 'sp-theme' ) . '</p>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @todo may be removed as it is not being used currently
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_excerpt_truncate( $post ) {	
	wp_nonce_field( '_sp_process_meta_excerpt_truncate', '_sp_meta_excerpt_truncate_nonce' );	
	
	if ( $post->ID ) {
		$count = (int)get_post_meta( $post->ID, '_sp_truncate_count', true );
		$denote = get_post_meta( $post->ID, '_sp_truncate_denote', true );
		$excerpt_truncate = get_post_meta( $post->ID, '_sp_excerpt_truncate', true );
	}

	// check if truncate function is on
	if ( $excerpt_truncate == 'on' )
		$display = 'style="display:block"';
	else 
		$display = 'style="display:none"';

	$output = '';
	$output .= '<p class="howto">' . __( 'This section is to help manage the excerpt text for this post.  It allows you to have fine control over how much text from your content is shown on pages that shows only a snippet of your content.  If enabled, this will override your excerpt field.', 'sp-theme' ) . '</p>' . PHP_EOL;
	
	$output .= '<p><label><input type="checkbox" value="on" name="excerpt_truncate" id="excerpt-truncate"' . checked( $excerpt_truncate, 'on', false ) . ' /> ' . __( 'Enable Truncate Function', 'sp-theme' ) . ' </label></p>' . PHP_EOL;
	
	$output .= '<p class="howto">' . __( 'Check box to enable the auto text truncate function for this post.  If left disabled, the default truncate settings will apply on excerpt pages.', 'sp-theme' ) . '</p>' . PHP_EOL;
	
	$output .= '<div class="truncate-settings-container" ' . $display . '>' . PHP_EOL;	
		
	$output .= '<p><label>' . __( 'How Many Characters to Show', 'sp-theme' ) . '<input type="text" value="' . esc_attr( $count ) . '" name="truncate_count" id="truncate-count" class="widefat" /></label></p>' . PHP_EOL; 
	$output .= '<p class="howto">' . __( 'Choose how many characters to show before it starts to truncate. i.e. if you enter 500, it would show 500 characters before cutting off the rest.', 'sp-theme' ) . '</p>' . PHP_EOL;
	
	$output .= '<p><label>' . __( 'The Denote Character to Use', 'sp-theme' ) . '<input type="text" value="' . esc_attr( $denote ) . '" name="truncate_denote" id="truncate-denote" class="widefat" /></label></p>' . PHP_EOL;
	$output .= '<p class="howto">' . __( 'This character denotation is used to signify there are more text to be displayed. i.e. you can type ... or [...]', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '</div>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_seo_settings( $post ) {
	wp_nonce_field( '_sp_process_meta_seo_settings', '_sp_meta_seo_settings_nonce' );	
	
	$description = get_post_meta( $post->ID, '_sp_page_seo_description', true );
	$keywords = get_post_meta( $post->ID, '_sp_page_seo_keywords', true );
	$title = get_post_meta( $post->ID, '_sp_page_seo_title', true );
	$robot = get_post_meta( $post->ID, '_sp_page_seo_robot', true );

	$output = '';
	$output .= '<p class="howto">' . __( 'Here you can put in specific SEO meta description and meta keywords just for this page.  It will override the default general SEO settings.  This gives you fine grain control over each page.  Leaving it blank will use the default settings.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<p><label for="seo-title">' . __( 'Title - Enter the title you want the search engines to see.', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><input type="text" id="seo-title" name="seo_title" class="widefat" value="' . esc_attr( $title ) . '" /></p>' . PHP_EOL;	

	$output .= '<p><label for="seo-description">' . __( 'Meta Description - You want to keep your description under 160 characters long.', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><textarea id="seo-description" name="seo_description" class="widefat">' . $description . '</textarea></p>' . PHP_EOL;
	
	$output .= '<p><label for="seo-keywords">' . __( 'Meta Keywords - Separate each keyword by a comma.  You want to have no more than 30 keywords.', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><textarea id="seo-keywords" name="seo_keywords" class="widefat">' . $keywords . '</textarea></p>' . PHP_EOL;

	$output .= '<p><label for="robot">' . __( 'Robot Settings - allows you to set specific robot/spiders/crawlers to follow and index the page.', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><select id="robot" name="seo_robot" class="select2-select">' . PHP_EOL;
	$output .= '<option value="0" ' . selected( $robot, '0', false ) . '>' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;
	$output .= '<option value="index,nofollow" ' . selected( $robot, 'index,nofollow', false ) . '>' . __( 'Index, No Follow', 'sp-theme' ) . '</option>' . PHP_EOL;
	$output .= '<option value="index,follow" ' . selected( $robot, 'index,follow', false ) . '>' . __( 'Index, Follow', 'sp-theme' ) . '</option>' . PHP_EOL;
	$output .= '<option value="noindex,follow" ' . selected( $robot, 'noindex,follow', false ) . '>' . __( 'No Index, Follow', 'sp-theme' ) . '</option>' . PHP_EOL;
	$output .= '<option value="nofollow,noindex" ' . selected( $robot, 'nofollow,noindex', false ) . '>' . __( 'No Follow & No Index', 'sp-theme' ) . '</option>' . PHP_EOL;
	$output .= '</select>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_testimonial_settings( $post ) {
	wp_nonce_field( '_sp_process_meta_testimonial_settings', '_sp_meta_testimonial_settings_nonce' );	
	
	$name = get_post_meta( $post->ID, '_sp_testimonial_submitter_name', true );
	$email = get_post_meta( $post->ID, '_sp_testimonial_submitter_email', true );

	$output = '';

	$output .= '<p><label for="testimonial-name">' . __( 'Name - name of the submitter.', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><input type="text" id="testimonial-name" name="testimonial_name" class="widefat" value="' . esc_attr( $name ) . '" /></p>' . PHP_EOL;	

	$output .= '<p><label for="testimonial-email">' . __( 'Email - email of the submitter', 'sp-theme' ) . '</label></p>' . PHP_EOL;
	$output .= '<p><input type="text" id="testimonial-email" name="testimonial_email" class="widefat" value="' . esc_attr( $email ) . '" /></p>' . PHP_EOL;	

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_advanced_page_options( $post ) {
	wp_nonce_field( '_sp_process_meta_advanced_page_options', '_sp_meta_advanced_page_options_nonce' );	

	if ( $post->ID ) {
		$show_title = get_post_meta( $post->ID, '_sp_page_show_title', true );
		$show_tagline = get_post_meta( $post->ID, '_sp_page_show_tagline', true );
		$tagline = get_post_meta( $post->ID, '_sp_page_tagline_text', true );
		$show_share = get_post_meta( $post->ID, '_sp_page_show_share', true );
		$show_wishlist = get_post_meta( $post->ID, '_sp_page_show_wishlist', true );
		$show_compare = get_post_meta( $post->ID, '_sp_page_show_compare', true );
	}

	// set default
	if ( ! isset( $show_header_section ) || empty( $show_header_section ) )
		$show_header_section = 'on';

	if ( ! isset( $show_title ) || empty( $show_title ) )
		$show_title = 'on';

	// set default
	if ( ! isset( $show_tagline ) || empty( $show_tagline ) )
		$show_tagline = 'off';

	// set default
	if ( ! isset( $show_share ) || empty( $show_share ) )
		$show_share = 'on';

	// show by default if post type is a blog post else off for all others
	if ( get_post_type() === 'post' ) {
		if ( ! isset( $show_social_buttons ) || empty( $show_social_buttons ) )
			$show_social_buttons = 'on';
	} else {
		if ( ! isset( $show_social_buttons ) || empty( $show_social_buttons ) )
			$show_social_buttons = 'off';
	}

	// set default
	if ( ! isset( $show_breadcrumbs ) || empty( $show_breadcrumbs ) )
		$show_breadcrumbs = 'on';

	// set default
	if ( ! isset( $show_wishlist ) || empty( $show_wishlist ) )
		$show_wishlist = 'on';

	// set default
	if ( ! isset( $show_compare ) || empty( $show_compare ) )
		$show_compare = 'on';

	$output = '';

	$output .= '<p><strong>' . __( 'Show Page Title:', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="page_show_title" value="on" ' . checked( $show_title, 'on', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="page_show_title" value="off" ' . checked( $show_title, 'off', false ) . '/></label></p>' . PHP_EOL;

	$output .= '<p><strong>' . __( 'Show Page Tagline:', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="page_show_tagline" value="on" ' . checked( $show_tagline, 'on', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="page_show_tagline" value="off" ' . checked( $show_tagline, 'off', false ) . '/></label></p>' . PHP_EOL;

	$output .= '<p><strong>' . __( 'Page Tagline Text:', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
	$output .= '<p><input type="text" name="page_tagline_text" class="widefat" value="' . esc_attr( $tagline ) . '" /></p>' . PHP_EOL;

	$output .= '<p><strong>' . __( 'Show Social Share', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="page_show_share" value="on" ' . checked( $show_share, 'on', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="page_show_share" value="off" ' . checked( $show_share, 'off', false ) . '/></label></p>' . PHP_EOL;

	// check if post type is products
	if ( get_post_type() === 'product' ) {
		$output .= '<p><strong>' . __( 'Show Product Wishlist', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
		$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="page_show_wishlist" value="on" ' . checked( $show_wishlist, 'on', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="page_show_wishlist" value="off" ' . checked( $show_wishlist, 'off', false ) . '/></label></p>' . PHP_EOL;

		$output .= '<p><strong>' . __( 'Show Product Compare', 'sp-theme' ) . '</strong></p>' . PHP_EOL;	
		$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="page_show_compare" value="on" ' . checked( $show_compare, 'on', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="page_show_compare" value="off" ' . checked( $show_compare, 'off', false ) . '/></label></p>' . PHP_EOL;		
	}

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_contact_form_shortcode( $post ) {

	$output = '';

	$output .= '<div class="settings-container">' . PHP_EOL;	
	$output .= '[sp-contact id="' . $post->ID . '"]' . PHP_EOL;
	$output .= '<p class="howto">' . __( 'Paste this shortcode on the page you want this contact form to show.', 'sp-theme' ) . '</p>' . PHP_EOL;
	$output .= '</div>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_contact_form_settings( $post ) {
	wp_nonce_field( '_sp_process_meta_contact_form_settings', '_sp_meta_contact_form_settings_nonce' );	

	// get saved settings
	$email_to = get_post_meta( $post->ID, '_sp_contact_form_email_to', true );
	$email_subject = get_post_meta( $post->ID, '_sp_contact_form_email_subject', true );
	$redirect = get_post_meta( $post->ID, '_sp_contact_form_redirect', true );
	$redirect_url = get_post_meta( $post->ID, '_sp_contact_form_redirect_url', true );
	$show_reset = get_post_meta( $post->ID, '_sp_contact_form_show_reset', true );

	// if not set, set admin email as email to
	if ( ! isset( $email_to ) || empty( $email_to ) )
		$email_to = get_option( 'admin_email' );

	if ( ! isset( $email_subject ) || empty( $email_subject ) )
		$email_subject = '';

	if ( ! isset( $redirect ) || empty( $redirect ) )
		$redirect = 'off';

	if ( ! isset( $show_reset ) || empty( $show_reset ) )
		$show_reset = 'off';

	$output = '';

	$output .= '<table class="contact-form-tables">' . PHP_EOL;
	
	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Email To', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_email_to" value="' . esc_attr( $email_to ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the email where this form will be submitted to.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Email Subject', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_email_subject" value="' . esc_attr( $email_subject ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the email subject.  Leave blank to use the subject from user submission.  Be sure you have a unique form field with the id of "subject"', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Redirect After Form Submission', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><label for="redirect-on">' . __( 'On', 'sp-theme' ) . ' <input type="radio" name="contact_form_redirect" value="on" id="redirect-on" ' . checked( $redirect, 'on', false ) . '/></label> <label for="redirect-off">' . __( 'Off', 'sp-theme' ) . ' <input type="radio" name="contact_form_redirect" value="off" id="redirect-off" ' . checked( $redirect, 'off', false ) . ' /></label></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Choose whether you want the page to be redirected after the contact form has been successfully submitted.  "OFF" will stay on the same page.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Redirect URL', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_redirect_url" value="' . esc_attr( $redirect_url ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the absolute URL of where you want to redirect to.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Show Reset Button', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><label for="reset-on">' . __( 'On', 'sp-theme' ) . ' <input type="radio" name="contact_form_show_reset" value="on" id="reset-on" ' . checked( $show_reset, 'on', false ) . '/></label> <label for="reset-off">' . __( 'Off', 'sp-theme' ) . ' <input type="radio" name="contact_form_show_reset" value="off" id="reset-off" ' . checked( $show_reset, 'off', false ) . ' /></label></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Choose whether you want to show the reset button on the form.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '</table>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_contact_form_content( $post ) {
	wp_nonce_field( '_sp_process_meta_contact_form_content', '_sp_meta_contact_form_content_nonce' );

	$output = '';

	$output .= '<ul class="contact-form-header">' . PHP_EOL;
	
	$output .= '<li class="col1">' . __( 'Field type', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col2">' . __( 'Label', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col3">' . __( 'Required', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col4">' . __( 'Unique Tag Name', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col5"></li>' . PHP_EOL;
	$output .= '<li class="col6"></li>' . PHP_EOL;
	$output .= '</ul>' . PHP_EOL;

	$output .= '<div class="field-container">' . PHP_EOL;

	// build field type array
	$field_types = array( __( 'Text Input', 'sp-theme' ) => 'text', __( 'Email Input', 'sp-theme' ) => 'email', __( 'Text Area', 'sp-theme' ) => 'textarea', __( 'Radio Selection', 'sp-theme' ) => 'radio', __( 'Check Box', 'sp-theme' ) => 'checkbox', __( 'Select Dropdown', 'sp-theme' ) => 'select', __( 'Multi-Select Dropdown', 'sp-theme' ) => 'multiselect', __( 'Date Picker', 'sp-theme' ) => 'datepicker', __( 'Date Time Picker', 'sp-theme' ) => 'datetimepicker', __( 'Captcha', 'sp-theme' ) => 'captcha', __( 'Heading', 'sp-theme' ) => 'heading', 'Separator' => 'separator' );

	$field_type = get_post_meta( $post->ID, '_sp_contact_form_field_type', true );
	$field_label = get_post_meta( $post->ID, '_sp_contact_form_field_label', true );
	$required_field = get_post_meta( $post->ID, '_sp_contact_form_required_field', true );
	$unique_tag_name = get_post_meta( $post->ID, '_sp_contact_form_unique_tag_name', true );
	$field_options = get_post_meta( $post->ID, '_sp_contact_form_field_options', true );

	$fields = count( $field_type );

	if ( ! is_array( $field_type ) ) {
		$output .= '<div class="contact-form-field-item" data-field-id="1">' . PHP_EOL;
		$output .= '<ul>' . PHP_EOL;
		$output .= '<li class="col1"><select name="field_type[]" class="select2-select field-type">' . PHP_EOL;
		
		foreach( $field_types as $k => $v ) {
			$output .= '<option value="' . esc_attr( $v ) . '">' . $k . '</option>' . PHP_EOL;
		}

		$output .= '</select></li>' . PHP_EOL;
		$output .= '<li class="col2"><input type="text" name="field_label[]" value="" class="field-label" /></li>' . PHP_EOL;
		$output .= '<li class="col3"><input type="checkbox" value="on" class="required-cb" /><input type="hidden" name="required_field[]" value="off" class="hidden-required" /></li>' . PHP_EOL;
		$output .= '<li class="col4"><input type="text" name="unique_tag_name[]" value="" class="tag-name" /></li>' . PHP_EOL;
		$output .= '<li class="col5"><a href="#" class="remove-field button" title="' . esc_attr__( 'Remove Element', 'sp-theme' ) . '">' . __( 'Remove', 'sp-theme' ) . '</a></li>' . PHP_EOL;
		$output .= '<li class="col6"><i class="icon-reorder form-field-handle" aria-hidden="true"></i></li>' . PHP_EOL;
		$output .= '</ul>' . PHP_EOL;
		$output .= '</div><!--close .contact-form-field-item-->' . PHP_EOL;
	} elseif ( $fields > 0 ) {

		for ( $i = 1; $i <= $fields; $i++ ) {
			$output .= '<div class="contact-form-field-item" data-field-id="' . esc_attr( $i ) . '">' . PHP_EOL;
			$output .= '<ul>' . PHP_EOL;
			$output .= '<li class="col1"><select name="field_type[]" class="select2-select field-type">' . PHP_EOL;
			
			foreach( $field_types as $k => $v ) {
				$output .= '<option value="' . esc_attr( $v ) . '" ' . selected( $v, $field_type['field_' . $i], false ) . '>' . $k . '</option>' . PHP_EOL;
			}

			if ( ! isset( $required_field['field_' . $i] ) )
				$required_field['field_' . $i] = 'off';

			if ( ! isset( $field_sort_order['field_' . $i] ) )
				$field_sort_order['field_' . $i] = '1';

			if ( ! isset( $unique_tag_name['field_' . $i] ) )
				$unique_tag_name['field_' . $i] = '';

			$output .= '</select></li>' . PHP_EOL;

			// check the field type and hidden non required items
			if ( $field_type['field_' . $i] === 'heading' || $field_type['field_' . $i] === 'separator' ) {
				$required_field_style = 'style="display:none;"';
				$tag_name_style = 'style="display:none;"';
				$field_label_style = '';

				if ( $field_type['field_' . $i] === 'separator' )
					$field_label_style = 'style="display:none;"';
			} else {
				$required_field_style = '';
				$tag_name_style = '';
				$field_label_style = '';
			}

			$output .= '<li class="col2"><input type="text" name="field_label[]" value="' . esc_attr( $field_label['field_' . $i] ) . '" class="field-label" ' . $field_label_style . ' /></li>' . PHP_EOL;

			if ( $field_type['field_' . $i] === 'captcha' ) {
				$output .= '<li class="col3">&nbsp;&nbsp;<input type="hidden" name="required_field[]" value="on" class="hidden-required" /></li>' . PHP_EOL;
			} else {
				$output .= '<li class="col3"><input type="checkbox" value="on" ' . checked( 'on', $required_field['field_' . $i], false ) . ' class="required-cb" ' . $required_field_style . '/><input type="hidden" name="required_field[]" value="' . esc_attr( $required_field['field_' . $i] ) . '" class="hidden-required" /></li>' . PHP_EOL;
			}

			$output .= '<li class="col4"><input type="text" name="unique_tag_name[]" value="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="tag-name" ' . $tag_name_style . '/></li>' . PHP_EOL;
			$output .= '<li class="col5"><a href="#" class="remove-field button" title="' . esc_attr__( 'Remove Element', 'sp-theme' ) . '">' . __( 'Remove', 'sp-theme' ) . '</a></li>' . PHP_EOL;
			$output .= '<li class="col6"><i class="icon-reorder form-field-handle" aria-hidden="true"></i></li>' . PHP_EOL;
			$output .= '</li>' . PHP_EOL;	
			$output .= '</ul>' . PHP_EOL;

			// if there are options
			if ( isset( $field_options['field_' . $i] ) && $field_options['field_' . $i] > 0 && ( $field_type['field_' . $i] === 'select' || $field_type['field_' . $i] === 'radio' || $field_type['field_' . $i] === 'multiselect' ) ) {
				foreach( $field_options['field_' . $i] as $field_option ) {
					$output .= '<ul class="option-row"><li><i class="icon-options-indicator" aria-hidden="true"></i> ' . __( 'Option Name', 'sp-theme' ) . ' <input type="text" name="field_options[][field_' . $i . '][]" value="' . esc_attr( $field_option ) . '" /> <a href="#" class="remove-option button" title="' . esc_attr__( 'Remove Option', 'sp-theme' ) . '">' . __( 'Remove', 'sp-theme' ) . '</a><i class="icon-reorder option-field-handle" aria-hidden="true"></i></li></ul>' . PHP_EOL;
				}

				$output .= '<ul class="add-option-row"><li><i class="icon-options-indicator" aria-hidden="true"></i> <a href="#" class="add-option button" title="' . esc_attr__( 'Add Option', 'sp-theme' ) . '">' . __( 'Add Option', 'sp-theme' ) . '</a><a href="#" title="' . esc_attr__( 'Toggle Options', 'sp-theme' ) . '" class="toggle-options button">' . __( 'Toggle Options', 'sp-theme' ) . '</a></li></ul>' . PHP_EOL;
			}

			$output .= '</div><!--close .contact-form-field-item-->' . PHP_EOL;				
		}
	}

	$output .= '</div><!--close .field-container-->' . PHP_EOL;
	$output .= '<ul class="contact-form-header bottom">' . PHP_EOL;
	
	$output .= '<li class="col1">' . __( 'Field type', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col2">' . __( 'Label', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col3">' . __( 'Required', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col4">' . __( 'Unique Tag Name', 'sp-theme' ) . '</li>' . PHP_EOL;
	$output .= '<li class="col5"></li>' . PHP_EOL;
	$output .= '<li class="col6"></li>' . PHP_EOL;
	$output .= '</ul>' . PHP_EOL;

	$output .= '<a href="#" class="add-field button" title="' . esc_attr__( 'Add Field', 'sp-theme' ) . '">' . __( 'Add Field', 'sp-theme' ) . '</a>' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_contact_form_messages( $post ) {
	wp_nonce_field( '_sp_process_meta_contact_form_messages', '_sp_meta_contact_form_messages_nonce' );

	// get saved settings
	$header_text			= get_post_meta( $post->ID, '_sp_contact_form_header_text', true );
	$submit_button_text		= get_post_meta( $post->ID, '_sp_contact_form_submit_button_text', true );
	$reset_button_text		= get_post_meta( $post->ID, '_sp_contact_form_reset_button_text', true );
	$success_message		= get_post_meta( $post->ID, '_sp_contact_form_success_message', true );
	$failure_message		= get_post_meta( $post->ID, '_sp_contact_form_failure_message', true );
	$required_field_text	= get_post_meta( $post->ID, '_sp_contact_form_required_field_text', true );
	$email_template			= get_post_meta( $post->ID, '_sp_contact_form_email_template', true );

	// set defaults

	if ( ! isset( $submit_button_text ) || empty( $submit_button_text ) )
		$submit_button_text = __( 'Submit', 'sp-theme' );

	if ( ! isset( $reset_button_text ) || empty( $reset_button_text ) )
		$reset_button_text = __( 'Reset Form', 'sp-theme' );

	if ( ! isset( $success_message ) || empty( $success_message ) )
		$success_message = __( 'The form was successfully submitted.  Thanks!', 'sp-theme' );

	if ( ! isset( $failure_message ) || empty( $failure_message ) )
		$failure_message = __( 'Sorry! We are not able to submit your form.  Please try later.', 'sp-theme' );

	if ( ! isset( $from_email ) || empty( $from_email ) )
		$from_email = get_option( 'admin_email' );

	$output = '';

	$output .= '<table class="contact-form-tables">' . PHP_EOL;
	
	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Form Header Text', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_header_text" value="' . esc_attr( $header_text ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the text for your form header.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Submit Button Text', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_submit_button_text" value="' . esc_attr( $submit_button_text ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the text to show for your submit button.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Reset Button Text', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_reset_button_text" value="' . esc_attr( $reset_button_text ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the text to show for your reset button.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Success Message', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_success_message" value="' . esc_attr( $success_message ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the message you would like to show when the form was successfully submitted.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Failure Message', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_failure_message" value="' . esc_attr( $failure_message ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the message you would like to show when the form fails to submit.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Required Field Text', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><input type="text" name="contact_form_required_field_text" value="' . esc_attr( $required_field_text ) . '" class="widefat" /></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'Enter the text you would like to show when a field is required.', 'sp-theme' ) . '</p></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '<tr>' . PHP_EOL;
	$output .= '<td class="col1">' . __( 'Email Template', 'sp-theme' ) . ':</td>' . PHP_EOL;
	$output .= '<td class="col2"><textarea name="contact_form_email_template" class="widefat" rows="20">' . esc_html( $email_template ) . '</textarea></td>' . PHP_EOL;
	$output .= '<td class="col3"><p class="howto">' . __( 'This is the email template you will see as the admin when someone contacts you with this form.  You can modify it to your liking.  Use the unique tag names to pull in the entered data from the form.  For example "First Name:[firstname]".  This will replace the firstname in between the brackets with the data people entered.', 'sp-theme' ) . '</p><br /><a href="#" title="' . esc_attr__( 'Do it for me', 'sp-theme' ) . '" class="populate-template button">' . __( 'Do it for me!', 'sp-theme' ) . '</a></td>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;

	$output .= '</table>' . PHP_EOL;


	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_page_builder( $post ) {
	wp_nonce_field( '_sp_process_meta_page_builder', '_sp_meta_page_builder_nonce' );	

	// get draggable modules
	$module_list = _sp_get_page_builder_module_list();

	$output = '';

	// get saved status
	$status = get_post_meta( $post->ID, '_sp_page_builder_status', true );

	// get saved cache
	$cache = get_post_meta( $post->ID, '_sp_page_builder_cache', true );

	if ( empty( $cache ) ) {
		$cache = 'on';
	}

	// get saved modules
	$allmodules = get_post_meta( $post->ID, '_sp_page_builder_modules', true );

	// get saved outer container style
	$pb_outer_container_style = get_post_meta( $post->ID, '_sp_page_builder_outer_container_style', true );

	if ( ! is_string( $allmodules ) ) {
		$allmodules = '';
	} else {
		$allmodules = maybe_unserialize( base64_decode( $allmodules ) );
	}

	// set default state to off
	if ( ! isset( $status ) || empty( $status ) )
		$status = 'off';

	// set default outer container style
	if ( ! isset( $pb_outer_container_style ) || empty( $pb_outer_container_style ) )
		$pb_outer_container_style = 'full_width';

	$output .= '<div class="page-builder-section">' . PHP_EOL;
	
	$output .= '<div class="inner">' . PHP_EOL;
	$output .= '<p><label><strong>' . __( 'Enable Section:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Enable', 'sp-theme' ) . ' <input type="radio" name="pb_status" value="on" ' . checked( $status, 'on', false ) . ' /></label> <label>' . __( 'Disable', 'sp-theme' ) . ' <input type="radio" name="pb_status" value="off" ' . checked( $status, 'off', false ) . ' /></label></p>' . PHP_EOL;

	//$output .= '<p><label><strong>' . __( 'Enable Cache (speeds up page load):', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	//$output .= '<p><label>' . __( 'Enable', 'sp-theme' ) . ' <input type="radio" name="pb_cache" value="on" ' . checked( $cache, 'on', false ) . ' /></label> <label>' . __( 'Disable', 'sp-theme' ) . ' <input type="radio" name="pb_cache" value="off" ' . checked( $cache, 'off', false ) . ' /></label></p>' . PHP_EOL;

	$output .= '<p><label><strong>' . __( 'Outer Container Style:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Full Width', 'sp-theme' ) . ' <input type="radio" name="pb_outer_container_style" value="full_width" ' . checked( $pb_outer_container_style, 'full_width', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Boxed Width', 'sp-theme' ) . ' <input type="radio" name="pb_outer_container_style" value="boxed_width" ' . checked( $pb_outer_container_style, 'boxed_width', false ) . ' /></label></p>' . PHP_EOL;

	$output .= '<p><a href="#" title="' . esc_attr__( 'Add Row', 'sp-theme' ) . '" class="add-row button">' . __( 'Add Row', 'sp-theme' ) . '</a></p>' . PHP_EOL;

	$output .= '<p><a href="#" title="' . esc_attr__( 'Collapse Rows', 'sp-theme' ) . '" class="collapse-rows">[' . __( 'Collapse Rows', 'sp-theme' ) . ']</a></p>' . PHP_EOL;

	$output .= '<div class="rows-wrapper">' . PHP_EOL;

	if ( is_array( $allmodules ) ) {
		$i = 0;
		$row_count = 1;

		$column_selection_arr = _sp_get_page_builder_column_selection_arr();

		foreach( $allmodules['row'] as $row ) {
			$output .= '<div class="row-container">' . PHP_EOL;
			$output .= '<h3 class="row-heading">' . __( 'ROW', 'sp-theme' ) . ' <span class="row-count">' . $row_count . '</span></h3>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Collapse Row', 'sp-theme' ) . '" class="collapse-row"><i class="icon-caret-down" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Remove Row', 'sp-theme' ) . '" class="remove-row"><i class="icon-remove-sign" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Drag Reorder', 'sp-theme' ) . '" class="reorder-row"><i class="icon-reorder" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<div class="row-inner clearfix">' . PHP_EOL;
			$output .= '<p class="column-layout">' . __( 'Choose Column Layout', 'sp-theme' ) . '<br />';

			// get number of columns set
			$num_columns = -1;

			if ( isset( $row['column'] ) )
				$num_columns = count( $row['column'] );	

			// build the columns selection
			$c = 1;

			// set default for row column class
			if ( ! isset( $row['row_column_class'] ) ) {
				$row_column_class = 'one';
			} else {
				$row_column_class = $row['row_column_class'];
			}

			foreach( $column_selection_arr as $column ) {
				$active = '';

				
				if ( $row_column_class === $column['column_class'] ) {
					$active = 'active';
				}

				switch( $column['column_class'] ) :
					case 'one':
						$column_class = 'icon-1-column';
						break;

					case 'two':
						$column_class = 'icon-2-columns';
						break;

					case 'three':
						$column_class = 'icon-3-columns';
						break;

					case 'four':
						$column_class = 'icon-4-columns';
						break;

					case 'five':
						$column_class = 'icon-5-columns';
						break;

					case 'six':
						$column_class = 'icon-6-columns';
						break;

					case 'one-third':
						$column_class = 'icon-one-third';
						break;

					case 'two-third':
						$column_class = 'icon-two-third';
						break;

					case 'two-sidebars':
						$column_class = 'icon-two-sidebars';
						break;

					case 'one-fourth':
						$column_class = 'icon-one-third';
						break;

					case 'three-fourth':
						$column_class = 'icon-two-third';
						break;

				endswitch;

				$output .= '<a href="#" title="' . esc_attr( $column['column_title'] ) . '" class="' . esc_attr( $column['column_class'] ) . ' ' . esc_attr( $active ) . ' sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="' . esc_attr( $column['column_class'] ) . '"><i class="' . esc_attr( $column_class ) . '" aria-hidden="true"></i></a>' . PHP_EOL;

				$c++;
			}

			$output .= '</p>' . PHP_EOL;

			// set default for row_status
			if ( ! isset( $row['row_status'] ) ) {
				$row_status = 'show_row';
			} else {
				$row_status = $row['row_status'];
			}

			$output .= '<p class="row-status"><label>' . __( 'Show Row', 'sp-theme' ) . ' <input type="radio" name="pb[row][' . $i . '][row_status]" value="show_row" ' . checked( $row_status, 'show_row', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Hide Row', 'sp-theme' ) . ' <input type="radio" name="pb[row][' . $i . '][row_status]" value="hide_row" ' . checked( $row_status, 'hide_row', false ) . ' /></label></p>' . PHP_EOL;

			// set default for row_width
			if ( ! isset( $row['row_width'] ) ) {
				$row_width = 'boxed_width';
			} else {
				$row_width = $row['row_width'];
			}

			$output .= '<p class="row-width"><label>' . __( 'Full Width', 'sp-theme' ) . ' <input type="radio" name="pb[row][' . $i . '][row_width]" value="full_width" ' . checked( $row_width, 'full_width', false ) . ' /></label>&nbsp;&nbsp;<label>' . __( 'Boxed Width', 'sp-theme' ) . ' <input type="radio" name="pb[row][' . $i . '][row_width]" value="boxed_width" ' . checked( $row_width, 'boxed_width', false ) . ' /></label></p>' . PHP_EOL;

			$output .= '<input type="hidden" name="pb[row][' . $i . '][row_column_class]" value="' . esc_attr( $row_column_class ) . '" class="pb-row-columns" />' . PHP_EOL;

			$output .= '<div class="columns-wrapper clearfix">' . PHP_EOL;

			if ( isset( $row['column'] ) ) {
				$col_count = 1;

				foreach( $row['column'] as $column ) {
					switch( count( $row['column'] ) ) {
						case 1 :
							$columns_class = 'one';
							break;
						case 2 :
							// check if columns are one third and two third
							if ( isset( $row['row_column_class'] ) && 'one-third' === $row['row_column_class'] ) {
								$columns_class = 'one-third';
							} elseif ( isset( $row['row_column_class'] ) && 'two-third' === $row['row_column_class'] ) {
								$columns_class = 'two-third';
							} elseif ( isset( $row['row_column_class'] ) && 'one-fourth' === $row['row_column_class'] ) {
								$columns_class = 'one-fourth';
							} elseif ( isset( $row['row_column_class'] ) && 'three-fourth' === $row['row_column_class'] ) {
								$columns_class = 'three-fourth';
							} else {
								$columns_class = 'two';
							}
							break;
						case 3 :
							// check if columns are one third and two third
							if ( isset( $row['row_column_class'] ) && 'two-sidebars' === $row['row_column_class'] ) {
								$columns_class = 'two-sidebars';
							} else {
								$columns_class = 'three';
							}
							break;
						case 4 :
							$columns_class = 'four';
							break;
						case 5 :
							$columns_class = 'five';
							break;
						case 6 :
							$columns_class = 'six';
							break;									
					}	
										
					$output .= '<div class="column ' . esc_attr( $columns_class ) . '">' . PHP_EOL;
					$output .= '<h3 class="column-heading">' . __( 'COLUMN', 'sp-theme' ) . ' <span class="col-count">' . $col_count . '</span></h3>' . PHP_EOL;
					$output .= '<div class="inner">' . PHP_EOL;

					if ( isset( $column['module'] ) ) {
						foreach( $column['module'] as $module ) {
							$output .= _sp_get_page_builder_module( $post->ID, key( $module ), $module );
						}
					}

					$output .= '</div><!--close .inner-->' . PHP_EOL;
					$output .= '</div><!--close .column-->' . PHP_EOL;

					$col_count++;					
				} // column loop
			}

			$output .= '</div><!--close .columns-wrapper-->' . PHP_EOL;

			// modules
			$output .= '<div class="modules">' . PHP_EOL;
			$output .= '<p class="howto">' . __( 'Drag below modules into the columns above.  Each module can be reordered by drag and drop.', 'sp-theme' ) . '</p>' . PHP_EOL;

			foreach( $module_list as $k => $v ) {
				$output .= '<div class="module" data-id="' . esc_attr( $k ) . '">' . $v . '</div>' . PHP_EOL;
			}

			$output .= '</div><!--close .modules-->' . PHP_EOL;

			$output .= '</div><!--close .row-inner-->' . PHP_EOL;

			$output .= '</div><!--close .row-->' . PHP_EOL;

			$i++;
			$row_count++;			
		} // row loop
	} else {
		$output .= '<div class="row-container">' . PHP_EOL;
		$output .= '<h3 class="row-heading">' . __( 'ROW', 'sp-theme' ) . ' <span class="row-count">1</span></h3>' . PHP_EOL;
		$output .= '<a href="#" title="' . esc_attr__( 'Collapse Row', 'sp-theme' ) . '" class="collapse-row"><i class="icon-caret-down" aria-hidden="true"></i></a>' . PHP_EOL;
		$output .= '<a href="#" title="' . esc_attr__( 'Remove Row', 'sp-theme' ) . '" class="remove-row"><i class="icon-remove-sign" aria-hidden="true"></i></a>' . PHP_EOL;
		$output .= '<a href="#" title="' . esc_attr__( 'Drag Reorder', 'sp-theme' ) . '" class="reorder-row"><i class="icon-reorder" aria-hidden="true"></i></a>' . PHP_EOL;
		$output .= '<div class="row-inner clearfix">' . PHP_EOL;
		$output .= '<p class="column-layout">' . __( 'Choose Column Layout', 'sp-theme' ) . '<br /><a href="#" title="' . esc_attr__( 'One Column', 'sp-theme' ) . '" class="one active sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="one"><i class="icon-1-column" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Two Columns', 'sp-theme' ) . '" class="two sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="two"><i class="icon-2-columns" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Three Columns', 'sp-theme' ) . '" class="three sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="three"><i class="icon-3-columns" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Four Columns', 'sp-theme' ) . '" class="four sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="four"><i class="icon-4-columns" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Five Columns', 'sp-theme' ) . '" class="five sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="five"><i class="icon-5-columns" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Six Columns', 'sp-theme' ) . '" class="six sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="six"><i class="icon-6-columns" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'One Third Column', 'sp-theme' ) . '" class="one-third sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="one-third"><i class="icon-one-third" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Two Third Column', 'sp-theme' ) . '" class="two-third sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="two-third"><i class="icon-two-third" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Two Sidebars Column', 'sp-theme' ) . '" class="two-sidebars sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="two-sidebars"><i class="icon-two-sidebars" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'One Fourth Column', 'sp-theme' ) . '" class="one-fourth sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="one-fourth"><i class="icon-one-third" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Three Fourth Column', 'sp-theme' ) . '" class="three-fourth sp-tooltip" data-toggle="tooltip" data-placement="top" data-column="three-fourth"><i class="icon-two-third" aria-hidden="true"></i></a></p>' . PHP_EOL;

		$output .= '<p class="row-status"><label>' . __( 'Show Row', 'sp-theme' ) . ' <input type="radio" name="pb[row][0][row_status]" value="show_row" checked="checked" /></label>&nbsp;&nbsp;<label>' . __( 'Hide Row', 'sp-theme' ) . ' <input type="radio" name="pb[row][0][row_status]" value="hide_row" /></label></p>' . PHP_EOL;

		$output .= '<p class="row-width"><label>' . __( 'Full Width', 'sp-theme' ) . ' <input type="radio" name="pb[row][0][row_width]" value="full_width" /></label>&nbsp;&nbsp;<label>' . __( 'Boxed Width', 'sp-theme' ) . ' <input type="radio" name="pb[row][0][row_width]" value="boxed_width" checked="checked" /></label></p>' . PHP_EOL;

		$output .= '<input type="hidden" name="pb[row][0][column_class]" value="one" class="pb-row-columns" />' . PHP_EOL;

		$output .= '<div class="columns-wrapper clearfix">' . PHP_EOL;
		$output .= '</div><!--close .columns-wrapper-->' . PHP_EOL;

		// modules
		$output .= '<div class="modules">' . PHP_EOL;
		$output .= '<p class="howto">' . __( 'Drag below modules into the columns above.  Each module can be reordered by drag and drop.', 'sp-theme' ) . '</p>' . PHP_EOL;

		foreach( $module_list as $k => $v ) {
			$output .= '<div class="module" data-id="' . esc_attr( $k ) . '">' . $v . '</div>' . PHP_EOL;
		}

		$output .= '</div><!--close .modules-->' . PHP_EOL;

		$output .= '</div><!--close .row-inner-->' . PHP_EOL;

		$output .= '</div><!--close .row-->' . PHP_EOL;			
	}

	$output .= '</div><!--close .rows-wrapper-->' . PHP_EOL;

	$output .= '<p><a href="#" title="' . esc_attr__( 'Add Row', 'sp-theme' ) . '" class="add-row button">' . __( 'Add Row', 'sp-theme' ) . '</a></p>' . PHP_EOL;

	$output .= '</div><!--close .inner-->' . PHP_EOL;
	$output .= '</div><!--close .page-builder-section-->' . PHP_EOL;

	$output .= '<input type="hidden" name="page_builder_form" value="saving" />' . PHP_EOL;
	$output .= '<input type="hidden" name="post_id" value="' . esc_attr( $post->ID ) . '" />' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom meta box settings
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_alternate_product_image( $post ) {
	wp_nonce_field( '_sp_alternate_product_image', '_sp_alternate_product_image_nonce' );

	// get saved settings
	$image_id = absint( get_post_meta( $post->ID, '_sp_alternate_product_image_id', true ) );
	$hover_status = get_post_meta( $post->ID, '_sp_alternate_product_image_on_hover_status', true );

	// set a default
	if ( ! isset( $hover_status ) || empty( $hover_status ) )
		$hover_status = 'off';

	if ( isset( $image_id ) && ! empty( $image_id ) ) {
		$image = wp_get_attachment_image_src( $image_id, array( 175, 175 ) );
	}

	$output = '';
	$output .= '<p class="howto">' . __( 'This sets an alternate image for your product when mouse is hovered.  Works in category view only.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<p><label><strong>' . __( 'Enable Image Swap on Mouse Hover:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Enable', 'sp-theme' ) . ' <input type="radio" name="alternate_image_hover_status" value="on" ' . checked( $hover_status, 'on', false ) . ' /></label> <label>' . __( 'Disable', 'sp-theme' ) . ' <input type="radio" name="alternate_image_hover_status" value="off" ' . checked( $hover_status, 'off', false ) . ' /></label></p>' . PHP_EOL;

	if ( isset( $image ) && ! empty( $image ) ) {
		$output .= '<p class="hide-if-no-js"><a href="#" class="alternate-product-image-media-upload" data-post-id="' . esc_attr( $post->ID ) . '"><img src="' . esc_attr( $image[0] ) . '" width="' . esc_attr( $image[1] ) . '" height="' . esc_attr( $image[2] ) . '" /></a></p>' . PHP_EOL;
		$output .= '<p class="hide-if-no-js"><a href="#" class="remove-alternate-product-image">' . __( 'Remove Alternate Product Image', 'sp-theme' ) . '</a></p>' . PHP_EOL;
	} else {
		$output .= '<p class="hide-if-no-js"><a href="#" class="alternate-product-image-media-upload" data-post-id="' . esc_attr( $post->ID ) . '">' . __( 'Set Alternate Product Image', 'sp-theme' ) . '</a></p>' . PHP_EOL;
	}

	$output .= '<input type="hidden" id="alternate-product-image" value="' . esc_attr( $image_id ) . '" name="alternate_product_image" />' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the custom product tabs meta box
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_custom_product_tabs( $post ) {
	// enqueue jQuery tabs for this meta box
	wp_enqueue_script( 'jquery-ui-tabs' );

	// Use nonce for verification
	wp_nonce_field( '_sp_process_product_tabs', '_sp_product_tabs_nonce' );

	// get product meta
	$show_product_description_tab = get_post_meta( $post->ID, '_sp_product_description_tab', true );
	$show_additional_info_tab = get_post_meta( $post->ID, '_sp_product_additional_info_tab', true );
	$show_product_review_tab = get_post_meta( $post->ID, '_sp_product_review_tab', true );
	$tab_names = get_post_meta( $post->ID, '_sp_custom_product_tab_names', true );
	$tab_content = get_post_meta( $post->ID, '_sp_custom_product_tab_content', true );

	// set default for tabs
	if ( ! $show_product_description_tab )
		$show_product_description_tab = 'on';

	if ( ! $show_additional_info_tab )
		$show_additional_info_tab = 'on';

	if ( ! $show_product_review_tab )
		$show_product_review_tab = 'on';

	$output = '';

	$output .= '<p><label><strong>' . __( 'Product Description Tab:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="show_product_description_tab" value="on" ' . checked( $show_product_description_tab, 'on', false ) . ' /></label> <label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="show_product_description_tab" value="off" ' . checked( $show_product_description_tab, 'off', false ) . ' /></label></p>' . PHP_EOL;

	$output .= '<p><label><strong>' . __( 'Additional Info Tab:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="show_product_additional_info_tab" value="on" ' . checked( $show_additional_info_tab, 'on', false ) . ' /></label> <label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="show_product_additional_info_tab" value="off" ' . checked( $show_additional_info_tab, 'off', false ) . ' /></label></p>' . PHP_EOL;

	$output .= '<p><label><strong>' . __( 'Product Review Tab:', 'sp-theme' ) . '</strong></label></p>' . PHP_EOL;
	$output .= '<p><label>' . __( 'Show', 'sp-theme' ) . ' <input type="radio" name="show_product_review_tab" value="on" ' . checked( $show_product_review_tab, 'on', false ) . ' /></label> <label>' . __( 'Hide', 'sp-theme' ) . ' <input type="radio" name="show_product_review_tab" value="off" ' . checked( $show_product_review_tab, 'off', false ) . ' /></label></p>' . PHP_EOL;

	$output .= '<p class="howto">' . __( 'You can add additional tabs here for this particular product.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<p class="howto">' . __( 'Double click on tab title to change name.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<p class="howto">' . __( 'NOTE: After adding new tabs, please click update on the post before entering any content.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<a href="#" class="button add-tab" title="' . esc_attr__( 'Add Tab', 'sp-theme' ) . '">' . __( 'Add Tab', 'sp-theme' ) . '</a>' . PHP_EOL;

	// check if any tabs to display
	if ( isset( $tab_names ) && ! empty( $tab_names ) )
		$display_class = 'display:block;';
	else
		$display_class = '';

	$output .= '<div class="product-tab-container" style="' . esc_attr( $display_class ) . '">' . PHP_EOL;

	$output .= '<ul class="tab-list">' . PHP_EOL;

	// loop through tabs
	if ( is_array( $tab_names ) && $tab_names ) {
		$i = 1;

		foreach( $tab_names as $tab ) {
			$output .= '<li class="tab"><a href="#tabs-' . esc_attr( $i ) . '" class="tab-title">' . $tab . '</a><span class="edit-title"><input type="hidden" name="sp_product_tab_name[]" value="' . $tab . '" placeholder="' . esc_attr__( 'Enter Tab Name', 'sp-theme' ) . '" class="tab-name" /></span><a href="#" class="remove-tab" title="' . esc_attr__( 'Remove Tab', 'sp-theme' ) . '">&times;</a></li>' . PHP_EOL;

			$i++;
		}
	}

	$output .= '</ul>' . PHP_EOL;

	// loop through tab content
	if ( is_array( $tab_content ) && $tab_content ) {
		$d = 1;
		
		foreach( $tab_content as $content ) {
			$output  .= '<div id="tabs-' . esc_attr( $d ) . '" class="tab-content">' . PHP_EOL;

			$settings = array(
				'textarea_name'	=> 'sp_product_tinymce_textarea[]',
				'tinymce' 		=> true,
				'media_buttons' => true,
				'editor_class'	=> 'sp-tinymce-content'
			);

			$mce_id = 'pt_tinymce_' . strtolower( wp_generate_password( 6, false ) );

			// content
			ob_start();
			wp_editor( $content, $mce_id, $settings );
			$output .= ob_get_clean();

			$output .= '</div><!--close .tab-content-->' . PHP_EOL;

			$d++;
		}
	}

	$output .= '</div><!--close .product-tab-container-->' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the featured video box
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_featured_video( $post ) {
	wp_nonce_field( '_sp_post_featured_video', '_sp_post_featured_video_nonce' );

	// get saved settings
	$video = get_post_meta( $post->ID, '_sp_post_featured_video', true );
	$poster = get_post_meta( $post->ID, '_sp_post_featured_video_poster', true );

	$output = '';

	$output .= '<p class="howto">' . __( 'Enter the video URL.  Currently supports MP4, YouTube and Vimeo.  Please note that this setting will override the featured image.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<textarea class="widefat" rows="5" name="post_featured_video">' . $video . '</textarea>' . PHP_EOL;

	$output .= '<p class="howto">' . __( 'You can enter an optional poster image URL for your video before it plays.  This is not needed for youtube or vimeo type sites.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<input type="text" class="widefat" name="post_featured_video_poster" value="' . esc_attr( $poster ) . '" />' . PHP_EOL;

	echo $output;
}

/**
 * Function that displays the faq menu order box
 *
 * @access private
 * @since 3.0
 * @param object $post the post object
 * @return html of the settings
 */
function _sp_custom_box_faq_order( $post ) {
	wp_nonce_field( '_sp_post_faq_order', '_sp_post_faq_order_nonce' );

	// get saved settings
	$order = get_post_meta( $post->ID, '_sp_post_faq_order', true );

	$output = '';

	$output .= '<p class="howto">' . __( 'Enter a number representing the order you would like this FAQ item to appear from top to bottom.  For example enter "1" to show as the first FAQ item.', 'sp-theme' ) . '</p>' . PHP_EOL;

	$output .= '<input type="text" class="widefat" name="post_faq_order" value="' . esc_attr( $order ) . '" />' . PHP_EOL;

	echo $output;
}

add_action( 'save_post', '_sp_custom_meta_boxes_save' );

/**
 * Function that saves the custom meta box settings to the post
 *
 * @access private
 * @since 3.0
 * @param int $post_id the current post ID
 * @return boolean true
 */
function _sp_custom_meta_boxes_save( $post_id ) {
	global $wpdb;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;			
	
	// Check permissions
	if ( ! current_user_can( 'manage_options' ) )
		return;	

	/////////////////////////////////////////////////////
	// wpautop
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_meta_wpautop_nonce'] ) && check_admin_referer( '_sp_process_meta_wpautop', '_sp_meta_wpautop_nonce' ) ) {
		$wpautop = isset( $_POST['wpautop'] ) && $_POST['wpautop'] === 'on' ? true : false;

		if ( isset( $wpautop ) && $wpautop === true ) 
			update_post_meta( $post_id, '_sp_disable_wpautop', 'on' );
		elseif ( isset( $wpautop ) && $wpautop !== true )
			update_post_meta( $post_id, '_sp_disable_wpautop', 'off' );
	}

	/////////////////////////////////////////////////////
	// site layout
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_meta_site_layout_nonce'] ) && check_admin_referer( '_sp_process_meta_site_layout', '_sp_meta_site_layout_nonce' ) ) {
		/////////////////////////////////////////////////////
		// custom layout
		/////////////////////////////////////////////////////
		$custom_layout = sanitize_text_field( $_POST['custom_layout'] );

		if ( ! empty( $custom_layout ) )
			update_post_meta( $post_id, '_sp_custom_layout', $custom_layout );

		/////////////////////////////////////////////////////
		// disable sitewide widgets
		/////////////////////////////////////////////////////
		$disable_sitewide_widgets = isset( $_POST['disable_sitewide_widgets'] ) && $_POST['disable_sitewide_widgets'] === 'on' ? true : false;

		if ( isset( $disable_sitewide_widgets ) && $disable_sitewide_widgets === true )
			update_post_meta( $post_id, '_sp_custom_layout_disable_sitewide_widgets', 'on' );
		else
			update_post_meta( $post_id, '_sp_custom_layout_disable_sitewide_widgets', 'off' );
	}

	/////////////////////////////////////////////////////
	// blog post featured video
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_post_featured_video_nonce'] ) && check_admin_referer( '_sp_post_featured_video', '_sp_post_featured_video_nonce' ) ) {
		$featured_video = isset( $_POST['post_featured_video'] ) ? sanitize_text_field( $_POST['post_featured_video'] ) : '';

		// update post meta
		update_post_meta( $post_id, '_sp_post_featured_video', $featured_video );

		$featured_video_poster = isset( $_POST['post_featured_video_poster'] ) ? sanitize_text_field( $_POST['post_featured_video_poster'] ) : '';

		// update post meta
		update_post_meta( $post_id, '_sp_post_featured_video_poster', $featured_video_poster );
	}

	/////////////////////////////////////////////////////
	// excerpt truncate settings
	/////////////////////////////////////////////////////	
	if ( ! empty( $_POST['_sp_meta_excerpt_truncate_nonce'] ) && check_admin_referer( '_sp_process_meta_excerpt_truncate', '_sp_meta_excerpt_truncate_nonce' ) ) {
		/////////////////////////////////////////////////////
		// excerpt truncate
		/////////////////////////////////////////////////////		
		$excerpt_truncate = ( ( sanitize_text_field( $_POST['excerpt_truncate'] ) === 'on' ) ? true : false );

		if ( isset( $excerpt_truncate ) && $excerpt_truncate === true ) 
			update_post_meta( $post_id, '_sp_excerpt_truncate', 'on' );
		else
			update_post_meta( $post_id, '_sp_excerpt_truncate', 'off' );	

		/////////////////////////////////////////////////////
		// excerpt truncate denote
		/////////////////////////////////////////////////////
		$truncate_denote = sanitize_text_field( $_POST['truncate_denote'] );

		if ( ! empty( $truncate_denote ) ) 
			update_post_meta( $post_id, '_sp_truncate_denote', $truncate_denote );

		/////////////////////////////////////////////////////
		// excerpt truncate count
		/////////////////////////////////////////////////////
		$truncate_count = absint( $_POST['truncate_count'] );

		if ( ! empty( $truncate_count ) ) 
			update_post_meta( $post_id, '_sp_truncate_count', $truncate_count );
	}

	/////////////////////////////////////////////////////
	// seo settings
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_meta_seo_settings_nonce'] ) && check_admin_referer( '_sp_process_meta_seo_settings', '_sp_meta_seo_settings_nonce' ) ) {
		/////////////////////////////////////////////////////
		// seo description
		/////////////////////////////////////////////////////		
		$seo_description = sanitize_text_field( $_POST['seo_description'] );
		
		update_post_meta( $post_id, '_sp_page_seo_description', $seo_description );	

		/////////////////////////////////////////////////////
		// seo keywords
		/////////////////////////////////////////////////////
		$seo_keywords = stripslashes( strip_tags( $_POST['seo_keywords'] ) );

		update_post_meta( $post_id, '_sp_page_seo_keywords', $seo_keywords );

		/////////////////////////////////////////////////////
		// seo title
		/////////////////////////////////////////////////////
		$seo_title = stripslashes( strip_tags( $_POST['seo_title'] ) );

		update_post_meta( $post_id, '_sp_page_seo_title', $seo_title );

		/////////////////////////////////////////////////////
		// seo robot
		/////////////////////////////////////////////////////
		$seo_robot = stripslashes( strip_tags( $_POST['seo_robot'] ) );

		if ( isset( $seo_robot ) )
			update_post_meta( $post_id, '_sp_page_seo_robot', $seo_robot );
	}

	/////////////////////////////////////////////////////
	// advanced page options
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_meta_advanced_page_options_nonce'] ) && check_admin_referer( '_sp_process_meta_advanced_page_options', '_sp_meta_advanced_page_options_nonce' ) ) {

		/////////////////////////////////////////////////////
		// page show title
		/////////////////////////////////////////////////////
		$page_show_title = sanitize_text_field( $_POST['page_show_title'] );

		if ( ! empty( $page_show_title ) )
			update_post_meta( $post_id, '_sp_page_show_title', $page_show_title );

		/////////////////////////////////////////////////////
		// page show tagline
		/////////////////////////////////////////////////////
		$page_show_tagline = sanitize_text_field( $_POST['page_show_tagline'] );

		if ( ! empty( $page_show_tagline ) )
			update_post_meta( $post_id, '_sp_page_show_tagline', $page_show_tagline );

		/////////////////////////////////////////////////////
		// page tagline text
		/////////////////////////////////////////////////////
		$page_tagline_text = sanitize_text_field( $_POST['page_tagline_text'] );

		update_post_meta( $post_id, '_sp_page_tagline_text', $page_tagline_text );

		/////////////////////////////////////////////////////
		// page show share
		/////////////////////////////////////////////////////
		$page_show_share = sanitize_text_field( $_POST['page_show_share'] );

		if ( ! empty( $page_show_share ) )
			update_post_meta( $post_id, '_sp_page_show_share', $page_show_share );				
	}

	/////////////////////////////////////////////////////
	// slider
	/////////////////////////////////////////////////////
	if ( get_post_type() === 'sp-slider' && ! empty( $_POST['_sp_meta_slider_settings_nonce'] ) && check_admin_referer( '_sp_process_meta_slider_settings', '_sp_meta_slider_settings_nonce' ) ) {
		/////////////////////////////////////////////////////
		// slider type
		/////////////////////////////////////////////////////
		$slider_type = sanitize_text_field( $_POST['type'] );

		if ( $slider_type )
			update_post_meta( $post_id, '_sp_slider_type', $slider_type );

		/////////////////////////////////////////////////////
		// slider mode
		/////////////////////////////////////////////////////
		$slider_mode = sanitize_text_field( $_POST['mode'] );

		if ( $slider_mode )
			update_post_meta( $post_id, '_sp_slider_mode', $slider_mode );

		/////////////////////////////////////////////////////
		// slider carousel item width
		/////////////////////////////////////////////////////
		$slider_carousel_item_width = sanitize_text_field( $_POST['carousel_item_width'] );

		if ( $slider_carousel_item_width )
			update_post_meta( $post_id, '_sp_slider_carousel_item_width', $slider_carousel_item_width );

		/////////////////////////////////////////////////////
		// slider carousel item height
		/////////////////////////////////////////////////////
		$slider_carousel_item_height = sanitize_text_field( $_POST['carousel_item_height'] );

		if ( $slider_carousel_item_height )
			update_post_meta( $post_id, '_sp_slider_carousel_item_height', $slider_carousel_item_height );

		/////////////////////////////////////////////////////
		// slider show title
		/////////////////////////////////////////////////////
		$slider_show_title = sanitize_text_field( $_POST['show_title'] );

		if ( $slider_show_title )
			update_post_meta( $post_id, '_sp_slider_show_title', $slider_show_title );

		/////////////////////////////////////////////////////
		// slider title text
		/////////////////////////////////////////////////////
		$slider_title_text = sanitize_text_field( $_POST['title_text'] );

		update_post_meta( $post_id, '_sp_slider_title_text', $slider_title_text );

		/////////////////////////////////////////////////////
		// slider title font variant
		/////////////////////////////////////////////////////
		$slider_title_font_variant = sanitize_text_field( $_POST['title_font_variant'] );

		if ( $slider_title_font_variant )
			update_post_meta( $post_id, '_sp_slider_title_font_variant', $slider_title_font_variant );

		/////////////////////////////////////////////////////
		// slider title font subset
		/////////////////////////////////////////////////////
		if ( ! empty( $_POST['title_font_subset'] ) && is_array( $_POST['title_font_subset'] ) && isset( $_POST['title_font_subset'] ) ) {
			$slider_title_font_subset = $_POST['title_font_subset'];

			$slider_title_font_subset = array_map( 'sanitize_text_field', $slider_title_font_subset );

			update_post_meta( $post_id, '_sp_slider_title_font_subset', $slider_title_font_subset );			
		} else {
			update_post_meta( $post_id, '_sp_slider_title_font_subset', '' );
		}

		/////////////////////////////////////////////////////
		// slider title font
		/////////////////////////////////////////////////////
		$slider_title_font = isset( $_POST['title_font'] ) ? sanitize_text_field( $_POST['title_font'] ) : false;

		if ( $slider_title_font ) {
			update_post_meta( $post_id, '_sp_slider_title_font', $slider_title_font );	

			if ( ! isset( $slider_title_font_subset ) )
				$slider_title_font_subset = array();

			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel h2.slider-title', 'font' => $slider_title_font, 'variant' => $slider_title_font_variant, 'subset' => $slider_title_font_subset ) );		
		}
		
		/////////////////////////////////////////////////////
		// slider title color
		/////////////////////////////////////////////////////
		$slider_title_color = sanitize_text_field( $_POST['title_color'] );

		update_post_meta( $post_id, '_sp_slider_title_color', $slider_title_color );

		/////////////////////////////////////////////////////
		// slider title size
		/////////////////////////////////////////////////////
		$slider_title_size = str_replace( 'px', '', sanitize_text_field( $_POST['title_size'] ) );

		if ( $slider_title_size )
			update_post_meta( $post_id, '_sp_slider_title_size', $slider_title_size );

		/////////////////////////////////////////////////////
		// slider background color
		/////////////////////////////////////////////////////
		$slider_bg_color = sanitize_text_field( $_POST['slider_bg_color'] );

		update_post_meta( $post_id, '_sp_slider_bg_color', $slider_bg_color );

		/////////////////////////////////////////////////////
		// slider show text overlay
		/////////////////////////////////////////////////////
		$slider_show_text_overlay = sanitize_text_field( $_POST['show_text_overlay'] );

		if ( $slider_show_text_overlay )
			update_post_meta( $post_id, '_sp_slider_show_text_overlay', $slider_show_text_overlay );

		/////////////////////////////////////////////////////
		// slider overlay position
		/////////////////////////////////////////////////////
		$slider_overlay_position = sanitize_text_field( $_POST['overlay_position'] );

		if ( $slider_overlay_position )
			update_post_meta( $post_id, '_sp_slider_overlay_position', $slider_overlay_position );

		/////////////////////////////////////////////////////
		// slider overlay color
		/////////////////////////////////////////////////////
		$slider_overlay_color = sanitize_text_field( $_POST['overlay_color'] );

		update_post_meta( $post_id, '_sp_slider_overlay_color', $slider_overlay_color );

		/////////////////////////////////////////////////////
		// slider overlay opacity
		/////////////////////////////////////////////////////
		$slider_overlay_opacity = sanitize_text_field( $_POST['overlay_opacity'] );

		if ( $slider_overlay_opacity )
			update_post_meta( $post_id, '_sp_slider_overlay_opacity', $slider_overlay_opacity );

		/////////////////////////////////////////////////////
		// slider easing
		/////////////////////////////////////////////////////
		$slider_easing = sanitize_text_field( $_POST['easing'] );

		if ( $slider_easing )
			update_post_meta( $post_id, '_sp_slider_easing', $slider_easing );

		/////////////////////////////////////////////////////
		// slider randomize
		/////////////////////////////////////////////////////
		$slider_randomize = sanitize_text_field( $_POST['randomize'] );

		if ( $slider_randomize )
			update_post_meta( $post_id, '_sp_slider_randomize', $slider_randomize );

		/////////////////////////////////////////////////////
		// slider autoscroll
		/////////////////////////////////////////////////////
		$slider_autoscroll = sanitize_text_field( $_POST['autoscroll'] );

		if ( $slider_autoscroll )
			update_post_meta( $post_id, '_sp_slider_autoscroll', $slider_autoscroll );	

		/////////////////////////////////////////////////////
		// slider interval
		/////////////////////////////////////////////////////		
		$slider_interval = sanitize_text_field( $_POST['interval'] );

		if ( $slider_interval )
			update_post_meta( $post_id, '_sp_slider_interval', $slider_interval );										

		/////////////////////////////////////////////////////
		// slider circular
		/////////////////////////////////////////////////////
		$slider_circular = sanitize_text_field( $_POST['circular'] );

		if ( $slider_circular )
			update_post_meta( $post_id, '_sp_slider_circular', $slider_circular );				

		/////////////////////////////////////////////////////
		// slider nav
		/////////////////////////////////////////////////////
		$slider_nav = sanitize_text_field( $_POST['nav'] );

		if ( $slider_nav )
			update_post_meta( $post_id, '_sp_slider_nav', $slider_nav );		

		/////////////////////////////////////////////////////
		// slider dot nav
		/////////////////////////////////////////////////////
		$slider_dot_nav = sanitize_text_field( $_POST['dot_nav'] );

		if ( $slider_dot_nav )
			update_post_meta( $post_id, '_sp_slider_dot_nav', $slider_dot_nav );

		/////////////////////////////////////////////////////
		// slider pause on hover
		/////////////////////////////////////////////////////
		$slider_pause_on_hover = sanitize_text_field( $_POST['pause_on_hover'] );

		if ( $slider_pause_on_hover )
			update_post_meta( $post_id, '_sp_slider_pause_on_hover', $slider_pause_on_hover );	

		/////////////////////////////////////////////////////
		// slider items per click
		/////////////////////////////////////////////////////		
		$slider_items_per_click = sanitize_text_field( $_POST['items_per_click'] );

		if ( $slider_items_per_click )
			update_post_meta( $post_id, '_sp_slider_items_per_click', $slider_items_per_click );				

		/////////////////////////////////////////////////////
		// slider transition speed
		/////////////////////////////////////////////////////
		$slider_transition_speed = sanitize_text_field( $_POST['transition_speed'] );

		update_post_meta( $post_id, '_sp_slider_transition_speed', $slider_transition_speed );		

		/////////////////////////////////////////////////////
		// slider reverse direction
		/////////////////////////////////////////////////////
		$slider_reverse_direction = sanitize_text_field( $_POST['reverse_direction'] );

		if ( $slider_reverse_direction )
			update_post_meta( $post_id, '_sp_slider_reverse_direction', $slider_reverse_direction );	

		/////////////////////////////////////////////////////
		// slider touch swipe
		/////////////////////////////////////////////////////		
		$slider_touch_swipe = sanitize_text_field( $_POST['touch_swipe'] );

		if ( $slider_touch_swipe )
			update_post_meta( $post_id, '_sp_slider_touch_swipe', $slider_touch_swipe );	

		/////////////////////////////////////////////////////
		// slider items to show
		/////////////////////////////////////////////////////		
		$slider_items_to_show = sanitize_text_field( $_POST['items_to_show'] );

		if ( $slider_items_to_show )
			update_post_meta( $post_id, '_sp_slider_items_to_show', $slider_items_to_show );	

		/////////////////////////////////////////////////////
		// slider slogan title font variant
		/////////////////////////////////////////////////////
		$slider_slogan_title_font_variant = sanitize_text_field( $_POST['slogan_title_font_variant'] );

		if ( $slider_slogan_title_font_variant )
			update_post_meta( $post_id, '_sp_slider_slide_slogan_title_font_variant', $slider_slogan_title_font_variant );

		/////////////////////////////////////////////////////
		// slider slogan title font subset
		/////////////////////////////////////////////////////
		if ( ! empty( $_POST['slogan_title_font_subset'] ) && is_array( $_POST['slogan_title_font_subset'] ) && isset( $_POST['slogan_title_font_subset'] ) ) {
			$slider_slogan_title_font_subset = $_POST['slogan_title_font_subset'];

			$slider_slogan_title_font_subset = array_map( 'sanitize_text_field', $slider_slogan_title_font_subset );

			update_post_meta( $post_id, '_sp_slider_slide_slogan_title_font_subset', $slider_slogan_title_font_subset );			
		} else {
			update_post_meta( $post_id, '_sp_slider_slide_slogan_title_font_subset', '' );
		}

		/////////////////////////////////////////////////////
		// slider slogan title font
		/////////////////////////////////////////////////////
		$slider_slogan_title_font = isset( $_POST['slogan_title_font'] ) ? sanitize_text_field( $_POST['slogan_title_font'] ) : false;

		if ( $slider_slogan_title_font ) {
			update_post_meta( $post_id, '_sp_slider_slide_slogan_title_font', $slider_slogan_title_font );	

			if ( ! isset( $slider_slogan_title_font_subset ) )
				$slider_slogan_title_font_subset = array();

			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel h3.slogan-title', 'font' => $slider_slogan_title_font, 'variant' => $slider_slogan_title_font_variant, 'subset' => $slider_slogan_title_font_subset ) );		
		}

		/////////////////////////////////////////////////////
		// slider content font variant
		/////////////////////////////////////////////////////
		$slider_content_font_variant = sanitize_text_field( $_POST['content_font_variant'] );

		if ( $slider_content_font_variant )
			update_post_meta( $post_id, '_sp_slider_slide_content_font_variant', $slider_content_font_variant );

		/////////////////////////////////////////////////////
		// slider slogan title font subset
		/////////////////////////////////////////////////////
		if ( ! empty( $_POST['content_font_subset'] ) && is_array( $_POST['content_font_subset'] ) && isset( $_POST['content_font_subset'] ) ) {
			$slider_content_font_subset = $_POST['content_font_subset'];

			$slider_content_font_subset = array_map( 'sanitize_text_field', $slider_content_font_subset );

			update_post_meta( $post_id, '_sp_slider_slide_content_font_subset', $slider_content_font_subset );			
		} else {
			update_post_meta( $post_id, '_sp_slider_slide_content_font_subset', '' );
		}

		/////////////////////////////////////////////////////
		// slider slogan title font
		/////////////////////////////////////////////////////
		$slider_content_font = isset( $_POST['content_font'] ) ? sanitize_text_field( $_POST['content_font'] ) : false;

		if ( $slider_content_font ) {
			update_post_meta( $post_id, '_sp_slider_slide_content_font', $slider_content_font );

			if ( ! isset( $slider_content_font_subset ) )
				$slider_content_font_subset = array();

			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel .textblock p', 'font' => $slider_content_font, 'variant' => $slider_content_font_variant, 'subset' => $slider_content_font_subset ) );		
		}

		/////////////////////////////////////////////////////
		// slider link title font variant
		/////////////////////////////////////////////////////
		$slider_link_title_font_variant = sanitize_text_field( $_POST['link_title_font_variant'] );

		if ( $slider_link_title_font_variant )
			update_post_meta( $post_id, '_sp_slider_slide_link_title_font_variant', $slider_link_title_font_variant );

		/////////////////////////////////////////////////////
		// slider slogan title font subset
		/////////////////////////////////////////////////////
		if ( ! empty( $_POST['link_title_font_subset'] ) && is_array( $_POST['link_title_font_subset'] ) && isset( $_POST['link_title_font_subset'] ) ) {
			$slider_link_title_font_subset = $_POST['link_title_font_subset'];

			$slider_link_title_font_subset = array_map( 'sanitize_text_field', $slider_link_title_font_subset );

			update_post_meta( $post_id, '_sp_slider_slide_link_title_font_subset', $slider_link_title_font_subset );			
		} else {
			update_post_meta( $post_id, '_sp_slider_slide_link_title_font_subset', '' );
		}

		/////////////////////////////////////////////////////
		// slider slogan title font
		/////////////////////////////////////////////////////
		$slider_link_title_font = isset( $_POST['link_title_font'] ) ? sanitize_text_field( $_POST['link_title_font'] ) : false;

		if ( $slider_link_title_font ) {
			update_post_meta( $post_id, '_sp_slider_slide_link_title_font', $slider_link_title_font );

			if ( ! isset( $slider_link_title_font_subset ) )
				$slider_link_title_font_subset = array();
			
			// save custom fonts into theme data
			sp_save_custom_font_data( array( 'selector' => '.sc-carousel .slide a.link-out', 'font' => $slider_link_title_font, 'variant' => $slider_link_title_font_variant, 'subset' => $slider_link_title_font_subset ) );		
		}													
	}

	/////////////////////////////////////////////////////
	// portfolio
	/////////////////////////////////////////////////////
	if ( get_post_type() === 'sp-portfolio' ) {
		/////////////////////////////////////////////////////
		// portfolio sort position
		/////////////////////////////////////////////////////
		if ( ! empty( $_POST['_sp_meta_portfolio_sort_position_nonce'] ) && check_admin_referer( '_sp_process_meta_portfolio_sort_position', '_sp_meta_portfolio_sort_position_nonce' ) ) {
			$sort = sanitize_text_field( $_POST['portfolio_sort_position'] );

			if ( isset( $sort ) ) 
				update_post_meta( $post_id, '_sp_portfolio_sort_position', $sort );
		}
	}

	/////////////////////////////////////////////////////
	// testimonials
	/////////////////////////////////////////////////////
	if ( get_post_type() === 'sp-testimonial' && ! empty( $_POST['_sp_meta_testimonial_settings_nonce'] ) && check_admin_referer( '_sp_process_meta_testimonial_settings', '_sp_meta_testimonial_settings_nonce' ) ) {
		/////////////////////////////////////////////////////
		// testimonial name
		/////////////////////////////////////////////////////
		$testimonial_name = stripslashes( strip_tags( $_POST['testimonial_name'] ) );

		if ( $testimonial_name )
			update_post_meta( $post_id, '_sp_testimonial_submitter_name', $testimonial_name );

		/////////////////////////////////////////////////////
		// testimonial email
		/////////////////////////////////////////////////////
		$testimonial_email = stripslashes( strip_tags( $_POST['testimonial_email'] ) );

		if ( $testimonial_email )
			update_post_meta( $post_id, '_sp_testimonial_submitter_email', $testimonial_email );
	}

	/////////////////////////////////////////////////////
	// contact form settings
	/////////////////////////////////////////////////////
	if ( get_post_type( $post_id ) === 'sp-contact-form' && ! empty( $_POST['_sp_meta_contact_form_settings_nonce'] ) && check_admin_referer( '_sp_process_meta_contact_form_settings', '_sp_meta_contact_form_settings_nonce' ) ) {

		/////////////////////////////////////////////////////
		// contact form email to
		/////////////////////////////////////////////////////
		$email_to = sanitize_text_field( $_POST['contact_form_email_to'] );

		update_post_meta( $post_id, '_sp_contact_form_email_to', $email_to );

		/////////////////////////////////////////////////////
		// contact form email subject
		/////////////////////////////////////////////////////
		$email_subject = sanitize_text_field( $_POST['contact_form_email_subject'] );

		update_post_meta( $post_id, '_sp_contact_form_email_subject', $email_subject );	

		/////////////////////////////////////////////////////
		// contact form redirect
		/////////////////////////////////////////////////////
		$redirect = sanitize_text_field( $_POST['contact_form_redirect'] );

		if ( isset( $redirect ) ) 
			update_post_meta( $post_id, '_sp_contact_form_redirect', $redirect );	

		/////////////////////////////////////////////////////
		// contact form redirect url
		/////////////////////////////////////////////////////
		$redirect_url = sanitize_text_field( $_POST['contact_form_redirect_url'] );

		update_post_meta( $post_id, '_sp_contact_form_redirect_url', $redirect_url );	

		/////////////////////////////////////////////////////
		// contact form show reset
		/////////////////////////////////////////////////////
		$show_reset = sanitize_text_field( $_POST['contact_form_show_reset'] );

		if ( isset( $show_reset ) ) 
			update_post_meta( $post_id, '_sp_contact_form_show_reset', $show_reset );
	}

	/////////////////////////////////////////////////////
	// contact form messages
	/////////////////////////////////////////////////////
	if ( get_post_type( $post_id ) === 'sp-contact-form' && ! empty( $_POST['_sp_meta_contact_form_messages_nonce'] ) && check_admin_referer( '_sp_process_meta_contact_form_messages', '_sp_meta_contact_form_messages_nonce' ) ) {

		/////////////////////////////////////////////////////
		// contact form email header text
		/////////////////////////////////////////////////////
		$header_text = sanitize_text_field( $_POST['contact_form_header_text'] );

		update_post_meta( $post_id, '_sp_contact_form_header_text', $header_text );

		/////////////////////////////////////////////////////
		// contact form submit button text
		/////////////////////////////////////////////////////
		$submit_button_text = sanitize_text_field( $_POST['contact_form_submit_button_text'] );

		update_post_meta( $post_id, '_sp_contact_form_submit_button_text', $submit_button_text );	

		/////////////////////////////////////////////////////
		// contact form reset button text
		/////////////////////////////////////////////////////
		$reset_button_text = sanitize_text_field( $_POST['contact_form_reset_button_text'] );

		update_post_meta( $post_id, '_sp_contact_form_reset_button_text', $reset_button_text );		

		/////////////////////////////////////////////////////
		// contact form success message
		/////////////////////////////////////////////////////
		$success_message = sanitize_text_field( $_POST['contact_form_success_message'] );

		update_post_meta( $post_id, '_sp_contact_form_success_message', $success_message );		

		/////////////////////////////////////////////////////
		// contact form failure message
		/////////////////////////////////////////////////////
		$failure_message = sanitize_text_field( $_POST['contact_form_failure_message'] );

		update_post_meta( $post_id, '_sp_contact_form_failure_message', $failure_message );	

		/////////////////////////////////////////////////////
		// contact form required field text
		/////////////////////////////////////////////////////
		$required_field_text = sanitize_text_field( $_POST['contact_form_required_field_text'] );

		update_post_meta( $post_id, '_sp_contact_form_required_field_text', $required_field_text );		

		/////////////////////////////////////////////////////
		// contact form email template
		/////////////////////////////////////////////////////
		$email_template = wp_kses_data( strip_tags( $_POST['contact_form_email_template'] ) );

		update_post_meta( $post_id, '_sp_contact_form_email_template', $email_template );	
	}

	/////////////////////////////////////////////////////
	// contact form content
	/////////////////////////////////////////////////////
	if ( get_post_type( $post_id ) === 'sp-contact-form' && ! empty( $_POST['_sp_meta_contact_form_content_nonce'] ) && check_admin_referer( '_sp_process_meta_contact_form_content', '_sp_meta_contact_form_content_nonce' ) ) {
		/////////////////////////////////////////////////////
		// contact form field type
		/////////////////////////////////////////////////////
		$field_type = $_POST['field_type'];	
		
		array_walk_recursive( $field_type, 'sp_clean_multi_array' );
		
		if ( is_array( $field_type ) && isset( $field_type ) ) {
			$rebuild_arr = array();

			$i = 1;
			foreach( $field_type as $type ) {
				$rebuild_arr['field_' . $i] = $type;
				$i++;	
			}	

			update_post_meta( $post_id, '_sp_contact_form_field_type', $rebuild_arr );
		}

		/////////////////////////////////////////////////////
		// contact form field options
		/////////////////////////////////////////////////////		
		$field_options = isset( $_POST['field_options'] ) ? $_POST['field_options'] : '';	

		if ( is_array( $field_options ) && isset( $field_options ) ) {
			array_walk_recursive( $field_options, 'sp_clean_multi_array' );

			// prepare the field options
			$merged = array();
			
			// todo: this is messy...gotta be a better way -- can't think right now!
			if ( is_array( $field_options ) ) {
				foreach ( $field_options as $a ) {
					if ( is_array( $a ) ) {
						foreach ( $a as $k => $v ) {
							if ( is_array( $v ) ) {
								foreach ( $v as $v2 ) {
									$merged[$k][] = $v2;
								}
							}
						}
					}
				}
			}
			$field_options = $merged;			
			update_post_meta( $post_id, '_sp_contact_form_field_options', $field_options );
		}

		/////////////////////////////////////////////////////
		// contact form field label
		/////////////////////////////////////////////////////
		$field_label = $_POST['field_label'];	
		
		array_walk_recursive( $field_label, 'sp_clean_multi_array' );

		if ( is_array( $field_label ) && isset( $field_label ) ) {
			$rebuild_arr = array();

			$i = 1;
			foreach( $field_label as $label ) {
				$rebuild_arr['field_' . $i] = $label;
				$i++;
			}

			update_post_meta( $post_id, '_sp_contact_form_field_label', $rebuild_arr );
		}

		/////////////////////////////////////////////////////
		// contact form required field
		/////////////////////////////////////////////////////
		$required_field = $_POST['required_field'];	

		array_walk_recursive( $required_field, 'sp_clean_multi_array' );

		if ( is_array( $required_field ) && isset( $required_field ) ) {
			$rebuild_arr = array();

			$i = 1;
			foreach( $required_field as $required ) {
				$rebuild_arr['field_' . $i] = $required;
				$i++;
			}

			update_post_meta( $post_id, '_sp_contact_form_required_field', $rebuild_arr );
		}

		/////////////////////////////////////////////////////
		// contact form unique tag name
		/////////////////////////////////////////////////////
		$unique_tag_name = $_POST['unique_tag_name'];	

		array_walk_recursive( $unique_tag_name, 'sp_clean_multi_array' );

		if ( is_array( $unique_tag_name ) && isset( $unique_tag_name ) ) {
			$rebuild_arr = array();

			$i = 1;
			foreach( $unique_tag_name as $tag_name ) {
				$rebuild_arr['field_' . $i] = $tag_name;
				$i++;
			}

			update_post_meta( $post_id, '_sp_contact_form_unique_tag_name', $rebuild_arr );
		}
	} // contact-form

	/////////////////////////////////////////////////////
	// page builder
	/////////////////////////////////////////////////////
	if ( isset( $_POST['page_builder_form'] ) && $_POST['page_builder_form'] === 'saving' ) {

		$pb_status = sanitize_text_field( $_POST['pb_status'] );
		update_post_meta( $post_id, '_sp_page_builder_status', $pb_status );

		//$pb_cache = sanitize_text_field( $_POST['pb_cache'] );
		//update_post_meta( $post_id, '_sp_page_builder_cache', $pb_cache );

		$pb_outer_container_style = sanitize_text_field( $_POST['pb_outer_container_style'] );
		update_post_meta( $post_id, '_sp_page_builder_outer_container_style', $pb_outer_container_style );

		$pb_modules = $_POST['pb'];

		if ( isset( $pb_modules ) ) {
			// clean the input
			array_walk_recursive( $pb_modules, 'sp_clean_multi_array' );
			update_post_meta( $post_id, '_sp_page_builder_modules', base64_encode( maybe_serialize( $pb_modules ) ) );
		} else {
			update_post_meta( $post_id, '_sp_page_builder_modules', '' );
		}

	} // page builder

	/////////////////////////////////////////////////////
	// page editor type
	/////////////////////////////////////////////////////
	if ( isset( $_POST['sp_editor_type'] ) )
		update_post_meta( $post_id, '_sp_page_editor_type', sanitize_text_field( $_POST['sp_editor_type'] ) );

	/////////////////////////////////////////////////////
	// products
	/////////////////////////////////////////////////////
	if ( get_post_type( $post_id ) === 'product' ) {
		global $wpdb;

		// alternate images
		$alternate_product_image = isset( $_POST['alternate_product_image'] ) ? $_POST['alternate_product_image'] : '';

		// before update get the image id first
		$alternate_product_image_id = get_post_meta( $post_id, '_sp_alternate_product_image_id', true );

		// update post meta
		update_post_meta( $post_id, '_sp_alternate_product_image_id', absint( $alternate_product_image ) );

		// remove attachment post parent
		if ( ( ! isset( $alternate_product_image ) || empty( $alternate_product_image ) ) && isset( $alternate_product_image_id ) )
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET `post_parent` = %d WHERE `ID` = %d", 0, absint( $alternate_product_image_id ) ) );

		$hover_status = isset( $_POST['alternate_image_hover_status'] ) ? $_POST['alternate_image_hover_status'] : '';

		update_post_meta( $post_id, '_sp_alternate_product_image_on_hover_status', $hover_status );

		// custom product tabs
		if ( ! empty( $_POST['_sp_product_tabs_nonce'] ) && check_admin_referer( '_sp_process_product_tabs', '_sp_product_tabs_nonce' ) ) {
			if ( isset( $_POST['sp_product_tab_name'] ) ) {
				$tab_names = $_POST['sp_product_tab_name'];

				// sanitize
				array_walk_recursive( $tab_names, 'sp_clean_multi_array' );
			} else {
				$tab_names = '';
			}

			if ( isset( $_POST['sp_product_tinymce_textarea'] ) ) {
				$tab_content = $_POST['sp_product_tinymce_textarea'];

				// sanitize
				array_walk_recursive( $tab_content, 'sp_clean_textarea_multi_array' );
			} else {
				$tab_content = '';
			}

			// update product meta
			update_post_meta( $post_id, '_sp_custom_product_tab_names', $tab_names );
			update_post_meta( $post_id, '_sp_custom_product_tab_content', $tab_content );
		}

		$show_product_description_tab = isset( $_POST['show_product_description_tab'] ) ? sanitize_text_field( $_POST['show_product_description_tab'] ) : '';
		$show_product_additional_info_tab = isset( $_POST['show_product_additional_info_tab'] ) ? sanitize_text_field( $_POST['show_product_additional_info_tab'] ) : '';
		$show_product_review_tab = isset( $_POST['show_product_review_tab'] ) ? sanitize_text_field( $_POST['show_product_review_tab'] ) : '';

		update_post_meta( $post_id, '_sp_product_description_tab', $show_product_description_tab );
		update_post_meta( $post_id, '_sp_product_additional_info_tab', $show_product_additional_info_tab );
		update_post_meta( $post_id, '_sp_product_review_tab', $show_product_review_tab );

		/////////////////////////////////////////////////////
		// page show wishlist
		/////////////////////////////////////////////////////
		$page_show_wishlist = isset( $_POST['page_show_wishlist'] ) ? sanitize_text_field( $_POST['page_show_wishlist'] ) : null;

		if ( ! empty( $page_show_wishlist ) )
			update_post_meta( $post_id, '_sp_page_show_wishlist', $page_show_wishlist );

		/////////////////////////////////////////////////////
		// page show compare
		/////////////////////////////////////////////////////
		$page_show_compare = isset( $_POST['page_show_compare'] ) ? sanitize_text_field( $_POST['page_show_compare'] ) : null;

		if ( ! empty( $page_show_compare ) )
			update_post_meta( $post_id, '_sp_page_show_compare', $page_show_compare );			
	} // products

	/////////////////////////////////////////////////////
	// faq sort order
	/////////////////////////////////////////////////////
	if ( ! empty( $_POST['_sp_post_faq_order_nonce'] ) && check_admin_referer( '_sp_post_faq_order', '_sp_post_faq_order_nonce' ) ) {
		$order = isset( $_POST['post_faq_order'] ) && ! empty( $_POST['post_faq_order'] ) ? sanitize_text_field( $_POST['post_faq_order'] ) : '0';

		// update post meta
		update_post_meta( $post_id, '_sp_post_faq_order', $order );
	}

	return true;
}