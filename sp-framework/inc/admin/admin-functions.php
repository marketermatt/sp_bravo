<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * admin functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function that displays the admin notification for theme update
 * see setup.php for add action on this function
 *
 * @access public
 * @since 3.0
 * @return html $notification
 */
function sp_theme_notification() {

	$file = wp_remote_get( 'http://splashingpixels.com/wp-content/themes/sp/versions/versions.xml' );
	$versions = wp_remote_retrieve_body( $file );
	
	if ( isset( $versions ) && $versions != '' ) {
		// converts the versions xml to an array
		$versions = sp_xml2array( $versions );
	
		// get the theme info of the parent
		$theme_name = substr( get_template_directory(), untrailingslashit( strrpos( get_template_directory(), '/' ) + 1 ) );

		$theme = wp_get_theme( $theme_name ); // function since WP 3.4


		if ( is_array( $versions['versions'] ) ) {
			foreach( $versions['versions']['item'] as $item ) {
				$cur = trim( $item['value'] );

				if ( $item['_attr']['name'] == strtolower( trim( $theme->Name ) ) ) {
					// proceed only if theme version is less than current XML version
					if ( $theme->Version < $cur ) {
						// build the notification HTML to display above SP theme control panel
						$notification = '<div class="updated sp-update-notice"><p>' . sprintf( __( 'There is a new version of your theme available (' . '%s' . '). Please update when possible.', 'sp-theme' ), $cur ) . ' <a href="' . esc_url( 'http://splashingpixels.com/wp-content/themes/sp/versions/' . strtolower( trim( basename( get_template() ) ) ) . '_changelog.txt' ) . '" title="' . esc_attr( 'Theme Changelog', 'sp-theme' ) . '" target="_blank">(ChangeLog)</a> (' . __( 'To disable this message, you can turn off notification in your theme options.', 'sp-theme' ) . ')</p></div>';

						echo $notification;
						return;
					}
				}
			}
		}
	}

	// return nothing;
	return;
}

/**
* Function that displays the admin notification for framework update
 * see setup.php for add action on this function
 *
 * @access public
 * @since 3.0
 * @return html $notification
 */
function sp_framework_notification( $version ) {
	$file = wp_remote_get( sp_ssl_protocol() . '://splashingpixels.s3.amazonaws.com/versions.xml', array( 'sslverify' => false ) );
	$versions = wp_remote_retrieve_body( $file );
	
	if ( isset( $versions ) && $versions != '' ) {
		// converts the versions xml to an array
		$versions = sp_xml2array( $versions );	
	
		// get the theme info of the parent
		$theme_name = substr( get_template_directory(), untrailingslashit( strrpos( get_template_directory(), '/' ) + 1 ) );

		if ( is_array( $versions['versions'] ) ) {
			foreach( $versions['versions']['item'] as $item ) {
				$cur = trim( $item['value'] );

				if ( $item['_attr']['name'] == 'framework' ) {
					// proceed only if framework version is less than current XML version
					if ( FRAMEWORK_VERSION < $cur ) {
						// build the notification HTML to display above SP theme control panel
						$notification = '<div class="updated sp-update-notice"><p>' . sprintf( __( 'There is a new version of SP Framework available (' . '%s' . '). Please update when possible.', 'sp-theme' ), $cur ) . ' <a href="' . esc_url( 'http://splashingpixels.com/wp-content/themes/sp/versions/framework_changelog.txt' ) . '" title="' . esc_attr( 'Framework Changelog', 'sp-theme' ) . '" target="_blank">' . __( '(ChangeLog)', 'sp-theme' ) . '</a> (' . __( 'To disable this message, you can turn off notification in your theme options.', 'sp-theme' ) . ')</p></div>';

						echo $notification;
						return;
					}
				}
			}
		}
	}

	// return nothing
	return;
}

/**
 * Function that displays the admin notification for any theme notice
 * see setup.php for add action on this function
 *
 * @access public
 * @since 3.0
 * @return html $notification
 */
function sp_theme_notice() {
	global $current_user;

	$user_id = $current_user->ID;

	$file = wp_remote_get( 'http://splashingpixels.com/wp-content/themes/sp/versions/versions.xml' );
	$notices = wp_remote_retrieve_body( $file );

	if ( isset( $notices ) && $notices != '' ) {
		// converts the notices xml to an array
		$notices = sp_xml2array( $notices );

		$date = $notices['notice']['_attr']['date'];
		$message = $notices['notice']['_attr']['message'];

		// check if user has already removed nag
		if ( ! get_user_meta( $user_id, '_sp_remove_theme_notice_' . $date ) ) {
			echo '<div class="error"><p>';
			printf( __( '%s', 'sp-theme' ) . ' ' . '<a href="' . admin_url( 'admin.php?page=sp' ) . '&amp;remove_theme_notice=0&remove_notice_date=' . $date . '" title="' . __( 'Hide Notice', 'sp-theme' ) . '"> ' . __( 'Hide Notice', 'sp-theme' ) . '</a>', $message );
			echo "</p></div>";
		}
	}
}

