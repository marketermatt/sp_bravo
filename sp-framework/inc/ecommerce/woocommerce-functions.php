<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * woocommerce functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_filter( 'woocommerce_get_price_html', 'sp_woo_filter_price_html' );

/**
 * Function that adds microdata to the price html
 *
 * @access public
 * @since 3.0
 * @param html $price_html | the price html to filter
 * @return html
 */
function sp_woo_filter_price_html( $price_html ) {
	return str_replace( '<span class="amount">', '<span class="amount" itemprop="price">', $price_html );
}

// remove default outer content wrapper and role our own
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// don't show related products if option is off
if ( sp_get_option( 'show_related_products', 'is', 'off' ) ) {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}

// don't show upsell products if option is off
if ( sp_get_option( 'show_upsell_products', 'is', 'off' ) ) {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_filter( 'external_add_to_cart_text', 'sp_woo_external_add_to_cart_text' );

/**
 * Function that filters the external add to cart button text
 *
 * @access public
 * @since 3.0
 * @return string
 */
function sp_woo_external_add_to_cart_text() {
	return __( 'Learn More', 'sp-theme' );
}

add_filter( 'out_of_stock_add_to_cart_text', 'sp_woo_outofstock_button_text' );

/**
 * Function that filters the out of stock add to cart button text
 *
 * @access public
 * @since 3.0
 * @return string
 */
function sp_woo_outofstock_button_text() {
	return __( 'Out of Stock', 'sp-theme' );
}

// add the functions to the ajax action hook
if ( is_admin() ) {
	add_action( 'wp_ajax_sp_woo_update_cart_ajax', 'sp_woo_update_cart_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_update_cart_ajax', 'sp_woo_update_cart_ajax' );	

	add_action( 'wp_ajax_sp_woo_add_to_cart_ajax', 'sp_woo_add_to_cart_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_add_to_cart_ajax', 'sp_woo_add_to_cart_ajax' );		
	
	add_action( 'wp_ajax_sp_woo_remove_item_ajax', 'sp_woo_remove_item_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_remove_item_ajax', 'sp_woo_remove_item_ajax' );	
	
	add_action( 'wp_ajax_sp_get_product_wishlist_ajax', 'sp_get_product_wishlist_ajax' );
	add_action( 'wp_ajax_nopriv_sp_get_product_wishlist_ajax', 'sp_get_product_wishlist_ajax' );

	add_action( 'wp_ajax_sp_woo_product_quickview_ajax', 'sp_woo_product_quickview_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_product_quickview_ajax', 'sp_woo_product_quickview_ajax' );
	
	add_action( 'wp_ajax_sp_woo_add_product_wishlist_ajax', 'sp_woo_add_product_wishlist_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_add_product_wishlist_ajax', 'sp_woo_add_product_wishlist_ajax' );
	
	add_action( 'wp_ajax_sp_woo_remove_product_wishlist_item_ajax', 'sp_woo_remove_product_wishlist_item_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_remove_product_wishlist_item_ajax', 'sp_woo_remove_product_wishlist_item_ajax' );	

	add_action( 'wp_ajax_sp_woo_delete_product_wishlist_entry_ajax', 'sp_woo_delete_product_wishlist_entry_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_delete_product_wishlist_entry_ajax', 'sp_woo_delete_product_wishlist_entry_ajax' );

	add_action( 'wp_ajax_sp_woo_save_new_product_wishlist_ajax', 'sp_woo_save_new_product_wishlist_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_save_new_product_wishlist_ajax', 'sp_woo_save_new_product_wishlist_ajax' );		
	
	add_action( 'wp_ajax_sp_woo_save_existing_product_wishlist_ajax', 'sp_woo_save_existing_product_wishlist_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_save_existing_product_wishlist_ajax', 'sp_woo_save_existing_product_wishlist_ajax' );

	add_action( 'wp_ajax_sp_woo_email_product_wishlist_ajax', 'sp_woo_email_product_wishlist_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_email_product_wishlist_ajax', 'sp_woo_email_product_wishlist_ajax' );

	add_action( 'wp_ajax_sp_woo_add_product_compare_ajax', 'sp_woo_add_product_compare_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_add_product_compare_ajax', 'sp_woo_add_product_compare_ajax' );

	add_action( 'wp_ajax_sp_woo_remove_product_compare_item_ajax', 'sp_woo_remove_product_compare_item_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_remove_product_compare_item_ajax', 'sp_woo_remove_product_compare_item_ajax' );

	add_action( 'wp_ajax_sp_woo_product_image_gallery_swap_quickview_ajax', 'sp_woo_product_image_gallery_swap_quickview_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_product_image_gallery_swap_quickview_ajax', 'sp_woo_product_image_gallery_swap_quickview_ajax' );	

	add_action( 'wp_ajax_sp_woo_product_image_gallery_swap_single_ajax', 'sp_woo_product_image_gallery_swap_single_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_product_image_gallery_swap_single_ajax', 'sp_woo_product_image_gallery_swap_single_ajax' );

	add_action( 'wp_ajax_sp_woo_view_order_ajax', 'sp_woo_view_order_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_view_order_ajax', 'sp_woo_view_order_ajax' );					

	add_action( 'wp_ajax_sp_woo_edit_address_ajax', 'sp_woo_edit_address_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_edit_address_ajax', 'sp_woo_edit_address_ajax' );	

	add_action( 'wp_ajax_sp_woo_edit_account_ajax', 'sp_woo_edit_account_ajax' );
	add_action( 'wp_ajax_nopriv_sp_woo_edit_account_ajax', 'sp_woo_edit_account_ajax' );			
}

/**
 * Function that updates the count and subtotal in mini cart
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_update_cart_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	global $woocommerce;

	$count = WC()->cart->cart_contents_count;

	$subtotal = WC()->cart->get_cart_subtotal();

	echo json_encode( array( 'count' => $count, 'subtotal' => $subtotal ) );
	exit;
}

/**
 * Function that handles woo add to cart ajax
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_add_to_cart_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	ob_start();
	
	global $woocommerce, $product;

	$product_id	= apply_filters( 'woocommerce_add_to_cart_product_id', $_POST['product_id'] );

	$product_type = sanitize_text_field( $_POST['product_type'] );

	// get form values
	$form = $_POST['form'];

	$form_items = array();

	parse_str( $form, $form_items );

	// sanitize form values
	if ( is_array( $form_items ) )
		array_walk_recursive( $form_items, 'sp_clean_multi_array' );

	// get the product
	$product = get_product( $product_id );

	$woo_message = '';
	$interactive_add_to_cart = '';
	$added_to_cart_message = '';
	$was_added_to_cart = false;
	$added_to_cart = array();
	$adding_to_cart = get_product( $product_id );
	$url = false;
	$redirect = false;

	$quantity = isset( $form_items['quantity'] ) ? $form_items['quantity'] : 1;

	$output = '';

	switch( $product_type ) {
		case 'simple' :

			$quantity = apply_filters( 'woocommerce_stock_amount', $quantity );

			// Add to cart validation
			$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

			if ( $passed_validation ) {
				do_action( 'woocommerce_ajax_added_to_cart', $product_id );

				// if add to cart successfully
				if ( WC()->cart->add_to_cart( $product_id, $quantity ) ) {    						
					wc_add_to_cart_message( $product_id );

					$was_added_to_cart = true;
					$added_to_cart[] = $product_id;
				}
			}

			break;
		case 'variable' :
			$variation_id	= empty( $_POST['variation_id'] ) ? '' : absint( $_POST['variation_id'] );
			$variations_set	= $_POST['variations'];
			$variations = array();
			$attributes = $adding_to_cart->get_attributes();
			$variation  = get_product( $variation_id );

			$all_variations_set = true;

			// Verify all attributes
			foreach ( $attributes as $attribute ) {
				if ( ! $attribute['is_variation'] )
					continue;

				$taxonomy = 'attribute_' . sanitize_title( $attribute['name'] );

				if ( isset( $form_items[ $taxonomy ] ) ) {

					// Get value from post data
					// Don't use wc_clean as it destroys sanitized characters
					$value = sanitize_title( trim( stripslashes( $form_items[ $taxonomy ] ) ) );

					// Get valid value from variation
					$valid_value = $variation->variation_data[ $taxonomy ];

					// Allow if valid
					if ( $valid_value == '' || $valid_value == $value ) {
						if ( $attribute['is_taxonomy'] )
							$variations[ $taxonomy ] = $value;
						else {
							// For custom attributes, get the name from the slug
							$options = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
							foreach ( $options as $option ) {
								if ( sanitize_title( $option ) == $value ) {
									$value = $option;
									break;
								}
							}
							 $variations[ $taxonomy ] = $value;
						}
						continue;
					}
				}

				$all_variations_set = false;
			}

			if ( $all_variations_set ) {
				// Add to cart validation
				$passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

				if ( $passed_validation ) {
					// if added successfully
					if ( WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) { 
						wc_add_to_cart_message( $product_id );
						$was_added_to_cart = true;
						$added_to_cart[] = $product_id;
					}
				}
			} else {
				wc_add_notice( __( 'Please choose product options&hellip;', 'sp-theme' ), 'error' );
			}

			break;

		case 'grouped' :
			if ( ! empty( $quantity ) && is_array( $quantity ) ) {

				$quantity_set = false;

				foreach ( $quantity as $item => $item_quantity ) {
					if ( $item_quantity <= 0 )
						continue;

					$quantity_set = true;

					// Add to cart validation
					$passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $item, $item_quantity );

					if ( $passed_validation ) {
						if ( WC()->cart->add_to_cart( $item, $item_quantity ) ) {
							$was_added_to_cart = true;
							$added_to_cart[] = $item;
						}
					}
				}

				if ( $was_added_to_cart ) {
					wc_add_to_cart_message( $added_to_cart );
				}

				if ( ! $was_added_to_cart && ! $quantity_set ) {
					wc_add_notice( __( 'Please choose the quantity of items you wish to add to your cart&hellip;', 'sp-theme' ), 'error' );
				}

			} elseif ( $product_id ) {
				/* Link on product archives */
				wc_add_notice( __( 'Please choose a product to add to your cart&hellip;', 'sp-theme' ), 'error' );
			}

			break;
	}

	// If we added the product to the cart we can now optionally do a redirect.
	if ( $was_added_to_cart && wc_notice_count( 'error' ) == 0 ) {

		$url = apply_filters( 'add_to_cart_redirect', $url );

		// If has custom URL redirect there
		if ( $url ) {
			$redirect = true;
		}

		// Redirect to cart option
		elseif ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
			$url = WC()->cart->get_cart_url();
			$redirect = true;
		}
	}

	$woo_message = wc_get_notices( 'success' );
	$woo_errors = wc_get_notices( 'error' );
	$errors = '';

	// clear out the notices if not redirect
	if ( get_option( 'woocommerce_cart_redirect_after_add' ) === 'no' )
		wc_clear_notices();

	// loop through each error message and append
	foreach( $woo_errors as $error ) {
		// remove view cart link
		$errors .= preg_replace( '/<.+>/', '', $error ) . '<br />';
	}

	// check if message is empty
	if ( empty( $woo_message ) ) {
		// check if error message is empty
		if ( empty( $woo_errors ) )
			$added_to_cart_message = __( 'Item added to your cart.', 'sp-theme' );
		else
			$added_to_cart_message = $errors;
	} else {
		$added_to_cart_message = $product->post->post_title . ' ' . apply_filters( 'sp_woo_added_to_cart_text', __( 'has been added to your cart.', 'sp-theme' ) );
	}

	// Return fragments
	ob_start();
	woocommerce_mini_cart();
	$cart = ob_get_clean();

	if ( isset( $woo_message ) && count( $woo_message ) > 1 ) {
		// build interactive add to cart modal
		$interactive_add_to_cart .= '<div class="interactive-modal-content"><p>' . $woo_message[0] . '</p><p>' . $added_to_cart_message . '</p><div class="button-wrap clearfix"><a href="#" title="' . esc_attr__( 'Continue Shopping', 'sp-theme' ) . '" class="continue-shopping close-modal">' . esc_attr__( 'Continue Shopping', 'sp-theme' ) . '</a><a href="' . esc_url( apply_filters( 'sp_interactive_modal_cart_link', WC()->cart->get_cart_url() ) ) . '" title="' . esc_attr__( 'Go to Checkout', 'sp-theme' ) . '" class="checkout">' . esc_attr__( 'Go to Checkout', 'sp-theme' ) . '</a></div></div>';
	} else {
		// build interactive add to cart modal
		$interactive_add_to_cart .= '<div class="interactive-modal-content"><p>' . $added_to_cart_message . '</p><div class="button-wrap clearfix"><a href="#" title="' . esc_attr__( 'Continue Shopping', 'sp-theme' ) . '" class="continue-shopping close-modal">' . esc_attr__( 'Continue Shopping', 'sp-theme' ) . '</a><a href="' . esc_url( apply_filters( 'sp_interactive_modal_cart_link', WC()->cart->get_cart_url() ) ) . '" title="' . esc_attr__( 'Go to Checkout', 'sp-theme' ) . '" class="checkout">' . esc_attr__( 'Go to Checkout', 'sp-theme' ) . '</a></div></div>';
	}

	echo json_encode( array( 'cart' => $cart, 'interactive_add_to_cart' => $interactive_add_to_cart, 'was_added_to_cart' => $was_added_to_cart, 'redirect' => $redirect, 'redirect_url' => $url ) );
	exit;	 
}

