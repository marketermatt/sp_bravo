<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

global $woocommerce, $current_user;

$page_title = ( $load_address == 'billing' ) ? __( 'Billing Address', 'sp-theme' ) : __( 'Shipping Address', 'sp-theme' );

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<?php sp_woo_checkout_additional_info(); ?>
<div class="row edit-address">
	
	<div class="<?php echo sp_column_css( '', '', '', '3' ); ?>">
		<nav class="account-nav">
			<h3><span><?php _e( 'My Account', 'sp-theme' ); ?></span></h3>
			<ul>
				<li><a href="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ); ?>" title="<?php esc_attr_e( 'Back to My Account', 'sp-theme' ); ?>" class="edit-address-link"><i class="icon-angle-left" aria-hidden="true"></i><?php _e( 'Back to My Account', 'sp-theme' ); ?></a></li>
			</ul>
		</nav>
	</div><!--close .column-->

	<div class="<?php echo sp_column_css( '', '', '', '9' ); ?>">

		<?php if ( ! $load_address) : ?>

			<?php wc_get_template('myaccount/my-address.php'); ?>

		<?php else : ?>

			<form method="post">

				<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>

				<?php foreach ( $address as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

				<?php endforeach; ?>

				<p>
					<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'sp-theme' ); ?>" />
					<?php wp_nonce_field('edit_address'); ?>
					<input type="hidden" name="action" value="edit_address" />
				</p>

			</form>

		<?php endif; ?>
	</div><!--close .column-->
</div><!--close .row-->		