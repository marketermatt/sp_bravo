<?php
/**
 *	
 * theme woocommerce specific functions
 */

// removes the single product title to be relocated
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// removes the single product tabs to be relocated
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// adds the single product tabs to under summary
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );

// removes the single product excerpt
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

// remove on sale badge to be relocated
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// removes the product rating from product category pages
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// removes the cross sell display to be relocated
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

// remove content title to be relocated
add_filter( 'woocommerce_show_page_title', 'sp_woo_remove_show_page_title' );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

function sp_woo_remove_show_page_title( $title ) {
	return false;
}

// remove content breadcrumb to be relocated
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// adds the cross sell to bottom of cart
if ( sp_get_option( 'show_cross_sell_products', 'is', 'on' ) ) {
	add_action( 'woocommerce_cross_sell_section', 'woocommerce_cross_sell_display' );
}

// adds divider line
add_action( 'woocommerce_single_product_summary', 'sp_woo_divider_line', 11 );

// this is redundant
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// this is redundant
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

add_action( 'woocommerce_before_main_content', 'sp_woo_before_main_content', 10 );

add_filter( 'woocommerce_breadcrumb_defaults', 'sp_woo_breadcrumb_args' );

/**
 * Function that adds a wrapping container before WC content
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_before_main_content() {
	$layout = sp_get_page_layout(); 
	$orientation = $layout['orientation'];
	$span_columns = $layout['span_columns'];

	$output = '';

	$output .= '<header class="page-header">' . PHP_EOL;
	$output .= '<div class="container">' . PHP_EOL;
	
	ob_start();
	woocommerce_page_title();
	$output .= '<h1 class="page-title">' . ob_get_clean() . '</h1>' . PHP_EOL;

	// check breadcrumb setting
	if ( sp_get_option( 'product_category_breadcrumbs', 'is', 'on' ) ) {
		ob_start();
		woocommerce_breadcrumb();
		$output .= ob_get_clean();
	}

	$output .= '</div><!--close .container-->' . PHP_EOL;
	$output .= '</header><!--close .page-header -->' . PHP_EOL;

	ob_start();
	do_action( 'sp_woo_before_main_content_below_header' );
	$output .= ob_get_clean();

	$output .= '<div class="container main-container woocommerce-container" itemtype="http://schema.org/Product" itemscope>' . PHP_EOL;
	$output .= '<div class="row ' . esc_attr( $orientation ) . '">' . PHP_EOL;

	if ( $layout['sidebar_left'] )  {
		ob_start();
		get_sidebar( 'left' );
		$output .= ob_get_clean();
	}

	$output .= '<section id="primary" role="main" class="' . esc_attr( $span_columns ) . '">' . PHP_EOL;

	ob_start();
	do_action( 'sp_woo_main_section_top' );
	$output .= ob_get_clean();

	echo $output;
}

add_action( 'woocommerce_after_main_content', 'sp_woo_after_main_content', 10 );

/**
 * Function that adds a closing wrapping container after WC content
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_after_main_content() {
	$layout = sp_get_page_layout(); 

	$output = '';

	do_action( 'sp_woo_main_section_bottom' );

	$output .= '</section>' . PHP_EOL;

	if ( $layout['sidebar_right'] ) {
		ob_start();
		get_sidebar( 'right' );
		$output .= ob_get_clean();
	}

	$output .= '</div><!--close .row--></div><!--close .woocommerce-container-->' . PHP_EOL;

	ob_start();
	do_action( 'sp_woo_after_main_content_container' );
	$output .= ob_get_clean();

	echo $output;
}

if ( ! function_exists( 'sp_woo_divider_line' ) ) :
/**
 * Function that displays a divider line
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_divider_line() {
	echo '<hr class="divider" />';
}
endif;

add_filter( 'woocommerce_pagination_args', 'sp_woo_pagination_args' );

if ( ! function_exists( 'sp_woo_pagination_args' ) ) :
/**
 * Function that modifies the pagination argruments
 *
 * @access public
 * @since 3.0
 * @param array $args | default arguments
 * @return array $args | modified argruments
 */
function sp_woo_pagination_args( $args ) {
	$args['prev_text'] = '<i class="icon-angle-left" aria-hidden="true"></i>';
	$args['next_text'] = '<i class="icon-angle-right" aria-hidden="true"></i>';

	return $args;
}
endif;

add_filter( 'woocommerce_subcategory_count_html', 'sp_woo_hide_subcategory_count' );

