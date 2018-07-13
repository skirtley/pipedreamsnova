<?php
/**
	* SW Woocommerce Categories Slider
	* Register Widget Woocommerce Categories Slider
	* @author 		flytheme
	* @version     1.0.0
**/
if ( !class_exists('sw_woo_cat_slider_widget') ) {
	class sw_woo_cat_slider_widget extends WP_Widget {
		
		private $snumber = 1;
		/**
		 * Widget setup.
		 */
		function __construct(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woo_cat_slider_widget', 'description' => __('Sw Woo Categories Slider', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woo_cat_slider_widget' );

			/* Create the widget. */
			parent::__construct( 'sw_woo_cat_slider_widget', __('Sw Woo Categories Slider widget', 'sw_woocommerce'), $widget_ops, $control_ops );
			
			add_action( 'wp_enqueue_scripts', array( $this, 'swcat_enqueue_script' ), 100 );
				
			/* Create Shortcode */
			add_shortcode( 'woocat_slide', array( $this, 'WSC_Shortcode' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') ) {
				add_action( 'vc_before_init', array( $this, 'WSC_integrateWithVC' ), 10 );
			}
			/* Add Custom field to category product */
			add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 100 );
			add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 100 );
			add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
			
			/* Ajax Call */
			if( version_compare( WC()->version, '2.4', '>=' ) ){
					add_action( 'wc_ajax_sw_category_callback', array( $this, 'sw_category_callback' ) );
					add_action( 'wc_ajax_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing' ) );
			}else{
				add_action( 'wp_ajax_sw_category_callback', array( $this, 'sw_category_callback') );
				add_action( 'wp_ajax_nopriv_sw_category_callback', array( $this, 'sw_category_callback') );
				add_action( 'wp_ajax_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing') );
				add_action( 'wp_ajax_nopriv_sw_category_ajax_listing', array( $this, 'sw_category_ajax_listing') );
			}
		}
		
		/*
		** Generate ID
		*/
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		/**
		* Enqueue script
		**/
		function swcat_enqueue_script(){
			wp_register_script( 'category_ajax_js', WCURL.'/js/category-ajax.js',array(), null, true );
			wp_localize_script( 'category_ajax_js', 'ya_catajax', array( 'ajax_url' => sw_ajax_url() ) );
			wp_enqueue_script( 'category_ajax_js' );	
		}
		
		/*
		** Get Count category level 1
		*/
		function sw_count_category( $number = 1 ){
			global $wpdb;
			$values = 1;
			$count = $wpdb->get_var($wpdb->prepare( "SELECT count(`term_id`) FROM `$wpdb->term_taxonomy` WHERE `taxonomy`='%s' AND `parent` = 0", 'product_cat' ) );
			if( $number > 0 && $count > $number ) {
				$values = ceil($count/$number);
			}
			return $values;
		}
		
		/**
		* Add Vc Params
		**/
		function WSC_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => '', 'hide_empty' => false ) );
			$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
			if( count( $terms )  > 0 ){
				foreach( $terms as $cat ){
					$term[$cat->name] = $cat -> slug;
				}
			}
			vc_map( array(
			  "name" => __( "SW Woocommerce Categories Slider", 'sw_woocommerce' ),
			  "base" => "woocat_slide",
			  "icon" => "icon-wpb-ytc",
			  "class" => "",
			  "category" => __( "SW Shortcodes", 'sw_woocommerce'),
			  "params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", 'sw_woocommerce' ),
					"param_name" => "title1",
					"admin_label" => true,
					"value" => '',
					"description" => __( "Title", 'sw_woocommerce' )
				 ),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Product Title Length", 'sw_woocommerce' ),
					"param_name" => "title_length",
					"admin_label" => true,
					"value" => 0,
					"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => 'layout2' ,
					),
				),			
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Desciption", 'sw_woocommerce' ),
					"param_name" => "desciption",
					"admin_label" => true,
					"value" => '',
					"description" => __( "Desciption", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2','theme3','theme4', 'theme5','theme6','theme7' )
					),
				 ),	
				  array(
					"type" => "multiselect",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Categories", 'sw_woocommerce' ),
					"param_name" => "category",
					"admin_label" => true,
					"value" => $term,
					"description" => __( "Select Categories", 'sw_woocommerce' ),
					"dependency" => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2','layout2','layout3','theme3','theme4','theme5','theme6','theme7' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", "flytheme" ),
					"param_name" => "item_row",
					"admin_label" => true,
					"value" =>array(1,2,3),
					"description" => __( "Number row per column", "flytheme" ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'theme4' )
					),
				 ),	
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Products", 'sw_woocommerce' ),
					"param_name" => "numberposts",
					"admin_label" => true,
					"value" => 5,
					"description" => __( "Number of products for layout 2", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'layout2','layout4' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Order By", 'sw_woocommerce' ),
					"param_name" => "orderby",
					"admin_label" => true,
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
					"description" => __( "Order by for layout 2", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => 'layout2' 
					),
				 ),				
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns >1200px: ", 'sw_woocommerce' ),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default', 'theme1','theme2','layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
					"param_name" => "columns1",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
					"param_name" => "columns2",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
					"param_name" => "columns3",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
					"param_name" => "columns4",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", 'sw_woocommerce' ),
					"param_name" => "speed",
					"admin_label" => true,
					"value" => 1000,
					"description" => __( "Speed Of Slide", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", 'sw_woocommerce' ),
					"param_name" => "autoplay",
					"admin_label" => true,
					"value" => array( 'True' => 'true', 'False' => 'false' ),
					"description" => __( "Auto Play", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", 'sw_woocommerce' ),
					"param_name" => "interval",
					"admin_label" => true,
					"value" => 5000,
					"description" => __( "Interval", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", 'sw_woocommerce' ),
					"param_name" => "layout",
					"admin_label" => true,
					"value" => array( 'Layout Default' => 'default', 'Layout Theme1' => 'theme1', 'Layout Theme2' => 'theme2', 'Layout Theme3' => 'theme3', 'Layout Theme4' => 'theme5',
					'Layout Theme5' => 'theme6', 'Layout Theme6' => 'theme7', 'Layout Category Ajax' => 'layout2', 'Layout Mobile' => 'layout3',  'Layout Mobile2' => 'theme4', 'Layout Mobile Ajax' => 'layout4' ),
					"description" => __( "Layout", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
					"param_name" => "scroll",
					"admin_label" => true,
					"value" => 1,
					"description" => __( "Total Items Slided", 'sw_woocommerce' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'default','theme1','theme2', 'layout2','theme3','theme4','theme6' )
					),
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function WSC_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'title_length' => 0,
					'desciption' => '',
					'orderby' => 'name',
					'category' => '',
					'item_row' => 1,
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
				), $atts )
			);
			ob_start();		
			if( $layout == 'default' ){
				include( sw_override_check( 'category-slider', 'default' ) );			
			}
			elseif( $layout == 'layout2' ){
				include( sw_override_check( 'category-slider', 'category_ajax' ) );			
			}
			elseif( $layout == 'layout3' ){
				include( sw_override_check( 'category-slider', 'theme-mobile' ) );			
			}
			elseif( $layout == 'theme4' ){
				include( sw_override_check( 'category-slider', 'theme-mobile2' ) );			
			}
			elseif( $layout == 'layout4' ){
				include( sw_override_check( 'category-slider', 'category_mobile_ajax' ) );	
			}
			elseif( $layout == 'theme1' ){
				include( sw_override_check( 'category-slider', 'theme1' ) );	
			}
			elseif( $layout == 'theme2' ){
				include( sw_override_check( 'category-slider', 'theme2' ) );	
			}
			elseif( $layout == 'theme3' ){
				include( sw_override_check( 'category-slider', 'theme3' ) );	
			}
			elseif( $layout == 'theme5' ){
				include( sw_override_check( 'category-slider', 'theme4' ) );	
			}
			elseif( $layout == 'theme6' ){
				include( sw_override_check( 'category-slider', 'theme5' ) );	
			}
			elseif( $layout == 'theme7' ){
				include( sw_override_check( 'category-slider', 'theme6' ) );	
			}
			$content = ob_get_clean();
			
			return $content;
		}
		
		/**
		*	Add Custom field on category product
		**/
		public function add_category_fields() { 
	?>
			<div class="form-field">
				<label><?php _e( 'Thumbnail 1', 'woocommerce' ); ?></label>
				<div id="product_cat_thumbnail1" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail_id1" name="product_cat_thumbnail_id1" />
					<button type="button" class="upload_image_button1 button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image_button1 button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#product_cat_thumbnail_id1' ).val() ) {
						jQuery( '.remove_image_button1' ).hide();
					}

					// Uploading files
					var file_frame1;

					jQuery( document ).on( 'click', '.upload_image_button1', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame1 ) {
							file_frame1.open();
							return;
						}

						// Create the media frame.
						file_frame1 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
							button: {
								text: '<?php _e( "Use image", "woocommerce" ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame1.on( 'select', function() {
							var attachment = file_frame1.state().get( 'selection' ).first().toJSON();
							
							jQuery( '#product_cat_thumbnail_id1' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail1 > img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button1' ).show();
						});

						// Finally, open the modal.
						file_frame1.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button1', function() {
						jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail_id1' ).val( '' );
						jQuery( '.remove_image_button1' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
			<?php
		}
		
		public function edit_category_fields( $term ) {

			$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id1', true ) );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = wc_placeholder_img_src();
			}
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php _e( 'Thumbnail 1', 'woocommerce' ); ?></label></th>
				<td>
					<div id="product_cat_thumbnail1" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="product_cat_thumbnail_id1" name="product_cat_thumbnail_id1" value="<?php echo $thumbnail_id; ?>" />
						<button type="button" class="upload_image_button1 button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
						<button type="button" class="remove_image_button1 button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
					</div>
					<script type="text/javascript">

						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#product_cat_thumbnail_id1' ).val() ) {
							jQuery( '.remove_image_button1' ).hide();
						}

						// Uploading files
						var file_frame1;

						jQuery( document ).on( 'click', '.upload_image_button1', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame1 ) {
								file_frame1.open();
								return;
							}

							// Create the media frame.
							file_frame1 = wp.media.frames.downloadable_file = wp.media({
								title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
								button: {
									text: '<?php _e( "Use image", "woocommerce" ); ?>'
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							file_frame1.on( 'select', function() {
								var attachment = file_frame1.state().get( 'selection' ).first().toJSON();

								jQuery( '#product_cat_thumbnail_id1' ).val( attachment.id );
								jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', attachment.sizes.thumbnail.url );
								jQuery( '.remove_image_button1' ).show();
							});

							// Finally, open the modal.
							file_frame1.open();
						});

						jQuery( document ).on( 'click', '.remove_image_button1', function() {
							jQuery( '#product_cat_thumbnail1 img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
							jQuery( '#product_cat_thumbnail1_id' ).val( '' );
							jQuery( '.remove_image_button1' ).hide();
							return false;
						});

					</script>
					<div class="clear"></div>
				</td>
			</tr>
			<?php
		}
		public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['product_cat_thumbnail_id1'] ) && 'product_cat' === $taxonomy ) {
				update_woocommerce_term_meta( $term_id, 'thumbnail_id1', absint( $_POST['product_cat_thumbnail_id1'] ) );
			}
		}
		/**
		* Ajax Callback
		**/
		function sw_category_callback(){
			$catid 			= ( isset( $_POST["catid"] )   	&& $_POST["catid"] != '' ) ? $_POST["catid"] : '';
			$number			= ( isset( $_POST["number"] )  	&& $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$target     = ( isset( $_POST["target"] )  	&& $_POST["target"] != '' ) ? str_replace( '#', '', $_POST["target"] ) : '';
			$orderby 		= ( isset( $_POST["orderby"] ) 	&& $_POST["orderby"] != '' ) ? $_POST["orderby"] : 'ID';
			$columns		= ( isset( $_POST["columns"] )  && $_POST["columns"] > 0 ) ? $_POST["columns"] : 1;
			$columns1		= ( isset( $_POST["columns1"] ) && $_POST["columns1"] > 0 ) ? $_POST["columns1"] : 1;
			$columns2		= ( isset( $_POST["columns2"] ) && $_POST["columns2"] > 0 ) ? $_POST["columns2"] : 1;
			$columns3		= ( isset( $_POST["columns3"] ) && $_POST["columns3"] > 0 ) ? $_POST["columns3"] : 1;
			$columns4		= ( isset( $_POST["columns4"] ) && $_POST["columns4"] > 0 ) ? $_POST["columns4"] : 1;
			$interval		= ( isset( $_POST["interval"] ) && $_POST["interval"] > 0 ) ? $_POST["interval"] : 1000;
			$speed			= ( isset( $_POST["speed"] )  	&& $_POST["speed"] > 0 ) ? $_POST["speed"] : 1000;
			$scroll			= ( isset( $_POST["scroll"] )  	&& $_POST["scroll"] > 0 ) ? $_POST["scroll"] : 1;
			$rtl				= ( isset( $_POST["rtl"] )  		&& $_POST["rtl"] != '' ) ? $_POST["rtl"] : 'false';
			$autoplay		= ( isset( $_POST["autoplay"] ) && $_POST["autoplay"] != '' ) ? $_POST["autoplay"] : 'false';
			$title_length = ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$default = array(
				'post_type' => 'product',
				'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'term_id',
					'terms'     => $catid ) ),
				'orderby' => $orderby,
				'post_status' => 'publish',
				'posts_per_page' => 0
			);		
			$default = sw_check_product_visiblity( $default );
			
			$thumbnail_id 	= absint( get_woocommerce_term_meta( $catid, 'thumbnail_id1', true ));
			$thumb 			= wp_get_attachment_image( $thumbnail_id, 'full', 0, array( 'class' => 'category-image pull-left' ) );
			$list 			= new WP_Query( $default );			
			if ( $list -> have_posts() ){ 
		?>
			<div id="<?php echo esc_attr( $target ); ?>" class="tab-pane fade in active">
				<div id="<?php echo 'category_ajax_slider_'.$catid; ?>" class="sw-woo-container-slider responsive-slider woo-slider-default" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo esc_attr( $rtl ) ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">       
					<div class="slider-wrapper clearfix">
					<?php if( $thumbnail_id != 0 ){?>
						<div class="imgleft  img-effect pull-left">
							<a class="img-class " href="#">	<?php echo $thumb; ?></a>
						</div>		
					<?php } ?>
						<div class="resp-slider-container">
							<div class="slider responsive">	
						<?php 
							while($list->have_posts()): $list->the_post();
							global $product, $post; 
							$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
						?>
								<div class="item <?php echo esc_attr( $class )?> product">
									<?php include( WCTHEME . '/default-item.php' ); ?>
								</div>
							<?php endwhile; wp_reset_postdata();?>
							</div>
						</div>
					</div>
				</div>
			<?php
				}else{
					echo '<div class="alert alert-warning alert-dismissible" role="alert">
						<a class="close" data-dismiss="alert">&times;</a>
						<p>'. esc_html__( "There isn't product in this category", 'sw_woocommerce' ) . '</p>
					</div>';
				}
			?>
			</div>
		<?php 
			exit();
		}		
		
		function sw_category_ajax_listing(){
			$number	= ( isset( $_POST["number"] )  	&& $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$page 	= ( isset( $_POST["page"]) ) ? $_POST["page"] : 1;
			$title_length = ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false, 'number' => $number, 'offset' => $number*$page ) );
			foreach( $terms as $term ){
			if( $term ) :
				$thumbnail_id1 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb1 = wp_get_attachment_image( $thumbnail_id1,'revo_cat_thumb_mobile' );
				$thubnail = ( $thumb1 != '' ) ? $thumb1 : '<img src="'.esc_url( 'http://placehold.it/210x270' ) .'" alt=""/>';
		?>
				<div class="item item-product-cat">					
					<div class="item-image">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo $thubnail; ?></a>
					</div>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
					</div>
				</div>
			<?php endif; ?>
		<?php } 
			exit();
		}
		
		/**
		 * Display the widget on the screen.
		 */
		 
		public function widget( $args, $instance ) {
			wp_reset_postdata();
			extract($args);
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) && !empty( $description1 ) ) { echo $before_title . $title . $after_title . '<h5 class="category_description clearfix">' . $description1 . '</h5>'; }
			else if (!empty( $title ) && $description1==NULL ){ echo $before_title . $title . $after_title; }
			
			if ( !isset($instance['category']) ){
				$instance['category'] = array();
			}
			$id = $this -> number;
			extract($instance);

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
			}
			
			if ( $tpl = sw_override_check( 'category-slider', $instance['widget_template'] ) ){ 			
				$link_img = plugins_url('images/', __FILE__);
				$widget_id = $args['widget_id'];		
				include $tpl;
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
			$instance['title1'] = strip_tags( $new_instance['title1'] );
			$instance['title_length'] = intval( $new_instance['title_length'] );
			$instance['description'] = strip_tags( $new_instance['description'] );
			// int or array
			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = $new_instance['category'] ;
				} else {
					$instance['category'] = strip_tags( $new_instance['category'] );
				}
			}		
			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
			}
			if ( array_key_exists('orderby', $new_instance) ){
				$instance['orderby'] = strip_tags( $new_instance['orderby'] );
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
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					//$allow_select_all = '<option value="">All Categories</option>';
				}
			} else {
				// is not multiple
				unset($opts['multiple']);
				unset($opts['size']);
				if (is_array($field_value)){
					$field_value = array_shift($field_value);
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					$allow_select_all = '<option value="">All Categories</option>';
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
			
			$categories = get_terms('product_cat');
			$all_category_ids = array();
			foreach ($categories as $cat) $all_category_ids[] = $cat->slug;
			$is_valid_field_value = in_array($field_value, $all_category_ids);
			if (!$is_valid_field_value && is_array($field_value)){
				$intersect_values = array_intersect($field_value, $all_category_ids);
				$is_valid_field_value = count($intersect_values) > 0;
			}
			if (!$is_valid_field_value){
				$field_value = '';
			}
		
			$select_html = '<select ' . $select_attributes . '>';
			if (isset($allow_select_all)) $select_html .= $allow_select_all;
			foreach ($categories as $cat){			
				$select_html .= '<option value="' . $cat->slug . '"';
				if ($cat->slug == $field_value || (is_array($field_value)&&in_array($cat->slug, $field_value))){ $select_html .= ' selected="selected"';}
				$select_html .=  '>'.$cat->name.'</option>';
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
					 
			$title1 			= isset( $instance['title1'] )    		? strip_tags($instance['title1']) : '';
			$title_length = isset( $instance['title_length'] )  ? intval($instance['title_length']) : 0;
			$description 	= isset( $instance['description'] )   ? strip_tags($instance['description']) : '';
			$categoryid 	= isset( $instance['category']  ) 		? $instance['category'] : null;
			$number     	= isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$orderby    	= isset( $instance['orderby'] )     	? strip_tags($instance['orderby']) : 'ID';
			$columns     	= isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     = isset( $instance['columns1'] )     	? intval($instance['columns1']) : 1;
			$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : 1;
			$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : 1;
			$columns4     = isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
			$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
			$speed     		= isset( $instance['speed'] )      		? intval($instance['speed']) : 1000;
			$scroll     	= isset( $instance['scroll'] )      	? intval($instance['scroll']) : 1;
			$widget_template = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
					   
					 
			?>		
			</p> 
			  <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
					type="text"	value="<?php echo esc_attr($title1); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title_length'); ?>"><?php _e('Product Title Length', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>"
					type="text"	value="<?php echo esc_attr($title_length); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"
					type="text"	value="<?php echo esc_attr($description); ?>" />
			</p>
			
			<p id="wgd-<?php echo $this->get_field_id('category'); ?>">
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'sw_woocommerce')?></label>
				<br />
				<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'sw_woocommerce')?></label>
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
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
			<p>
				<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
					<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
					<?php } ?>>
						<?php _e('False', 'sw_woocommerce')?>
					</option>
					<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
						<?php _e('True', 'sw_woocommerce')?>
					</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
					type="text"	value="<?php echo esc_attr($interval); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
					type="text"	value="<?php echo esc_attr($speed); ?>" />
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
					type="text"	value="<?php echo esc_attr($scroll); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_woocommerce')?>		
					</option>			
					<option value="category_ajax" <?php if ($widget_template=='category_ajax'){?> selected="selected"
					<?php } ?>>
						<?php _e('Category Ajax Tab', 'sw_woocommerce')?>
					</option>					
				</select>
			</p>  
		<?php
		}	
	}
}
?>