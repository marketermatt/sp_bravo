<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
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
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_review_order_before_payment' ); ?>

	<div id="payment" class="woocommerce-checkout-payment">
		<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="payment_methods methods">
			<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
				} else {
					if ( ! WC()->customer->get_country() ) {
						$no_gateways_message = __( 'Please fill in your details above to see available payment methods.', 'sp-theme' );
					} else {
						$no_gateways_message = __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'sp-theme' );
					}

					echo '<p>' . apply_filters( 'woocommerce_no_available_payment_methods_message', $no_gateways_message ) . '</p>';
				}
			?>
		</ul>
		<?php endif; ?>

		<div class="form-row place-order">

			<noscript><?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'sp-theme' ); ?><br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php _e( 'Update totals', 'sp-theme' ); ?>" /></noscript>

			<?php wp_nonce_field( 'woocommerce-process_checkout'); ?>

			<?php do_action( 'woocommerce_review_order_before_submit' ); ?>
			
			<div class="clearfix">
				<div class="pull-right">
				<?php
				$order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'sp-theme' ) );

				echo apply_filters('woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' );
				?>
					
				</div><!--close .column-->

				<div class="pull-right">

			<?php if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) { 

				?>
				<p class="form-row terms">
					<label for="terms" class="checkbox"><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'sp-theme' ), esc_url( get_permalink( wc_get_page_id( 'terms' ) ) ) ); ?></label>
					<input type="checkbox" class="input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />
				</p>
			<?php } ?>
				
				<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
				</div><!--close .column-->


			</div><!--close .row-->
		</div>

		<div class="clear"></div>

	</div>
</div><!--close #order_review-->	
	<?php do_action( 'woocommerce_review_order_after_payment' ); ?>
