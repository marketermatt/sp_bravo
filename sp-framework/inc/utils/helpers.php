<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * helpers and utilities
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function to get the browser agent
 *
 * @access public
 * @since 3.0
 * @return string
 */
function sp_get_browser_agent() {
	// if no user agent, quit here
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) 
		return false;
	
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = '';
	$ub = 'Unknown';
	
	// get the platform
	if ( preg_match( '!linux!i' , $u_agent ) ) {
		$platform = 'linux';
	} elseif ( preg_match( '!macintosh|mac os x!i', $u_agent ) ) {
		if ( strpos( $u_agent, 'iPad' ) ) {
			$platform = 'iPad';
		} else {
			$platform = 'mac';
		}
	} elseif ( preg_match( '!windows|win32!i', $u_agent ) ) {
		$platform = 'windows';
	}
	
	// get the useragent of the browser
	if( preg_match( '!MSIE!i', $u_agent ) && !preg_match( '!Opera!i', $u_agent ) ) {
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	} elseif( preg_match( '!Firefox!i', $u_agent ) ) {
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	} elseif( preg_match( '!Chrome!i', $u_agent ) ) {
		$bname = 'Google Chrome';
		$ub = "Chrome";
	} elseif( preg_match( '!Safari!i', $u_agent ) ) {
		$bname = 'Apple Safari';
		$ub = "Safari";
	} elseif( preg_match( '!Opera!i', $u_agent ) ) {
		$bname = 'Opera';
		$ub = "Opera";
	} elseif( preg_match( '!Netscape!i', $u_agent ) ) {
		$bname = 'Netscape';
		$ub = "Netscape";
	}
	
	// get the version number
	$known = array( 'Version', $ub, 'other' );
	$pattern = '#(?<browser>' . join( '|', $known ) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	
	if ( ! @preg_match_all( $pattern, $u_agent, $matches ) ) {
		// continue do nothing
	}
	
	// count the number of browser matches
	$i = count( $matches['browser'] );
	if ( $i != 1 ) {
		if ( strripos( $u_agent, "Version" ) < strripos( $u_agent, $ub ) ){
			$version= $matches['version'][0];
		} else {
			$version= isset( $matches['version'][1] ) ? $matches['version'][1] : "?";
		}
	} else {
		$version= $matches['version'][0];
	}
	
	// check if version number exists and not null
	if ( $version == null || $version == "" ) {
		$version = "?";
	}
	
	$mainVersion = $version;
	if ( strpos( $version, '.' ) !== false ) {
		$mainVersion = explode( '.', $version );
		$mainVersion = $mainVersion[0];
	}
	
	return strtolower( $ub . " " . $ub . $mainVersion . " " . $platform );
}

/**
 * Function to check if WooCommerce plugin is active
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_woo_exists() {
	if ( class_exists( 'woocommerce' ) )
		return true;
	else
		return false;
}

/**
 * function that cleans the data array
 *
 * @access public
 * @since 3.0
 * @param $string takes in the string to be cleaned
 * @return string $string returns cleaned string
 */
function sp_a_clean( $string = '' ) {		
	// converts everything to lowercase and replace spaces with hyphens
	$string = strtolower( str_replace( ' ', '-', $string ) );
  
	return $string;
}

/**
 * Function to get the option value or test value is set
 *
 * @access public
 * @since 3.0
 * @param string $option the name of the option to get
 * @param string $type the type of operation - value to get value - is to test condition
 * @param string $value the value to test the condition against if set
 * @return mixed either the value or a boolean state
 */
function sp_get_option( $option = '', $type = 'value', $value = '' ) {
	global $spdata;
	
	switch ( $type ) :
		case 'value' :
			// returns the value if set
			if ( isset( $spdata[$option] ) && ( $spdata[$option] != '' ) )
				return $spdata[$option];
			else
				return false;	
		break;
		
		case 'isset' :
			if ( isset( $spdata[$option] ) && ( $spdata[$option] != '' ) )		
				return true;
			else
				return false;

		case 'is' :
			// returns boolean
			if ( isset( $spdata[$option] ) && ( $spdata[$option] == $value ) ) 
				return true;
			else
				return false;	
		break;

		default :
		
	endswitch;
}

/**
 * Function that checks for SSL and returns proper protocol
 *
 * @access public
 * @since 3.0
 * @return string returns proper protocol
 */
function sp_ssl_protocol() {	
	if ( is_ssl() )
		return 'https';
	else 
		return 'http';
}

/**
 * Function that gets the URL and strip down to page name
 *
 * @access public
 * @since 3.0
 * @param string $url the URL string
 * @return string returns proper protocol
 */
function sp_extract_url( $url ) {
	$last_slash_pos = strrpos( $url, "/" );
	$url = trim( $url, "/" );
	$url = substr( $url, strrpos( $url, "/" ) + 1, $last_slash_pos );
	
	return $url;
}

/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * @access public
 * @since 3.0
 * @param string  $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string  $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
