<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
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

global $woocommerce;

wc_print_notices(); 

sp_woo_checkout_additional_info(); 
?>

<div class="row myaccount">
	
	<div class="<?php echo sp_column_css( '', '', '', '3' ); ?>">
		<nav class="account-nav">
			<h3><span><?php _e( 'My Account', 'sp-theme' ); ?></span></h3>
			<ul>
				<?php echo apply_filters( 'sp_woo_myaccount_nav_orders', '<li><a href="#orders" title="' . esc_attr__( 'Recent Orders', 'sp-theme' ) . '">' . __( 'Recent Orders', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>
				
				<?php
				// check if we need to show downloadables
				if ( WC()->customer->get_downloadable_products() )
				?>
					<?php echo apply_filters( 'sp_woo_myaccount_nav_downloads', '<li><a href="#downloads" title="' . esc_attr__( 'My Downloads', 'sp-theme' ) . '">' . __( 'My Downloads', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>

				<?php echo apply_filters( 'sp_woo_myaccount_nav_addresses', '<li><a href="#addresses" title="' . esc_attr__( 'My Addresses', 'sp-theme' ) . '">' . __( 'My Addresses', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>

				<?php echo apply_filters( 'sp_woo_myaccount_nav_wishlist', '<li><a href="#wishlists" title="' . esc_attr__( 'My Wishlists', 'sp-theme' ) . '">' . __( 'My Wishlists', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>

				<?php echo apply_filters( 'sp_woo_myaccount_nav_edit_account', '<li><a href="#edit-account" title="' . esc_attr__( 'Edit Account', 'sp-theme' ) . '">' . __( 'Edit Account', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>

				<?php echo apply_filters( 'sp_woo_myaccount_nav_change_password', '<li><a href="#change-password" title="' . esc_attr__( 'Change Password', 'sp-theme' ) . '">' . __( 'Change Password', 'sp-theme' ) . ' <i class="icon-angle-right" aria-hidden="true"></i></a></li>' ); ?>
			</ul>
		</nav>
	</div><!--close .column-->

	<div class="<?php echo sp_column_css( '', '', '', '9' ); ?>">

		<p class="myaccount-user">
			<?php
			printf(
				__( 'Hello <strong>%s</strong> ( not %s? <a href="%s">Sign out</a> ).', 'sp-theme' ) . ' ',
				$current_user->display_name,
				$current_user->display_name,
				wp_logout_url()
			);

			printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and edit your password and account details.', 'sp-theme' ) );
			?>
		</p>

		<?php do_action( 'woocommerce_before_my_account' ); ?>
		
		<div id="orders">
		<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
		</div><!--close #orders-->
		
		<div id="downloads">
		<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
		</div><!--close .#downloads-->
		
		<div id="addresses">
		<?php wc_get_template( 'myaccount/my-address.php' ); ?>
		</div><!--close #address-->
		
		<div id="wishlists">
		<?php sp_woo_add_product_wishlist_to_my_account(); ?>
		</div><!--close #wishlist-->
		
		<div id="edit-account">
		<?php wc_get_template( 'myaccount/form-edit-account.php' ); ?>
		</div><!--close #edit-account-->

		<div id="change-password">
		<?php wc_get_template( 'myaccount/form-change-password.php' ); ?>
		</div><!--close #edit-account-->

		<?php do_action( 'woocommerce_after_my_account' ); ?>
	</div><!--close .column-->
</div><!--close .row-->