if ( ! function_exists( 'sp_woo_hide_subcategory_count' ) ) :
/**
 * Function that hides the subcategory item count
 *
 * @access public
 * @since 3.0
 * @return empty string
 */
function sp_woo_hide_subcategory_count() {
	return '';
}
endif;

add_filter( 'woocommerce_product_single_add_to_cart_text', 'sp_woo_product_add_to_cart_text' );
//add_filter( 'woocommerce_product_add_to_cart_text', 'sp_woo_product_add_to_cart_text' );

if ( ! function_exists( 'sp_woo_product_add_to_cart_text' ) ) :
/**
 * Function that adds an icon to add to cart text
 *
 * @access public
 * @since 3.0
 * @return string $message | message
 */
function sp_woo_product_add_to_cart_text( $text ) {
	return '<i class="icon-plus" aria-hidden="true"></i> ' . $text;
}
endif;

if ( ! function_exists( 'sp_display_slider_products' ) ) :
/**
 * function that display slider products called from product slider shortcode
 * @access public
 * @since 3.0
 * @param object $products | the product object
 * @return html | $output
 */
function sp_display_slider_products( $products = '' ) {
	
	global $post;

	// bail if nothing was passed in
	if ( empty( $products ) )
		return;

	$output = '';

	// get total products
	$total_products = $products->post_count;

	if ( $products->have_posts() ) :

		ob_start();
	
		woocommerce_product_loop_start();

		while ( $products->have_posts() ) : $products->the_post();

			woocommerce_get_template_part( 'content', 'product' );

		endwhile;

		woocommerce_product_loop_end();
		
		$output .= ob_get_clean();

	endif;

	wp_reset_postdata();

	return $output;
}
endif;

add_filter( 'woocommerce_page_title', 'sp_woo_product_category_title' );

if ( ! function_exists( 'sp_woo_product_category_title' ) ) :
/**
 * Function that adds a span hook around titles
 *
 * @access public
 * @since 3.0
 * @param string $title
 * @return mixed html
 */	
function sp_woo_product_category_title( $title ) {
	return '<span>' . $title . '</span>';
}
endif;

if ( ! function_exists( 'sp_woo_product_meta_action_buttons_html' ) ) :
/**
 * Function that builds the product meta buttons such as wishlist, compare...etc
 *
 * @access public
 * @since 3.0
 * @param int $product_id | the id of the product
 * @return mixed html
 */	
function sp_woo_product_meta_action_buttons_html( $product_id = '' ) {
	global $product;

	if ( ! isset( $product_id ) || empty ( $product_id ) )
		$product_id = $product->id;

	// get saved settings
	$social_media = get_post_meta( absint( $product_id ), '_sp_page_show_share', true );
	$show_wishlist = get_post_meta( absint( $product_id ), '_sp_page_show_wishlist', true );
	$show_compare = get_post_meta( absint( $product_id ), '_sp_page_show_compare', true );

	$output = '';

	if ( $show_compare === 'on' )
		$output .= sp_compare_button_html( $product_id );

	if ( $show_wishlist === 'on' )
		$output .= sp_wishlist_button_html( $product_id );

	if ( isset( $social_media ) && ! empty( $social_media ) && $social_media !== 'none' && $social_media !== 'off' )
		$output .= sp_share_button_html();

	// enclose with container
	if ( $output !== '' )
		$output = '<div class="meta-action-buttons">' . $output . '</div>';

	return $output;
}
endif;

add_action( 'woocommerce_single_product_summary', 'sp_woo_single_product_social_share_html', 70 );

if ( ! function_exists( 'sp_woo_single_product_social_share_html' ) ) :
/**
 * Function that generates the social share
 *
 * @access public
 * @since 1.0
 * @return html $output
 */	
function sp_woo_single_product_social_share_html() {
	global $product;

	$output = '';

	if ( get_post_meta( $product->id, '_sp_page_show_share', true ) === 'on' ) {

		$output .= '<div class="social-share clearfix">' . PHP_EOL;
		$output .= '<h3>' . __( 'Share', 'sp-theme' ) . '</h3>' . PHP_EOL;
		$output .= sp_social_media_share_buttons();
		$output .= '</div><!--close .social-share-->' . PHP_EOL;

	}

	echo $output;

	return true;
}
endif;

// remove add to cart action to relocate
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//add_filter( 'woocommerce_loop_add_to_cart_link', 'sp_woo_product_loop_add_to_cart_link', 10, 2 );

