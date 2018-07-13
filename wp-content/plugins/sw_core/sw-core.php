<?php
/**
 * Plugin Name: SW Core
 * Plugin URI: http://www.smartaddons.com
 * Description: A plugin developed for many shortcode in theme
 * Version: 1.4.1
 * Author: Smartaddons
 * Author URI: http://www.smartaddons.com
 * This Widget help you to show images of product as a beauty reponsive slider
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if( !function_exists( 'is_plugin_active' ) ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/* define plugin path */
if ( ! defined( 'SWPATH' ) ) {
	define( 'SWPATH', plugin_dir_path( __FILE__ ) );
}

/* define plugin URL */
if ( ! defined( 'SWURL' ) ) {
	define( 'SWURL', plugins_url(). '/sw_core' );
}

/* define options */
if ( !defined( 'ICL_LANGUAGE_CODE' ) && !defined('SW_THEME') ){
	define( 'SW_THEME', 'revo_theme' );
}else{
	define( 'SW_THEME', 'revo_theme'.ICL_LANGUAGE_CODE );
}

/* define plugin URL */
if ( ! defined( 'SW_OPTIONS_URL' ) ) {
	define( 'SW_OPTIONS_URL', SWURL . '/inc' );
}

/* define plugin URL */
if ( ! defined( 'SW_OPTIONS_DIR' ) ) {
	define( 'SW_OPTIONS_DIR', SWPATH . 'inc' );
}

function sw_core_construct(){
	/*
	** Require file
	*/
	
	require_once( SWPATH . 'inc/inc.php' );
	require_once( SWPATH . 'sw_plugins/sw-plugins.php' );
	
	if( class_exists( 'Vc_Manager' ) ){
		require_once ( SWPATH . '/visual-map.php' );
	}
	
	/*
	** Load text domain
	*/
	load_plugin_textdomain( 'sw_core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	
	/*
	** Call action and filter
	*/
	add_filter('style_loader_tag', 'sw_clean_style_tag');
	add_filter('widget_text', 'do_shortcode');
	add_action('init', 'sw_head_cleanup');
	add_action( 'wp_enqueue_scripts', 'Sw_AddScript', 20 );
}

add_action( 'plugins_loaded', 'sw_core_construct', 20 );

/**
 * Clean up output of stylesheet <link> tags
 */
function sw_clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
	$media = $matches[3][0] === 'print' ? ' media="print"' : '';
	return '<link rel="stylesheet" href="' . esc_url( $matches[2][0] ) . '"' . $media . '>' . "\n";
}

	

function sw_head_cleanup() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action('init', 'sw_head_cleanup');

function Sw_AddScript(){
	wp_register_style('ya_photobox_css', SWURL . '/css/photobox.css', array(), null);	
	wp_register_style('fancybox_css', SWURL . '/css/jquery.fancybox.css', array(), null);
	wp_register_style('shortcode_css', SWURL . '/css/shortcodes.css', array(), null);
	wp_register_script('photobox_js', SWURL . '/js/photobox.js', array(), null, true);
	wp_register_script('fancybox', SWURL . '/js/jquery.fancybox.pack.js', array(), null, true);
	wp_enqueue_style( 'fancybox_css' );
	wp_enqueue_style( 'shortcode_css' );
	wp_enqueue_script( 'fancybox' );
}