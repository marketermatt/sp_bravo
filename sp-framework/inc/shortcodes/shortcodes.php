<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * Shortcodes 32
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_shortcode( 'sp-gplusone', 'sp_gplusonebutton_shortcode' );

/**
 * Google plus one shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_gplusonebutton_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'url'			=> get_permalink(), // use default page url if none set
		'size'			=> 'small', // small, medium, standard, tall
		'annotation'	=> 'bubble' // bubble, inline, none
	), $atts ) );  

	$output = '';
	$output .= '<div class="sc-gplusone g-plusone" data-href="' . esc_url_raw( $url ) . '" data-size="' . esc_attr( $size ) . '" data-annotation="' . esc_attr( $annotation ) . '"></div><!--close .g-plusone-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-fblike', 'sp_fblikebutton_shortcode' );

/**
 * Facebook Like shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_fblikebutton_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'url'			=> get_permalink(), // use default page url if none set
		'send_button'	=> 'false',
		'layout'		=> 'button_count', // standard, button_count, box_count
		'width'			=> '75',
		'show_faces'	=> 'false',
		'verb'			=> 'like' // like, recommend
	), $atts ) );  

	$output = '';
	
	$output .= '<div class="sc-fblike fb-like" data-href="' . esc_url_raw( $url ) . '" data-send="' . esc_attr( $send_button ) . '" data-layout="' . esc_attr( $layout ) . '" data-width="' . esc_attr( (int)$width ) . '" data-show-faces="' . esc_attr( $show_faces ) . '" data-action="' . esc_attr( $verb ) . '"></div><!--close .fb-like-->' . PHP_EOL;

	$output .= '<div id="fb-root"></div>' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-tweet', 'sp_tweetbutton_shortcode' );

/**
 * Twitter Tweet shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_tweetbutton_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'url'				=> get_permalink(), // use default page url if none set 
		'count_position'	=> 'horizontal', // none, horizontal, vertical
		'size'				=> 'medium', // medium, large
		'type'				=> 'share', // share, hashtag, mention
		'hashtag'			=> '',
		'hashtag_text'		=> '', // only used when hashtag is set
		'tweet_to'			=> '' // only used when type is "mention"
	), $atts ) );  

	$twitter_url = 'https://twitter.com/share';
	$tweet = __( 'Tweet', 'sp-theme' );

	// check the type of tweet
	switch ( $type ) :
		case 'share' :
			$type_class = 'twitter-share-button';
			break;

		case 'hashtag' :
			$type_class = 'twitter-hashtag-button';
			$twitter_url = add_query_arg( 'button_hashtag', $hashtag, 'https://twitter.com/intent/tweet' );
			$twitter_url = add_query_arg( 'text', $hashtag_text, $twitter_url );
			$tweet = sprintf( __( 'Tweet %s', 'sp-theme' ), $hashtag );
			break;

		case 'mention' :
			$type_class = 'twitter-mention-button';
			$twitter_url = add_query_arg( 'screen_name', $tweet_to, 'https://twitter.com/intent/tweet' );
			$tweet = sprintf( __( 'Tweet to %s', 'sp-theme' ), $tweet_to );
			break;

	endswitch;

	$output = '';	
	$output .= '<div class="sc-tweet">' . PHP_EOL;
	$output .= '<a href="' . esc_url( $twitter_url ) . '" class="' . esc_attr( $type_class ) . '" data-url="' . esc_url_raw( $url ) . '" data-count="' . esc_attr( $count_position ) . '" data-size="' . esc_attr( $size ) . '">' . $tweet . '</a>' . PHP_EOL;	
	$output .= '</div><!--close .tweet-sc-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-twitter-follow', 'sp_twitterfollow_shortcode' );

/**
 * Twitter Follow shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_twitterfollow_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'user'			=> '', 
		'size'			=> 'normal', // normal, large
		'show_username'	=> 'true'
	), $atts ) ); 

	if ( $size !== 'large' )
		$size = '';

	$output = '';

	$output .= '<a href="https://twitter.com/' . esc_attr( $user ) . '" class="twitter-follow-button" data-show-count="false" data-size="' . esc_attr( $size ) . '" data-show-screen-name="' . esc_attr( $show_username ) . '" data-dnt="true">' . __( 'Follow', 'sp-theme' ) . ' @' . $user . '</a>' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-pinit', 'sp_pinit_shortcode' );

/**
 * Pinterest shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_pinit_shortcode( $atts, $content = null ) {
	global $post;
	
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'page_url'		=> get_permalink(), // use default page url if none set
		'image_url'		=> wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ), // use default featured thumbnail if none set
		'description'	=> '',
		'count_layout'	=> 'horizontal' // horizontal, vertical, none
	), $atts ) );  

	$pinterest_url = 'https://pinterest.com/pin/create/button';
	$pinterest_url = add_query_arg( array( 'url' => $page_url, 'media' => $image_url, 'description' => $description ), $pinterest_url );

	$output = '';
	$output .= '<div class="sc-pinit">' . PHP_EOL;
	$output .= '<a href="' . esc_url( $pinterest_url ) . '" class="pin-it-button" count-layout="' . esc_attr( $count_layout ) . '"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="' . esc_attr__( 'Pin It', 'sp-theme' ) . '" /></a>' . PHP_EOL;
	$output .= '</div><!--close .sc-pinit-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-homeurl', 'sp_home_url' );

/**
 * Home URL shortcode
 *
 * @access public
 * @since 3.0
 * @return url
 */
function sp_home_url() {
	return home_url() . "/";
}

add_shortcode( 'sp-themeurl', 'sp_theme_url' );

/**
 * Theme URL
 *
 * @access public
 * @since 3.0
 * @return url
 */
function sp_theme_url() {
	return get_template_directory_uri() . "/";
}

add_shortcode( 'sp-themepath', 'sp_theme_path' );

/**
 * Theme path
 *
 * @access public
 * @since 3.0
 * @return path
 */
function sp_theme_path() {
	return get_template_directory() . "/";
}

add_shortcode( 'sp-grid', 'sp_grid_shortcode' );