/**
 * Function that handles woo remove item ajax
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_woo_remove_item_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	global $woocommerce;

	$item_key = sanitize_text_field( $_POST['item_key'] );

	if ( ! isset( $item_key ) || empty( $item_key ) )
		exit;

	WC()->cart->set_quantity( $item_key, 0 );

	// Return fragments
	ob_start();
	woocommerce_mini_cart();
	$cart = ob_get_clean();

	echo json_encode( array( 'cart' => $cart ) );
	exit;	
}

/**
 * Function that overrides the quickview variation image size
 *
 * @access private
 * @since 3.0
 * @param array $data | the data array of the variation
 * @param object $variation | the variation object post
 * @return array $data | filtered image size
 */
function _sp_woo_quickview_variation_image_size( $data, $variation ) {
		$variation_id = (int) $data['variation_id'];

		// get user set image width/height
		$image_width = sp_get_option( 'quickview_width' );
		$image_height = sp_get_option( 'quickview_height' );
		$image_crop = sp_get_option( 'quickview_image_crop' );

		if ( $image_crop === 'on' )
			$image_crop = true;
		else
			$image_crop = false;

		// check if variation has thumbnail
		if ( get_post_thumbnail_id( $variation_id ) !== '0' ) {
			$image = sp_get_image( get_post_thumbnail_id( $variation_id ), $image_width, $image_height, $image_crop  );

			$data['image_src'] = $image['url'];
		}

		return $data;	
}

/**
 * Function that builds the wishlist products html
 *
 * @access public
 * @since 3.0
 * @param array $wishlist_ids | list of product ids
 * @return html $output
 */
function sp_woo_product_wishlist_html( $wishlist_ids = array() ) {
	if ( ! isset( $wishlist_ids ) || empty( $wishlist_ids ) )
		return;

	global $post, $woocommerce;

	// build arguments for query
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'post__in' => $wishlist_ids,
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key'		=> '_visibility',
				'value'		=> array( 'catalog', 'visible' ),
				'compare'	=> 'IN'
			)
		)		
	);

	$products = new WP_Query( $args );

	$output = '';

	$output .= '<table class="wishlist-table">' . PHP_EOL;

	$output .= '<thead>' . PHP_EOL;
	$output .= '<tr>' . PHP_EOL;
	$output .= '<th class="remove-item"></th>' . PHP_EOL;
	$output .= '<th class="item-image"></th>' . PHP_EOL;
	$output .= '<th class="item-name">' . __( 'Item Name', 'sp-theme' ) . '</th>' . PHP_EOL;
	$output .= '<th class="item-price">' . __( 'Item Price', 'sp-theme' ). '</th>' . PHP_EOL;
	$output .= '<th class="item-stock">' . __( 'Stock Status', 'sp-theme' ) . '</th>' . PHP_EOL;
	$output .= '<th class="item-action"></th>' . PHP_EOL;
	$output .= '</tr>' . PHP_EOL;
	$output .= '</thead>' . PHP_EOL;
	$output .= '<tbody>' . PHP_EOL;

	while( $products->have_posts() ) : $products->the_post();
		$product = get_product( $post->ID );

		$output .= '<tr itemscope itemtype="http://schema.org/Product" class="product">' . PHP_EOL;

		$output .= '<td><a href="#" title="' . esc_attr__( 'Remove Item', 'sp-theme' ) . '" class="remove-wishlist-item" data-product-id="' . esc_attr( $post->ID ) . '"><i class="icon-remove" aria-hidden="true"></i></a></td>' . PHP_EOL;

		$image = sp_get_image( get_post_thumbnail_id(), apply_filters( 'sp_wishlist_product_image_width', 50 ), apply_filters( 'sp_wishlist_product_image_height', 50 ), apply_filters( 'sp_wishlist_product_image_crop', true ) );

		$output .= '<td class="item-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><img src="' . esc_attr( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" itemprop="image" /></a></td>' . PHP_EOL;

		$output .= '<td><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">' . get_the_title() . '</a></td>' . PHP_EOL;

		$output .= '<td class="item-price">' . $product->get_price_html() . '</td>' . PHP_EOL;

		// check stock
		$in_stock = $product->is_in_stock();

		if ( $in_stock )
			$stock_status = __( 'In Stock', 'sp-theme' );
		else
			$stock_status = __( 'Out of Stock', 'sp-theme' );

		$output .= '<td class="item-stock"><p class="stock ' . esc_attr( str_replace( ' ', '', strtolower( $stock_status ) ) ) . '">' . $stock_status . '</p></td>' . PHP_EOL;

		// get add to cart button
		ob_start();
		wc_get_template( 'loop/add-to-cart.php' );
		$addtocart = ob_get_clean() . PHP_EOL;

		// perform string replace to insert icon
		$addtocart = str_replace( '</a>', ' <i class="icon-ok" aria-hidden="true"></i></a>', $addtocart );

		$output .= '<td><form class="cart" method="post" enctype="multipart/form-data">' . $addtocart . '<input type="hidden" name="product_id" value="' . esc_attr( $product->id ) . '" /><input type="hidden" name="product_type" value="simple" /><input type="hidden" name="quantity" value="1" /></form></td>' . PHP_EOL;

		$output .= '</tr>' . PHP_EOL;

	endwhile;

	wp_reset_postdata();

	$output .= '</tbody>' . PHP_EOL;
	$output .= '</table>' . PHP_EOL;

	return $output;
}

