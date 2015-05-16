<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * Frontend display functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

if ( ! function_exists( 'sp_post_header_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * @access public
	 * @since 3.0
	 * @return mixed html
	 */
	function sp_post_header_entry_meta() {
		if ( is_sticky() && is_home() && ! is_paged() )
			echo '<span class="featured-post"><i class="icon-star"></i> ' . __( 'Sticky', 'sp-theme' ) . '</span>';

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
			sp_entry_date();

		// Post author
		if ( 'post' == get_post_type() ) {
			printf( '<span class="author vcard"><i class="icon-user"></i> %1$s <a class="url fn n" href="%2$s" title="%3$s" rel="author">%4$s</a></span>',
				__( 'by', 'sp-theme' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'sp-theme' ), get_the_author() ) ),
				get_the_author()
			);
		}

		sp_comments_count();
	}
endif;

if ( ! function_exists( 'sp_post_footer_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags.
	 *
	 * @access public
	 * @since 3.0
	 * @return mixed html
	 */
	function sp_post_footer_entry_meta() {

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'sp-theme' ) );
		if ( $categories_list ) {
			echo '<span class="categories-links"><i class="icon-graduation"></i> ' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'sp-theme' ) );
		if ( $tag_list ) {
			echo '<span class="tags-links"><i class="icon-tags-2"></i> ' . $tag_list . '</span>';
		}
	}
endif;

if ( ! function_exists( 'sp_comments_count' ) ) :
/**
 * Function that gets the comment count
 *
 * @access public
 * @since 3.0
 * @return int 
 */	
function sp_comments_count() {
	global $post;

	if ( apply_filters( 'sp_show_comments_count', true ) )
		echo '<span class="comment-count"><i class="icon-comments" aria-hidden="true"> </i>' . __( 'Comments', 'sp-theme' ) . ' (' . get_comments_number( $post->ID ) . ')</span>';

	return true;
}
endif;

if ( ! function_exists( 'sp_entry_date' ) ) :
	/**
	 * Function that builds the post date html
	 *
	 * @access public
	 * @since 3.0
	 * @return mixed html
	 */
	function sp_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'sp-theme' );
		else
			$format_prefix = '%2$s';

		$date = sprintf( '<span class="date"><i class="icon-calendar"></i> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( __( 'Permalink to %s', 'sp-theme' ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $echo )
			echo $date;

		return $date;
	}
endif;

/**
 * Function that builds the social media profile icons
 *
 * @access public
 * @since 3.0
 * @return mixed html
 */	
