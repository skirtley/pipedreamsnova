<?php 
vc_add_shortcode_param( 'date', 'sw_date_vc_setting' );

function sw_date_vc_setting( $settings, $value ) {
 return '<div class="vc_date_block">'
   .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
   esc_attr( $settings['param_name'] ) . ' ' .
   esc_attr( $settings['type'] ) . '_field" type="date" value="' . esc_attr( $value ) . '" placeholder="dd-mm-yyyy"/>' .
  '</div>'; 
}

/*
** Add Multi Select Param
*/
if( !function_exists( 'sw_mselect_settings_field' ) ) :
	vc_add_shortcode_param( 'multiselect', 'sw_mselect_settings_field' );
	function sw_mselect_settings_field( $settings, $value ) {
		$output = '';
		$values = explode( ',', $value );
		$output .= '<select name="'
							 . $settings['param_name']
							 . '" class="wpb_vc_param_value wpb-input wpb-select '
							 . $settings['param_name']
							 . ' ' . $settings['type']
							 . '" multiple="multiple">';
		if ( is_array( $value ) ) {
			$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
		}
		if ( ! empty( $settings['value'] ) ) {
			foreach ( $settings['value'] as $index => $data ) {
				if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
					$option_label = $data;
					$option_value = $data;
				} elseif ( is_numeric( $index ) && is_array( $data ) ) {
					$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
					$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
				} else {
					$option_value = $data;
					$option_label = $index;
				}
				$selected = '';
				$option_value_string = (string) $option_value;
				$value_string = (string) $value;
				$selected = (is_array($values) && in_array($option_value, $values))?' selected="selected"':'';
				$option_class = str_replace( '#', 'hash-', $option_value );
				$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
									 . htmlspecialchars( $option_label ) . '</option>';
			}
		}
		$output .= '</select>';

		return $output;
	}
endif;

