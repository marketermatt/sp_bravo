<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div id="order_review" class="clearfix">
	
	<div class="shop-table-container">
		<table class="shop_table">
			<thead>
				<tr>
					<th class="product-image"></th>
					<th class="product-name"><?php _e( 'Product', 'sp-theme' ); ?></th>
					<th class="product-unit-price"><?php _e( 'Unit Price', 'sp-theme' ); ?></th>
					<th class="product-quantity"><?php _e( 'Quantity', 'sp-theme' ); ?></th>
					<th class="product-subtotal"><?php _e( 'Subtotal', 'sp-theme' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
					do_action( 'woocommerce_review_order_before_cart_contents' );

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$image = sp_get_image( get_post_thumbnail_id( $_product->id ), 60, 60, true );

						$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
						
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							?>
							<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
								<td class="product-image"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" /></td>
								<td class="product-name">
									<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?>
									
									<?php echo WC()->cart->get_item_data( $cart_item ); ?>
								</td>
								<td class="product-price">
									<?php echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key ); ?>
								</td>
								<td class="product-quantity">
									<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
								</td>
								<td class="product-total">
									<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
								</td>
							</tr>
							<?php
						}
					}

					do_action( 'woocommerce_review_order_after_cart_contents' );
				?>
			</tbody>
		</table>
	</div><!--close .shop-table-container-->

	<div class="row">
		<div class="<?php echo sp_column_css( '12', '7', '8', '8' ); ?>">
			<?php
			// get saved values
			$image_upload = sp_get_option( 'checkout_secured_image' );
			$ssl_seal = sp_get_option( 'checkout_secured_code' );			 
			$show_ssl_seal = sp_get_option( 'checkout_show_ssl' );
			if($show_ssl_seal=='yes')
			{

			if ( isset( $ssl_seal ) && ! empty( $ssl_seal ) ) {
			?>
				<div class="checkout-ssl-seal">
					<?php echo apply_filters( 'sp_woo_checkout_secure_icon', '<p class="lock"><i class="icon-locked" aria-hidden="true"></i> ' . __( 'SECURED CHECKOUT', 'sp-theme' ) ) . '</p>'; ?>
					<?php echo $ssl_seal; ?>
				</div><!--close .checkout-ssl-seal-->
			<?php
			} else {
				if ( isset( $image_upload ) && ! empty( $image_upload ) )
					// check for ssl
					if ( is_ssl() )
						$image_upload = str_replace( 'http', 'https', $image_upload );
				?>
					<div class="checkout-ssl-seal">
						<?php echo apply_filters( 'sp_woo_checkout_secure_icon', '<p class="lock"><i class="icon-locked" aria-hidden="true"></i> ' . __( 'SECURED CHECKOUT', 'sp-theme' ) ) . '</p>'; ?>
						<img src="<?php echo esc_url( $image_upload ); ?>" alt="<?php esc_attr_e( 'SSL SEAL', 'sp-theme' ); ?>" />
					</div><!--close .checkout-ssl-seal-->
			<?php
			}
			} // if closed 
			?>
		</div><!--close .column-->

		<div class="summary-column <?php echo sp_column_css( '12', '5', '4', '4' ); ?>">
			<table class="summary">
				<tr class="cart-subtotal">
					<th><?php _e( 'Cart Subtotal', 'sp-theme' ); ?></th>
					<td><?php wc_cart_totals_subtotal_html(); ?></td>
				</tr>

				<?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
					<tr class="discount cart-discount coupon-<?php echo esc_attr( $code ); ?>">
						<th><?php echo esc_html( $code ); ?></th>
						<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

					<?php do_action('woocommerce_review_order_before_shipping'); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action('woocommerce_review_order_after_shipping'); ?>

				<?php endif; ?>

				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>

					<tr class="fee">
						<th><?php echo esc_html( $fee->name ); ?></th>
						<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
					</tr>

				<?php endforeach; ?>

				<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
					<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
							<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
								<th><?php echo esc_html( $tax->label ); ?></th>
								<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr class="tax-total">
							<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
							<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>

				<?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
					<tr class="order-discount coupon-<?php echo esc_attr( $code ); ?>">
						<th><?php echo esc_html( $code ); ?></th>
						<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

				<tr class="total order-total">
					<th><strong><?php _e( 'Order Total', 'sp-theme' ); ?></strong></th>
					<td><?php wc_cart_totals_order_total_html(); ?></td>
				</tr>

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
			</table>
		</div><!--close .column-->
	</div><!--close .row-->
