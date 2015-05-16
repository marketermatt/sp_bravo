<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * shortcodes module 32 modules
*/

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function that returns the shortcode modules array
 *
 * @access public
 * @since 3.0
 * @return array $module | list of all modules in array
 */
function sp_shortcodes_module() {
	$module = array(
		'grid' => array(
			'title' => __( 'Grid Layout', 'sp-theme' ),
			'options' => array(
				'span' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets how many columns you want to span.', 'sp-theme' ),
					'default' => '12',
					'form_type' => 'select',
					'settings' => array(
						'1',
						'2',
						'3',
						'4',
						'5',
						'6',
						'7',
						'8',
						'9',
						'10',
						'12'
					),
				),

				'first' => array(
					'requirement' => 'required',
					'info' => __( 'Setting this declares the first column in a row. "IMPORTANT"', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'last' => array(
					'requirement' => 'required',
					'info' => __( 'Setting this declares the last column in a row. "IMPORTANT"', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				)
			),

			'shortcode' => '[sp-grid first="true" last="true"]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-grid]',
			'shortcode_name' => 'sp-grid',
			'shortcode_callback' => 'sp_grid_shortcode'
		),

		'social_media_fb' => array(
			'title' => __( 'Facebook Like', 'sp-theme' ),
			'options' => array(
				'url' => array(
					'requirement' => 'optional',
					'info' => __( 'The URL you want your button to link to. If not specify, it will pick up the current page\'s URL.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'send_button' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will include a send button next to the like button.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'layout' => array(
					'requirement' => 'optional',
					'info' => __( 'This controls the layout of the button.', 'sp-theme' ),
					'default' => 'button_count',
					'form_type' => 'select',
					'settings' => array(
						'button_count',
						'box_count',
						'standard'
					)
				),

				'width' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the width of the button. Enter a pixel value.  Leave blank for auto.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'show_faces' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will show profile faces below the button.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'verb' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this shows a different verb text on the button either like or recommend.', 'sp-theme' ),
					'default' => 'like',
					'form_type' => 'select',
					'settings' => array(
						'like',
						'recommend'
					)
				)
			),	

			'shortcode' => '[sp-fblike]',
			'shortcode_name' => 'sp-fblike',
			'shortcode_callback' => 'sp_fblikebutton_shortcode'
		),

		'social_media_tweet' => array(
			'title' => __( 'Twitter Tweet', 'sp-theme' ),
			'options' => array(
				'url' => array(
					'requirement' => 'optional',
					'info' => __( 'The URL you want your button to link to. If not specify, it will pick up the current page\'s URL.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'count_position' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the position of the counter.', 'sp-theme' ),
					'default' => 'horizontal',
					'form_type' => 'select',
					'settings' => array(
						'none',
						'horizontal',
						'vertical'
					)
				),

				'size' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the size of the button.', 'sp-theme' ),
					'default' => 'medium',
					'form_type' => 'select',
					'settings' => array(
						'medium',
						'large'
					)
				),

				'type' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the type of button to use.', 'sp-theme' ),
					'default' => 'share',
					'form_type' => 'select',
					'settings' => array(
						'share',
						'hashtag',
						'mention'
					)
				),

				'hashtag' => array(
					'requirement' => 'optional',
					'info' => __( 'This is to set the hashtag you want.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'hashtag_text' => array(
					'requirement' => 'optional',
					'info' => __( 'If hashtag is set, enter the text you want for the hashtag.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'tweet_to' => array(
					'requirement' => 'optional', 
					'info' => __( 'If type is set to mention, enter the name to mention to.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array( 

					)
				)
			),

			'shortcode' => '[sp-tweet]',
			'shortcode_name' => 'sp-tweet',
			'shortcode_callback' => 'sp_tweetbutton_shortcode'																	
		),

		'social_media_twitter_follow' => array(
			'title' => __( 'Twitter Follow', 'sp-theme' ),
			'options' => array(
				'user' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the user name of the Twitter account.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'show_username' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets whether you want to display the username on the follow button.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'size' => array(
					'requirement' => 'optional', 
					'info' => __( 'This sets the size of the button.', 'sp-theme' ),
					'default' => 'normal',
					'form_type' => 'select',
					'settings' => array(
						'normal',
						'large'
					)
				)
			),

			'shortcode' => '[sp-twitter-follow user=""]',
			'shortcode_name' => 'sp-twitter-follow',
			'shortcode_callback' => 'sp_twitterfollow_shortcode'			
		),

		'social_media_gplusone' => array(
			'title' => __( 'Google Plus One', 'sp-theme' ),
			'options' => array(
				'url' => array(
					'requirement' => 'optional',
					'info' => __( 'The URL you want your button to link to. If not specify, it will pick up the current page\'s URL.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'size' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the size of the button.', 'sp-theme' ),
					'default' => 'small',
					'form_type' => 'select',
					'settings' => array(
						'small',
						'medium',
						'standard',
						'tall'
					)
				),

				'annotation' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the type of button to use.', 'sp-theme' ),
					'default' => 'bubble',
					'form_type' => 'select',
					'settings' => array(
						'bubble',
						'inline',
						'none'
					)
				)
			),

			'shortcode' => '[sp-gplusone]',
			'shortcode_name' => 'sp-gplusone',
			'shortcode_callback' => 'sp_gplusonebutton_shortcode'		
		),

		'social_media_pinit' => array(
			'title' => __( 'Pinterest Pin It', 'sp-theme' ),
			'options' => array(
				'page_url' => array(
					'requirement' => 'optional',
					'info' => __( 'The page URL you want your button to link to. If not specify, it will pick up the current page\'s URL.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array( 

					)
				),

				'image_url' => array(
					'requirement' => 'optional',
					'info' => __( 'The image URL you want your button to link to. If not specify, it will pick up the current page\'s featured image.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array( 

					)
				),

				'description' => array(
					'requirement' => 'optional',
					'info' => __( 'The description you want for this pin.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'count_layout' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the position of the counter.', 'sp-theme' ),
					'default' => 'horizontal',
					'form_type' => 'select',
					'settings' => array(
						'horizontal',
						'vertical',
						'none'
					)
				)
			),

			'shortcode' => '[sp-pinit]',
			'shortcode_name' => 'sp-pinit',
			'shortcode_callback' => 'sp_pinit_shortcode'	
		),

		'tabs' => array(
			'title' => __( 'Tabs', 'sp-theme' ),
			'options' => array(
				'tab_names' => array(
					'requirement' => 'required',
					'info' => __( 'Enter each title of the tabs you want to show separated by a comma.  For example "Tab1,Tab2,Tab3"...etc', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'width' => array( 
					'requirement' => 'optional',
					'info' => __( 'This sets the width of the tabs if you need it to be a set width.  Enter a pixel value. It is recommended to leave this as default auto so it will generate the width based on the container.', 'sp-theme' ),
					'default' => 'auto',
					'form_type' => 'text',
					'settings' => array(
						'auto'
					)
				),

				'collapsible' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will make any of the tabs collapsible even if it is the only one opened.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'active' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the tab you want to show as the active tab when the page loads.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'tab_icon' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this allows you to input an icon next to the tab title.  Separate each icon for each tab respectively with a comma.  You can use any available class names from the icon font list. You can find the icon font list by going to your theme documentation folder and opening the icon-font.html file in your browser.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)	
			),

			'shortcode' => '[sp-tabs tab_names=""][sp-tab-content tab=""]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-tab-content][/sp-tabs]',
			'shortcode_name' => 'sp-tabs',
			'shortcode_callback' => 'sp_tabs_shortcode'																												
		),

		'tab_content' => array(
			'title' => __( 'Tab Content', 'sp-theme' ),
			'options' => array(
				'tab' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the corresponding title you entered in the tabs shortcode.  They must match for the tabs to work.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'text_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the text color of the content text.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)
			),

			'shortcode' => '[sp-tab-content tab=""]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-tab-content]',
			'shortcode_name' => 'sp-tab-content',
			'shortcode_callback' => 'sp_tabs_content_shortcode'							
		),

		'carousel_slider' => array(
			'title' => __( 'Carousel Slider', 'sp-theme' ),
			'options' => array(
				'id' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the carousel slider you want to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)	
			),

			'shortcode' => '[sp-carousel id=""]',
			'shortcode_name' => 'sp-carousel',
			'shortcode_callback' => 'sp_carousel_shortcode'				
		),

		'layer_slider' => array(
			'title' => __( 'Layer Slider', 'sp-theme' ),
			'options' => array(
				'id' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the layer slider you want to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)						
			),

			'shortcode' => '[layerslider id=""]',
			'shortcode_name' => 'layerslider',
			'shortcode_callback' => 'layerslider_init'
		),

		'callout' => array(
			'title' => __( 'Callout Box', 'sp-theme' ),
			'options' => array(
				'type' => array(
					'requirement' => 'optional',
					'info' => __( 'Select the type of callout box you want to display.', 'sp-theme' ),
					'default' => 'alert-info',
					'form_type' => 'select',
					'settings' => array(
						'alert-info',
						'alert-warning',
						'alert-danger',
						'alert-success'
					)
				),

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the title you want to display for the callout box.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'icon' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this allows you to input an icon next to the title.  You can use any available class names from the icon font list. You can find the icon font list by going to your theme documentation folder and opening the icon-font.html file in your browser.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'inner_wrap_content' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the content you want to show inside the callout box.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'textarea',
					'settings' => array(

					)
				)			
			),

			'shortcode' => '[sp-callout]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-callout]',
			'shortcode_name' => 'sp-callout',
			'shortcode_callback' => 'sp_callout_shortcode'
		),

		'dropcap' => array(
			'title' => __( 'Dropcaps', 'sp-theme' ),
			'options' => array(
				'size' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the size of the font/text in pixels for your dropcap.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the text color of the dropcap.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'bg_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the background color of the dropcap.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'bg_style' => array(
					'requirement' => 'optional',
					'info' => __( 'This setting sets the background style of the dropcap if background color is used.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'select',
					'settings' => array(
						'square',
						'circle'
					)
				),

				'inner_wrap_content' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the letter you want to make dropcap.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)				
			),

			'shortcode' => '[sp-dropcap]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-dropcap]',
			'shortcode_name' => 'sp-dropcap',
			'shortcode_callback' => 'sp_dropcap_shortcode'
		),

		'accordion' => array(
			'title' => __( 'Accordion', 'sp-theme' ),
			'options' => array(
				'collapsible' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will make any of the accordion collapsible even if it is the only one opened.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'active_panel' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the active panel when the page loads. Enter "1" for the first panel, "2" for second..etc.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'style' => array(
					'requirement' => 'optional',
					'info' => __( 'Choose between two different styles.', 'sp-theme' ),
					'default' => '1',
					'form_type' => 'select',
					'settings' => array(
						'1',
						'2'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-accordion][sp-accordion-content]' . __( 'YOUR CONTENT HERE', 'sp-theme' ) . '[/sp-accordion-content][/sp-accordion]',
			'shortcode_name' => 'sp-accordion',
			'shortcode_callback' => 'sp_accordion_shortcode'
		),

		'accordion_content' => array(
			'title' => __( 'Accordion Content', 'sp-theme' ),
			'options' => array(
				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the title of the accordion as the heading.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'icon' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this allows you to input an icon next to the title.  You can use any available class names from the icon font list. You can find the icon font list by going to your theme documentation folder and opening the icon-font.html file in your browser.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)
			),

			'shortcode' => '[sp-accordion-content]',
			'shortcode_name' => 'sp-accordion-content',
			'shortcode_callback' => 'sp_accordion_content_shortcode'
		),

		'hr' => array(
			'title' => __( 'Horizontal Rule', 'sp-theme' ),
			'options' => array(
				'color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the color of the line.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'style' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the style of line you want to display.', 'sp-theme' ),
					'default' => 'dashed',
					'form_type' => 'select',
					'settings' => array(
						'dashed',
						'solid',
						'dotted'
					)
				),

				'width' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the width of the line you want. Enter a pixel value.  It is recommended to keep this as default so it spans the width of the container.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'thickness' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the thickness of the line in pixels.  Enter a pixel value.  So "1" would be 1 pixel thick.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)				
			),
	
			'shortcode' => '[sp-hr]',
			'shortcode_name' => 'sp-hr',
			'shortcode_callback' => 'sp_hr_shortcode'
		),

		'btt' => array(
			'title' => __( 'Back to Top', 'sp-theme' ),
			'options' => array(
				'animate' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will have a slide effect when back to top is clicked.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'text_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the color of the text.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'bg_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the color of the background.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'position' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the position of the back to top button.  Left would float items to the right of it and right would float items to the left of it and center will just center the button by iteself.', 'sp-theme' ),
					'default' => 'none',
					'form_type' => 'select',
					'settings' => array(
						'none',
						'left',
						'center',
						'right'
					)
				),

				'style' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the style of the button.  Style 1 puts the icon arrow on top of the text and Style 2 puts the icon arrow to the right of the text.', 'sp-theme' ),
					'default' => '1',
					'form_type' => 'select',
					'settings' => array(
						'1',
						'2'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)				
			),

			'shortcode' => '[sp-btt]',
			'shortcode_name' => 'sp-btt',
			'shortcode_callback' => 'sp_back_to_top'
		),

		'map' => array(
			'title' => __( 'Google Map', 'sp-theme' ),
			'options' => array(
				'width' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the width of the map if you need it to be a set width.  Enter a value in pixels.  You can also enter "100%" and "auto"', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'height' => array(
					'requirement' => 'required',
					'info' => __( 'This sets the height of the map if you need it to be a set height.  Enter a value in pixels.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'zoom' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the initial zoom level of the map. The higher the number the more zoomed in it will be.', 'sp-theme' ),
					'default' => '15',
					'form_type' => 'select',
					'settings' => array(
						'0',
						'1',
						'2',
						'3',
						'4',
						'5',
						'6',
						'7',
						'8',
						'9',
						'10',
						'11',
						'12',
						'13',
						'14',
						'15',
						'16',
						'17',
						'18'
					)
				),

				'address' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the address you wish the map to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'static' => array( 
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will render a static image of the map instead of interactive.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'directions_link' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display a link to the maps and directions page of Google.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				)
			),

			'shortcode' => '[sp-map address=""]',
			'shortcode_name' => 'sp-map',
			'shortcode_callback' => 'sp_google_map_shortcode'
		),

		'blockquote' => array(
			'title' => __( 'Blockquote', 'sp-theme' ),
			'options' => array(
				'text_align' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the alignment of the text within the blockquote.', 'sp-theme' ),
					'default' => 'center',
					'form_type' => 'select',
					'settings' => array(
						'center',
						'left',
						'right'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'inner_wrap_content' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the content you want to show inside the quote box.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'textarea',
					'settings' => array(

					)
				)								
			),

			'shortcode' => '[sp-blockquote]' . __( 'YOUR QUOTE HERE', 'sp-theme' ) . '[/sp-blockquote]',
			'shortcode_name' => 'sp-blockquote',
			'shortcode_callback' => 'sp_blockquote_shortcode'
		),

		'check_login' => array(
			'title' => __( 'Check Login', 'sp-theme' ),
			'options' => 'no-option',
			'info' => __( 'Wrapping this around your content will insure only logged in users will see it.  If they are not logged in, no content is shown to them.', 'sp-theme' ),
			'shortcode' => '[sp-check-login]' . __( 'HIDE CONTENT HERE', 'sp-theme' ) . '[/sp-check-login]',
			'shortcode_name' => 'sp-check-login',
			'shortcode_callback' => 'sp_check_login_shortcode'
		),

		'code' => array(
			'title' => __( 'Code Display', 'sp-theme' ),
			'options' => 'no-option',
			'info' => __( 'Wrapping this around your code to display a code formatted display instead of rendering it.', 'sp-theme' ),
			'shortcode' => '[sp-code]' . __( 'YOUR CODE HERE', 'sp-theme' ) . '[/sp-code]',
			'shortcode_name' => 'sp-code',
			'shortcode_callback' => 'sp_shortcode_code'
		),

		'lightbox' => array(
			'title' => __( 'Lightbox', 'sp-theme' ),
			'options' => array(
				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the title you want for this lightbox.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'group' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the group name (no spaces) you want to set for this lightbox. This is used for grouping multiple lightboxes together so they can be displayed in a carousel with next/previous buttons.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'url' => array(
					'requirement' =>  'required',
					'info' => __( 'This sets the URL of the item you wish to display such as an image or a video from shared sites like Youtube and Vimeo.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'thumbnail' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the thumbnail image display before the lightbox is popped open. The smaller version of your image.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'poster_size' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the size of the video frame thumbnail you wish to grab from the video servers.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'select',
					'settings' => array(
						'large',
						'small'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)	
			),

			'shortcode' => '[sp-lightbox url=""]',
			'shortcode_name' => 'sp-lightbox',
			'shortcode_callback' => 'sp_lightbox_shortcode'
		),

		'button' => array(
			'title' => __( 'Button', 'sp-theme' ),
			'options' => array(

				'title' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the title of this button. This is displayed on the button itself.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'text_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the color of the text on the button.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'button_color' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the color of the button.  Enter a HEX value like 000000 for black.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'url' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the URL you want the button to link to when clicked.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'target' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets whether you want the link to open in the same window or open a new window.', 'sp-theme' ),
					'default' => 'same',
					'form_type' => 'select',
					'settings' => array(
						'same',
						'new-window'
					)
				),

				'style' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets style of the button.', 'sp-theme' ),
					'default' => 'rounded',
					'form_type' => 'select',
					'settings' => array(
						'rounded',
						'square'
					)
				),

				'position' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets display position of the button.', 'sp-theme' ),
					'default' => 'inline',
					'form_type' => 'select',
					'settings' => array(
						'inline',
						'block',
						'float-left',
						'float-right'
					)
				),

				'size' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the size of the button.', 'sp-theme' ),
					'default' => 'default',
					'form_type' => 'select',
					'settings' => array(
						'default',
						'mini',
						'small',
						'large'
					)
				),

				'icon' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this allows you to input an icon next to the button title.  You can use any available class names from the icon font list. You can find the icon font list by going to your theme documentation folder and opening the icon-font.html file in your browser.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)
			),

			'shortcode' => '[sp-button title=""]',
			'shortcode_name' => 'sp-button',
			'shortcode_callback' => 'sp_button_shortcode'
		),

		'portfolio' => array(
			'title' => __( 'Portfolio', 'sp-theme' ),
			'options' => array(
				'category' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the portfolio category you wish to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'columns' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets how many columns you want to display in a row.', 'sp-theme' ),
					'default' => '4',
					'form_type' => 'select',
					'settings' => array(
						'1',
						'2',
						'3',
						'4',
						'5',
						'6'
					)
				),

				'show_filters' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display filterable tags.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'sort_order' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the sort order of the portfolio items. Name will alpahbetically sort them and position will sort them by the position you set within the portfolio item.', 'sp-theme' ),
					'default' => 'name',
					'form_type' => 'select',
					'settings' => array(
						'name',
						'position'
					)
				),

				'sort_by' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this will sort your portfolio items by ascending order or by descending order. If sort_order is set to "name", then ASC would sort this from A to Z and vice-versa for DESC. If sort_order is set to "position", then ASC would sort this from lowest postion number to highest position number and vice-versa for DESC.', 'sp-theme' ),
					'default' => 'ASC',
					'form_type' => 'select',
					'settings' => array(
						'ASC',
						'DESC'
					)
				),

				'show_title' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the title of your portfolio item.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'show_excerpt' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the excerpt of your portfolio item.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'show_cat_description' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the category description at the top of the portfolio listing giving a brief description of what the following portfolios are about.  Be sure to have set the description in the portfolio category setting.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'gallery_only' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will invoke the lightbox when clicked thus making the portfolio list like a gallery only.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'link_gallery' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will link all the portfolio images in a lightbox so you can navigate between them with prev/next buttons.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),
				
				'show_animation' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will show an animation of the images when resizing the browser.  Note that this is always on if show filters is on.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'image_width' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the width of the portfolio image. Enter a pixel value.  Leave as default to use theme\'s settings.', 'sp-theme' ),
					'default' => sp_get_theme_init_setting( 'portfolio_list_size', 'width' ),
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'image_height' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the height of the portfolio image. Enter a pixel value. Leave as default to use theme\'s settings.', 'sp-theme' ),
					'default' => sp_get_theme_init_setting( 'portfolio_list_size', 'height' ),
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'image_crop' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will crop the image per the width and height set as a hard crop. Setting it to false will do a soft-crop on the image depending on the ratio and proportion.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'posts_per_page' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the number of portfolio items you wish to show on a page.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'mosaic' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will turn your portfolio lists into a mosaic of images superceding other layout options.  Mosaic layout is each image next to each other side by side filling the entire container.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-portfolio category=""]',
			'shortcode_name' => 'sp-portfolio',
			'shortcode_callback' => 'sp_portfolio_shortcode'
		),

		'testimonial' => array(
			'title' => __( 'Testimonial', 'sp-theme' ),
			'options' => array(
				'category' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the testimonial category you wish to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'sort_by' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this will sort your testimonials by ascending order or by descending order. ASC would sort this from A to Z and vice-versa for DESC.', 'sp-theme' ),
					'default' => 'ASC',
					'form_type' => 'select',
					'settings' => array(
						'ASC',
						'DESC'
					)
				),

				'posts_per_page' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the number of portfolio items you wish to show on a page.  Please note that this setting is only useful when you are only displaying testimonial on a page and nothing else with pagination or else it may interfere.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'show_avatar' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display an avatar for the person who left the testimonial.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'show_quote_marks' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display quote marks to the left of the quote.  Note that if "show avatar" is turned on, this setting would have no affect.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'autorotate' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display your testimonials in an autorotate fashion instead of in a list.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'autorotate_interval' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the number in miliseconds you want in between rotation.  For example if you entered "6000", it would mean each testimonial will show for 6 seconds before rotating to the next one.', 'sp-theme' ),
					'default' => '6000',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'randomize' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display a randomize list of testimonials on page load.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'show_title' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the section title.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the section title you want to display. For example "We would love it if you left us a testimonial".', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'submit_testimonial' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will change the behavior of this shortcode to allow people to submit new testimonials.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)	
			),

			'shortcode' => '[sp-testimonial category=""]',
			'shortcode_name' => 'sp-testimonial',
			'shortcode_callback' => 'sp_testimonial_shortcode'
		),

		'register' => array(
			'title' => __( 'Register Form', 'sp-theme' ),
			'options' => array(
				'firstname' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the firstname field for user input.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'lastname' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the lastname field for user input.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'captcha' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display a captha field to prevent spam bots from submitting the form.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'from_email' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the email address that you would like displayed when the email is sent out.  Defaults to admin\'s email address.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-register]',
			'shortcode_name' => 'sp-register',
			'shortcode_callback' => 'sp_register_shortcode'
		),

		'login' => array(
			'title' => __( 'Login Form', 'sp-theme' ),
			'options' => array(
				'redirect_to' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the URL of the page you would like the site to redirect to after login.  Default stays on the same page.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'forgot_password' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will show the forgot password option.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the title of the login form.  Default is Login', 'sp-theme' ),
					'default' => apply_filters( 'sp_sc_login_form_title', __( 'Login', 'sp-theme' ) ),
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-login]',
			'shortcode_name' => 'sp-login',
			'shortcode_callback' => 'sp_login_shortcode'
		),

		'change_password' => array(
			'title' => __( 'Change Password Form', 'sp-theme' ),
			'options' => array(
				'strong_password' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will make sure the new password is strong.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-change-password]',
			'shortcode_name' => 'sp-change-password',
			'shortcode_callback' => 'sp_change_password_shortcode'
		),

		'contactform' => array(
			'title' => __( 'Contact Form', 'sp-theme' ),
			'options' => array(
				'id' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the contact form you want to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)					
			),

			'shortcode' => '[sp-contact id=""]',
			'shortcode_name' => 'sp-contact',
			'shortcode_callback' => 'sp_contact_shortcode'
		),

		'faq' => array(
			'title' => __( 'FAQ', 'sp-theme' ),
			'options' => array(
				'category' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the ID of the FAQ category you want to display.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'title' => array( 
					'requirement' => 'optional',
					'info' => __( 'Enter the title you want to display for the faq section.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'icon' => array(
					'requirement' =>  'optional',
					'info' => __( 'Setting this allows you to input an icon next to the title.  You can use any available class names from the icon font list. You can find the icon font list by going to your theme documentation folder and opening the icon-font.html file in your browser.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'collapsible' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will make all elements collapsible.  False will have at least one element opened at all times.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)
			),

			'shortcode' => '[sp-faq category=""]',
			'shortcode_name' => 'sp-faq',
			'shortcode_callback' => 'sp_faq_shortcode'
		),

		'homeurl' => array(
			'title' => __( 'Home URL', 'sp-theme' ),
			'options' => 'no-option',
			'info' => __( 'This shortcode will output the home URL dynamically. It is useful when you don\'t want to hardcode an absolute URL into the editor.', 'sp-theme' ),
			'shortcode' => '[sp-homeurl]',
			'shortcode_name' => 'sp-homeurl',
			'shortcode_callback' => 'sp_home_url'
		),

		'themeurl' => array(
			'title' => __( 'Theme URL', 'sp-theme' ),
			'options' => 'no-option',
			'info' => __( 'This shortcode will output the theme URL dynamically. It is useful when you don\'t want to hardcode an absolute URL into the editor.', 'sp-theme' ),
			'shortcode' => '[sp-themeurl]',
			'shortcode_name' => 'sp-themeurl',
			'shortcode_callback' => 'sp_theme_url'
		),

		'themepath' => array(
			'title' => __( 'Theme Path', 'sp-theme' ),
			'options' => 'no-option',
			'info' => __( 'This shortcode will output the theme path dynamically. It is useful when you don\'t want to hardcode an absolute path into the editor.', 'sp-theme' ),
			'shortcode' => '[sp-themepath]',
			'shortcode_name' => 'sp-themepath',
			'shortcode_callback' => 'sp_theme_path'
		),

		'imagelinkbox' => array(
			'title' => __( 'Image Link Box', 'sp-theme' ),
			'options' => array(
				'url' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the URL where you want to link to.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'img' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the URL of the image you want to use.  Please note to only use the image size you required for display to prevent slow page loads.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'link_text' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the text you would like to display beneath the image.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)				
			),

			'shortcode' => '[sp-imagelinkbox url="" image=""]',
			'shortcode_name' => 'sp-imagelinkbox',
			'shortcode_callback' => 'sp_imagelinkbox_shortcode'
		),

		'product_slider' => array(
			'title' => __( 'Product Slider', 'sp-theme' ),
			'options' => array(

				'categories' => array(
					'requirement' => 'required',
					'info' => __( 'Enter a list of category IDs of products you want to display separating each ID with a comma.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'width' => array(
					'requirement' => 'optional',
					'info' => __( 'Set the width of each product item you would like to display.  Adjusting this will allow certain number of product items to fit in the slide.  For example you want to display 5 items visible but the 5th one is cut off.  Setting the width can adjust it to make each product item smaller to fit.  Leave blank to use default catalog image width.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_pick' => array(
					'requirement' => 'optional',
					'info' => __( 'You can custom pick the products you want displayed by entering each product ID separated by a comma.  Note that this setting will supercede categories.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter a title you would like to display for this list of products. Example would be "Latest Arrivals".', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'count' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter how many products you would like to show in total.', 'sp-theme' ),
					'default' => '6',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'randomize' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will randomize the order your products when displayed.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'order' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the order of your products either from ascending or descending according to the product name.', 'sp-theme' ),
					'default' => 'DESC',
					'form_type' => 'select',
					'settings' => array(
						'ASC',
						'DESC'
					)
				),

				'items_visible' => array(
					'requirement' => 'optional',
					'info' => __( 'Set how many products you would like to show at one time in the carousel slider.', 'sp-theme' ),
					'default' => '3',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'min_items' => array(
					'requirement' => 'optional',
					'info' => __( 'Set how many products you would like to show at minimum in the carousel slider.  You can set this number the same as the visible items to allow slider to scale in size.', 'sp-theme' ),
					'default' => '2',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'auto_scroll' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will make the carousel slider auto rotate the products.', 'sp-theme' ),
					'default' => 'false',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'auto_scroll_interval' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets how many seconds you want to display the products before scrolling.  Use miliseconds.  For example if you want 6 seconds, enter 6000.', 'sp-theme' ),
					'default' => '6000',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'transition_speed' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the speed inbetween transitions during a slide.  Use miliseconds.  For example if you want to set 200 miliseconds, enter 200.', 'sp-theme' ),
					'default' => '200',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'circular' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will allow the carousel to loop through infinitely.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'show_nav' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will display the next/prev navigation buttons.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'items_per_click' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets how many product you want to scroll by on each click of the navigation buttons.', 'sp-theme' ),
					'default' => '1',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'easing' => array(
					'requirement' => 'optional',
					'info' => __( 'This sets the easing effect when the products slides.', 'sp-theme' ),
					'default' => 'linear',
					'form_type' => 'select',
					'settings' => array(
						'linear',
						'easeInQuad',
						'easeOutQuad',
						'easeInOutQuad',
						'easeInCubic',
						'easeOutCubic',
						'easeInOutCubic',
						'easeInQuart',
						'easeOutQuart',
						'easeInOutQuart',
						'easeInSine',
						'easeOutSine',
						'eaesInOutSine',
						'easeInExpo',
						'easeOutExpo',
						'easeInOutExpo',
						'easeInQuint',
						'easeOutQuint',
						'easeInOutQuint',
						'easeInCirc',
						'easeOutCirc',
						'easeInOutCirc',
						'easeInElastic',
						'easeOutElastic',
						'easeInOutElastic',
						'easeInBack',
						'easeOutBack',
						'easeInOutBack',
						'easeInBounce',
						'easeOutBounce',
						'easeInOutBounce'
					)
				),

				'pause_on_hover' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will pause the carousel slider when your mouse is hovered over the carousel slider.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)				
			),

			'shortcode' => '[sp-product-slider categories=""]',
			'shortcode_name' => 'sp-product-slider',
			'shortcode_callback' => 'sp_product_slider_shortcode'
		),

		'image_link' => array(
			'title' => __( 'Image Link', 'sp-theme' ),
			'options' => array(
				'image_url' => array(
					'requirement' => 'required',
					'info' => __( 'Set the URL of the image you would like to show.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),	

				'link_url' => array(
					'requirement' => 'required',
					'info' => __( 'Set the URL of the link.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),								

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Set the title of the link.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),	

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)								
			),

			'shortcode' => '[sp-image-link]',
			'shortcode_name' => 'sp-image-link',
			'shortcode_callback' => 'sp_image_link_shortcode'
		),

		'tooltip' => array(
			'title' => __( 'Tooltip Link', 'sp-theme' ),
			'options' => array(
				'tooltip_title' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the text you would like to show in the tooltip popup.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),	

				'link_name' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the text you would like to show for the link.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'url' => array(
					'requirement' => 'optional',
					'info' => __( 'Set the URL of the link.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'position' => array(
					'requirement' => 'optional',
					'info' => __( 'Set the position of the tooltip popup to show.', 'sp-theme' ),
					'default' => 'top',
					'form_type' => 'select',
					'settings' => array(
						'top',
						'left',
						'right',
						'bottom'
					)
				)											
			),

			'shortcode' => '[sp-tooltip]',
			'shortcode_name' => 'sp-tooltip',
			'shortcode_callback' => 'sp_tooltip_shortcode'
		),

		'linebreaks' => array(
			'title' => __( 'Line Breaks', 'sp-theme' ),
			'options' => array(
				'linebreaks' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the number of line breaks you want to insert.', 'sp-theme' ),
					'default' => '2',
					'form_type' => 'text',
					'settings' => array(

					)
				)
			),	

			'shortcode' => '[sp-linebreaks]',
			'shortcode_name' => 'sp-linebreaks',
			'shortcode_callback' => 'sp_linebreaks_shortcode'
		),

		'bio_card' => array(
			'title' => __( 'Bio Card', 'sp-theme' ),
			'options' => array(
				'photo' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the URL of the photo image for this person.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'name' => array(
					'requirement' => 'required',
					'info' => __( 'Enter the name of this person.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the title position of this person.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'email' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the email address of this person.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'twitter_name' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the Twitter screen name of this person if you wish to display a follow button.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_class' => array(
					'requirement' => 'optional',
					'info' => __( 'You can add your own custom class to style this module differently if you wish.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)	
			),

			'shortcode' => '[sp-bio-card photo="" name=""]',
			'shortcode_name' => 'sp-bio-card',
			'shortcode_callback' => 'sp_bio_card_shortcode'				
		)		
/*
		'show_header' => array(
			'title' => __( 'Show Header', 'sp-theme' ),
			'options' => array(
				'show_bg_color' => array(
					'requirement' => 'optional',
					'info' => __( 'Setting this to true will show a background color behind the header.', 'sp-theme' ),
					'default' => 'true',
					'form_type' => 'select',
					'settings' => array(
						'true',
						'false'
					)
				),

				'bg_color' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the background color in hex value you would like your header background to be.  Leaving it blank will use the theme\'s default colors.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'text_color' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the text color in hex value you would like your header text to be.  Leaving it blank will use the theme\'s default colors.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),

				'custom_title' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the text you would like to show as your header title.  Leaving it blank will use the page\'s title.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				),	

				'tagline_text' => array(
					'requirement' => 'optional',
					'info' => __( 'Enter the text you would like your tagline to be.  Leaving it blank will not display any tagline.', 'sp-theme' ),
					'default' => '',
					'form_type' => 'text',
					'settings' => array(

					)
				)									
			),

			'shortcode' => '[sp-show-header]',
			'shortcode_name' => 'sp-show-header'
		)	
*/			
	);

	return apply_filters( 'sp_shortcode_module_object', $module );
}

/**
 * Function that displays the html input form for shortcodes
 *
 * @access public
 * @since 3.0
 * @param string $module | the module name
 * @param array $module_settings | the saved settings of the module
 * @return html $form
 */
function sp_shortcodes_input_form( $module = '', $module_settings = '' ) {
	$shortcodes = sp_shortcodes_module();

	// bail if module and module settings are not passed
	if ( ! isset( $module ) || empty( $module ) )
		return;

	$form = '';

	$hidden_shortcode_name = 'pb[row][][column][][module][][' . $module . '][shortcode_name]';

	$hidden_callback_name = 'pb[row][][column][][module][][' . $module . '][shortcode_callback]';

	$form .= '<input type="hidden" name="' . $hidden_shortcode_name . '" class="module-value" value="' . esc_attr( $shortcodes[$module]['shortcode_name'] ) . '" />' . PHP_EOL;

	$form .= '<input type="hidden" name="' . $hidden_callback_name . '" class="module-value" value="' . esc_attr( $shortcodes[$module]['shortcode_callback'] ) . '" />' . PHP_EOL;

	if ( $shortcodes[$module]['options'] === 'no-option' ) {

	} else {

		foreach( $shortcodes[$module]['options'] as $k => $v ) {
			if ( $v['requirement'] === 'required' )
				$color = 'required-color';
			else
				$color = '';
			
			$form .= '<div class="form-group ' . esc_attr( $v['requirement'] ) . '">' . PHP_EOL;
			$form .= '<label><strong>' . ucwords( str_replace( '_', ' ', $k ) ) . ' - <span class="' . $color . '">' . sprintf( __( '%s', 'sp-theme' ), $v['requirement'] ) . '</span></strong><span class="howto">' . $v['info'] . '</span></label>' . PHP_EOL;

			$name = 'pb[row][][column][][module][][' . $module . '][' . $k . ']';

			// check form type
			switch( $v['form_type'] ) {
				case 'text' :
					$form .= '<input type="text" data-set-name="' . esc_attr( $k ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( isset( $module_settings[$module][$k] ) ? stripslashes( $module_settings[$module][$k] ) : ''  ) . '" class="form-control module-value widefat" />';
					break;
				case 'select' :
					// loop through available settings
					if ( ! empty( $v['settings'] ) ) {
						$form .= '<select data-set-name="' . esc_attr( $k ) . '" name="' . esc_attr( $name ) . '" class="form-control module-value select2-select">' . PHP_EOL;
						foreach( $v['settings'] as $setting ) {							
							$form .= '<option value="' . esc_attr( $setting ) . '" ' . selected( isset( $module_settings[$module][$k] ) ? $module_settings[$module][$k] : $v['default'], $setting, false ) . '>' . sprintf( __( '%s', 'sp-theme' ), $setting ) . '</option>' . PHP_EOL;
						}

						$form .= '</select>' . PHP_EOL;
					}
					break;
				case 'textarea' :
					$form .= '<textarea data-set-name="' . esc_attr( $k ) . '" name="' . esc_attr( $name ) . '" class="form-control module-value widefat" rows="20">' . esc_attr( isset( $module_settings[$module][$k] ) ? $module_settings[$module][$k] : ''  ) . '</textarea>';

					break;
				case 'radio' :
					// loop through available settings
					if ( ! empty( $v['settings'] ) ) {
						foreach( $v['settings'] as $setting ) {
							$form .= '<label class="radio">' . sprintf( __( '%s', 'sp-theme' ), ucwords( $setting ) ) . ' <input type="radio" data-set-name="' . esc_attr( $k ) . '" name="' . esc_attr( $name ) . '" class="module-value" value="' . esc_attr( $setting ) . '" ' . checked( isset( $module_settings[$module][$k] ) ? $module_settings[$module][$k] : $v['default'], $setting, false ) . '/></label>' . PHP_EOL;
						}
					}
					break;
			}

			$form .= '</div>' . PHP_EOL;
		}
	}

	return $form;
}