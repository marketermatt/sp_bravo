<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * Carousel slider display functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * function to get the slider's settings
 *
 * @access public
 * @since 3.0
 * @param int $post_id the post id to get the meta from
 * @return array $settings
 */
function sp_get_slider_settings( $post_id ) {
	// bail if no id is passed
	if ( ! isset( $post_id ) )
		return;

	$settings = array(
		'type' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_type', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_type', 'std' ),
			'label'			=> __( 'Slider Type', 'sp-theme' ),
			'desc'			=> __( 'Select the slider type you want between a full carousel of slides or a single slide.  Different options will appear for each type.', 'sp-theme' ),
			'field_type'	=> 'select',
			'attr'			=> array( 'single', 'carousel' )
		),

		'mode' => array(
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_mode', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_mode', 'std' ),
			'label'			=> __( 'Slider Mode', 'sp-theme' ),
			'desc'			=> __( 'Select the slider mode you want your slider to display.  Horizontal will show your slides going left to right, vertical will show your slides going up and down and finally fade will fade your slides in and out.  Please note that if you are using fade, it is advisable to use images that are all the same size width and height or you may get unexpected results.', 'sp-theme' ),
			'field_type'	=> 'select',
			'attr'			=> array( 'horizontal', 'vertical', 'fade' ),
			'context'		=> 'single'
		),

		'carousel_item_width' => array(
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_carousel_item_width', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_carousel_item_width', 'std' ),
			'label'			=> __( 'Slider Carousel Item Width', 'sp-theme' ),
			'desc'			=> __( 'Set the width in pixels for your slide item.  Please omit the PX after the number.  This must be set.', 'sp-theme' ),
			'field_type'	=> 'text',
			'context'		=> 'carousel'
		),

		'carousel_item_height' => array(
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_carousel_item_height', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_carousel_item_height', 'std' ),
			'label'			=> __( 'Slider Carousel Item Height', 'sp-theme' ),
			'desc'			=> __( 'Set the height in pixels for your slide item.  Please omit the PX after the number.  This must be set.', 'sp-theme' ),
			'field_type'	=> 'text',
			'context'		=> 'carousel'
		),

		'slider_bg_color' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_bg_color', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_bg_color', 'std' ),
			'label'			=> __( 'Slider Background Color', 'sp-theme' ),
			'desc'			=> __( 'Select the color you want for your background.  This will only show through if your images are not big enough to fill the space.', 'sp-theme' ),
			'field_type'	=> 'colorpicker',
			'attr'			=> array( 'single', 'carousel' )
		),

		'show_title' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_show_title', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_show_title', 'std' ),
			'label'			=> __( 'Show Section Title', 'sp-theme' ),
			'desc'			=> __( 'Turn this on to show a title to be displayed above the slider.  You can enter the custom title below.', 'sp-theme' ),
			'field_type'	=> 'radio'
		),

		'title_text' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_title_text', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_title_text', 'std' ),
			'label'			=> __( 'Section Title', 'sp-theme' ),
			'desc'			=> __( 'Enter the title you want to display above the slider.', 'sp-theme' ),
			'field_type'	=> 'text'
		),

		'title_font' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_title_font', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_title_font', 'std' ),
			'label'			=> __( 'Section Title Font', 'sp-theme' ),
			'desc'			=> __( 'Select the font you want to use for your title.', 'sp-theme' ),
			'field_type'	=> 'font'
		),

		'title_font_variant' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_title_font_variant', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_title_font_variant', 'std' ),
			'label'			=> __( 'Section Title Font Variant', 'sp-theme' ),
			'desc'			=> __( 'Select the font variant you want to use for your title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-variant'
		),

		'title_font_subset' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_title_font_subset', true ),
			'std'			=> sp_get_theme_init_setting( 'slider_title_font_subset', 'std' ),
			'label'			=> __( 'Section Title Font Subset', 'sp-theme' ),
			'desc'			=> __( 'Select the font subset you want to use for your title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-subsets'
		),

		'title_color' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_title_color', true ),
			'std'           => sp_get_theme_init_setting( 'slider_title_color', 'std' ),
			'label'         => __( 'Section Title Color', 'sp-theme' ),
			'desc'          => __( 'Select the color you want for your title.', 'sp-theme' ),
			'field_type'    => 'colorpicker'
		),

		'title_size' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_title_size', true ),
			'std'           => sp_get_theme_init_setting( 'slider_title_size', 'std' ),
			'label'         => __( 'Section Title Size', 'sp-theme' ),
			'desc'          => __( 'Enter the font size you want for your title in pixels.  i.e. 20 for 20 pixels.  You do not need to include the PX.', 'sp-theme' ),
			'field_type'    => 'text-size'
		),

		'show_text_overlay' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_show_text_overlay', true ),
			'std'           => sp_get_theme_init_setting( 'slider_show_text_overlay', 'std' ),
			'label'         => __( 'Show Text Overlay', 'sp-theme' ),
			'desc'          => __( 'Turn this on to show a text overlay on top of the slide for better text readability.', 'sp-theme' ),
			'field_type'    => 'radio',
			'context'       => 'single'
		),

		'overlay_position' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_overlay_position', true ),
			'std'           => sp_get_theme_init_setting( 'slider_overlay_position', 'std' ),
			'label'         => __( 'Overlay Position', 'sp-theme' ),
			'desc'          => __( 'Select the position of the overlay you want to show on top of the slide.', 'sp-theme' ),
			'field_type'    => 'select',
			'attr'          => array( 'top', 'bottom', 'left', 'right', 'left-offset', 'right-offset' ),
			'context'       => 'single'
		),

		'overlay_color' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_overlay_color', true ),
			'std'           => sp_get_theme_init_setting( 'slider_overlay_color', 'std' ),
			'label'         => __( 'Overlay Color', 'sp-theme' ),
			'desc'          => __( 'Select the overlay color you would like to use.', 'sp-theme' ),
			'field_type'    => 'colorpicker',
			'context'       => 'single'
		),		

		'overlay_opacity' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_overlay_opacity', true ),
			'std'           => sp_get_theme_init_setting( 'slider_overlay_opacity', 'std' ),
			'label'         => __( 'Overlay Opacity', 'sp-theme' ),
			'desc'          => __( 'Enter the amount in percentage of how opaque you want your overlay to be. i.e 50 would give a 50% transparency to the overlay.', 'sp-theme' ),
			'field_type'    => 'select',
			'attr'			=> array( '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
			'context'       => 'single'
		),

		'easing' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_easing', true ),
			'std'           => sp_get_theme_init_setting( 'slider_easing', 'std' ),
			'label'         => __( 'Easing Effect', 'sp-theme' ),
			'desc'          => __( 'Select the easing effect you want for the slide transitions.', 'sp-theme' ),
			'field_type'    => 'select',
			'attr'          => sp_get_easing()
		),

		'randomize' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_randomize', true ),
			'std'           => sp_get_theme_init_setting( 'slider_randomize', 'std' ),
			'label'         => __( 'Randomize Starting Slide', 'sp-theme' ),
			'desc'          => __( 'Turn this on to enable the first slide to be random instead of always starting with the same slide.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'autoscroll' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_autoscroll', true ),
			'std'           => sp_get_theme_init_setting( 'slider_autoscroll', 'std' ),
			'label'         => __( 'Auto Scroll', 'sp-theme' ),
			'desc'          => __( 'Turn this on to enable auto scrolling of your slides.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'interval' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_interval', true ),
			'std'           => sp_get_theme_init_setting( 'slider_interval', 'std' ),
			'label'         => __( 'Slide Interval', 'sp-theme' ),
			'desc'          => __( 'Select the interval you want in seconds, for each slide to change.', 'sp-theme' ),
			'field_type'    => 'select',
			'attr'          => array( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20' )
		),

		'circular' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_circular', true ),
			'std'           => sp_get_theme_init_setting( 'slider_circular', 'std' ),
			'label'         => __( 'Enable Circular', 'sp-theme' ),
			'desc'          => __( 'Turn this on to enable the slides to go around in circles after it has reach the last slide and repeat.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'nav' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_nav', true ),
			'std'           => sp_get_theme_init_setting( 'slider_nav', 'std' ),
			'label'         => __( 'Enable Navigation', 'sp-theme' ),
			'desc'          => __( 'Turn this on to show slider navigation.  i.e. left and right arrows or dot navigation', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'dot_nav' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_dot_nav', true ),
			'std'           => sp_get_theme_init_setting( 'slider_dot_nav', 'std' ),
			'label'         => __( 'Enable Dot Navigation', 'sp-theme' ),
			'desc'          => __( 'Turn this on to show dots that can be clicked to change slides.', 'sp-theme' ),
			'field_type'    => 'radio',
			'context'       => 'single'
		),

		'pause_on_hover' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_pause_on_hover', true ),
			'std'           => sp_get_theme_init_setting( 'slider_pause_on_hover', 'std' ),
			'label'         => __( 'Enable Pause on Hover', 'sp-theme' ),
			'desc'          => __( 'Turn this on to enable the slider to pause when mouse is hovered on top.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'items_per_click' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_items_per_click', true ),
			'std'           => sp_get_theme_init_setting( 'slider_items_per_click', 'std' ),
			'label'         => __( 'Scroll Items Per Click', 'sp-theme' ),
			'desc'          => __( 'Enter how many items you want the slider to scroll by when the next or previous button is clicked.  In addition, if you select the slider to be of type "single", then only one slide will be advanced per click.', 'sp-theme' ),
			'field_type'    => 'text',
			'context'       => 'carousel'
		),

		'transition_speed' => array(
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_transition_speed', true ),
			'std'           => sp_get_theme_init_setting( 'slider_transition_speed', 'std' ),
			'label'         => __( 'Slide Transition Speed', 'sp-theme' ),
			'desc'          => __( 'Enter the speed you want for each slide transition animation in miliseconds. i.e. If you entered 500, the slide animation will take 500 miliseconds to complete.', 'sp-theme' ),
			'field_type'    => 'text'
		),

		'reverse_direction' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_reverse_direction', true ),
			'std'           => sp_get_theme_init_setting( 'slider_reverse_direction', 'std' ),
			'label'         => __( 'Reverse Slider Direction', 'sp-theme' ),
			'desc'          => __( 'Turn this on to reverse the direction the slider slides to.  If slider goes from left to right, turning this on will make it right to left.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'touch_swipe' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_touch_swipe', true ),
			'std'           => sp_get_theme_init_setting( 'slider_touch_swipe', 'std' ),
			'label'         => __( 'Enable Touch Swipe', 'sp-theme' ),
			'desc'          => __( 'Turn this on to enable touch swiping on touch enabled devices.', 'sp-theme' ),
			'field_type'    => 'radio'
		),

		'items_to_show' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_items_to_show', true ),
			'std'           => sp_get_theme_init_setting( 'slider_items_to_show', 'std' ),
			'label'         => __( 'Max Items to Show', 'sp-theme' ),
			'desc'          => __( 'Select the maximum amount of items/slides you want to show at any given time.  Please note this does not refer to how many items in the slider total but refers to how many are visible at one time.  In addition, if you select the slider to be of type "single", then only one slide will show at a time.', 'sp-theme' ),
			'field_type'    => 'text',
			'context'       => 'carousel'
		),

		'slogan_title_font' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_slide_slogan_title_font', true ),
			'std'           => sp_get_theme_init_setting( 'slide_slogan_title_font', 'std' ),
			'label'         => __( 'Slogan Title Font', 'sp-theme' ),
			'desc'          => __( 'Select the font you want for your slogan title.', 'sp-theme' ),
			'field_type'    => 'font',
			'context'		=> 'single'
		),

		'slogan_title_font_variant' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_slogan_title_font_variant', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_slogan_title_font_variant', 'std' ),
			'label'			=> __( 'Slogan Title Font Variant', 'sp-theme' ),
			'desc'			=> __( 'Select the font variant you want to use for your title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-variant',
			'context'		=> 'single'
		),

		'slogan_title_font_subset' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_slogan_title_font_subset', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_slogan_title_font_subset', 'std' ),
			'label'			=> __( 'Slogan Title Font Subset', 'sp-theme' ),
			'desc'			=> __( 'Select the font subset you want to use for your title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-subsets',
			'context'		=> 'single'
		),

		'content_font' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_slide_content_font', true ),
			'std'           => sp_get_theme_init_setting( 'slide_content_font', 'std' ),
			'label'         => __( 'Content Font', 'sp-theme' ),
			'desc'          => __( 'Select the font you want for your content.', 'sp-theme' ),
			'field_type'    => 'font',
			'context'		=> 'single'
		),

		'content_font_variant' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_content_font_variant', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_content_font_variant', 'std' ),
			'label'			=> __( 'Content Font Variant', 'sp-theme' ),
			'desc'			=> __( 'Select the font variant you want to use for your content. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-variant',
			'context'		=> 'single'
		),

		'content_font_subset' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_content_font_subset', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_content_font_subset', 'std' ),
			'label'			=> __( 'Content Font Subset', 'sp-theme' ),
			'desc'			=> __( 'Select the font subset you want to use for your content. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-subsets',
			'context'		=> 'single'
		),

		'link_title_font' => array( 
			'saved_setting' => get_post_meta( $post_id, '_sp_slider_slide_link_title_font', true ),
			'std'           => sp_get_theme_init_setting( 'slide_link_title_font', 'std' ),
			'label'         => __( 'Slide Link Title Font', 'sp-theme' ),
			'desc'          => __( 'Select the font you want for your link title.', 'sp-theme' ),
			'field_type'    => 'font'
		),

		'link_title_font_variant' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_link_title_font_variant', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_link_title_font_variant', 'std' ),
			'label'			=> __( 'Slide Link Title Font Variant', 'sp-theme' ),
			'desc'			=> __( 'Select the font variant you want to use for your link title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-variant'
		),

		'link_title_font_subset' => array( 
			'saved_setting'	=> get_post_meta( $post_id, '_sp_slider_slide_link_title_font_subset', true ),
			'std'			=> sp_get_theme_init_setting( 'slide_link_title_font_subset', 'std' ),
			'label'			=> __( 'Slide Link Title Font Subset', 'sp-theme' ),
			'desc'			=> __( 'Select the font subset you want to use for your link title. This is set for non English language.', 'sp-theme' ),
			'field_type'	=> 'font-subsets'
		)
	);

	return $settings;
}

