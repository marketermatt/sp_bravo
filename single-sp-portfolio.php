<?php
get_header();
 
$layout = sp_get_page_layout(); 
$orientation = $layout['orientation'];
$span_columns = $layout['span_columns'];

global $post;

// get page builder status
$pb_status = get_post_meta( $post->ID, '_sp_page_builder_status', true );
?>
	
	<?php
	// don't show any title or breadcrumb for home
	if ( ! is_home() && ! is_front_page() ) {
	?>
	<header class="page-header">
		<div class="container">
			<?php sp_display_page_title(); ?>
			<?php sp_display_breadcrumbs(); ?>
		</div><!--close .container-->
	</header><!-- .page-header -->
	<?php
	}
	?>
	
	<?php 
	// check if page builder is on
	if ( $pb_status === 'on' ) {
		sp_display_page_builder();
	} else {
	?>
	
	<?php do_action( 'sp_single_portfolio_layout_before_main_container' ); ?>
	<div class="container main-container <?php echo esc_attr( $orientation ); ?>">
		
		<?php do_action( 'sp_single_portfolio_layout_before_content_row' ); ?>

		<div class="row">
			
			<?php if ( $layout['sidebar_left'] ) get_sidebar( 'left' ); ?>
			
			<section id="primary" role="main" class="blog single <?php echo esc_attr( $span_columns ); ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'portfolio' ); ?>

					<?php sp_post_nav(); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</section><!-- #primary -->

			<?php if ( $layout['sidebar_right'] ) get_sidebar( 'right' ); ?>
		</div><!--close. row-->

		<?php do_action( 'sp_single_portfolio_layout_after_content_row' ); ?>

	</div><!--close . container-->
	<?php do_action( 'sp_single_portfolio_layout_after_main_container' ); ?>
	<?php
	}
	?>
<?php get_footer(); ?>