<?php 
/**
 * Plugin Name: Sw Woocommerce Swatches
 * Plugin URI: http://www.smartaddons.com/
 * Description: A plugin help to display woocommerce beauty.
 * Version: 1.0.4
 * Author: SmartAddons
 * Author URI: http://www.smartaddons.com/
 * Requires at least: 4.1
 * Tested up to: WorPress 4.8.x and WooCommerce 3.2.x
 * WC tested up to: 3.3.0
 * Text Domain: sw_wooswatches
 * Domain Path: /languages/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// define plugin path
if ( ! defined( 'WSPATH' ) ) {
	define( 'WSPATH', plugin_dir_path( __FILE__ ) );
}

// define plugin URL
if ( ! defined( 'WSURL' ) ) {
	define( 'WSURL', plugins_url(). '/sw_wooswatches' );
}

// define plugin theme path
if ( ! defined( 'WSTHEME' ) ) {
	define( 'WSTHEME', plugin_dir_path( __FILE__ ). 'includes/themes' );
}

function sw_wooswatches_construct(){
	global $woocommerce;

	if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'sw_wooswatches_admin_notice' );
		return;
	}
	
	/* Enqueue Script */
	add_action( 'wp_enqueue_scripts', 'sw_wooswatches_custom_script', 1001 );
	
	/* Load text domain */
	load_plugin_textdomain( 'sw_wooswatches', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	
	/* Include files */
	require_once( WSPATH . '/admin/admin-settings.php' );
	require_once( WSPATH . '/admin/admin-attribute-metabox.php' );
	require_once( WSPATH . '/includes/product-variation.php' );
}

add_action( 'plugins_loaded', 'sw_wooswatches_construct', 20 );


/*
** Load admin notice when WooCommerce not active
*/
function sw_wooswatches_admin_notice(){
	?>
	<div class="error">
		<p><?php _e( 'Sw WooSwatches is enabled but not effective. It requires WooCommerce in order to work.', 'sw_wooswatches' ); ?></p>
	</div>
<?php
}

/*
** Load Custom variation script
*/
function sw_wooswatches_custom_script(){	
	if( current_theme_supports( 'sw_theme' ) || get_option( 'sw_wooswatches_enable' ) === 'yes' ) :
		wp_dequeue_script('wc-add-to-cart-variation');	
		wp_dequeue_script('wc-single-product');
		wp_deregister_script('wc-add-to-cart-variation');
		wp_deregister_script('wc-single-product');
		$w_folder = ( ! current_theme_supports( 'sw_theme' ) ) ? 'woocommerce' : 'woocommerce/custom';
		if( get_option( 'sw_wooswatches_enable' ) === 'no' ){
			$w_folder = 'woocommerce-select';
		}

		wp_enqueue_style( 'sw-wooswatches', plugins_url( 'css/style.css', __FILE__ ), array(), null );	
		wp_enqueue_script( 'wc-single-product', WSURL . '/js/'. $w_folder .'/single-product.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'wc-add-to-cart-variation', WSURL . '/js/'. $w_folder .'/add-to-cart-variation.min.js', array( 'jquery', 'wp-util' ),null, true  );
	endif;
}