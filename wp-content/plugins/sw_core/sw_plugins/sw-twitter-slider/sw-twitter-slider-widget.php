<?php
/**
 * Name: SW Twitter Slider Widget

 * Description: A widget that serves as an slideshow for developing more advanced widgets.
 * Version: 1.0
 * Author: smartaddons.com
 * Author URI: http://smartaddons.com
 *
 */
 
 /* register style */

require_once( plugin_dir_path(__FILE__) . 'autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;


if (!function_exists('sw_convert_links')) {
	function sw_convert_links($status,$targetBlank=true,$linkMaxLen=40){
	 
		// the target
			$target=$targetBlank ? " target=\"_blank\" " : "";
		 
		// convert link to url
			$status = preg_replace_callback("/((http:\/\/|https:\/\/)[^ )]+)/", function ($matches) {
       return '<a href="'.$matches[0].'" title="'.$matches[0].'"  target="_blank" >'. ((strlen($matches[0])>=40 ? substr($matches[0],0,40).'...': $matches[0])).'</a>'; }, $status);
		 
			$status = preg_replace_callback("/(@([_a-z0-9\-]+))/i", function ($matches) {
            return '<a href="http://twitter.com/'.$matches[1].'" title="Follow '.$matches[1].'" target="_blank" >'.$matches[0].'</a>'; },$status);
		 
		// convert # to search
			$status = preg_replace_callback("/(#([_a-z0-9\-]+))/i",function ($matches) {
            return '<a href="https://twitter.com/search?q='.$matches[1].'" title="Search '.$matches[0].'" target="_blank" >'.$matches[0].'</a>';},$status);
		 
		// return the status
			return $status;
	}
}
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}
function Get_Connection( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $twitter_cache, $twitter_username, $twitter_number, $exclude_replies ){
	if(empty($consumer_key) || empty($consumer_secret) || empty($access_token) || empty($access_token_secret) || empty($twitter_cache) || empty($twitter_username)){
		echo '<strong>Please fill all widget settings!</strong>' ;
		return;
	}

	$twtransient = get_transient( 'sw_twitter' );
	$twvalue 		 = array();
	if( empty( $twtransient ) ){			  
		$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);
		$tweets = $connection->get('statuses/user_timeline', ["screen_name" => str_replace( '@', '', $twitter_username ), "count" => $twitter_number, "exclude_replies" => $exclude_replies]) or die('Couldn\'t retrieve tweets! Wrong username?');

		if(!empty($tweets->errors)){
			if($tweets->errors[0]->message == 'Invalid or expired token'){
				echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
			}else{
				echo '<strong>'.$tweets->errors[0]->message.'</strong>' ;
			}
			return;
		}
		$tweets_array = array();
		for($i = 0;$i <= count($tweets); $i++){
			if(!empty($tweets[$i])){
				$tweets_array[$i]['user_img'] 	= $tweets[$i]->user->profile_image_url;
				$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
				
					//clean tweet text
					$tweets_array[$i]['text'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $tweets[$i]->text);
				
				if(!empty($tweets[$i]->id_str)){
					$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;			
				}
			}
		} 	
		//save tweets to wp option 		
		set_transient( 'sw_twitter', serialize( $tweets_array ), 60 );		
		$twvalue = serialize( $tweets_array );
		echo '<!-- twitter cache has been updated! -->';
	}else{
		$twvalue = get_transient( 'sw_twitter' );
	}	
	return unserialize( $twvalue );
}

//convert dates to readable format	
if (!function_exists('sw_relative_time')) {
	function sw_relative_time($a) {
		//get current timestampt
		$b = strtotime("now"); 
		//get timestamp when tweet created
		$c = strtotime($a);
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;
			
		if(is_numeric($d) && $d > 0) {
			//if less then 3 seconds
			if($d < 3) return "right now";
			//if less then minute
			if($d < $minute) return floor($d) . esc_html__( " seconds ago", 'sw_core' );
			//if less then 2 minutes
			if($d < $minute * 2) return esc_html__( "about 1 minute ago", 'sw_core' ) ;
			//if less then hour
			if($d < $hour) return floor($d / $minute) . esc_html__( " minutes ago", 'sw_core' );
			//if less then 2 hours
			if($d < $hour * 2) return esc_html__( "about 1 hour ago", 'sw_core' );
			//if less then day
			if($d < $day) return floor($d / $hour) . esc_html__( " hours ago", 'sw_core' );
			//if more then day, but less then 2 days
			if($d > $day && $d < $day * 2) return esc_html__( "yesterday", 'sw_core' );
			//if less then year
			if($d < $day * 365) return floor($d / $day) . esc_html__( " days ago", 'sw_core' );
			//else return more than a year
			return esc_html__( "over a year ago", 'sw_core' );
		}
	}	
}
add_action( 'widgets_init', 'sw_twitter_slider' );

