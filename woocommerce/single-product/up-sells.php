<?php
/**
 * Single Product Up-Sells
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce;

$upsell_product_count = sp_get_option( 'upsell_product_count' );

if ( isset( $upsell_product_count ) && ! empty( $upsell_product_count ) )
	$posts_per_page = absint( $upsell_product_count );

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page' 		=> apply_filters( 'sp_woo_upsell_product_count', $posts_per_page ),
	'orderby' 				=> apply_filters( 'sp_woo_upsell_product_orderby', $orderby ),
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$title = sp_get_option( 'upsell_product_title' );

if ( ! isset( $title ) || empty( $title ) )
	$title = '';

if ( $products->have_posts() ) : ?>

	<div class="upsells products">

		<h2><span><?php echo $title; ?></span></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'upsell-product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