function sp_truncate( $text, $length = 100, $ending = '...', $exact = true, $considerHtml = true ) {
	if ( $considerHtml ) {
		// if the plain text is shorter than the maximum length, return the whole text
		if ( strlen( preg_replace( '/<.*?>/', '', $text ) ) <= $length ) {
			return $text;
		}

		// splits all html-tags to scanable lines
		preg_match_all( '/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER );
		$total_length = strlen( $ending );
		$open_tags = array();
		$truncate = '';
		foreach ( $lines as $line_matchings ) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if ( ! empty( $line_matchings[1] ) ) {
				// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
				if ( preg_match( '/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1] ) ) {
					// do nothing
				// if tag is a closing tag (f.e. </b>)
				} else if ( preg_match( '/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings ) )  {
					// delete tag from $open_tags list
					$pos = array_search( $tag_matchings[1], $open_tags );
					if ( $pos !== false ) {
						unset( $open_tags[$pos] );
					}
				// if tag is an opening tag (f.e. <b>)
				} else if ( preg_match( '/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings ) ) {
					// add tag to the beginning of $open_tags list
					array_unshift( $open_tags, strtolower( $tag_matchings[1] ) );
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen( preg_replace( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2] ) );
			if ( $total_length+$content_length > $length ) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if ( preg_match_all( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE ) ) {
					// calculate the real length of all entities in the legal range
					foreach ( $entities[0] as $entity ) {
						if ( $entity[1] + 1 - $entities_length <= $left ) {
							$left--;
							$entities_length += strlen( $entity[0] );
						} else {
							// no more characters left
							break;
						}
					}
				}

				$truncate .= substr( $line_matchings[2], 0, $left + $entities_length );
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if ( $total_length >= $length ) {
				break;
			}
		}
	} else {
		if ( strlen( $text ) <= $length ) {
			return $text;
		} else {
			$truncate = substr( $text, 0, $length - strlen( $ending ) );
		}
	}

	// if the words shouldn't be cut in the middle...
	if ( ! $exact ) {
		// ...search the last occurance of a space...
		$spacepos = strrpos( $truncate, ' ' );
		if ( isset( $spacepos ) ) {
			// ...and cut the text in this position
			$truncate = substr( $truncate, 0, $spacepos );
		}
	}

	// add the defined ending to the text
	$truncate .= $ending;
	if ( $considerHtml ) {
		// close all unclosed html-tags
		foreach ( $open_tags as $tag ) {
			$truncate .= '</' . $tag . '>';
		}
	}

	return stripslashes( $truncate );
}

/**
 * Function that gets the page id from page slug
 *
 * @access public
 * @since 3.0
 * @param string $page_slug the slug name of the page
 * @return int $page->ID the page id
 */
function sp_get_page_id_from_slug( $page_slug ) {
	global $wpdb;
	
	$id = '';

	$id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = '" . $page_slug . "'");

	return $id;
}

/**
 * Function that checks the template a page is using
 *
 * @access public
 * @since 3.0
 * @param string $page_slug the slug of the page
 * @return string $template_name returns the template name
 */
function sp_get_page_template( $page_slug = 'sp-home' ) {	
	// get the id of the page from slug
	$id = sp_get_page_id_from_slug( $page_slug );

	$template_name = str_replace( '.php', '', get_post_meta( $id, '_wp_page_template', true ) ); //removes .php from the string
	
	return $template_name;	
}

/**
 * Function that gets the multisite image URL
 *
 * @access public
 * @since 3.0
 * @param string $image the URL of the image
 * @return string $ms_image_url the multisite URL of the image source
 */
function sp_get_ms_image( $image_url ) {
	global $blog_id, $wp_version; 
	
	// if multisite is not set exit out
	if ( ! is_multisite() || $blog_id == 1 ) 
		return $image_url;

	// if WP 3.5 or greater -- 3.5 puts network files in uploads/sites/ folder
	if ( $wp_version >= 3.5 )
		return $image_url;
		
	// check if it is the parent network		
	$matches = array();
	preg_match( '/(?<=files).*/', $image_url, $matches ); //gets the end part of string after files
	$image_part = $matches[0];
	
	$ms_image_url = trailingslashit( network_site_url() ) . 'wp-content/blogs.dir/' . $blog_id . '/files' . $image_part;
	
	return $ms_image_url;
	
}

/**
 * Function that gets the post featured thumbnail image
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | the id of the attachment
 * @return array $attached_image | the image url, size
 */
function sp_find_image( $attachment_id = '' ) {
	
	// bail if no id passed
	if ( ! isset( $attachment_id ) )
		return;
	
	$image = wp_get_attachment_image_src( $attachment_id, 'full' );

	// if image found
	if ( $image ) {
		// run image url string check for multisite
		$image_url = sp_get_ms_image( $image[0] );
		
		$image = array(
			'url'		=> $image_url,
			'width'		=> $image[1],
			'height'	=> $image[2]
		);

	} else {
		$image_url = sp_no_image();

		$image = array(
			'url'		=> $image_url,
			'width'		=> 800,
			'height'	=> 800
		);
	}
	
	return $image;	
}

/**
 * Function to get image meta info
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | id of the attachment
 * @return string $string | the title or alt
 */
function sp_get_image_meta( $attachment_id = '' ) {
	// bail if post id is not passed
	if ( ! isset( $attachment_id ) )
		return;

	// get the image post object
	$image = get_post( $attachment_id );

	// if object is found
	if ( $image ) {
		$description = $image->post_content;
		$caption = $image->post_excerpt;
		$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		$title = $image->post_title;
	} else {
		$description = '';
		$caption = '';
		$alt = __( 'No Image', 'sp-theme' );
		$title = __( 'No Image', 'sp-theme' );
	}

	$meta = array();

	// if alt was not set, use title instead
	if ( empty( $alt ) )
		$meta['alt'] = $image->post_title;
	else
		$meta['alt'] = $alt;

	$meta['description'] = $description;
	$meta['caption'] = $caption;
	$meta['title'] = $title;

	return $meta;
}

/**
 * Function to dynamically create an image with custom sizes
 *
 * @access public
 * @since 3.0
 * @param int $attachment_id | id of the attachment
 * @param int $width | the width
 * @param int $height | the height
 * @param bool $crop | crop value
 * @return url | the url of the newly created image
 */
function sp_get_image( $attachment_id = null, $width = null, $height = null, $crop = false ) {
	// bail if post id is not passed
	if ( ! isset( $attachment_id ) )
		return;	

	// handle crop in case on/off is passed in
	if ( $crop === true || $crop === 'on' || absint( $crop ) === 1 )
		$crop = apply_filters( 'sp_image_crop_position', array( 'center', 'center' ) );
	elseif ( $crop === 'off' || absint( $crop ) === 0 )
		$crop = false;

	// get the image url (array)
	$org_image = sp_find_image( $attachment_id );

	// skip check if no image
	if ( ! preg_match( '/no-image/', $org_image['url'] ) ) {
		// if not correct mime type bail
		if ( get_post_mime_type( $attachment_id ) !== 'image/jpeg' && get_post_mime_type( $attachment_id ) !== 'image/png' && get_post_mime_type( $attachment_id ) !== 'image/gif' )
			return;
	}

	if ( $width === null && $height === null ) { 
		// this is returned if width and height is not set
		$new_image = array (
			'url'		=> $org_image['url'],
			'width'		=> $org_image['width'],
			'height'	=> $org_image['height']
		);
	}

	if ( $width !== null && $height !== null ) {

		// if no image
		if ( preg_match( '/no-image/', $org_image['url'] ) )
			// get the file path
			$org_file_path = apply_filters( 'sp_fallback_image_path', get_template_directory() . '/images/no-image.jpg' );
		else
			// get the file path
			$org_file_path = get_attached_file( $attachment_id );

		// image and path not found bail
		if ( ! isset( $org_image ) && ! isset( $org_file_path ) || $org_file_path === false )
			return;

		// get the file path information
		$org_file_info = pathinfo( $org_file_path );

		// bail if filename is empty
		if ( ! isset( $org_file_info['filename'] ) || empty( $org_file_info['filename'] ) )
			return;

		// extract the extension of the file
		$org_extension = '.' . $org_file_info['extension'];

		// the image path without the extension
		$org_file_path_no_ext = $org_file_info['dirname'] . '/' . $org_file_info['filename'];

		// build the path to check if it exists
		$check_path = $org_file_path_no_ext . '-' . $width . 'x' . $height . $org_extension;	

		// build the array
		$image_src = array();
		$image_src['url'] = $org_image['url'];
		$image_src['width'] = $org_image['width'];
		$image_src['height'] = $org_image['height'];

		// if file already exists
		if ( file_exists( $check_path ) ) {

			$new_img_url = str_replace( basename( $image_src['url'] ), basename( $check_path ), $image_src['url'] );
			
			$new_image = array (
				'url'		=> $new_img_url,
				'width'		=> $width,
				'height'	=> $height
			);
		}

		// image doesn't exist, let's create
		$image_object = wp_get_image_editor( $org_file_path );

		// continue if no error
		if ( ! is_wp_error( $image_object ) ) {
			$image_object->resize( $width, $height, $crop );
			$new_size = $image_object->get_size();
			$image_object->save( $org_file_path_no_ext . '-' . $new_size['width'] . 'x' . $new_size['height'] . $org_extension );

			$new_img_url = str_replace( basename( $image_src['url'] ), basename( $org_file_path_no_ext . '-' . $new_size['width'] . 'x' . $new_size['height'] . $org_extension ), $image_src['url'] );

			// resized output
			$new_image = array (
				'url'		=> $new_img_url,
				'width'		=> $width,
				'height'	=> $height
			);
		}
	}

	// get image meta
	$image_meta = sp_get_image_meta( $attachment_id );

	if ( isset( $new_image ) ) {
		$new_image = array_merge( $new_image, $image_meta );

		return $new_image;
	} else {
		return false;
	}				
}

/**
 * Function that gets the fallback image if no image is found
 *
 * @access public
 * @since 3.0
 * @param string $size | the size of image to return
 * @return string the url of the image fallback
 */
function sp_no_image( $size = 'large' ) {
	switch( $size ) {
		case 'thumbnail' :
			return apply_filters( 'sp_fallback_image_thumbnail', get_template_directory_uri() . '/images/no-image-thumbnail.jpg' );	
			break;
		case 'small' :
			return apply_filters( 'sp_fallback_image_small', get_template_directory_uri() . '/images/no-image-small.jpg' );	
			break;
		case 'medium' :
			return apply_filters( 'sp_fallback_image_medium', get_template_directory_uri() . '/images/no-image-medium.jpg' );	
			break;
		case 'large' :
		default :
			return apply_filters( 'sp_fallback_image', get_template_directory_uri() . '/images/no-image.jpg' );			
			break;
	}
}

/**
 * Function that gets current page's id
 *
 * @access public
 * @since 3.0
 * @return int $post_id the post id
 */
function sp_current_page_id() {
	global $wp_query;
	
	if ( is_object( $wp_query ) && isset( $wp_query->queried_object_id ) )
		$post_id = $wp_query->queried_object_id;
	else {
		$post_id = null;
	}

	return $post_id;
}

/**
 * Function that gets the current page's slug
 *
 * @access public
 * @since 3.0
 * @return string $slug the slug of the page
 */
function sp_cur_page_slug() {	
	$slug = false;
	
	$post_id = sp_current_page_id();
	
	$post = get_post( $post_id );
	
	if ( isset( $post ) )
		$slug = $post->post_name;
	
	return $slug;
}

/**
 * Function that checks if current page is a store page
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_is_store_page() {
	$is_store_page = false;
	
	// checks if WooCommerce plugin is active
	if ( sp_woo_exists() ) {
		if ( is_woocommerce() ) { 
			$is_store_page = true;	
		} else { 
			$is_store_page = false;	
		}
	}
	
	return $is_store_page;
}

/**
 * Function that checks if current page is single product page
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_is_single_product_page() { 
	$is_single_product_page = false;
	
	// checks if WooCommerce plugin is active
	if ( sp_woo_exists() ) {
		if ( is_product() )
			$is_single_product_page = true;	
	}
	
	return $is_single_product_page;
}

/**
 * Function that checks if current page is a checkout or transaction page
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_is_checkout_pages() { 
	$is_checkout_pages = false;

	// checks if WooCommerce plugin is active
	if ( sp_woo_exists() ) { 
		if ( is_cart() || is_checkout() || sp_cur_page_slug() === 'order-received' )
			$is_checkout_pages = true;	
	}
	
	return $is_checkout_pages;
}

/**
 * Function that checks if current page is using default layout
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_is_default_layout() {
	global $post;
	
	$is_default = true;
	
	// get the page layout settings from post meta
	$layout = get_post_meta( $post->ID, '_sp_page_layout', true );
	
	if ( ! empty( $layout ) && $layout !== 'default' ) 
		$is_default = false;
	
	return $is_default;
}

/**
 * Function to that returns the current page's layout
 *
 * @access public
 * @since 3.0
 * @return mix booleans
 */
function sp_get_page_layout() {	
	global $post;

	$context = 'page';
	$sidebar_left = false;
	$sidebar_right = false;
	$layout = 'default';
	
	if ( is_object( $post ) ) {
		switch ( get_post_type( $post ) ) {
			case 'post' :
				$context = 'blog';	

				if ( is_single() )
					$layout = get_post_meta( $post->ID, '_sp_custom_layout', true );

				break;
			case 'sp-portfolio' :
				$context = 'portfolio';	

				if ( is_single() )
					$layout = get_post_meta( $post->ID, '_sp_custom_layout', true );

				break;
			case 'page' :
				// check for product page
				if ( sp_is_store_page() )
					$context = 'product';
				else
					$context = 'page';	

				$layout = get_post_meta( $post->ID, '_sp_custom_layout', true );
				break;
			case 'product' :
				$context = 'category_product';	

				if ( is_product() ) {
					$context = 'single_product';
					$layout = get_post_meta( $post->ID, '_sp_custom_layout', true );
				}

				break;
		}

		// check for product checkout page
		if ( sp_is_checkout_pages() ) {
			$context = 'product_checkout';	
		}		
	}
		
	// if it is not set to default
	if ( ! empty( $layout ) && $layout !== 'default' ) {
		switch ( $layout ) {
			case 'sidebar-left' :
				$sidebar_left = true;	
				$sidebar_right = false;

				break;
			case 'sidebar-right' :
				$sidebar_right = true;	
				$sidebar_left = false;

				break;
			case 'no-sidebars' :
				$sidebar_left = false;	
				$sidebar_right = false;

				break;
			case 'both-sidebars' :
				$sidebar_left = true;
				$sidebar_right = true;

				break;			
		}
		
		$orientation = $layout . '-layout';
	} else { 
		if ( sp_get_option( $context . '_sidebar_orientation', 'isset' ) ) { 
			$orientation = sp_get_option( $context . '_sidebar_orientation' );

			switch ( $orientation ) {
				case 'sidebar-left' :
					$sidebar_left = true;
					$sidebar_right = false;

					break;
				case 'sidebar-right' :
					$sidebar_left = false;
					$sidebar_right = true;

					break;
				case 'no-sidebars' :
					$sidebar_left = false;
					$sidebar_right = false;	

					break;
				case 'both-sidebars' :
					$sidebar_left = true;
					$sidebar_right = true;

					break;				
			}
			
			$orientation = $orientation . '-layout';
		} else {
			$orientation = 'sidebar-right-layout';
			$sidebar_left = false;
			$sidebar_right = true;	
		}
	}
	
	$span_columns = sp_column_css( '', '', '', '9' );

	switch ( $orientation ) {
		case 'sidebar-left-layout' :
			$span_columns = sp_column_css( '', '', '', '9' );
			break;

		case 'sidebar-right-layout' :
			$span_columns = sp_column_css( '', '', '', '9' );
			break;

		case 'both-sidebars-layout' :
			$span_columns = sp_column_css( '', '9', '', '8' );
			break;

		case 'no-sidebars-layout' :
			$span_columns = sp_column_css( '', '', '', '12' );
			break;
	}	

	// return the 3 variables as arrays
	$vars = array( 'orientation' => $orientation, 'sidebar_left' => $sidebar_left, 'sidebar_right' => $sidebar_right, 'span_columns' => $span_columns );

	return $vars;
}

/**
 * Function to get the slide media count
 *
 * @access public
 * @since 3.0
 * @param int $post_id the post id to get media from
 * @return string $count the count slides for this attachment post
 */
function sp_get_slider_slide_count( $post_id ) {
	// bail if no id is passed
	if ( ! isset( $post_id ) )
		return;

	// build the query
	$args = array( 
		'posts_per_page' 	=> -1,
		'post_type'			=> 'attachment',
		'post_status' 		=> 'any',
		'meta_query'		=> array(
			array(
				'key'		=> '_sp_slide_post_parent',
				'value'		=> $post_id
			)
		)
	);

	$attachments = new WP_Query( $args );
	
	wp_reset_postdata();

	$count = $attachments->found_posts;

	return $count;	
}

/**
 * Function to get the slider's shortcode
 *
 * @access public
 * @since 3.0
 * @param int $post_id | the post id of object
 * @return string $shortcode the shortcode that displays the slider
 */
function sp_get_slider_shortcode( $post_id ) {
	// bail if no id is passed
	if ( ! isset( $post_id ) )
		return;

	$shortcode = '[sp-carousel id="' . $post_id . '"]';

	return $shortcode;	
}

/**
 * Function to check if post has excerpt
 *
 * @access public
 * @since 3.0
 * @param int $post_id the post id to check
 * @return boolean true | false
 */
function sp_has_excerpt( $post_id ) {
	// bail if no post id
	if ( ! isset( $post_id ) )
		return;

	// get the post object
	$excerpt = get_post( $post_id );

	// check if it is set and not empty
	if ( isset( $excerpt->post_excerpt ) && ! empty( $excerpt->post_excerpt ) )
		return true;
	else 
		return false;
}

/**
 * Function to get list of widget areas
 *
 * @access public
 * @since 3.0
 * @return array $widget_areas
 */
function sp_get_widget_areas() {
	$widget_areas = array( 'Sidebar Left', 'Sidebar Right', 'Site Top', 'Site Bottom', 'Page Top', 'Page Bottom' );

	return $widget_areas;
}

/**
 * Function to get the term name
 * used when it is too early in the hook to get plugin's custom taxonomy
 *
 * @access public
 * @since 3.0
 * @param string $cart the cart plugin to get
 * @param int $term_id the term id to get the object from
 * @return string $term
 */
function sp_get_term_name( $term_id ) {
	global $wpdb;

	// bail if term_id is not set
	if ( ! isset( $term_id ) )
		return;

	$sql = $wpdb->prepare( "SELECT name FROM {$wpdb->prefix}terms WHERE term_id = %d", $term_id );
	$term = $wpdb->get_var( $sql );	

	return $term;
}

/**
 * Function that gets a single font array
 *
 * @access public
 * @since 3.0
 * @param string $font | the font name to get
 * @return array $font | the array of the font 
 */
function sp_get_font( $fontname ) {
	// bail if font is not set
	if ( ! isset( $fontname ) )
		return;

	$fonts = sp_get_google_fonts();

	foreach( $fonts as $font ) {
		if ( $font['family'] === $fontname )
			return $font;
	}

	return;
}

/**
 * Function that generates a gradient background css
 *
 * @access public
 * @since 3.0
 * @param string $color1 | the hex value of the color
 * @param string $color2 | the hex value of the color
 * @param string $color3 | the hex value of the color
 * @return css $output | the css for the background gradient
 */
function sp_generate_bg_color_css( $color1, $color2, $color3 ) {
	// to see if at least one color is passed in
	if ( ! isset( $color1 ) && ! isset( $color2 ) && ! isset( $color3 ) )
		return;

	$output = '';

	// if all 3 colors are set
	if ( isset( $color1 ) && ! empty( $color1 ) && isset( $color2 ) && ! empty( $color2 ) && isset( $color3 ) && ! empty( $color3 ) ) {
		$color1 = '#' . $color1;
		$color2 = '#' . $color2;
		$color3 = '#' . $color3;

		$output .= "
			background: " . $color1 . ";background-image: -moz-linear-gradient(top,  " . $color1 . " 0%, " . $color2 . " 50%, " . $color3 . " 100%);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%," . $color1 . "), color-stop(50%," . $color2 . "), color-stop(100%," . $color3 . "));background-image: -webkit-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 50%," . $color3 . " 100%);background-image: -o-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 50%," . $color3 . " 100%);background-image: -ms-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 50%," . $color3 . " 100%);background-image: linear-gradient(to bottom,  " . $color1 . " 0%," . $color2 . " 50%," . $color3 . " 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $color1 . "', endColorstr='" . $color3 . "',GradientType=0 );";
			
	} elseif ( isset( $color1 ) && ! empty( $color1 ) && isset( $color2 ) && ! empty( $color2 ) ) {
		$color1 = '#' . $color1;
		$color2 = '#' . $color2;

		$output .= "
			background: " . $color1 . ";background-image: -moz-linear-gradient(top, " . $color1 . " 0%, " . $color2 . " 100%);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%," . $color1 . "), color-stop(100%," . $color2 . "));background-image: -webkit-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 100%);background-image: -o-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 100%);background-image: -ms-linear-gradient(top,  " . $color1 . " 0%," . $color2 . " 100%);background-image: linear-gradient(to bottom,  " . $color1 . " 0%," . $color2 . " 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $color1 . "', endColorstr='" . $color2 . "',GradientType=0 );";
	} else {
		$color1 = '#' . $color1;

		$output .= 'background-color:' . $color1 . ';';
	}

	return strip_tags( trim( $output ) );
}

