<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * facebook widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

class SP_Facebook_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function SP_Facebook_Widget() {
		// Instantiate the parent object
		parent::__construct( false, 'SP Facebook Widget' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sp-facebook-widget', 'description' => __( 'A widget to display your Facebook Activity Feed or Facebook Like Box.', 'sp-theme' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'sp-facebook-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sp-facebook-widget', 'SP Facebook Widget', $widget_ops, $control_ops );	

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
			echo $before_title . apply_filters( 'sp_facebook_widget_title_icon', ' <i class="icon-facebook" aria-hidden="true"></i> ' ) . $title . $after_title;	
		
		$output = '';

		// check the plugin type
		if ( $instance['plugin_type'] === 'activity_feed' ) {
			$af_width = absint( $instance['af_width'] );
			$af_height = absint( $instance['af_height'] );

			if ( ! isset( $instance['af_show_header'] ) || empty( $instance['af_show_header'] ) )
				$af_show_header = 'false';
			else
				$af_show_header = $instance['af_show_header'];

			if ( ! isset( $instance['show_recommendations'] ) || empty( $instance['show_recommendations'] ) )
				$show_recommendations = 'false';
			else
				$show_recommendations = $instance['show_recommendations'];

			$output .= '<div class="fb-activity" data-site="' . esc_attr( $instance['domain'] ) . '" data-action="' . esc_attr( $instance['action'] ) . '" data-width="' . esc_attr( $af_width ) . '" data-height="' . esc_attr( $af_height ) . '" data-header="' . esc_attr( $af_show_header ) . '" data-recommendations="' . esc_attr( $show_recommendations ) . '" data-colorscheme="' . esc_attr( $instance['af_color_scheme'] ) . '" data-linktarget="' . esc_attr( $instance['link_target'] ) . '" data-app-id="' . esc_attr( $instance['app_id'] ) . '"></div>';
			
		} elseif ( $instance['plugin_type'] === 'like_box' ) {
			$lb_width = absint( $instance['lb_width'] );
			$lb_height = absint( $instance['lb_height'] );

			if ( ! isset( $instance['show_stream'] ) || empty( $instance['show_stream'] ) )
				$show_stream = 'false';
			else
				$show_stream = $instance['show_stream'];

			if ( ! isset( $instance['show_faces'] ) || empty( $instance['show_faces'] ) )
				$show_faces = 'false';
			else
				$show_faces = $instance['show_faces'];

			if ( ! isset( $instance['lb_show_header'] ) || empty( $instance['lb_show_header'] ) )
				$lb_show_header = 'false';
			else
				$lb_show_header = $instance['lb_show_header'];

			$output .= '<div class="fb-like-box" data-href="' . esc_attr( $instance['page_url'] ) . '" data-width="' . esc_attr( $lb_width ) . '" data-height="' . esc_attr( $lb_height ) . '" data-show-faces="' . esc_attr( $show_faces ) . '" data-colorscheme="' . esc_attr( $instance['lb_color_scheme'] ) . '" data-stream="' . esc_attr( $show_stream ) . '" data-header="' . esc_attr( $lb_show_header ) . '"></div>';
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
		$instance['plugin_type'] = sanitize_text_field( $new_instance['plugin_type'] );
		$instance['domain'] = sanitize_text_field( $new_instance['domain'] );
		$instance['app_id'] = sanitize_text_field( $new_instance['app_id'] );
		$instance['action'] = sanitize_text_field( $new_instance['action'] );
		$instance['af_width'] = sanitize_text_field( $new_instance['af_width'] );
		$instance['af_height'] = sanitize_text_field( $new_instance['af_height'] );
		$instance['af_show_header'] = sanitize_text_field( $new_instance['af_show_header'] );
		$instance['af_color_scheme'] = sanitize_text_field( $new_instance['af_color_scheme'] );
		$instance['link_target'] = sanitize_text_field( $new_instance['link_target'] );
		$instance['show_recommendations'] = sanitize_text_field( $new_instance['show_recommendations'] );
		$instance['page_url'] = sanitize_text_field( $new_instance['page_url'] );
		$instance['lb_width'] = sanitize_text_field( $new_instance['lb_width'] );
		$instance['lb_height'] = sanitize_text_field( $new_instance['lb_height'] );
		$instance['show_faces'] = sanitize_text_field( $new_instance['show_faces'] );
		$instance['lb_color_scheme'] = sanitize_text_field( $new_instance['lb_color_scheme'] );
		$instance['show_stream'] = sanitize_text_field( $new_instance['show_stream'] );
		$instance['lb_show_header'] = sanitize_text_field( $new_instance['lb_show_header'] );
				
		
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
		$defaults = array( 'title' => '', 'plugin_type' => 'activity_feed', 'domain' => '', 'app_id' => '', 'action' => '', 'af_width' => '250', 'af_height' => '300', 'af_show_header' => 'true', 'af_color_scheme' => 'light', 'link_target' => '_blank', 'show_recommendations' => 'false', 'page_url' => '', 'lb_width' => '250', 'lb_height' => '300', 'show_faces' => 'true', 'show_stream' => 'true', 'lb_color_scheme' => 'light', 'lb_show_header' => 'true' );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); 

		?>
		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'plugin_type' ) ); ?>"><?php _e( 'Select a Plugin:', 'sp-theme' ); ?></label><br />
			<select id="<?php echo esc_attr( $this->get_field_id( 'plugin_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'plugin_type' ) ); ?>" class="fb-plugin-type select2-select">
				<option value="activity_feed" <?php selected( 'activity_feed', $instance['plugin_type'] ); ?>><?php _e( 'Activity Feed', 'sp-theme' ); ?></option>	
				<option value="like_box" <?php selected( 'like_box', $instance['plugin_type'] ); ?>><?php _e( 'Like Box', 'sp-theme' ); ?></option>	
			</select>
        </p>

 		<?php
 		// checks which type is set and show options accordingly
 		if ( $instance['plugin_type'] === 'activity_feed' ) {
 			$show_activity_feed = 'display:block;';
 			$show_like_box = 'display:none;';
 		} elseif ( $instance['plugin_type'] === 'like_box' ) {
 			$show_activity_feed = 'display:none;';
 			$show_like_box = 'display:block;';
 		}
 		?>

        <div class="type-activity-feed" style="<?php echo $show_activity_feed; ?>">
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'domain' ) ); ?>"><?php _e( 'Domain:', 'sp-theme' ); ?></label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'domain' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'domain' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['domain'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the domain to show the activity for. For example http://splashingpixels.com', 'sp-theme' ); ?></p>

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>"><?php _e( 'App ID:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['app_id'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the associated App ID. If you specify an App ID for the Activity Feed plugin, we will display all actions (built-in and custom) specified by the associated app ID.', 'sp-theme' ); ?></p>	 

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'action' ) ); ?>"><?php _e( 'Action:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'action' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['action'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter all the actions you want to be associated with this activity box. Separate each action with a comma. For example "like".', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'af_width' ) ); ?>"><?php _e( 'Width:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'af_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'af_width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['af_width'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the width you would like the box to be in pixels.', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'af_height' ) ); ?>"><?php _e( 'Height:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'af_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'af_height' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['af_height'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the height you would like the box to be in pixels.', 'sp-theme' ); ?></p>		  

	        <p>
	        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'af_show_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'af_show_header' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['af_show_header'] ); ?> />
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'af_show_header' ) ); ?>"><?php _e( 'Show Header:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
	        </p>
	        <p class="howto"><?php _e( 'Check the box to show the Facebook Activity Feed Header.', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'af_color_scheme' ) ); ?>"><?php _e( 'Select a Color Scheme: (optional)', 'sp-theme' ); ?></label><br />
				<select id="<?php echo esc_attr( $this->get_field_id( 'af_color_scheme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'af_color_scheme' ) ); ?>" class="select2-select">
					<option value="light" <?php selected( 'light', $instance['af_color_scheme'] ); ?>><?php _e( 'Light', 'sp-theme' ); ?></option>
					<option value="dark" <?php selected( 'dark', $instance['af_color_scheme'] ); ?>><?php _e( 'Dark', 'sp-theme' ); ?></option>	
				</select>
	        </p>

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'link_target' ) ); ?>"><?php _e( 'Link Target: (optional)', 'sp-theme' ); ?></label><br />
				<select id="<?php echo esc_attr( $this->get_field_id( 'link_target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_target' ) ); ?>" class="select2-select">
					<option value="_blank" <?php selected( '_blank', $instance['link_target'] ); ?>><?php _e( 'New Window', 'sp-theme' ); ?></option>
					<option value="_parent" <?php selected( '_parent', $instance['link_target'] ); ?>><?php _e( 'Same Window', 'sp-theme' ); ?></option>	
				</select>
	        </p>	  
	        <p class="howto"><?php _e( 'Select where the link will go when clicked. It can open up in a new window or open up in the same window.', 'sp-theme' ); ?></p>

	        <p>
	        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_recommendations' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_recommendations' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_recommendations'] ); ?> />
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_recommendations' ) ); ?>"><?php _e( 'Show Recommendations:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
	        </p>
	        <p class="howto"><?php _e( 'Specifies whether to always show recommendations in the plugin. If recommendations is checked, the plugin will display recommendations in the bottom half.', 'sp-theme' ); ?></p>	              	        	              	                       
        </div><!--close type-activity-feed-->

        <div class="type-like-box" style="<?php echo esc_attr( $show_like_box ); ?>">
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php _e( 'Facebook Page URL:', 'sp-theme' ); ?></label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the Facebook page URL.  For example "http://facebook.com/splashingpixels"', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'lb_width' ) ); ?>"><?php _e( 'Width:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lb_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lb_width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['lb_width'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the width you would like the box to be in pixels.', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'lb_height' ) ); ?>"><?php _e( 'Height:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lb_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lb_height' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['lb_height'] ); ?>" />
	        </p>
	        <p class="howto"><?php _e( 'Enter the height you would like the box to be in pixels.', 'sp-theme' ); ?></p>		  

	        <p>
	        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_faces'] ); ?> />
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php _e( 'Show Faces:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
	        </p>
	        <p class="howto"><?php _e( 'Check the box to show profile photos in the plugin.', 'sp-theme' ); ?></p>	

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'lb_color_scheme' ) ); ?>"><?php _e( 'Select a Color Scheme: (optional)', 'sp-theme' ); ?></label><br />
				<select id="<?php echo esc_attr( $this->get_field_id( 'lb_color_scheme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lb_color_scheme' ) ); ?>" class="select2-select">
					<option value="light" <?php selected( 'light', $instance['lb_color_scheme'] ); ?>><?php _e( 'Light', 'sp-theme' ); ?></option>
					<option value="dark" <?php selected( 'dark', $instance['lb_color_scheme'] ); ?>><?php _e( 'Dark', 'sp-theme' ); ?></option>	
				</select>
	        </p>

	        <p>
	        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_stream'] ); ?> />
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>"><?php _e( 'Show Profile Stream:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
	        </p>
	        <p class="howto"><?php _e( 'Specifies whether to display a stream of the latest posts from the Page\'s wall.', 'sp-theme' ); ?></p>

	        <p>
	        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'lb_show_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lb_show_header' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['lb_show_header'] ); ?> />
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'lb_show_header' ) ); ?>"><?php _e( 'Show Header:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
	        </p>
	        <p class="howto"><?php _e( 'Check the box to show the Facebook Like Box Header.', 'sp-theme' ); ?></p>	


        </div><!--close type-like-box-->

		<?php
    }	
}