<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * twitter widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

require_once( 'twitter/twitteroauth.php' );	

//Author: Storm Consultancy (Liam Gladdy)
//Author URI: http://www.stormconsultancy.co.uk
class StormTwitter {

  private $defaults = array(
    'directory' => '',
    'key' => '',
    'secret' => '',
    'token' => '',
    'token_secret' => '',
    'screenname' => '',
    'cache_expire' => 3600      
  );
  
  public $st_last_error = false;
  
  function __construct($args = array()) {
    $this->defaults = array_merge($this->defaults, $args);
  }
  
  function __toString() {
    return print_r($this->defaults, true);
  }
  
  //I'd prefer to put username before count, but for backwards compatibility it's not really viable. :(
  function getTweets($count = 20,$screenname = false,$options = false) {  
    if ($count > 20) $count = 20;
    if ($count < 1) $count = 1;
    
    $default_options = array('trim_user'=>true, 'exclude_replies'=>true, 'include_rts'=>false);
    
    if ($options === false || !is_array($options)) {
      $options = $default_options;
    } else {
      $options = array_merge($default_options, $options);
    }
    
    if ($screenname === false) $screenname = $this->defaults['screenname'];
  
    $result = $this->checkValidCache($screenname,$options);
    
    if ($result !== false) {
      return $this->cropTweets($result,$count);
    }
    
    //If we're here, we need to load.
    $result = $this->oauthGetTweets($screenname,$options);
    
    if (isset($result['errors'])) {
      if (is_array($result) && isset($result['errors'][0]) && isset($result['errors'][0]['message'])) {
        $last_error = $result['errors'][0]['message'];
      } else {
        $last_error = $result['errors'];
      }
      return array('error'=>'Twitter said: '.$last_error);
    } else {
      return $this->cropTweets($result,$count);
    }
    
  }
  
  private function cropTweets($result,$count) {
    return array_slice($result, 0, $count);
  }
  
  private function getCacheLocation() {
    return $this->defaults['directory'].'.tweetcache';
  }
  
  private function getOptionsHash($options) {
    $hash = md5(serialize($options));
    return $hash;
  }
  
  private function checkValidCache($screenname,$options) {
    $file = $this->getCacheLocation();
    if (is_file($file)) {
      $cache = file_get_contents($file);
      $cache = @json_decode($cache,true);
      
      if (!isset($cache)) {
        unlink($file);
        return false;
      }
      
      // Delete the old cache from the first version, before we added support for multiple usernames
      if (isset($cache['time'])) {
        unlink($file);
        return false;
      }
      
      $cachename = $screenname."-".$this->getOptionsHash($options);
      
      //Check if we have a cache for the user.
      if (!isset($cache[$cachename])) return false;
      
      if (!isset($cache[$cachename]['time']) || !isset($cache[$cachename]['tweets'])) {
        unset($cache[$cachename]);
        file_put_contents($file,json_encode($cache));
        return false;
      }
      
      if ($cache[$cachename]['time'] < (time() - $this->defaults['cache_expire'])) {
        $result = $this->oauthGetTweets($screenname,$options);
        if (!isset($result['errors'])) {
          return $result;
        }
      }
      return $cache[$cachename]['tweets'];
    } else {
      return false;
    }
  }
  
  private function oauthGetTweets($screenname,$options) {
    $key = $this->defaults['key'];
    $secret = $this->defaults['secret'];
    $token = $this->defaults['token'];
    $token_secret = $this->defaults['token_secret'];
    $result = '';

    $cachename = $screenname."-".$this->getOptionsHash($options);
    
    $options = array_merge($options, array('screen_name' => $screenname, 'count' => 20));
    
    if (empty($key)) return array('error'=>'Missing Consumer Key - Check Settings');
    if (empty($secret)) return array('error'=>'Missing Consumer Secret - Check Settings');
    if (empty($token)) return array('error'=>'Missing Access Token - Check Settings');
    if (empty($token_secret)) return array('error'=>'Missing Access Token Secret - Check Settings');
    if (empty($screenname)) return array('error'=>'Missing Twitter Feed Screen Name - Check Settings');
    
    $connection = new SPTwitterOAuth($key, $secret, $token, $token_secret);
    $result = $connection->get('statuses/user_timeline', $options);
    
    if ( ! isset( $result ) || ! is_array( $result ) )
    	return;
    
    if (is_file($this->getCacheLocation())) {
      $cache = json_decode(file_get_contents($this->getCacheLocation()),true);
    }
    
    if (!isset($result['errors'])) {
      $cache[$cachename]['time'] = time();
      $cache[$cachename]['tweets'] = $result;
      $file = $this->getCacheLocation();
      file_put_contents($file,json_encode($cache));
    } else {
      if (is_array($result) && isset($result['errors'][0]) && isset($result['errors'][0]['message'])) {
        $last_error = '['.date('r').'] Twitter error: '.$result['errors'][0]['message'];
        $this->st_last_error = $last_error;
      } else {
        $last_error = '['.date('r').'] Twitter returned an invalid response. It is probably down.';
        $this->st_last_error = $last_error;
      }
    }
    
    return $result;
  
  }
}