/**
 * Function that removes the theme notice for the user
 * see setup.php for add action on this function
 *
 * @access public
 * @since 3.0
 * @return html $notification
 */
function sp_remove_theme_notice() {
	global $current_user;

	$user_id = $current_user->ID;

	// remove the notice.
	if ( isset( $_GET['remove_theme_notice'] ) && '0' == $_GET['remove_theme_notice'] && isset( $_GET['remove_notice_date'] ) ) {
		$date = sanitize_text_field( $_GET['remove_notice_date'] );

		add_user_meta( $user_id, '_sp_remove_theme_notice_' . $date, 'true', true );
	}
}

/**
 * Function that sets a specific theme option
 *
 * @access public
 * @since 3.0
 * @param string $option the theme option id
 * @param mixed $value the value to set the option to
 * @return boolean true
 */
function sp_set_theme_option( $option, $value ) {
	global $spdata;

	// if nothing passed in bail
	if ( ! isset( $option ) )
		return;

	// if nothing passed in bail
	if ( ! isset( $value ) )
		return;

	// set the array key | value
	$spdata[$option] = $value;

	// save the option
	_sp_save_data( $spdata );

	return true;
}

/**
 * function to set the slide's sort order
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id the attachment id of the post
 * @param int $post_id the parent post id
 * @return boolean true
 */
function sp_set_slide_sort_order( $attachment_id, $post_id ) {
	// bail if attachment id is not set
	if ( ! isset( $attachment_id ) )
		return;

	// bail if post id is not set
	if ( ! isset( $post_id ) )
		return;

	// arbitrary number to put item to the end initially
	$sort_order = 1000;

	// set the attachment post's sort order
	update_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_sort_order', $sort_order );

	return true;
}

/**
 * Function that inserts a media link object
 *
 * @access public
 * @since 3.0
 * @param int $post_id the parent post id
 * @param string $title | the title of the media link
 * @param string $link | the submitted link 
 * @return int $attachment_id | the newly created attachment id
 */
function sp_insert_slide_media_link_object( $post_id, $title, $link ) {

	// bail if post id is not set
	if ( ! isset( $post_id ) )
		return;

	// bail if title is not set
	if ( ! isset( $title ) )
		return;

	// bail if link is not set
	if ( ! isset( $link ) )
		return;

	// build the arguments
	$args = array(
		'post_title'	=> $title,
		'post_parent'	=> $post_id,
		'post_status'	=> 'inherit',
		'post_type'		=> 'attachment',
		'post_content'	=> $link
	);
	
	$attachment_id = wp_insert_post( $args );

	// update the mime type
	wp_update_post( array( 'ID' => $attachment_id, 'post_mime_type' => 'video/mp4' ) );

	// set the attachment post's post parent
	add_post_meta( $attachment_id, '_sp_slide_post_parent', $post_id );	

	return $attachment_id;
}

/**
 * Function that inserts a media content object
 *
 * @access public
 * @since 3.0
 * @param int $post_id | the parent post id
 * @param string $title | the title of the content 
 * @return int $attachment_id the newly created attachment id
 */
function sp_insert_slide_media_content_object( $post_id, $title ) {

	// bail if post id is not set
	if ( ! isset( $post_id ) )
		return;

	// bail if title is not set
	if ( ! isset( $title ) )
		return;

	// build the arguments
	$args = array(
		'post_title'	=> $title,
		'post_parent'	=> $post_id,
		'post_status'	=> 'inherit',
		'post_type'		=> 'attachment'
	);
	
	$attachment_id = wp_insert_post( $args );

	// update the mime type
	wp_update_post( array( 'ID' => $attachment_id, 'post_mime_type' => 'content/text' ) );

	// set the attachment post's post parent
	add_post_meta( $attachment_id, '_sp_slide_post_parent', $post_id );	

	return $attachment_id;
}

/**
 * function to get a list of all pages
 *
 * @access public
 * @since 3.0
 * @return array $pages
 */
function sp_list_pages( $names_only = false ) {
	$args = array(
		'sort_order'	=> 'ASC',
		'sort_column'	=> 'post_title',
		'hierarchical'	=> 0,
		'exclude'		=> array( sp_get_page_id_from_slug( 'maintenance' ) ),
		'post_type'		=> 'page',
		'post_status'	=> 'publish'
	); 

	$pages = get_pages( apply_filters( 'sp_list_pages_args', $args ) ); // array of objects

	// display names only
	if ( $names_only ) {
		// rebuild the array
		$pages_array = array();

		foreach( $pages as $page ) {
			$pages_array[$page->post_name] = $page->post_title;
		}
		return $pages_array;
	}

	return $pages;
}

/**
 * function to get a list of all blog categories
 *
 * @access public
 * @since 3.0
 * @return array $categories
 */
function sp_list_blog_categories( $names_only = false ) {
	$args = array(
		'hide_empty'   => true
	); 

	$categories = get_terms( 'category', apply_filters( 'sp_list_blog_categories_args', $args ) ); // array of objects

	// display names only
	if ( $names_only ) {
		// rebuild the array
		$categories_array = array();

		foreach( $categories as $category ) {
			$categories_array[$category->slug] = $category->name;
		}
		return $categories_array;
	}

	return $categories;
}

