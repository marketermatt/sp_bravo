<?php
/**
 * Edit address form
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
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