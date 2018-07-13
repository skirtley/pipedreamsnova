<?php 
/*
** Mobile Layout 
*/
require_once( get_template_directory().'/lib/mobile-detect.php' );


/*
** Check Header Mobile or Desktop
*/
function revo_header_check(){ 	
	if( get_post_meta( get_the_ID(), 'page_header_hide', true ) && ( is_page() || is_single() ) ){
		return ;
	}
	$mobile_header = ( get_post_meta( get_the_ID(), 'page_mobile_header', true ) != '' && is_page() ) ? get_post_meta( get_the_ID(), 'page_mobile_header', true ) : sw_options( 'mobile_header_style' );
	$page_header   = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' && ( is_page() || is_single() ) ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	$header_style  = ( $page_header ) ? $page_header : 'style1';
	/* 
	** Display header or not 
	*/
	if( get_post_meta( get_the_ID(), 'page_header_hide', true ) ) :
		return ;
	endif;
	if( revo_mobile_check() ):
		get_template_part( 'mlayouts/header', $mobile_header );
	else: 
		get_template_part( 'templates/header', $header_style );
	endif;
}

/*
** Check Footer Mobile or Desktop
*/
function revo_footer_check(){
	if( get_post_meta( get_the_ID(), 'page_footer_hide', true ) && ( is_page() || is_single() ) ){
		return ;
	}
	$mobile_footer = ( get_post_meta( get_the_ID(), 'page_mobile_footer', true ) != '' && ( is_page() || is_single() ) ) ? get_post_meta( get_the_ID(), 'page_mobile_footer', true ) : sw_options( 'mobile_footer_style' );
	if( revo_mobile_check() && $mobile_footer != '' ):
		get_template_part( 'mlayouts/footer', $mobile_footer );
	else: 
		get_template_part( 'templates/footer' );
	endif;
}

/*
** Check Content Page Mobile or Desktop
*/
function revo_pagecontent_check(){
	$mobile_content = sw_options( 'mobile_content' );
	if( revo_mobile_check() && $mobile_content != '' && is_front_page() ):
		echo sw_get_the_content_by_id( $mobile_content );
	else: 
		the_content();
	endif;
}

/*
** Check Product Listing Mobile or Desktop
*/
function revo_product_listing_check(){
	if( revo_mobile_check() ) :
		get_template_part('mlayouts/archive','product-mobile');
	else: 
		 wc_get_template( 'archive-product.php' );
	endif;
}

/*
** Check Product Listing Mobile or Desktop
*/
function revo_blog_listing_check(){
	if( revo_mobile_check()  ) :
		get_template_part('mlayouts/archive', 'mobile');
	else: 
		get_template_part( 'templates/content' );
	endif;		
}

/*
** Check Product Detail Mobile or Desktop
*/
function revo_product_detail_check(){
	if( revo_mobile_check()  ) :
		get_template_part('mlayouts/single','product');
	else: 
		 wc_get_template( 'single-product.php' );
	endif;
}

/*
** Check Product Detail Mobile or Desktop
*/
function revo_content_detail_check(){
	if( revo_mobile_check() ) :
		get_template_part('mlayouts/single','mobile');
	else: 
		 get_template_part('templates/content', 'single');
	endif;		
}

/*
** Product Meta
*/
if( !function_exists( 'revo_mobile_check' ) ){
	function revo_mobile_check(){
		global $sw_detect;
		
		$sw_demo   		  = get_option( 'sw_mdemo' );
		$mobile_check   = sw_options( 'mobile_enable' );
		
		if( $sw_demo == 1 ) :
			return true;
		endif;
		
		if( !empty( $sw_detect ) && $mobile_check && $sw_detect->isMobile() && !$sw_detect->isTablet() ) :
			return true;
		else: 
			return false;
		endif;
		return false;
	}
}

/*
** Number of post for a WordPress archive page
*/
function revo_Per_category_basis($query){
    if ( ( $query->is_category ) ) {
        /* set post per page */
        if ( is_archive() && revo_mobile_check() ){
            $query->set('posts_per_page', 3);
        }
    }
    return $query;

}
add_filter('pre_get_posts', 'revo_Per_category_basis');


