<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * filters
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_filter( 'language_attributes', 'sp_language_attributes' );

/**
 * Function to adds facebook open graph protocol to html tag
 * 
 * @access public
 * @since 3.0
 * @param string $protocol | saved protocols
 * @return string $protocol | modified protocols
 */
function sp_language_attributes( $protocol ) {
	// check if fb open graph is on
	if ( sp_get_option( 'facebook_opengraph', 'is', 'on' ) )
		return $protocol .= ' xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter( 'widget_form_callback', '_sp_widget_form_extend', 10, 2 );

/**
 * Function to add CSS class field to widgets
 * 
 * @access private
 * @since 3.0
 * @param array $instance | the instance
 * @param object $widget | the object
 * @return array $instance | returns the instance
 */
function _sp_widget_form_extend( $instance, $widget ) {
	if ( ! isset( $instance['classes'] ) )
		$instance['classes'] = null;

	$output = "<p>\r\n";
	$output .= "<label for='widget-{$widget->id_base}-{$widget->number}-classes'>" . __( 'Additional Classes', 'sp-theme' ) . "<small> (" . __( 'separate with spaces', 'sp-theme' ) . ")</small></label>\r\n";
	$output .= "<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\r\n";
	$output .= "</p>\r\n";

	echo $output;

	return $instance;
}

add_filter( 'widget_update_callback', '_sp_widget_update', 10, 2 );

/**
 * Function that adds the class field through save process
 * 
 * @access private
 * @since 3.0
 * @param array $instance | the instance
 * @param array $new_instance | new passed in instance
 * @return array $instance | returns the instance
 */
function _sp_widget_update( $instance, $new_instance ) {
	$instance['classes'] = $new_instance['classes'];
	return $instance;
}

add_filter( 'dynamic_sidebar_params', '_sp_dynamic_sidebar_params' );

/**
 * Function that adds the class attribute to the widget output
 * 
 * @access private
 * @since 3.0
 * @param array $params | parameters of the widget
 * @return array $params | modified params
 */
function _sp_dynamic_sidebar_params( $params ) {
	global $wp_registered_widgets;
	
	$widget_id	= $params[0]['widget_id'];
	$widget_obj	= $wp_registered_widgets[$widget_id];

	// check if object is built
	if ( ! is_object( $widget_obj ) )
		return $params;

	$widget_opt	= get_option( $widget_obj['callback'][0]->option_name );
	$widget_num	= $widget_obj['params'][0]['number'];

	if ( isset( $widget_opt[$widget_num]['classes'] ) && ! empty( $widget_opt[$widget_num]['classes'] ) )
		$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );

	return $params;
}

add_filter( 'the_generator', '_sp_remove_wp_version' );

/**
 * Function that removes the WordPress version from site
 * 
 * @access private
 * @since 3.0
 * @return null
 */
function _sp_remove_wp_version() {
	return null;
}

add_filter( 'wp_title', 'sp_wp_title', 10, 2 );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @access public
 * @since 3.0
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function sp_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'sp-theme' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'the_content', 'sp_wpautop_control_filter', 9 );

/**
 * Function that filters the wpautop
 *
 * @access public
 * @since 3.0
 * @param string $content | the content to filter
 * @return string $content | filtered content
 */
function sp_wpautop_control_filter( $content ) {
	global $post;
	
	if ( is_object( $post ) ) {
		// Get the keys and values of the custom fields:
		$post_wpautop_value = get_post_meta( $post->ID, '_sp_disable_wpautop', true );
		
		if ( in_array( $post_wpautop_value, array( 'true', '1', 'on' ) ) )
		  $remove_filter = true;

		elseif ( in_array( $post_wpautop_value, array( 'false', '0', 'off' ) ) )
		  $remove_filter = false;

		else
		  $remove_filter = false;
		
		// if remove filter is on
		if ( $remove_filter ) {
		  remove_filter( 'the_content', 'wpautop' );
		  remove_filter( 'the_excerpt', 'wpautop' );
		}
	} 

	return $content;	
}

/**
 * Function that sets the RSS URL
 *
 * @access public
 * @since 3.0
 * @return array $output | the array of feed URLs
 */
function sp_custom_feed_link( $output, $feed ) {
	$feed_url = sp_get_option( 'rss_url' );
	
	$feed_array = array(
		'rss'			=> $feed_url,
		'rss2'			=> $feed_url,
		'atom'			=> $feed_url,
		'rdf'			=> $feed_url,
		'comments_rss2'	=> ''
	);

	$feed_array[$feed] = $feed_url;

	$output = $feed_array[$feed];
	
	return $output;
}

/**
 * Function that sets the any other feed RSS URL
 *
 * @access public
 * @since 3.0
 * @return string $link | the link
 */
