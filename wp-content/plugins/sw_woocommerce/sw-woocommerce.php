<?php 
/**
 * Plugin Name: Sw Woocommerce
 * Plugin URI: http://www.smartaddons.com/
 * Description: A plugin help to display woocommerce beauty.
 * Version: 1.6.0
 * Author: SmartAddons
 * Author URI: http://www.smartaddons.com/
 * Requires at least: 4.1
 * Tested up to: WorPress 4.9.x and WooCommerce 3.3.x
 *
 * Text Domain: sw_woocommerce
 * Domain Path: /languages/
 * WC tested up to: 3.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// define plugin path
if ( ! defined( 'WCPATH' ) ) {
	define( 'WCPATH', plugin_dir_path( __FILE__ ) );
}

// define plugin URL
if ( ! defined( 'WCURL' ) ) {
	define( 'WCURL', plugins_url(). '/sw_woocommerce' );
}

// define plugin theme path
if ( ! defined( 'WCTHEME' ) ) {
	define( 'WCTHEME', plugin_dir_path( __FILE__ ). 'includes/themes' );
}

if( !function_exists( 'is_plugin_active' ) ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function sw_woocommerce_construct(){
	global $woocommerce;

	if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'sw_woocommerce_admin_notice' );
		return;
	}
	
	add_action( 'wp_enqueue_scripts', 'sw_enqueue_script', 99 );
	if( current_theme_supports( 'sw_theme' ) ):
		add_action( 'wp_enqueue_scripts', 'sw_custom_product_scripts', 1000 );
	endif;

	/* Load text domain */
	load_plugin_textdomain( 'sw_woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	
	if ( class_exists( 'Vc_Manager' ) ) {
		add_action( 'vc_frontend_editor_render', 'Sw_EnqueueJsFrontend' );
	}

	
	/* Include Widget File and hook */
	require_once( WCPATH . '/includes/sw-widgets.php' );
}
add_action( 'plugins_loaded', 'sw_woocommerce_construct', 20 );

/*
** Load script frontend edit by visual
*/
function Sw_EnqueueJsFrontend(){
	wp_register_script( 'slick_slider', plugins_url( 'js/slick.min.js', __FILE__ ),array(), null, true );	
	wp_register_script( 'custom_js', plugins_url( 'js/custom_js.js', __FILE__ ),array( 'slick_slider' ), null, true );	
	wp_enqueue_script('custom_js');
}

/*
** Load script
*/
function sw_enqueue_script(){	
	wp_register_style( 'slick_slider_css', plugins_url('css/slider.css', __FILE__) );
	if (!wp_style_is('slick_slider_css')) {
		wp_enqueue_style('slick_slider_css'); 
	}
	wp_register_style( 'fontawesome_css', plugins_url('css/font-awesome.min.css', __FILE__) );
	if (!wp_style_is('fontawesome_css')) {
		wp_enqueue_style('fontawesome_css'); 
	} 
	wp_register_script( 'slick_slider', plugins_url( 'js/slick.min.js', __FILE__ ),array(), null, true );		
	if (!wp_script_is('slick_slider')) {
		wp_enqueue_script('slick_slider');
	}
	$sw_countdown_text = array(
		'day' 		 => esc_html__( 'days', 'sw_woocommerce' ),
		'hour' 		 => esc_html__( 'hours', 'sw_woocommerce' ),
		'min'		 => esc_html__( 'mins', 'sw_woocommerce' ),
		'sec' 	 => esc_html__( 'secs', 'sw_woocommerce' ),
	);
	
	wp_register_script( 'countdown_slider_js', plugins_url( 'js/jquery.countdown.min.js', __FILE__ ),array(), null, true );	
	wp_localize_script( 'countdown_slider_js', 'sw_countdown_text', $sw_countdown_text );
	if (!wp_script_is('countdown_slider_js')) {
		wp_enqueue_script('countdown_slider_js');
	}		
	wp_dequeue_script('wc-cart');
	wp_deregister_script('wc-cart');
	wp_enqueue_script( 'wc-cart', plugins_url( 'js/cart.min.js', __FILE__ ), array( 'jquery' ), null, true );
}

/*
** Load Custom variation script
*/
function sw_custom_product_scripts(){	
	$dest_folder = 'woocommerce_select';
	
	wp_dequeue_script('wc-add-to-cart-variation');	
	wp_dequeue_script('wc-single-product');
	wp_deregister_script('wc-add-to-cart-variation');
	wp_deregister_script('wc-single-product');
	wp_enqueue_script( 'wc-single-product', plugins_url( 'js/'. $dest_folder .'/single-product.min.js', __FILE__ ), array( 'jquery' ), null, true );
	wp_enqueue_script( 'wc-add-to-cart-variation', plugins_url( 'js/'. $dest_folder .'/add-to-cart-variation.min.js', __FILE__ ), array( 'jquery', 'wp-util' ),null, true  );
}

/*
** Load admin notice when WooCommerce not active
*/
function sw_woocommerce_admin_notice(){
	?>
	<div class="error">
		<p><?php _e( 'Sw Woocommerce is enabled but not effective. It requires WooCommerce in order to work.', 'sw_woocommerce' ); ?></p>
	</div>
<?php
}