/**
 * Function that builds the compare products html
 *
 * @access public
 * @since 3.0
 * @param array $compare_ids | list of product ids
 * @return html $output
 */
function sp_woo_product_compare_html( $compare_ids = array() ) {
	if ( ! isset( $compare_ids ) || empty( $compare_ids ) )
		return;

	global $post, $woocommerce, $product;

	// build arguments for query
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'post__in' => $compare_ids,
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key'		=> '_visibility',
				'value'		=> array( 'catalog', 'visible' ),
				'compare'	=> 'IN'
			)
		)		
	);

	$products = new WP_Query( $args );

	$output = '';

	$output .= '<div class="compare-products-container">' . PHP_EOL;

	$output .= '<ul itemscope itemtype="http://schema.org/Product">' . PHP_EOL;

	while( $products->have_posts() ) : $products->the_post();
		$product = get_product( $post->ID );

		$output .= '<li class="product">' . PHP_EOL;

		$output .= '<a href="#" title="' . esc_attr__( 'Remove Item', 'sp-theme' ) . '" class="remove-compare-item" data-product-id="' . esc_attr( $post->ID ) . '"><i class="icon-remove" aria-hidden="true"></i> ' . __( 'Remove Item', 'sp-theme' ) . '</a>' . PHP_EOL;

		$image = sp_get_image( get_post_thumbnail_id(), apply_filters( 'sp_compare_product_image_width', 200 ), apply_filters( 'sp_compare_product_image_height', 200 ), apply_filters( 'sp_compare_product_image_crop', true ) );

		$output .= '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" class="image-link"><img src="' . esc_attr( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" itemprop="image" /></a>' . PHP_EOL;

		$output .= '<h3><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">' . get_the_title() . '</a></h3>' . PHP_EOL;

		$output .= '<p class="divider">' . $product->get_price_html() . '</p>' . PHP_EOL;

		$output .= '<p class="excerpt divider">' . $product->post->post_excerpt . '</p>' . PHP_EOL;
		
		// check if product has attributes
		if ( $product->has_attributes() ) {
			ob_start();
			$product->list_attributes();
			$attributes = ob_get_clean();

			$output .= $attributes . PHP_EOL;
		}

		// check stock
		$in_stock = $product->is_in_stock();

		if ( $in_stock )
			$stock_status = __( 'In Stock', 'sp-theme' );
		else
			$stock_status = __( 'Out of Stock', 'sp-theme' );

		$output .= '<p class="stock divider ' . esc_attr( str_replace( ' ', '', strtolower( $stock_status ) ) ) . '">' . $stock_status . '</p>' . PHP_EOL;

		// get add to cart button
		ob_start();
		wc_get_template( 'loop/add-to-cart.php' );
		$addtocart = ob_get_clean() . PHP_EOL;

		// perform string replace to insert icon
		$addtocart = str_replace( '</a>', ' <i class="icon-ok" aria-hidden="true"></i></a>', $addtocart );

		$output .= '<p class="divider">' . $addtocart . '</p>' . PHP_EOL;

		$output .= '<input type="hidden" name="product_id" value="' . esc_attr( $post->ID ) . '" />' . PHP_EOL;

		$output .= '<input type="hidden" name="product_type" value="' . esc_attr( $product->product_type ) . '" />' . PHP_EOL;
		
		$output .= '</li>' . PHP_EOL;

	endwhile;

	wp_reset_postdata();

	$output .= '</ul>' . PHP_EOL;

	$output .= '</div><!--close .compare-products-container-->' . PHP_EOL;

	return $output;
}

add_filter( 'woocommerce_product_tabs', 'sp_woo_filter_product_tabs' );

/**
 * Function that filters the product tabs
 *
 * @access public
 * @since 3.0
 * @return array $tabs
 */	
function sp_woo_filter_product_tabs( $tabs ) {
	global $product;

	// get product tabs meta
	$tab_names = get_post_meta( $product->post->ID, '_sp_custom_product_tab_names', true );

	$show_product_description_tab = get_post_meta( $product->post->ID, '_sp_product_description_tab', true );
	$show_additional_info_tab = get_post_meta( $product->post->ID, '_sp_product_additional_info_tab', true );
	$show_product_review_tab = get_post_meta( $product->post->ID, '_sp_product_review_tab', true );

	// check to see if we need to add custom tabs
	if ( is_array( $tab_names ) && $tab_names ) {
		$priority = 30;
		$i = 0;

		foreach( $tab_names as $name ) {
			$tabs[strtolower( trim( str_replace( ' ', '', $name ) ) )] = array( 
				'title' => $name,
				'priority' => (int) $priority,
				'callback' => 'sp_woo_custom_tab_content_display',
				'index' => $i
			);

			$priority += 10;
			$i++;
		}

		// set the priorty of review tab to be last to show
		$tabs['reviews']['priority'] = $priority += 10;
	}

	if ( $show_product_description_tab === 'off' )
		unset( $tabs['description'] );

	if ( $show_additional_info_tab === 'off' )
		unset( $tabs['additional_information'] );

	if ( $show_product_review_tab === 'off' )
		unset( $tabs['reviews'] );

	return $tabs;
}

/**
 * Function that generates the custom tab content
 *
 * @access public
 * @since 3.0
 * @return html $output
 */	
function sp_woo_custom_tab_content_display( $key, $tab ) {
	global $product;

	// get product meta
	$tab_content = get_post_meta( $product->post->ID, '_sp_custom_product_tab_content', true );

	$output = '';

	$output .= '<div class="custom-product-tabs">' . PHP_EOL;

	$output .= do_shortcode( $tab_content[$tab['index']] );

	$output .= '</div><!--close .custom-product-tabs-->' . PHP_EOL;

	echo $output;

	return true;
}

/**
 * Function that gets the number of wishlist items
 *
 * @access public
 * @since 3.0
 * @return string $count
 */	
function sp_woo_get_wishlist_item_count() {
	$count = '0';	
	
	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

		if ( is_array( $cookie ) )
			$count = (string)count( $cookie );
	}

	return $count;
}

/**
 * Function that gets the number of compare items
 *
 * @access public
 * @since 3.0
 * @return string $count
 */	
function sp_woo_get_compare_item_count() {
	$count = '0';

	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_compare'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_compare'] );

		if ( is_array( $cookie ) )
			$count = (string)count( $cookie );
	}

	return $count;
}

add_action( 'woocommerce_before_shop_loop', 'sp_woo_display_grid_list_view_buttons' );

/**
 * Function that displays the grid and list view buttons
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_woo_display_grid_list_view_buttons() {
	if ( sp_get_option( 'product_view_buttons', 'is', 'off' ) )
		return;

	$shop_page_display = get_option( 'woocommerce_shop_page_display' );
	$cat_page_display = get_option( 'woocommerce_category_archive_display' );
	// if view is not products only don't show buttons
	//if ( ! empty( $shop_page_display ) || ! empty( $cat_page_display ) )
		//return;

	if ( sp_get_product_view_type() === 'list-view' ) {
		$list_view_active = 'active';
		$grid_view_active = '';
	} else {
		$list_view_active = '';
		$grid_view_active = 'active';
	}

	$output = '';

	$output .= '<div class="grid-list-view-buttons">' . PHP_EOL;
	$output .= '<a href="#" title="' . __( 'List View', 'sp-theme' ) . '" class="list-view-button sp-tooltip ' . esc_attr( $list_view_active ) . '" data-toggle="tooltip" data-placement="top"><i class="icon-list3"></i></a>';
	$output .= '<a href="#" title="' . __( 'Grid View', 'sp-theme' ) . '" class="grid-view-button sp-tooltip ' . esc_attr( $grid_view_active ) . '" data-toggle="tooltip" data-placement="top"><i class="icon-grid2"></i></a>' . PHP_EOL;
	$output .= '</div><!--close .row-->' . PHP_EOL;

	echo $output;
}

add_filter( 'woocommerce_catalog_orderby', 'sp_woo_orderby_dropdown_text' );

/**
 * Function that filters the orderby dropdown text
 *
 * @access public
 * @since 3.0
 * @param array $list | the existing list
 * @return array $list | modified array list
 */
function sp_woo_orderby_dropdown_text( $list ) {
	$list['date'] = __( 'Sort by most recent', 'sp-theme' );

	return $list;
}

// see utils/helper function for callback
add_action( 'woocommerce_before_shop_loop', 'sp_add_clearfix', 40 );

