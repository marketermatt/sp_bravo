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
	<header class="entry-header">
		<div class="container">
			<?php sp_display_page_title(); ?>
			<?php sp_display_breadcrumbs(); ?>
		</div><!--close .container-->
	</header><!-- .entry-header -->
	<?php
	}
	?>

	<div class="container main-container <?php echo esc_attr( $orientation ); ?>">

		<?php do_action( 'sp_index_layout_before_content_row' ); ?>

		<div class="row">
			<?php if ( $layout['sidebar_left'] ) get_sidebar( 'left' ); ?>

			<div id="primary" class="site-content <?php echo esc_attr( $span_columns ); ?>">
				<div id="content" role="main">
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php sp_paging_nav(); ?>

				<?php else : ?>

					<article id="post-0" class="post no-results not-found">

					<?php if ( current_user_can( 'edit_posts' ) ) :
						// Show a different message to a logged-in user who can add posts.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'No posts to display', 'sp-theme' ); ?></h1>
						</header>

						<div class="entry-content">
							<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'sp-theme' ), admin_url( 'post-new.php' ) ); ?></p>
						</div><!-- .entry-content -->

					<?php else :
						// Show the default message to everyone else.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'sp-theme' ); ?></h1>
						</header>

						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'sp-theme' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					<?php endif; // end current_user_can() check ?>

					</article><!-- #post-0 -->

				<?php endif; // end have_posts() check ?>

				</div><!-- #content -->
			</div><!-- #primary -->

			<?php if ( $layout['sidebar_right'] ) get_sidebar( 'right' ); ?>

		</div><!--close. row-->

		<?php do_action( 'sp_index_layout_after_content_row' ); ?>

	</div><!--close . container-->

<?php get_footer(); ?>