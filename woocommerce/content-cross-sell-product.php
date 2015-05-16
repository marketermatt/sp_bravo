<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-cross-sell-product.php
 *
 * actual version 1.6.4
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// get quickview setting
$show_quickview = sp_get_option( 'quickview' );

if ( $show_quickview === 'on' )
	$quickview_class = 'quickview';
else
	$quickview_class = '';

// get image width
$image = sp_get_image( 
				get_post_thumbnail_id( $product->id ), 
				apply_filters( 'sp_woo_cross_sell_product_image_width', sp_get_theme_init_setting( 'woo_cross_sell_product_image_size', 'width' ) ), 
				apply_filters( 'sp_woo_cross_sell_product_image_height', sp_get_theme_init_setting( 'woo_cross_sell_product_image_size', 'height' ) ), 
				apply_filters( 'sp_woo_cross_sell_product_image_crop', sp_get_theme_init_setting( 'woo_cross_sell_product_image_size', 'crop' ) )
			);

// removes the default image function and load our own
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
?>
<li <?php post_class(); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

	<div class="image-wrap-column">
	<div class="image-wrap <?php echo esc_attr( $quickview_class ); ?>" style="max-width:<?php echo esc_attr( $image['width'] ); ?>px;">
	<a href="<?php the_permalink(); ?>" class="product-image-link">

		<?php
			// get user set image width/height
			$catalog_image_size = get_option( 'shop_catalog_image_size' );

			// get alternate product image settings
			$hover_status = get_post_meta( $product->id, '_sp_alternate_product_image_on_hover_status', true );

			// get the alternate image
			$show_alt_image = false;
			if ( $hover_status === 'on' ) {
				$alt_image_id = absint( get_post_meta( $product->id, '_sp_alternate_product_image_id', true ) );
				$alt_image = sp_get_image( $alt_image_id, $catalog_image_size['width'], $catalog_image_size['height'], $catalog_image_size['crop'] );
				$show_alt_image = true;
			}

			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );

			echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" itemprop="image" class="attachment-shop_catalog wp-post-image" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '" />' . PHP_EOL;

			if ( $product->is_on_sale() )
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'sp-theme' ) . '</span>', $post, $product );

			if ( $show_alt_image )
				echo '<img src="' . esc_attr( $alt_image['url'] ) . '" alt="' . esc_attr( $alt_image['alt'] ) . '" itemprop="image" class="alt-product-image" />' . PHP_EOL;
		?>

		<?php
		if ( $show_quickview === 'on' )
			echo '<span class="quickview-button"><i class="icon-eye" aria-hidden="true"></i> ' . __( 'QUICKVIEW', 'sp-theme' ) . '</span>' . PHP_EOL;
		?>
	</a>
	
	</div><!--close .image-wrap-->
	</div><!--close .image-wrap-column-->
	
	<div class="content-wrap">

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	 	<input type="hidden" name="product_type" value="<?php echo esc_attr( $product->product_type ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->id ); ?>" />
		<input type="hidden" name="product_image_width" value="<?php echo esc_attr( $image['width'] ); ?>" />

		<?php woocommerce_template_loop_add_to_cart(); ?>	
	</div><!--close .content-wrap-->

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>