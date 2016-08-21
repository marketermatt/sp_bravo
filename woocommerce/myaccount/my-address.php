<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
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

$customer_id = get_current_user_id();

if ( get_option('woocommerce_ship_to_billing_address_only') == 'no' && get_option('woocommerce_calc_shipping') !== 'no' ) {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Addresses', 'sp-theme' ) );
	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing Address', 'sp-theme' ),
		'shipping' => __( 'Shipping Address', 'sp-theme' )
	), $customer_id );
} else {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Address', 'sp-theme' ) );
	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' =>  __( 'Billing Address', 'sp-theme' )
	), $customer_id );
}

$col = 1;
?>

<h3><span><?php echo $page_title; ?></span></h3>

<p class="myaccount_address">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'sp-theme' ) ); ?>
</p>

<?php //if ( get_option('woocommerce_ship_to_billing_address_only') == 'no' ) echo '<div class="col2-set addresses">'; ?>

<div class="row">

<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="<?php echo sp_column_css( '', '', '', '6' ); ?> address">
		<header class="title">
			<h3><span><?php echo $title; ?></span></h3>
		</header>
		<address>
			<?php
				$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'first_name' 	=> get_user_meta( $customer_id, $name . '_first_name', true ),
					'last_name'		=> get_user_meta( $customer_id, $name . '_last_name', true ),
					'company'		=> get_user_meta( $customer_id, $name . '_company', true ),
					'address_1'		=> get_user_meta( $customer_id, $name . '_address_1', true ),
					'address_2'		=> get_user_meta( $customer_id, $name . '_address_2', true ),
					'city'			=> get_user_meta( $customer_id, $name . '_city', true ),
					'state'			=> get_user_meta( $customer_id, $name . '_state', true ),
					'postcode'		=> get_user_meta( $customer_id, $name . '_postcode', true ),
					'country'		=> get_user_meta( $customer_id, $name . '_country', true )
				), $customer_id, $name );

				$formatted_address = WC()->countries->get_formatted_address( $address );

				if ( ! $formatted_address )
					_e( 'You have not set up this type of address yet.', 'sp-theme' );
				else
					echo $formatted_address;
			?>
		</address>
		<a href="<?php echo wc_get_endpoint_url( 'edit-address', $name ); ?>" class="edit-address" data-address-type="<?php echo esc_attr( $name ); ?>"><?php _e( 'Edit', 'sp-theme' ); ?></a>
	</div>

<?php endforeach; ?>
</div><!--close .row-->
<?php //if ( get_option('woocommerce_ship_to_billing_address_only') == 'no' ) echo '</div>'; ?>