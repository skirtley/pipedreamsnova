<?php
/**
 * Name: SW Our Team Slider
 * Description: A widget that serves as an slider for developing more advanced widgets.
 */

class sw_ourteam_slider_widget extends WP_Widget {
	function __construct(){
		/* Register Taxonomy */
		add_action( 'init', array( $this, 'sw_team_register' ), 5 );
		add_action( 'admin_init', array( $this, 'team_init') );
		add_action( 'save_post', array( $this, 'team_save_meta' ), 10, 1 );
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_team_slider', 'description' => __('Sw Ourteam Slider', 'sw_core') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_team_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_team_slider', __( 'Sw Ourteam Slider widget', 'sw_core' ), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'ourteam', array( $this, 'OT_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'OT_integrateWithVC' ) );
		}
	}
	
	/* Register Post Type */
	function sw_team_register() {
		$labels = array(
			'name' => __('Our Team', 'sw_core' ),
			'singular_name' => __('Teams Item', 'sw_core'),
			'add_new' => __('Add New', 'sw_core'),
			'add_new_item' => __('Add New Team Item', 'sw_core'),
			'edit_item' => __('Edit Item', 'sw_core'),
			'new_item' => __('New Item', 'sw_core'),
			'view_item' => __('View Team Item', 'sw_core'),
			'search_items' => __('Search Team', 'sw_core'),
			'not_found' =>  __('Nothing found', 'sw_core'),
			'not_found_in_trash' => __('Nothing found in Trash', 'sw_core'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-id',
			'rewrite' =>  true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 4,
			'supports' => array('title','thumbnail','author', 'editor')
		  ); 

		register_post_type( 'team' , $args );
	}
	
	public function team_init(){
		add_meta_box( __( 'Our Team Detail', 'sw_core' ), __( 'Our Team Detail', 'sw_core' ), array( $this, 'team_detail' ), 'team', 'normal', 'low' );
	}
	
	public function team_detail(){
		global $post;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'team_save_meta', 'sw_team_plugin_nonce' );
		
		$facebook = get_post_meta( $post->ID, 'facebook', true );	
		$twitter = get_post_meta( $post->ID, 'twitter', true );
		$gplus = get_post_meta( $post->ID, 'gplus', true );
		$linkedin = get_post_meta( $post->ID, 'linkedin', true );
		$team_info = get_post_meta( $post->ID, 'team_info', true );
	?>	
		<div>
		<h3><?php _e( 'Social', 'sw_core' ); ?></h3>
			<p><label><b><?php _e('Facebook', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "facebook" value ="<?php echo esc_attr( $facebook );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Twitter', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "twitter" value ="<?php echo esc_attr( $twitter );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Google Plus', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "gplus" value ="<?php echo esc_attr( $gplus );?>" size="80%" />
			</p>
			<p><label><b><?php _e('Linkedin', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "linkedin" value ="<?php echo esc_attr( $linkedin );?>" size="80%" />
			</p>
		</div>
		<div>
			<p><label><b><?php _e('Member Infomation', 'sw_core'); ?>:</b></label><br/>
				<input type ="text" name = "team_info" value ="<?php echo esc_attr( $team_info );?>" size="80%" />
			</p>
		</div>
	<?php 
	}
	
	function team_save_meta( $post ){
		global $post;
		if ( ! isset( $_POST['sw_team_plugin_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['sw_team_plugin_nonce'], 'team_save_meta' ) ) {
			return;
		}
		$list_meta = array( 'facebook', 'twitter', 'gplus', 'linkedin', 'team_info' );
		foreach( $list_meta as $meta ){
			if( isset( $_POST[$meta] ) ){
				$my_data = sanitize_text_field( $_POST[$meta] );
				update_post_meta( $post->ID, $meta, $my_data );
			}
		}
	}
	/**
		* Add Vc Params
	**/
	function OT_integrateWithVC(){
		vc_map( array(
		  "name" => __( "Sw Our Team", 'sw_core' ),
		  "base" => "ourteam",
		  "icon" => "icon-wpb-ytc",
		  "class" => "",
		  "category" => __( "SW Core", 'sw_core'),
		  "params" => array(
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Title", 'sw_core' ),
				"param_name" => "title",
				"admin_label" => true,
				"value" => '',
				"description" => __( "Title", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order By", 'sw_core' ),
				"param_name" => "orderby",
				"admin_label" => true,
				"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
				"description" => __( "Order By", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order", 'sw_core' ),
				"param_name" => "order",
				"admin_label" => true,
				"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
				"description" => __( "Order", 'sw_core' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Of Post", 'sw_core' ),
				"param_name" => "numberposts",
				"admin_label" => true,
				"value" => 5,
				"description" => __( "Number Of Post", 'sw_core' )
			 ),
			 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", 'sw_core' ),
					"param_name" => "item_row",
				"admin_label" => true,
					"value" =>array(1,2,3),
					"description" => __( "Number row per column", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", 'sw_core' ),
				"param_name" => "columns",
				"admin_label" => true,
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_core' ),
				"param_name" => "columns1",
				"admin_label" => true,
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", 'sw_core' ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", 'sw_core' ),
				"param_name" => "columns3",
				"admin_label" => true,
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", 'sw_core' ),
				"param_name" => "columns4",
				"admin_label" => true,
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", 'sw_core' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Speed", 'sw_core' ),
				"param_name" => "speed",
				"admin_label" => true,
				"value" => 1000,
				"description" => __( "Speed Of Slide", 'sw_core' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Auto Play", 'sw_core' ),
				"param_name" => "autoplay",
				"admin_label" => true,
				"value" => array( 'True' => 'true', 'False' => 'false' ),
				"description" => __( "Auto Play", 'sw_core' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Interval", 'sw_core' ),
				"param_name" => "interval",
				"admin_label" => true,
				"value" => 5000,
				"description" => __( "Interval", 'sw_core' )
			 ),			 
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Total Items Slided", 'sw_core' ),
				"param_name" => "scroll",
				"admin_label" => true,
				"value" => 1,
				"description" => __( "Total Items Slided", 'sw_core' )
			 ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Layout", 'sw_core' ),
				"param_name" => "layout",
				"admin_label" => true,
				"value" => array( 'Layout Default' => 'default', 'Layout 1' => 'layout1' ),
				"description" => __( "Layout", 'sw_core' )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function OT_Shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title' => '',
				'orderby' => '',
				'order'	=> '',
				'numberposts' => 5,
				'item_row'=> 1,
				'length' => 25,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'speed' => 1000,
				'autoplay' => 'false',
				'interval' => 5000,
				'layout'  => 'default',
				'scroll' => 1
			), $atts )
		);
		ob_start();		
		if( $layout == 'default' ){
			include( 'includes/default.php' );
		}else{
			include( 'includes/team-style1.php' );
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
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if( $instance['widget_template'] == 'default' ){
			include( 'includes/default.php' );
		}else{
			include( 'includes/team-style1.php' );
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
		
		if ( array_key_exists('orderby', $new_instance) ){
			$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		}
		if ( array_key_exists('order', $new_instance) ){
			$instance['order'] = strip_tags( $new_instance['order'] );
		}
		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}
		if ( array_key_exists('item_row', $new_instance) ){
			$instance['item_row'] = intval( $new_instance['item_row'] );
		}
		if ( array_key_exists('length', $new_instance) ){
			$instance['length'] = intval( $new_instance['length'] );
		}		
		if ( array_key_exists('columns', $new_instance) ){
			$instance['columns'] = intval( $new_instance['columns'] );
		}
		if ( array_key_exists('columns1', $new_instance) ){
			$instance['columns1'] = intval( $new_instance['columns1'] );
		}
		if ( array_key_exists('columns2', $new_instance) ){
			$instance['columns2'] = intval( $new_instance['columns2'] );
		}
		if ( array_key_exists('columns3', $new_instance) ){
			$instance['columns3'] = intval( $new_instance['columns3'] );
		}
		if ( array_key_exists('columns4', $new_instance) ){
			$instance['columns4'] = intval( $new_instance['columns4'] );
		}		
		if ( array_key_exists('interval', $new_instance) ){
			$instance['interval'] = intval( $new_instance['interval'] );
		}
		if ( array_key_exists('speed', $new_instance) ){
			$instance['speed'] = intval( $new_instance['speed'] );
		}		
		if ( array_key_exists('scroll', $new_instance) ){
			$instance['scroll'] = intval( $new_instance['scroll'] );
		}
		if ( array_key_exists('effect', $new_instance) ){
			$instance['effect'] = strip_tags( $new_instance['effect'] );
		}
		if ( array_key_exists('autoplay', $new_instance) ){
			$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
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
		$instance = wp_parse_args( (array) $instance, $defaults ); 		
		$title    = isset( $instance['title'] )     ? strip_tags($instance['title']) : '';      
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
		$item_row   = isset( $instance['item_row'] )      	? intval($instance['item_row']) : 1;
        $length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
		$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
		$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
		$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
		$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
		$columns4     = isset( $instance['columns'] )      ? intval($instance['columns4']) : '';
		$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
		$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
		$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
		$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
		$effect     = isset( $instance['effect'] )      ? strip_tags($instance['effect']) : 'slide';
		$hover     = isset( $instance['hover'] )      ? strip_tags($instance['hover']) : '';
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
				type="text"	value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'sw_core')?></label>
			<br />
			<?php $allowed_keys = array('name' => 'Name', 'author' => 'Author', 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'parent' => 'Parent', 'ID' => 'ID', 'rand' =>'Rand', 'comment_count' => 'Comment Count'); ?>
			<select class="widefat"
				id="<?php echo $this->get_field_id('orderby'); ?>"
				name="<?php echo $this->get_field_name('orderby'); ?>">
				<?php
				$option ='';
				foreach ($allowed_keys as $value => $key) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $orderby){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
				<?php } ?>>
					<?php _e('Descending', 'sw_core')?>
				</option>
				<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
					<?php _e('Ascending', 'sw_core')?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>
		
		<?php $row_number = array( '1' => 1, '2' => 2, '3' => 3 ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column:  ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('item_row'); ?>"
				name="<?php echo $this->get_field_name('item_row'); ?>">
				<?php
				$option ='';
				foreach ($row_number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $item_row){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' =>  7, '8' => 8); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_core')?></label>
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
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns1'); ?>"
				name="<?php echo $this->get_field_name('columns1'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns1){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns2'); ?>"
				name="<?php echo $this->get_field_name('columns2'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns2){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns3'); ?>"
				name="<?php echo $this->get_field_name('columns3'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns3){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns4'); ?>"
				name="<?php echo $this->get_field_name('columns4'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns4){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
				<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
				<?php } ?>>
					<?php _e('False', 'sw_core')?>
				</option>
				<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
					<?php _e('True', 'sw_core')?>
				</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
				type="text"	value="<?php echo esc_attr($interval); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
				type="text"	value="<?php echo esc_attr($speed); ?>" />
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
				type="text"	value="<?php echo esc_attr($scroll); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_core')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
				<?php } ?>>
					<?php _e('Default', 'sw_core')?>
				</option>
				<option value="theme1" <?php if ($widget_template=='theme1'){?> selected="selected"
				<?php } ?>>
					<?php _e('Theme 1', 'sw_core')?>
				</option>				
			</select>
		</p>               
	<?php
	}	
}
?>