/**
 * function to get the slide's settings
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id the attachment id to get the meta from 
 * @param int $post_id the post id to get the meta from
 * @return array $settings
 */
function sp_get_slide_settings( $attachment_id, $post_id ) {
	// bail if no id is passed
	if ( ! isset( $post_id ) )
		return;

	// bail if no id is passed
	if ( ! isset( $attachment_id ) )
		return;

	// get the slider type from post parent
	$type = get_post_meta( $post_id, '_sp_slider_type', true );

	$settings = array();
	
	if ( $type == 'single' ) {
		$settings = array(

			'slogan_title' => array( 
				'saved_setting'	=> get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_slogan_title', true ),
				'std'			=> sp_get_theme_init_setting( 'slide_slogan_title', 'std' ),
				'label'			=> __( 'Slogan Title', 'sp-theme' ),
				'desc'			=> __( 'Enter the slogan title you want to display for this slide.', 'sp-theme' ),
				'field_type'	=> 'text'
			),

			'slogan_title_color' => array( 
				'saved_setting'	=> get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_slogan_title_color', true ),
				'std'			=> sp_get_theme_init_setting( 'slide_slogan_title_color', 'std' ),
				'label'			=> __( 'Slogan Title Color', 'sp-theme' ),
				'desc'			=> __( 'Select the text color you want for your slogan title.', 'sp-theme' ),
				'field_type'	=> 'colorpicker'
			),

			'slogan_title_size' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_slogan_title_size', true ),
				'std'           => sp_get_theme_init_setting( 'slide_slogan_title_size', 'std' ),
				'label'         => __( 'Slogan Title Size', 'sp-theme' ),
				'desc'          => __( 'Enter the font size you want for your title in pixels.  i.e. 20 for 20 pixels.  You do not need to include the PX.', 'sp-theme' ),
				'field_type'    => 'text-size'
			),

			'content' => array(
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content', true ),
				'std'           => sp_get_theme_init_setting( 'slide_content', 'std' ),
				'label'         => __( 'Content Description', 'sp-theme' ),
				'desc'          => __( 'Enter the content description verbiage you want to display for this slide.  This content is usually shown under the slogan title.', 'sp-theme' ),
				'field_type'    => 'textarea'
			),

			'content_color' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_color', true ),
				'std'           => sp_get_theme_init_setting( 'slide_content_color', 'std' ),
				'label'         => __( 'Content Color', 'sp-theme' ),
				'desc'          => __( 'Select the text color you want for your content.', 'sp-theme' ),
				'field_type'    => 'colorpicker'
			),

			'content_font_size' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_font_size', true ),
				'std'           => sp_get_theme_init_setting( 'slide_content_font_size', 'std' ),
				'label'         => __( 'Content Font Size', 'sp-theme' ),
				'desc'          => __( 'Enter the font size you want for your content in pixels.  i.e. 20 for 20 pixels.  You do not need to include the PX.', 'sp-theme' ),
				'field_type'    => 'text-size'
			),

			'link_out' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_out', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_out', 'std' ),
				'label'         => __( 'Link Redirect', 'sp-theme' ),
				'desc'          => __( 'Turn this on to enable this slide to redirect to the URL you specify below.  If kept off, the slide will not link to anywhere when clicked nor will it show any links.', 'sp-theme' ),
				'field_type'    => 'radio'
			),	

			'link_url' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_url', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link', 'std' ),
				'label'         => __( 'Link URL', 'sp-theme' ),
				'desc'          => __( 'Enter the link URL you want this slide to be redirected to when clicked.', 'sp-theme' ),
				'field_type'    => 'text'
			),

			'link_title' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_title', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_title', 'std' ),
				'label'         => __( 'Link Title', 'sp-theme' ),
				'desc'          => __( 'Enter the link title you want to display. i.e "View our Collection"', 'sp-theme' ),
				'field_type'    => 'text'
			),				

			'link_title_color' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_title_color', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_title_color', 'std' ),
				'label'         => __( 'Link Title Color', 'sp-theme' ),
				'desc'          => __( 'Select the text color you want for your link title.', 'sp-theme' ),
				'field_type'    => 'colorpicker'
			),

			'link_title_size' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_title_size', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_title_size', 'std' ),
				'label'         => __( 'Link Title Size', 'sp-theme' ),
				'desc'          => __( 'Enter the font size you want for your link title in pixels.  i.e. 20 for 20 pixels.  You do not need to include the PX.', 'sp-theme' ),
				'field_type'    => 'text-size'
			)
		);

	} elseif ( $type == 'carousel' ) {
		$settings = array(

			'title' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_title', true ),
				'std'           => sp_get_theme_init_setting( 'slide_title', 'std' ),
				'label'         => __( 'Title', 'sp-theme' ),
				'desc'          => __( 'Enter the title you want to display for this slide.', 'sp-theme' ),
				'field_type'    => 'text'
			),

			'title_color' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_title_color', true ),
				'std'           => sp_get_theme_init_setting( 'slide_title_color', 'std' ),
				'label'         => __( 'Title Color', 'sp-theme' ),
				'desc'          => __( 'Select the text color you want for your title.', 'sp-theme' ),
				'field_type'    => 'colorpicker'
			),

			'title_size' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_title_size', true ),
				'std'           => sp_get_theme_init_setting( 'slide_title_size', 'std' ),
				'label'         => __( 'Title Size', 'sp-theme' ),
				'desc'          => __( 'Enter the font size you want for your title in pixels.  i.e. 20 for 20 pixels.  You do not need to include the PX.', 'sp-theme' ),
				'field_type'    => 'text-size'
			),

			'link_out' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_out', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_out', 'std' ),
				'label'         => __( 'Link Redirect', 'sp-theme' ),
				'desc'          => __( 'Turn this on to enable this slide to redirect to the URL you specify below.  If kept off, the slide will not link to anywhere when clicked nor will it show any links.', 'sp-theme' ),
				'field_type'    => 'radio'
			),	

			'link_url' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_url', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link', 'std' ),
				'label'         => __( 'Link URL', 'sp-theme' ),
				'desc'          => __( 'Enter the link URL you want this slide to be redirected to when clicked.', 'sp-theme' ),
				'field_type'    => 'text'
			),
		
			'link_lightbox' => array( 
				'saved_setting' => get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_link_lightbox', true ),
				'std'           => sp_get_theme_init_setting( 'slide_link_lightbox', 'std' ),
				'label'         => __( 'Open Lightbox', 'sp-theme' ),
				'desc'          => __( 'Turn this on if you want your slide media to open up in a modal lightbox when clicked.  Note that this supercedes the above link redirection option.  So enabling this will no longer link out to another URL when image is clicked.', 'sp-theme' ),
				'field_type'    => 'radio'
			)			
		);
	}
	
	return $settings;
}

