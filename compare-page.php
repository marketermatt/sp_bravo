<?php
/* Template Name: Product Compare */
get_header();

// get items to compare
if ( isset( $_COOKIE['sp_product_compare'] ) ) {
	$cookie = maybe_unserialize( $_COOKIE['sp_product_compare'] );

	// sanitize cookie
	is_array( $cookie ) ? array_walk_recursive( $cookie, 'sp_clean_multi_array' ) : null;
}
?>

	<header class="page-header">
		<div class="container">
			<?php sp_display_page_title(); ?>
			<?php sp_display_breadcrumbs(); ?>
		</div><!--close .container-->
	</header><!-- .page-header -->

	<div class="container main-container">
		
		<?php do_action( 'sp_compare_layout_before_content_row' ); ?>

		<section id="primary" role="main" class="compare-page">
			
			<?php 
			if ( sp_woo_exists() ) {
				wc_print_notices();
				
				if ( isset( $cookie ) && ! empty( $cookie ) )
					echo sp_woo_product_compare_html( $cookie ); 
				else
					echo '<p>' . __( 'There are no items to compare.', 'sp-theme' ) . '</p>' . PHP_EOL;
			}
			?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>

		</section><!--close #primary-->

		<?php do_action( 'sp_compare_layout_after_content_row' ); ?>

	</div><!--close . container-->
<?php get_footer(); ?>