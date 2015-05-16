<?php
/**
 * Single Product Thumbnails
 *
 * actual version 2.3.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

// get image swap value
$image_swap = sp_get_option( 'product_image_gallery_swap' );

if ( $attachment_ids ) {
	?>
	<div class="thumbnails"><?php

		// run if image swap is on
		if ( $image_swap === 'on' ) {
			$main_attachment_id = get_post_thumbnail_id( $post->ID );
			$main_image_class = 'zoom';
			$main_image = wp_get_attachment_image( $main_attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$main_image_link = wp_get_attachment_url( $main_attachment_id );
			$main_image_title = esc_attr( get_the_title( $main_attachment_id ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s">%s</a>', $main_image_link, $main_image_class, $main_image_title, $main_image ), $main_attachment_id, $post->ID, $main_image_class );	
		}

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?></div>
	<?php
}