function sp_social_media_profile_icons() {
	$output = '';
	$buttons = array();

	$target = apply_filters( 'sp_social_media_profile_icons_open_target', '_self' );

	$output .= '<ul class="social-media-profile-buttons">' . PHP_EOL;	
	
	if ( sp_get_option( 'facebook_enable', 'is', 'on' ) )
		$buttons['facebook'] = '<li class="facebook"><a href="' . esc_url( sp_get_option( 'facebook_account' ) ) . '" title="' . esc_attr__( 'Join Us on Facebook', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_facebook_profile_icon_class', 'facebook' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;

	if ( sp_get_option( 'twitter_enable', 'is', 'on' ) ) 
		$buttons['twitter'] = '<li class="twitter"><a href="' . esc_url( sp_get_option( 'twitter_account' ) ) . '" title="' . esc_attr__( 'Follow our Tweets', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_twitter_profile_icon_class', 'twitter' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	if ( sp_get_option( 'pinterest_enable', 'is', 'on' ) )  
		$buttons['pinterest'] = '<li class="pinterest"><a href="' . esc_url( sp_get_option( 'pinterest_account' ) ) . '" title="' . esc_attr__( 'Follow our Pins', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_pinterest_profile_icon_class', 'pinterest' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	if ( sp_get_option( 'flickr_enable', 'is', 'on' ) ) 
		$buttons['flickr'] = '<li class="flickr"><a href="' . esc_url( sp_get_option( 'flickr_account' ) ) . '" title="' . esc_attr__( 'Checkout our Flickr Photos', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_flickr_profile_icon_class', 'flickr' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	if ( sp_get_option( 'gplus_enable', 'is', 'on' ) ) 
		$buttons['gplus'] = '<li class="gplus"><a href="' . esc_url( sp_get_option( 'gplus_account' ) ) . '" title="' . esc_attr__( 'Checkout our Google Plus Profile', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_gplus_profile_icon_class', 'google-plus' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	if ( sp_get_option( 'youtube_enable', 'is', 'on' ) ) 
		$buttons['youtube'] = '<li class="youtube"><a href="' . esc_url( sp_get_option( 'youtube_account' ) ) . '" title="' . esc_attr__( 'Checkout our YouTube Videos', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_youtube_profile_icon_class', 'youtube' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	
	
	if ( sp_get_option( 'rss_enable', 'is', 'on' ) ) 
		$buttons['rss'] = '<li class="rss"><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_attr__( 'Get Fed on our Feeds' , 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="bottom" target="' . esc_attr( $target ) . '"><i class="icon-' . apply_filters( 'sp_social_media_rss_profile_icon_class', 'rss' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	$buttons = apply_filters( 'sp_social_media_profile_icons', $buttons );
	
	// loop through buttons
	foreach( $buttons as $button )  {
		$output .= $button;
	}

	$output .= '</ul>' . PHP_EOL;

	return $output;
}

/**
 * Function that outputs the social media action buttons
 *
 * @access private
 * @since 3.0
 * @param string $size | the size of the icon buttons
 * @return html $output | the meta tags
 */
function sp_social_media_action_buttons( $size = 'small' ) {
	$output = '';
	$buttons = array();

	$output .= '<ul class="social-action-buttons ' . $size . '">' . PHP_EOL;

	if ( $size === 'big' ) {
		if ( sp_get_option( 'facebook_enable', 'is', 'on' ) )
			$buttons['facebook'] = '<li>' . do_shortcode( '[sp-fblike layout="box_count"]' ) . '</li>' . PHP_EOL;

		if ( sp_get_option( 'twitter_enable', 'is', 'on' ) )
			$buttons['twitter'] = '<li>' . do_shortcode( '[sp-tweet count_position="vertical"]' ) . '</li>' . PHP_EOL;

		if ( sp_get_option( 'gplus_enable', 'is', 'on' ) )
			$buttons['gplus'] = '<li>' . do_shortcode( '[sp-gplusone size="tall"]' ) . '</li>' . PHP_EOL;

		if ( sp_get_option( 'pinterest_enable', 'is', 'on' ) )
			$buttons['pinterest'] = '<li>' . do_shortcode( '[sp-pinit count_layout="vertical"]' ) . '</li>' . PHP_EOL;
	} else {
		if ( sp_get_option( 'facebook_enable', 'is', 'on' ) )
			$buttons['facebook'] = '<li>' . do_shortcode( '[sp-fblike]' ) . '</li>' . PHP_EOL;

		if ( sp_get_option( 'twitter_enable', 'is', 'on' ) )
			$buttons['twitter'] = '<li>' . do_shortcode( '[sp-tweet]' ) . '</li>' . PHP_EOL;
		
		if ( sp_get_option( 'gplus_enable', 'is', 'on' ) )
			$buttons['gplus'] = '<li>' . do_shortcode( '[sp-gplusone]' ) . '</li>' . PHP_EOL;

		if ( sp_get_option( 'pinterest_enable', 'is', 'on' ) )
			$buttons['pinterest'] = '<li>' . do_shortcode( '[sp-pinit]' ) . '</li>' . PHP_EOL;
	}

	// user filter
	$buttons = apply_filters( 'sp_social_media_action_buttons', $buttons, $size );

	// loop through buttons
	foreach ( $buttons as $button ) {
		$output .= $button;
	}

	$output .= '</ul>' . PHP_EOL;

	return $output;
}

/**
 * Function that outputs the social media share buttons
 *
 * @access private
 * @since 3.0
 * @param int $post_id | the post id to use
 * @return html $output | the meta tags
 */
function sp_social_media_share_buttons( $post_id = '' ) {

	if ( isset( $post_id ) && ! empty( $post_id ) )
		$id = $post_id;
	else 
		$id = null;

	$image = wp_get_attachment_url( get_post_thumbnail_id( $id ) );

	$output = '';
	$buttons = array();

	$output .= '<ul class="social-share-buttons">' . PHP_EOL;

	// email share
	$buttons['email'] = '<li class="email"><a href="mailto:?subject=' . str_replace( ' ', '%20', get_the_title( $id ) ) . '&amp;body=' . esc_url( get_permalink( $id ) ) . '" title="' . esc_attr__( 'Share via Email', 'sp-theme' ) . '" class="sp-tooltip" data-toggle="tooltip" data-placement="top"><i class="icon-' . apply_filters( 'sp_social_media_email_share_icon_class', 'mail2' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;

	$buttons['facebook'] = '<li class="facebook"><a href="' . esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink( $id ) . '&amp;t=' . str_replace( ' ', '%20', get_the_title( $id ) ) ) . '" title="' . esc_attr__( 'Share on Facebook', 'sp-theme' ) . '" target="_blank" class="sp-tooltip" data-toggle="tooltip" data-placement="top"><i class="icon-' . apply_filters( 'sp_social_media_facebook_share_icon_class', 'facebook3' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;

	$buttons['twitter'] = '<li class="twitter"><a href="' . esc_url( 'http://twitter.com/home?status=' . get_permalink( $id ) ) . '" title="' . esc_attr__( 'Share on Twitter', 'sp-theme' ) . '" target="_blank" class="sp-tooltip" data-toggle="tooltip" data-placement="top"><i class="icon-' . apply_filters( 'sp_social_media_twitter_share_icon_class', 'twitter3' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	$buttons['gplus'] = '<li class="gplus"><a href="' . esc_url( 'https://plus.google.com/share?url=' . get_permalink( $id ) ) . '" title="' . esc_attr__( 'Share on Google', 'sp-theme' ) . '" target="_blank" class="sp-tooltip" data-toggle="tooltip" data-placement="top"><i class="icon-' . apply_filters( 'sp_social_media_gplus_share_icon_class', 'google-plus2' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;	

	$buttons['pinterest'] = '<li class="pinterest"><a href="' . esc_url( '//pinterest.com/pin/create/button/?url=' . get_permalink( $id ) . '&amp;media=' . esc_url( $image ) . '&amp;description=' . str_replace( ' ', '%20', get_the_title( $id ) ) ) . '" title="' . esc_attr__( 'Share on Pinterest', 'sp-theme' ) . '" target="_blank" class="sp-tooltip" data-toggle="tooltip" data-placement="top"><i class="icon-' . apply_filters( 'sp_social_media_pinterest_share_icon_class', 'pinterest3' ) . '" aria-hidden="true"></i></a></li>' . PHP_EOL;

	// user filter
	$buttons = apply_filters( 'sp_social_media_share_buttons', $buttons, $id );

	// loop through buttons
	foreach( $buttons as $button ) {
		$output .= $button;
	}

	$output .= '</ul>' . PHP_EOL;

	return $output;
}

/**
 * Function that displays the social media buttons
 *
 * @access private
 * @since 3.0
 * @return html $output | the meta tags
 */
function sp_display_social_media_buttons() {
	global $post;

	// get saved value
	$show = get_post_meta( $post->ID, '_sp_page_show_share', true );

	$output = '';

	if ( $show === 'on' )
		$output .= sp_social_media_share_buttons();

	return $output;
}

if ( ! function_exists( 'sp_display_logo' ) ) :
/**
 * Function that displays the logo
 *
 * @access public
 * @since 3.0
 * @return mixed html
 */	
function sp_display_logo() {
	// get saved setting
	$logo_show = get_theme_mod( 'logo_show' );
	$logo_type = get_theme_mod( 'logo_image_text' );
	$logo_url = get_theme_mod( 'logo_upload' );
	$logo_title = get_theme_mod( 'logo_title_text' );

	if ( isset( $logo_show ) && $logo_show === 'off' )
		return '';

	$output = '';

	$output .= '<a href="' . esc_url( home_url() ) . '" title="' . esc_attr( 'Home', 'sp-theme' ) . '" id="logo">' . PHP_EOL;
	
	if ( $logo_type === 'text' ) {
		if ( isset( $logo_title ) && ! empty( $logo_title ) )
			$output .= $logo_title;
		else
			$output .= __( 'Your Logo Here', 'sp-theme' );
	} else {
		// if logo is not set
		if ( ! isset( $logo_url ) || empty( $logo_url ) )
			$logo_url = THEME_URL . 'images/logo.png';

		// check if ssl
		if ( is_ssl() ) {
			$logo_url = str_replace( 'http://', 'https://', $logo_url );
		}
		
		$output .= '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . PHP_EOL;
	}
	
	$output .= '</a>' . PHP_EOL;

	return apply_filters( 'sp_site_logo', $output, $logo_type, $logo_url, $logo_title );
}
endif;

if ( ! function_exists( 'sp_display_tagline' ) ) :
/**
 * Function that displays the tagline
 *
 * @access public
 * @since 3.0
 * @return mixed html
 */	
function sp_display_tagline() {
	// get saved setting
	$tagline = get_theme_mod( 'tagline_title_text' );
	$tagline_show = get_theme_mod( 'tagline_show' );

	if ( isset( $tagline_show ) && $tagline_show === 'off' )
		return '';

	$output = '';

	// if no tagline is used
	if ( ! isset( $tagline ) || empty( $tagline ) )
		$tagline = __( 'Premium WordPress e-Commerce Theme', 'sp-theme' );

	$output .= '<em id="tagline">' . $tagline . '</em>' . PHP_EOL;

	return apply_filters( 'sp_site_tagline', $output, $tagline );
}
endif;

add_action( 'wp_head', '_sp_display_favicon', 5 );
add_action( 'admin_head', '_sp_display_favicon', 5 );

/**
 * Function that displays the favicon
 *
 * @access private
 * @since 3.0
 * @return mixed html
 */	
function _sp_display_favicon() { 
	// get saved setting
	$favicon = get_theme_mod( 'favicon_upload' );

	if ( ! isset( $favicon ) || empty( $favicon ) )
		$favicon = THEME_URL . 'images/favicon.ico';

	// check for ssl
	if ( is_ssl() ) {
		$favicon = str_replace( 'http://', 'https://', $favicon );
	}

	$output = '';
	$output .= '<link rel="shortcut icon" id="favicon" type="image/x-icon" href="' . esc_url( $favicon ) . '" />' . PHP_EOL;
	
	echo $output;
}

add_action( 'wp_head', '_sp_display_custom_head_scripts' );

/**
 * Function that displays custom head scripts
 *
 * @access private
 * @since 3.0
 * @return mixed html
 */	
function _sp_display_custom_head_scripts() {
	// get saved setting
	$script = sp_get_option( 'custom_head_scripts' );

	if ( ! isset( $script ) || empty( $script ) )
		return;

	// remove existing script tags
	$script = preg_replace( '/<script.+>/', '', $script );
	$script = preg_replace( '/<\/script>/', '', $script );

	$output = '<script type="text/javascript">';
	$output .= $script;
	$output .= '</script>';

	echo $output;
}

add_action( 'wp_footer', '_sp_display_custom_footer_scripts' );

/**
 * Function that displays custom footer scripts
 *
 * @access private
 * @since 3.0
 * @return mixed html
 */	
function _sp_display_custom_footer_scripts() {
	// get saved setting
	$script = sp_get_option( 'custom_footer_scripts' );

	if ( ! isset( $script ) || empty( $script ) )
		return;

	// remove existing script tags
	$script = preg_replace( '/<script.+>/', '', $script );
	$script = preg_replace( '/<\/script>/', '', $script );

	$output = '<script type="text/javascript">';
	$output .= $script;
	$output .= '</script>';

	echo $output;
}

add_action( 'wp_footer', '_sp_display_google_analytics_scripts' );

/**
 * Function that displays custom footer scripts
 *
 * @access private
 * @since 3.0
 * @return mixed html
 */	
function _sp_display_google_analytics_scripts() {
	// get saved setting
	$script = sp_get_option( 'ga' );

	if ( ! isset( $script ) || empty( $script ) )
		return;

	// remove existing script tags
	//$script = preg_replace( '/<script.+>/', '', $script );
	//$script = preg_replace( '/<\/script>/', '', $script );
	$script = strip_tags( $script );
	
	$output = '<script type="text/javascript">';
	$output .= $script;
	$output .= '</script>';

	echo $output;
}

if ( ! function_exists( 'sp_copyright_html' ) ) :
/**
 * Function that displays the copyright
 *
 * @access public
 * @since 3.0
 * @return mixed html
 */	
function sp_copyright_html() { 
	// get saved setting
	$info = get_theme_mod( 'copyright_title_text' );
	$copyright_show = get_theme_mod( 'copyright_show' );

	if ( isset( $copyright_show ) && $copyright_show === 'off' )
		return '';

	$output = '';
	$output .= '<small id="copyright">' . str_replace( array( '%%YEAR%%', '%YEAR%' ), date( 'Y' ), $info ) . '</small>' . PHP_EOL;

	return apply_filters( 'sp_site_copyright', $output, $info );
}
endif;

/**
 * Function that displays the site layout
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_site_layout() {
	// check if layout is boxed
	if ( sp_get_option( 'site_layout', 'is', 'boxed' ) )
		return 'boxed container';
	else
		return '';
}

/**
 * Function that displays the mini cart
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_display_mini_cart() {
	global $woocommerce;

	// check what cart type to use
	if ( sp_get_option( 'mini_cart_type' ) === 'simple' ) {
	?>
		<div class="mini-cart-contents-simple clearfix">
        	<div class="simple-cart clearfix">
                <em class="count"><span class="number">
            	<?php 	                   
                if ( sp_woo_exists() ) {
					if ( $woocommerce->cart->cart_contents_count === 0 )
						echo "0";										
					else
						echo $woocommerce->cart->cart_contents_count;
				} 
				?>
                </span> &times; <span><?php echo apply_filters( 'sp_mini_cart_items_text', __( 'Item(s)', 'sp-theme' ) ); ?></span> | 
                </em>
                <em class="total"><span><?php echo apply_filters( 'sp_mini_cart_sub_total_text', __( 'Subtotal', 'sp-theme' ) ); ?>: </span><span class="price">
                <?php 
                if ( sp_woo_exists() ) { 
					echo $woocommerce->cart->get_cart_subtotal();
					$checkout_link = get_permalink( get_option( 'woocommerce_cart_page_id' ) );
				}
				?>
                </span>
                </em> | <a href="<?php echo esc_url( $checkout_link ); ?>" title="<?php esc_attr_e( 'Checkout', 'sp-theme' ); ?>" class="checkout-link"><?php echo apply_filters( 'sp_mini_cart_checkout_link_text', '<strong>' . __( 'CHECK', 'sp-theme' ) . '</strong>' . __( 'OUT', 'sp-theme' ) ); ?> <i class="<?php echo apply_filters( 'sp_mini_cart_simple_icon', 'icon-angle-right' ); ?>" aria-hidden="true"></i></a>
                <span class="arrow-shadow"></span>
                <span class="arrow"></span>
            </div><!--close .simple-cart-->
        </div><!--close .mini-cart-contents-simple-->		            		
    <?php
	} elseif ( sp_get_option( 'mini_cart_type' ) === 'full' ) {
	?>
		<div class="mini-cart-contents clearfix">
			<div class="full-cart clearfix">
				<?php	           
				if ( sp_woo_exists() ) {
					// can pass in list_class as an array for argument
				?>
					<div class="widget_shopping_cart_content">	
					<?php woocommerce_mini_cart(); ?>
					</div><!--close .widget_shopping_cart_content-->
				<?php
				} ?>
				<span class="arrow-shadow"></span>
				<span class="arrow"></span>
			</div><!--close .full-cart-->
		</div><!--close .mini-cart-contents-->
	<?php
	}
}

/**
 * Function that displays the login/signup links
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_display_login_links() {
	if ( sp_get_option( 'show_login', 'is', 'on' ) ) {
		$show_account = false;

	    // get account url of the relative ecommerce plugin
	    if ( sp_woo_exists() ) {
	        $account_url = get_permalink( woocommerce_get_page_id( 'myaccount' ) );

	        $show_account = true;
	    } else {
	    	$account_url = '#';
	    }
	    ?>
	    <?php
	    if ( is_user_logged_in() ) { 
	    ?>
	        <i class="icon-user" aria-hidden="true"></i> <?php echo sp_get_username(); ?> <?php if ( $show_account ) { ?><a href="<?php echo esc_url( $account_url ); ?>" title="<?php esc_attr_e( 'My Account', 'sp-theme'); ?>" class="account-links"><?php _e( 'My Account', 'sp-theme' ); ?></a><?php } ?> | <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php esc_attr_e( 'Logout', 'sp-theme'); ?>" class="account-links"><?php _e( 'Logout', 'sp-theme' ); ?></a>
	    <?php                
	    } else {
	    ?>
	        <a href="<?php echo get_permalink( sp_login_page_id() ); ?>" title="<?php esc_attr_e( 'Log In', 'sp-theme'); ?>" class="sp-login account-links"><i class="icon-user" aria-hidden="true"></i> <?php _e( 'Log In', 'sp-theme' ); ?></a> 
	    	<?php
	    	if ( sp_get_option( 'show_register', 'is', 'on' ) ) {
	    	?>
	        | <a href="<?php echo get_permalink( sp_register_page_id() ); ?>" title="<?php esc_attr_e( 'Register', 'sp-theme'); ?>" class="sp-register account-links"><?php _e( 'Register', 'sp-theme'); ?></a>
	    	<?php
	    	}
		}       
	} else {
		return null;
	}  
}

/**
 * Function that displays the search field
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_display_search_field() {
	echo get_template_part( 'searchform' );

	return true;
}

/**
 * Function that displays breadcrumbs
 * Attribution goes to Dimox for the code http://dimox.net
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_display_breadcrumbs() {
	global $post;

	// don't display for cart/checkout pages
	if ( sp_is_checkout_pages() )
		return;
	
	if ( ! is_object( $post ) )
		return;
	
	// get the meta
	$show_breadcrumbs = sp_get_option( 'show_page_breadcrumbs' );

	if ( $show_breadcrumbs === 'on' ) {

		/* === OPTIONS === */
		$text['home']     = '<i class="icon-home" aria-hidden="true"></i>'; // text for the 'Home' link
		$text['category'] = __( 'Archive by Category "%s"', 'sp-theme' ); // text for a category page
		$text['search']   = __( 'Search Results for "%s" Query', 'sp-theme' ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"', 'sp-theme' ); // text for a tag page
		$text['author']   = __( 'Articles Posted by "%s"', 'sp-theme' ); // text for an author page
		$text['404']      = __( 'Error 404', 'sp-theme' ); // text for the 404 page

		$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
		$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_title     = 1; // 1 - show the title for the links, 0 - don't show
		$delimiter      = '<i class="icon-angle-right" aria-hidden="true"></i> '; // delimiter between crumbs
		$before         = '<span class="current" itemprop="breadcrumb">'; // tag before the current crumb
		$after          = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$home_link    = home_url('/');
		$link_before  = '<span itemprop="breadcrumb">';
		$link_after   = '</span>';
		$link_attr    = ' itemprop="url"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id    = $parent_id_2 = $post->post_parent;
		$frontpage_id = get_option('page_on_front');

		if ( is_home() || is_front_page() ) {

			if ( $show_on_home == 1 ) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<nav class="breadcrumbs" itemscope itemtype="http://schema.org/breadcrumb">';
			if ( $show_home_link == 1 ) {
				echo sprintf( $link, $home_link, $text['home'] );
				if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) echo $delimiter;
			}

			if ( is_category() ) {
				$this_cat = get_category (get_query_var('cat'), false );
				if ($this_cat->parent != 0) {
					$cats = get_category_parents( $this_cat->parent, TRUE, $delimiter );
					if ( $show_current == 0 ) $cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) $cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					echo $cats;
				}
				if ( $show_current == 1 ) echo $before . sprintf( $text['category'], single_cat_title( '', false) ) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf( $text['search'], get_search_query() ) . $after;

			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y') ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F') ) . $delimiter;
				echo $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link(get_the_time('Y') ), get_the_time('Y') ) . $delimiter;
				echo $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug = $post_type->rewrite;
					printf( $link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $show_current == 1 ) echo $delimiter . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents( $cat, TRUE, $delimiter );
					if ( $show_current == 0 ) $cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) $cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					echo $cats;
					if ( $show_current == 1 ) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post( $parent_id );
				$cat = get_the_category( $parent->ID ); $cat = $cat[0];
				$cats = get_category_parents( $cat, TRUE, $delimiter );
				$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
				$cats = str_replace( '</a>', '</a>' . $link_after, $cats);
				if ( $show_title == 0 ) $cats = preg_replace( '/ title="(.*?)"/', '', $cats );
				echo $cats;
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $show_current == 1 ) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$parent_id ) {
				if ( $show_current == 1 ) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $parent_id ) {
				if ( $parent_id != $frontpage_id ) {
					$breadcrumbs = array();
					while ( $parent_id ) {
						$page = get_page( $parent_id );
						if ( $parent_id != $frontpage_id ) {
							$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID) );
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse( $breadcrumbs );
					for ( $i = 0; $i < count( $breadcrumbs); $i++ ) {
						echo $breadcrumbs[$i];
						if ( $i != count( $breadcrumbs )-1 ) echo $delimiter;
					}
				}
				if ( $show_current == 1 ) {
					if ( $show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) echo $delimiter;
					echo $before . get_the_title() . $after;
				}

			} elseif ( is_tag() ) {
				echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

			} elseif ( is_author() ) {
		 		global $author;
				$userdata = get_userdata( $author );
				echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				echo __( 'Page', 'sp-theme' ) . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</nav><!-- .breadcrumbs -->';
		}
	}
}

/**
 * Function that displays the page builder sections
 *
 * @access public
 * @since 3.0
 * @return html
 */	
function sp_display_page_builder() {
	global $post;
	
	$cache = get_post_meta( $post->ID, '_sp_page_builder_cache', true );

	if ( empty( $cache ) || $cache === 'on' ) {
		$cache = true;
	} else {
		$cache = false;
	}

	// check if page already in transient
	//if ( false === ( $output = get_transient( 'sp-page-builder-' . $post->ID ) ) || false === $cache ) {

		// get status
		$pb_status = get_post_meta( $post->ID, '_sp_page_builder_status', true );

		// bail if status is off
		if ( isset( $pb_status ) && $pb_status === 'off' ) {
			return;
		}

		// get outer container style
		$pb_outer_container_style = get_post_meta( $post->ID, '_sp_page_builder_outer_container_style', true );

		// set default outer container style
		if ( ! isset( $pb_outer_container_style ) || empty( $pb_outer_container_style ) ) {
			$pb_outer_container_style = 'full_width';
		}

		if ( $pb_outer_container_style === 'full_width' ) {
			$outer_container_style = '';
		} else {
			$outer_container_style = 'container pb-boxed';
		}

		// get modules
		$pb_modules = get_post_meta( $post->ID, '_sp_page_builder_modules', true );
		$pb_modules = maybe_unserialize( base64_decode( $pb_modules ) );

		// get layout values
		$layout = sp_get_page_layout(); 
		$orientation = $layout['orientation'];
		$span_columns = $layout['span_columns'];

		// output the columns needed
		$output = '';

		//offset class
		$header_columns_offset_class = '';

		if ( is_array( $pb_modules ) ) {
			ob_start();
			do_action( 'sp_page_layout_before_content_row' );
			$output .= ob_get_clean();

			$output .= '<div class="page-builder main-container entry-content ' . esc_attr( $outer_container_style ) . '">' . PHP_EOL;

			// if not password protected page
			if ( ! post_password_required() ) {

				$row_count = count( $pb_modules['row'] );

				foreach ( $pb_modules['row'] as $row ) {

					// skip row if row status is off
					if ( isset( $row['row_status'] ) && $row['row_status'] === 'hide_row' ) {
						continue;
					}

					$row_column_class = isset( $row['row_column_class'] ) ? $row['row_column_class'] : '';

					if ( isset( $row['row_width'] ) && $row['row_width'] === 'boxed_width' ) {
						$output .= '<div class="container">' . PHP_EOL;
						//$output .= '<div class="row">' . PHP_EOL;
					} elseif ( $pb_outer_container_style === 'full_width' ) {
						//$output .= '<div class="row">' . PHP_EOL;
					} else {
						$output .= '<div class="container">' . PHP_EOL;
						$output .= '<div class="row">' . PHP_EOL;
					}

					if ( isset( $row['column'] ) ) {
						$i = 1;

						foreach( $row['column'] as $column ) { 

							switch( count( $row['column'] ) ) {
								case 1 :
									$header_columns_class = '';
									break;

								case 2 :
									// check if columns are one third and two third
									if ( isset( $row_column_class ) && 'one-third' === $row_column_class ) {
										// first column
										if ( $i === 1 ) {
											$header_columns_class = sp_column_css( '', '', '', '4' );
										} elseif ( $i === 2 ) {
											$header_columns_class = sp_column_css( '', '', '', '8' );
										}
									} elseif ( isset( $row_column_class ) && 'two-third' === $row_column_class ) {
										// first column
										if ( $i === 1 ) {
											$header_columns_class = sp_column_css( '', '', '', '8' );
										} elseif ( $i === 2 ) {
											$header_columns_class = sp_column_css( '', '', '', '4' );
										}
									} elseif ( isset( $row_column_class ) && 'one-fourth' === $row_column_class ) {
										// first column
										if ( $i === 1 ) {
											$header_columns_class = sp_column_css( '', '', '', '3' );
										} elseif ( $i === 2 ) {
											$header_columns_class = sp_column_css( '', '', '', '9' );
										}
									} elseif ( isset( $row_column_class ) && 'three-fourth' === $row_column_class ) {
										// first column
										if ( $i === 1 ) {
											$header_columns_class = sp_column_css( '', '', '', '9' );
										} elseif ( $i === 2 ) {
											$header_columns_class = sp_column_css( '', '', '', '3' );
										}
									} else {
										$header_columns_class = sp_column_css( '', '', '', '6' );
									}
									break;

								case 3 :
									// check if columns is two sidebars
									if ( isset( $row_column_class ) && 'two-sidebars' === $row_column_class ) {
										// first column
										if ( $i === 1 ) {
											$header_columns_class = sp_column_css( '', '', '', '2' );
										} elseif ( $i === 2 ) {
											$header_columns_class = sp_column_css( '', '', '', '8' );
										} elseif ( $i ===3 ) {
											$header_columns_class = sp_column_css( '', '', '', '2' );
										}
									} else {
										$header_columns_class = sp_column_css( '', '', '', '4' );
									}
									break;

								case 4 :
									$header_columns_class = sp_column_css( '', '', '', '3' );
									break;

								case 5 :
									$header_columns_class = sp_column_css( '', '', '', '2', '', '', '2' );
									break;

								case 6 :
									$header_columns_class = sp_column_css( '', '', '', '2' );
									break;														
							}

							$output .= '<div class="' . esc_attr( $header_columns_class ) . '">' . PHP_EOL;

							if ( isset( $column['module'] ) ) {
								foreach( $column['module'] as $module ) {
									// skip on placeholder
									if ( array_key_exists( 'placeholder', $module ) ) {
										continue;
									}

									switch( key( $module ) ) {
										case 'shortcode' :
											$shortcode = $module[key( $module )]['shortcode'];									

											// if shortcode is set echo it
											if ( isset( $shortcode ) && ! empty( $shortcode ) ) 
												$output .= do_shortcode( stripslashes( $module[key( $module )]['shortcode'] ) );	

											break;
										case 'custom_content' :
											$content = $module[key( $module )]['content'];

											// if heading is used echo it
											if ( isset( $heading ) && ! empty( $heading ) )
												$output .= '<h2 class="pb-module-heading">' . $heading . '</h2>';
											
											// if content is set echo it
											if ( isset( $content ) && ! empty( $content ) ) 
												$output .= do_shortcode( stripslashes( $module[key( $module )]['content'] ) );

											break;
										case 'placeholder' :
											break;

										case 'widget_area' :
											ob_start();
											dynamic_sidebar( str_replace( array( ' ', '(', ')' ), '', strtolower( trim( $module['widget_area'] ) ) ) );
											$output .= ob_get_clean();

											break;

										default :
											$scode = '[' . $module[key( $module )]['shortcode_name'];

											// loop through options and build shortcode
											foreach( $module[key( $module )] as $name => $option ) {	
												if ( $name !== 'inner_wrap_content' )
													$scode .= ' ' . $name . '="' . $option . '"'; 
											}

											$scode .= ']';

											// check if we need to display closing wrap
											if ( isset( $module[key( $module )]['inner_wrap_content'] ) && ! empty( $module[key( $module )]['inner_wrap_content'] ) )
												$scode .= $module[key( $module )]['inner_wrap_content'] . '[/' . $module[key( $module )]['shortcode_name'] . ']';

											$output .= do_shortcode( $scode );
											break;
									}
								} // module loop
							}

							// echo the closing column wrapper
							$output .= '</div><!--close .column-->' . PHP_EOL;

							$i++;
						} // column loop
					}

					if ( isset( $row['row_width'] ) && $row['row_width'] === 'boxed_width' ) {
						//$output .= '</div><!--close .row-->' . PHP_EOL;	
						$output .= '</div><!--close .container-->' . PHP_EOL;

					} elseif ( $pb_outer_container_style === 'full_width' ) {
						//$output .= '</div><!--close .row-->' . PHP_EOL;						
					} else {
						$output .= '</div><!--close .row-->' . PHP_EOL;
						$output .= '</div><!--close .container-->' . PHP_EOL;
					}
				} // row loop
			
			} else {
				$output .= '<div class="container protected"><br /><br />' . PHP_EOL;
				$output .= get_the_password_form( $post->ID );
				$output .= '</div><!--close .container-->' . PHP_EOL;
			} // end password protected check

			$output .= '<div class="container">' . PHP_EOL;
			$output .= sp_display_social_media_buttons();
			$output .= '</div><!--close container-->' . PHP_EOL;
			
			$output .= '</div><!--close .page-builder-->' . PHP_EOL;

			ob_start();
			do_action( 'sp_page_layout_after_content_row' );
			$output .= ob_get_clean();						
		}

		//set_transient( 'sp-page-builder-' . $post->ID, $output );
	//}

	echo $output;

	return true;
}

if ( ! function_exists( 'sp_back_to_top_html' ) ) :
/**
 * Function that displays the back to top html
 *
 * @access public
 * @since 3.0
 * @return mixed html
 */	
function sp_back_to_top_html() { 
	// get saved setting
	$show = sp_get_option( 'back_to_top' );

	$output = '';

	if ( isset( $show ) && $show === 'on' )
		$output = '<a href="#top" class="site-btt" title="' . esc_attr__( 'Back to Top', 'sp-theme' ) . '"><i class="icon-chevron-up" aria-hidden="true"></i></a>' . PHP_EOL;

	return $output;
}
endif;

if ( ! function_exists( 'sp_share_button_html' ) ) :
/**
 * Function that builds share button link
 *
 * @access public
 * @since 3.0
 * @return mixed html $output
 */	
function sp_share_button_html() {

	$output = '';

	$output .= apply_filters( 'sp_share_button_link_html', '<a href="#" class="sp-tooltip share-button" title="' . esc_attr__( 'Share This', 'sp-theme' ) . '" data-toggle="tooltip" data-placement="top"><i class="icon-group" aria-hidden="true"></i><span class="text">' . __( 'Share', 'sp-theme' ) . '</span></a>' ) . PHP_EOL;

	return $output;
}
endif;

if ( ! function_exists( 'sp_footer_phone_number_html' ) ) :
/**
 * Function that displays the footer phone number
 *
 * @access public
 * @since 3.0
 * @return mixed html $output
 */	
function sp_footer_phone_number_html() {

	$output = '';

	$phone = sp_get_option( 'footer_phone' );

	if ( sp_get_option( 'show_footer_phone', 'is', 'on' ) && ! empty( $phone ) ) {

		// prep the phone number
		$phone_raw = apply_filters( 'sp_phone_number_format', str_replace( array( ' ', '-', '(', ')', '.' ), '', $phone ), $phone );

		$output .= '<p class="footer-phone-number"><span class="divider">|</span>' . apply_filters( 'sp_footer_phone_label', __( 'Tel:', 'sp-theme' ) ) . ' <a href="tel:' . esc_attr( $phone_raw ) . '" class="phone">' . $phone . '</a></p>' . PHP_EOL;
	}

	return $output;
}
endif;