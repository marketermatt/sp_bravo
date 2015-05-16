<?php
/**
 * Related Products
 *
 * actual version 1.6.4
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$related_product_count = sp_get_option( 'related_product_count' );

if ( isset( $related_product_count ) && ! empty( $related_product_count ) )
	$posts_per_page = absint( $related_product_count );

$related = $product->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> apply_filters( 'sp_woo_related_product_count', $posts_per_page ),
	'orderby' 				=> apply_filters( 'sp_woo_related_product_orderby', $orderby ),
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );

$products = new WP_Query( $args );

$title = sp_get_option( 'related_product_title' );

if ( ! isset( $title ) || empty( $title ) )
	$title = '';

if ( $products->have_posts() ) : ?>

	<div class="related products <?php echo sp_column_css( '', '', '', '12' ); ?>">

		<h2><span><?php echo $title; ?></span></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'related-product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div><!--close .related-->

<?php endif;

wp_reset_postdata();