/**
 * function to get a list of all Woo product categories
 *
 * @access public
 * @since 3.0
 * @return array $categories
 */
function sp_list_woo_product_categories( $names_only = false ) {
	$args = array(
		'hide_empty'   => true
	); 

	$categories = get_terms( 'product_cat', apply_filters( 'sp_list_woo_product_categories_args', $args ) ); // array of objects

	// display names only
	if ( $names_only ) {
		// rebuild the array
		$categories_array = array();

		foreach( $categories as $category ) {
			$categories_array[$category->slug] = $category->name;
		}
		return $categories_array;
	}

	return $categories;
}

/**
 * function to get the saved configurations
 *
 * @access public
 * @since 3.0
 * @return array $configs
 */
function sp_get_saved_configurations() {
	global $wpdb;

	$option_name = THEME_NAME . '_saved_config_%';

	$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->options} WHERE `option_name` LIKE %s", $option_name );

	$configs = $wpdb->get_results( $sql );

	$configs_array = array();

	// build the array
	foreach( $configs as $config ) {
		// trim the name
		$config_name = substr( $config->option_name, strrpos( $config->option_name, '_' ) + 1 );

		$configs_array[$config_name] = $config->option_value;
	}

	return $configs_array;
}

/**
 * Function that deletes post meta from slide
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | the id of the attachment
 * @param int $post_id | the id of the parent post
 * @return boolean true
 */
function sp_delete_slide_meta( $attachment_id, $post_id ) {
	global $wpdb;

	// bail if no attachment id is passed
	if ( ! isset( $attachment_id ) )
		return;

	// bail if no post id is passed
	if ( ! isset( $post_id ) )
		return;

	$sql = $wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE `post_id` = %d AND `meta_key` LIKE %s", $attachment_id, '_sp_post_parent_' . $post_id . '_slide_%' ); 
	$wpdb->query( $sql );

	return true;	
}

add_action( 'admin_init', '_sp_shortcodes_tinymce' );

/**
 * Function that adds filters to tinymce editor
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_shortcodes_tinymce() {
	if ( ! current_user_can( 'edit_posts' ) || ! current_user_can( 'edit_pages' ) )
		return;

	if ( get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', '_sp_add_tinymce_plugin' ); // see scripts-styles.php
		add_filter( 'mce_buttons', '_sp_register_button' );
	}

	return true;
}

/**
 * Function that appends our shortcode button to the existing ones
 *
 * @access private
 * @since 3.0
 * @param array $buttons | existing tinymce buttons
 * @return array $buttons | appended array
 */
function _sp_register_button( $buttons ) {
	array_push( $buttons, 'sp_shortcodes' );
	
	return $buttons;
}

add_action( 'save_post', '_sp_clear_cache_actions' );
add_action( 'trashed_post', '_sp_clear_cache_actions' );
add_action( 'deleted_post', '_sp_clear_cache_actions' );

/**
 * Function that handles save posts
 *
 * @access private
 * @since 3.0
 * @param int $id | post id or taxonomy id
 * @return boolean true
 */
function _sp_clear_cache_actions( $id ) {
	if ( get_post_type( $id ) === 'sp-slider' ) {
		// clear cache
		_sp_clear_slider_cache( $id );
	}

	if ( get_post_type( $id ) === 'sp-testimonial' ) {
		// clear cache
		_sp_clear_testimonial_pending_notice_cache();
	}

	if ( get_post_type( $id ) === 'page' ) {
		// clear cache
		_sp_clear_page_builder_cache( $id );
	}

	return true;	
}

add_action( 'admin_menu', '_sp_add_menu_notices' );

/**
 * Function that adds notices to menu labels
 *
 * @access private
 * @since 3.0
 * @return html
 */
function _sp_add_menu_notices() {
	global $menu;

	foreach ( $menu as $k => $v ) {
		switch( $menu[$k][2] ) {
			case 'edit.php?post_type=sp-testimonial' :
				// if cache not found build query
				if ( false === $testimonials = get_transient( 'sp-testimonial-pending-notice' ) ) {
					// build the testimonial entry argument
					$args = array (
						'post_type'			=> 'sp-testimonial',
						'post_status'		=> 'pending',
						'posts_per_page'	=> -1
					);	

					$testimonials = new WP_Query( $args );	

					$testimonials = $testimonials->found_posts;

					// cache it
					set_transient( 'sp-testimonial-pending-notice', $testimonials, 60*60*24 ); // 24 hours
				}

				// only add if there are more than 0 notice
				if ( $testimonials > 0 )
					$menu[$k][0] .= ' <span class="awaiting-mod count-' . esc_attr( $testimonials ) . '"><span class="pending-count">' . $testimonials . '</span></span>';
				break;
		}			
	}
}

/**
 * Function that gets the page builder modules
 *
 * @access private
 * @since 3.0
 * @param string $post_id | the post id that holds the module
 * @param string $module | name of the module to get
 * @return array $modules | array of modules
 */