/**
 * Function to get the twitter stream data
 *
 * @access private
 * @since 3.0
 * @param string $screen_name | the screen name for twitter
 * @param string $count | how many tweets to return
 * @return string
 */
function _sp_get_twitter_stream( $widget_id, $screen_name, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $count = 5 ) {
	
	// bail if screen name is not set
	if ( ! isset( $screen_name ) || empty( $screen_name ) )
		return;

	// if cached version not found or expired get from twitter
	if ( false === ( $res = get_transient( $widget_id ) ) ) {
		if ( ! isset( $count ) || empty( $count ) )
			$count = 3;

		$options = array(
			'screen_name'		=> $screen_name,
			'count'				=> $count,
			'exclude_replies '	=> true,
			'include_rts'		=> false,
			'include_entities'	=> true
		);

		$config = array();

		$config['key'] = $consumer_key;
		$config['secret'] = $consumer_secret;
		$config['token'] = $access_token;
		$config['token_secret'] = $access_token_secret;
		$config['screenname'] = $screen_name;

		$obj = new StormTwitter( $config );
		$res = $obj->getTweets( (int)$count, $screen_name, $options );		

		// cache the response
		set_transient( $widget_id, $res, 60*60*1 ); // refreshes every hour
	}

	return $res;
}

class SP_Twitter_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function SP_Twitter_Widget() {
		// Instantiate the parent object
		parent::__construct( false, 'SP Twitter Widget' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sp-twitter-widget', 'description' => __( 'A widget to display your Twitter Tweets.', 'sp-theme' ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'sp-twitter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sp-twitter-widget', 'SP Twitter Widget', $widget_ops, $control_ops );	
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
			echo $before_title . apply_filters( 'sp_twitter_widget_title_icon', ' <i class="icon-twitter"></i> ' ) . $title . $after_title;	
		
		$output = '';

		// get the steram
		$tweets = _sp_get_twitter_stream( $args['widget_id'], $instance['screen_name'], $instance['consumer_key'], $instance['consumer_secret'], $instance['access_token'], $instance['access_token_secret'], $instance['count'] );

		// check ssl
		if ( is_ssl() )
			$http_protocol = 'https';
		else
			$http_protocol = 'http';

		// check if there are any tweet objects
		if ( is_array( $tweets ) ) {
			foreach( $tweets as $tweet ) {
				echo '<div class="tweet">' . PHP_EOL;

				if ( $tweet['text'] ) {
					$the_tweet = $tweet['text'];

					/*
					Twitter Developer Display Requirements
					https://dev.twitter.com/terms/display-requirements

					2.b. Tweet Entities within the Tweet text must be properly linked to their appropriate home on Twitter. For example:
					i. User_mentions must link to the mentioned user's profile.
					ii. Hashtags must link to a twitter.com search with the hashtag as the query.
					iii. Links in Tweet text must be displayed using the display_url
					field in the URL entities API response, and link to the original t.co url field.
					*/

					// i. User_mentions must link to the mentioned user's profile.
					if ( is_array( $tweet['entities']['user_mentions'] ) ) {
						foreach( $tweet['entities']['user_mentions'] as $key => $user_mention ) {
							$the_tweet = preg_replace( '/@' . $user_mention['screen_name'] . '/i', '<a href="' . $http_protocol . '://www.twitter.com/' . $user_mention['screen_name'] . '" target="_blank">@' . $user_mention['screen_name'].'</a>', $the_tweet );
						}
					}

					// ii. Hashtags must link to a twitter.com search with the hashtag as the query.
					if ( is_array( $tweet['entities']['hashtags'] ) ) {
						foreach( $tweet['entities']['hashtags'] as $key => $hashtag ) {
							$the_tweet = preg_replace( '/#' . $hashtag['text'] . '/i', '<a href="' . $http_protocol . '://twitter.com/search?q=%23' . $hashtag['text'] . '&src=hash" target="_blank">#' . $hashtag['text'] . '</a>', $the_tweet );
						}
					}

					// iii. Links in Tweet text must be displayed using the display_url
					// field in the URL entities API response, and link to the original t.co url field.
					if ( is_array( $tweet['entities']['urls'] ) ) {
						foreach( $tweet['entities']['urls'] as $key => $link ) {
							$the_tweet = preg_replace( '`' . $link['url'] . '`', '<a href="' . $link['url'] . '" target="_blank">' . $link['url'] . '</a>', $the_tweet );
						}
					}

					echo '<i class="icon-twitter"></i> ' . $the_tweet;


					// 3. Tweet Actions
					// Reply, Retweet, and Favorite action icons must always be visible for the user to interact with the Tweet. These actions must be implemented using Web Intents or with the authenticated Twitter API.
					// No other social or 3rd party actions similar to Follow, Reply, Retweet and Favorite may be attached to a Tweet.
					// get the sprite or images from twitter's developers resource and update your stylesheet
					echo '
						<div class="twitter-intents">
						<a class="reply" href="' . $http_protocol . '://twitter.com/intent/tweet?in_reply_to=' . $tweet['id_str'] . '"><i class="icon-reply"></i> ' . __( 'Reply', 'sp-theme' ) . '</a>
						<a class="retweet" href="' . $http_protocol . '://twitter.com/intent/retweet?tweet_id=' . $tweet['id_str'] . '"><i class="icon-retweet"></i> ' . __( 'Retweet', 'sp-theme' ) . '</a>
						<a class="favorite" href="' . $http_protocol . '://twitter.com/intent/favorite?tweet_id=' . $tweet['id_str'] . '"><i class="icon-star"></i> ' . __( 'Favorite', 'sp-theme' ) . '</a>
						</div>';


					// 4. Tweet Timestamp
					//    The Tweet timestamp must always be visible and include the time and date. e.g., “3:00 PM - 31 May 12”.
					// 5. Tweet Permalink
					//    The Tweet timestamp must always be linked to the Tweet permalink.
					echo '
						<p class="timestamp">
						<a href="' . $http_protocol . '://twitter.com/' . $instance['screen_name'] . '/status/' . $tweet['id_str'] . '" target="_blank"><i class="icon-clock"></i> ' . date( 'h:i A M d', strtotime( $tweet['created_at'] . '- 8 hours' ) ) . '</a>
						</p>';// -8 GMT for Pacific Standard Time
				} else {
					echo '
						<p>
						<a href="' . $http_protocol . '://twitter.com/' . $instance['screen_name'] . '" target="_blank">Click here to read ' . $instance['screen_name'] . '\'S Twitter feed</a></p>';
				}

				echo '</div><!--close .tweet-->' . PHP_EOL;
				
			} // foreach
		} // if		

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
		$instance['screen_name'] = sanitize_text_field( $new_instance['screen_name'] );
		$instance['consumer_key'] = sanitize_text_field( $new_instance['consumer_key'] );
		$instance['consumer_secret'] = sanitize_text_field( $new_instance['consumer_secret'] );
		$instance['access_token'] = sanitize_text_field( $new_instance['access_token'] );
		$instance['access_token_secret'] = sanitize_text_field( $new_instance['access_token_secret'] );
		$instance['count'] = sanitize_text_field( $new_instance['count'] );

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
		$defaults = array( 'title' => '', 'screen_name' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '', 'count' => '' );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); 

		?>
		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>"><?php _e( 'Twitter Screen Name:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'screen_name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['screen_name'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php _e( 'Consumer Key:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['consumer_key'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php _e( 'Consumer Secret:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['consumer_secret'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php _e( 'Access Token:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['access_token'] ); ?>" />
		</p>

		<p>
			<label for"<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php _e( 'Access Token Secret:', 'sp-theme' ); ?></label><br />
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['access_token_secret'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Show How Many Tweets:', 'sp-theme' ); ?> (<?php _e( 'optional', 'sp-theme' ); ?>)</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['count'] ); ?>" />        	
		</p>

		<p class="howto">
			<?php _e( 'Twitter requires all interactions with their API to be authenticated.  Thus to use this widget, you must create a custom app in your Twitter account which will generate the consumer keys and tokens for you to be plugged in up above.  You can go here to create your app http://dev.twitter.com/apps', 'sp-theme ' ); ?>
		</p>			        					
		<?php
	}	
}