/**
 * Function that gets the list of easing effects
 *
 * @access public
 * @since 3.0
 * @return array $easing the list of easing
 */
function sp_get_easing() {
	// compile list of easing effects
	$easing = array(
		'linear',
		'swing',
		'easeInQuad',
		'easeOutQuad',
		'easeInOutQuad',
		'easeInCubic',
		'easeOutCubic',
		'easeInOutCubic',
		'easeInQuart',
		'easeOutQuart',
		'easeInOutQuart',
		'easeInSine',
		'easeOutSine',
		'easeInOutSine',
		'easeInExpo',
		'easeOutExpo',
		'easeInOutExpo',
		'easeInQuint',
		'easeOutQuint',
		'easeInOutQuint',
		'easeInCirc',
		'easeOutCirc',
		'easeInOutCirc',
		'easeInElastic',
		'easeOutElastic',
		'easeInOutElastic',
		'easeInBack',
		'easeOutBack',
		'easeInOutBack',
		'easeInBounce',
		'easeOutBounce',
		'easeInOutBounce'
	);

	return $easing;
}

/**
 * Function that converts hex to rgb values
 *
 * @access public
 * @since 3.0
 * @param string $hex | the hex value to convert
 * @return array $rgb | the rgb values
 */
function sp_hex2rgb( $hex ) {
   $hex = str_replace( '#', '', $hex );

   if ( strlen( $hex ) == 3 ) {
      $r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
      $g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
      $b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
   } else {
      $r = hexdec( substr( $hex, 0, 2 ) );
      $g = hexdec( substr( $hex, 2, 2 ) );
      $b = hexdec( substr( $hex, 4, 2 ) );
   }
   $rgb = array( $r, $g, $b );
   
   return implode( ',', $rgb ); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

/**
 * Function that checks if value is listed as default font
 *
 * @access public
 * @since 3.0
 * @param string $value | the value to check against
 * @return boolean
 */
function sp_check_default_fonts( $value ) {
	$default = array(
		'Arial',
		'Helvetica',
		'Georgia',
		'Times New Roman'
	);

	if ( in_array( $value, $default ) )
		return true;
	else 
		return false;
}

/**
 * Function that generates CSS
 *
 * @access public
 * @since 3.0
 * @param string $selector | the CSS selector
 * @param string $property | the CSS property
 * @param string $value | the CSS value
 * @param string $prefix | the value prefix such as # for hex
 * @param string $postfix | the value postfix such as px, %, ems
 * @return string $css | CSS style
 */
function sp_generate_css( $selector, $property, $value, $prefix = '', $suffix = '' ) {
	// if any of these are not set, bail
	if ( ! isset( $selector ) || ! isset( $property ) || ! isset( $value ) || empty( $value ) )
		return;

	$css = '';

	// if property is font-family add fallbacks
	if ( $property === 'font-family' && ! sp_check_default_fonts( $value ) ) {
		$value = '"' . $value . '", Arial, sans-serif';
	}

	if ( $property === 'background-image' && is_ssl() ) {
		$value = str_replace( 'http', 'https', $value );
	}

	$css .= sprintf( '%s { %s:%s; }', $selector, $property, $prefix . str_replace( array( '#', 'px' ), '', $value ) . $suffix );

	return $css;
}

/**
 * Function that saves CSS styles
 *
 * @access public
 * @since 3.0
 * @param string $filename | the filename of the stylesheet
 * @param string $styles | the styles to save
 * @return boolean true
 */
function sp_save_styles( $filename, $styles = '' ) {
	// bail if not set
	if ( ! isset( $filename ) )
		return;

	// if child theme is used	
	if ( is_child_theme() )
		$path = get_stylesheet_directory() . '/css/';
	else
		$path = get_template_directory() . '/css/';

	// if file doesn't exist - create
	if ( ! file_exists( $path ) ) {
		mkdir( $path, 0755, true );
	}

	file_put_contents( $path . $filename, $styles );

	return true;	
}

/**
 * Function that gets a list of background images
 *
 * @access public
 * @since 3.0
 * @return array $option | list of background images
 */
function sp_get_background_images() {
	// generate a list of custom backgrounds from the backgrounds folder
	$dir = get_template_directory() . '/images/backgrounds';

	if ( is_dir( $dir ) ) 
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );

	$option_defaults = array( 'none' => __( 'Default Background', 'sp-theme' ), 'no-image' => __( 'No Background Image', 'sp-theme' ), 'custom' => __( 'Upload Custom Background', 'sp-theme' ) );

	// rebuild the files array to set value same as key
	$rebuilt_files = array();

	foreach ( $files as $file ) {
		$rebuilt_files[get_template_directory_uri() . '/images/backgrounds/' . $file] = $file;	
	}

	$option = @array_merge( $option_defaults, $rebuilt_files );

	return $option;
}

