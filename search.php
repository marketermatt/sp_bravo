<?php get_header(); 

$layout = sp_get_page_layout(); 
$orientation = $layout['orientation'];
$span_columns = $layout['span_columns'];

global $post;
?>
	<header class="page-header">
		<div class="container">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'sp-theme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</div><!--close .container-->
	</header>

	<div class="container main-container <?php echo esc_attr( $orientation ); ?>">
		
		<?php do_action( 'sp_search_layout_before_content_row' ); ?>

		<div class="row">
			<?php if ( $layout['sidebar_left'] ) get_sidebar( 'left' ); ?>

			<section id="primary" class="site-content <?php echo esc_attr( $span_columns ); ?>">
				<div id="content" role="main">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php sp_paging_nav(); ?>

				<?php else : ?>

					<article id="post-0" class="post no-results not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'sp-theme' ); ?></h1>
						</header>

						<div class="entry-content">
							<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sp-theme' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				<?php endif; ?>

				</div><!-- #content -->
			</section><!-- #primary -->

			<?php if ( $layout['sidebar_right'] ) get_sidebar( 'right' ); ?>
		</div><!--close. row-->

		<?php do_action( 'sp_search_layout_after_content_row' ); ?>

	</div><!--close . container-->

<?php get_footer(); ?>