if ( ! function_exists( 'sp_woo_product_loop_add_to_cart_link' ) ) :
/**
 * Function that filters the add to cart link on product loops
 *
 * @access public
 * @since 3.0.2
 * @param string $html | html of the link
 * @param object $product | product object
 * @return string html
 */
function sp_woo_product_loop_add_to_cart_link( $html, $product ) { 

	$output = '';

	// check product type
	if ( $product->product_type === 'variable' || $product->product_type === 'grouped' ) {

		$output .= '<a href="' . esc_url( $product->add_to_cart_url() ) . '" rel="nofollow" data-product_id="' . esc_attr( $product->id ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" class="button product_type_' . esc_attr( $product->product_type ) . '"><i class="icon-plus" aria-hidden="true"></i> ' . $product->add_to_cart_text() . '</a>' . PHP_EOL;
	} else {

		$output .= '<a href="' . esc_url( $product->add_to_cart_url() ) . '" rel="nofollow" data-product_id="' . esc_attr( $product->id ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" class="add_to_cart_button button product_type_' . esc_attr( $product->product_type ) . '"><i class="icon-plus" aria-hidden="true"></i> ' . $product->add_to_cart_text() . '</a>' . PHP_EOL;
	}

	return $output;
}
endif;

add_action( 'woocommerce_single_product_summary', 'sp_woo_single_product_action_meta', 41 );

if ( ! function_exists( 'sp_woo_single_product_action_meta' ) ) :
/**
 * Function that generates the wishlist compare icons
 *
 * @access public
 * @since 3.0
 * @return html $output
 */	
function sp_woo_single_product_action_meta() {
	global $product;

	$output = '';
	
	$output .= sp_woo_product_meta_action_buttons_html( $product->id );

	echo $output;
}
endif;

//add_action( 'woocommerce_after_my_account', 'sp_woo_add_product_wishlist_to_my_account' );

/**
 * Function that adds wishlist section to my account page
 * Shows saved wishlists
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_woo_add_product_wishlist_to_my_account() {
	global $current_user;

	$current_user = wp_get_current_user();

	// get wishlist page url
	$wishlist_page = sp_get_option( 'wishlist_page' );

	// get saved wishlists
	$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

	$output = '';

	$output .= '<h3><span>' . __( 'My Wishlists', 'sp-theme' ) . '</span></h3>' . PHP_EOL;

	// check any saved wishlists
	if ( isset( $saved_wishlists ) && is_array( $saved_wishlists ) && count( $saved_wishlists ) > 0 ) {
		$output .= '<ol class="my-account-wishlists">' . PHP_EOL;

		foreach( $saved_wishlists as $list_name => $list_val ) {
			$url = get_permalink( $wishlist_page );
			$url = add_query_arg( 'wishlist', urlencode( stripslashes( $list_name ) ), $url );

			$output .= '<li><a href="' . esc_url( $url ) . '" title="' . esc_attr( stripslashes( $list_name ) ) . '">' . stripslashes( $list_name ) . '</a><a href="#" title="' . esc_attr__( 'Delete Wishlist Entry', 'sp-theme' ) . '" class="delete-wishlist-entry" data-wishlist-name="' . esc_attr( stripslashes( $list_name ) ) . '"><i class="icon-remove-circle" aria-hidden="true"></i></a></li>' . PHP_EOL;
		}

		$output .= '</ol>' . PHP_EOL;
	} else {
		$output .= __( 'You do not have any saved wishlists.', 'sp-theme' );
	}

	echo $output;
	return true;
}

if ( ! function_exists( 'sp_display_wishlist_compare_icons' ) ) :
/**
 * Function that displays the icons for wishlist and compare
 * @access public
 * @since 3.0
 * @return html | $output
 */
function sp_display_wishlist_compare_icons() {
	global $woocommerce;

	$output = '';

	if ( sp_woo_exists() && ( sp_get_option( 'show_wishlist_icon', 'is', 'on' ) || sp_get_option( 'show_compare_icon', 'is', 'on' ) ) ) {

		$output .= '<div class="wishlist-compare">' . PHP_EOL;

		// check if show wishlist icon is on
		if ( sp_get_option( 'show_wishlist_icon', 'is', 'on' ) )
			$output .= '<a href="' . get_permalink( sp_wishlist_page_id() ) . '" title="' . esc_attr__( 'My Wishlist', 'sp-theme' ) . '" class="get-wishlist sp-tooltip" data-toggle="tooltip" data-placement="bottom"><i class="icon-star" aria-hidden="true"><span class="wishlist-item-count">' . sp_woo_get_wishlist_item_count() . '</span></i></a>' . PHP_EOL;

		// check if show compare icon is on
		if ( sp_get_option( 'show_compare_icon', 'is', 'on' ) )
			$output .= '<a href="' . get_permalink( sp_compare_page_id() ) . '" title="' . esc_attr__( 'Compare Products', 'sp-theme') . '" class="get-compare sp-tooltip" data-toggle="tooltip" data-placement="bottom"><i class="icon-cog" aria-hidden="true"><span class="compare-item-count">' . sp_woo_get_compare_item_count() . '</span></i></a>' . PHP_EOL;

		$output .= '</div><!--close .wishlist-compare-tab-->' . PHP_EOL;
	}

	echo $output;
}
endif;

add_action( 'woocommerce_before_checkout_form', 'sp_woo_checkout_breadcrumb', 10, 2 );

if ( ! function_exists( 'sp_woo_checkout_breadcrumb' ) ) :
/**
 * Function that displays breadcrumbs on checkout
 *
 * @access public
 * @since 3.0
 * @param string $active | which item to set active
 * @return $output html
 */
function sp_woo_checkout_breadcrumb( $checkout = '', $active = 'signin' ) {
	global $woocommerce;

	// check if we need to show checkout breadcrumbs
	if ( sp_get_option( 'show_checkout_breadcrumbs', 'is', 'off' ) || sp_get_option( 'checkout_3_step', 'is', 'off' ) )
		return;

	$disable_breadcrumb = '';

	if ( $active === 'signin' )
		$signin_active = 'active';
	else
		$signin_active = '';

	if ( $active === 'billing' )
		$billing_active = 'active';
	else
		$billing_active = '';

	if ( $active === 'review' )
		$review_active = 'active';
	else
		$review_active = '';

	if ( $active === 'confirm' ) {
		$confirm_active = 'active';
		$disable_breadcrumb = 'disable';
	} else {
		$confirm_active = '';
	}

	$output = '';

	$output .= '<ul class="checkout-breadcrumbs clearfix row ' . esc_attr( $disable_breadcrumb ) . '">';
	
	if ( ! is_user_logged_in() && apply_filters( 'sp_woo_checkout_enable_login', true ) ) {
		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_signin', '<li><a href="#" title="' . esc_attr__( '1. Sign In / Register', 'sp-theme' ) . '" class="' . esc_attr( $signin_active ) . ' signin-bc-link">' . esc_attr__( '1. Sign In / Register', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;

		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_billing_shipping', '<li><a href="#" title="' . esc_attr__( '2. Billing / Shipping', 'sp-theme' ) . '" class="' . esc_attr( $billing_active ) . ' billing-bc-link">' . esc_attr__( '2. Billing / Shipping', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;

		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_review_order', '<li><a href="#" title="' . esc_attr__( '3. Review / Payment', 'sp-theme' ) . '" class="' . esc_attr( $review_active ) . ' review-bc-link">' . esc_attr__( '3. Review / Payment', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;

		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_confirmation', '<li class="confirmation"><a href="#" title="' . esc_attr__( '4. Confirmation', 'sp-theme' ) . '" class="' . esc_attr( $confirm_active ) . ' confirmation-bc-link">' . esc_attr__( '4. Confirmation', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;
	} else {
		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_billing_shipping', '<li><a href="#" title="' . esc_attr__( '1. Billing / Shipping', 'sp-theme' ) . '" class="active billing-bc-link">' . esc_attr__( '1. Billing / Shipping', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;

		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_review_order', '<li><a href="#" title="' . esc_attr__( '2. Review / Payment', 'sp-theme' ) . '" class="' . esc_attr( $review_active ) . ' review-bc-link">' . esc_attr__( '2. Review / Payment', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;

		$output .= apply_filters( 'sp_woo_checkout_breadcrumb_confirmation', '<li class="confirmation"><a href="#" title="' . esc_attr__( '3. Confirmation', 'sp-theme' ) . '" class="' . esc_attr( $confirm_active ) . ' confirmation-bc-link">' . esc_attr__( '3. Confirmation', 'sp-theme' ) . '</a></li>' ) . PHP_EOL;
	}

	$output .= '</ul>' . PHP_EOL;

	echo $output;
}
endif;

// check login enabled
if ( sp_get_option( 'checkout_login', 'is', 'off' ) ) {
	add_filter( 'sp_woo_checkout_enable_login', '__return_false' );
}

function sp_woo_breadcrumb_args( $args ) {
	$args['delimiter'] = '<i class="icon-angle-right separator"></i>';

	return $args;
}