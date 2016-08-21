<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<div class="edit-account">

	<form action="#" method="post" class="edit-account-form">
		<h3><span><?php _e( 'Edit Account', 'sp-theme' ); ?></span></h3>

		<div class="form-group">
			<label for="account_first_name" class="field-label control-label"><?php _e( 'First name', 'sp-theme' ); ?> <span class="required">*</span></label>
			<div class="controls">
			<input type="text" class="input-text form-control" name="account_first_name" id="account_first_name" value="<?php esc_attr_e( $current_user->first_name ); ?>" data-required="required" tabindex="1" />
			</div><!--close .controls-->
			<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>
		</div><!--close .form-group-->

		<div class="form-group">
			<label for="account_last_name" class="field-label control-label"><?php _e( 'Last name', 'sp-theme' ); ?> <span class="required">*</span></label>
			<div class="controls">
			<input type="text" class="input-text form-control" name="account_last_name" id="account_last_name" value="<?php esc_attr_e( $current_user->last_name ); ?>" data-required="required" tabindex="2" />
			</div><!--close .controls-->
			<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>
		</div><!--close .form-group-->

		<div class="form-group">
			<label for="account_email" class="field-label control-label"><?php _e( 'Email address', 'sp-theme' ); ?> <span class="required">*</span></label>
			<div class="controls">
			<input type="email" class="input-text form-control" name="account_email" id="account_email" value="<?php esc_attr_e( $current_user->user_email ); ?>" data-required="required" tabindex="3" />
			</div><!--close .controls-->
			<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>
		</div><!--close .form-group-->
		
		<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>

		<div class="form-actions clearfix">
			<button type="submit" class="btn btn-primary" name="save_account_details"><i class="loader" aria-hidden="true"></i> <?php _e( 'Save changes', 'sp-theme' ); ?></button>
		</div><!--close .form-actions-->

		<?php wp_nonce_field( 'save_account_details', '_save_account_details_nonce' ); ?>
		<input type="hidden" name="action" value="save_account_details" />
		<input type="hidden" name="account_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
	</form>

</div><!--close .edit-account-->