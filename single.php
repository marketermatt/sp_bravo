<?php
get_header();
 
$layout = sp_get_page_layout(); 
$orientation = $layout['orientation'];
$span_columns = $layout['span_columns'];

global $post;

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

	<?php do_action( 'sp_post_layout_before_main_container' ); ?>

	<div class="container main-container <?php echo esc_attr( $orientation ); ?>">
		
		<?php do_action( 'sp_post_layout_before_content_row' ); ?>

		<div class="row">
			
			<?php if ( $layout['sidebar_left'] ) get_sidebar( 'left' ); ?>
			
			<section id="primary" role="main" class="blog single <?php echo esc_attr( $span_columns ); ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

					<?php sp_post_nav(); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</section><!-- #primary -->

			<?php if ( $layout['sidebar_right'] ) get_sidebar( 'right' ); ?>
		</div><!--close. row-->

		<?php do_action( 'sp_post_layout_after_content_row' ); ?>

	</div><!--close . container-->
	<?php do_action( 'sp_post_layout_after_main_container' ); ?>

<?php get_footer(); ?>