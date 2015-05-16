<?php 
get_header();

global $post;

$classes = array();

if ( get_post_type() === 'post' )
	$classes[] = 'blog';

$layout = sp_get_page_layout(); 
$orientation = $layout['orientation'];
$span_columns = $layout['span_columns'];

$classes[] = $span_columns;
$classes[] = 'site-content';
?>

	<header class="archive-header">
		<div class="container">
			<h1 class="archive-title"><?php printf( __( 'Author Archives: %s', 'sp-theme' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
			<?php sp_display_breadcrumbs(); ?>
		</div><!--close .container-->
	</header><!-- .archive-header -->

	<div class="container main-container <?php echo esc_attr( $orientation ); ?>">
		
		<?php do_action( 'sp_archive_layout_before_content_row' ); ?>

		<div class="row">
			
			<?php if ( $layout['sidebar_left'] ) get_sidebar( 'left' ); ?>

			<section id="primary" <?php post_class( $classes ); ?>>
				<div id="content" role="main">

				<?php if ( have_posts() ) : ?>

					<?php
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop
						 * properly with a call to rewind_posts().
						 */
						the_post();
					?>

					<?php
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();
					?>

					<?php
					// If a user has filled out their description, show a bio on their entries.
					if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="author-info row">
							
							<div class="author-avatar <?php echo sp_column_css( '', '', '', '2' ); ?>">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'sp_author_bio_avatar_size', 100 ) ); ?>
							</div><!-- .author-avatar -->

							<div class="author-description <?php echo sp_column_css( '', '', '', '10' ); ?>">
								<h2><?php printf( __( 'About %s', 'sp-theme' ), get_the_author() ); ?></h2>

								<p><?php the_author_meta( 'description' ); ?></p>
								
							</div><!-- .author-description -->
						</div><!-- .author-info -->
					<?php endif; ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php sp_paging_nav(); ?>

				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>

				</div><!-- #content -->
			</section><!-- #primary -->

			<?php if ( $layout['sidebar_right'] ) get_sidebar( 'right' ); ?>
		</div><!--close. row-->
		
		<?php do_action( 'sp_archive_layout_after_content_row' ); ?>

	</div><!--close . container-->

<?php get_footer(); ?>