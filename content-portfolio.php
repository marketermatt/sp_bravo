<?php
/*
For general blog post format and a fallback if no specific format template is found
*/

if ( is_sticky() )
	$sticky_class = 'sticky';
else
	$sticky_class = '';
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( $sticky_class ); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<h2 class="featured-post-title">
			<?php _e( 'Featured post', 'sp-theme' ); ?>
		</h2>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_singular() ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php } ?>
			
			<div class="header-entry-meta"><?php sp_post_header_entry_meta(); ?></div><!--close .entry-meta-->
			
		</header><!-- .entry-header -->
		
		<?php
		// get featured video settings
		$video = get_post_meta( $post->ID, '_sp_post_featured_video', true );
		$poster = get_post_meta( $post->ID, '_sp_post_featured_video_poster', true );

		// if video is set, use that instead of image
		if ( isset( $video ) && ! empty( $video ) ) { 
			$type = sp_check_video_type( $video );
			$video_width = sp_get_theme_init_setting( 'set_post_thumbnail_size', 'width' );
			$video_height = sp_get_theme_init_setting( 'set_post_thumbnail_size', 'height' );

			if ( $type === 'embed' ) {
				echo wp_oembed_get( $video, array( 'width' => (int)$video_width ) );
			} elseif ( $type === 'mp4' ) {
				// strip the extension
				$video_noext = str_replace( '.mp4', '', $video );

				if ( ! isset( $poster ) || empty( $poster ) )
					$poster = '';
				
				echo do_shortcode( '[video mp4="' . esc_url( $video ) . '" ogv="' . esc_url( $video_noext . '.ogv' ) . '" webm="' . esc_url( $video_noext . '.webm' ) . '" width="' . esc_attr( (int)$video_width ) . '" poster="' . esc_attr( $poster ) . '"]' );
			}
		} else {
			// check if have post thumbnail
			if ( has_post_thumbnail() ) { 
				if ( is_singular() ) { 
					$image_width = apply_filters( 'sp_single_portfolio_image_width', sp_get_theme_init_setting( 'portfolio_single_size', 'width' ) );
					$image_height = apply_filters( 'sp_single_portfolio_image_height', sp_get_theme_init_setting( 'portfolio_single_size', 'height' ) );
					$image_crop = apply_filters( 'sp_single_portfolio_image_crop', sp_get_theme_init_setting( 'portfolio_single_size', 'crop' ) );

					$image = sp_get_image( get_post_thumbnail_id( $post->ID ), $image_width, $image_height, $image_crop );
					$image_full = sp_get_image( get_post_thumbnail_id( $post->ID ) );
					?>
					<div class="image-wrap"><a href="<?php echo $image_full['url']; ?>" title="<?php the_title_attribute(); ?>" class="portfolio-image-link mfp-image"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" /><i class="hover-icon icon-resize-full" aria-hidden="true"></i></a></div>
				<?php } else { ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="featured-image-link"><?php the_post_thumbnail(); ?><span class="overlay"></span></a>
				<?php } ?>
			<?php } ?>
		<?php } ?>

		<?php if ( is_search() || ! is_singular() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php sp_show_post_content_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content clearfix">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'sp-theme' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		
		<div class="footer-entry-meta row">
			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">
				<?php sp_post_footer_entry_meta(); ?>
			</div><!--close .column-->

			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">
				<?php echo sp_display_social_media_buttons(); ?>
			</div><!--close .column-->
		</div><!--close .footer-entry-meta-->

		<footer>			
		
			<?php if ( is_singular() && get_the_author_meta( 'description' ) ) : ?>
				<div class="author-info row">
					
					<div class="author-avatar <?php echo sp_column_css( '', '', '', '2' ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'sp_author_bio_avatar_size', 100 ) ); ?>
					</div><!-- .author-avatar -->

					<div class="author-description <?php echo sp_column_css( '', '', '', '10' ); ?>">
						<h2><?php printf( __( 'About %s', 'sp-theme' ), get_the_author() ); ?></h2>

						<p><?php the_author_meta( 'description' ); ?></p>
						
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <i class="icon-angle-right"></i>', 'sp-theme' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'sp-theme' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</article><!-- #post -->
