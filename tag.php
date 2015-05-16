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
			<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'sp-theme' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>

			<?php if ( tag_description() ) : // Show an optional tag description ?>
				<span class="heading-tagline"> - <?php echo strip_tags( tag_description() ); ?></span>
			<?php endif; ?>
			</h1>
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
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/* Include the post format-specific template for the content. If you want to
						 * this in a child theme then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;

					sp_paging_nav();
					?>

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