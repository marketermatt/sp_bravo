<?php
/**
 *	
 * theme specific hot patches
 */

// convert FAQ content to wp editor content - 2/10/2014
$faq_option = get_option( 'sp_faq_converted' );

// if not converted convert
if ( $faq_option !== '1' ) {

	$args = array( 
		'post_type' => 'sp-faq',
		'posts_per_page' => -1,
		'post_status' => 'any'
	);

	$faqs = new WP_Query( $args );

	// loop
	while( $faqs->have_posts() ) : $faqs->the_post();
		// get the content meta
		$content = get_post_meta( get_the_ID(), '_sp_faq_answer', true );

		$post_content = array(
			'ID' => get_the_ID(),
			'post_content' => $content
		);

		wp_update_post( $post_content );
	endwhile;

	wp_reset_postdata();

	// flag converted
	update_option( 'sp_faq_converted', '1' );
}

// remove WC shop folder 1/6/2015
if ( is_dir( get_template_directory() . '/woocommerce/shop' ) ) {
	@unlink( get_template_directory() . '/woocommerce/shop/breadcrumb.php' );

	@rmdir( get_template_directory() . '/woocommerce/shop' );
}

// FAQ add sort position - 1/6/2015
$faq_sort_added = get_option( 'sp_faq_sort_added' );

// if not converted convert
if ( $faq_sort_added !== '1' ) {

	$args = array( 
		'post_type' => 'sp-faq',
		'posts_per_page' => -1,
		'post_status' => 'any'
	);

	$faqs = new WP_Query( $args );

	// loop
	while( $faqs->have_posts() ) : $faqs->the_post();
		// add sort order of zero
		update_post_meta( get_the_ID(), '_sp_post_faq_order', '0' );
	endwhile;

	wp_reset_postdata();

	// flag converted
	update_option( 'sp_faq_sort_added', '1' );
}