add_action( 'vc_before_init', 'SW_shortcodeVC' );
function SW_shortcodeVC(){
$target_arr = array(
	__( 'Same window', 'sw_woocommerce' ) => '_self',
	__( 'New window', 'sw_woocommerce' ) => "_blank"
);	
$args = array(
			'type' => 'post',
			'child_of' => 0,
			'parent' => 0,
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => 'product_cat',
			'pad_counts' => false,

		);
		$product_categories_dropdown = array( __( 'All Categories Products', 'sw_woocommerce' ) => '' );
		$categories = get_categories( $args );
		foreach($categories as $category){
			$product_categories_dropdown[$category->name] = $category -> slug;
		}

$terms = get_terms( 'product_cat', array( 'parent' => '', 'hide_empty' => false ) );
	$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
	if( count( $terms )  > 0 ){
		foreach( $terms as $cat ){
			$term[$cat->name] = $cat -> slug;
		}
	}


/////////////////// best sale /////////////////////
vc_map( array(
	'name' => __( 'SW Best Sale', 'sw_woocommerce' ),
	'base' => 'BestSale',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'SW Shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display bestseller', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Banner Images', 'sw_woocommerce' ),
			'param_name' => 'images',
			'description' => __( 'Select images', 'sw_woocommerce' ),
			"dependency" => array(
						'element' => 'template',
						'value' => 'slide' 
					),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'sw_woocommerce' ),
			'param_name' => 'template',
			'value' => array(
				'Select type',
				__( 'Default', 'sw_woocommerce' ) => 'default',
				__( 'Slide', 'sw_woocommerce' ) => 'slide',
			),
			'description' => sprintf( __( 'Select different style best sale.', 'sw_woocommerce' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of products to slide', 'sw_woocommerce' ),
			'param_name' => 'item_slide',
			'admin_label' => true,
			'dependency' => array(
					'element' => 'template',
					'value' => array( 'slide' ),
				)
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'sw_woocommerce' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );

///////////////////Latest Product/////////////////////
vc_map( array(
	'name' => __( 'SW Latest Product', 'sw_woocommerce' ),
	'base' => 'Latest',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'SW Shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Latest Products', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'sw_woocommerce' ),
			'param_name' => 'template',
			'value' => array(
				'Select type',
				__( 'Default', 'sw_woocommerce' ) => 'default'
			),
			'description' => sprintf( __( 'Select different style best sale.', 'sw_woocommerce' ) )
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Category", 'sw_woocommerce' ),
			"param_name" => "category",
			"value" => $product_categories_dropdown,
			"description" => __( "Select Categories", 'sw_woocommerce' )
		 ),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of products to slide', 'sw_woocommerce' ),
			'param_name' => 'item_slide',
			'admin_label' => true,
			'dependency' => array(
					'element' => 'template',
					'value' => array( 'slide' ),
				)
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'sw_woocommerce' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );
/*
** Most Viewed
*/
	vc_map( array(
		"name" => __( "SW Most Viewed Slider", 'sw_woocommerce' ),
		"base" => "product_mostvied",
		"icon" => "icon-wpb-ytc",
		"class" => "",
		"category" => __( "SW Shortcodes", 'sw_woocommerce'),
		"params" => array(
		 array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Title", 'sw_woocommerce' ),
			"param_name" => "title",
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
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Select Style", 'sw_woocommerce' ),
			"param_name" => "style",
			"value" => array( 'Default' => '', 'Style1' => 'style1' ),
			"description" => __( "Select Style", 'sw_woocommerce' )
		 ),
			array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Category", 'sw_woocommerce' ),
			"param_name" => "category",
			"value" => $product_categories_dropdown,
			"description" => __( "Select Categories", 'sw_woocommerce' )
		 ),
		 array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Number Of Post", 'sw_woocommerce' ),
			"param_name" => "numberposts",
			"value" => 5,
			"description" => __( "Number Of Post", 'sw_woocommerce' )
		 ),
			array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Layout", 'sw_woocommerce' ),
			"param_name" => "layout",
			"value" => array( 'Layout Default' => 'default' ),
			"description" => __( "Layout", 'sw_woocommerce' )
		 ),
		 array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
			"param_name" => "scroll",
			"value" => 1,
			"description" => __( "Total Items Slided", 'sw_woocommerce' )
		 ),
		)
	 ) );
///////////////////On sale Product/////////////////////
vc_map( array(
	'name' => __( 'SW On sale Product', 'sw_woocommerce' ),
	'base' => 'onsale',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'SW Shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Onsale Products', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),

		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Category", 'sw_woocommerce' ),
			"param_name" => "category",
			"value" => $product_categories_dropdown,
			"description" => __( "Select Categories", 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of products to show', 'sw_woocommerce' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );

/*
** Featured product 
*/
vc_map( array(
	'name' => __( 'SW Featured Product', 'sw_woocommerce' ),
	'base' => 'Featured',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'SW Shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Featured', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Product Title Length", 'sw_woocommerce' ),
			"param_name" => "title_length",
			"admin_label" => true,
			"value" => 0,
			"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Banner Images', 'sw_woocommerce' ),
			'param_name' => 'images',
			'description' => __( 'Select images', 'sw_woocommerce' ),
			"dependency" => array(
						'element' => 'template',
						'value' => 'slide' 
					),
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Category", 'sw_woocommerce' ),
			"param_name" => "category",
			"value" => $product_categories_dropdown,
			"description" => __( "Select Categories", 'sw_woocommerce' )
		 ),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'sw_woocommerce' ),
			'param_name' => 'template',
			'value' => array(
				'Select type',
				__( 'Default', 'sw_woocommerce' ) => 'default',
				__( 'Slide', 'sw_woocommerce' ) => 'slide',
			),
			'description' => sprintf( __( 'Select different style best sale.', 'sw_woocommerce' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of products to slide', 'sw_woocommerce' ),
			'param_name' => 'item_slide',
			'admin_label' => true,
			"value" => 1,
			'dependency' => array(
					'element' => 'template',
					'value' => array( 'slide' ),
				)
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'sw_woocommerce' ),
			'param_name' => 'number',
			'admin_label' => true,
			"value" => 5,
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),	
	)
) );