add_filter( 'loop_shop_per_page', 'sp_woo_filter_products_per_page', 20 );

/**
 * Function that filters the number of products per page
 *
 * @access public
 * @since 3.0
 * @return int $ppp | how many products to return
 */
function sp_woo_filter_products_per_page() {
	// get saved settings
	$ppp = sp_get_option( 'products_per_page' );

	if ( ! isset( $ppp ) || empty( $ppp ) )
		$ppp = 20;

	return absint( $ppp );
}

add_filter( 'loop_shop_columns', 'sp_woo_product_loop_columns' );

/**
 * Function that filters the number of columns per row
 *
 * @access public
 * @since 3.0
 * @return int $columns | how many columns per row
 */
function sp_woo_product_loop_columns() {
	// get the saved value from settings
	$columns = absint( sp_get_option( 'products_per_row' ) );

	if ( ! isset( $columns ) || empty( $columns ) )
		$columns = 4;
	
	return $columns;
}

add_action( 'woocommerce_before_shop_loop_item_title', 'sp_woo_product_show_new', 10 );

/**
 * Function that filters the new badge display
 *
 * @access public
 * @since 3.0
 * @return html $badge
 */
function sp_woo_product_show_new() {
	global $post;

	// get saved settings
	$show_new_badge = sp_get_option( 'show_product_new_badge' );
	$new_badge_duration = sp_get_option( 'product_new_badge_duration' );

	if ( $show_new_badge !== 'on' )
		return;

	$product_date = strtotime( $post->post_date );
	$current_date = time();
	$duration = 24*60*60*absint( $new_badge_duration );
	$badge = '';

	// show new badge			
	if ( ( $current_date - $product_date ) < $duration )
		$badge = '<span class="new">' . __( 'New!', 'sp-theme' ) . '</span>';

	echo $badge;
}

/**
 * Function that checks catalog visibility options plugin
 *
 * @access public
 * @since 3.1.0
 * @param object $product
 * @return boolean true | false
 */
