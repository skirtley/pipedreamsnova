<?php 
/**
* Admin Settings for SW WooSwatches
**/


class SW_WooSwatches_Admin_Settings{
	public static function init(){
		add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
		add_action( 'woocommerce_settings_tabs_settings_sw_wooswatches', __CLASS__ . '::settings_tab' );
		add_action( 'woocommerce_update_options_settings_sw_wooswatches', __CLASS__ . '::update_settings' );
		if( get_option( 'sw_wooswatches_enable' ) === 'yes' ) :
			add_filter( 'woocommerce_product_data_tabs', __CLASS__ . '::add_wooswatches_product_data_tab', 999 );
			add_action( 'woocommerce_product_data_panels',  __CLASS__ . '::add_wooswatches_product_data_fields' );
			add_action( 'woocommerce_process_product_meta',  __CLASS__ . '::save_wooswatches_product_data_fields', 10, 2 );
			add_action( 'admin_print_scripts-post.php', __CLASS__ . '::sw_wooswatches_admin_script', 11 );
		endif;

		//add custom type
		// add_action( 'woocommerce_admin_field_custom_type', __CLASS__ . '::output_custom_type', 10, 1 );
	}
	
	public static function sw_wooswatches_admin_script(){
		global $post_type;	
		if( 'product' == $post_type ){
			wp_enqueue_script( 'swatches_admin_js', WSURL . '/js/admin/swatches-admin.js' , array(), null, true );
			wp_enqueue_style( 'swatches_admin_style', WSURL . '/css/admin/wooswatches-style.css' , array(), null );
			wp_enqueue_script('category_color_picker_js', WSURL . '/js/admin/category_color_picker.js', array( 'wp-color-picker' ), false, true);
		}
	}
	
	/**
		* Add a new settings tab to the WooCommerce settings tabs array.
		*
		* @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
		* @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	*/
	public static function add_settings_tab($settings_tabs ) {
		$settings_tabs['settings_sw_wooswatches'] = __( 'Sw WooSwatches', 'sw_wooswatches' );
		return $settings_tabs;
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
		*
		* @uses woocommerce_admin_fields()
		* @uses self::get_settings()
	*/
	public static function settings_tab(){
		woocommerce_admin_fields( self::get_settings() );
	}
	
	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	*/
	public static function update_settings() {
		woocommerce_update_options( self::get_settings() );			
	}
	
	/**
	* Declare option for Sw WooSwatches Settings
	**/
	public static function get_settings(){
		$settings = array(
			'section_title' => array(
				'name'     => __( 'SW WooCommerce Swatches Settings', 'sw_wooswatches' ),
				'type'     => 'title',
				'desc'     => '',
				'id'       => 'wc_setting_section_title'
			),
			
			array(
				'title'         => __( 'Enable Swatches Variation', 'sw_wooswatches' ),
				'desc'          => __( 'Uncheck this checkbox to disable WooCommerce Swatches Variation', 'sw_wooswatches' ),
				'id'            => 'sw_wooswatches_enable',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'autoload'      => true,
			),
			
			array(
				'title'         => __( 'Enable Swatches Variation Listing', 'sw_wooswatches' ),
				'desc'          => __( 'Check this field to enable swatches variation on product listing.', 'sw_wooswatches' ),
				'id'            => 'sw_wooswatches_enable_listing',
				'default'       => 'no',
				'type'          => 'checkbox',
			),
			
			array(
				'title'         => __( 'Enable Tooltip', 'sw_wooswatches' ),
				'desc'          => __( 'Check in this field to enable tooltip on swatches variation.', 'sw_wooswatches' ),
				'id'            => 'sw_wooswatches_tooltip_enable',
				'default'       => 'no',
				'type'          => 'checkbox',
			),
			
			array(
				'title'    => __( 'Image Tooltip Size', 'sw_wooswatches' ),
				'desc'     => __( 'Choose image size when tooltip show.', 'sw_wooswatches' ),
				'id'       => 'sw_wooswatches_tooltip_size',
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width:300px;',
				'default'  => '',
				'type'     => 'select',
				'options'  => array(
					'shop_catalog'  => __( 'Shop Catalog', 'sw_wooswatches' ),
					'shop_single' 	=> __( 'Shop Single', 'sw_wooswatches' ),
					'full'          => __( 'Full', 'sw_wooswatches' ),
				),
				'desc_tip' => true,
			),
						
			array(
				'title'    => __( 'Product Variation Width', 'sw_wooswatches' ),
				'desc'     => __( 'px', 'sw_wooswatches' ),
				'id'       => 'sw_wooswatches_w_size',
				'css'      => '',
				'type'     => 'number',
				'default'	 => 40
			),
			
			array(
				'title'    => __( 'Product Variation Height', 'sw_wooswatches' ),
				'desc'     => __( 'px', 'sw_wooswatches' ),
				'id'       => 'sw_wooswatches_h_size',
				'css'      => '',
				'type'     => 'number',
				'default'	 => 40
			),
			
			array( 'type' => 'sectionend', 'id' => 'wc_setting_section_endpoint' ),
		);
		return apply_filters( 'sw_wooswatches_settings', $settings );
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_product_data_tabs() function.
	*/
	public static function add_wooswatches_product_data_tab( $product_data_tabs ){
		
		$product_data_tabs['sw_wooswatches'] = array(
			'label' => __( 'Sw WooSwatches', 'sw_wooswatches' ),
			'target' => 'sw_wooswatches_data',
			'priority' => 999,
			'class'    => array( 'show_if_variable' ),
		);
		return $product_data_tabs;
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_product_data_panels() function.
	*/
	public static function add_wooswatches_product_data_fields(){
		global $post;
		$product       = wc_get_product($post->ID);		  
		$product_type  =  $product->get_type();
		
		$meta_variation_check = get_post_meta( $post->ID,  'sw_variation_check', true );
		$meta_variation       = get_post_meta( $post->ID,  'sw_variation', true ); 
		
		if( $product_type == 'variable' ) :
			$product = new WC_Product_Variable( $post->ID );
	    $attributes = $product->get_variation_attributes();
		endif;
		
		
		if( !empty( $attributes ) && sizeof( $attributes ) > 0 ) :
			include( WSPATH. '/admin/admin-metabox.php' ); /* include metabox product variation */
		endif;
	}	
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_process_product_meta() function.
	*/
	function save_wooswatches_product_data_fields( $post_id ){
		$variation_check = ( isset( $_POST['sw_variation_check'] ) ) ? $_POST['sw_variation_check'] : array();
		update_post_meta( $post_id, 'sw_variation_check', $variation_check );
		
		if( isset( $_POST['sw_variation'] ) ){
			update_post_meta( $post_id, 'sw_variation', $_POST['sw_variation'] );
		}
	}
}

SW_WooSwatches_Admin_Settings::init();