/**
 * Register our widget.
 * 'Slideshow_Widget' is the widget class used below.
 */
function sw_twitter_slider() {
	register_widget( 'sw_twitter_slider_widget' );
}

/**
 * ya slideshow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, display, and update.  Nice!
 */
class sw_twitter_slider_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_twitter_slider_content', 'description' => __('Sw Twitter Slider', 'sw_core') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_twitter_slider_content' );

		/* Create the widget. */
		parent::__construct( 'sw_twitter_slider_content', __('Sw Twitter Slider Widget', 'sw_core'), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'sw_twitter', array( $this, 'Sw_Twitter' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'Sw_TwitterVC' ) );
		}
	}
	
	public function ya_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	/**
	* Add Vc Params
	**/
	function Sw_TwitterVC(){
		vc_map( array(
		  "name" => __( "SW Twitter Slider", "sw_core" ),
		  "base" => "sw_twitter",
		  "icon" => "icon-wpb-ytc",
		  "class" => "",
		  "category" => __( "SW Core", "sw_core"),
		  "params" => array(
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Title", "sw_core" ),
				"param_name" => "title1",
				"value" => "",
				"description" => __( "Title", "sw_core" )
			 ),				 
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Consumer Key", "sw_core" ),
				"param_name" => "consumer_key",
				"value" => '',
				"description" => __( "Consumer Key", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Consumer Secret", "sw_core" ),
				"param_name" => "consumer_secret",
				"value" => '',
				"description" => __( "Consumer Secret", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Access Token", "sw_core" ),
				"param_name" => "access_token",
				"value" => '',
				"description" => __( "Access Token Secret", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Access Token Secret", "sw_core" ),
				"param_name" => "access_token_secret",
				"value" => '',
				"description" => __( "Access Token Secret", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Cache Tweets (hours)", "sw_core" ),
				"param_name" => "twitter_cache",
				"value" => '',
				"description" => __( "Cache Tweets", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Twitter Username", "sw_core" ),
				"param_name" => "twitter_username",
				"value" => '',
				"description" => __( "Twitter Username", "sw_core" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Tweets to display", "sw_core" ),
				"param_name" => "twitter_number",
				"value" => '',
				"description" => __( "Number Tweets to display", "sw_core" )
			 ),	
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number row per column", "sw_core" ),
				"param_name" => "twitter_row",
				"value" =>array(1,2,3),
				"description" => __( "Number row per column", "sw_core" )
			 ),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'heading' => __( 'Layout', 'sw_core' ),
				'param_name' => 'layout',
				"admin_label" => true,
				'value' => array(
					__( 'Layout Default','sw_core' ) => 'default',
					__( 'Layout Theme1','sw_core' ) => 'theme1',		
				),
				'description' => sprintf( __( 'Select Layout', 'sw_core' ) )
			),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Exclude Reply", "sw_core" ),
				"param_name" => "exclude_replies",
				"value" =>array( 'No' => 'false', 'Yes' => 'true' ),
				"description" => __( "Exclude Reply", "sw_core" )
			 ),
		  )
	   ) );
	}
	function Sw_Twitter( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',					
				'consumer_key' => '',
				'consumer_secret'=> '',
				'access_token' => '',
				'access_token_secret' => '',
				'twitter_cache' => 1,
				'twitter_username' => '',
				'twitter_number' =>'',
				'twitter_row' => 1,
				'layout' => 'default',
				'exclude_replies' => 'false'
			), $atts )
		);
		ob_start();
		if( $layout == 'default' ){
			include( 'themes/default.php' );
		}elseif( $layout == 'theme1' ){
			include( 'themes/theme1.php' );
		}	
		$content = ob_get_clean();
		
		return $content;
	}
	/**
	 * Display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$exclude_replies = $instance['exclude_reply'] ? 'true' : 'false';
		echo $before_widget;
		if ( !empty( $title ) ){ echo $before_title . $title . $after_title; }
		extract($instance);	
		include( plugin_dir_path( __FILE__ ).'/themes/default.php' );
		/* After widget (defined by themes). */
		echo $after_widget;
	}    
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title1'] = strip_tags( $new_instance['title1'] );
		if ( array_key_exists('consumer_key', $new_instance) ){
			$instance['consumer_key'] = strip_tags( $new_instance['consumer_key'] );
		}
		if ( array_key_exists('consumer_secret', $new_instance) ){
			$instance['consumer_secret'] = strip_tags( $new_instance['consumer_secret'] );
		}
		if ( array_key_exists('access_token', $new_instance) ){
			$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		}
		if ( array_key_exists('access_token_secret', $new_instance) ){
			$instance['access_token_secret'] = strip_tags( $new_instance['access_token_secret'] );
		}
		if ( array_key_exists('twitter_cache', $new_instance) ){
			$instance['twitter_cache'] = intval( $new_instance['twitter_cache'] );
		}
		if ( array_key_exists('twitter_username', $new_instance) ){
			$instance['twitter_username'] = strip_tags( $new_instance['twitter_username'] );
		}
		if ( array_key_exists('twitter_number', $new_instance) ){
			$instance['twitter_number'] = intval( $new_instance['twitter_number'] );
		}
		if ( array_key_exists('twitter_row', $new_instance) ){
			$instance['twitter_row'] = intval( $new_instance['twitter_row'] );
		}
		$instance['exclude_reply'] = $new_instance['exclude_reply'];					
		return $instance;
	}
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); 		
		         
		$title1 = isset( $instance['title1'] )    ? 	strip_tags($instance['title1']) : '';
		$consumer_key    	 = isset( $instance['consumer_key'] )      ? strip_tags($instance['consumer_key']) : '';
		$consumer_secret 	 = isset( $instance['consumer_secret'] )      ? strip_tags($instance['consumer_secret']) : '';
		$access_token     	 = isset( $instance['access_token'] )      ? strip_tags($instance['access_token']) : '';
		$access_token_secret = isset( $instance['access_token_secret'] )      ? strip_tags($instance['access_token_secret']) : '';
		$twitter_cache	     = isset( $instance['twitter_cache'] )      ? intval($instance['twitter_cache']) : 1;
		$twitter_username    = isset( $instance['twitter_username'] )      ? strip_tags($instance['twitter_username']) : '';
		$twitter_number      = isset( $instance['twitter_number'] )      ? intval($instance['twitter_number']) : 5;
		$twitter_row      	 = isset( $instance['twitter_row'] )      ? intval($instance['twitter_row']) : 1;
		$exclude_reply       = isset( $instance['twitter_row'] ) ? $instance['exclude_reply'] : false;                
                 
		?>		
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id('title1'); ?>"><?php esc_html_e('Title', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
				type="text"	value="<?php echo esc_attr($title1); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php esc_html_e('Consumer Key', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>"
				type="text"	value="<?php echo esc_attr($consumer_key); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php esc_html_e('Consumer Secret', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>"
				type="text"	value="<?php echo esc_attr($consumer_secret); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php esc_html_e('Access Token: ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" 
				value="<?php echo esc_attr($access_token); ?>" />
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('access_token_secret'); ?>"><?php esc_html_e('Access Token Secret: ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" type="text" 
				value="<?php echo esc_attr($access_token_secret); ?>" />
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_cache'); ?>"><?php esc_html_e('Cache Tweets in every: ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('twitter_cache'); ?>" name="<?php echo $this->get_field_name('twitter_cache'); ?>" type="text" 
				value="<?php echo esc_attr($twitter_cache); ?>" /> <span><?php esc_html_e('Hour(s)', 'sw_core'); ?></span>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php esc_html_e('Twitter Username: ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" type="text" 
				value="<?php echo esc_attr($twitter_username); ?>" />
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_number'); ?>"><?php esc_html_e('Number Tweets to display: ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('twitter_number'); ?>" name="<?php echo $this->get_field_name('twitter_number'); ?>" type="text" 
				value="<?php echo esc_attr($twitter_number); ?>" />
		</p> 
		
		<?php $number1 = array('1' => 1, '2' => 2, '3' => 3); ?>
		<p>
			<label for="<?php echo $this->get_field_id('twitter_row'); ?>"><?php esc_html_e('Number of row per on item slider: ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('twitter_row'); ?>"
				name="<?php echo $this->get_field_name('twitter_row'); ?>">
				<?php
				$option ='';
				foreach ($number1 as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $twitter_row){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p><label for="<?php echo $this->get_field_id('exclude_reply'); ?>"><?php esc_html_e('Exclude Reply: ', 'sw_core')?></label>
			 <input class="checkbox" type="checkbox" <?php checked($exclude_reply, 'on'); ?> id="<?php echo $this->get_field_id('exclude_reply'); ?>" name="<?php echo $this->get_field_name('exclude_reply'); ?>" /> 
		</p>
	<?php
	}	
}
?>