function sp_woo_cvo_hide( $product ) {
	if ( ! class_exists( 'WC_Catalog_Visibility_Options' ) )
		return false;

	$wc_cvo = new WC_Catalog_Visibility_Options();

	if ( 
		(($wc_cvo->setting('wc_cvo_atc') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_atc') == 'disabled') ||
		(($wc_cvo->setting('wc_cvo_prices') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_prices') == 'disabled')
	) {
		// only call it if it exists
		if ( file_exists( ABSPATH . 'wp-content/plugins/woocommerce-catalog-visibility-options/lib/woocommerce-catalog-restrictions/classes/class-wc-catalog-restrictions-filters.php' ) ) {
			require_once( ABSPATH . 'wp-content/plugins/woocommerce-catalog-visibility-options/lib/woocommerce-catalog-restrictions/classes/class-wc-catalog-restrictions-filters.php' );

			// checks if user can purchase
			if ( ! WC_Catalog_Restrictions_Filters::instance()->user_can_purchase( $product ) ) {
				return true;
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

/**
 * Function that gets the product quickview
 *
 * @access public
 * @since 3.0
 * @return html $output | the html of the quickview product
 */
function sp_woo_product_quickview_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	global $woocommerce, $product, $post;
	
	$product_id = absint( $_POST['product_id'] );
	$product_type = sanitize_text_field( $_POST['product_type'] );

	// we need to create the post object here or else we will get
	// non object error when other templates are called
	$post = get_post( $product_id );

	if ( ! isset( $product_id ) )
		die( 'error' );

	// get show badges setting
	$show_new_badge = sp_get_option( 'show_product_new_badge' );
	$show_sale_badge = sp_get_option( 'show_product_sale_badge' );

	// get new badge duration
	$new_badge_duration = sp_get_option( 'product_new_badge_duration' );

	$output = '';

	// get user set image width/height
	$image_width = sp_get_option( 'quickview_width' );
	$image_height = sp_get_option( 'quickview_height' );
	$image_crop = sp_get_option( 'quickview_image_crop' );

	$image = sp_get_image( get_post_thumbnail_id( $product_id ), $image_width, $image_height, $image_crop );
	$image_full = sp_get_image( get_post_thumbnail_id( $product_id ) );

	// get the product object
	$product = get_product( $product_id );

	$output .= '<div class="sp-quickview">' . PHP_EOL;

	$output .= '<article itemscope itemtype="http://schema.org/Product" class="product row clearfix">' . PHP_EOL;
	$output .= '<div class="' . sp_column_css( '', '', '', '5' ) . '">' . PHP_EOL;
	
	$output .= '<h2 class="product-title" itemprop="name"><a href="' . get_permalink( $product->id ) . '" title="' . esc_attr( get_the_title( $product->id ) ) . '" itemprop="url">' . get_the_title( $product->id ) . '</a></h2>' . PHP_EOL;

	$output .= '<div class="image-wrap images" data-product-id="' . esc_attr( $product->id ) . '">' . PHP_EOL;

	$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . esc_attr( get_the_title( $product->id ) ) . '" class="zoom product-image-link" itemprop="image" data-rel="sp-lightbox[' . esc_attr( $product->id ) . ']">' . PHP_EOL;
	$output .= '<img src="' . esc_attr( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" itemprop="image" class="product-image" />' . PHP_EOL;

	$output .= '<i class="icon-resize-full hover-icon" aria-hidden="true"></i>' . PHP_EOL;

	// badges
	if ( $product->is_on_sale() && $show_sale_badge === 'on' ) {
		$output .= '<span class="onsale">' . __( 'SALE!', 'sp-theme' ) . '</span>' . PHP_EOL;
	}

	if ( $show_new_badge === 'on' ) {
		if ( isset( $new_badge_duration ) && ! empty( $new_badge_duration ) ) {
			$product_date = strtotime( $product->post->post_date );
			$current_date = time();
			$duration = 24*60*60*absint( $new_badge_duration );
			
			if ( ( $current_date - $product_date ) < $duration ) {
				$output .= '<span class="new">' . __( 'NEW!', 'sp-theme' ) . '</span>' . PHP_EOL;
			}
		}
	}

	$output .= '</a>' . PHP_EOL;
	
	$output .= '</div><!--close .image-wrap-->' . PHP_EOL;

	ob_start();
	woocommerce_show_product_thumbnails();
	$output .= ob_get_clean();

	$output .= '</div><!--close .column-->' . PHP_EOL;

	$output .= '<div class="' . sp_column_css( '', '', '', '7' ) . '">' . PHP_EOL;

	$output .= '<div class="content-wrap">' . PHP_EOL;

	// check if we need to display star ratings
	if ( sp_get_option( 'product_rating_stars', 'is', 'on' ) )
		$output .= sp_woo_product_rating_html( $product->id ); 

	// excerpt
	$output .= '<div class="excerpt clearfix">' . PHP_EOL;
	$output .= $product->post->post_excerpt;
	$output .= '</div>' . PHP_EOL;

	if ( ! sp_woo_cvo_hide( $product ) ) {
		// display the price
		ob_start();
		woocommerce_template_single_price();
		$output .= ob_get_clean();
	}

	// get add to cart template
	ob_start();
	switch( $product->product_type ) {
		case 'simple' : 
			woocommerce_simple_add_to_cart();
			break;
		
		case 'variable' :
			// overrides the image sizes set by WC
			add_filter( 'woocommerce_available_variation', '_sp_woo_quickview_variation_image_size', 10, 2 );

			woocommerce_variable_add_to_cart();
			break;
									
		case 'grouped' :
			woocommerce_grouped_add_to_cart();
			break;
		
		case 'external' :
			woocommerce_external_add_to_cart();
			break;
	}
	$output .= ob_get_clean();

	$output .= '<input type="hidden" name="product_type" value="' . esc_attr( $product_type ) . '" />';
	$output .= '<input type="hidden" name="product_id" value="' . esc_attr( $product_id ) . '" />';

	$output .= '<div class="action-meta">' . PHP_EOL;
	$output .= sp_woo_product_meta_action_buttons_html( $product_id );
	$output .= '</div><!--close .action-meta-->' . PHP_EOL;

	$output .= '</div><!--close .content-wrap-->' . PHP_EOL;

	$output .= '</div><!--close .column-->' . PHP_EOL;

	// get thumb width
	$image_thumb = get_option( 'shop_thumbnail_image_size' );

	$output .= '<input type="hidden" name="product_thumb_width" value="' . $image_thumb['width'] . '" />';

	// get show slider setting
	$show_slider = sp_get_option( 'product_image_gallery_slider' );

	if ( $show_slider === 'on' )
		$output .= '<input type="hidden" name="product_image_gallery_slider" value="on" />';

	$output .= '<a href="' . get_permalink( $product_id ) . '" title="' . esc_attr__( 'Go to product detail page', 'sp-theme' ) . '" itemprop="url" class="product-detail-link">' . apply_filters( 'sp_woo_go_to_product_detail_text', __( 'Product Detail', 'sp-theme' ) ) . '</a>' . PHP_EOL;

	$output .= '</article><!--close .product-->' . PHP_EOL;

	$output .= '<button class="close-quickview"><i class="icon-remove-circle" aria-hidden="true"></i></button>' . PHP_EOL;
	$output .= '</div><!--close .sp-quickview-->' . PHP_EOL;

	echo $output;
	exit; 
}

/**
 * Function that adds items to wishlist ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | added message
 */
function sp_woo_add_product_wishlist_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$product_id = absint( $_POST['product_id'] );

	$plus_one = 0;

	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

		// sanitize the cookie
		is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;

		if ( is_array( $cookie ) && ! in_array( $product_id, $cookie ) ) {
			array_push( $cookie, $product_id );
		} else {
			$message = __( 'Item is already in your wishlist.', 'sp-theme' );

			echo json_encode( array( 'message' => $message, 'count' => sp_woo_get_wishlist_item_count() ) );
			exit;
		}

	} else {
		$cookie = array( $product_id );
	}

	if ( setcookie( 'sp_product_wishlist', maybe_serialize( $cookie ), apply_filters( 'sp_product_wishlist_cookie_expire_time', time() + 60*60*24*30 ), '/' ) ) {
		$message = __( 'Item added to wishlist.', 'sp-theme' );

		// add one to count as we can't get correct count right after setting cookie
		$plus_one = 1;

	} else {
		$message = __( 'Sorry, unable to add to wishlist.', 'sp-theme' );
	}
	
	echo json_encode( array( 'message' => $message, 'count' => ( sp_woo_get_wishlist_item_count() + $plus_one ) ) );
	exit;
}

/**
 * Function that removes wishlist items ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | message
 */
function sp_woo_remove_product_wishlist_item_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$product_id = absint( $_POST['product_id'] );
	$wishlist_type = sanitize_text_field( $_POST['wishlist_type'] );
	$wishlist_name = stripslashes( sanitize_text_field( $_POST['wishlist_name'] ) );
	$user_id = absint( $_POST['user_id'] );

	$message = '';

	// check wishlist type
	if ( $wishlist_type === 'cookie' ) {
		// check if there is existing cookie
		if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
			$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

			// sanitize the cookie
			is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;

			if ( is_array( $cookie ) && in_array( $product_id, $cookie ) ) {
				if ( ( $key = array_search( $product_id, $cookie ) ) !== false )
					unset( $cookie[$key] );

				// check if array is now empty
				if ( count( $cookie ) <= 0 ) {
					setcookie( 'sp_product_wishlist', '0', time() - 3600, '/' );
					$message = 'empty';
				} else {
					setcookie( 'sp_product_wishlist', maybe_serialize( $cookie ), apply_filters( 'sp_product_wishlist_cookie_expire_time', time() + 60*60*24*30 ), '/' );
				}
			}
		}
	} elseif ( $wishlist_type === 'saved' ) {
		// get saved wishlists
		$saved_wishlists = get_user_meta( $user_id, '_sp_product_wishlist', true );

		if ( isset( $saved_wishlists ) ) {
			// get the wishlist
			$wishlist_ids = $saved_wishlists[$wishlist_name];

			if ( is_array( $wishlist_ids ) && in_array( $product_id, $wishlist_ids ) ) {
				if ( ( $key = array_search( $product_id, $wishlist_ids ) ) !== false )
					unset( $wishlist_ids[$key] );	

				// check if array is now empty
				if ( ! $wishlist_ids ) {
					unset( $saved_wishlists[$wishlist_name] );

					$message = 'empty';
				} else {
					$saved_wishlists[$wishlist_name] = $wishlist_ids;
				}

				// check if there are any wishlist left
				if ( ! $saved_wishlists ) {
					// delete the wishlist from user meta
					delete_user_meta( $user_id, '_sp_product_wishlist' );	

					$message = 'empty';
				} else {
					update_user_meta( $user_id, '_sp_product_wishlist', $saved_wishlists );
				}    						
			}
		}
	}
	
	echo $message;
	exit;
}

/**
 * Function that deletes the wishlist entry ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | added message
 */
function sp_woo_delete_product_wishlist_entry_ajax() {
	global $current_user;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$wishlist_name = sanitize_text_field( $_POST['wishlist_name'] );

	$message = '';

	// check if user is logged in
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();

		// check if user has previous saved wishlists
		$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

		// get account url of the relative ecommerce plugin
		if ( sp_woo_exists() )
			$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id', true ) );

		// check array has elements and wishlist exists
		if ( $saved_wishlists && isset( $saved_wishlists[$wishlist_name] ) ) {
			unset( $saved_wishlists[$wishlist_name] );

			update_user_meta( $current_user->ID, '_sp_product_wishlist', $saved_wishlists );
		}

		// recheck if there are still wishlist entries left if not show message
		if ( ! $saved_wishlists )
			$message .= __( 'There are no items in your wishlist.', 'sp-theme' );
	}

	echo $message;
	exit;
}

/**
 * Function that saves new wishlist to account ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | message
 */
function sp_woo_save_new_product_wishlist_ajax() {
	global $current_user;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$wishlist_name = sanitize_text_field( $_POST['wishlist_name'] );

	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

		// sanitize the cookie
		is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;
	}

	$process = true;
	$message = '';

	// check if user is logged in
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();

		// check if user has previous saved wishlists
		$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

		// get account url of the relative ecommerce plugin
		if ( sp_woo_exists() )
			$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id', true ) );

		// check array has elements
		if ( $saved_wishlists ) {
			// check if list already has same name
			if ( isset( $saved_wishlists[ $wishlist_name ] ) ) {
				$process = false;
				$message = __( 'You already have a wishlist saved by that name.  Please select another name.', 'sp-theme' );
			} else {
				$saved_wishlists[ $wishlist_name ] = $cookie;
				update_user_meta( $current_user->ID, '_sp_product_wishlist', $saved_wishlists );
				$process = true;

				$message = sprintf( __( 'Your wishlist has been saved to your account.  You can view them in', 'sp-theme' ) . ' <a href="' . esc_url( $account_url ) . '" title="' . esc_attr__( 'My Account', 'sp-theme' ) . '">%s</a>.', 'My Account', 'sp-theme' );

				// remove the wishlist cookie
				setcookie( 'sp_product_wishlist', '0', time() - 3600, '/' );				
			}
		} else {
			// make sure cookie is set
			if ( is_array( $cookie ) && isset( $cookie ) ) {
				$new_wishlist = array( $wishlist_name => $cookie );
				update_user_meta( $current_user->ID, '_sp_product_wishlist', $new_wishlist );
				$process = true;				

				$message = sprintf( __( 'Your wishlist has been saved to your account.  You can view them in', 'sp-theme' ) . ' <a href="' . esc_url( $account_url ) . '" title="' . esc_attr__( 'My Account', 'sp-theme' ) . '">%s</a>.', 'My Account', 'sp-theme' );

				// remove the wishlist cookie
				setcookie( 'sp_product_wishlist', '0', time() - 3600, '/' );				
			}
		}
	}

	echo json_encode( array( 'message' => $message, 'process' => $process ) );
	exit;
}

/**
 * Function that saves to existing wishlist to account ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | message
 */
function sp_woo_save_existing_product_wishlist_ajax() {
	global $current_user;

	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$wishlist_name = sanitize_text_field( $_POST['wishlist_name'] );

	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

		// sanitize the cookie
		is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;
	}

	$process = true;
	$message = '';

	// check if user is logged in
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();

		// check if user has previous saved wishlists
		$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

		// get account url of the relative ecommerce plugin
		if ( sp_woo_exists() )
			$account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id', true ) );

		// check array has elements
		if ( $saved_wishlists && isset( $saved_wishlists[$wishlist_name] ) ) {

			// make sure cookie is set
			if ( is_array( $cookie ) && isset( $cookie ) ) {
				// loop through cookie wishlist items
				foreach( $cookie as $product_id ) {
					// if it doesn't already exists
					if ( ! in_array( $product_id, $saved_wishlists[$wishlist_name] ) )
						$saved_wishlists[ $wishlist_name ][] = $product_id;
				}

				update_user_meta( $current_user->ID, '_sp_product_wishlist', $saved_wishlists );

				$message = sprintf( __( 'Your wishlist has been updated to your account.  You can view them in', 'sp-theme' ) . ' <a href="' . esc_url( $account_url ) . '" title="' . esc_attr__( 'My Account', 'sp-theme' ) . '">%s</a>.', 'My Account', 'sp-theme' );

				// remove the wishlist cookie
				setcookie( 'sp_product_wishlist', '0', time() - 3600, '/' );
			}			

		}
	}

	echo json_encode( array( 'message' => $message, 'process' => $process ) );
	exit;
}

/**
 * Function that emails the product wishlist ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | added message
 */
