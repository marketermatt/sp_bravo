<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class( 'row single-product' ); ?>>

	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary <?php echo sp_column_css( '', '', '', '7' ); ?>">
		<?php 
		// check if we need to display star ratings
		if ( sp_get_option( 'product_rating_stars', 'is', 'on' ) )
			echo sp_woo_product_rating_html( $product->id ); 
		?>
		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */

			do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->

	<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->id ); ?>" />

	<?php
	// check product type
	$product_type = sp_has_product_add_ons( $product->id ) ? 'addons' : $product->product_type;
	?>
	<input type="hidden" name="product_type" value="<?php echo esc_attr( $product_type ); ?>" />
	<?php
	// get thumb width
	$image_thumb = get_option( 'shop_thumbnail_image_size' );

	echo '<input type="hidden" name="product_thumb_width" value="' . $image_thumb['width'] . '" />';

	// get show slider setting
	$show_slider = sp_get_option( 'product_image_gallery_slider' );

	if ( $show_slider === 'on' )
		echo '<input type="hidden" name="product_image_gallery_slider" value="on" />';	
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div><!-- #product-<?php the_ID(); ?> -->

<div class="row related-row">
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
</div><!--close .row-->

<?php do_action( 'woocommerce_after_single_product' ); ?>