/**
 * Function that gets the saved google fonts to be loaded
 *
 * @access public
 * @since 3.0
 * @return json $fonts
 */
function sp_load_fonts() {
	global $spdata;

	$fonts = array();
	$sep = ':';
	$subsets = '';
	$dups = array();

	// bail if custom font is not set
	if ( ! isset( $spdata['custom_fonts'] ) || ! is_array( $spdata['custom_fonts'] ) )
		return json_encode( array() );

	// build the array
	foreach( $spdata['custom_fonts'] as $font ) {
		$font_string = '';

		if ( ! isset( $font['font'] ) || $font['font'] === 'none' )
			continue;

		$font_string .= $font['font'];

		// if variant is selected
		if ( isset( $font['variant'] ) && ! empty( $font['variant'] ) && $font['variant'] !== 'none' )
			$font_string .= $sep . $font['variant'];

		// if subset is selected
		if ( is_array( $font['subset'] ) && isset( $font['subset'] ) && $font['subset'] !== 'none' ) {
			// if variant not set prepend semicolon
			if ( ! isset( $font['variant'] ) || empty( $font['variant'] ) || $font['variant'] === 'none' )
				$font_string .= $sep;

			$count = count( $font['subset'] );
			$i = 1;
			$font_string .= $sep;

			foreach( $font['subset'] as $k => $subset ) {
				if ( $subset === 'none' ) {
					$i++;
					continue;
				}

				// don't append comma for last item
				if ( $i != $count )
					$font_string .= $subset . ',';
				else
					$font_string .= $subset;

				$i++;
			}
		}

		if ( ! in_array( $font_string, $dups ) ) {
			$fonts[] = $font_string;
		}
		
		// add to dups list
		$dups[] = $font_string;		
	}

	// user filter
	$fonts = apply_filters( 'sp_load_user_fonts', $fonts );

	return json_encode( $fonts );
}