function _sp_get_page_builder_module( $post_id = '', $module = '', $module_settings = '' ) {
	$shortcodes = sp_shortcodes_module();

	if ( isset( $shortcodes[$module]['title'] ) )
		$shortcode_name = $shortcodes[$module]['title'];
	else
		$shortcode_name = '';

	switch( $module ) {
		case 'shortcode' :
			// get saved values
			$shortcode = isset( $module_settings[$module]['shortcode'] ) && ! empty( $module_settings[$module]['shortcode'] ) ? $module_settings[$module]['shortcode'] : '';

			$output = '<div class="module-element" data-id="shortcode">' . PHP_EOL;
			$output .= '<span class="module-element-name">' . __( 'Shortcode', 'sp-theme' ) . '</span>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Edit', 'sp-theme' ) . '" class="module-element-edit"><i class="icon-edit" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Delete', 'sp-theme' ) . '" class="module-element-delete"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
			
			// values
			$output .= '<div class="module-values">' . PHP_EOL;
			$output .= '<h3>' . $shortcode_name . '</h3>' . PHP_EOL;
			$output .= '<p class="howto">' . __( 'You may enter any valid shortcode in the box.', 'sp-theme' ) . '</p>' . PHP_EOL;

			// shortcode
			$output .= '<p><label><strong>' . __( 'Shortcode', 'sp-theme' ) . '</strong></label>' . PHP_EOL;
			$output .= '<input type="text" name="pb[row][][column][][module][][shortcode][shortcode]" value="' . esc_attr( stripslashes( $shortcode ) ) . '" class="content-area module-value widefat" /></p>' . PHP_EOL;

			$output .= '</div><!--close .module-values-->' . PHP_EOL;
			$output .= '</div><!--close .module-element-->' . PHP_EOL;
			break;	

		case 'custom_content' :
			// get saved values
			$content = isset( $module_settings[$module]['content'] ) && ! empty( $module_settings[$module]['content'] ) ? $module_settings[$module]['content'] : '';

			$output = '<div class="module-element" data-id="custom_content">' . PHP_EOL;
			$output .= '<span class="module-element-name">' . __( 'Custom Content', 'sp-theme' ) . '</span>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Edit', 'sp-theme' ) . '" class="module-element-edit"><i class="icon-edit" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Delete', 'sp-theme' ) . '" class="module-element-delete"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
			
			// values
			$output .= '<div class="module-values">' . PHP_EOL;
			$output .= '<h3>' . $shortcode_name . '</h3>' . PHP_EOL;
			$output .= '<textarea name="pb[row][][column][][module][][custom_content][content]" class="pb-textarea module-value widefat">' . stripslashes( $content ) . '</textarea>' . PHP_EOL;

			$output .= '</div><!--close .module-values-->' . PHP_EOL;
			$output .= '</div><!--close .module-element-->' . PHP_EOL;
			break;

		case 'placeholder' :
			$output = '<div class="module-element column-placeholder" data-id="' . esc_attr( $module ) . '">' . PHP_EOL;
			$output .= '<span class="module-element-name"></span>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Edit', 'sp-theme' ) . '" class="module-element-edit"><i class="icon-edit" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Delete', 'sp-theme' ) . '" class="module-element-delete"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
			
			// values
			$output .= '<div class="module-values">' . PHP_EOL;
			$output .= '<h3>' . $shortcode_name . '</h3>' . PHP_EOL;
			$output .= '<input type="hidden" name="pb[row][][column][][module][0][placeholder]" class="module-value column-placeholder" value="hold" />';

			$output .= '</div><!--close .module-values-->' . PHP_EOL;
			$output .= '</div><!--close .module-element-->' . PHP_EOL;
			break;	

		case 'widget_area' :
			$saved_settings = isset( $module_settings['widget_area'] ) ? $module_settings['widget_area'] : '';
			
			$output = '<div class="module-element" data-id="' . esc_attr( $module ) . '">' . PHP_EOL;
			$output .= '<span class="module-element-name">' . __( 'Widget Area', 'sp-theme' ) . '</span>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Delete', 'sp-theme' ) . '" class="module-element-delete"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
			
			// values
			$output .= '<div class="module-values">' . PHP_EOL;
			$output .= '<h3>' . __( 'Widget Area', 'sp-theme' ) . '</h3>' . PHP_EOL;
			$output .= '<input type="hidden" name="pb[row][][column][][module][][widget_area]" class="module-value" data-page-id="' . esc_attr( $post_id ) . '" data-page-name="' . esc_attr( get_the_title( $post_id ) ) . '" data-module="widget_area" value="' . esc_attr( $saved_settings ) . '" />';

			$output .= '</div><!--close .module-values-->' . PHP_EOL;
			$output .= '</div><!--close .module-element-->' . PHP_EOL;
			break;	

		default :
			$output = '<div class="module-element" data-id="' . esc_attr( $module ) . '">' . PHP_EOL;
			$output .= '<span class="module-element-name">' . $shortcodes[$module]['title'] . '</span>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Edit', 'sp-theme' ) . '" class="module-element-edit"><i class="icon-edit" aria-hidden="true"></i></a>' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Delete', 'sp-theme' ) . '" class="module-element-delete"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
			
			// values
			$output .= '<div class="module-values">' . PHP_EOL;
			$output .= '<h3>' . $shortcode_name . '</h3>' . PHP_EOL;
			$output .= sp_shortcodes_input_form( $module, $module_settings );

			$output .= '</div><!--close .module-values-->' . PHP_EOL;
			$output .= '</div><!--close .module-element-->' . PHP_EOL;
			break;				
	}

	return $output;
}