function sp_woo_email_product_wishlist_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'sp_submit_email_product_wishlist_form' ) )
		 die ( 'error' );

	$email = sanitize_email( $_POST['wishlist_email'] );

	$email_subject = sanitize_text_field( $_POST['wishlist_email_subject'] );

	$wishlist_name = isset( $_POST['wishlist_name'] ) ? sanitize_text_field( $_POST['wishlist_name'] ) : '';

	$message = '';

	// if email and subject not set bail
	if ( ! isset( $email ) || ! isset( $email_subject ) ) {
		$message .= __( 'All required fields must be filled out.', 'sp-theme' );

		echo json_encode( array( 'message' => $message, 'proceed' => false ) );
		exit;
	}

	// check if wishlist name is passed
	if ( isset( $wishlist_name ) && ! empty( $wishlist_name ) ) {
		// get products from saved wishlist
		global $current_user;

		// check if user is logged in
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();

			// get the saved wishlists
			$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

			$link = '';

			// check array has elements
			if ( $saved_wishlists && isset( $saved_wishlists[ $wishlist_name ] ) ) {
				foreach( $saved_wishlists[ $wishlist_name ] as $product_id ) {
					// check ecommerce
					if ( sp_woo_exists() ) {
						$product_obj = get_product( $product_id );

						$link .= apply_filters( 'sp_product_wishlist_email_link', $product_obj->post->post_title . ' - ' . get_permalink( $product_obj->post->ID ), $product_obj->post->post_title, $product_obj->post->ID ) . PHP_EOL;
					}
				}
			}			
		}

	} else { 
		// get products from cookie wishlist
		if ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
			$cookie = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

			// sanitize the cookie
			is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;

			$link = '';

			foreach( $cookie as $product_id ) {
				// check ecommerce
				if ( sp_woo_exists() ) {
					$product_obj = get_product( $product_id );

					$link .= apply_filters( 'sp_product_wishlist_email_link', $product_obj->post->post_title . ' - ' . get_permalink( $product_obj->post->ID ), $product_obj->post->post_title, $product_obj->post->ID ) . PHP_EOL;
				}				
			}
		}
	}

	$email_body = apply_filters( 'sp_product_wishlist_email_opening_text', __( 'Have a look at these awesome products from my wishlist.', 'sp-theme' ) ) . PHP_EOL . PHP_EOL;

	// append the product links
	$email_body .= $link;

	$headers = sprintf( __( '%s', 'sp-theme' ) . ' ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <' . apply_filters( 'sp_product_wishlist_email_from', get_bloginfo( 'admin_email' ) ) . '>', 'From:' ) . PHP_EOL;

	// if email sent successfully
	if ( wp_mail( $email, stripslashes( $email_subject ), $email_body, $headers ) ) {
		$message .= __( 'Your wishlist has been emailed!', 'sp-theme' );

		echo json_encode( array( 'message' => $message, 'proceed' => true ) );
		exit;		
	} else {
		$message .= __( 'Sorry, we\'re having issues emailing your wishlist at this time, please try again later.', 'sp-theme' );

		echo json_encode( array( 'message' => $message, 'proceed' => false ) );
		exit;	
	}
}

/**
 * Function that adds items to compare ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | added message
 */
function sp_woo_add_product_compare_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$product_id = absint( $_POST['product_id'] );
	
	$plus_one = 0;
	
	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_compare'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_compare'] );

		// sanitize the cookie
		is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;

		if ( is_array( $cookie ) && ! in_array( $product_id, $cookie ) ) {
			array_push( $cookie, $product_id );

		} else {
			$message = __( 'Item is already in your compare list.', 'sp-theme' );

			echo json_encode( array( 'message' => $message, 'count' => sp_woo_get_compare_item_count() ) );
			exit;
		}

	} else {
		$cookie = array( $product_id );
	}

	if ( setcookie( 'sp_product_compare', maybe_serialize( $cookie ), apply_filters( 'sp_product_compare_cookie_expire_time', time() + 60*60*24*1 ), '/' ) ) {
		$message = __( 'Item added to compare list.', 'sp-theme' );

		// add one to count as we can't get correct count right after setting cookie
		$plus_one = 1;

	} else {
		$message = __( 'Sorry, unable to add this item for compare.', 'sp-theme' );
	}

	echo json_encode( array( 'message' => $message, 'count' => ( sp_woo_get_compare_item_count() + $plus_one ) ) );
	exit;
}

/**
 * Function that removes compare items ajax
 *
 * @access public
 * @since 3.0
 * @return string $message | message
 */
function sp_woo_remove_product_compare_item_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$product_id = absint( $_POST['product_id'] );

	$message = '';

	// check if there is existing cookie
	if ( isset( $_COOKIE['sp_product_compare'] ) ) {
		$cookie = maybe_unserialize( $_COOKIE['sp_product_compare'] );

		// sanitize the cookie
		is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;

		if ( is_array( $cookie ) && in_array( $product_id, $cookie ) ) {
			if ( ( $key = array_search( $product_id, $cookie ) ) !== false )
				unset( $cookie[$key] );

			// check if array is now empty
			if ( count( $cookie ) <= 0 ) {
				setcookie( 'sp_product_compare', '0', time() - 3600, '/' );
				$message = 'empty';
			} else {
				setcookie( 'sp_product_compare', maybe_serialize( $cookie ), apply_filters( 'sp_product_compare_cookie_expire_time', time() + 60*60*24*30 ), '/' );
			}
		}
	}

	echo $message;
	exit;
}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'sp_woo_single_product_image_thumbnails_html', 15, 4 );

/**
 * Function that adds an icon to add to cart text
 *
 * @access public
 * @since 3.0
 * @param html $html | html of the original 
 * @param int $attachment_id | id of the attachment
 * @param int $post_id
 * @param string $image_class | defined classes
 * @return html $output
 */
function sp_woo_single_product_image_thumbnails_html( $html, $attachment_id, $post_id, $image_class ) {
	// get saved settings
	$image_size = get_option( 'shop_thumbnail_image_size' );

	$image_swap = sp_get_option( 'product_image_gallery_swap' );

	$show_gallery = sp_get_option( 'show_product_gallery' );

	if ( $show_gallery !== 'on' )
		return;

	if ( absint( $image_size['crop'] ) === 1 )
		$image_crop = true;
	else
		$image_crop = false;

	$image_thumb = sp_get_image( $attachment_id, $image_size['width'], $image_size['height'], $image_crop );
	$image_full = sp_get_image( $attachment_id );

	$output = '';

	if ( $image_swap === 'on' )
		$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '" class="zoom image-swap" data-attachment-id="' . esc_attr( $attachment_id ) . '" data-product-id="' . esc_attr( $post_id ) . '"><img src="' . esc_url( $image_thumb['url'] ) . '" alt="' . esc_attr( $image_thumb['alt'] ) . '" /><span class="overlay"></span></a>' . PHP_EOL;
	else
		$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '" class="' . esc_attr( $image_class ) . '" data-attachment-id="' . esc_attr( $attachment_id ) . '" data-product-id="' . esc_attr( $post_id ) . '"><img src="' . esc_url( $image_thumb['url'] ) . '" alt="' . esc_attr( $image_thumb['alt'] ) . '" /><span class="overlay"></span></a>' . PHP_EOL;		

	return $output;
}

/**
 * Function that swaps the product image with the gallery image quickview
 *
 * @access public
 * @since 3.0
 * @return html $output 
 */
function sp_woo_product_image_gallery_swap_quickview_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	$attachment_id = absint( $_POST['attachment_id'] );
	$product_id = absint( $_POST['product_id'] );

	$product = get_product( $product_id );

	// get user set image width/height
	$image_width = sp_get_option( 'quickview_width' );
	$image_height = sp_get_option( 'quickview_height' );
	$image_crop = sp_get_option( 'quickview_image_crop' );

	if ( $image_crop === 'on' )
		$image_crop = true;
	else
		$image_crop = false;

	$image_thumb = sp_get_image( $attachment_id, $image_width, $image_height, $image_crop );
	$image_full = sp_get_image( $attachment_id );

	if ( $product->is_on_sale() && sp_get_option( 'show_product_sale_badge' ) === 'on' ) {
		$sale_flash = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'sp-theme' ) . '</span>', $product );
	} else {
		$sale_flash = '';
	}

	$new_badge = '';
	$new_badge_duration = sp_get_option( 'product_new_badge_duration' );

	if ( sp_get_option( 'show_product_new_badge' ) === 'on' ) {
		if ( isset( $new_badge_duration ) && ! empty( $new_badge_duration ) ) {
			$product_date = strtotime( $product->post->post_date );
			$current_date = time();
			$duration = 24*60*60*absint( $new_badge_duration );
			
			if ( ( $current_date - $product_date ) < $duration ) {
				$new_badge .= '<span class="new">' . __( 'NEW!', 'sp-theme' ) . '</span>' . PHP_EOL;
			}
		}
	}

	$output = '';

	$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . esc_attr( get_the_title( $product_id ) ) . '" class="zoom product-image-link" itemprop="image"><img src="' . esc_url( $image_thumb['url'] ) . '" alt="' . esc_attr( $image_thumb['alt'] ) . '" /><i class="icon-resize-full hover-icon" aria-hidden="true"></i>' . $sale_flash . $new_badge . '</a>' . PHP_EOL;

	echo $output;
	exit;
}

/**
 * Function that swaps the product image with the gallery image single
 *
 * @access public
 * @since 3.0
 * @return html $output 
 */
