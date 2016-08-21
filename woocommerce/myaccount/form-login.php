<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
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