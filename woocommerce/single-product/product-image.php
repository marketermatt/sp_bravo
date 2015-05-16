<?php
/**
 * Single Product Image
 *
 * actual version 2.0.14
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images <?php echo sp_column_css( '', '', '', '5' ); ?>">
	<?php woocommerce_template_single_title(); ?>
	<div class="image-wrap">
	<?php
		if ( has_post_thumbnail() ) {

			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_title 		= esc_attr( get_the_title( $post->ID ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			if ( sp_get_option( 'show_product_sale_badge' ) === 'on' ) {
				ob_start();
				woocommerce_show_product_loop_sale_flash();
				$sale_flash = ob_get_clean();
			} else {
				$sale_flash = '';
			}

			$new_badge = '';
			$new_badge_duration = sp_get_option( 'product_new_badge_duration' );

			if ( sp_get_option( 'show_product_new_badge' ) === 'on' ) {
				if ( isset( $new_badge_duration ) && ! empty( $new_badge_duration ) ) {
					$product_date = strtotime( $product->post->post_date );
					$current_date = time();
					$duration = 24*60*60*absint( $new_badge_duration );
					
					if ( ( $current_date - $product_date ) < $duration ) {
						$new_badge .= '<span class="new">' . __( 'NEW!', 'sp-theme' ) . '</span>' . PHP_EOL;
					}
				}
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s">%s<i class="icon-resize-full hover-icon" aria-hidden="true"></i>%s%s</a>', $image_link, $image_title, $image, $sale_flash, $new_badge ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

		}
/*
	$attachment_ids = $product->get_gallery_attachment_ids();

	if ( $attachment_ids ) {

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom', 'hide-thumbs', 'gal' );

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
		}
	}*/
	?>

	</div><!--close .image-wrap-->
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
