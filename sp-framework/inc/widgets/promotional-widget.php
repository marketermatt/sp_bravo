<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * promotional widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

class SP_Promotional_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function SP_Promotional_Widget() {
		// Instantiate the parent object
		parent::__construct( false, 'SP Promotional Widget' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sp-promotional-widget', 'description' => __( 'A widget to display any promotional items.', 'sp-theme' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'sp-promotional-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sp-promotional-widget', 'SP Promotional Widget', $widget_ops, $control_ops );	

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

		$content = $instance['content'];
		$timezone = $instance['timezone'];
		
		// sets the default timezone based on user selection
		if ( isset( $timezone ) && ( $timezone != '0' ) ) 
			date_default_timezone_set( $timezone );

		$start_time = strtotime( $instance['start_time'] );
		$end_time = strtotime( $instance['end_time'] ); 
		$icon = $instance['icon'];

		// current unix timestamp
		$cur_time = time();
		
		if ( ( $cur_time >= $start_time ) && ( $cur_time <= $end_time ) ) {
			
			$title = apply_filters( 'widget_title', $instance['title'] );

			/* Before widget (defined by theme). */
			echo $before_widget;
			
			if ( ! empty( $title ) )
				echo $before_title . ' <i class="' . $icon . '" aria-hidden="true"></i> ' . $title . $after_title;			
			
			echo $content;
			
			/* After widget (defined by themes). */
			echo $after_widget;
		}
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
		$instance['content'] = sanitize_text_field( $new_instance['content'] );
		$instance['timezone'] = sanitize_text_field( $new_instance['timezone'] );
		$instance['start_time'] = sanitize_text_field( $new_instance['start_time'] );
		$instance['end_time'] = sanitize_text_field( $new_instance['end_time'] );
		$instance['icon'] = sanitize_text_field( $new_instance['icon'] );
		
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
		$defaults = array( 'title' => '', 'content' => '', 'timezone' => '0', 'start_time' => '', 'end_time' => '', 'icon' => '' );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); 
		$timezone = $instance['timezone'];
		?>
		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'timezone' ) ); ?>"><?php _e( 'Select Time Zone:', 'sp-theme' ); ?></label><br />
        	<?php 	
			include( THEME_PATH . 'sp-framework/inc/admin/timezones.php' );
			?>

			<select id="<?php echo esc_attr( $this->get_field_id( 'timezone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'timezone' ) ); ?>" class="select2-select">
				<option value="0"><?php _e( '--Please Select--', 'sp-theme' ); ?></option>
			<?php
			foreach ( $timezone_list as $k => $v ) {
			?>
				<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $k, $timezone ); ?>><?php echo $k; ?></option>
			<?php
			}
			?>
			</select>
        </p>
        
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'start_time' ) ); ?>"><?php _e( 'Select Start Time:', 'sp-theme' ); ?></label><br />
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'start_time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'start_time' ) ); ?>" class="promotional-widget datepicker widefat"  value="<?php echo esc_attr( $instance['start_time'] ); ?>" />
        </p>
        <p class="howto"><?php _e( 'Select the time you want to start displaying this widget.', 'sp-theme' ); ?></p>
        
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'end_time' ) ); ?>"><?php _e( 'Select End Time:', 'sp-theme' ); ?></label><br />
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'end_time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'end_time' ) ); ?>" class="promotional-widget datepicker widefat" value="<?php echo esc_attr( $instance['end_time'] ); ?>" />
        </p>
        <p class="howto"><?php _e( 'Select the time you want to stop displaying this widget.', 'sp-theme' ); ?></p>
		
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon Class Name:', 'sp-theme' ); ?></label><br />
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" class="promotional-widget widefat" value="<?php echo esc_attr( $instance['icon'] ); ?>" />
        </p>
        <p class="howto"><?php _e( 'You can optional add a cool icon before the widget title by entering the icon class name here.  You can use any icon font.  Please refer to the theme documentation on icon fonts.', 'sp-theme' ); ?></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php _e( 'Content:', 'sp-theme' ); ?></label><br />
			<textarea id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" style="width:100%;height:200px;"><?php echo $instance['content']; ?></textarea>
		</p>
		<p class="howto"><?php _e( 'Enter the content you want to display.', 'sp-theme' ); ?></p>

		<?php
    }	
}