/**
 * Function that generates the styles needed for google fonts to prevent fout
 *
 * @access public
 * @since 3.0
 * @return array $option | list of background images
 */
function _sp_save_google_font_styles() {
	global $spdata;

	// save styles to prevent FOUT
	$styles = '';

	// bail if custom font is not set
	if ( ! isset( $spdata['custom_fonts'] ) || ! is_array( $spdata['custom_fonts'] ) )
		return;

	// build the array
	foreach( $spdata['custom_fonts'] as $font ) {
		// skip if it is default system font
		if ( isset( $font['font'] ) && sp_check_default_fonts( $font['font'] ) )
			continue;

		// skip if font family is none
		if ( isset( $font['font'] ) && $font['font'] === 'none' )
			continue;
/*
		// loading
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-loading ' . $font['selector'], 'visibility', 'hidden' ) . PHP_EOL;
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-loading ' . $font['selector'], 'font-family', 'Arial, sans-serif' ) . PHP_EOL;

		// inactive
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-inactive ' . $font['selector'], 'visibility', 'visible' ) . PHP_EOL;
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-inactive ' . $font['selector'], 'font-family', 'Arial, sans-serif' ) . PHP_EOL;

		// active
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-active ' . $font['selector'], 'visibility', 'visible' ) . PHP_EOL;
		$styles .=  sprintf( '%s { %s:%s; }', '.wf-active ' . $font['selector'], 'font-family', '"' . $font['font'] . '", Arial, sans-serif' ) . PHP_EOL;			
*/

		if ( isset( $font['selector'] ) )
			$styles .=  sprintf( '%s { %s:%s; }', $font['selector'], 'font-family', '"' . $font['font'] . '", Arial, sans-serif' ) . PHP_EOL;			
	}

	// save the styles to file
	sp_save_styles( 'font-styles.css', $styles );	
}

