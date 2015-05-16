<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * pagination functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

if ( ! function_exists( 'sp_paging_nav' ) ) :
/**
 * Function that displays next/previous pagination for sets of posts
 *
 * @access public
 * @since 3.0
 * @return array
 */
function sp_paging_nav( $show_title = false ) {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;

	// get the saved setting
	$style = sp_get_option( 'blog_pagination' );

	switch( $style ) :
		case 'next-previous' :

	?>
			<nav class="navigation paging-navigation clearfix" role="navigation">
				<?php if ( $show_title ) { ?>
					<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'sp-theme' ); ?></h1>
				<?php } ?>

				<div class="nav-links clearfix">

					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( apply_filters( 'sp_paging_nav_prev_icon', '<i class="icon-angle-left"></i>' ) . ' Older posts', 'sp-theme' ) ); ?></div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts ' . apply_filters( 'sp_paging_nav_next_icon', '<i class="icon-angle-right"></i>' ), 'sp-theme' ) ); ?></div>
					<?php endif; ?>

				</div><!-- .nav-links -->
			</nav><!-- .navigation -->
			<?php
			break;

		case 'numeration' :
			echo sp_pagination();
			break;

		case 'no-pagination':
		default:
			return;
			break;

	endswitch;
}
endif;

if ( ! function_exists( 'sp_post_nav' ) ) :
/**
 * Function that displays next/previous pagination for single post
 *
 * @access public
 * @since 3.0
 * @return array
 */
function sp_post_nav( $show_title = false ) {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation clearfix" role="navigation">
		<?php if ( $show_title ) { ?>
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'sp-theme' ); ?></h1>
		<?php } ?>
		
		<div class="nav-links clearfix">

			<?php previous_post_link( '%link', _x( apply_filters( 'sp_post_nav_prev_icon', '<i class="icon-angle-left"></i>' ) . ' %title', 'Previous post link', 'sp-theme' ) ); ?>
			<?php next_post_link( '%link', _x( '%title ' . apply_filters( 'sp_post_nav_next_icon', '<i class="icon-angle-right"></i>' ), 'Next post link', 'sp-theme' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'sp_pagination' ) ) :
/**
 * pagination function 
 * attribution goes out to Kriesi
 *
 * @access public
 * @since 3.0
 * @param $pages the number of pages to show
 * @param $range the range of min and max to show
 * @return string HTML output of the pagination
 */
function sp_pagination( $pages = '', $range = 2 ) {  
	global $paged, $wp_query;
	
	$showitems = ( $range * 2 ) + 1;  
	
	// paged is empty set it to 1
	if ( empty( $paged ) ) 
		$paged = 1;
	
	// if pages is empty set to max num pages
	if ( $pages == '' ) {
	   $pages = $wp_query->max_num_pages;
	   
	   // if no max, set to 1
	   if ( ! $pages )
		   $pages = 1;
	}   

	$output = '';

	if ( 1 != $pages ) {
	   $output .= '<nav class="sp-pagination clearfix">' . PHP_EOL;
	   
	   if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) 
			$output .= '<a href="' . get_pagenum_link( 1 ) . '" class="inactive"><i class="icon-angle-left"></i></a>' . PHP_EOL;
	   
	   if ( $paged > 1 && $showitems < $pages ) 
			$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="inactive"><i class="icon-angle-left"></i></a>' . PHP_EOL;
	
	   for ( $i=1; $i <= $pages; $i++ ) {
		   if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
			   $output .= ( $paged == $i ) ? '<a href="#" title="' . esc_attr__( 'Current', 'sp-theme' ) . '" class="current">' . $i . '</a>' : '<a href="' . get_pagenum_link( $i ) . '" title="' . esc_attr__( 'Page', 'sp-theme' ) . '" class="inactive" >' . $i . '</a>' . PHP_EOL;
	   }
	
	   if ( $paged < $pages && $showitems < $pages ) 
			$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="inactive"><i class="icon-angle-right"></i></a>' . PHP_EOL;  
	   
	   if ( $paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages ) 
			$output .= '<a href="' . get_pagenum_link( $pages ) . '" class="inactive"><i class="icon-angle-right"></i></a>' . PHP_EOL;
	   
	   $output .= '</nav>' . PHP_EOL;
	}

	return $output;
}
endif;