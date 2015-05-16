<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<span class="arrow-shadow"></span>
<span class="arrow"></span>
<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

		<?php 
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				?>

				<li class="clearfix">
					<div class="column-1">
						<a href="<?php echo get_permalink( $product_id ); ?>" class="image-link">

							<?php echo $_product->get_image( apply_filters( 'sp_mini_cart_image_size', array( sp_get_theme_init_setting( 'woo_mini_cart_image_size', 'width' ), sp_get_theme_init_setting( 'woo_mini_cart_image_size', 'height' ) ) ) ); ?>
						</a>
					</div><!--close .column-1-->

					<div class="column-2">
						<a href="<?php echo get_permalink( $product_id ); ?>" class="title-link">

							<?php echo $product_name; ?>

						</a>

						<?php echo WC()->cart->get_item_data( $cart_item ); ?>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>				
					</div><!--close .column-2-->

					<div class="column-3">
						<i class="remove-item icon-remove-circle" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-hidden="true"></i>
					</div><!--close .column-3-->
				</li>
				<?php 
			}
		endforeach;

	else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'sp-theme' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

	<p class="total"><strong><?php _e( 'Subtotal', 'sp-theme' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons">
		<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="button view-cart"><?php _e( 'View Cart', 'sp-theme' ); ?> <i class="icon-angle-right"></i></a>
		<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="button checkout"><?php _e( 'Checkout', 'sp-theme' ); ?> <i class="icon-angle-right"></i></a>
	</p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