/**
 * Function that builds the display for carousel slider
 *
 * @access public
 * @since 3.0
 * @param int $post_id | the post id of the slider
 * @return mixed html
 */	
function sp_display_carousel_slider( $post_id ) {

	// get parent post
	$parent_post_obj = get_post( $post_id );

	// bail if parent post cannot be found
	if ( null === $parent_post_obj )
		return;

	// if not cached query it
	if ( false === $attachments_obj = get_transient( 'sp-carousel-slider-' . $post_id ) ) {
		// build the argument list to get the attachments
		$args = array(
			'posts_per_page' 	=> -1,
			'orderby'			=> 'meta_value_num',
			'order'				=> 'ASC',
			'meta_key'			=> '_sp_post_parent_' . $post_id . '_slide_sort_order',
			'post_type'			=> 'attachment',
			'post_status' 		=> 'any',
			'meta_query'		=> array(
				array(
					'key'		=> '_sp_slide_post_parent',
					'value'		=> $post_id
				)
			)		
		);

		$attachments_obj = new WP_Query( $args );

		// set the cache
		set_transient( 'sp-carousel-slider-' . $post_id, $attachments_obj );
	}

	// grab all slider settings
	$slider_settings = sp_get_slider_settings( $post_id );

	// grab slide settings
	$slide_settings = sp_get_slide_settings( get_the_ID(), $post_id );

	$show_overlay				= $slider_settings['show_text_overlay']['saved_setting'];
	$overlay_opacity			= $slider_settings['overlay_opacity']['saved_setting'];
	$overlay_color				= $slider_settings['overlay_color']['saved_setting'];
	$overlay_position			= $slider_settings['overlay_position']['saved_setting'];
	$slider_show_title			= $slider_settings['show_title']['saved_setting'];
	$slider_title_color			= $slider_settings['title_color']['saved_setting'];
	$slider_title_size			= $slider_settings['title_size']['saved_setting'];
	$slider_title_font			= $slider_settings['title_font']['saved_setting'];
	$slider_title_text			= $slider_settings['title_text']['saved_setting'];
	$carousel_item_width		= $slider_settings['carousel_item_width']['saved_setting'];
	$carousel_item_height		= $slider_settings['carousel_item_height']['saved_setting'];
	$slider_type				= $slider_settings['type']['saved_setting'];
	$slider_mode				= $slider_settings['mode']['saved_setting'];
	$slider_bg_color			= $slider_settings['slider_bg_color']['saved_setting'];
	$slider_nav					= $slider_settings['nav']['saved_setting'];
	$slider_dot_nav				= $slider_settings['dot_nav']['saved_setting'];
	$slider_easing				= $slider_settings['easing']['saved_setting'];
	$slider_randomize			= $slider_settings['randomize']['saved_setting'];
	$slider_autoscroll			= $slider_settings['autoscroll']['saved_setting'];
	$slider_interval			= $slider_settings['interval']['saved_setting'];
	$slider_circular			= $slider_settings['circular']['saved_setting'];
	$slider_pause_on_hover		= $slider_settings['pause_on_hover']['saved_setting'];
	$slider_items_per_click		= $slider_settings['items_per_click']['saved_setting'];
	$slider_transition_speed	= $slider_settings['transition_speed']['saved_setting'];
	$slider_reverse_direction	= $slider_settings['reverse_direction']['saved_setting'];
	$slider_touchswipe			= $slider_settings['touch_swipe']['saved_setting'];
	$slider_items_to_show		= $slider_settings['items_to_show']['saved_setting'];
	$slide_link_font			= $slider_settings['link_title_font']['saved_setting'];
	$slide_content_font			= $slider_settings['content_font']['saved_setting'];
	$slide_slogan_title_font	= $slider_settings['slogan_title_font']['saved_setting'];	

	$output = '';

	// calculate opacity
	$overlay_opacity = str_replace( '%', '', $overlay_opacity );
	$overlay_opacity = $overlay_opacity * 0.01; // i.e. converts 20 to 0.2
	
	// if show title is on
	if ( $slider_show_title === 'on' ) {
		$slider_title_style = '';
		
		if ( isset( $slider_title_color ) && ! empty( $slider_title_color ) )
			$slider_title_style .= 'color:#' . str_replace( '#', '', $slider_title_color ) . ';';

		if ( isset( $slider_title_size ) && ! empty( $slider_title_size ) )
			$slider_title_style .= 'font-size:' . str_replace( 'px', '', $slider_title_size ) . 'px;';
		
		if ( isset( $slider_title_font ) && ! empty( $slider_title_font ) && $slider_title_font !== 'none' )
			$slider_title_style .= 'font-family:"' . $slider_title_font . '", arial;';

		$output .= '<h3 style="' . esc_attr( $slider_title_style ) . '" class="slider-title entry-title"><span>' . $slider_title_text . '</span></h3>' . PHP_EOL;					
	}

	if ( isset( $slider_bg_color ) && ! empty( $slider_bg_color ) )
		$slider_bg_style = 'background-color:#' . str_replace( '#', '', $slider_bg_color ) . ';';
	else 
		$slider_bg_style = '';

	// only set if slider is type single and overlay is on
	if ( $slider_type === 'single' && $show_overlay === 'on' )
		$overlay_position_class = 'overlay-' . $overlay_position;
	else
		$overlay_position_class = '';

	if ( $slider_type === 'single' )
		$output .= '<div class="inner-container single ' . $overlay_position_class . '" style="' . esc_attr( $slider_bg_style ) . '">' . PHP_EOL;
	else
		$output .= '<div class="inner-container carousel">' . PHP_EOL;

	$output .= '<div class="carousel-container">' . PHP_EOL;

	// loop through each attachments
	while ( $attachments_obj->have_posts() ) : $attachments_obj->the_post();
		$output .= '<div class="slide">' . PHP_EOL;

		// get the post mime type
		$mime_type = get_post( get_the_ID() )->post_mime_type;

		// check slider type
		if ( $slider_type === 'single' ) {
			// get the full size image
			$attached_image_full = sp_get_image( get_the_ID() );	
						
			$slide_link_out					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_out', true );
			$slide_link_url					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_url', true );
			$slide_link_title				= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_title', true );
			$slide_link_font_size			= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_title_size', true );
			$slide_link_color				= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_title_color', true );
			$slide_content					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_content', true );
			$slide_content_font_size		= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_content_font_size', true );
			$slide_content_color			= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_content_color', true );
			$slide_slogan_title				= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_slogan_title', true );
			$slide_slogan_title_color		= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_slogan_title_color', true );
			$slide_slogan_title_font_size	= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_slogan_title_font_size', true );

			// check mime type
			switch( substr( $mime_type, 0, strpos( $mime_type, '/' ) ) ) {
				case 'image' :
					// add anchor tag if link is on and set
					if ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) ) 
						$output .= '<a href="' . esc_url( $slide_link_url ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
					
					$output .= '<img src="' . $attached_image_full['url'] . '" alt="' . esc_attr( $attached_image_full['alt'] ) . '" class="slide-image" />';
					
					// add anchor tag if link is on and set
					if ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) ) 
						$output .= '</a>' . PHP_EOL;

					$overlay_styles = '';

					// textblock content
					if ( isset( $slide_content ) && ! empty( $slide_content ) ) {

						// build content styles
						$content_styles = '';

						if ( isset( $slide_content_font_size ) && ! empty( $slide_content_font_size ) )
							$content_styles .= 'font-size:' . str_replace( 'px', '', $slide_content_font_size ) . 'px;';

						if ( isset( $slide_content_color ) && ! empty( $slide_content_color ) ) 
							$content_styles .= 'color:#' . str_replace( '#', '', $slide_content_color ) . ';';

						if ( isset( $slide_content_font ) && ! empty( $slide_content_font ) && $slide_content_font !== 'none' )
							$content_styles .= 'font-family:' . $slide_content_font . ',sans-serif;';

						$output .= '<div class="textblock-container row ' . $overlay_position . '">' . PHP_EOL;
						$output .= '<div class="textblock">' . PHP_EOL;
						
						// if slogan title is set
						if ( isset( $slide_slogan_title ) && $slide_slogan_title != '' ) {
							$title_styles = '';

							if ( isset( $slide_slogan_title_color ) && ! empty( $slide_slogan_title_color ) )
								$title_styles .= 'color:#' . str_replace( '#', '', $slide_slogan_title_color ) . ';';

							if ( isset( $slide_slogan_title_font_size ) && ! empty( $slide_slogan_title_font_size ) )
								$title_styles .= 'font-size:' . str_replace( 'px', '', $slide_slogan_title_font_size ) . 'px;';

							if ( isset( $slide_slogan_title_font ) && ! empty( $slide_slogan_title_font ) && $slide_slogan_title_font !== 'none' )
								$title_styles .= 'font-family:' . $slide_slogan_title_font . ', sans-serif;';

							$output .= '<h3 style="' . esc_attr( $title_styles ) . '" class="slogan-title">' . $slide_slogan_title . '</h3>' . PHP_EOL;
						}

						$output .= '<p style="' . esc_attr( $content_styles ) . '">' . $slide_content . '</p>' . PHP_EOL;

						// add anchor tag if link is on and set
						if ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) ) {				
							$link_styles = '';

							if ( isset( $slide_link_color ) && ! empty( $slide_link_color ) )
								$link_styles .= 'color:#' . str_replace( '#', '', $slide_link_color ) . ';';

							if ( isset( $slide_link_font_size ) && ! empty( $slide_link_font_size ) )
								$link_styles .= 'font-size:' . str_replace( 'px', '', $slide_link_font_size ) . 'px;';

							if ( isset( $slide_link_font ) && ! empty( $slide_link_font ) && $slide_link_font !== 'none' )
								$link_styles .= 'font-family:' . $slide_link_font . ', sans-serif;';

							$output .= '<a href="' . esc_url( $slide_link_url ) . '" title="' . the_title_attribute( 'echo=0' ) . '" style="' . esc_attr( $link_styles ) . '" class="link-out">' . $slide_link_title . '</a>';	
						}					
						$output .= '</div><!--close .textblock-->' . PHP_EOL;

						$output .= '</div><!--close .textblock-container-->' . PHP_EOL;
					}

					break;

				case 'video' :
					// get external video link meta
					$external_link = get_the_content();

					// check if video is external - for video sharing sites like vimeo and youtube
					if ( isset( $external_link ) && ! empty( $external_link ) ) {
						$output .= '<iframe src="' . esc_url( $external_link ) . '" class="video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
					} else {
						$video_link = wp_get_attachment_url( get_the_ID() );
						$video_link_mp4 = $video_link;
						$video_link_ogg = substr( $video_link, 0, strrpos( $video_link, '.' ) ) . '.ogv';
						$video_link_webm = substr( $video_link, 0, strrpos( $video_link, '.' ) ) . '.webm';

						$output .= '<video class="video" controls="controls" id="video-' . get_the_ID() . '">' . PHP_EOL;

						$output .= '<source src="' . $video_link_mp4 . '" type="video/mp4">' . PHP_EOL;
						
						// checks if file exists then try to load
						if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.ogv' ) )
							$output .= '<source src="' . $video_link_ogg . '" type="video/ogv">' . PHP_EOL;

						// checks if file exists then try to load
						if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.webm' ) )
							$output .= '<source src="' . $video_link_webm . '" type="video/webm">' . PHP_EOL;

						$output .= '<p>' . __( 'Sorry! Your browser does not support HTML 5 video.  Please use a more modern browser!', 'sp-theme' ) . '</p>' . PHP_EOL;
						$output .= '</video>' . PHP_EOL;
					
					}

					break;

				case 'audio' :
					$audio_link = wp_get_attachment_url( get_the_ID() );
					$audio_link_mpeg = $audio_link;
					$audio_link_ogg = substr( $audio_link, 0, strrpos( $audio_link, '.' ) ) . '.ogg';
					$audio_link_wav = substr( $audio_link, 0, strrpos( $audio_link, '.' ) ) . '.wav';

					$output .= '<audio class="audio" controls="controls" id="audio-' . get_the_ID() . '">' . PHP_EOL;
					$output .= '<source src="' . $audio_link_mpeg . '"  type="audio/mpeg" />' . PHP_EOL;

					// checks if file exists then try to load
					if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.ogg' ) )
						$output .= '<source src="' . $audio_link_ogg . '"  type="audio/ogg" />' . PHP_EOL;

					// checks if file exists then try to load
					if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.wav' ) )
						$output .= '<source src="' . $audio_link_wav . '"  type="audio/wav" />' . PHP_EOL;

					$output .= '<p>' . __( 'Sorry! Your browser does not support HTML 5 audio.  Please use a more modern browser!', 'sp-theme' ) . '</p>' . PHP_EOL;
					$output .= '</audio>' . PHP_EOL;	
					
					break;

				case 'content' :
					// get the content
					$content_text = get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_content_text', true );

					// show this if it is a content slide
					$output .= '<div class="content-text">' . PHP_EOL;
					$output .= wpautop( $content_text ) . PHP_EOL;
					$output .= '</div><!--close .content-->' . PHP_EOL;

					break;
			}	
			
		} elseif ( $slider_type === 'carousel' ) {

			$slide_link_out					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_out', true );
			$slide_link_url					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_url', true );
			$slide_title					= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_title', true );
			$slide_title_color				= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_title_color', true );
			$slide_title_size				= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_title_size', true );
			$slide_link_lightbox			= get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_link_lightbox', true );

			// clean up size
			$carousel_item_width = str_replace( 'px', '', $carousel_item_width );
			$carousel_item_height = str_replace( 'px', '', $carousel_item_height );

			$attached_image_full = sp_get_image( get_the_ID() );
			$attached_image_thumb = sp_get_image( get_the_ID(), $carousel_item_width, $carousel_item_height, true );

			// check mime type
			switch( substr( $mime_type, 0, strpos( $mime_type, '/' ) ) ) {
				case 'image' :
					// add anchor tag if link is on and set
					if ( $slide_link_lightbox === 'on' ) {
						$output .= '<a href="' . esc_url( $attached_image_full['url'] ) . '" title="' . the_title_attribute( 'echo=0' ) . '" data-rel="sp-lightbox[' . get_the_ID() . ']" class="carousel-lightbox mfp-image">';
					} elseif ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) && $slide_link_lightbox === 'off' ) {
						$output .= '<a href="' . esc_url( $slide_link_url ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
					}

					$output .= '<img src="' . $attached_image_thumb['url'] . '" alt="' . esc_attr( $attached_image_full['alt'] ) . '" class="slide-image" />';
					
					// add anchor tag if link is on and set
					if ( $slide_link_lightbox === 'on' )
						$output .= '<i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;				
					elseif ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) && $slide_link_lightbox === 'off' )
						$output .= '<i class="icon-link" aria-hidden="true"></i></a>' . PHP_EOL;	
					
					break;

				case 'video' :
					// get external video link meta
					$external_link = get_the_content();

					// check if video is external - for video sharing sites like vimeo and youtube
					if ( isset( $external_link ) && ! empty( $external_link ) ) {
						$output .= '<iframe src="' . esc_url( $external_link ) . '" class="video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
					} else {
						$video_link = wp_get_attachment_url( get_the_ID() );
						$video_link_mp4 = $video_link;
						$video_link_ogg = substr( $video_link, 0, strrpos( $video_link, '.' ) ) . '.ogv';
						$video_link_webm = substr( $video_link, 0, strrpos( $video_link, '.' ) ) . '.webm';

						$video_styles = '';
						$video_styles .= 'width:' . apply_filters( 'sp_carousel_slide_size_width', $carousel_item_width ) . 'px;';
						$video_styles .= 'height:' . apply_filters( 'sp_carousel_slide_size_height', $carousel_item_height ) . 'px;';

						$output .= '<video class="video" controls="controls" id="video-' . get_the_ID() . '" style="' . esc_attr( $video_styles ) . '">' . PHP_EOL;

						$output .= '<source src="' . $video_link_mp4 . '" type="video/mp4">' . PHP_EOL;
						
						// checks if file exists then try to load
						if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.ogv' ) )
							$output .= '<source src="' . $video_link_ogg . '" type="video/ogv">' . PHP_EOL;

						// checks if file exists then try to load
						if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.webm' ) )
							$output .= '<source src="' . $video_link_webm . '" type="video/webm">' . PHP_EOL;

						$output .= '<p>' . __( 'Sorry! Your browser does not support HTML 5 video.  Please use a more modern browser!', 'sp-theme' ) . '</p>' . PHP_EOL;
						$output .= '</video>' . PHP_EOL;
					
					}

					break;

				case 'audio' :
					$audio_link = wp_get_attachment_url( get_the_ID() );
					$audio_link_mpeg = $audio_link;
					$audio_link_ogg = substr( $audio_link, 0, strrpos( $audio_link, '.' ) ) . '.ogg';
					$audio_link_wav = substr( $audio_link, 0, strrpos( $audio_link, '.' ) ) . '.wav';

					$audio_styles = '';
					$audio_styles .= 'width:' . apply_filters( 'sp_carousel_slide_size_width', $carousel_item_width ) . 'px;';
					$audio_styles .= 'height:' . apply_filters( 'sp_carousel_slide_size_height', $carousel_item_height ) . 'px;';

					$output .= '<audio class="audio" controls="controls" id="audio-' . get_the_ID() . '" style="' . esc_attr( $audio_styles ) . '">' . PHP_EOL;
					$output .= '<source src="' . $audio_link_mpeg . '"  type="audio/mpeg" />' . PHP_EOL;

					// checks if file exists then try to load
					if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.ogg' ) )
						$output .= '<source src="' . $audio_link_ogg . '"  type="audio/ogg" />' . PHP_EOL;

					// checks if file exists then try to load
					if ( file_exists( substr( get_attached_file( get_the_id() ), 0, strrpos( get_attached_file( get_the_id() ), '.' ) ) . '.wav' ) )
						$output .= '<source src="' . $audio_link_wav . '"  type="audio/wav" />' . PHP_EOL;

					$output .= '<p>' . __( 'Sorry! Your browser does not support HTML 5 audio.  Please use a more modern browser!', 'sp-theme' ) . '</p>' . PHP_EOL;
					$output .= '</audio>' . PHP_EOL;	
					
					break;

				case 'content' :
					// get the content
					$content_text = get_post_meta( get_the_ID(), '_sp_post_parent_' . $post_id . '_slide_content_text', true );

					$content_text_styles = '';
					$content_text_styles .= 'width:' . apply_filters( 'sp_carousel_slide_size_width', $carousel_item_width ) . 'px;';
					$content_text_styles .= 'height:' . apply_filters( 'sp_carousel_slide_size_height', $carousel_item_height ) . 'px;';

					// show this if it is a content slide
					$output .= '<div class="content-text" style="' . esc_attr( $content_text_styles ) . '">' . PHP_EOL;
					$output .= $content_text . PHP_EOL;
					$output .= '</div><!--close .content-->' . PHP_EOL;

					break;
			}	

			$link_styles = '';

			if ( isset( $slide_title_color ) && ! empty( $slide_title_color ) )
				$link_styles .= 'color:#' . str_replace( '#', '', $slide_title_color ) . ';';

			if ( isset( $slide_title_size ) && ! empty( $slide_title_size ) )
				$link_styles .= 'font-size:' . str_replace( 'px', '', $slide_title_size ) . 'px;';

			if ( isset( $slide_link_font ) && ! empty( $slide_link_font ) && $slide_link_font !== 'none' )
				$link_styles .= 'font-family:' . $slide_link_font . ', sans-serif;';			
			
			// add anchor tag if link is on and set
			if ( $slide_link_out === 'on' && isset( $slide_link_url ) && ! empty( $slide_link_url ) ) {
				$output .= '<h2><a href="' . esc_url( $slide_link_url ) . '" title="' . the_title_attribute( 'echo=0' ) . '" style="' . esc_attr( $link_styles ) . '" class="link-out">' . $slide_title . '</a></h2>';	
			} elseif ( isset( $slide_title ) && ! empty( $slide_title ) ) {
				$output .= '<h2 style="' . esc_attr( $link_styles ) . '">' . $slide_title . '</h2>' . PHP_EOL;
			}	
		}

		$output .= '</div><!--close .slide-->' . PHP_EOL;
	
	endwhile;

	wp_reset_postdata();

	$output .= '</div><!--close .carousel-container-->' . PHP_EOL;

	// show only for type single slider
	if ( $slider_type === 'single' && $show_overlay ) {
		if ( isset( $overlay_color ) && ! empty( $overlay_color ) && isset( $overlay_opacity ) && ! empty( $overlay_opacity ) ) {
			$overlay_styles .= 'background-color:rgba(' . sp_hex2rgb( $overlay_color ) . ',' . $overlay_opacity . ');';
			$output .= '<div class="overlay" style="' . esc_attr( $overlay_styles ) . '"></div>' . PHP_EOL;
		}
	}

	$output .= '</div><!--close .inner-container-->' . PHP_EOL;

	$output .= '<input type="hidden" name="slider_type" value="' . esc_attr( $slider_type ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_mode" value="' . esc_attr( $slider_mode ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_show_text_overlay" value="' . esc_attr( $show_overlay ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_overlay_position" value="' . esc_attr( $overlay_position ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_carousel_item_width" value="' . esc_attr( $carousel_item_width ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_easing" value="' . esc_attr( $slider_easing ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_randomize" value="' . esc_attr( $slider_randomize ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_autoscroll" value="' . esc_attr( $slider_autoscroll ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_interval" value="' . esc_attr( $slider_interval ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_circular" value="' . esc_attr( $slider_circular ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_nav" value="' . esc_attr( $slider_nav ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_dot_nav" value="' . esc_attr( $slider_dot_nav ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_pause_on_hover" value="' . esc_attr( $slider_pause_on_hover ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_items_per_click" value="' . esc_attr( $slider_items_per_click ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_transition_speed" value="' . esc_attr( $slider_transition_speed ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_reverse_direction" value="' . esc_attr( $slider_reverse_direction ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_touchswipe" value="' . esc_attr( $slider_touchswipe ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="slider_items_to_show" value="' . esc_attr( $slider_items_to_show ) . '" />' . PHP_EOL;

	return $output;
}