/**
 * Grid shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_grid_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'span' 		=> '12', // 1-12
		'offset' 	=> '', // 1-12
		'first'		=> 'false',
		'last'		=> 'false'
	), $atts ) );
	
	if ( isset( $offset ) && $offset != '' )
		$offset = 'offset' . $offset;

	$output = '';

	// check if it is first column in a row
	if ( $first == 'true')
		$output .= '<div class="sc-grid row">' . PHP_EOL;

	$output .= '<div class="' . esc_attr( sp_column_css( '', '', '', (string)$span, '', '', (string)$offset ) ) . '">' . do_shortcode( $content ) . '</div>' . PHP_EOL;
	
	// check if it is last column in a row
	if ( $last == 'true')
		$output .= '</div><!--close .row-->' . PHP_EOL;
	
	return $output;
}

add_shortcode( 'sp-hr', 'sp_hr_shortcode' );

/**
 * Horizontal rule shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_hr_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array( 
		'color'				=> '#ADA394',
		'style'				=> 'dashed', // dashed,solid,dotted
		'width'				=> '100%',
		'thickness'			=> '1',
		'custom_class'		=> ''
	), $atts ) );

	$color = str_replace( '#', '', $color );
	$thickness = str_replace( 'px', '', $thickness );

	$output = '';
	$output .= '<hr class="sc-hr ' . esc_attr( $custom_class ) . '" style="border-top-color:#' . esc_attr( $color ) . ';border-top-width:' . esc_attr( $thickness ) . 'px;width:' . esc_attr( $width ) . ';border-top-style:' . esc_attr( $style ) . ';background:transparent;" />' . PHP_EOL;
	
	return $output;
}

// back to top shortcode
add_shortcode( 'sp-btt', 'sp_back_to_top' );

/**
 * Back to top shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_back_to_top( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array( 
		'animate'			=> 'true',
		'text_color'		=> 'fff',
		'bg_color'			=> '000000',
		'position'			=> '', // left, right, center
		'style'				=> '1', // 1 -- arrow on top 2 -- arrow on the side
		'custom_class'		=> ''
	), $atts ) );

	$text_color = str_replace( '#', '', $text_color );
	$bg_color = str_replace( '#', '', $bg_color );

	if ( $animate == 'true' )
		$animate = 'animate';

	if ( $position === 'left' )
		$position = 'pull-left';
	elseif ( $position === 'right' )
		$position = 'pull-right';

	$output = '';
	$output .= '<div class="sc-btt clearfix ' . esc_attr( $animate ) . ' ' . esc_attr( $position ) . ' ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	
	if ( $style === '1' )
		$output .= '<a href="#top" title="' . esc_attr__( 'Top', 'sp-theme' ) . '" style="color:#' . esc_attr( $text_color ) . ';background-color:#' . esc_attr( $bg_color ) . ';" class="style-1"><i class="icon-chevron-up" aria-hidden="true"></i>' . __( 'Top', 'sp-theme' ) . '</a>' . PHP_EOL;
	else
		$output .= '<a href="#top" title="' . esc_attr__( 'Top', 'sp-theme' ) . '" style="color:#' . esc_attr( $text_color ) . ';background-color:#' . esc_attr( $bg_color ) . ';" class="style-2">' . __( 'Top', 'sp-theme' ) . ' <i class="icon-chevron-up" aria-hidden="true"></i></a>' . PHP_EOL;

	$output .= '</div><!--close .sc-btt-->' . PHP_EOL;
	
	return $output;
}

// custom portfolio shortcode
add_shortcode( 'sp-portfolio', 'sp_portfolio_shortcode' );

/**
 * Portfolio shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_portfolio_shortcode( $atts, $content = null ) {
	global $post, $paged;
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'category'				=> '', // category from portfolio
		'columns'				=> '4', // 1, 2, 3, 4, 5, 6
		'show_filters'			=> 'true',
		'sort_order'			=> 'name', // name, position
		'sort_by'				=> 'ASC', // ASC, DESC
		'show_title'			=> 'false',
		'show_excerpt'			=> 'false',
		'gallery_only'			=> 'true', // this will invoke lightbox when clicked
		'image_width'			=> sp_get_theme_init_setting( 'portfolio_list_size', 'width' ),
		'image_height'			=> sp_get_theme_init_setting( 'portfolio_list_size', 'height' ),
		'image_crop'			=> 'true',
		'link_gallery'			=> 'true',
		'posts_per_page'		=> '-1',
		'show_cat_description'	=> 'false',
		'show_animation'		=> 'true', // will turn on isotope
		'mosaic'				=> 'false',
		'custom_class'			=> '' // allow users to add their own class
	), $atts ) );

	$metakey = '';
	$order_by = '';

	if ( $sort_order !== 'name' ) {
		$metakey = '_sp_portfolio_sort_position';
		$order_by = 'meta_value_num';
	}

	// build the portfolio entry argument
	$args = array (
		'post_type'			=> 'sp-portfolio',
		'post_status'		=> 'publish',
		'posts_per_page'	=> (int)$posts_per_page,
		'tax_query'			=> array(
			array(
				'taxonomy'	=> 'sp-portfolio-categories',
				'field'		=> 'id',
				'terms'		=> $category,
				'operator'	=> 'IN'
			)
		),
		'order'		=> strtoupper( $sort_by ),
		'orderby'	=> $order_by,
		'meta_key'	=> $metakey,
		'paged'		=> $paged
	);	

	$entries = new WP_Query( $args ); 

	$output = '';
	$output .= '<div class="sc-portfolio clearfix container-fluid ' . esc_attr( $custom_class ) . '">' . PHP_EOL;

	// check if we need to show category description
	if ( $show_cat_description === 'true' ) {
		$cat = get_term( (int)$category, 'sp-portfolio-categories' );

		if ( is_object( $cat ) && strlen( $cat->description ) > 0 ) {
			$output .= '<div class="cat-description">' . PHP_EOL;
			$output .= '<p>' . $cat->description . '</p>' . PHP_EOL;
			$output .= '</div><!--close .cat-description-->' . PHP_EOL;
		}
	}

	$isotope = false;

	// check if show animation is on
	if ( $show_animation === 'true' )
		$isotope = true;

	// check if filter is on
	if ( $show_filters === 'true' ) {
		$tags = array();
		
		$isotope = true;

		// gather the unqiue tags from entries		
		foreach ( $entries->posts as $post ) { 
			$terms = wp_get_post_terms( $post->ID, 'sp-portfolio-tags' ); 

			foreach ( $terms as $term ) { 
				$tags[] = $term->name; 
			}
		}

		// remove any duplicates
		$filtered_tags = array_unique( $tags );

		if ( is_array( $filtered_tags ) && strlen( (string)$filtered_tags ) ) {
			$output .= '<ul class="portfolio-sort clearfix">' . PHP_EOL;

			// display the all filter
			$output .= '<li><a href="#" title="' . esc_attr__( 'All', 'sp-theme' ) . '" data-filter="*" class="active">' . __( 'All', 'sp-theme' ) . '</a></li>' . PHP_EOL;

			foreach ( $filtered_tags as $tag ) {
				$output .= '<li><span class="divider"> / </span><a href="#" title="' . esc_attr( $tag ) . '" data-filter=".' . esc_attr( str_replace( ' ', '-', $tag ) ) . '-sort">' . $tag . '</a></li>' . PHP_EOL;	
			}

			$output .= '</ul>' . PHP_EOL;
		}
	}

	// setup the columns
	switch ( $columns ) {
		case '1' :
			if ( $isotope )
				$span = 'isotope-1-column';
			else
				$span = sp_column_css( '', '', '', '12' );
			break;
		case '2' :
			if ( $isotope )
				$span = 'isotope-2-columns';
			else
				$span = sp_column_css( '', '', '', '6' );
			break;
		case '3' :
			if ( $isotope )
				$span = 'isotope-3-columns';
			else
				$span = sp_column_css( '', '', '', '4' );
			break;
		case '5' :
			if ( $isotope )
				$span = 'isotope-5-columns';
			else
				$span = sp_column_css( '', '', '', '2' );
			break;
		case '6' :
			if ( $isotope )
				$span = 'isotope-6-columns';
			else
				$span = sp_column_css( '', '', '', '2' );
			break;
		case '4' :
		default :
			if ( $isotope )
				$span = 'isotope-4-columns';
			else
				$span = sp_column_css( '', '', '', '3' );
			break;
	}

	// get the number of posts found
	$post_count = $entries->found_posts;

	$gal_id = '';

	// check if link gallery is on - links the images in lightbox
	if ( $link_gallery === 'true' ) 
		$gal_id = time();

	if ( $isotope ) {
		$output .= '<div class="isotope-wrap center">' . PHP_EOL;
	}

	while ( $entries->have_posts() ) : $entries->the_post();
		// get the tags
		$terms = wp_get_post_terms( $post->ID, 'sp-portfolio-tags' );

		$tags = '';
		
		foreach ( $terms as $term ) { 
			$tags .= ' ' . str_replace( ' ', '-', $term->name ) . '-sort'; 
		}

		$image_thumbnail = sp_get_image( get_post_thumbnail_id( $post->ID ), (int)$image_width, (int)$image_height, (bool)$image_crop );
	   
		$image_full = sp_get_image( get_post_thumbnail_id( $post->ID ) );

		// if mosaic is on, don't continue down the page
		if ( $mosaic === 'true' ) {
			$output .= '<article id="post-' . esc_attr( $post->ID ) . '" class="portfolio-item ' . esc_attr( $tags ) . ' mosaic">' . PHP_EOL;

			$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . the_title_attribute( 'echo=0' ) . '" class="portfolio-image-link mfp-image" data-rel="sp-lightbox[' . esc_attr( empty( $gal_id ) ? $post->ID : $gal_id ) . ']">' . PHP_EOL;
			
			$output .= '<img src="' . esc_url( $image_thumbnail['url'] ) . '" alt="' . esc_attr( $image_thumbnail['alt'] ) . '" />' . PHP_EOL;
			
			$output .= '<i class="hover-icon icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;

			// add custom user hook
			do_action( 'sp_gallery_after_image', $post->ID );

			$output .= '</article>' . PHP_EOL;	        	    	
			continue;
		}

		// only apply if isotope is off
		if ( ! $isotope ) {
			if ( (int)( $entries->current_post + 1 ) === 1 )
				$output .= '<div class="items row center">' . PHP_EOL;
		}

		$output .= '<article id="post-' . esc_attr( $post->ID ) . '" class="portfolio-item ' . esc_attr( $span ) . ' ' . esc_attr( $tags ) . '">' . PHP_EOL;
		
		// if show gallery only
		if ( $gallery_only === 'true') {    

			$output .= '<figure class="image-wrap gallery-only" style="max-width:' . esc_attr( (int)$image_width ) . 'px;">' . PHP_EOL;

			$output .= '<a href="' . esc_url( $image_full['url'] ) . '" title="' . the_title_attribute( 'echo=0' ) . '" class="portfolio-image-link mfp-image" data-rel="sp-lightbox[' . esc_attr( empty( $gal_id ) ? $post->ID : $gal_id ) . ']">' . PHP_EOL;
			
			$output .= '<img src="' . esc_url( $image_thumbnail['url'] ) . '" alt="' . esc_attr( $image_thumbnail['alt'] ) . '" />' . PHP_EOL;
			
			$output .= '<i class="hover-icon icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;

			$output .= '</figure><!--close .image-wrap-->' . PHP_EOL;
		} else {
			$output .= '<figure class="image-wrap" style="max-width:' . esc_attr( (int)$image_width ) . 'px;">' . PHP_EOL;
			
			$output .= '<a href="' . get_permalink() .'" title="' . esc_attr__( 'Detail', 'sp-theme' ) . '">' . PHP_EOL;
			
			$output .= '<img src="' . esc_url( $image_thumbnail['url'] ) . '" alt="' . esc_attr( $image_thumbnail['alt'] ) . '" />' . PHP_EOL;
			
			$output .= '<i class="hover-icon icon-link" aria-hidden="true"></i></a>' . PHP_EOL;
			
			$output .= '<figcaption>' . PHP_EOL;
				
			// check if show title is on
			if ( isset( $show_title ) && $show_title === 'true' ) { 
				$output .= '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'sp-theme' ), the_title_attribute( 'echo=0' ) ) . '" data-rel="bookmark">' . get_the_title() . '</a></h2>' . PHP_EOL;
			}	

			// check if show excerpt is on	
			if ( isset( $show_excerpt ) && $show_excerpt === 'true' ) {
				if ( strlen( $post->post_excerpt ) > 0 ) {
					$output .= get_the_excerpt() . PHP_EOL;
				} else {
					$output .= $post->post_content . PHP_EOL;
				}
			}

			$output .= '</figcaption>' . PHP_EOL;

			$output .= '</figure><!--close .image-wrap-->' . PHP_EOL;
		} // end gallery only check                               
		
		// add custom user hook
		do_action( 'sp_gallery_after_image', $post->ID );

		$output .= '</article>' . PHP_EOL;

		// only apply if isotope is off
		if ( ! $isotope ) {
			if ( (int)( $entries->current_post + 1 ) % (int)$columns === 0 || (int)( $entries->current_post + 1 ) === (int)$post_count ) {
				$output .= '</div><!--close items-->' . PHP_EOL;

				// make sure it is not last post
				if ( (int)( $entries->current_post + 1 ) !== (int)$post_count )
					$output .= '<div class="items row center">' . PHP_EOL;
			}
		}
	endwhile;

	if ( $isotope )
		$output .= '</div><!--close .isotope-wrap-->' . PHP_EOL;

	//$output .= sp_pagination( $entries->max_num_pages ) . PHP_EOL;
	$output .= '<input type="hidden" name="link_gallery" value="' . esc_attr( $link_gallery ) . '" class="link-gallery" />' . PHP_EOL;
	$output .= '</div><!--close .sc-portfolio-->' . PHP_EOL;
	
	wp_reset_postdata();
	
	return $output;
}

add_shortcode( 'sp-testimonial', 'sp_testimonial_shortcode' );

/**
 * Testimonial shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_testimonial_shortcode( $atts, $content = null ) {
	global $post, $paged;
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'category'				=> '', // category from testimonial
		'sort_by'				=> 'ASC', // ASC, DESC
		'posts_per_page'		=> '-1',
		'show_avatar'			=> 'true',
		'randomize'				=> 'true',
		'autorotate'			=> 'true', // will use carousel
		'autorotate_interval'	=> '6000', 
		'show_title'			=> 'true',
		'show_quote_marks'		=> 'true', // this is shown only if show avatar is off
		'title'					=> __( 'We would love your testimonial!', 'sp-theme' ),
		'submit_testimonial'	=> 'false', // true will change shortcode to accept new testimonials
		'custom_class'			=> '' // allow users to add their own class
	), $atts ) );

	if ( isset( $_POST['submit'] ) && $_POST['submit'] === 'submit_testimonial' && wp_verify_nonce( $_POST['_sp_testimonial_submit_nonce'], 'sp_testimonial_submit' ) ) {
		// do nothing as we will handle this via AJAX
		// dump the post just in case
		unset( $_POST );
	}

	if ( $randomize === 'true' )
		$orderby = 'rand';
	else 
		$orderby = 'title';

	// set default interval
	if ( empty( $autorotate_interval ) )
		$autorotate_interval = '6000';
	
	$output = '';
	
	$output .= '<div class="sc-testimonial clearfix ' . esc_attr( $custom_class ) . '">' . PHP_EOL;

	// check if submit testimonial is false
	if ( isset( $submit_testimonial ) && $submit_testimonial === 'false' ) {
		
		if ( $show_title === 'true' )
			$output .= '<h3 class="entry-title">' . $title . '</h3>' . PHP_EOL;
		
		// build the testimonial entry argument
		$args = array (
			'post_type'			=> 'sp-testimonial',
			'post_status'		=> 'publish',
			'posts_per_page'	=> (int)$posts_per_page,
			'tax_query'			=> array(
				array(
					'taxonomy'	=> 'sp-testimonial-categories',
					'field'		=> 'id',
					'terms'		=> $category,
					'operator'	=> 'IN'
				)
			),
			'order'		=> strtoupper( $sort_by ),
			'orderby'	=> $orderby,
			'paged'		=> $paged
		);	

		$entries = new WP_Query( $args ); 

		$output .= '<div class="entry-content">' . PHP_EOL;
		
		// check if autorotate is on
		if ( $autorotate === 'true' )
			$output .= '<div class="carousel">' . PHP_EOL;

		while ( $entries->have_posts() ) : $entries->the_post();
			// get name post meta
			$name = get_post_meta( $post->ID, '_sp_testimonial_submitter_name', true );

			// get email post meta
			$email = get_post_meta( $post->ID, '_sp_testimonial_submitter_email', true );

			// get gravatar
			$avatar = get_avatar( $email, 50 );

			// avatar
			if ( $show_avatar === 'true' )
				$avatar_class = 'show-avatar';
			else
				$avatar_class = '';

			// quote marks
			if ( $show_avatar === 'false' && $show_quote_marks === 'true' )
				$quote_marks = 'show-quotes';
			else
				$quote_marks = '';

			$output .= '<article id="post-' . esc_attr( $post->ID ) . '" class="testimonial-item row ' . esc_attr( $avatar_class ) . ' ' . esc_attr( $quote_marks ) . '">' . PHP_EOL;
			
			if ( $show_avatar === 'true' )
				$output .= '<div class="avatar-wrap">' . $avatar . '</div><!--close .avatar-wrap-->' . PHP_EOL;

			// only show if show quote marks is on and avatar is off
			if ( $show_avatar === 'false' && $show_quote_marks === 'true' )
				$output .= '<i class="icon-quotes-left" aria-hidden="true"></i>' . PHP_EOL;

			$output .= '<blockquote>' . PHP_EOL;
			$output .= '<p>' . strip_tags( get_the_content() ) . '</p>' . PHP_EOL;
			$output .= '<cite>&#47;&#47; ' . $name . '</cite>' . PHP_EOL;
			$output .= '</blockquote>' . PHP_EOL;
			$output .= '</article>' . PHP_EOL;

		endwhile;

		// check if autorotate is on
		if ( $autorotate === 'true' )
			$output .= '</div><!--close .carousel-->' . PHP_EOL;

		// check if autorotate is on
		if ( $autorotate === 'true' )
			$output .= '<input type="hidden" class="interval" value="' . esc_attr( $autorotate_interval ) . '" />' . PHP_EOL;

		$output .= '</div><!--close .entry-content-->' . PHP_EOL;

		// check if autorotate is off before showing pagination
		if ( $autorotate === 'false' )
			$output .= sp_pagination( $entries->max_num_pages ) . PHP_EOL;

		wp_reset_postdata();
	} else {
		if ( $show_title === 'true' )
			$output .= '<h3 class="entry-title">' . $title . '</h3>' . PHP_EOL;
		$output .= '<p><span class="required">' . apply_filters( 'sp_testimonial_form_sc_required_symbol', '*' ) . '</span> - ' . __( 'Required', 'sp-theme' ) . '</p>' . PHP_EOL;
		$output .= '<form action="#" method="post" role="form">' . PHP_EOL;
		$output .= '<h3 class="title"><i class="icon-comments-alt" aria-hidden="true"></i> ' . apply_filters( 'sp_sc_testimonial_submit_title', __( 'We would love your testimonial!', 'sp-theme' ) ) . '</h3>' . PHP_EOL;
		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label for="name" class="control-label field-label">' . __( 'Name', 'sp-theme' ) . ' <span class="required">' . apply_filters( 'sp_testimonial_form_sc_required_symbol', '*' ) . '</span></label>' . PHP_EOL;
		$output .= '<input type="text" id="name" name="testimonial_submitter_name" value="" data-required="required" class="form-control" />' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;

		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label for="email" class="control-label field-label">' . __( 'Email', 'sp-theme' ) . ' <span class="required">' . apply_filters( 'sp_testimonial_form_sc_required_symbol', '*' ) . '</span></label>' . PHP_EOL;
		$output .= '<input type="email" id="email" name="testimonial_submitter_email" value="" data-required="required" class="form-control" />' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;

		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label for="testimonial" class="control-label field-label">' . __( 'Testimonial', 'sp-theme' ) . ' <span class="required">' . apply_filters( 'sp_testimonial_form_sc_required_symbol', '*' ) . '</span></label>' .  PHP_EOL;
		$output .= '<textarea id="testimonial" name="testimonial" rows="10" data-required="required" class="form-control"></textarea>' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;

		$output .= '<div class="form-actions clearfix">' . PHP_EOL;
		$output .= '<button type="submit" name="submit" class="button" value="submit_testimonial"><i class="loader" aria-hidden="true"></i> ' . __( 'Send', 'sp-theme' ) . '</button>' . PHP_EOL;

		$output .= '</div><!--close .form-actions-->' . PHP_EOL;

		$output .= wp_nonce_field( 'sp_testimonial_submit', '_sp_testimonial_submit_nonce', true, false ) . PHP_EOL;
		$output .= '</form>' . PHP_EOL;
	}
	
	$output .= '</div><!--close .sc-testimonial-->' . PHP_EOL;

	return $output;	
}

add_shortcode( 'sp-button', 'sp_button_shortcode' );

/**
 * Button shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_button_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'text_color'	=> '333333', 
		'button_color'	=> 'f5f5f5',
		'url'			=> '#', 
		'target'		=> 'same', // same, new-window
		'title'			=> 'Button',
		'style'			=> 'rounded', // rounded, square
		'position'		=> 'inline', // inline, block, float-left, float-right
		'size'			=> 'default', // mini, small, default, large
		'icon'			=> '' // see font awesome for list
	), $atts ) );
		
	// set the link target
	if ( $target == 'same' ) 
		$target = '_self';
	else 
		$target = '_blank';	

	// set the position of the button
	if ( $position == 'float-left' )
		$position = 'pull-left';
	elseif ( $position == 'float-right' )
		$position = 'pull-right';
	elseif ( $position == 'block' )
		$position = 'btn-block';
	else
		$position = 'inline';

	// remove hash symbol
	$text_color = str_replace( '#', '', $text_color );

	// remove hash symbol
	$button_color = str_replace( '#', '', $button_color );

	$output = '';

	// check if icon is set
	if ( isset( $icon ) && ! empty( $icon ) && $icon != '' ) {
		$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="' . esc_attr( $target ) . '" class="sc-button ' . esc_attr( $style ) . ' ' . esc_attr( $position ) . ' ' . esc_attr( $size ) . '" style="color:#' . esc_attr( $text_color ) . ';background:url(' . get_template_directory_uri() . '/images/sc-button-overlay.png) repeat-x scroll center center #' . esc_attr( $button_color ) . '"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i> ' . $title . '</a>' . PHP_EOL;
	} else {
		$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="' . esc_attr( $target ) . '" class="sc-button ' . esc_attr( $style ) . ' ' . esc_attr( $position ) . ' ' . esc_attr( $size ) . '" style="color:#' . esc_attr( $text_color ) . ';background:url(' . get_template_directory_uri() . '/images/sc-button-overlay.png) repeat-x scroll center center #' . esc_attr( $button_color ) . '">' . $title . '</a>' . PHP_EOL;
	}

	return $output;
}

add_shortcode( 'sp-lightbox', 'sp_lightbox_shortcode' );

/**
 * Lightbox shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_lightbox_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array( 
		'title'				=> '', 
		'group'				=> '', // groups images together in lightbox
		'url'				=> '', // url of the full size image to expand to
		'poster_size'		=> '', // size of the poster thumbnail for videos
		'thumbnail'			=> '', // thumbnail to use for image
		'custom_class'		=> '' // allows users to add their own class 
	), $atts ) );

	$mfp_type = 'mfp-image';

	$content = strip_tags( $content );
	
	// if group is not set, add random class string
	if ( $group == '' ) 
		$group = wp_generate_password( 6, false, false );

	$output = '';

	$output .= '<div class="sc-lightbox ' . esc_attr( $custom_class ) . '">' . PHP_EOL;

	// check if $url is not empty
	if ( ! empty( $url ) ) {
		$source_url = parse_url( $url );

		// check if source is from youtube
		if ( $source_url['host'] == 'www.youtube.com' || $source_url['host'] == 'youtube.com' ) {
			parse_str( $source_url['query'], $query );
			
			$mfp_type = 'mfp-iframe';

			if ( isset( $query['v'] ) && $query['v'] != '' ) {
				$id = $query['v'];
			} else {
				$path = explode( "/", $source_url['path'] );
				$id = $path[count( $path )-1];
			}
			
			// if thumbnail is on, get first frame of video
			if ( $poster_size == "large" || $poster_size == "small" ) {
				// if poster image used, ignore thumbnail
				$thumbnail = '';

				if ( $poster_size == "large" ) 
					$size = "hqdefault.jpg";
				else 
					$size = "1.jpg";
			
				$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '"><img src="' . esc_url( sp_ssl_protocol() . '://img.youtube.com/vi/' . $id . '/' . $size ) . '" alt="' . esc_attr( $title ) . '" /><i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;	
			} else {
				$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '">' . PHP_EOL;

				// if thumbnail is set
				if ( isset( $thumbnail ) && ! empty( $thumbnail ) )
					$output .= '<img src="' . esc_url( $thumbnail ) . '" alt="' . esc_attr( $title ) . '" class="thumbnail" />' . PHP_EOL;
				else
					$output .= '<img src="' . esc_url( sp_no_image( 'small' ) ) . '" alt="' . esc_attr_e( 'No Image', 'sp-theme' ) . '" class="thumbnail" />' . PHP_EOL;

				$output .= do_shortcode( $content ) . '<i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;		
			}

		// check if source is from vimeo
		} elseif ( $source_url['host'] == 'www.vimeo.com' || $source_url['host'] == 'vimeo.com' || $source_url['host'] == 'player.vimeo.com' ) {
			$mfp_type = 'mfp-iframe';

			if ( isset( $query['clip_id'] ) && $query['clip_id'] != '' ) {
				$id = $query['clip_id'];
			} else {
				$path = explode( "/", $source_url['path'] );
				$id = $path[( count( $path )-1)];
			}

			// if thumbnail is on, get first frame of video
			if ( $poster_size == "large" || $poster_size == "small" ) {
				// if poster image used, ignore thumbnail
				$thumbnail = '';

				if ( function_exists( 'file_get_contents' ) ) {
					if ( $poster_size == "large" ) 
						$size = "thumbnail_large";
					else 
						$size = "thumbnail_small";
												
					$hash = maybe_unserialize( wp_remote_retrieve_body( wp_remote_get( sp_ssl_protocol() . '://vimeo.com/api/v2/video/' . $id . '.php', array( 'sslverify' => false ) ) ) );

					if ( isset( $hash[0] ) && $hash[0] != '' ) {
						$image = $hash[0][$size];	
					}
				}

				$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '"><img src="' . $image . '" alt="' . esc_attr( $title ) . '" /><i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;		
			} else {
				$output = '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '">' . PHP_EOL;

				// if thumbnail is set
				if ( isset( $thumbnail ) && ! empty( $thumbnail ) )
					$output .= '<img src="' . esc_url( $thumbnail ) . '" alt="' . esc_attr( $title ) . '" class="thumbnail" />' . PHP_EOL;
				else
					$output .= '<img src="' . esc_url( sp_no_image( 'small' ) ) . '" alt="' . esc_attr_e( 'No Image', 'sp-theme' ) . '" class="thumbnail" />' . PHP_EOL;

				$output .= do_shortcode( $content ) . '<i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;				
			}	

		// all others		
		} else {
			$mfp_type = 'mfp-image';

			$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '">' . PHP_EOL;

			// if thumbnail is set
			if ( isset( $thumbnail ) && ! empty( $thumbnail ) )
				$output .= '<img src="' . esc_url( $thumbnail ) . '" alt="' . esc_attr( $title ) . '" class="thumbnail" />' . PHP_EOL;
				else
					$output .= '<img src="' . esc_url( sp_no_image( 'small' ) ) . '" alt="' . esc_attr_e( 'No Image', 'sp-theme' ) . '" class="thumbnail" />' . PHP_EOL;

			$output .= do_shortcode( $content ) . '<i class="icon-resize-full" aria-hidden="true"></i></a>' . PHP_EOL;	

		}		
	} elseif ( ! empty( $content ) ) {
		$mfp_type = 'mfp-inline';

		$id = rand( 0, 1000 );
		$output .= '<a href="#content-' . esc_attr( $id ) . '" data-group="' . esc_attr( $group ) . '" class="lightbox ' . esc_attr( $mfp_type ) . '">' . $title . '</a>' . PHP_EOL;	
		$output .= '<div class="content mfp-hide" id="content-' . esc_attr( $id ) . '" style="display:none;">' . do_shortcode( $content ) . '</div><!--close .content-->' . PHP_EOL;
	}

	$output .= '</div><!--close sc-lightbox-->' . PHP_EOL;	
	
	return $output;
}

add_shortcode( 'sp-code', 'sp_shortcode_code' );

/**
 * Display raw code shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_shortcode_code( $atts, $content = null ) {
	$content = str_replace( '</p>', '\n', $content );
	$content = str_replace( '<p>', '', $content );
	$content = esc_attr( $content );
	$content = str_replace( '\n', '<br/>', trim( $content ) );
	$content = preg_replace( '/\[([^\]]*)\]/imu', '<strong>[</strong>$1<strong>]</strong>', $content );
	
	return '<pre>' . $content . '</pre>' . PHP_EOL;
}

add_shortcode( 'sp-check-login', 'sp_check_login_shortcode' );

/**
 * Check login shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_check_login_shortcode( $atts, $content = null ) {
	if ( is_user_logged_in() )
		return do_shortcode( $content );
}


add_shortcode( 'sp-blockquote', 'sp_blockquote_shortcode' );

/**
 * Blockquote shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_blockquote_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'text_align'		=> 'center', // left, right, center
		'custom_class'		=> ''
	), $atts ) );

	return '<blockquote class="sc-blockquote ' . esc_attr( $custom_class ) . '" style="text-align:' . esc_attr( $text_align ) . '"><p>' . do_shortcode( $content ) . '</p></blockquote>';
}

add_shortcode( 'sp-map', 'sp_google_map_shortcode' );

/**
 * Google map shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_google_map_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array( 
		'width'				=> '500', // 100%,auto
		'height'			=> '300', // must be set
		'zoom'				=> 15, 
		'address'			=> '1600 Amphitheatre Parkway Mountain View, CA 94043',
		'static'			=> 'false',
		'directions_link'	=> 'false'
	), $atts ) );

	$width = str_replace( 'px', '', $width );
	$height = str_replace( 'px', '', $height );

	$output = '';
	
	$output .= '<div class="sc-google-map">' . PHP_EOL;

	if ( $static === 'true' ) {

		$output .= '<div class="map"><img src="' . sp_ssl_protocol() . '://maps.apple.com/maps/api/staticmap?center=' . urlencode( $address ) . '&amp;zoom=' . esc_attr( $zoom ) . '&amp;size=' . esc_attr( $width ) . 'x' . esc_attr( $height ) . '&amp;sensor=false&amp;maptype=roadmap&amp;markers=color:red|' . urlencode( $address ) . '" alt="Google Map" /></div>' . PHP_EOL;	
	
	} else {
		$width = $width . 'px';
		$height = $height . 'px';

		$num = rand( 0, 10000 );
		
		$output .= '<script type="text/javascript">
					jQuery( document ).ready( function() {
					initialize("' . esc_js( $address ) . '",' . esc_js( $num ) . ',' . esc_js( $zoom ) . ');
					});
					</script><div id="map-' . esc_attr( $num ) . '" style="display:block; width:' . esc_attr( $width ) . '; height:' . esc_attr( $height ) . ';" class="map">&nbsp;</div>';
	}

	// add directions link if set
	if ( $directions_link === 'true' ) {
		$output .= '<a href="' . sp_ssl_protocol() . '://maps.apple.com/?q=' . urlencode( $address ) . '" title="' . esc_attr__( 'Map &amp; Directions', 'sp-theme' ). '" target="_blank" class="directions-link">' . __( 'Map &amp; Directions', 'sp-theme' ) . '</a>' . PHP_EOL;
	}

	$output .= '</div><!--close .sc-google-map-->' . PHP_EOL;

	return $output;
}

// check if action has already been added to prevent adding multiple times
if ( ! has_action( 'wp_footer', 'sp_google_map_script' ) ) {
	add_action( 'wp_footer', 'sp_google_map_script' );
}

// function to add google map js script
function sp_google_map_script() { ?>
	<script type="text/javascript" src="<?php echo sp_ssl_protocol(); ?>://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">var map;
	  function initialize(address, num, zoom) {
		var geo = new google.maps.Geocoder(),
		latlng = new google.maps.LatLng(-34.397, 150.644),
		myOptions = {
		  zoom: zoom,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		},
		map = new google.maps.Map(document.getElementById("map-" + num), myOptions);
		
		geo.geocode( { address: address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: map, 
				position: results[0].geometry.location
			});
		  }
		});
	  }			
	  </script>
<?php		
}

add_shortcode( 'sp-tabs', 'sp_tabs_shortcode' );

/**
 * Tabs shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_tabs_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'tab_names'			=> __( 'Tab1', 'sp-theme' ),
		'width'				=> 'auto',
		'collapsible'		=> 'false',
		'active'			=> 1,
		'style'				=> 'nav-top', // nav-top, nav-left
		'tab_icon'			=> '', // so user can add icons to tabs		
		'custom_class'		=> '' // so user can style the tabs
	), $atts ) );
	
	// explode into array
	$tab_titles = explode( ",", str_replace( ' ', '-', str_replace( ', ', ',', $tab_names ) ) );

	// explode into array
	$tab_icons = explode( ",", str_replace( ', ', ',', $tab_icon ) );

	$width = 'width:' . $width . 'px;';

	$output = '';

	$output .= '<div class="sc-tabs ' . esc_attr( $custom_class ) . ' ' . esc_attr( $style ) . '" style="' . esc_attr( $width ) . '">' . PHP_EOL;
	
	// check if style is nav left
	if ( $style === 'nav-left' )
		$output .= '<div class="' . esc_attr( sp_column_css( '', '', '', '3' ) ) . '">' . PHP_EOL;

	// build the tabs menu
	$output .= '<ul class="tabs">' . PHP_EOL;

	$i = 0;

	foreach ( $tab_titles as $title ) {
		if ( isset( $tab_icons[$i] ) )
			$icon = $tab_icons[$i];
		else 
			$icon = '';

		$output .= '<li>' . PHP_EOL;
		$output .= '<a href="#' . esc_attr( $title ) . '"><i class="' . esc_attr( $icon ) . '"></i> ' . esc_attr( str_replace( "-", " ", $title ) ) . '<i class="icon-angle-right"></i></a>' . PHP_EOL;
		$output .= '</li>' . PHP_EOL;

		$i++;
	}

	$output .= '</ul>' . PHP_EOL;		

	// check if style is nav left
	if ( $style === 'nav-left' ) {
		$output .= '</div><!--close .column-->' . PHP_EOL;

		$output .= '<div class="' . esc_attr( sp_column_css( '', '', '', '9' ) ) . '">' . PHP_EOL;
	}

	$output .= do_shortcode( $content ) . PHP_EOL;

	$output .= '<input type="hidden" class="collapsible" value="' . esc_js( $collapsible ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" class="active" value="' . esc_js( $active ) . '" />' . PHP_EOL;

	// check if style is nav left
	if ( $style === 'nav-left' )
		$output .= '</div><!--close .column-->' . PHP_EOL;

	$output .= '</div><!--close .sc-tabs-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-tab-content', 'sp_tabs_content_shortcode' );

/**
 * Tab content shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_tabs_content_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'tab'			=> 'Tab1',
		'text_color'	=> ''
		), $atts ) );

	if ( isset( $text_color ) && ! empty( $text_color ) )
		$style = 'color:#' . str_replace( '#', '', $text_color );
	else
		$style = '';

	$output = '';	
	
	$output .= '<div id="' . esc_attr( str_replace( ' ', '-', $tab ) ) . '" class="sc-tabs-container ui-tabs-hide" style="' . esc_attr( $style ) . '">' . PHP_EOL;
	$output .= do_shortcode( $content ) . PHP_EOL;
	$output .= '</div><!--close .tabs-container-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-carousel', 'sp_carousel_shortcode' );

/**
 * Carousel shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_carousel_shortcode( $atts, $contents = null ) {
	if ( sp_hide_on_mobile() ) {
		return;
	}

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'id'				=> '1',
		'custom_class'		=> ''
	), $atts ) );

	$output = '';

	$output .= '<div class="sc-carousel clearfix ' . esc_attr( $custom_class ) . '">' . PHP_EOL;

	$output .= sp_display_carousel_slider( $id ) . PHP_EOL;

	$output .= '</div><!--close .sc-carousel-->' . PHP_EOL;
	
	return $output;
}

add_shortcode( 'sp-accordion', 'sp_accordion_shortcode' );

/**
 * Accordion shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_accordion_shortcode( $atts, $contents = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'collapsible'		=> true,
		'active_panel'		=> 1,
		'style'				=> '1', // 1/2
		'custom_class'		=> ''
	), $atts ) );

	$output = '';
	$output .= '<div class="sc-accordion ' . esc_attr( $custom_class ) . ' style-' . esc_attr( $style ) . '">' . PHP_EOL;
	$output .= do_shortcode( $contents ) . PHP_EOL;
	$output .= '<input type="hidden" name="collapsible" value="' . esc_js( $collapsible ) . '" />' . PHP_EOL;
	$output .= '<input type="hidden" name="active_panel" value="' . esc_js( $active_panel ) . '" />' . PHP_EOL;
	$output .= '</div>' . PHP_EOL;
	
	// enqueue jquery ui accordion
	wp_enqueue_script( 'jquery-ui-accordion' );

	return $output;
}

add_shortcode( 'sp-accordion-content', 'sp_accordion_content_shortcode' );

/**
 * Accordion content shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_accordion_content_shortcode( $atts, $contents = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'title' => __( 'Title of Accordion', 'sp-theme' ),
		'icon'	=> ''
	), $atts ) );
	
	$output = '';
	$output .= '<h3 class="clearfix"><span class="' . esc_attr( $icon ) . '"></span> ' . $title . '<i class="handle icon-angle-up" aria-hidden="true"></i></h3>' . PHP_EOL;
	$output .= '<div class="content"><p>' . PHP_EOL;
	$output .= do_shortcode( $contents ) . PHP_EOL;
	$output .= '</p></div>' . PHP_EOL;
	
	return $output;
}

add_shortcode( 'sp-callout', 'sp_callout_shortcode' );

/**
 * Callout shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_callout_shortcode( $atts, $contents = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'type'				=> 'alert-info', // alert-info, alert-warning, alert-danger, alert-success
		'title'				=> __( 'Alert Title', 'sp-theme' ),
		'icon'				=> '',
		'custom_class'		=> ''
	), $atts ) );

	$output = '';

	$output .= '<div class="sc-callout ' . esc_attr( $type ) . ' ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	$output .= '<h3><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i> ' . $title . '</h3>' . PHP_EOL;
	$output .= '<div class="content clearfix">' . PHP_EOL;
	$output .= do_shortcode( $contents );
	$output .= '</div></div>' . PHP_EOL;
	
	return $output;	
}

add_shortcode( 'sp-dropcap', 'sp_dropcap_shortcode' );

/**
 * Dropcaps shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_dropcap_shortcode( $atts, $contents = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'size'	=> '60',
		'color'	=> '#800000',
		'bg_color' => '',
		'bg_style' => '' // square, circle
	), $atts ) );
	
	$size = str_replace( 'px', '', $size );
	$size = ( ( int ) $size < 50 ) ? 60 : $size;
	$size = $size . 'px';

	$color = str_replace( '#', '', $color );

	$padding = '';

	if ( isset( $bg_color ) && ! empty( $bg_color ) ) {
		$padding = 'padding:4px 12px;';
		$bg_color = 'background-color:#' . str_replace( '#', '', $bg_color ) . ';';

		if ( $bg_style === 'circle' ) {
			$bg_style = 'border-radius:20em;';
			$padding = 'padding:0;line-height:' . absint( $size * 1.017 ) . 'px;height:' . absint( $size * 1.017 ) . 'px;width:' . absint( $size * 1.017 ) . 'px;text-align:center;';
		}
	}

	$output = '';
	$output .= '<span class="sc-dropcap" style="font-size:' . esc_attr( $size ) . ';color:#' . esc_attr( $color ) . ';' . esc_attr( $bg_color ) . esc_attr( $padding ) . esc_attr( $bg_style ) . '">';
	$output .= $contents;
	$output .= '</span>' . PHP_EOL;
	
	return $output;	
}

add_shortcode( 'sp-contact', 'sp_contact_shortcode' );

/**
 * Contact Form shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_contact_shortcode( $atts, $contents = null ) {
	global $post;

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'id'				=> '',
		'custom_class'		=> ''
	), $atts ) );

	if ( empty( $id ) )
		return false;

	// build the contact form argument
	$args = array (
		'post_type'			=> 'sp-contact-form',
		'post_status'		=> 'publish',
		'posts_per_page'	=> 1,
		'p'					=> absint( $id )
	);	

	$form = new WP_Query( $args ); 

	// bail if no posts found
	if ( ! $form->have_posts() )
		return;

	while ( $form->have_posts() ) : $form->the_post();	

		// get the list of saved post meta
		$email_to				= get_post_meta( $post->ID, '_sp_contact_form_email_to', true );
		$email_subject			= get_post_meta( $post->ID, '_sp_contact_form_email_subject', true );
		$redirect				= get_post_meta( $post->ID, '_sp_contact_form_redirect', true );
		$redirect_url			= get_post_meta( $post->ID, '_sp_contact_form_redirect_url', true );
		$show_reset 			= get_post_meta( $post->ID, '_sp_contact_form_show_reset', true );
		$field_type				= get_post_meta( $post->ID, '_sp_contact_form_field_type', true );
		$field_label			= get_post_meta( $post->ID, '_sp_contact_form_field_label', true );
		$required_field			= get_post_meta( $post->ID, '_sp_contact_form_required_field', true );
		$unique_tag_name		= get_post_meta( $post->ID, '_sp_contact_form_unique_tag_name', true );
		$field_options			= get_post_meta( $post->ID, '_sp_contact_form_field_options', true );	
		$header_text			= get_post_meta( $post->ID, '_sp_contact_form_header_text', true );
		$submit_button_text		= get_post_meta( $post->ID, '_sp_contact_form_submit_button_text', true );
		$reset_button_text		= get_post_meta( $post->ID, '_sp_contact_form_reset_button_text', true );
		$success_message		= get_post_meta( $post->ID, '_sp_contact_form_success_message', true );
		$failure_message		= get_post_meta( $post->ID, '_sp_contact_form_failure_message', true );
		$from_email				= get_post_meta( $post->ID, '_sp_contact_form_from_email', true );
		$required_field_text	= get_post_meta( $post->ID, '_sp_contact_form_required_field_text', true );	
		$email_template			= get_post_meta( $post->ID, '_sp_contact_form_email_template', true );	

	endwhile;
	wp_reset_postdata();
	
	// on submit - validate/sanitize
	if ( isset( $_POST['submit'] ) && $_POST['submit'] === 'submit-contact-form' && wp_verify_nonce( $_POST['_sp_submit_contact_form_nonce'], 'sp_submit_contact_form' ) ) {
		// do nothing as we want to handle this via AJAX
		// dump the post just in case
		unset( $_POST );		
	}

	$output = '';

	$output .= '<div class="sc-contact-form ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	
	// form header
	if ( isset( $header_text ) && ! empty( $header_text ) )
		$output .= '<h2 class="form-header">' . $header_text . '</h2>' . PHP_EOL;

	// required field text
	if ( isset( $required_field_text ) && ! empty( $required_field_text ) )
		$output .= '<small class="required-field-text"><span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span> - ' . $required_field_text . '</small>' . PHP_EOL;

	$output .= '<form method="post" action="#">' . PHP_EOL;

	// count how many fields we need to loop
	$fields = count( $field_type );

	// if more than 0 fields
	if ( $fields > 0 ) {
		// perform the loop
		for ( $i = 1; $i <= $fields; $i++ ) {
			switch( $field_type['field_' . $i] ) {
				case 'text' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<input type="text" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" value="" class="form-control" ' . $required_attr . ' />' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'email' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<input type="email" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" value="" class="form-control" ' . $required_attr . ' />' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'textarea' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<textarea name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" rows="10" class="form-control" ' . $required_attr . '></textarea>' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'radio' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label class="field-label control-label">' . $field_label['field_' . $i] . '</label>' . PHP_EOL;
					foreach( $field_options['field_' . $i] as $options ) {
						$output .= '<label for="' . esc_attr( strtolower( str_replace( ' ', '-', $options ) ) ) . '" class="options-label"><input type="radio" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( strtolower( str_replace( ' ', '-', $options ) ) ) . '" value="' . esc_attr( strtolower( str_replace( ' ', '_', $options ) ) ) . '" /> ' . $options . ' </label>' . PHP_EOL;
					}
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'checkbox' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<div class="checkbox">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label"><input type="checkbox" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" value="true" /> ' . $field_label['field_' . $i] . ' </label>' . PHP_EOL;
					$output .= '</div><!--close .checkbox-->' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'select' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<select name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="select2-select" data-placeholder="' . apply_filters( 'sp_contact_form_please_select_text', __( '--Please Select--', 'sp-theme' ) ) . '" data-no_results_text="' . esc_attr__( 'No Results', 'sp-theme' ) . '" ' . $required_attr . '>' . PHP_EOL;
					$output .= '<option value="' . esc_attr__( '[no input from user]', 'sp-theme' ) . '">' . apply_filters( 'sp_contact_form_please_select_text', __( '--Please Select--', 'sp-theme' ) ) . '</option>' . PHP_EOL;
					foreach( $field_options['field_' . $i] as $options ) {
						$output .= '<option value="' . esc_attr( strtolower( str_replace( ' ', '_', $options ) ) ) . '">' . $options . '</option>' . PHP_EOL;
					}						

					$output .= '</select>' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'multiselect' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<select name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '[]" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="select2-select" multiple="multiple" data-placeholder="' . apply_filters( 'sp_contact_form_please_select_text', esc_attr__( '--Please Select--', 'sp-theme' ) ). '" ' . $required_attr . '>' . PHP_EOL;

					foreach( $field_options['field_' . $i] as $options ) {
						$output .= '<option value="' . esc_attr( strtolower( str_replace( ' ', '_', $options ) ) ) . '">' . $options . '</option>' . PHP_EOL;
					}						

					$output .= '</select>' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'datepicker' :
					// enqueue scripts for datepicker
					wp_enqueue_script( 'jquery-ui-datepicker' );
					
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<input type="text" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" value="" class="form-control datepicker" ' . $required_attr . ' />' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'datetimepicker' :
					// enqueue scripts for datepicker
					wp_enqueue_script( 'jquery-ui-datepicker' );
					wp_enqueue_script( 'jquery-ui-slider' );
					wp_register_script( apply_filters( 'sp_jquery_timepicker', 'jquery_timepicker' ), THEME_URL . 'js/jquery-timepicker.min.js', null, '1.3', true );
					wp_enqueue_script( apply_filters( 'sp_jquery_timepicker', 'jquery_timepicker' ) );
					
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<input type="text" name="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" value="" class="form-control datetimepicker" ' . $required_attr . ' />' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'captcha' :
					// check if field is required
					if ( $required_field['field_' . $i] === 'on' ) {
						$show_required = '<span class="required">' . apply_filters( 'sp_contact_form_sc_required_symbol', '*' ) . '</span>';
						$required_attr = 'data-required="required"';
					} else {
						$show_required = '';
						$required_attr = '';
					}

					$output .= '<div class="form-group">' . PHP_EOL;
					$output .= '<img id="captcha" src="' . THEME_URL . 'securimage/securimage_show.php" alt="' . esc_attr__( 'CAPTCHA Image', 'sp-theme' ). '" />' . PHP_EOL;
					$output .= '<label for="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" class="field-label control-label">' . $field_label['field_' . $i] . ' ' . $show_required . '</label>' . PHP_EOL;
					$output .= '<input type="text" name="captcha_code" id="' . esc_attr( $unique_tag_name['field_' . $i] ) . '" size="10" maxlength="6" class="form-control" ' . $required_attr . ' /><a href="#" onclick="' . esc_js( 'document.getElementById("captcha").src="' . THEME_URL . 'securimage/securimage_show.php?" + Math.random(); return false' ) . '" class="reset-captcha">[ ' . __( 'Different Image', 'sp-theme' ) . ' ]</a>' . PHP_EOL;
					$output .= '</div><!--close .form-group-->' . PHP_EOL;
					break;

				case 'heading' :
					$output .= '<h3 class="section-heading">' . $field_label['field_' . $i ] . '</h3>' . PHP_EOL;
					break;

				case 'separator' :
					$output .= '<hr class="separator" />' . PHP_EOL;
			} // end switch
		} // end for loop
		$output .= '<p class="alert alert-success"><button class="close" data-dismiss="alert" type="button">&times;</button>' . $success_message . '</p>' . PHP_EOL;
		$output .= '<p class="alert alert-warning"><button class="close" data-dismiss="alert" type="button">&times;</button>' . $failure_message . '</p>' . PHP_EOL;
		$output .= '<div class="form-actions clearfix">' . PHP_EOL;
		
		// check if we need to show reset
		if ( isset( $show_reset ) && $show_reset === 'on' )
			$output .= '<button type="reset" class="btn">' . $reset_button_text . '</button>' . PHP_EOL;

		$output .= '<button type="submit" class="btn btn-primary" name="submit" value="submit-contact-form"><i class="loader" aria-hidden="true"></i> ' . $submit_button_text . '</button>' . PHP_EOL;
		$output .= '</div><!--close .form-actions-->' . PHP_EOL;
	} // end have fields
	$output .= '<input type="hidden" name="cf_id" value="' . esc_attr( $id ) . '" />' . PHP_EOL;
	$output .= wp_nonce_field( 'sp_submit_contact_form', '_sp_submit_contact_form_nonce', true, false );
	$output .= '</form>' . PHP_EOL;
	$output .= '</div><!--close .sc-contact-form-->' . PHP_EOL;
	
	return $output;	
}

add_shortcode( 'sp-faq', 'sp_faq_shortcode' );

/**
 * FAQ shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_faq_shortcode( $atts, $content = null ) {
	global $post;

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'category'			=> '',
		'title'				=> '', // section title
		'icon'				=> '', // icon class from icon fonts
		'collapsible'		=> 'true',
		'custom_class'		=> ''
	), $atts ) );	

	if ( empty( $category ) )
		return false;

	// build the faq argument
	$args = array (
		'post_type'			=> 'sp-faq',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1,
		'order'             => 'ASC',
		'orderby'           => 'meta_value_num',
		'meta_key'          => '_sp_post_faq_order',
		'tax_query' => array(
			array(
				'taxonomy' => 'sp-faq-categories',
				'field' => 'id',
				'terms' => absint( $category )
			)
		)
	);	

	$faq = new WP_Query( $args ); 

	// return if no posts found
	if ( $faq->found_posts <= 0 ) {
		return;
	}

	$output = '';

	$output .= '<div class="sc-faq ' . esc_attr( $custom_class ) . '">' . PHP_EOL;

	if ( isset( $title ) && ! empty( $title ) )
		$output .= '<h2 class="section-title"><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i> ' . $title . '</h2>' . PHP_EOL;

	while ( $faq->have_posts() ) : $faq->the_post();

		$output .= '<h3 class="entry-title"><i class="icon-plus" aria-hidden="true"></i> <a href="#" title="' . esc_attr( get_the_title() ) . '">' . get_the_title() . '</a></h3>' . PHP_EOL;
		$output .= '<div class="answer"><p>' . get_the_content() . '</p></div>' . PHP_EOL;

	endwhile;

	wp_reset_postdata();
	
	$output .= '<input type="hidden" name="collapsible" value="' . esc_attr( $collapsible ) . '" />' . PHP_EOL;
	$output .= '</div><!--close .sc-faq-->' . PHP_EOL;	

	// enqueue jquery ui accordion
	wp_enqueue_script( 'jquery-ui-accordion' );

	return $output;
}

add_shortcode( 'sp-register', 'sp_register_shortcode' );

/**
 * Member Register shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_register_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'firstname'			=> 'false', // true will allow visitors to input firstname
		'lastname'			=> 'false', // true will allow visitors to input lastname
		'captcha'			=> 'false',
		'title'				=> apply_filters( 'sp_sc_register_form_title', __( 'Register', 'sp-theme' ) ),		
		'from_email'		=> get_bloginfo( 'admin_email' ),
		'custom_class'		=> ''
	), $atts ) );	

	$output = '';

	$output .= '<div class="sc-register-form ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	$output .= '<div class="heading clearfix">' . PHP_EOL;
	$output .= '<h3 class="title"><span>' . $title . '</span></h3>' . PHP_EOL;
	$output .= '<div class="meta clearfix">' . PHP_EOL;
	$output .= '<i class="icon-user" aria-hidden="true"></i><p class="tagline-wrapper clearfix"><span class="tagline">' . apply_filters( 'sp_sc_register_form_tagline', __( 'New Customer?', 'sp-theme' ) ) . '</span>' . PHP_EOL;
	$output .= '<span class="sub-tagline">' . apply_filters( 'sp_sc_register_form_sub_tagline', __( 'Please create your account.', 'sp-theme' ) ) . '</span></p>' . PHP_EOL;
	$output .= '</div><!--close .meta-->' . PHP_EOL;
	$output .= '</div><!--close .heading-->' . PHP_EOL;	
	$output .= '<form action="#" method="post">' . PHP_EOL;
	
	if ( isset( $firstname ) && $firstname === 'true' ) {
		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label class="field-label control-label">' . __( 'First Name', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<input type="text" name="firstname" class="form-control" data-required="required" tabindex="1" />' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;
	}

	if ( isset( $lastname ) && $lastname === 'true' ) {
		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label class="field-label control-label">' . __( 'Last Name', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<input type="text" name="lastname" class="form-control" data-required="required" tabindex="2" />' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;
	}

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'Username', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="text" name="username" class="form-control" data-required="required" tabindex="3" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'Email', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="text" name="email" class="form-control" data-required="required" tabindex="4" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'Confirm Email', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="text" name="confirm_email" class="form-control" data-required="required" tabindex="5" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;

	if ( isset( $captcha ) && $captcha === 'true' ) {
		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<img id="captcha" src="' . THEME_URL . 'securimage/securimage_show.php" alt="' . esc_attr__( 'CAPTCHA Image', 'sp-theme' ). '" />' . PHP_EOL;
		$output .= '<label class="field-label control-label">' . __( 'Enter the characters you see in the image', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<input type="text" name="captcha_code" size="10" maxlength="6" class="form-control" data-required="required" tabindex="6" /><a href="#" onclick="' . esc_js( 'document.getElementById("captcha").src="' . THEME_URL . 'securimage/securimage_show.php?" + Math.random(); return false' ) . '" class="reset-captcha">[ ' . __( 'Different Image', 'sp-theme' ) . ' ]</a>' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;
	}

	$output .= '<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;	
	$output .= '<div class="form-actions clearfix">' . PHP_EOL;
	$output .= '<button type="submit" class="btn btn-primary" name="submit" value="submit-register-form"><i class="loader" aria-hidden="true"></i> ' . __( 'Register', 'sp-theme' ) . '</button>' . PHP_EOL;
	$output .= '</div><!--close .form-actions-->' . PHP_EOL;

	$output .= wp_nonce_field( 'sp_submit_register_form', '_sp_submit_register_form_nonce', true, false );
	$output .= '<input type="hidden" name="from_email" value="' . str_replace( '@', '*', esc_attr( $from_email ) ) . '" />' . PHP_EOL;
	$output .= '</form>' . PHP_EOL;
	$output .= '</div><!--close .sc-register-form-->' . PHP_EOL;

	// check if users can register
	if ( false === sp_users_can_register() )
		$output = '<div class="sc-register-form"><p>' . __( 'Sorry, new registration is not allowed at this time.', 'sp-theme' ) . '</p></div>' . PHP_EOL;
	
	return $output;
}

add_shortcode( 'sp-login', 'sp_login_shortcode' );

/**
 * Member Login shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_login_shortcode( $atts, $content = null ) {
	global $post;

	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'redirect_to'		=> '',
		'forgot_password'	=> 'true',
		'title'				=> apply_filters( 'sp_sc_login_form_title', __( 'Login', 'sp-theme' ) ),
		'custom_class'		=> ''
	), $atts ) );	

	$output = '';

	// check if the user is already logged in
	if ( ! is_user_logged_in() ) {
		$output .= '<div class="sc-login-form login ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
		$output .= '<div class="heading clearfix">' . PHP_EOL;
		$output .= '<h3 class="title"><span>' . $title . '</span></h3>' . PHP_EOL;
		$output .= '<div class="meta clearfix">' . PHP_EOL;
		$output .= '<i class="icon-signin" aria-hidden="true"></i><p class="tagline-wrapper clearfix"><span class="tagline">' . apply_filters( 'sp_sc_login_form_tagline', __( 'Already have an account?', 'sp-theme' ) ) . '</span>' . PHP_EOL;
		$output .= '<span class="sub-tagline">' . apply_filters( 'sp_sc_login_form_sub_tagline', __( 'Please log in.', 'sp-theme' ) ) . '</span></p>' . PHP_EOL;
		$output .= '</div><!--close .meta-->' . PHP_EOL;
		$output .= '</div><!--close .heading-->' . PHP_EOL;
		$output .= '<form action="#" method="post">' . PHP_EOL;

		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label class="field-label control-label">' . __( 'Username', 'sp-theme' ) . '</label>' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<input type="text" name="username" class="form-control" data-required="required" tabindex="1" />' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;

		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<label class="field-label control-label">' . __( 'Password', 'sp-theme' ) . '</label>' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<input type="password" name="password" class="form-control" data-required="required" tabindex="2" />' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;	

		$output .= '<div class="form-group">' . PHP_EOL;
		$output .= '<div class="controls">' . PHP_EOL;
		$output .= '<label class="field-label control-label"><input type="checkbox" name="rememberme" tabindex="3" /> ' . __( 'Remember Me', 'sp-theme' ) . '</label>' . PHP_EOL;
		$output .= '</div><!--close .controls-->' . PHP_EOL;
		$output .= '</div><!--close .form-group-->' . PHP_EOL;

		$output .= '<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;	
		$output .= '<div class="form-actions clearfix">' . PHP_EOL;
		$output .= '<button type="submit" class="btn btn-primary" name="submit" value="submit-login-form"><i class="loader" aria-hidden="true"></i> ' . __( 'Login', 'sp-theme' ) . '</button>' . PHP_EOL;

		// check show forgot
		if ( isset( $forgot_password ) && $forgot_password === 'true' ) {
			$output .= '<a href="#" class="forgot-password" title="' . esc_attr__( 'Forgot Password', 'sp-theme' ) . '">' . __( 'Forgot Password?', 'sp-theme' ) . '</a>' . PHP_EOL;
		}

		$output .= '</div><!--close .form-actions-->' . PHP_EOL;

		$output .= wp_nonce_field( 'sp_submit_login_form', '_sp_submit_login_form_nonce', true, false );

		// check redirect set
		if ( isset( $redirect_to ) && ! empty( $redirect_to ) )
			$output .= '<input type="hidden" name="redirect_to" value="' . esc_attr( $redirect_to ) . '" />' . PHP_EOL;

		$output .= '</form>' . PHP_EOL;
		$output .= '</div><!--close .sc-login-form-->' . PHP_EOL;

		// show forgot
		if ( isset( $forgot_password ) && $forgot_password === 'true' ) {
			$output .= '<div class="sc-login-form forgot ' . esc_attr( $custom_class ) . '" style="display:none;">' . PHP_EOL;
			$output .= '<div class="heading clearfix">' . PHP_EOL;
			$output .= '<h3 class="title"><span>' . apply_filters( 'sp_sc_login_form_forgot_password_title', __( 'Forgot Password', 'sp-theme' ) ) . '</span></h3>' . PHP_EOL;
			$output .= '</div><!--close .heading-->' . PHP_EOL;
			$output .= '<form action="#" method="post">' . PHP_EOL;

			$output .= '<div class="form-group">' . PHP_EOL;
			$output .= '<label class="field-label control-label">' . __( 'Username or Email', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
			$output .= '<div class="controls">' . PHP_EOL;
			$output .= '<input type="text" name="user_login" class="form-control" data-required="required" tabindex="1" />' . PHP_EOL;
			$output .= '</div><!--close .controls-->' . PHP_EOL;
			$output .= '</div><!--close .form-group-->' . PHP_EOL;

			$output .= '<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;	
			$output .= '<div class="form-actions clearfix">' . PHP_EOL;
			$output .= '<button type="submit" class="btn btn-primary" name="submit" value="submit-login-forgot-form"><i class="loader" aria-hidden="true"></i> ' . __( 'Reset Password', 'sp-theme' ) . '</button>' . PHP_EOL;
			$output .= '<a href="#" class="remember-password" title="' . esc_attr__( 'Remember Password', 'sp-theme' ) . '">' . __( 'I Remember My Login!', 'sp-theme' ) . '</a>' . PHP_EOL;
			$output .= '</div><!--close .form-actions-->' . PHP_EOL;

			$output .= wp_nonce_field( 'sp_submit_login_forgot_form', '_sp_submit_login_forgot_form_nonce', true, false );

			$output .= '</form>' . PHP_EOL;
			$output .= '</div><!--close .sc-login-form-->' . PHP_EOL;
		}
	} else {
		$output .= '<p class="alert main alert-success">' . __( 'You\'re already logged in', 'sp-theme' ) . '</p>';
	}

	return $output;	
}

add_shortcode( 'sp-change-password', 'sp_change_password_shortcode' );

/**
 * Change Password shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_change_password_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'strong_password'	=> 'true', // checks if user entered password meets requirements
		'custom_class'		=> ''
	), $atts ) );	

	$output = '';

	$output .= '<div class="sc-change-password-form ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	$output .= '<div class="heading clearfix">' . PHP_EOL;
	$output .= '<h3 class="title"><i class="icon-locked"></i> ' . __( 'Change Password', 'sp-theme' ) . '</h3>' . PHP_EOL;

	if ( $strong_password === 'true' )
		$output .= '<p><em>' . __( 'Your password needs to be at least 8 characters long with a combination of upper and lower case letters, a number and a special character like "@, #, %, $".', 'sp-theme' ) . '</em></p>' . PHP_EOL;

	$output .= '</div><!--close .heading-->' . PHP_EOL;
	$output .= '<form action="#" method="post">' . PHP_EOL;

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'Current Password', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="text" name="current_password" class="form-control" data-required="required" tabindex="1" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'New Password', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="password" name="new_password" class="form-control" data-required="required" tabindex="2" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;	

	$output .= '<div class="form-group">' . PHP_EOL;
	$output .= '<label class="field-label control-label">' . __( 'Confirm Password', 'sp-theme' ) . ' <span class="required">*</span></label>' . PHP_EOL;
	$output .= '<div class="controls">' . PHP_EOL;
	$output .= '<input type="password" name="confirm_password" class="form-control" data-required="required" tabindex="3" />' . PHP_EOL;
	$output .= '</div><!--close .controls-->' . PHP_EOL;
	$output .= '<p class="alert"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;
	$output .= '</div><!--close .form-group-->' . PHP_EOL;	

	$output .= '<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>' . PHP_EOL;	
	$output .= '<div class="form-actions clearfix">' . PHP_EOL;
	$output .= '<button type="submit" class="btn btn-primary" name="submit" value="submit-change-password-form"><i class="loader" aria-hidden="true"></i> ' . __( 'Change Password', 'sp-theme' ) . '</button>' . PHP_EOL;

	$output .= '</div><!--close .form-actions-->' . PHP_EOL;

	$output .= wp_nonce_field( 'sp_submit_change_password_form', '_sp_submit_change_password_form_nonce', true, false );

	// check strong password setting
	if ( $strong_password === 'true' )
		$output .= '<input type="hidden" name="strong_password" value="' . esc_attr( $strong_password ) . '" />' . PHP_EOL;

	$output .= '</form>' . PHP_EOL;
	$output .= '</div><!--close .sc-forgot-password-form-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-imagelinkbox', 'sp_imagelinkbox_shortcode' );

/**
 * Image Link shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_imagelinkbox_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'url'				=> get_permalink(), // use default page url if none set
		'img'				=> '',
		'link_text'			=> '', // optional link text
		'custom_class'		=> ''		
	), $atts ) );  

	$output = '';
	$output .= '<div class="sc-imagelinkbox ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $link_text ) . '">' . PHP_EOL;
	$output .= '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $link_text ) . '" />' . PHP_EOL;

	// if set then show
	if ( isset( $link_text ) && ! empty( $link_text ) )
		$output .= '<h3 class="clearfix">' . esc_attr( $link_text ) . '<i class="icon-angle-right" aria-hidden="true"></i></h3></a>' . PHP_EOL;

	$output .= '</div><!--close .sc-imagelink-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-product-slider', 'sp_product_slider_shortcode' );

/**
 * Product slider shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_product_slider_shortcode( $atts, $content = null ) {
	if ( sp_hide_on_mobile() ) {
		return;
	}

	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'custom_pick'			=> '', // get product ids ( supercedes categories )
		'categories'			=> '', // category ids | can be comma separated list
		'title'					=> __( 'Latest Arrivals', 'sp-theme' ),
		'count'					=> '6', // how many items to return
		'randomize'				=> 'true',
		'width'					=> '', 
		'order'					=> 'DESC',
		'items_visible'			=> '3', // how many items visible in the carousel at once
		'min_items'				=> '2', // how many items at minimum to show
		'auto_scroll'			=> 'false',
		'auto_scroll_interval'	=> '6000',
		'transition_speed'		=> '200',
		'circular'				=> 'true',
		'show_nav'				=> 'true',
		'items_per_click'		=> '1', // how many items to scroll by per click
		'easing'				=> 'easeInOutQuad',
		'pause_on_hover'		=> 'true',
		'custom_class'			=> ''	
	), $atts ) );  

	$output = '';

	$output .= '<div class="sc-product-slider clearfix ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	
	if ( sp_woo_exists() ) 
		$output .= wc_print_notices() . PHP_EOL;

	// check if we need to display title
	if ( isset( $title ) && ! empty( $title ) )
		$output .= '<h2 class="section-title title-with-line"><span>' . $title . '</span></h2>' . PHP_EOL;

	//$output .= '<div class="carousel-container">' . PHP_EOL;

	$products = sp_get_products( $custom_pick, $categories, $count, $order, $randomize );

	if ( sp_woo_exists() )
		$output .= sp_display_slider_products( $products );

	// get user set image width
	if ( empty( $width ) || ! isset( $width ) ) {
		$catalog_image_size = get_option( 'shop_catalog_image_size' ); 
		$catalog_image_size = $catalog_image_size['width'];
	} else {
		$catalog_image_size = str_replace( 'px', '', $width );
	}

	$options = array(
			'slider_items_to_show'			=> $items_visible,
			'slider_min_items'				=> $min_items,
			'slider_autoscroll'				=> $auto_scroll,
			'slider_interval'				=> $auto_scroll_interval,
			'slider_nav'					=> $show_nav,
			'slider_transition_speed'		=> $transition_speed,
			'slider_carousel_item_width'	=> $catalog_image_size,
			'slider_circular'				=> $circular,
			'slider_items_per_click'		=> $items_per_click,
			'slider_easing'					=> $easing,
			'slider_pause_on_hover'			=> $pause_on_hover
		);

	$output .= '<input type="hidden" name="slider_options" value="' . esc_attr( json_encode( $options ) ) . '" />' . PHP_EOL;
	//$output .= '</div><!--close .carousel-container-->' . PHP_EOL;

	$output .= '</div><!--close .sc-product-slider-->' . PHP_EOL;

	wp_enqueue_script( 'wc-add-to-cart-variation' );
	
	return $output;
}

add_shortcode( 'sp-image-link', 'sp_image_link_shortcode' );

/**
 * Simple image link shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_image_link_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'image_url'		=> '', // url to the image
		'link_url'		=> '', // url to link to
		'title'			=> '', // title of the link
		'custom_class'	=> '' 
	), $atts ) ); 

	$output = '';

	$output .= '<a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '" class="sc-image-link ' . esc_attr( $custom_class ) . '"><img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" /></a>' . PHP_EOL;

	return $output;
}

//add_shortcode( 'sp-show-header', 'sp_show_header_shortcode' );

/**
 * Shows the header shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_show_header_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'show_bg_color'	=> 'true', // shows the background color otherwise transparent;
		'bg_color'		=> '', // sets custom color or uses default theme's color
		'text_color'	=> '', // sets the text color
		'custom_title'	=> '', // if set, it will override default page title
		'tagline_text'	=> '' // if set, it will show tagline next to heading
	), $atts ) );

	// check if custom title is used
	if ( isset( $custom_title ) && ! empty( $custom_title ) )
		$title = $custom_title;
	else
		$title = get_the_title();

	// check background color
	if ( isset( $bg_color ) && ! empty( $bg_color ) )
		$color = 'background-image:none;background-color:#' . str_replace( '#', '', $bg_color ) . ';';
	else
		$color = '';

	// check for text color
	if ( isset( $text_color ) && ! empty( $text_color ) )
		$text_color = 'color:#' . str_replace( '#', '', $text_color ) . ';';
	else
		$text_color = '';

	// check if show background color is off
	if ( ! isset( $show_bg_color ) || $show_bg_color !== 'true' )
		$color = 'background-image:none;background-color:transparent;';

	$output = '';

	$output .= '<header class="header-entry" style="' . esc_attr( $color ) . ' ' . esc_attr( $text_color ) . '">' . PHP_EOL;
	$output .= '<div class="container">' . PHP_EOL;

	if ( isset( $tagline_text ) && ! empty( $tagline_text ) )
		$output .= '<h1 class="entry-title">' . $title . '<span class="heading-tagline"> - ' . sanitize_text_field( $tagline_text ) . '</span></h1>' . PHP_EOL;
	else
		$output .= '<h1 class="entry-title">' . $title . '</h1>' . PHP_EOL;

	$output .= '</div><!--close .container-->' . PHP_EOL;
	$output .= '</header><!--close .header-entry-->' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-tooltip', 'sp_tooltip_shortcode' );

/**
 * Tooltip shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_tooltip_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(
		'position'		=> 'top', // top, left, right, bottom
		'url'			=> '', // url of the link
		'tooltip_title'	=> '', // title of the tooltip
		'link_name'		=> '' // name of the link
	), $atts ) );

	$output = '';
	$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $tooltip_title ) . '" data-toggle="tooltip" data-placement="' . esc_attr( $position ) . '" class="sp-tooltip">' . $link_name . '</a>' . PHP_EOL;

	return $output;
}

add_shortcode( 'sp-linebreaks', 'sp_linebreaks_shortcode' );

/**
 * Linebreaks shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_linebreaks_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'linebreaks' => '2' // sets how many line breaks to insert
	), $atts ) );

	$output = '';

	if ( empty( $linebreaks ) )
		$linebreaks = 2;

	for ( $i = 1; $i <= (int)$linebreaks; $i++ ) {
		$output .= '<br />';
	}

	return $output;
}

add_shortcode( 'sp-bio-card', 'sp_bio_card_shortcode' );

/**
 * Bio Card shortcode
 *
 * @access public
 * @since 3.0
 * @param array $atts | the attributes passed in
 * @param string $content | the content passed in
 * @return html $output | the shortcode
 */
