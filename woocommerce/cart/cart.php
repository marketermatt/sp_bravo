<?php
/**
 * Cart Page
 *
 * actual version 2.3.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 
?>

<div class="row">
	<div class="<?php echo sp_column_css( '', '', '', '9' ); ?>">
		<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			<div class="shop-table-container">
				<table class="shop_table cart">
					<thead>
						<tr>
							<th class="product-remove">&nbsp;</th>
							<th class="product-thumbnail">&nbsp;</th>
							<th class="product-name"><?php _e( 'Product', 'sp-theme' ); ?></th>
							<th class="product-price"><?php _e( 'Price', 'sp-theme' ); ?></th>
							<th class="product-quantity"><?php _e( 'Quantity', 'sp-theme' ); ?></th>
							<th class="product-subtotal"><?php _e( 'Total', 'sp-theme' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								?>
								<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<td class="product-remove">
										<?php
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'sp-theme' ) ), $cart_item_key );
										?>
									</td>

									<td class="product-thumbnail">
										<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $_product->is_visible() )
												echo $thumbnail;
											else
												printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
										?>
									</td>

									<td class="product-name">
										<?php
											if ( ! $_product->is_visible() )
												echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
											else
												echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

											// Meta data
											echo WC()->cart->get_item_data( $cart_item );

				               				// Backorder notification
				               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
				               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'sp-theme' ) . '</p>';
										?>
									</td>

									<td class="product-price">
										<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										?>
									</td>

									<td class="product-quantity">
										<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input( array(
													'input_name'  => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
												), $_product, false );
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
										?>
									</td>

									<td class="product-subtotal">
										<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
										?>
									</td>
								</tr>
								<?php
							}
						}

						do_action( 'woocommerce_cart_contents' );

						?>
						<tr class="update">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'sp-theme' ); ?>" />
							</td>
							<td></td>
						</tr>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</tbody>
				</table>
			</div><!--close .shop-table-container-->
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
			
			<div class="shipping-action clearfix">
				<div class="<?php echo sp_column_css( '', '', '', '8' ); ?>">
					<?php woocommerce_shipping_calculator(); ?>
				</div><!--close .column-->

				<div class="<?php echo sp_column_css( '', '', '', '4' ); ?>">
					<?php if ( WC()->cart->coupons_enabled() ) { ?>
						<div class="coupon">
							<h3><span><?php _e( 'Enter a Coupon', 'sp-theme' ); ?></span></h3>
							<input name="coupon_code" class="input-text form-control" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /><br />
							<input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'sp-theme' ); ?>" />

							<?php do_action( 'woocommerce_cart_coupon' ); ?>

						</div>
					<?php } ?>

				</div><!--close .column-->			
			
			</div><!--close .row-->
			
			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		</form>

	</div><!--close .column-->

	<div class="<?php echo sp_column_css( '', '', '', '3' ); ?>">
		<div class="cart-collaterals">

			<?php do_action( 'woocommerce_cart_collaterals' ); ?>

			<?php woocommerce_cart_totals(); ?>

			<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
				
				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</form>

		</div><!--close .cart-collaterals-->	
	</div><!--close .column-->
</div><!--close .row-->

<div class="row">
	<div class="<?php echo sp_column_css( '', '', '', '12' ); ?>">
		<?php do_action( 'woocommerce_cross_sell_section' ); ?>
	</div><!--close .column-->
</div><!--close .row-->

<?php do_action( 'woocommerce_after_cart' ); ?>