function sp_woo_product_image_gallery_swap_single_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) ) {
		 die ( 'error' );
	}

	$attachment_id = absint( $_POST['attachment_id'] );
	$product_id = absint( $_POST['product_id'] );

	$product = get_product( $product_id );

	$image_size = get_option( 'shop_single_image_size' );

	// get user set image width/height
	$image_width = $image_size['width'];
	$image_height = $image_size['height'];
	$image_crop = $image_size['crop'];

	if ( $image_crop === 'on' ) {
		$image_crop = true;
	} else {
		$image_crop = false;
	}

	$image_thumb = sp_get_image( $attachment_id, $image_width, $image_height, (bool) $image_crop );
	$image_full = sp_get_image( $attachment_id );

	if ( $product->is_on_sale() && sp_get_option( 'show_product_sale_badge' ) === 'on' ) {
		$sale_flash = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'sp-theme' ) . '</span>', $product );
	} else {
		$sale_flash = '';
	}

	$new_badge = '';
	$new_badge_duration = sp_get_option( 'product_new_badge_duration' );

	if ( sp_get_option( 'show_product_new_badge' ) === 'on' ) {
		if ( isset( $new_badge_duration ) && ! empty( $new_badge_duration ) ) {
			$product_date = strtotime( $product->post->post_date );
			$current_date = time();
			$duration = 24*60*60*absint( $new_badge_duration );
			
			if ( ( $current_date - $product_date ) < $duration ) {
				$new_badge .= '<span class="new">' . __( 'NEW!', 'sp-theme' ) . '</span>' . PHP_EOL;
			}
		}
	}

	$output = '';

	$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . esc_attr( get_the_title( $product_id ) ) . '" class="zoom product-image-link" itemprop="image"><img src="' . esc_url( $image_thumb['url'] ) . '" alt="' . esc_attr( $image_thumb['alt'] ) . '" /><i class="icon-resize-full hover-icon" aria-hidden="true"></i>' . $sale_flash . $new_badge . '</a>' . PHP_EOL;

	echo $output;
	exit;
}

/**
 * Function that displays star rating
 *
 * @access public
 * @since 3.0
 * @param int $product_id
 * @param string $icon_class | name of the icon
 * @return $output html
 */
function sp_woo_product_rating_html( $product_id = '', $icon_class = 'icon-star' ) {
	if ( empty( $product_id ) )
		return;

	// get the comments of product
	$comments = get_comments( array( 'post_id' => absint( $product_id ), 'status' => 'approve', 'meta_key' => 'rating' ) );

	$ratings = array();
	$total = 0;

	if ( is_array( $comments ) ) {
		foreach( $comments as $comment ) {
			$ratings[] = absint( $comment->meta_value );
			$total += absint( $comment->meta_value );
		}
	}

	// bail if no ratings
	if ( count( $ratings )  <= 0 )
		return '';
	
	$avg_rating = round( $total / count( $ratings ), 0 );

	$output = '';

	$output .= '<div class="product-rating-stars">' . PHP_EOL;

	for ( $i = 1; $i <= 5; $i++ ) {
		if ( $avg_rating / $i >=  1 )
			$active = 'active';
		else
			$active = '';

		$output .= '<i class="' . esc_attr( $icon_class ) . ' ' . esc_attr( $active ) . '" aria-hidden="true"></i>' . PHP_EOL;
	}

	$output .= '</div><!--close product-rating-stars-->' . PHP_EOL;

	return $output;
}

add_action( 'woocommerce_before_checkout_form', 'sp_woo_checkout_additional_info' );

/**
 * Function that displays additional info on checkout page
 *
 * @access public
 * @since 3.0
 * @todo fix the double stripslashes
 * @return $output html
 */
function sp_woo_checkout_additional_info() {
	// get saved settings
	$show_additional_info = sp_get_option( 'show_checkout_additional_info' );
	$additional_info_text = sp_get_option( 'checkout_text_info' );
	$links = sp_get_option( 'checkout_add_links' ); // array

	// if off or not set bail
	if ( $show_additional_info === 'off' || ! isset( $show_additional_info ) )
		return;

	$output = '';

	$output .= '<div class="checkout-additional-info row">' . PHP_EOL;
	
	$output .= '<div class="' . sp_column_css( '12', '', '', '6' ) . '">' . PHP_EOL;

	if ( isset( $additional_info_text ) && ! empty( $additional_info_text ) ) {
		
		$output .= $additional_info_text;
		
	}
	
	$output .= '</div><!--close .column-->' . PHP_EOL;

	if ( is_array( $links ) && $links ) {
		$i = 0;

		$output .= '<div class="clearfix links-column ' . sp_column_css( '12', '', '', '6' ) . '">' . PHP_EOL;
		$output .= '<ul class="clearfix">' . PHP_EOL;

		foreach( $links['link_name'] as $link ) {
			$output .= '<li class="info-link">' . PHP_EOL;
			$output .= '<a href="#content-info-' . esc_attr( $i ) . '" title="' . esc_attr( stripslashes( stripslashes( $link ) ) ) . '" class="mfp-link">' . stripslashes( stripslashes( $link ) ) . '</a>' . PHP_EOL;
			$output .= '<div class="content" id="content-info-' . esc_attr( $i ) . '">' . PHP_EOL;
			$output .= do_shortcode( stripslashes( stripslashes( wpautop( $links['link_content'][ $i ] ) ) ) ) . PHP_EOL;
			$output .= '</div><!--close .content-->' . PHP_EOL;
			$output .= '</li>' . PHP_EOL;

			$i++;
		}

		$output .= '</ul>' . PHP_EOL;
		$output .= '</div><!--close .column-->' . PHP_EOL;
	}

	$output .= '</div><!--close .checkout-additional-info-->' . PHP_EOL;

	echo $output;
}

add_filter( 'woocommerce_general_settings', '_sp_woo_change_general_settings' );

/**
 * Function that changes the woocommerce plugin general settings like adding and removing settings
 *
 * @access private
 * @since 3.0
 * @param array $settings
 * @return array $settings
 */
function _sp_woo_change_general_settings( $settings ) {
	foreach( $settings as $arr => $setting ) {
		// remove the script and styling option title
		//if ( isset( $setting['id'] ) && $setting['id'] === 'script_styling_options' )
			//unset( $settings[$arr] );

		// remove enable woocommerce css
		if ( isset( $setting['id'] ) && $setting['id'] === 'woocommerce_frontend_css' )
			unset( $settings[$arr] );

		// remove frontend styles display
		if ( isset( $setting['type'] ) && $setting['type'] === 'frontend_styles' )
			unset( $settings[$arr] );

		// remove lightbox setting
		if ( isset( $setting['id'] ) && $setting['id'] === 'woocommerce_enable_lightbox' )
			unset( $settings[$arr] );

		// remove country state js for dropdowns
		//if ( isset( $setting['id'] ) && $setting['id'] === 'woocommerce_enable_chosen' )
			//unset( $settings[$arr] );
	}

	return $settings;
}

add_action( 'woocommerce_after_order_notes', 'sp_woo_checkout_show_review_order_link' );

/**
 * Function that displays the continue to review order link on checkout
 *
 * @access private
 * @since 3.0
 * @param array $checkout
 * @return html $output
 */
function sp_woo_checkout_show_review_order_link( $checkout ) {
	if ( sp_get_option( 'checkout_3_step', 'is', 'off' ) ) {
		return;
	}
	
	$output = '';

	$output .= '<p class="goto-review-wrap"><a href="#" class="goto-review button" title="' . esc_attr__( 'Review Order', 'sp-theme' ) . '">' . __( 'Review Order', 'sp-theme' ) . '</a></p>' . PHP_EOL;

	echo $output;
}

/**
 * Function that builds compare button link
 *
 * @access public
 * @since 3.0
 * @param int $product_id | id of the product
 * @return mixed html $output
 */	
function sp_compare_button_html( $product_id ) {
	// get saved cookies
	$compare_cookie = isset( $_COOKIE['sp_product_compare'] ) ? maybe_unserialize( $_COOKIE['sp_product_compare'] ) : '';

	// sanitize the cookie
	is_array( $compare_cookie ) ? array_walk_recursive( $compare_cookie, 'sp_clean_multi_array' ) : null;

	// match product to cookie
	if ( is_array( $compare_cookie ) && in_array( $product_id, $compare_cookie ) )
		$compare_class = 'added';
	else
		$compare_class = '';

	$output = '';

	$output .= apply_filters( 'sp_compare_button_link_html', '<a href="#" class="sp-tooltip compare-button ' . esc_attr( $compare_class ) . '" title="' . esc_attr__( 'Add to Compare', 'sp-theme' ) . '" data-toggle="tooltip" data-placement="top"><i class="icon-cog" aria-hidden="true"></i><span class="text">' . __( 'Compare', 'sp-theme' ) . '</span></a>' ) . PHP_EOL;

	return $output;
}

/**
 * Function that builds wishlist button link
 *
 * @access public
 * @since 3.0
 * @param int $product_id | id of the product
 * @return mixed html $output
 */	