/**
 * Function sanitizes an multidimensional array
 *
 * @access public
 * @since 3.0
 * @return array $item | cleaned array
 */
function sp_clean_multi_array( $item, $key ) {
	$item = sanitize_text_field( $item );

	return $item;
}

/**
 * Function sanitizes an multidimensional array textarea
 *
 * @access public
 * @since 3.0
 * @return array $item | cleaned array
 */
function sp_clean_textarea_multi_array( $item, $key ) {
	$item = wp_kses_data( $item );

	return $item;
}

/**
 * Function to get user name
 *
 * @access public
 * @since 3.0
 * @return string $username
 */
function sp_get_username() {
	global $current_user;

	get_currentuserinfo();

	$user_arr = get_user_meta( $current_user->ID );

	// check username type
	switch( sp_get_option( 'show_login_name_type' ) ) {
		case 'user_nicename' :
			$username = $current_user->data->user_nicename;
			break;

		case 'display_name' :
			$username = $current_user->data->display_name;
			break;

		case 'first_name' :
			$username = $user_arr['first_name'][0];
			break;

		case 'last_name' :
			$username = $user_arr['last_name'][0];
			break;

		case 'nickname' :
			$username = $user_arr['nickname'][0];
			break;

		case 'full_name' :
			$username = $user_arr['first_name'][0] . ' ' . $user_arr['last_name'][0];
			break;
	
		case 'no_name' :
			$username = false;
			break;

		case 'user_login' :
		default:
			$username = $current_user->data->user_login;
			break;			
	}

	// if set to no name
	if ( $username === false ) {
		return '';
	} else {
		return '(' . apply_filters( 'sp_greeting_text', __( 'Hello,', 'sp-theme' ) ) . ' ' . $username . ')';
	}
}

