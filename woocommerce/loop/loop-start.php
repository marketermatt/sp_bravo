<?php
/**
 * Product Loop Start
 *
 * actual version 2.0.0
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

$add_class = '';

if ( is_woocommerce() ) {
	$add_class = sp_get_product_view_type();
}
?>
<ul class="products <?php echo esc_attr( $add_class ); ?>">