function sp_wishlist_button_html( $product_id ) {
	// get saved cookies
	$wishlist_cookie = isset( $_COOKIE['sp_product_wishlist'] ) ? maybe_unserialize( $_COOKIE['sp_product_wishlist'] ) : '';

	// sanitize the cookie
	is_array( $wishlist_cookie ) ? array_walk_recursive( $wishlist_cookie, 'sp_clean_multi_array' ) : null;

	// match product to cookie
	if ( is_array( $wishlist_cookie ) && in_array( $product_id, $wishlist_cookie ) )
		$wishlist_class = 'added';
	else
		$wishlist_class = '';

	$output = '';

	$output .= apply_filters( 'sp_wishlist_button_link_html', '<a href="#" class="sp-tooltip wishlist-button ' . esc_attr( $wishlist_class ) . '" title="' . __( 'Add to Wishlist', 'sp-theme' ) . '" data-toggle="tooltip" data-placement="top"><i class="icon-star" aria-hidden="true"></i><span class="text">' . __( 'Wishlist', 'sp-theme' ) . '</span></a>' ) . PHP_EOL;

	return $output;
}

/**
 * Function that gets the order detail for my account
 *
 * @access public
 * @since 3.0
 * @return mixed html $output
 */	
function sp_woo_view_order_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );	
	
	$order_id = absint( $_POST['order_id'] );

	$output = '';

	$output .= '<div class="order-detail-popup clearfix">' . PHP_EOL;

	ob_start();
	wc_get_template( 'order/order-details-full.php', array(
			'order_id' => $order_id
		) );
	$output .= ob_get_clean();

	$output .= '</div><!--close .order-detail-popup-->' . PHP_EOL;
	
	echo $output;
}

/**
 * Function that edit the addresses
 *
 * @access public
 * @since 3.0
 * @return mixed html $output
 */	
function sp_woo_edit_address_ajax() {
	$nonce = $_POST['ajaxCustomNonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, '_sp_nonce' ) )
		 die ( 'error' );

	global $woocommerce;

	if ( ! is_user_logged_in() ) return;

	$address_type = sanitize_text_field( $_POST['type'] );

	$address = WC()->countries->get_address_fields( get_user_meta( get_current_user_id(), $address_type . '_country', true ), $address_type . '_' );

	$output = '';

	$output .= '<div class="edit-address-popup clearfix">' . PHP_EOL;

	ob_start();
	wc_get_template( 'myaccount/form-edit-address.php', array(
			'load_address' 	=> $address_type,
			'address'		=> apply_filters( 'woocommerce_address_to_edit', $address )
		) );
	$output .= ob_get_clean();

	$output .= '</div><!--close .edit-address-popup-->' . PHP_EOL;
	
	echo $output;	 
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

if ( sp_get_option( 'show_product_ordering', 'is', 'on' ) )
	add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'sp_woo_before_main_content_below_header', 'sp_woo_page_top_widget' );

/**
 * Function that adds widget areas to woocommerce page top
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_woo_page_top_widget() {
	global $post;

	echo '<aside id="sidebar-woo-page-top" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom WOO category widgets
	/////////////////////////////////////////////////////		
	// check if WOO is active
	if ( sp_woo_exists() ) {
		if ( is_object( $post ) && sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {

			// get the product category ids
			$cat_ids = sp_get_option( 'custom_product_category_widget' );

			// loop through the ids and output each widget
			foreach( $cat_ids as $cat ) {
				// checks if it is an array before continuing
				if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
						dynamic_sidebar( 'page-top-product-category-' . $cat );	
				}
			}
		}
	}

	echo '</div><!--close .container-->' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

add_action( 'sp_woo_after_main_content_container', 'sp_woo_page_bottom_widget' );

/**
 * Function that adds widget areas to woocommerce page bottom
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_woo_page_bottom_widget() {
	global $post;

	echo '<aside id="sidebar-woo-page-bottom" class="sidebar hidden-print">';
	echo '<div class="widget-wrapper container">';

	/////////////////////////////////////////////////////
	// custom WOO category widgets
	/////////////////////////////////////////////////////		
	// check if WOO is active
	if ( sp_woo_exists() ) {
		if ( is_object( $post ) && sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {

			// get the product category ids
			$cat_ids = sp_get_option( 'custom_product_category_widget' );

			// loop through the ids and output each widget
			foreach( $cat_ids as $cat ) {
				// checks if it is an array before continuing
				if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
					dynamic_sidebar( 'page-bottom-product-category-' . $cat );	
				}
			}
		}
	}

	echo '</div><!--close .container-->' . PHP_EOL;
	echo '</aside>' . PHP_EOL;
}

/**
 * Function that handles the edit account ajax
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_woo_edit_account_ajax() {
	// bail if form data is not posted
	if ( ! isset( $_POST['form_items'] ) ) {
		echo 'error';
		exit;
	}

	parse_str( $_POST['form_items'], $form_data );

	// sanitize the array db insert
	array_walk_recursive( $form_data, 'sp_clean_multi_array' );

	$nonce = $form_data['_save_account_details_nonce'];

	// bail if nonce don't check out
	if ( ! wp_verify_nonce( $nonce, 'save_account_details' ) )
	     die ( 'error' );

	$error_msg = array();
	$proceed = true;

	$account_id = absint( $form_data['account_id'] );

	// get account
	$user = get_userdata( $account_id );

	// get user email
	$user_email = $user->user_email;

	if ( isset( $form_data['account_first_name'] ) && $form_data['account_first_name'] !== '' && strlen( $form_data['account_first_name'] ) < 2 ) {
		$error_msg['account_first_name'] = apply_filters( 'sp_woo_edit_account_too_short_msg', __( 'Sorry, your first name is too short.  Please enter at least 2 characters.', 'sp-theme' ) );

		$proceed = false;			
	}

	if ( isset( $form_data['account_last_name'] ) && $form_data['account_last_name'] !== '' && strlen( $form_data['account_last_name'] ) < 2 ) {
		$error_msg['account_last_name'] = apply_filters( 'sp_woo_edit_account_too_short_msg', __( 'Sorry, your last name is too short.  Please enter at least 2 characters.', 'sp-theme' ) );

		$proceed = false;			
	}

	// if email is not valid log
	if ( isset( $form_data['account_email'] ) && $form_data['account_email'] !== '' && $form_data['account_email'] !== $user_email ) {
		// if not a valid email
		if ( ! is_email( $form_data['account_email'] ) ) {
			$error_msg['account_email'] = apply_filters( 'sp_woo_edit_account_non_valid_email_msg', __( 'Sorry, you must enter a valid email.', 'sp-theme' ) );

			$proceed = false;
		}

		// if email exists log
		if ( email_exists( $form_data['account_email'] ) ) {
			$error_msg['account_email'] = apply_filters( 'sp_woo_edit_account_email_exists_msg', __( 'Sorry, this email address already exists.', 'sp-theme' ) );

			$proceed = false;
		}
	}
	
	if ( $proceed ) {

		// proceed to update user
		if ( $user ) {
			// update firstname if set
			if ( isset( $form_data['account_first_name'] ) && ! empty( $form_data['account_first_name'] ) )
				update_user_meta( $account_id, 'first_name', $form_data['account_first_name'] );

			// update lastname if set
			if ( isset( $form_data['account_last_name'] ) && ! empty( $form_data['account_last_name'] ) )
				update_user_meta( $account_id, 'last_name', $form_data['account_last_name'] );
		
			// update email if set
			if ( isset( $form_data['account_email'] ) && ! empty( $form_data['account_email'] ) )
				wp_update_user( array( 'ID' => $account_id, 'user_email' => $form_data['account_email'] ) );

			// update display name if set
			if ( isset( $form_data['account_first_name'] ) && ! empty( $form_data['account_first_name'] ) )
				wp_update_user( array( 'ID' => $account_id, 'display_name' => $form_data['account_first_name'] ) );

			echo json_encode( array( 'success_msg' => apply_filters( 'sp_woo_edit_account_success_msg', __( 'Your information has been updated.', 'sp-theme' ) ) ) );
			exit;			

		} else {
			$output = array( 'error_msg' => apply_filters( 'sp_woo_edit_account_failed_msg', __( 'Sorry, we cannot perform your request at this time.  Please try back later.', 'sp-theme' ) ) );
			echo json_encode( $output );
			exit;		
		}
	} else {
		echo json_encode( array( 'error_msg' => $error_msg ) );
		exit;
	}
}

/**
 * Function to check if product add on extension is active
 *
 * @access public
 * @since 3.0.1
 * @return bool
 */
function sp_is_product_add_ons() {
	return class_exists( 'Product_Addon_Cart' ) ? true : false;
}

/**
 * Function to check if product has add ons and is required
 *
 * @access public
 * @since 3.0.1
 * @param int $product_id
 * @return bool
 */
function sp_has_product_add_ons( $product_id ) {
	if ( sp_is_product_add_ons() ) {
		$addons = get_product_addons( $product_id );

		if ( $addons && ! empty( $addons ) ) {
			foreach ( $addons as $addon ) {
				if ( '1' == $addon['required'] ) {
					return true;
				}
			}
		}

		return false;
	}

	return false;
}