/**
 * Function that gets the page builder module list
 *
 * @access private
 * @since 3.0
 * @return array $modules | array of modules
 */
function _sp_get_page_builder_module_list() {
	return apply_filters( 'sp_pb_shortcode_module_list', array(
			'shortcode'                   => __( 'Shortcode', 'sp-theme' ),
			'custom_content'              => __( 'Custom Content', 'sp-theme' ),
			'social_media_fb'             => __( 'Facebook Like', 'sp-theme' ),
			'social_media_tweet'          => __( 'Twitter Tweet', 'sp-theme' ),
			'social_media_twitter_follow' => __( 'Twitter Follow', 'sp-theme' ),
			'social_media_gplusone'       => __( 'Google Plus One', 'sp-theme' ),
			'social_media_pinit'          => __( 'Pinterest Pin It', 'sp-theme' ),
			'carousel_slider'             => __( 'Carousel Slider', 'sp-theme' ),
			'layer_slider'                => __( 'Layer Slider', 'sp-theme' ),
			'callout'                     => __( 'Callout Box', 'sp-theme' ),
			'hr'                          => __( 'Horizontal Rule', 'sp-theme' ),
			'btt'                         => __( 'Back to Top', 'sp-theme' ),
			'map'                         => __( 'Google Map', 'sp-theme' ),
			'blockquote'                  => __( 'Blockquote', 'sp-theme' ),
			'lightbox'                    => __( 'Lightbox', 'sp-theme' ),
			'button'                      => __( 'Button', 'sp-theme' ),
			'portfolio'                   => __( 'Portfolio', 'sp-theme' ),
			'testimonial'                 => __( 'Testimonial', 'sp-theme' ),
			'register'                    => __( 'Register', 'sp-theme' ),
			'login'                       => __( 'Login', 'sp-theme' ),
			'contactform'                 => __( 'Contact Form', 'sp-theme' ),
			'faq'                         => __( 'FAQ', 'sp-theme' ),
			'imagelinkbox'                => __( 'Image Link Box', 'sp-theme' ),
			'product_slider'              => __( 'Product Slider', 'sp-theme' ),
			'image_link'                  => __( 'Simple Image Link', 'sp-theme' ),
			//'show_header'               => __( 'Show Header', 'sp-theme' ),
			'change_password'             => __( 'Change Password', 'sp-theme' ),
			'linebreaks'                  => __( 'Line Breaks', 'sp-theme' ),
			'tooltip'                     => __( 'Tooltip Link', 'sp-theme' ),
			'bio_card'                    => __( 'Bio Card', 'sp-theme' ),
			'widget_area'                 => __( 'Widget Area', 'sp-theme' )
		) );
}

add_action( 'edit_form_after_title', '_sp_add_page_builder_button' );

/**
 * Function that adds the page builder button to pages
 *
 * @access private
 * @since 3.0
 * @return html
 */
function _sp_add_page_builder_button() {
	// only add to page post type
	if ( get_post_type() === 'page' ) {
		global $post;

		$template_file = get_post_meta( $post->ID, '_wp_page_template', TRUE );

		// don't show button on maintenance page
		if ( $template_file !== 'maintenance-page.php' ) {
			// get the editor type
			$editor_type = get_post_meta( $post->ID, '_sp_page_editor_type', true );

			if ( $editor_type === 'advanced' ) {
				echo '<a href="#" title="' . esc_attr__( 'Switch to Default Editor', 'sp-theme' ) . '" class="page-builder-switcher button button-primary advanced">' . esc_attr__( 'Default Editor', 'sp-theme' ) . '</a><input type="hidden" name="sp_editor_type" value="' . esc_attr( $editor_type ) . '" />';			
			} else {
				echo '<a href="#" title="' . esc_attr__( 'Switch to Advanced Page Builder', 'sp-theme' ) . '" class="page-builder-switcher button button-primary default">' . esc_attr__( 'Advanced Page Builder', 'sp-theme' ) . '</a><input type="hidden" name="sp_editor_type" value="' . esc_attr( $editor_type ) . '" />';
			}
		}
	}

	return true;
}

/**
 * Function that builds the column selection array for page builder
 *
 * @access private
 * @since 3.0
 * @return array $columns
 */
