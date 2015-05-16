<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * filters
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_action( 'wp_head', 'sp_facebook_og_meta' );

/**
 * Function to adds facebook open graph metas to the head
 * 
 * @access public
 * @since 3.0
 * @return html $metas
 */
function sp_facebook_og_meta() {
	global $post;

	$metas = '';

	// add facebook opengraph metas if enabled 
	if ( sp_get_option( 'facebook_opengraph', 'is', 'on' ) ) {
		if ( is_object( $post ) ) {
			// if WooCommerce plugin active and single product page
			if ( sp_woo_exists() && is_product() ) {
				$product = get_product( $post->ID );
				$product_title = $product->post->post_title;
				$product_url = get_permalink( $product->id );
				$product_image_link = sp_get_image( get_post_thumbnail_id( $product->id, apply_filters( 'sp_fb_opengraph_product_image_width', 100 ), apply_filters( 'sp_fb_opengraph_product_image_height', 100 ), true ) );
				$product_description = $product->post->post_content;
				$product_price = $product->get_price();

				$metas .= '<meta property="og:title" content="' . esc_attr( $product_title ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:type" content="' . apply_filters( 'sp_fb_opengraph_type_for_products', 'product' ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:url" content="' . esc_attr( $product_url ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:image" content="' . esc_attr( $product_image_link['url'] ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:description" content="' . esc_attr( strip_tags( $product_description ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:price:amount" content="' . esc_attr( apply_filters( 'sp_facebook_og_price_display', number_format( strip_tags( (double)$product_price ), 2, '.', '' ), $product_price ) ) . '" />' . PHP_EOL;
			
			// if single blog post
			} elseif ( is_single() || is_page() ) {

				$post_image_link = sp_get_image( get_post_thumbnail_id( $post->ID, apply_filters( 'sp_fb_opengraph_post_image_width', 100 ), apply_filters( 'sp_fb_opengraph_post_image_height', 100 ), true ) );

				$metas .= '<meta property="og:title" content="' . esc_attr( get_the_title( $post->ID ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:type" content="' . apply_filters( 'sp_fb_opengraph_type_for_articles', 'article' ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:url" content="' . esc_attr( get_permalink( $post->ID ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:image" content="' . esc_attr( $post_image_link['url'] ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:description" content="' . esc_attr( strip_tags( $post->post_content ) ) . '" />' . PHP_EOL;   
			
			// all others
			} else {
				$logo_url = get_theme_mod( 'logo_upload' );

				if ( ! isset( $logo_url ) || empty( $logo_url ) )
					$logo_url = THEME_URL . 'images/logo.png';

				$logo_url = apply_filters( 'sp_fb_opengraph_logo_url', $logo_url );

				$metas .= '<meta property="og:type" content="' . apply_filters( 'sp_fb_opengraph_type_for_general', 'website' ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:url" content="' . esc_attr( home_url() ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:image" content="' . esc_attr( $logo_url ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . PHP_EOL;
				$metas .= '<meta property="og:description" content="' . esc_attr( get_bloginfo( 'description' ) ) . '" />' . PHP_EOL;   
			}

			$metas .= '<meta property="fb:admins" content="' . esc_attr( sp_get_option( 'facebook_opengraph_admin_id'  ) ) . '" />' . PHP_EOL;
			$metas .= '<meta property="fb:app_id" content="' . esc_attr( sp_get_option( 'facebook_opengraph_app_id' ) ) . '" />' . PHP_EOL; 			
		}
	}

	echo $metas;	
}

add_action( 'wp_head', '_sp_seo', 1 );

/**
 * Function that outputs seo meta tags
 *
 * @access private
 * @since 3.0
 * @return html $output | the meta tags
 */
function _sp_seo() {
	global $post;

	// check if SEO is enabled
	$seo = sp_get_option( 'seo_enable' );

	if ( isset( $seo ) && $seo === 'off' ) {
	 	return;
	 }

	if ( is_object( $post ) ) {
		// get general meta info
		$description = sp_get_option( 'seo_general_meta_description' );
		$keywords = sp_get_option( 'seo_general_meta_keywords' );

		// get post specific meta
		$page_description = get_post_meta( $post->ID, '_sp_page_seo_description', true );
		$page_keywords = get_post_meta( $post->ID, '_sp_page_seo_keywords', true );
		$page_robot = get_post_meta( $post->ID, '_sp_page_seo_robot', true );

		// fallbacks
		if ( empty( $page_description ) )
			$page_description = get_bloginfo( 'description' );

		$output = '' . PHP_EOL;

		if ( isset( $page_description ) && ! empty( $page_description ) )
			$description = $page_description;
		
		if ( isset( $page_keywords ) && ! empty( $page_keywords ) )
			$keywords = $page_keywords;

		$output .= '<meta name="description" content="' . esc_attr( $description ) . '" />' . PHP_EOL;
		$output .= '<meta name="keywords" content="' . esc_attr( $keywords ) . '" />' . PHP_EOL;

		if ( isset( $page_robot ) && $page_robot !== '0' )
			$output .= '<meta name="robots" content="' . esc_attr( $page_robot ) . '" /> ' . PHP_EOL;

		echo $output;
	}
}

add_action( 'wp_head', 'sp_device_width_meta', 1 );

/**
 * Function that adds viewport meta to the head
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_device_width_meta() {
	$metas = '';

	// check if mobile zoom is enabled
	if ( sp_get_option( 'mobile_zoom', 'is', 'on' ) )
		$metas .= '<meta name="viewport" content="width=device-width, initial-scale=1.0" />' . PHP_EOL;
	else
		$metas .= '<meta name="viewport" content="width=device-width, intital-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . PHP_EOL;

	echo $metas;
}

add_action( 'admin_bar_menu', 'sp_add_maintenance_status_to_toolbar_item', 999 );

/**
 * Function that adds an item to the admin toolbar
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | the id of the attachment
 * @param int $post_id | the id of the parent post
 * @return boolean true
 */
function sp_add_maintenance_status_to_toolbar_item( $wp_admin_bar ) {
	$maintenance = sp_get_option( 'maintenance_enable' );

	if ( $maintenance === 'on' ) {
		$args = array(
			'id'		=> 'maintenance_mode',
			'title'		=> __( 'Maintenance Mode Active', 'sp-theme' ),
			'meta'		=> array( 'class' => 'toolbar-maintenance-mode' ),
			'parent'	=> 'top-secondary'
		);
		
		$wp_admin_bar->add_node( $args );
  	}

  	return true;
}

add_action( 'admin_bar_menu', 'sp_add_theme_customizer_to_toolbar_item', 100 );

/**
 * Function that adds an item to the admin toolbar
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | the id of the attachment
 * @param int $post_id | the id of the parent post
 * @return boolean true
 */
function sp_add_theme_customizer_to_toolbar_item( $wp_admin_bar ) {
	$args = array(
		'id'		=> 'theme_customizer',
		'title'		=> __( 'Theme Customizer', 'sp-theme' ),
		'href'		=> admin_url( 'customize.php' ),
		'meta'		=> array( 'class' => 'toolbar-theme-customizer' )
	);
	
	$wp_admin_bar->add_node( $args );

  	return true;
}

add_action( 'admin_bar_menu', 'sp_add_debug_status_to_toolbar_item', 999 );

/**
 * Function that adds an item to the admin toolbar
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | the id of the attachment
 * @param int $post_id | the id of the parent post
 * @return boolean true
 */
function sp_add_debug_status_to_toolbar_item( $wp_admin_bar ) {

	if ( SP_DEV ) {
		$args = array(
			'id'		=> 'debug_mode',
			'title'		=> __( 'Debug Mode Active', 'sp-theme' ),
			'meta'		=> array( 'class' => 'toolbar-debug-mode' ),
			'parent'	=> 'top-secondary'
		);
		
		$wp_admin_bar->add_node( $args );
  	}

  	return true;
}

add_action( 'wp_head', 'sp_ie_meta', 1 );

/**
 * Function that adds IE 8 specific meta
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_ie_meta() {
?>
<!--[if lte IE 8]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<?php
}

add_action( 'sp_before_main_header_container', 'sp_site_top_widget' );

/**
 * Function that adds widget areas to site top
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_site_top_widget() {
	global $post;

	if ( ! is_object( $post ) )
		return;

	echo '<aside id="sidebar-site-top" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	// site wide
	dynamic_sidebar( 'sidebar-site-top' );

	/////////////////////////////////////////////////////
	// custom page widgets
	/////////////////////////////////////////////////////
	// check if custom page widget is set and is an array
	if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
		// get the page ids
		$page_ids = sp_get_option( 'custom_page_widget' ); // array
		
		// loop through the ids and output each custom widget
		foreach( $page_ids as $page ) {
			// continue if the page id matches the page id set
			if ( $post->ID == $page )
				dynamic_sidebar( 'site-top-page-' . $page );	
		}
	}

	/////////////////////////////////////////////////////
	// custom blog category widgets
	/////////////////////////////////////////////////////
	// check if custom blog widget is set and is an array
	if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
		// get the category ids
		$cat_ids = sp_get_option( 'custom_blog_category_widget' );
		
		// loop through the ids and output each widget
		foreach( $cat_ids as $cat ) {
			if ( isset( get_queried_object()->term_id ) && isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
				dynamic_sidebar( 'site-top-blog-category-' . $cat );
			}	
		}
	}

	/////////////////////////////////////////////////////
	// custom WOO category widgets
	/////////////////////////////////////////////////////		
	// check if WOO is active
	if ( sp_woo_exists() ) {
		if ( sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {

			// get the product category ids
			$cat_ids = sp_get_option( 'custom_product_category_widget' );

			// loop through the ids and output each widget
			foreach( $cat_ids as $cat ) {
				if ( isset( get_queried_object()->term_id ) && isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
					dynamic_sidebar( 'site-top-product-category-' . $cat );	
				}
			}
		}
	}

	echo '</div>' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_after_main_footer_container', 'sp_site_bottom_widget' );

/**
 * Function that adds widget areas to site top
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_site_bottom_widget() {
	global $post;

	if ( ! is_object( $post ) )
		return;
	
	echo '<aside id="sidebar-site-bottom" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom page widgets
	/////////////////////////////////////////////////////
	// check if custom page widget is set and is an array
	if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
		// get the page ids
		$page_ids = sp_get_option( 'custom_page_widget' ); // array
		
		// loop through the ids and output each custom widget
		foreach( $page_ids as $page ) {
			// continue if the page id matches the page id set
			if ( $post->ID == $page )
				dynamic_sidebar( 'site-bottom-page-' . $page );	
		}
	}

	/////////////////////////////////////////////////////
	// custom blog category widgets
	/////////////////////////////////////////////////////
	// check if custom blog widget is set and is an array
	if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
		// get the category ids
		$cat_ids = sp_get_option( 'custom_blog_category_widget' );
		
		// loop through the ids and output each widget
		foreach( $cat_ids as $cat ) {
			// checks if current post category matches the saved settings
			if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
				dynamic_sidebar( 'site-bottom-blog-category-' . $cat );	
			}
		}
	}

	/////////////////////////////////////////////////////
	// custom WOO category widgets
	/////////////////////////////////////////////////////		
	// check if WOO is active
	if ( sp_woo_exists() ) {
		if ( sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {

			// get the product category ids
			$cat_ids = sp_get_option( 'custom_product_category_widget' );

			// loop through the ids and output each widget
			foreach( $cat_ids as $cat ) {
				if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
					dynamic_sidebar( 'site-bottom-product-category-' . $cat );	
				}
			}
		}
	}

	echo '</div>' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_page_layout_before_content_row', 'sp_page_top_widget' );

/**
 * Function that adds widget areas to page top
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_page_top_widget() {
	global $post;

	if ( ! is_object( $post ) )
		return;
	
	echo '<aside id="sidebar-page-top" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom page widgets
	/////////////////////////////////////////////////////
	// check if custom page widget is set and is an array
	if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
		// get the page ids
		$page_ids = sp_get_option( 'custom_page_widget' ); // array
		
		// loop through the ids and output each custom widget
		foreach( $page_ids as $page ) {
			// continue if the page id matches the page id set
			if ( $post->ID == $page )
				dynamic_sidebar( 'page-top-page-' . $page );	
		}
	}

	echo '</div><!--close .container-->' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_page_layout_after_content_row', 'sp_page_bottom_widget' );

/**
 * Function that adds widget areas to page bottom
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_page_bottom_widget() {
	global $post;

	if ( ! is_object( $post ) )
		return;
	
	echo '<aside id="sidebar-page-bottom" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom page widgets
	/////////////////////////////////////////////////////
	// check if custom page widget is set and is an array
	if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
		// get the page ids
		$page_ids = sp_get_option( 'custom_page_widget' ); // array
		
		// loop through the ids and output each custom widget
		foreach( $page_ids as $page ) {
			// continue if the page id matches the page id set
			if ( $post->ID == $page )
				dynamic_sidebar( 'page-bottom-page-' . $page );	
		}
	}

	echo '</div>' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_category_layout_before_main_container', 'sp_blog_page_top_widget' );
add_action( 'sp_post_layout_before_main_container', 'sp_blog_page_top_widget' );

/**
 * Function that adds widget areas to page top
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_blog_page_top_widget() {
	
	echo '<aside id="sidebar-page-top" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom blog category widgets
	/////////////////////////////////////////////////////
	// check if custom blog widget is set and is an array
	if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
		// get the category ids
		$cat_ids = sp_get_option( 'custom_blog_category_widget' );
		
		// loop through the ids and output each widget
		foreach( $cat_ids as $cat ) {
			// checks if current post category matches the saved settings
			if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
				dynamic_sidebar( 'page-top-blog-category-' . $cat );	
			}
		}
	}

	echo '</div>' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_category_layout_after_main_container', 'sp_blog_page_bottom_widget' );
add_action( 'sp_post_layout_after_main_container', 'sp_blog_page_bottom_widget' );

/**
 * Function that adds widget areas to page bottom
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_blog_page_bottom_widget() {
	
	echo '<aside id="sidebar-page-bottom" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom blog category widgets
	/////////////////////////////////////////////////////
	// check if custom blog widget is set and is an array
	if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
		// get the category ids
		$cat_ids = sp_get_option( 'custom_blog_category_widget' );
		
		// loop through the ids and output each widget
		foreach( $cat_ids as $cat ) {
			// checks if current post category matches the saved settings
			if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
				dynamic_sidebar( 'page-bottom-blog-category-' . $cat );	
			}
		}
	}

	echo '</div>' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}