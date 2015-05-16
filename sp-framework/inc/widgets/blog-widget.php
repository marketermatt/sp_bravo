<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * blog widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

class SP_Blog_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function SP_Blog_Widget() {
		// Instantiate the parent object
		parent::__construct( false, 'SP Blog Widget' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sp-blog-widget', 'description' => __( 'A widget to display your blog posts, popular posts and recent comments in a tab style layout.', 'sp-theme' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'sp-blog-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sp-blog-widget', 'SP Blog Widget', $widget_ops, $control_ops );	

		add_action( 'comment_post', array( $this, 'clear_blog_widget_cache' ) );
		add_action( 'save_post', array( $this, 'clear_blog_widget_cache' ) );
		add_action( 'widgets.php', array( $this, 'clear_blog_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'clear_blog_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'clear_blog_widget_cache' ) );
	}	

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {	
		
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$show_tabs = $instance['show_tabs'];

		/* Before widget (defined by theme). */
		echo $before_widget;
		
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;	
		
		$output = '';

		// check if show tabs is on
		if ( isset( $show_tabs ) && $show_tabs === 'true' )
			$show_tabs = 'blog-widget-tabs';
		else
			$show_tabs = '';

		$output .= '<div class="blog-widget ' . esc_attr( $show_tabs ) . '">' . PHP_EOL;

		// convert string to array
		$excludes = explode( ',', $instance['excludes'] );

		$recent_posts = SP_Blog_Widget::get_recent_posts( $args['widget_id'] . '-recent-posts', $instance['recent_posts_count'], $excludes );
		$recent_comments = SP_Blog_Widget::get_recent_comments( $args['widget_id'] . '-recent-comments', $instance['recent_comments_count'] );
		$popular_posts = SP_Blog_Widget::get_popular_posts( $args['widget_id'] . '-popular-posts', $instance['popular_posts_count'], $excludes );

		$tabs = '';
		$content = '';

		// continue if posts not null
		if ( null !== $recent_posts ) {
			// check if show title is enabled
			if ( isset( $instance['show_tab_title'] ) && $instance['show_tab_title'] === 'true' ) {
				$tab_title = __( 'Recent Posts', 'sp-theme' );
				$tab_link_title = '';
			} else {
				$tab_title = '';
				$tab_link_title = __( 'Recent Posts', 'sp-theme' );
			}

			// build the tab menu
			$tabs .= '<li><a href="#recent-posts" title="' . esc_attr( $tab_link_title ) . '" class="tab-link sp-tooltip" data-placement="top" data-toggle="tooltip"><i class="icon-edit" aria-hidden="true"></i> ' . $tab_title . '</a></li>' . PHP_EOL;

			$content .= '<div id="recent-posts" class="content-wrap">' . PHP_EOL;

			$content .= '<ul>' . PHP_EOL;

			foreach( $recent_posts as $post ) {
				$date = apply_filters( 'sp_date_format', date( SP_DATE_FORMAT, strtotime( $post['post_date'] ) ), strtotime( $post['post_date'] ) );

				$post_image = sp_get_image( get_post_thumbnail_id( $post['ID'] ), 35, 35, true );

				$content .= '<li>' . PHP_EOL;
				$content .= '<a href="' . esc_url( get_permalink( $post['ID'] ) ) . '" title="' . esc_attr( $post['post_title'] ) . '">' . PHP_EOL;
				$content .= '<img src="' . esc_url( $post_image['url'] ) . '" width="' . esc_attr( $post_image['width'] ) . '" height="' . esc_attr( $post_image['height'] ) . '" alt="' . esc_attr( $post_image['alt'] ) . '" />' . PHP_EOL;
				$content .= '<h3 class="post-title">' . $post['post_title'] . '</h3>' . PHP_EOL;
				$content .= '</a>' . PHP_EOL;
				$content .= '<em>' . $date . '</em>' . PHP_EOL;
				$content .= '</li>' . PHP_EOL;
			}

			$content .= '</ul>' . PHP_EOL;

			$content .= '</div><!--close #recent-posts-->' . PHP_EOL;
		}

		// continue if comments not null
		if ( null !== $recent_comments ) {
			// check if show title is enabled
			if ( isset( $instance['show_tab_title'] ) && $instance['show_tab_title'] === 'true' ) {
				$tab_title = __( 'Recent Comments', 'sp-theme' );
				$tab_link_title = '';
			} else {
				$tab_title = '';
				$tab_link_title = __( 'Recent Comments', 'sp-theme' );
			}

			// build the tab menu
			$tabs .= '<li><a href="#recent-comments" title="' . esc_attr( $tab_link_title ) . '" class="tab-link sp-tooltip" data-placement="top" data-toggle="tooltip"><i class="icon-comments" aria-hidden="true"></i> ' . $tab_title . '</a></li>' . PHP_EOL;

			$content .= '<div id="recent-comments" class="content-wrap">' . PHP_EOL;

			$content .= '<ul>' . PHP_EOL;

			foreach( $recent_comments as $comment ) {
				$date = apply_filters( 'sp_date_format', date( SP_DATE_FORMAT, strtotime( $comment->comment_date ) ), strtotime( $comment->comment_date ) );

				$comment_content = substr( $comment->comment_content, 0, apply_filters( 'sp_blog_widget_comment_excerpt_length', 185 ) ) . '...';

				$content .= '<li class="comment-wrap clearfix">' . PHP_EOL;
				$content .= '<i class="icon-comment" aria-hidden="true"></i> <p class="comment"><a href="' . esc_url( get_permalink( $comment->comment_post_ID ) ) . '" title="' . __( 'Comment On:', 'sp-theme' ) . ' ' . esc_attr( $comment->post_title ) . '">' . $comment_content . '</a>' . PHP_EOL;
				$content .= '<em>' . __( 'by', 'sp-theme' ) . ' ' . $comment->comment_author . '</em><em>' . $date . '</em></p>' . PHP_EOL;
				$content .= '</li>' . PHP_EOL;
			}

			$content .= '</ul>' . PHP_EOL;

			$content .= '</div><!--close #recent-comments-->' . PHP_EOL;
		}

		// continue if popular posts not null
		if ( null !== $popular_posts ) {
			// check if show title is enabled
			if ( isset( $instance['show_tab_title'] ) && $instance['show_tab_title'] === 'true' ) {
				$tab_title = __( 'Popular Posts', 'sp-theme' );
				$tab_link_title = '';
			} else {
				$tab_title = '';
				$tab_link_title = __( 'Popular Posts', 'sp-theme' );
			}

			// build the tab menu
			$tabs .= '<li><a href="#popular-posts" title="' . esc_attr( $tab_link_title ) . '" class="tab-link sp-tooltip" data-placement="top" data-toggle="tooltip"><i class="icon-star" aria-hidden="true"></i> ' . $tab_title . '</a></li>' . PHP_EOL;

			$content .= '<div id="popular-posts" class="content-wrap">' . PHP_EOL;

			$content .= '<ul>' . PHP_EOL;

			foreach( $popular_posts as $post ) {
				$date = apply_filters( 'sp_date_format', date( SP_DATE_FORMAT, strtotime( $post->post_date ) ), strtotime( $post->post_date ) );

				$post_image = sp_get_image( get_post_thumbnail_id( $post->ID ), 35, 35, true );

				$content .= '<li>' . PHP_EOL;
				$content .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( $post->post_title ) . '">' . PHP_EOL;
				$content .= '<img src="' . esc_url( $post_image['url'] ) . '" width="' . esc_attr( $post_image['width'] ) . '" height="' . esc_attr( $post_image['height'] ) . '" alt="' . esc_attr( $post_image['alt'] ) . '" />' . PHP_EOL;
				$content .= '<h3 class="post-title">' . $post->post_title . '</h3>' . PHP_EOL;
				$content .= '</a>' . PHP_EOL;
				$content .= '<em>' . $date . '</em>' . PHP_EOL;
				$content .= '</li>' . PHP_EOL;
			}

			$content .= '</ul>' . PHP_EOL;

			$content .= '</div><!--close #recent-comments-->' . PHP_EOL;
		}

		// display if setting is on
		if ( $instance['show_tabs'] === 'true' ) {
			// build tabs
			$output .= '<ul class="clearfix">' . PHP_EOL;
			$output .= $tabs . PHP_EOL;
			$output .= '</ul>' . PHP_EOL;
		}
		
		// build tab content
		$output .= $content . PHP_EOL;

		// set active tab
		$output .= '<input type="hidden" class="active-tab" value="' . esc_attr( $instance['active_tab'] ) . '" name="active_tab" />' . PHP_EOL;

		$output .= '</div><!--close .blog-widget-tabs-->' . PHP_EOL;

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
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['recent_posts_count'] = sanitize_text_field( absint( $new_instance['recent_posts_count'] ) );
		$instance['recent_comments_count'] = sanitize_text_field( absint( $new_instance['recent_comments_count'] ) );
		$instance['popular_posts_count'] = sanitize_text_field( absint( $new_instance['popular_posts_count'] ) );
		$instance['active_tab'] = sanitize_text_field( absint( $new_instance['active_tab'] ) );
		$instance['show_tabs'] = sanitize_text_field( $new_instance['show_tabs'] );
		$instance['show_tab_title'] = sanitize_text_field( $new_instance['show_tab_title'] );
		$instance['excludes'] = sanitize_text_field( $new_instance['excludes'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'recent_posts_count' => '5', 'recent_comments_count' => '5', 'popular_posts_count' => '5', 'show_tabs' => 'true', 'active_tab' => '1', 'show_tab_title' => 'false', 'excludes' => '' );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); 

		?>
		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>     

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'recent_posts_count' ) ); ?>"><?php _e( 'Show How Many Recent Posts:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'recent_posts_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_posts_count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['recent_posts_count'] ); ?>" />
		</p>  
		<p class="howto"><?php _e( 'Enter how many recent posts you would like to display. If you want to hide this section and not display anything, enter a 0.', 'sp-theme' ); ?></p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'recent_comments_count' ) ); ?>"><?php _e( 'Show How Many Recent Comments:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'recent_comments_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_comments_count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['recent_comments_count'] ); ?>" />
		</p>
		<p class="howto"><?php _e( 'Enter how many recent comments you would like to display. If you want to hide this section and not display anything, enter a 0.', 'sp-theme' ); ?></p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'popular_posts_count' ) ); ?>"><?php _e( 'Show How Many Popular Posts:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'popular_posts_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_posts_count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['popular_posts_count'] ); ?>" />
		</p>	
		<p class="howto"><?php _e( 'Enter how many popular posts you would like to display. If you want to hide this section and not display anything, enter a 0.', 'sp-theme' ); ?></p>

        <p>
        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_tabs' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_tabs' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_tabs'] ); ?> />
        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_tabs' ) ); ?>"><?php _e( 'Show Tabs:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
        </p>
        <p class="howto"><?php _e( 'Check the box to display blog sections into a tabbed layout.', 'sp-theme' ); ?></p>

        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'active_tab' ) ); ?>"><?php _e( 'Active Tab:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'active_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'active_tab' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['active_tab'] ); ?>" />
        </p>
        <p class="howto"><?php _e( 'Select the tab you want to show as active when page loads. Enter a numberic value such as 1 for Recent Posts, 2 for Recent Comments and 3 for Popular Posts.', 'sp-theme' ); ?></p>

        <p>
        	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_tab_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_tab_title' ) ); ?>" type="checkbox" value="true" <?php checked( 'true', $instance['show_tab_title'] ); ?> />
        	<label for="<?php echo esc_attr( $this->get_field_id( 'show_tab_title' ) ); ?>"><?php _e( 'Show Tab Title:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
        </p>
        <p class="howto"><?php _e( 'Check the box to show the text title in the tabs.', 'sp-theme' ); ?></p>	

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'excludes' ) ); ?>"><?php _e( 'Exclude Posts:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excludes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excludes' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['excludes'] ); ?>" />
		</p>	
		<p class="howto"><?php _e( 'Type each ID of the post you want to exclude from showing separated by a comma.  For example 234,448.', 'sp-theme' ); ?></p>				        
		<?php
    }	

	/**
	 * Function to get the recent posts
	 *
	 * @access public
	 * @since 3.0
	 * @param int $count | the count of posts to get
	 * @param string $excludes | the ids of the posts to exclude
	 * @return array $posts | the lists of recent posts
	 */
	public function get_recent_posts( $widget_id, $count = 5, $excludes = array() ) {
		// if count is zero, bail
		if ( absint( $count ) === 0 )
			return;

		// try to get data from cache first
		$cache = get_transient( 'sp-blog-widget' );

		if ( false === $cache )
        	$cache = array();

        // if cache not found get the data from database
		if ( isset( $cache[$widget_id] ) )
			return $cache[$widget_id];

		// if cache not found
		$args = array(
			'posts_per_page'	=> absint( $count ),
			'post_status'		=> 'publish',
			'exclude'			=> $excludes,
			'post_type'			=> 'post'
		);

		$posts = wp_get_recent_posts( apply_filters( 'sp_blog_widget_recent_posts_query_args', $args, $args ) ); // array

		$cache[$widget_id] = $posts;

		// set the cache
		set_transient( 'sp-blog-widget', $cache );

		return $posts;
	}

	/**
	 * Function to get the recent comments
	 *
	 * @access public
	 * @since 3.0
	 * @param int $count | the count of comments to get
	 * @return array $comments | the lists of recent comments
	 */
	public function get_recent_comments( $widget_id, $count = 5 ) {
		// if count is zero, bail
		if ( absint( $count ) === 0 )
			return;

		// try to get data from cache first
		$cache = get_transient( 'sp-blog-widget' );

		if ( false === $cache )
        	$cache = array();

        // if cache not found get the data from database
		if ( isset( $cache[$widget_id] ) )
			return $cache[$widget_id];

		// if cache not found
		$args = array(
			'number'	=> absint( $count ),
			'status'	=> 'approve'
		);

		$comments = get_comments( apply_filters( 'sp_blog_widget_recent_comments_args', $args, $args ) ); // array

		$cache[$widget_id] = $comments;

		// set the cache
		set_transient( 'sp-blog-widget', $cache );

		return $comments;
	}

	/**
	 * Function to get the popular posts
	 *
	 * @access public
	 * @since 3.0
	 * @param int $count | the count of posts to get
	 * @return array $posts | the lists of popular posts
	 */
	public function get_popular_posts( $widget_id, $count = 5, $excludes = array() ) {
		// if count is zero, bail
		if ( absint( $count ) === 0 )
			return;

		// try to get data from cache first
		$cache = get_transient( 'sp-blog-widget' );

		if ( false === $cache )
        	$cache = array();

        // if cache not found get the data from database
		if ( isset( $cache[$widget_id] ) )
			return $cache[$widget_id];

		// if cache not found
		$args = array(
			'posts_per_page'	=> absint( $count ),
			'status'			=> 'publish',
			'post_type'			=> 'post',
			'exclude'			=> $excludes,
			'orderby'			=> 'comment_count'
		);

		$posts = get_posts( apply_filters( 'sp_blog_widget_popular_posts_args', $args, $args ) ); // array
		
		$cache[$widget_id] = $posts;

		// set the cache
		set_transient( 'sp-blog-widget', $cache );

		return $posts;
	}

	/**
	 * Function that clears particular transients when posts are saved
	 *
	 * @access public
	 * @since 3.0
	 * @return boolean true
	 */
	public function clear_blog_widget_cache() {
		delete_transient( 'sp-blog-widget' );

		return true;
	}  
}