function _sp_get_page_builder_column_selection_arr() {
	return array(
		array( 'column_class' => 'one', 'column_title' => __( 'One Column', 'sp-theme' ) ),
		array( 'column_class' => 'two', 'column_title' => __( 'Two Columns', 'sp-theme' ) ),
		array( 'column_class' => 'three', 'column_title' => __( 'Three Columns', 'sp-theme' ) ),
		array( 'column_class' => 'four', 'column_title' => __( 'Four Columns', 'sp-theme' ) ),
		array( 'column_class' => 'five', 'column_title' => __( 'Five Columns', 'sp-theme' ) ),
		array( 'column_class' => 'six', 'column_title' => __( 'Six Columns', 'sp-theme' ) ),
		array( 'column_class' => 'one-third', 'column_title' => __( 'One Third Column', 'sp-theme' ) ),
		array( 'column_class' => 'two-third', 'column_title' => __( 'Two Third Column', 'sp-theme' ) ),
		array( 'column_class' => 'two-sidebars', 'column_title' => __( 'Two Sidebars Column', 'sp-theme' ) ),
		array( 'column_class' => 'one-fourth', 'column_title' => __( 'One Fourth Column', 'sp-theme' ) ),
		array( 'column_class' => 'three-fourth', 'column_title' => __( 'Three Fourth Column', 'sp-theme' ) ),
	);
}

/**
 * Function that displays the slide media object
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id the attachment id of the post
 * @param int $post_id the parent post id
 * @param string $size the thumbnail size name 
 * @return html $output
 */
function sp_display_slide_media_object( $attachment_id, $post_id, $size = '' ) { 

	// get the attachment alt text
	$attachment_alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

	// check the type of the media
	$post_obj = get_post( $attachment_id );
	$type = $post_obj->post_mime_type;
	$type = substr( $type, 0, strpos( $type, '/' )  );

	// build the outer container
	$output = '';
	$output .= '<div class="slide-container ui-state-default" data-attachment-id="' . absint( $attachment_id ) . '" data-post-id="' . $post_id . '" title="' . esc_attr( $post_obj->post_title ) . '">' . PHP_EOL;
	
	switch( $type ) {
		case 'image' :
			$image = sp_get_image( $attachment_id, apply_filters( 'sp_slide_media_preview_width', 100 ), apply_filters( 'sp_slide_media_preview_height', 70 ), true );

			// build the image tag
			$output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';
			break;

		case 'audio' :
			// build the image tag
			$output .= '<img src="' . THEME_URL . 'images/admin/slide-audio-thumbnail.jpg" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';
			break;

		case 'video' :
			// get the post content - the external video link
			$external_link = $post_obj->post_content;

			// check if link is youtube or vimeo
			if ( preg_match( '/youtube|youtu.be/', $external_link ) ) {
				$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail-youtube.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
			
			} elseif ( preg_match( '/vimeo/', $external_link ) ) {
				$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail-vimeo.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
			
			} else {
				$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
			}
			break;

		case 'content' :
			// build the image tag
			$output .= '<img src="' . THEME_URL . 'images/admin/slide-text-thumbnail.jpg" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';
			break;			
	}

	$output .= '<a href="#" title="' . __( 'Remove Media', 'sp-theme' ) . '" class="remove-media"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
	$output .= '<span class="edit">' . __( 'edit', 'sp-theme' ) . '</span>' . PHP_EOL;
	$output .= '<img src="' . THEME_URL . 'images/admin/ajax-loader.gif" alt="' . esc_attr( 'Loading', 'sp-theme' ) . '" width="16" height="16" class="alert" />' . PHP_EOL;
	$output .= '</div><!--close .slide-container-->' . PHP_EOL;

	return $output;
}

/**
 * function to display the slide media
 *
 * @access public
 * @since 3.0
 * @param int $post_id the post id to get media from
 * @return html $output
 */
