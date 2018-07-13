<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function revo_scripts() {	
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : sw_options('scheme');
	$revo_direction = sw_options('direction');
	
	$app_css 	= get_template_directory_uri() . '/css/app-default.css';
	$mobile_css = get_template_directory_uri() . '/css/mobile/mobile-default.css';
	if ( $scheme ){
		$app_css 	= get_template_directory_uri() . '/css/app-'.$scheme.'.css';
		$mobile_css = get_template_directory_uri() . '/css/mobile-'.$scheme.'.css';
		
	} 
	wp_dequeue_style('fontawesome');
	wp_dequeue_style('slick_slider_css');
	wp_dequeue_style('fontawesome_css');
	wp_dequeue_style('shortcode_css');
	wp_dequeue_style('yith-wcwl-font-awesome');
	wp_dequeue_style('tabcontent_styles');	
	
	/* enqueue script & style */
	if ( !is_admin() ){			
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);	
		wp_enqueue_style('revo_css', $app_css, array(), null);
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/jquery.plugin.min.js', array('jquery'), null, true);
		wp_enqueue_script('loadimage', get_template_directory_uri() . '/js/load-image.min.js', array('jquery'), null, true);
		wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
		wp_enqueue_script('slick_slider',get_template_directory_uri().'/js/slick.min.js',array(),null,true);
		wp_enqueue_script('isotope_script', get_template_directory_uri() . '/js/isotope.js', array(), null, true);
		wp_enqueue_script('wc-quantity', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
		
		if( is_rtl() || $revo_direction == 'rtl' ){
			wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css', array(), null);
		}
		wp_enqueue_style('revo_responsive_css', get_template_directory_uri() . '/css/app-responsive.css', array(), null);
		
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('revo_child_css', get_stylesheet_uri(), false, null);
		}
		
		if( !wp_script_is( 'jquery-cookie' ) ){
			wp_enqueue_script('plugins_js');
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	if ( !is_admin() ){
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
		
		$translation_text = array(
			'cart_text' 		 => esc_html__( 'Add To Cart', 'revo' ),
			'compare_text' 	 => esc_html__( 'Add To Compare', 'revo' ),
			'wishlist_text'  => esc_html__( 'Add To WishList', 'revo' ),
			'quickview_text' => esc_html__( 'QuickView', 'revo' ),
			'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
			'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
			'message' => esc_html__( 'Please enter your usename and password', 'revo' ),
		);
		
		wp_localize_script( 'revo_custom_js', 'custom_text', $translation_text );
		wp_enqueue_script( 'revo_custom_js', get_template_directory_uri() . '/js/main.js', array(), null, true );
	}
	
	/*
	** Dequeue and enqueue css, js mobile
	*/
	if( revo_mobile_check() ) :
		if( is_front_page() || is_home() ) :
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		endif;
		if( !sw_options( 'mobile_jquery' ) ){
			wp_dequeue_script( 'tp-tools' );
			wp_dequeue_script( 'revmin' );
		}
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope_script' );		
		wp_dequeue_script( 'revo_megamenu' );
		wp_dequeue_script( 'moneyjs' );
		wp_dequeue_script( 'accountingjs' );
		wp_dequeue_script( 'wc_currency_converter' );
		wp_dequeue_script( 'yith-woocompare-main' );
		wp_enqueue_style('mobile_css', $mobile_css, array(), null);
	endif;
	
	/*
	** Dequeue some css and jquery mobile responsive
	*/
	
	global $sw_detect;
	if( !empty( $sw_detect ) && $sw_detect->isMobile() && !$sw_detect->isTablet() ){
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope_script' );
		wp_dequeue_script( 'revo_megamenu' );
		wp_dequeue_script( 'yith-woocompare-main' );
		wp_enqueue_script( 'revo_mobile_js', get_template_directory_uri(). '/js/mobiles.js', array(), null, true);	
		if( !is_singular( 'product' ) ){
			wp_dequeue_script( 'slick_slider' );
		}
	}
}
add_action('wp_enqueue_scripts', 'revo_scripts', 100);