/**
 * Function that gets a list of products
 *
 * @access public
 * @since 3.0
 * @param string $custom_pick | if custom pick type is selected this value is used
 * @param string $categories | if category type is selected this value is used
 * @param string $count | the number of items to return
 * @param string $order | the order of the products either ASC or DESC
 * @param string $randomize | randomize the products on output
 * @return object | $products
 */
function sp_get_products( $custom_pick = '', $categories = '', $count = '6', $order = 'DESC', $randomize = 'true' ) {
	$products = '';

	// check randomize
	if ( $randomize === 'true' )
		$orderby = 'rand';
	else
		$orderby = 'date';

	// check ecommerce plugin
	if ( sp_woo_exists() ) {
		// build arguments
		$args = array(
			'post_type'			=> 'product',
			'post_status'		=> 'publish',
			'posts_per_page'	=> (int)$count,
			'order'				=> $order,
			'orderby'			=> $orderby,
			'meta_query' => array(
				array(
					'key'		=> '_visibility',
					'value'		=> array( 'catalog', 'visible' ),
					'compare'	=> 'IN'
				)
            )			
		);

		// if custom pick is not entered and categories is set
		if ( empty( $custom_pick ) && isset( $categories ) && ! empty( $categories ) ) {
			$cat_ids = explode( ',', $categories );

			$tax_query = array( 'tax_query' => array(
				array(
					'taxonomy'	=> 'product_cat',
					'field'		=> 'id',
					'terms'		=> $cat_ids,
					'operator'	=> 'IN'
				)
			) );

			$args = array_merge( $args, $tax_query );
		}

		// if custom pick is entered supercede categories
		if ( isset( $custom_pick ) && ! empty( $custom_pick ) ) {
			$post_ids = explode( ',', $custom_pick );

			$post = array( 'post__in' => $post_ids );

			$args = array_merge( $args, $post );
		}

		// user filter
		$args = apply_filters( 'sp_get_products_arguments', $args );

		$products = new WP_Query( $args );
	}

	return $products;
}

/** 
 * Function that gets the size of an image 
 *
 * @since 3.0
 * @param string $image | file path to check
 * @return array $size | array width and height
 */
function sp_get_image_size( $image = '' ) {
	// if file is empty, bail out
	if ( empty( $image ) )
		return null;
	
	// checks to make sure PHP config allows url fopen
	if ( ini_get( 'allow_url_fopen' ) ) {
		$imageinfo = @getimagesize( $image );
	} else {
		$ch = curl_init();
		curl_setopt ( $ch, CURLOPT_URL, $image );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		$contents = curl_exec( $ch );
		curl_close( $ch );
		
		$new_image = ImageCreateFromString( $contents );
		imagejpeg( $new_image, 'temp.jpg', 100 );
		
		$imageinfo = @getimagesize( 'temp.jpg' );
	}
	
	return $size = array( 'width' => $imageinfo[0], 'height' => $imageinfo[1] );
}

/** 
 * Function that gets the login page id
 *
 * @since 3.0
 * @return page id
 */
function sp_login_page_id() {
	return sp_get_option( 'login_page' );
}

/** 
 * Function that gets the register page id
 *
 * @since 3.0
 * @return page id
 */
function sp_register_page_id() {
	return sp_get_option( 'register_page' );
}

/** 
 * Function that gets the wishlist page id
 *
 * @since 3.0
 * @return page id
 */
function sp_wishlist_page_id() {
	return sp_get_option( 'wishlist_page' );
}

/** 
 * Function that gets the compare page id
 *
 * @since 3.0
 * @return page id
 */
