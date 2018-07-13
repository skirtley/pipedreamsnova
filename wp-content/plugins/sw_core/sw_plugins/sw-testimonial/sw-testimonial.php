<?php
/**
 * Name: SW Testimonial Slider Widget
 * Description: A widget that serves as an slider for developing more advanced widgets.
 */

class sw_testimonial_slider_widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Register Taxonomy */
		add_action( 'init', array( $this, 'testimonial_register' ) );		
		add_action( 'admin_init', array( $this, 'testimonial_init' ) );
		add_action( 'save_post', array( $this, 'testimonial_save_meta' ), 10, 1 );

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_testimonial_slider', 'description' => __('Sw Testimonial Slider', 'sw_core') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_testimonial_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_testimonial_slider', __('Sw Testimonial Slider widget', 'sw_core'), $widget_ops, $control_ops );
	
		/* Create Shortcode */
		add_shortcode( 'testimonial', array( $this, 'TT_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'TT_integrateWithVC' ) );
		}
	}
	
	function testimonial_register() {
		$labels = array(
			'name' => __('Testimonial', 'sw_core'),
			'singular_name' => __('Testimonial Item', 'sw_core'),
			'add_new' => __('Add New', 'sw_core'),
			'add_new_item' => __('Add New Item', 'sw_core'),
			'edit_item' => __('Edit Item', 'sw_core'),
			'new_item' => __('New Item', 'sw_core'),
			'view_item' => __('View Item', 'sw_core'),
			'search_items' => __('Search', 'sw_core'),
			'not_found' =>  __('Nothing found', 'sw_core'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-welcome-write-blog',
			'rewrite' =>  true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => 4,
			'supports' => array( 'title', 'thumbnail', 'editor' )
		  );

		register_post_type( 'testimonial' , $args );
	}
	
	function testimonial_init(){
		add_meta_box( __( 'Testimonial Options', 'sw_core' ), __( 'Testimonial Options', 'sw_core' ), array( $this, 'testimonial_detail' ), 'testimonial', 'normal', 'low' );
	}
	
	function testimonial_detail(){
		global $post;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'testimonial_save_meta', 'sw_testimonial_plugin_nonce' );
		$au_name = get_post_meta( $post->ID, 'au_name', true );
		$au_url  = get_post_meta( $post->ID, 'au_url', true );
		$au_info = get_post_meta( $post->ID, 'au_info', true );
	?>	
		<p><label><b><?php esc_html_e('Author Name', 'sw_core'); ?>:</b></label><br/>
			<input type ="text" name = "au_name" value ="<?php echo esc_attr( $au_name );?>" size="70%" /></p>
		<p><label><b><?php esc_html_e('Author URL', 'sw_core'); ?>:</b></label><br/>
			<input type ="text" name = "au_url" value ="<?php echo esc_attr( $au_url );?>" size="70%" /></p>
		<p><label><b><?php esc_html_e('Author Infomation', 'sw_core'); ?>:</b></label><br/>
			<input type ="text" name = "au_info" value ="<?php echo esc_attr( $au_info );?>" size="70%" /></p>
	<?php 
	}
	function testimonial_save_meta(){
		global $post;
		if ( ! isset( $_POST['sw_testimonial_plugin_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['sw_testimonial_plugin_nonce'], 'testimonial_save_meta' ) ) {
			return;
		}
		$list_meta = array( 'au_name', 'au_url', 'au_info' );
		foreach( $list_meta as $meta ){
			if( isset( $_POST[$meta] ) ){
				$my_data = sanitize_text_field( $_POST[$meta] );
				update_post_meta( $post->ID, $meta, $my_data );
			}
		}
	}
	public function ya_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	/**
	* VC Integrate
	**/
	function TT_integrateWithVC(){
		vc_map( array(
			'name' =>  __( 'Sw Testimonial Slider', 'sw_core' ),
			'base' => 'testimonial',
			"icon" => "icon-wpb-ytc",
			'category' => __( 'SW Core', 'sw_core' ),
			'class' => 'wpb_vc_wp_widget',
			'weight' => - 50,
			'description' => '',
			'params' => array(
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
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Exerpt Length", 'sw_core' ),
					"param_name" => "length",
					"admin_label" => true,
					"value" => 25,
					"description" => __( "Exerpt Length", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order By", 'sw_core' ),
					"param_name" => "orderby",
					"admin_label" => true,
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns >1200px: ", 'sw_core' ),
					"param_name" => "columns",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_core' ),
					"param_name" => "columns1",
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
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns in 480px or less than:", 'sw_core' ),
					"param_name" => "columns4",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", 'sw_core' ),
					"param_name" => "speed",
					"value" => 1000,
					"description" => __( "Speed Of Slide", 'sw_core' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", 'sw_core' ),
					"param_name" => "autoplay",
					"value" => array( 'True' => 'true', 'False' => 'false' ),
					"description" => __( "Auto Play", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", 'sw_core' ),
					"param_name" => "interval",
					"value" => 5000,
					"description" => __( "Interval", 'sw_core' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", 'sw_core' ),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __( "Total Items Slided", 'sw_core' )
				 ),
			 	array(
					'type' => 'dropdown',
					'holder' => 'div',
					'heading' => __( 'Layout', 'sw_core' ),
					'param_name' => 'layout',
					"admin_label" => true,
					'value' => array(
						__( 'Layout Default','sw_core' ) => 'default',
						__( 'Layout Indicators Up','sw_core' ) => 'layout1',	
						__( 'Layout Them1','sw_core' ) => 'layout2',		
					),
					'description' => sprintf( __( 'Select Layout', 'sw_core' ) )
				),	
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'sw_core' ),
					'param_name' => 'el_class',
					"admin_label" => true,
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_core' )
				),
			)
		) );
	}
	
	/**
	* Add Shortcode
	**/
	function TT_Shortcode( $atts,$content = null ){
		extract(shortcode_atts(array(
			'el_class'=> '',
			'title'=> '',
			'orderby' => 'name',
			'length'=> 25,
			'order' => 'DESC',
			'numberposts' => 5,
			'columns' => 4,
			'columns1' => 4,
			'columns2' => 3,
			'columns3' => 2,
			'columns4' => 1,
			'speed' => 1000,
			'autoplay' => 'true',
			'interval' => 5000,
			'layout'  => 'default',
			'scroll' => 1
		 ),$atts));
		ob_start();		
		if( $layout == 'default' ){
			include( 'themes/default.php' );
		}elseif( $layout == 'layout1' ){
			include( 'themes/layout1.php' );
		}elseif( $layout == 'layout2' ){
			include( 'themes/layout2.php' );
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
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		extract($instance);
		
		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if ( $tpl = $this->getTemplatePath( $instance['widget_template'] ) ){ 
			$link_img = plugins_url('images/', __FILE__);
			$widget_id = $args['widget_id'];		
			include $tpl;
		}
				
		/* After widget (defined by themes). */
		echo $after_widget;
	}    

	protected function getTemplatePath($tpl='default', $type=''){
		$file = '/'.$tpl.$type.'.php';
		$dir =realpath(dirname(__FILE__)).'/themes';
		
		if ( file_exists( $dir.$file ) ){
			return $dir.$file;
		}
		
		return $tpl=='default' ? false : $this->getTemplatePath('default', $type);
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['el_class']=strip_tags($new_instance['el_class']);
        $instance['style_title']=strip_tags($new_instance['style_title']);
		// int or array
		
		if ( array_key_exists('orderby', $new_instance) ){
			$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		}

		if ( array_key_exists('order', $new_instance) ){
			$instance['order'] = strip_tags( $new_instance['order'] );
		}

		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}

		if ( array_key_exists('length', $new_instance) ){
			$instance['length'] = intval( $new_instance['length'] );
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
		$el_class  = isset( $instance['el_class'] )    ? 	strip_tags($instance['el_class']) : '';
		$style_title  = isset( $instance['style_title'] )    ? 	strip_tags($instance['style_title']) : '';		
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
		$length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
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

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'sw_core')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id('el_class'); ?>"><?php _e('El_class', 'sw_core')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('el_class'); ?>" name="<?php echo $this->get_field_name('el_class'); ?>"
				type="text"	value="<?php echo esc_attr($el_class); ?>" />
		</p>

<?php $style_title_name = array('title1' => 'title1', 'title2' => 'title2', 'title3' => 'title3', 'title4' => 'title4'); ?>
<p>
			<label for="<?php echo $this->get_field_id('style_title'); ?>"><?php _e('Style title ', 'sw_core')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('style_title'); ?>"
				name="<?php echo $this->get_field_name('style_title'); ?>">
				<?php
				$option ='';
				foreach ($style_title_name as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $style_title){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_core')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
				<?php } ?>>
					<?php _e('Theme1', 'sw_core')?>
				</option>
			</select>
		</p>           
	<?php
	}	
}
?>