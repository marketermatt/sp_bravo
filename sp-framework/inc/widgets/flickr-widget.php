<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * flickr widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function to get the flickr stream data
 *
 * @access private
 * @since 3.0
 * @param string $api_key | the api key for flickr
 * @param string $user_id | the user id for flickr
 * @return string
 */
function _sp_get_flickr_stream( $widget_id, $api_key, $user_id, $count = '10' ) {
	// bail if key and id not set
	if ( ! isset( $api_key ) || empty( $api_key ) || ! isset( $user_id ) || empty( $user_id ) )
		return;

	// if cached version not found or expired get from flickr
	if ( false === ( $rsp_obj = get_transient( $widget_id ) ) ) {

		$params = array(
			'api_key'	=> $api_key,
			'user_id'	=> $user_id,
			'method'	=> 'flickr.photos.search',
			'per_page'	=> $count,
			'format'	=> 'php_serial',
		);

		$encoded_params = array();

		// encode params
		foreach ( $params as $k => $v ) {
			$encoded_params[] = urlencode( $k ) . '=' . urlencode( $v );
		}

		// build url
		$url = 'https://api.flickr.com/services/rest/?' . implode( '&', $encoded_params );

		// pass url and get response
		$rsp = wp_remote_get( $url, array( 'sslverify' => false ) );

		// extract the response body only
		$rsp = wp_remote_retrieve_body( $rsp );

		// unserialize the response
		$rsp_obj = unserialize( $rsp );

		// cache the response
		set_transient( $widget_id, $rsp_obj, 60*60*2 ); // refreshes every 2 hours
	}

	return $rsp_obj;
}

class SP_Flickr_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function SP_Flickr_Widget() {
		// Instantiate the parent object
		parent::__construct( false, 'SP Flickr Widget' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sp-flickr-widget', 'description' => __( 'A widget to display your Flickr Photo Stream.', 'sp-theme' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'sp-flickr-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sp-flickr-widget', 'SP Flickr Widget', $widget_ops, $control_ops );	

	}	

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {	
		
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );

		/* Before widget (defined by theme). */
		echo $before_widget;
		
		if ( ! empty( $title ) )
			echo $before_title . apply_filters( 'sp_flickr_widget_title_icon', ' <i class="icon-flickr2" aria-hidden="true"></i> ' ) . $title . $after_title;
		
		$output = '';

		// get the photos
		$photos = _sp_get_flickr_stream( $args['widget_id'], $instance['api_key'], $instance['user_id'], $instance['count'] );

		// check to make sure there are photos to show
		if ( is_array( $photos ) && isset( $photos['photos'] ) && $photos['photos']['total'] > 0 ) {
			if ( ! isset( $instance['show_lightbox'] ) || empty( $instance['show_lightbox'] ) )
				$show_lightbox = 'false';
			else
				$show_lightbox = $instance['show_lightbox'];

			$width = absint( $instance['width'] );
			$height = absint( $instance['height'] );

			if ( isset( $instance['show_lightbox'] ) && ! empty( $instance['show_lightbox'] ) )
				$lightbox = 'lightbox';
			else 
				$lightbox = '';

			// note _b is large and _s is small ( there are many other sizes as well )
			foreach( $photos['photos']['photo'] as $photo ) {
				$output .= '<a href="' . esc_url( 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_b.jpg' ) . '" title="' . esc_attr( $photo['title'] ) . '" class="flickr-item ' . $lightbox . '" data-rel="sp-lightbox[flickr]"><img src="' . esc_url( 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_s.jpg' ) . '" alt="' . esc_attr( $photo['title'] ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" /><span class="overlay"></span></a>' . PHP_EOL;
			}
		}

		echo $output;

		/* After widget (defined by themes). */
		echo $after_widget;	
	}	

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['api_key'] = sanitize_text_field( $new_instance['api_key'] );
		$instance['user_id'] = sanitize_text_field( $new_instance['user_id'] );
		$instance['width'] = sanitize_text_field( $new_instance['width'] );
		$instance['height'] = sanitize_text_field( $new_instance['height'] );
		$instance['count'] = sanitize_text_field( $new_instance['count'] );
		$instance['show_lightbox'] = sanitize_text_field( $new_instance['show_lightbox'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		$defaults = array( 'title' => '', 'api_key' => '', 'user_id' => '', 'count' => '10', 'width' => '75', 'height' => '75', 'show_lightbox' => 'true', 'refresh' => 'false' );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); 

		?>
		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>"><?php _e( 'API KEY:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['api_key'] ); ?>" />
		</p>
		<p class="howto"><?php _e( 'Enter the api key for your photo stream. This is required. To learn how to obtain a API KEY, click the link and log into your Flickr account.', 'sp-theme' ); ?><a href="http://www.flickr.com/services/api/" title="Flickr API KEY" target="_blank"><?php _e( 'Get API KEY', 'sp-theme' ); ?></a></p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>"><?php _e( 'User ID:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['user_id'] ); ?>" />
		</p>
		<p><?php _e( 'Enter your user id. The id looks something like this -> 947453136@N06', 'sp-theme' ); ?></p>

        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Show How Many Photos:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['count'] ); ?>" />        	
        </p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php _e( 'Thumbnail Width:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>
		<p><?php _e( 'Enter the width you want your thumbnail photo to be in pixels. Default is 75.', 'sp-theme' ); ?></p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php _e( 'Height:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['height'] ); ?>" />
		</p>
		<p><?php _e( 'Enter the height you want your thumbnail photo to be in pixels. Default is 75.', 'sp-theme' ); ?></p>

        <p>
        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_lightbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_lightbox' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_lightbox'] ); ?> />
        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_lightbox' ) ); ?>"><?php _e( 'Show Lightbox:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
        </p>
        <p class="howto"><?php _e( 'Check the box to show a popup lightbox when a photo is clicked.', 'sp-theme' ); ?></p>	        					
		<?php
    }	
}