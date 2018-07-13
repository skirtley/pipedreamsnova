<?php
/**
 * revo initial setup and constants
 */
function revo_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'revo', get_template_directory() . '/lang' );

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus(array(
		'primary_menu' => esc_html__('Primary Menu', 'revo'),
		'primary_menu1' => esc_html__('Primary Menu1', 'revo'),
		'vertical_menu' => esc_html__( 'Vertical Menu', 'revo' ),
		'vertical_menu1' => esc_html__( 'Vertical Menu 1', 'revo' ),
		'mobile_menu1' => esc_html__( 'Mobile Menu 1', 'revo' ),
		'mobile_menu2' => esc_html__( 'Mobile Menu 2', 'revo' ),
		'mobile_menu3' => esc_html__( 'Mobile Menu 3', 'revo' ),
		'mobile_menu4' => esc_html__( 'Mobile Menu 4', 'revo' ),
	));
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'sw_theme' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	if( sw_options( 'product_zoom' ) ) :
		add_theme_support( 'wc-product-gallery-zoom' );
	endif;
	
	add_image_size( 'revo_blog-responsive1', 370, 240, true );
	add_image_size( 'revo_blog-responsive2', 568, 300, true );
	add_image_size( 'revo_shop-image', 600, 800, true );
	add_image_size( 'revo_shop-image2', 600, 700, true );
	add_image_size( 'revo_detail_thumb', 870, 450, true );
	add_image_size( 'revo_thumbnail_mobile', 140, 180, true );
	add_image_size( 'revo_blog_mobile', 460, 240, true );
	add_image_size( 'revo_blog_home10', 280, 250, true );
	add_image_size( 'revo_related_mobile', 115, 60, true );
	add_image_size( 'revo_cat_thumb_mobile', 210, 270, true );
	
	add_theme_support( "title-tag" );
	
	add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
	
	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support('post-thumbnails');

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	
	// Custom image header
	$revo_header_arr = array(
		'default-image' => get_template_directory_uri().'/assets/img/logo-default.png',
		'uploads'       => true
	);
	add_theme_support( 'custom-header', $revo_header_arr );
	
	// Custom Background 
	$revo_bgarr = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);
	add_theme_support( 'custom-background', $revo_bgarr );
	
	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( 'css/editor-style.css' );
	
	new Revo_Menu();
}
add_action('after_setup_theme', 'revo_setup');

