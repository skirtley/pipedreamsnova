<?php
/**
 * Name: SW Our Team Slider
 * Description: A widget that serves as an slider for developing more advanced widgets.
 */

/*
** Add Instagram API
*/
 
class sw_instagram_widget extends WP_Widget {
	private $snumber = 1;
	function __construct(){
		/* Register Taxonomy */
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw-instagram', 'description' => __('Sw Instagram Gallery', 'flytheme') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_instagram' );

		/* Create the widget. */
		parent::__construct( 'sw_instagram', __( 'Sw Instagram Gallery Widget', 'flytheme' ), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'instagram', array( $this, 'INST_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'INST_integrateWithVC' ) );
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'resp_slider_script' ) );
	}
	
	/*
	** Enqueue Script
	*/
	function resp_slider_script(){	
		wp_register_script( 'slick_slider', SWURL . '/js/slick.min.js' ,array(), null, false );		
		if (!wp_script_is('slick_slider')) {
			wp_enqueue_script('slick_slider');
		}                
	}
	
	/*
	** Generate ID
	*/
	public function generateID() {
		return $this->id_base . '_' . (int) $this->snumber++;
	}
	
	/**
		* Get content gallery
	**/
	function http($url, $method, $postfields = NULL) {
    $this->http_info = array();
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_URL, $url);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ci, CURLOPT_TIMEOUT, 90);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ci, CURLOPT_HEADER, false);
		
    switch ($method) {
      case 'POST':
        curl_setopt($ci, CURLOPT_POST, TRUE);
        if (!empty($postfields)) {
          curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        break;
      case 'DELETE':
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if (!empty($postfields)) {
          $url = "{$url}?{$postfields}";
        }
    }

    $response = curl_exec($ci);		
		if( !$response ){
			throw new Exception( __('Error: The access_token provided is invalid.', 'flytheme') );
		}
		curl_close($ci);
		$response = json_decode($response);
		return $response;
  }
	public function Get_Instagram_Gallery( $userid, $access_token, $number ){
		$url = 'https://api.instagram.com/v1/users/'. $userid .'/media/recent?access_token='. $access_token .'&count='. $number;
		$data = $this->http( $url, 'GET' );
		return $data;
	}
	
	/**
		* Add Vc Params
	**/
	function INST_integrateWithVC(){
		vc_map( array(
		  "name" => __( "Sw Instagram Gallery", "flytheme" ),
		  "base" => "instagram",
		  "icon" => "icon-wpb-ytc",
		  "class" => "",
		  "category" => __( "SW Core", "flytheme"),
		  "params" => array(
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Title", "flytheme" ),
				"param_name" => "title",
				"value" => '',
				"description" => __( "Title", "flytheme" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Of Post", "flytheme" ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Post", "flytheme" )
			 ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Instagram User ID", "flytheme" ),
				"param_name" => "userid",
				"value" => 0,
				"description" => __( "Instagram User ID", "flytheme" )
			 ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Access Token", "flytheme" ),
				"param_name" => "access_token",
				"value" => 5,
				"description" => __( "Access Token", "flytheme" )
			 ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", 'flytheme' ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", 'flytheme' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", 'flytheme' ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", 'flytheme' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", 'flytheme' ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", 'flytheme' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", 'flytheme' ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", 'flytheme' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", 'flytheme' ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", 'flytheme' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Speed", 'flytheme' ),
				"param_name" => "speed",
				"value" => 1000,
				"description" => __( "Speed Of Slide", 'flytheme' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Auto Play", 'flytheme' ),
				"param_name" => "autoplay",
				"value" => array( 'True' => 'true', 'False' => 'false' ),
				"description" => __( "Auto Play", 'flytheme' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Interval", 'flytheme' ),
				"param_name" => "interval",
				"value" => 5000,
				"description" => __( "Interval", 'flytheme' )
			 ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Layout", 'flytheme' ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => '1', 'Layout 1' => '2' ),
				"description" => __( "Layout", 'flytheme' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Total Items Slided", 'flytheme' ),
				"param_name" => "scroll",
				"value" => 1,
				"description" => __( "Total Items Slided", 'flytheme' )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function INST_Shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title' => '',				
				'numberposts' => 5,				
				'userid' => 0,
				'access_token' => '',
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'speed' => 1000,
				'autoplay' => 'true',
				'interval' => 5000,
				'layout'  => 1,
				'scroll' => 1,
				'layout'  => 1,
			), $atts )
		);
		ob_start();
		if( $layout == 1 ){
			include( 'includes/default.php' );	
		}else{
			include( 'includes/theme1.php' );	
		}		
		
		$content = ob_get_clean();
		
		return $content;
	}
	
	public function ya_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	/**
	 * Display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if( $instance['widget_template'] == 'default' ){
			include( 'includes/default.php' );
		}
				
		/* After widget (defined by themes). */
		echo $after_widget;
	}    
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}
		if ( array_key_exists('userid', $new_instance) ){
			$instance['userid'] = intval( $new_instance['userid'] );
		}
		if ( array_key_exists('access_token', $new_instance) ){
			$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		}
		if ( array_key_exists('columns', $new_instance) ){
			$instance['columns'] = intval( $new_instance['columns'] );
		}
    $instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
        
					
        
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
		$instance 				 = wp_parse_args( (array) $instance, $defaults ); 		
		$title   					 = isset( $instance['title'] )     			 ? strip_tags($instance['title']) : '';     		
		$number     			 = isset( $instance['numberposts'] ) 		 ? intval($instance['numberposts']) : 5;
		$userid     			 = isset( $instance['userid'] ) 		 		 ? intval($instance['userid']) : 0;
		$access_token			 = isset( $instance['access_token'] ) 		 ? strip_tags($instance['access_token']) : '';
		$columns    			 = isset( $instance['columns'] )      	 ? intval($instance['columns']) : 3;		
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
				type="text"	value="<?php echo esc_attr($title); ?>" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('userid'); ?>"><?php _e('Instagram User ID', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('userid'); ?>" name="<?php echo $this->get_field_name('userid'); ?>"
				type="text"	value="<?php echo esc_attr($userid); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>"
				type="text"	value="<?php echo esc_attr($access_token); ?>" />
		</p>
		
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns'); ?>"
				name="<?php echo $this->get_field_name('columns'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'flytheme')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected"<?php } ?>>
					<?php _e('Default', 'flytheme')?>
				</option>			
			</select>
		</p>               
	<?php
	}	
}
?>