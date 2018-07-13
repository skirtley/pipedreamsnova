<?php 
/*
** Maintaince Function
*/

/*
** Maintaince Mode
*/
function revo_template_load( $template ){ 
	if( !is_user_logged_in() && sw_options('maintaince_enable') ){
		$template = SWPATH . 'inc/maintaince/maintaince.php';
	}
	return $template;
}
add_filter( 'template_include', 'revo_template_load' );

/*
** Maintaince Mode
*/
function sw_maintaince_script(){
	$output = '';
	$countdown = sw_options('maintaince_date');
	if( $countdown != '' ):
		$output .= 'jQuery(function($){
		"use strict";
		function revo_check_height(){
			var W_height = $( window ).height();
			if( W_height > 767) {
				setTimeout(function(){
					var cm_height = $( window ).height();
					var cm_target = $( "body > .body-wrapper" );
					cm_target.css( "height", cm_height );
				}, 1000);
			}
		}
		$(window).on( "load", function(){
			revo_check_height();
		});
			$(document).ready(function(){ 
				var end_date = new Date( "'. esc_js( $countdown ) .'" ).getTime()/1000;
				$("#countdown-container").ClassyCountdown({
					theme: "white", 
					end: end_date, 
					now: $.now()/1000,
					labelsOptions: {
						lang: {
						days: "'. esc_html__( 'Days', 'revo' ) .'",
						hours: "'. esc_html__( 'Hours', 'revo' ) .'",
						minutes: "'. esc_html__( 'Mins', 'revo' ) .'",
						seconds: "'. esc_html__( 'Secs', 'revo' ) .'"
						},
						style: "font-size: 0.5em;"
					},
				});
			});
		});';
	endif;
	
	wp_enqueue_style('countdown_css', SWURL . '/css/jquery.classycountdown.min.css', array(), null);
	wp_enqueue_style('maintaince_css', SWURL . '/css/style-maintaince.css', array(), null);
	wp_register_script('countdown', SWURL . '/js/maintaince/jquery.classycountdown.min.js', array(), null, true);
	wp_enqueue_script( 'knob', SWURL . '/js/maintaince/jquery.knob.js', array(), null, true);	
	wp_enqueue_script( 'throttle', SWURL . '/js/maintaince/jquery.throttle.js', array(), null, true);	
	wp_enqueue_script( 'countdown' );
	wp_add_inline_script( 'countdown', $output );
}

if( !is_user_logged_in() && sw_options('maintaince_enable') ){ 
	add_action( 'wp_enqueue_scripts', 'sw_maintaince_script' );
}