function sp_other_feed_links( $link ) {
	$feed_url = sp_get_option( 'rss_url' );
	
	return $link;
}

add_action( 'init', 'sp_custom_feed_links' );

/**
 * Function that sets the filters for all RSS
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_custom_feed_links() {	
	if ( sp_get_option( 'rss_url', 'isset' ) && sp_get_option( 'rss_url' ) != '' ) {
		add_filter( 'feed_link','sp_custom_feed_link', 1, 2 );
		add_filter( 'category_feed_link', 'sp_other_feed_links' );
		add_filter( 'author_feed_link', 'sp_other_feed_links' );
		add_filter( 'tag_feed_link','sp_other_feed_links' );
		add_filter( 'search_feed_link','sp_other_feed_links' );
	}

	return true;
}

/**
 * Function that filters the query where clause
 *
 * @access public
 * @since 3.0
 * @param string $where  | the current query where clause
 * @return string $where | the where clause
 */
function sp_search_where( $where ) {
  global $wpdb;

  // if it is searching
  if ( is_search() )
    $where .= "OR (t.name LIKE '%" . get_search_query() . "%' AND {$wpdb->posts}.post_status = 'publish')";
  
  return $where;
}

/**
 * Function that filters the join where clause
 *
 * @access public
 * @since 3.0
 * @param string $join  | the current query join clause
 * @return string $join | the join clause
 */
function sp_search_join( $join ) {
  global $wpdb;
  
  // if it is searching
  if ( is_search() )
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  
  return $join;
}

/**
 * Function that filters the group where clause
 *
 * @access public
 * @since 3.0
 * @param string $group  | the current query group clause
 * @return string $group | the group clause
 */
function sp_search_groupby( $groupby ) {
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";

  if ( ! is_search() || strpos( $groupby, $groupby_id ) !== false) 
  	return $groupby;

  // groupby was empty, use ours
  if ( ! strlen( trim( $groupby ) ) ) 
  	return $groupby_id;

  // not empty, append ours
  return $groupby . ", " . $groupby_id;
}

// builds the search filter to include custom fields
if ( ! is_admin() ) {
	//add_filter( 'posts_where', 'sp_search_where' );
	//add_filter( 'posts_join', 'sp_search_join' );
	//add_filter( 'posts_groupby', 'sp_search_groupby' );
}

add_filter( 'oembed_dataparse', 'sp_add_oembed_video_wrapper', 90, 3 );

/**
 * Function that puts a wrapper around embedded videos for fitVids to hook into
 *
 * @access public
 * @since 3.0
 * @return html $output | the filter content
 */
function sp_add_oembed_video_wrapper( $html, $data, $url ) {
	$output = '<div class="fitvids-video-wrapper">' . $html . '</div><!--close .fitvids-video-wrapper-->' . PHP_EOL;
	
	return $output;	
}

add_filter( 'wp_video_shortcode', 'sp_add_video_wrapper', 90, 5 );

function sp_add_video_wrapper( $html, $atts, $video, $post_id, $library ) {
	$output = '<div class="fitvids-video-wrapper">' . $html . '</div><!--close .fitvids-video-wrapper-->' . PHP_EOL;
	
	return $output;
}

// adds shortcode capability in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'img_caption_shortcode', 'sp_img_caption_shortcode_filter', 10, 3 );

/**
 * Filter that changes WP caption shortcode to use html5 figure/figcaption tags
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_img_caption_shortcode_filter( $val, $attr, $content = null ) {
	extract( shortcode_atts( array(
		'id'		=> '',
		'align'		=> '',
		'width'		=> '',
		'caption'	=> ''
	), $attr ) );
	
	if ( 1 > (int)$width || empty( $caption ) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr( $id );
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" style="width: '
	. (10 + (int) $width ) . 'px">' . do_shortcode( $content ) . '<figcaption ' . $capid 
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

add_filter( 'the_content', 'sp_fix_shortcode_wpautop' );

/**
 * Filter that strips wpautop items from shortcode blocks
 *
 * @access public
 * @since 3.0
 * @param html $content | the content to filter
 * @return html $content | return the filtered content
 */
function sp_fix_shortcode_wpautop( $content ) {
	$array = array(
		'<p>[sc_' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;
}

add_filter( 'wp_title', 'sp_seo_title', 20 );

/**
 * Function that fitlers the seo title tag to user specific
 * 
 * @access public
 * @since 3.0
 * @return string $output | the filtered title
 */
function sp_seo_title( $title ) {
	global $post;

	if ( is_object( $post ) ) {
		$page_title = get_post_meta( $post->ID, '_sp_page_seo_title', true );

		$output = '';

		if ( isset( $page_title ) && ! empty( $page_title ) )
			$title = $page_title;

		$output .= strip_tags( $title );

		return $output;	
	} else {
		return $title;
	}
}