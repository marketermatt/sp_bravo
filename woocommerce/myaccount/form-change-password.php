<?php
/**
 * Change password form
 *
 * actual version 1.6.4
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php wc_print_notices(); ?>

<?php echo do_shortcode( '[sp-change-password]' );