function sp_bio_card_shortcode( $atts, $content = null ) {
	// extracts the attributes into variables
	extract( shortcode_atts( array(  
		'photo'			=> '', // url of the photo
		'name'			=> '', // name of the person
		'title'			=> '', // title of the person
		'email'			=> '', // email address of the person
		'twitter_name'	=> '', // twitter account name to follow
		'custom_class'	=> ''
	), $atts ) );

	$output = '';

	$output .= '<div class="sc-bio-card clearfix ' . esc_attr( $custom_class ) . '">' . PHP_EOL;
	$output .= '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr__( 'Photo', 'sp-theme' ) . '" width="150" height="150" />' . PHP_EOL;
	$output .= '<p class="name">' . $name . '</p>' . PHP_EOL;

	if ( isset( $title ) && ! empty( $title ) )
		$output .= '<p class="title">' . $title . '</p>' . PHP_EOL;

	if ( isset( $email ) && ! empty( $email ) )
		$output .= '<p class="email"><a href="mailto:' . $email . '" title="' . esc_attr__( 'Email', 'sp-theme' ) . ' ' . $name . '">' . $email . '</a></p>' . PHP_EOL;

	if ( isset( $twitter_name ) && ! empty( $twitter_name ) ) {
		$output .= '<a href="https://twitter.com/' . esc_attr( $twitter_name ) . '" class="twitter-follow-button" data-show-count="false" data-size="normal" data-show-screen-name="true" data-dnt="true">' . __( 'Follow', 'sp-theme' ) . ' @' . $twitter_name . '</a>' . PHP_EOL;	
	}

	$output .= '</div><!--close .sc-bio-card-->' . PHP_EOL;

	return $output;
}