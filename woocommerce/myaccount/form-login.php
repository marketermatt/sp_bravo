<?php
/**
 * Login Form
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="row myaccount-login">
	<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">
		<?php echo do_shortcode( '[sp-login redirect_to="' . apply_filters( 'sp_woocommerce_my_account_login_redirect', wc_customer_edit_account_url() ) . '"]' ); ?>
	</div><!--close .column-->

	<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">
		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<?php echo do_shortcode( '[sp-register]' ); ?>
		<?php endif; ?>
	</div><!--close .column-->
</div><!--close .row-->

<?php endif; ?>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>