function sp_display_slide_media( $post_id ) { 
	global $post;

	// temporarily store $post
	$temp = $post;

	// bail if post id not passed
	if ( ! isset( $post_id ) )
		return;

	// build the query
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

	$attachments = new WP_Query( $args );

	$output = '';

	// iterate and build output
	while( $attachments->have_posts() ) : $attachments->the_post();
		$output .= '<div class="slide-container ui-state-default" data-attachment-id="' . absint( $post->ID ) . '" data-post-id="' . absint( $post_id ) . '" title="' . esc_attr( get_the_title() ) . '">' . PHP_EOL;
		
		// get the post mime type
		$type = $post->post_mime_type;

		// trim it down
		$type = substr( $type, 0, strpos( $type, '/' )  );

		// get the attachment array
		$attachment_image = sp_get_image( $post->ID, apply_filters( 'sp_slide_media_preview_width', 100 ), apply_filters( 'sp_slide_media_preview_height', 70 ), true );

		// get the attachment alt text
		$attachment_alt_text = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );

		switch( $type ) {
			case 'image' :
				// build the image tag
				$output .= '<img src="' . esc_url( $attachment_image['url'] ) . '" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . absint( $attachment_image['width'] ) . '" height="' . absint( $attachment_image['height'] ) . '" />';
				break;

			case 'audio' :
				// build the image tag
				$output .= '<img src="' . THEME_URL . 'images/admin/slide-audio-thumbnail.jpg" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';
				break;
				
			case 'video' :
				// get the post content - the external video link
				$external_link = $post->post_content;

				// check if link is youtube or vimeo
				if ( preg_match( '/youtube|youtu.be/', $external_link ) ) {
					$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail-youtube.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
				
				} elseif ( preg_match( '/vimeo/', $external_link ) ) {
					$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail-vimeo.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
				
				} else {
					$output .= '<img src="' . THEME_URL . 'images/admin/slide-video-thumbnail.png" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';	
				}
				break;

			case 'content' :
				// build the image tag
				$output .= '<img src="' . THEME_URL . 'images/admin/slide-text-thumbnail.jpg" alt="' . esc_attr( $attachment_alt_text ) . '" width="' . apply_filters( 'sp_slide_media_preview_width', '100' ) . '" height="' . apply_filters( 'sp_slide_media_preview_height', '70' ) . '" />';
				break;				
		}

		$output .= '<a href="#" title="' . __( 'Remove Media', 'sp-theme' ) . '" class="remove-media"><i class="icon-remove" aria-hidden="true"></i></a>' . PHP_EOL;
		$output .= '<span class="edit">' . __( 'edit', 'sp-theme' ) . '</span>' . PHP_EOL;
		$output .= '<img src="' . THEME_URL . 'images/admin/ajax-loader.gif" alt="' . esc_attr( 'Loading', 'sp-theme' ) . '" width="16" height="16" class="alert" />' . PHP_EOL;
		$output .= '</div><!--close .slide-container-->' . PHP_EOL;
	endwhile;
	wp_reset_postdata();

	// return edit post to the post global
	$post = $temp;

	return $output;
}

/**
 * function to display the slide's settings
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id the attachment id of the post 
 * @param int $post_id the post id to get the meta from
 * @return array $settings
 */