function sp_compare_page_id() {
	return sp_get_option( 'compare_page' );
}

/** 
 * Function that returns CSS classes for columns
 *
 * @since 3.0
 * @param string $xs - handheld mobiles
 * @param string $small - handheld tablets
 * @param string $medium - small desktops
 * @param string $lg - large desktops
 * @param string $sm_offset - small column offset
 * @param string $md_offset - medium column offset
 * @param string $lg_offset - large column offset
 * @return CSS $css
 */
function sp_column_css( $xs = '', $small = '', $medium = '', $large = '', $sm_offset = '', $md_offset = '', $lg_offset = '' ) {
	$sep = ' ';

	$css = '';

	$css .= 'column';

	if ( ! empty( $xs ) )
		$css .= $sep . 'col-xs-' . (string)$xs;

	// if small is not set, use large
	if ( ! empty( $small ) )
		$css .= $sep . 'col-sm-' . (string)$small;
	elseif ( ! empty( $large ) )
		$css .= $sep . 'col-sm-' . (string)$large;

	// if medium is not set use large
	if ( ! empty( $medium ) )
		$css .= $sep . 'col-md-' . (string)$medium;
	elseif ( ! empty( $large ) )
		$css .= $sep . 'col-md-' . (string)$large;

	if ( ! empty( $large ) )
		$css .= $sep . 'col-lg-' . (string)$large;

	// if small offset is not set, use large
	if ( ! empty( $sm_offset ) )
		$css .= $sep . 'col-sm-offset-' . (string)$sm_offset;
	elseif ( ! empty( $lg_offset ) )
		$css .= $sep . 'col-sm-offset-' . (string)$lg_offset;

	// if medium offset is not set, use large
	if ( ! empty( $md_offset ) )
		$css .= $sep . 'col-md-offset-' . (string)$md_offset;
	elseif ( ! empty( $lg_offset ) )
		$css .= $sep . 'col-md-offset-' . (string)$lg_offset;

	if ( ! empty( $lg_offset ) )
		$css .= $sep . 'col-lg-offset-' . (string)$lg_offset;

	return $css;
}

/** 
 * Function that returns the column class based on how many columns
 *
 * @since 3.0
 * @param string $columns | the number of columns to calc based on
 * @return CSS $css
 */
function sp_calc_footer_columns( $columns = '' ) {

	switch( $columns ) {
		case '' :
			$css = '';
			break;
		case '2' :
			$css = sp_column_css( '', '', '', '6' );
			break;
		case '3' :
			$css = sp_column_css( '', '', '', '4' );
			break;
		case '4' :
			$css = sp_column_css( '', '', '', '3' );
			break;
		case '6' :
			$css = sp_column_css( '', '', '', '2' );
			break;			
	}

	return $css;
}

/**
 * Function that adds a clearfix html
 *
 * @access public
 * @since 3.0
 * @return html
 */
function sp_add_clearfix() {
	echo '<div class="clearfix"></div>' . PHP_EOL;
}

/**
 * Function that deletes saved settings from options panel
 *
 * @access private
 * @since 3.0
 * @param string $option_id
 * @return boolean true
 */
function _sp_delete_setting( $option_id = '' ) {
	global $spdata;

	if ( empty( $option_id ) )
		return;

	// unset the option
	unset( $spdata[$option_id] );

	// save the option
	_sp_save_data( $spdata );

	return true;
}

/**
 * Function that checks if users can register 
 * Option is set in WordPress general settings
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_users_can_register() {
	$can_register = get_option( 'users_can_register' );

	if ( $can_register == '1' )
		return true;
	else
		return false;
}

/**
 * Function that checks what video type a url is
 *
 * @access public
 * @since 3.0
 * @return string $type
 */
function sp_check_video_type( $url = '' ) {
	if ( empty( $url ) )
		return;

	$type = '';

	// mp4
	if ( preg_match( '/.mp4/', $url ) ) {
		$type = 'mp4';
	} else {
		$type = 'embed';
	}

	return $type;
}

/**
 * Function that checks whether we need to show the page header
 *
 * @access public
 * @since 3.0
 * @return boolean true | false
 */
function sp_display_header() {
	global $post;

	// get the meta 
	$show_title = get_post_meta( $post->ID, '_sp_page_show_title', true );
	$show_tagline = get_post_meta( $post->ID, '_sp_page_show_tagline', true );
	$show_breadcrumbs = sp_get_option( 'show_page_breadcrumbs' );

	// if any one is on, show header
	if ( $show_title === 'on' || $show_tagline === 'on' || $show_breadcrumbs === 'on' || ( ! isset( $show_title ) && ! isset( $show_tagline ) && ! isset( $show_breadcrumbs ) ) )
		return true;
	else
		return false;	
}

/**
 * Function that gets the product view type
 *
 * @access public
 * @since 3.0
 * @return string
 */
function sp_get_product_view_type() {
	// get theme setting
	$default_view = sp_get_option( 'product_view_default' );

	// get cookie setting
	$cookie_view = isset( $_COOKIE['sp_view_type'] ) ? sanitize_text_field( $_COOKIE['sp_view_type'] ) : '';

	if ( ! empty( $cookie_view ) )
		return $cookie_view;
	else
		return $default_view;
}

/**
 * Function that checks if it is mobile
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_is_mobile() {
	static $is_mobile;

	if ( isset( $is_mobile ) ) {
		return $is_mobile;
	}

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = false;
	} elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
			$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

/**
 * Function that checks if it mobile and if hide on mobile option is enabled
 *
 * @access public
 * @since 3.0
 * @return boolean
 */
function sp_hide_on_mobile() {
	if ( sp_is_mobile() && sp_get_option( 'hide_sliders_on_xs_mobile', 'is', 'on' ) ) {
		return true;
	} else {
		return false;
	}
}