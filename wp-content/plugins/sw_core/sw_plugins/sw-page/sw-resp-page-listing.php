<?php
/**
 * Name: SW Responsive Page Listing
 * Version: 1.0.0
 * Author: smartaddons.com
 * Author URI: http://smartaddons.com
 */
 

if( !class_exists('sw_resp_page_listing') ) :
	add_action( 'widgets_init', 'sw_resp_page_register' );
	function sw_resp_page_register(){
			register_widget( 'sw_resp_page_listing' );
	}
	 
	class sw_resp_page_listing extends WP_Widget {
		
		private $snumber = 1;
		/**
		 * Widget setup.
		 */
		function __construct() {

			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_resp_page_listing', 'description' => __('Sw Responsive Page Listing', 'sw_core') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_resp_page_listing' );

			/* Create the widget. */
			parent::__construct( 'sw_resp_page_listing', __('Sw Responsive Page Listing', 'sw_core'), $widget_ops, $control_ops );
			
			/* Create Shortcode */
			add_shortcode( 'resp_page_listing', array( $this, 'RP_Shortcode' ) );
			
			/* Create Vc_map */
			if (class_exists('Vc_Manager')) {
				add_action( 'vc_before_init', array( $this, 'RP_integrateWithVC' ) );
			}
			
			/* Ajax Call */
			add_action( 'wp_ajax_sw_page_listing', array( $this, 'sw_page_listing_callback'), 99 );
			add_action( 'wp_ajax_nopriv_sw_page_listing', array( $this, 'sw_page_listing_callback'), 99 );
		}
		
		/*
		** Generate ID
		*/
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		function get_the_content_by_id( $post_id ) {
			$page_data = get_page( $post_id );
			if ($page_data) {
				$content = apply_filters( 'the_content', $page_data->post_content );
				return $content;
			}
			else return '<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p>'. esc_html__( "There isn't content for this page.", 'sw_core' ) .'</p>
			</div>'; ;
		}
		
		/**
		* Add Vc Params
		**/
		function RP_integrateWithVC(){
			$link_pages = array();
			$link_page     = get_pages(); 
			if ( is_array( $link_page ) ) {
				foreach ( $link_page as $link ) {
					$link_pages[$link->post_title] = $link->ID;
				}
			}
			vc_map( array(
				"name" => __( "SW Responsive Page Listing", 'sw_core' ),
				"base" => "resp_page_listing",
				"icon" => "icon-wpb-ytc",
				"class" => "",
				"category" => __( "SW Core", 'sw_core'),
				"params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", 'sw_core' ),
					"param_name" => "title1",
					"value" => "",
					"description" => __( "Title", 'sw_core' )
				 ),
				 
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Description", 'sw_core' ),
					"param_name" => "description",
					"value" => "",
					"description" => __( "Description", 'sw_core' )
				 ),
				 
				 array(
				'param_name'    => 'category',
				'type'          => 'multiselect',
				'value'         => $link_pages, 
				'heading'       => __('Select Page', 'sw_core'),
				'description'   => '',
				'holder'        => 'div',
				'class'         => ''
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
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", 'sw_core' ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'default', 'Layout Ajax Tab' => 'layout1' ),
					"description" => __( "Layout", 'sw_core' )
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
				)
			 ) );
		}
		/**
			** Add Shortcode
		**/
		function RP_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'description' =>'',
					'category' => '',
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
				), $atts )
			);
			if( $layout == 'layout1' ){
				wp_register_script( 'page_ajax_listing', SWURL . '/js/ajax_page.js' );
				wp_localize_script( 'page_ajax_listing', 'sw_page', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
				wp_enqueue_script( 'page_ajax_listing' );
			}
			ob_start();		
			if( $layout == 'default' ){
				include( 'themes/default.php' );
			}	
			if( $layout == 'layout1' ){
				include( 'themes/layout1.php' );
			}	
			
			$content = ob_get_clean();
			
			return $content;
		}
		
		function sw_page_listing_callback(){
			$pageid = ( isset( $_POST["pageid"] )   	&& $_POST["pageid"] != '' ) ? $_POST["pageid"] : 0;
			if (class_exists('Vc_Manager')) {
				WPBMap::addAllMappedShortcodes();
			}
			echo do_shortcode( $this->get_the_content_by_id( $pageid ) );
			exit();
		}		
		
		/**
		 * Display the widget on the screen.
		 */
		public function widget( $args, $instance ) {
			wp_reset_postdata();
			extract($args);
			$title = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
			$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) && !empty( $description1 ) ) { echo $before_title . $title . $after_title . '<h5 class="category_description clearfix">' . $description1 . '</h5>'; }
			else if (!empty( $title ) && $description1==NULL ){ echo $before_title . $title . $after_title; }
			
			if (!isset($instance['category'])){
				$instance['category'] = 0;
			}
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
			$instance['title1'] = strip_tags( $new_instance['title1'] );
			$instance['description'] = strip_tags( $new_instance['description'] );
			// int or array
			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = array_map( 'intval', $new_instance['category'] );
				} else {
					$instance['category'] = intval($new_instance['category']);
				}
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
			if ( array_key_exists('start', $new_instance) ){
				$instance['start'] = intval( $new_instance['start'] );
			}
			if ( array_key_exists('scroll', $new_instance) ){
				$instance['scroll'] = intval( $new_instance['scroll'] );
			}	
			if ( array_key_exists('autoplay', $new_instance) ){
				$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
			}
					$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
					
						
					
			return $instance;
		}

		function category_select( $field_name, $opts = array(), $field_value = null ){
			$default_options = array(
					'multiple' => true,
					'disabled' => false,
					'size' => 5,
					'class' => 'widefat',
					'required' => false,
					'autofocus' => false,
					'form' => false,
			);
			$opts = wp_parse_args($opts, $default_options);
		
			if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
				$opts['multiple'] = 'multiple';
				if ( !is_numeric($opts['size']) ){
					if ( intval($opts['size']) ){
						$opts['size'] = intval($opts['size']);
					} else {
						$opts['size'] = 5;
					}
				}
			} else {
				unset($opts['multiple']);
				unset($opts['size']);
				if (is_array($field_value)){
					$field_value = array_shift($field_value);
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					$allow_select_all = '<option value="0">'. esc_html__( 'Select Page', 'sw_core' ) .'</option>';
				}
			}
		
			if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
				$opts['disabled'] = 'disabled';
			} else {
				unset($opts['disabled']);
			}
		
			if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
				$opts['required'] = 'required';
			} else {
				unset($opts['required']);
			}
		
			if ( !is_string($opts['form']) ) unset($opts['form']);
		
			if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
		
			$opts['id'] = $this->get_field_id($field_name);
		
			$opts['name'] = $this->get_field_name($field_name);
			if ( isset($opts['multiple']) ){
				$opts['name'] .= '[]';
			}
			$select_attributes = '';
			foreach ( $opts as $an => $av){
				$select_attributes .= "{$an}=\"{$av}\" ";
			}
			
			$categories = get_pages();
			
			$all_category_ids = array();
			foreach ($categories as $cat) $all_category_ids[] = (int)$cat->ID;
			
			$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
			if (!$is_valid_field_value && is_array($field_value)){
				$intersect_values = array_intersect($field_value, $all_category_ids);
				$is_valid_field_value = count($intersect_values) > 0;
			}
			if (!$is_valid_field_value){
				$field_value = '0';
			}
		
			$select_html = '<select ' . $select_attributes . '>';
			if (isset($allow_select_all)) $select_html .= $allow_select_all;
			foreach ($categories as $cat){
				$select_html .= '<option value="' . $cat->ID . '"';
				if ($cat->ID == $field_value || (is_array($field_value)&&in_array($cat->ID, $field_value))){ $select_html .= ' selected="selected"';}
				$select_html .=  '>'.$cat->post_title.'</option>';
			}
			$select_html .= '</select>';
			return $select_html;
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
			$description = isset( $instance['description'] )    ? 	strip_tags($instance['description']) : '';
			$categoryid = isset( $instance['category'] )    ? $instance['category'] : 0;			
			$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
			$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
			$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
			$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
			$columns4     = isset( $instance['columns4'] )      ? intval($instance['columns4']) : '';
			$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
			$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
			$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
			$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
			$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
										 
									 
			?>		
					</p> 
						<div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
					</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
					type="text"	value="<?php echo esc_attr($title1); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'sw_core')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"
					type="text"	value="<?php echo esc_attr($description); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Page ID', 'sw_core')?></label>
				<br />
				<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
			</p>
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
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
				</select>
			</p>           
		<?php
		}	
	}
endif;
?>