function sp_display_slide_media_details( $attachment_id, $post_id ) {
	// bail if no attachment id is passed
	if ( ! isset( $attachment_id ) )
		return;

	// bail if no post id is passed
	if ( ! isset( $post_id ) )
		return;

	// get the post mime type
	$post_obj = get_post( $attachment_id );

	// if it is type content
	if ( $post_obj->post_mime_type == 'content/text' ) {
		// get content
		$content = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_text', true );

		$font_family = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_text_font', true );
		$font_variant = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_text_font_variant', true );
		$font_subset = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_content_text_font_subset', true );

		$output = '';
		$output .= '<div class="row">' . PHP_EOL;

		$output .= '<form action="#" method="post" data-post-id="' . $post_id . '" data-attachment-id="' . $attachment_id . '">' . PHP_EOL;

		// textarea
		$output .= '<p class="howto">' . __( 'Enter the content text you would like displayed.', 'sp-theme' ) . '</p>' . PHP_EOL;
		$output .= '<textarea name="content_text" class="widefat" rows="20">' . stripslashes( $content ) . '</textarea><br /><br />' . PHP_EOL;
		$output .= '<input type="submit" value="' . esc_attr__( 'Save', 'sp-theme' ) . '" name="save" class="save-slide-settings button button-primary" />' . PHP_EOL;	
		$output .= '</form>' . PHP_EOL;	

		$output .= '</div><!--close .row-->' . PHP_EOL;

		return $output;		
	}

	// if it is audio
	if ( $post_obj->post_mime_type == 'audio/mpeg' ) {
		$output = '';
			$output .= '<p class="howto">' . __( 'Due to the compability of each browser, certain audio file formats will not work for all.  It is recommended you add ogg and wav format.  You can do this by simply adding the converted audio format with the same filename to the same uploads folder as your original audio file.  Please note that the filename has to be the same for it to work.  So for example if you uploaded my-audio.mp3, you will need to upload my-audio.ogg and my-audio.wav to the same uploads folder.  You will see the path to the original audio file below.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= __( 'URL Path: ', 'sp-theme' ) . wp_get_attachment_url( $attachment_id ) . PHP_EOL;
			$output .= '<p>' . __( 'Here are the current browser support for HTML 5 audio formats', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= '<table class="html5-browser-compat">' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<th>' . __( 'Browser', 'sp-theme' ) . '</th>' . PHP_EOL;
			$output .= '<th>MP3</th>' . PHP_EOL;
			$output .= '<th>OGG</th>' . PHP_EOL;
			$output .= '<th>WAV</th>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Internet Explorer 9+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Chrome 6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;	
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Firefox 3.6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Safari 5+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Opera 10.6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;											
			$output .= '</table>' . PHP_EOL;

		return $output;
	}

	// if it is video
	if ( $post_obj->post_mime_type == 'video/mp4' ) {
		// get external link
		$external_link = $post_obj->post_content;

		// if one is set, it is an external link
		if ( isset( $external_link ) && ! empty( $external_link ) ) {
			$output = '';
			$output .= '<p>' . __( 'There are no options for this slide media.', 'sp-theme' ) . '</p>' . PHP_EOL;

			return $output;
		} else {
			// get the ogg meta
			$ogg = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_video_format_ogg', true );

			// get the webm meta
			$webm = get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_video_format_webm', true );

			$output = '';
			$output .= '<p class="howto">' . __( 'Due to the compability of each browser, certain video file formats will not work for all.  It is recommended you add ogg and webm format.  You can do this by simply adding the converted video format with the same filename to the same uploads folder as your original video file.  Please note that the filename has to be the same for it to work.  So for example if you uploaded my-video.mp4, you will need to upload my-video.ogg and my-video.webm to the same uploads folder.  You will see the path to the original video file below.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= __( 'URL Path: ', 'sp-theme' ) . wp_get_attachment_url( $attachment_id ) . PHP_EOL;
			$output .= '<p>' . __( 'Here are the current browser support for HTML 5 video formats', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= '<table class="html5-browser-compat">' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<th>' . __( 'Browser', 'sp-theme' ) . '</th>' . PHP_EOL;
			$output .= '<th>MP4</th>' . PHP_EOL;
			$output .= '<th>WebM</th>' . PHP_EOL;
			$output .= '<th>Ogg</th>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Internet Explorer 9+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Chrome 6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;	
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Firefox 3.6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Safari 5+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>Opera 10.6+</td>' . PHP_EOL;
			$output .= '<td>' . __( 'NO', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '<td>' . __( 'YES', 'sp-theme' ) . '</td>' . PHP_EOL;
			$output .= '</tr>' . PHP_EOL;											
			$output .= '</table>' . PHP_EOL;

			return $output;
		}
	}

	// get the slide settings array
	$slide_array = sp_get_slide_settings( $attachment_id, $post_id );
	
	$output = '';
	$output .= '<form action="#" method="post" data-post-id="' . esc_attr( $post_id ) . '" data-attachment-id="' . esc_attr( $attachment_id ) . '">' . PHP_EOL;

	foreach( $slide_array as $key => $value ) {
		$output .= '<div class="row">' . PHP_EOL;
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

			case 'textarea':
				$output .= '<textarea name="' . esc_attr( $key ) . '" rows="8" class="widefat">' . stripslashes( esc_attr( $setting ) ) . '</textarea>' . PHP_EOL;
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

				$font = sp_get_font( get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_' . str_replace( '_variant', '', $key ), true ) );

				if ( $font ) {
					foreach( $font['variants'] as $variant ) {
						$output .= '<option value="' . esc_attr( $variant ) . '" ' . selected( $setting, $variant, false ) . '>' . $variant . '</option>' . PHP_EOL;
					}
				}
														
				$output .= '</select>' . PHP_EOL;
				break;	

			case 'font-subsets':
				$output .= '<select name="' . esc_attr( $key ) . '[]" class="select2-select font-subset-select" multiple data-placeholder="' . __( '--Please Select--', 'sp-theme' ) . '">' . PHP_EOL;
				$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

				$font = sp_get_font( get_post_meta( $attachment_id, '_sp_post_parent_' . $post_id . '_slide_' . str_replace( '_subset', '', $key ), true ) );

				if ( $font ) {
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

	$output .= '<input type="submit" value="' . esc_attr__( 'Save', 'sp-theme' ) . '" name="save" class="save-slide-settings button button-primary" />' . PHP_EOL;
	$output .= '</form>' . PHP_EOL;

	return $output;
}

add_filter( 'enter_title_here', '_sp_filter_title_placeholder_text' );

/**
 * function to filter the title placeholder text
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id the attachment id of the post 
 * @param int $post_id the post id to get the meta from
 * @return array $settings
 */
function _sp_filter_title_placeholder_text( $title ) {
	$screen = get_current_screen();

	switch( $screen->post_type ) {
		case 'sp-faq' :
			return __( 'Enter Your Question Here', 'sp-theme' );
			break;

		case 'sp-contact-form' :
			return __( 'Enter Your Contact Form Name', 'sp-theme' );
			break;

		case 'sp-slider' :
			return __( 'Enter Your Carousel Slider Group Name', 'sp-theme' );
			break;

		case 'sp-testimonial' :
			return __( 'Enter Your Testimonial Name', 'sp-theme' );
			break;

		case 'sp-portfolio' :
			return __( 'Enter Your Portfolio Name', 'sp-theme' );
			break;
			
		default :
			return $title;
			break;
	}
}

add_action( 'wp_update_nav_menu', '_sp_update_nav_menu' );

/**
 * Function that clears transient cache for menus
 *
 * @access public
 * @since 3.0
 * @return array $settings
 */
function _sp_update_nav_menu() {
	global $sptheme_config;
	
	// loop through each menu and delete transient cache
	if ( is_array( $sptheme_config['init']['nav_menu'] ) ) {
		foreach ( $sptheme_config['init']['nav_menu'] as $nav ) {
			delete_transient( $nav['_attr']['name'] );	
		}
	}

	return true;
}

add_action( 'layerslider_ready', 'sp_layerslider_overrides' );

/**
 * Function that overrides layer slider settings
 *
 * @access public
 * @since 3.0
 * @return array $settings
 */
function sp_layerslider_overrides() {

	// Disable auto-updates
	$GLOBALS['lsAutoUpdateBox'] = false;
}