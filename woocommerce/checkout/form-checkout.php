<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

wc_print_notices();

$show_billing = 'display:block;';

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	//echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'sp-theme' ) );
	//return;
}

if ( sp_get_option( 'checkout_3_step', 'is', 'on' ) || ! sp_get_option( 'checkout_3_step', 'isset' ) ) {
	$checkout_flow = 'checkout-3-step-on';
} else {
	$checkout_flow = 'checkout-3-step-off';
}

if ( apply_filters( 'sp_woo_checkout_enable_login', true ) ) {
	if ( sp_get_option( 'checkout_3_step', 'is', 'on' ) || ! sp_get_option( 'checkout_3_step', 'isset' ) ) {
		$show_billing = 'display:none;';
	}
?>
<div class="signin-section row">
	<?php
	// check if user is not logged in
	if ( ! is_user_logged_in() ) {
	?>
		<div class="checkout-signin row">
			<?php if ( $checkout->enable_guest_checkout ) { ?>
				<div class="<?php echo esc_attr( sp_column_css( '', '', '', '6' ) ); ?>">
					<?php echo do_shortcode( '[sp-login custom_class="checkout-login" redirect_to="' . WC()->cart->get_checkout_url() . '" title="' . apply_filters( 'sp_woo_checkout_login_title_text', __( 'I already have an account', 'sp-theme' ) ) . '"]' ); ?>
				</div><!--close .column-->

				<div class="<?php echo esc_attr( sp_column_css( '', '', '', '6' ) ); ?>">
						<h3><span><?php _e( 'I\'m New Here', 'sp-theme' ); ?></span></h3>
						<h3 class="msg"><?php echo apply_filters( 'sp_woo_checkout_guest_message', __( ' Please continue with guest checkout.', 'sp-theme' ) ); ?></h3><a href="#" class="goto-billing button <?php esc_attr_e( $checkout_flow ); ?>"><?php _e( 'Continue', 'sp-theme' ); ?></a>
				</div><!--close .column-->
			<?php } else { ?>
				<div class="<?php echo esc_attr( sp_column_css( '', '', '', '12' ) ); ?>">
					<?php echo do_shortcode( '[sp-login custom_class="checkout-login" redirect_to="' . WC()->cart->get_checkout_url() . '" title="' . apply_filters( 'sp_woo_checkout_login_title_text', __( 'I already have an account', 'sp-theme' ) ) . '"]' ); ?>
				</div><!--close .column-->
			<?php } ?>

		</div><!--close .checkout-signin-->
	<?php
	} else {
	?>
		<h3 class="msg"><?php echo apply_filters( 'sp_woo_checkout_logged_in_message', __( ' Great!  You are already logged in.  Please continue your checkout process.', 'sp-theme' ) ); ?></h3><a href="#" class="goto-billing button <?php esc_attr_e( $checkout_flow ); ?>"><?php _e( 'Continue', 'sp-theme' ); ?></a>
	<?php
	}	
	?>
</div><!--close .signin-section-->
<?php } ?>

<?php
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
		<div class="billing-form-section row <?php esc_attr_e( $checkout_flow ); ?>" style="<?php echo esc_attr( $show_billing ); ?>">

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>" id="customer_details">

			<?php do_action( 'woocommerce_checkout_billing' ); ?>

			</div><!--close .column-->


			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

			</div><!--close .column-->

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		</div><!--close .billing-form-section-->

	<?php endif; ?>
	
	<div class="review-section row <?php esc_attr_e( $checkout_flow ); ?>">
		<div class="<?php echo sp_column_css( '', '', '', '12' ); ?>">
			<h3 id="order_review_heading"><span><?php _e( 'Your order', 'sp-theme' ); ?></span></h3>

			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div><!--close .column-->
	</div><!--close .review-section-->
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>