/*
** Latest Reviews
*/
vc_map( array(
	"name" => __( "SW Latest Rating Slider", 'sw_woocommerce' ),
	"base" => "latest_rating",
	"icon" => "icon-wpb-ytc",
	"class" => "",
	"category" => __( "SW Shortcodes", 'sw_woocommerce'),
	"params" => array(
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Title", 'sw_woocommerce' ),
		"param_name" => "title",
		"admin_label" => true,
		"value" => '',
		"description" => __( "Title", 'sw_woocommerce' )
	 ),	
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Description", 'sw_woocommerce' ),
		"param_name" => "description",
		"admin_label" => true,
		"value" => '',
		"description" => __( "Description", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Rating Content Length", 'sw_woocommerce' ),
		"param_name" => "length",
		"admin_label" => true,
		"value" => 25,
		"description" => __( "Choose Rating Content Length if you want to trim word, leave 0 to not show content rating", 'sw_woocommerce' )
	),		
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number Of Post", 'sw_woocommerce' ),
		"param_name" => "numberposts",
		"admin_label" => true,
		"value" => 5,
		"description" => __( "Number Of Post", 'sw_woocommerce' )
	 ),	 
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number of Columns >1200px: ", 'sw_woocommerce' ),
		"param_name" => "columns",
		"admin_label" => true,
		"value" => array(1,2,3,4,5,6),
		"description" => __( "Number of Columns >1200px:", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
		"param_name" => "columns1",
		"admin_label" => true,
		"value" => array(1,2,3,4,5,6),
		"description" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
		"param_name" => "columns2",
		"admin_label" => true,
		"value" => array(1,2,3,4,5,6),
		"description" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
		"param_name" => "columns3",
		"admin_label" => true,
		"value" => array(1,2,3,4,5,6),
		"description" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
		"param_name" => "columns4",
		"admin_label" => true,
		"value" => array(1,2,3,4,5,6),
		"description" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Speed", 'sw_woocommerce' ),
		"param_name" => "speed",
		"admin_label" => true,
		"value" => 1000,
		"description" => __( "Speed Of Slide", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "dropdown",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Auto Play", 'sw_woocommerce' ),
		"param_name" => "autoplay",
		"admin_label" => true,
		"value" => array( 'False' => 'false', 'True' => 'true' ),
		"description" => __( "Auto Play", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Interval", 'sw_woocommerce' ),
		"param_name" => "interval",
		"admin_label" => true,
		"value" => 5000,
		"description" => __( "Interval", 'sw_woocommerce' )
	 ),
	 array(
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
		"param_name" => "scroll",
		"admin_label" => true,
		"value" => 1,
		"description" => __( "Total Items Slided", 'sw_woocommerce' )
	 ),
	 array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'sw_woocommerce' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
	),	
	)
 ) );
 
/*
** Banner Countdown
*/
vc_map( array(
	'name' => __( 'Sw Banner Countdown', 'sw_woocommerce' ),
	'base' => 'banner_countdown',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'sw_woocommerce' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Banner Countdown', 'sw_woocommerce' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'sw_woocommerce' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'sw_woocommerce' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'sw_woocommerce' )
		),
		array(
			'type' => 'textarea',
			'heading' => __( 'Description', 'sw_woocommerce' ),
			'param_name' => 'description',
			'description' => __( 'Description', 'sw_woocommerce' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Banner Images', 'sw_woocommerce' ),
			'param_name' => 'images',
			'description' => __( 'Select images', 'sw_woocommerce' )
		),
		array(
			'type' => 'date',
			'heading' => __( 'Countdown Date', 'sw_woocommerce' ),
			'param_name' => 'date',
			'description' => __( 'Countdown Date', 'sw_woocommerce' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Link for banner', 'sw_woocommerce' ),
			'param_name' => 'url',
			'description' => __( 'Each URL separated by commas', 'sw_woocommerce' )
		),
	)
) );
}
?>