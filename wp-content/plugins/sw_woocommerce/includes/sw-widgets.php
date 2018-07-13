<?php 
/**
 * SW WooCommerce Widget Functions
 *
 * Widget related functions and widget registration
 *
 * @author 		flytheme
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {
	for ( $i = $pos; $i < count( $array ); $i ++ ) {
		if ( $array[ $i ]->parent == $parent_id ) {
			$name = str_repeat( '- ', $level ) . $array[ $i ]->name;
			$value = $array[ $i ]->slug;
			$dropdown[] = array(
				'label' => $name,
				'value' => $value,
			);
			getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
		}
	}
} */

include_once( 'sw-widgets/sw-brand.php' );
include_once( 'sw-widgets/sw-slider-widget.php' );
include_once( 'sw-widgets/sw-slider-countdown-widget.php' );
include_once( 'sw-widgets/sw-woo-tab-category-slider-widget.php' );
include_once( 'sw-widgets/sw-woo-tab-slider-widget.php' );
include_once( 'sw-widgets/sw-category-slider-widget.php' );
include_once( 'sw-widgets/sw-related-upsell-widget.php' );
include_once( 'sw-woocommerce-shortcodes.php' );

/**
 * Register Widgets
**/
function sw_register_widgets() {
	register_widget( 'sw_brand_slider_widget' );
	register_widget( 'sw_woo_slider_widget' );	
	register_widget( 'sw_woo_slider_countdown_widget' );	
	register_widget( 'sw_woo_tab_cat_slider_widget' );
	register_widget( 'sw_woo_tab_slider_widget' );
	register_widget( 'sw_woo_cat_slider_widget' );
	register_widget( 'sw_related_upsell_widget' );
}
add_action( 'widgets_init', 'sw_register_widgets' );

/*
** Get timezone offset for countdown
*/
function sw_timezone_offset( $countdowntime ){
	$timeOffset = 0;	
	if( get_option( 'timezone_string' ) != '' ) :
		$timezone = get_option( 'timezone_string' );
		$dateTimeZone = new DateTimeZone( $timezone );
		$dateTime = new DateTime( "now", $dateTimeZone );
		$timeOffset = $dateTimeZone->getOffset( $dateTime );
	else :
		$dateTime = get_option( 'gmt_offset' );
		$dateTime = intval( $dateTime );
		$timeOffset = $dateTime * 3600;
	endif;
	$offset =  ( $timeOffset < 0 ) ? '+' . gmdate( "H:i", abs( $timeOffset ) ) : '-' . gmdate( "H:i", $timeOffset );
	$date = date( 'Y/m/d H:i:s', $countdowntime );
	$date1 = new DateTime( $date );
	$cd_date =  $date1->format('Y-m-d H:i:s') . $offset;
	return strtotime( $cd_date ); 
}

/*
** Sales label
*/
if( !function_exists( 'sw_label_sales' ) ){
	function sw_label_sales(){
		global $product, $post;
		$product_type = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_type() : $product->product_type;
		echo sw_label_new();
		if( $product_type != 'variable' ) {
			$forginal_price 	= get_post_meta( $post->ID, '_regular_price', true );	
			$fsale_price 		= get_post_meta( $post->ID, '_sale_price', true );
			if( $fsale_price > 0 && $product->is_on_sale() ){ 
				$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
				$html = '<div class="sale-off ' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
				$html .= '-' . round( $sale_off ).'%';
				$html .= '</div>';
				echo apply_filters( 'sw_label_sales', $html );
			} 
		}else{
			echo '<div class="' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
			wc_get_template( 'single-product/sale-flash.php' );
			echo '</div>';
		}
	}	
}

/*
** Check quickview
*/
function sw_quickview(){
	global $product;
	$quickview = 1;
	if( function_exists( 'sw_options' ) ){
		$quickview = sw_options( 'product_quickview' );
	}
	if( $quickview ):
		return '<a href="javascript:void(0)" data-product_id="'. esc_attr( $product->get_id() ) .'" class="sw-quickview" data-type="quickview" data-ajax_url="' . WC_AJAX::get_endpoint( "%%endpoint%%" ) . '">'. esc_html__( 'Quick View ', 'sw_woocommerce' ) .'</a>';	
	endif;
}

/*
** Trim Words
*/
function sw_trim_words( $title, $title_length = 0 ){
	$html = '';
	if( $title_length > 0 ){
		$html .= wp_trim_words( $title, $title_length, '...' );
	}else{
		$html .= $title;
	}
	echo esc_html( $html );
}

/*
** Sw Ajax URL
*/
function sw_ajax_url(){
	$ajaxurl = version_compare( WC()->version, '2.4', '>=' ) ? WC_AJAX::get_endpoint( "%%endpoint%%" ) : admin_url( 'admin-ajax.php', 'relative' );
	return $ajaxurl;
}

/*
** Check override template
*/
function sw_override_check( $path, $file ){
	$paths = '';
	if( locate_template( 'sw_woocommerce/'.$path . '/' . $file ) ){
		$paths = get_template_directory() . '/sw_woocommerce/' . $path . '/' . $file . '.php';
	}else{
		$paths = WCTHEME . '/' . $path . '/' . $file . '.php';
	}
	return $paths;
}

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'sw_woocommerce_version_check' ) ) :
	function sw_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;

/*
** Convert Time to second
*/
function sw_convert_time( $str_time ){
	$str_time = explode( ':', $str_time );
	$time = 0;
	if( sizeof( $str_time ) > 0 ){
		foreach( $str_time as $key => $time ){
			$time = isset( $str_time[1] ) ? ( $str_time[0] * 3600 + $str_time[1] * 60 ) : ( $str_time[0] * 3600 );
		} 
	}
	return $time;
}

/*
** Hook to price schedule
*/
add_action( 'woocommerce_product_options_pricing', 'sw_custom_schedule_time', 1 );
add_action( 'save_post', 'sw_custom_countdown_meta', 10, 1 );
function sw_custom_schedule_time(){
	global $post;
	wp_nonce_field( 'sw_custom_countdown_meta', 'sw_custom_countdown_nonce' );
	$sale_price_time_from = get_post_meta( $post->ID, '_sale_price_time_from', true );
	$sale_price_time_to   = get_post_meta( $post->ID, '_sale_price_time_to', true );
	$start_date 		  = get_post_meta( $post->ID, '_sale_price_dates_from', true );
	$countdown_date 	  = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
	
	$attribute = ( $start_date != '' || $countdown_date ) ? 'style="display: block;"' : 'style="display: none;"';
	echo '<p class="form-field sale_price_time_fields" '. $attribute .'>';
	echo '<label for="_sale_price_time_from">' . esc_html__( 'Sale price time', 'sw_woocommerce' ) . '</label>';
	echo '<input type="text" class="short_time" name="_sale_price_time_from" id="_sale_price_time_from" value="'. esc_attr( str_replace( ':', ' : ', $sale_price_time_from ) ) .'" placeholder="' . esc_attr__( 'From g:i', 'sw_woocommerce' ) . '"/></br>';
	echo '<input type="text" class="short_time" name="_sale_price_time_to" id="_sale_price_time_to" value="'. esc_attr( str_replace( ':', ' : ', $sale_price_time_to ) ) .'" placeholder="' . esc_attr__( 'To g:i', 'sw_woocommerce' ) . '"/>';
	echo '</p>';
	wp_enqueue_style( 'timepicker_style', WCURL . '/css/admin/timepicker.css' );
	wp_enqueue_script( 'timepicker',  WCURL . '/js/admin/timepicki.min.js', array(), null, true );
}

function sw_custom_countdown_meta( $post_id ){
	if ( ! isset( $_POST['sw_custom_countdown_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['sw_custom_countdown_nonce'], 'sw_custom_countdown_meta' ) ) {
		return;
	}
	$current_screen = isset( get_current_screen()->post_type ) ? get_current_screen()->post_type : '';
	if( $current_screen != 'product' ){
		return;
	}

	$start_date 	= get_post_meta( $post_id, '_sale_price_dates_from', true );
	$countdown_date = get_post_meta( $post_id, '_sale_price_dates_to', true );	
	
	
	$start_hour		= isset( $_POST['_sale_price_time_from'] ) ? $_POST['_sale_price_time_from'] : '';
	$countdown_hour = isset( $_POST['_sale_price_time_to'] ) ? $_POST['_sale_price_time_to'] : '';
	
	if( $start_date != '' ) :
		update_post_meta( $post_id, '_sale_price_time_from', str_replace( ' ', '', $start_hour ) );
		update_post_meta( $post_id, '_sale_price_dates_from', str_replace( ' ', '', $start_date + sw_convert_time( $start_hour ) ) );
	else:
		delete_post_meta( $post_id, '_sale_price_time_from' );
	endif;
	
	if( $start_date != '' ) :
		update_post_meta( $post_id, '_sale_price_time_to', str_replace( ' ', '', $countdown_hour ) );
		update_post_meta( $post_id, '_sale_price_dates_to', str_replace( ' ', '', $countdown_date + sw_convert_time( $countdown_hour ) ) );
	else:
		delete_post_meta( $post_id, '_sale_price_time_to' );
	endif;
}

/*
** Check Visible
*/
function sw_check_product_visiblity( $query ) {
	$query['tax_query']['relation'] = 'AND';
	$product_visibility_terms  = wc_get_product_visibility_term_ids();
	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$product_visibility_not_in[] = $product_visibility_terms['outofstock'];
	}
	if ( ! empty( $product_visibility_not_in ) ) {
		$query['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => $product_visibility_not_in,
			'operator' => 'NOT IN',
		);
	}
	return $query;
}

/*
** Add Label New and SoldOut
*/
if( !function_exists( 'sw_label_new' ) ){
	function sw_label_new(){
		if( !current_theme_supports( 'sw_theme' ) ) {
			return;
		}
		global $product;
		$html = '';
		$newtime = ( get_post_meta( $product->get_id(), 'newproduct', true ) != '' && get_post_meta( $product->get_id(), 'newproduct', true ) ) ? get_post_meta( $product->get_id(), 'newproduct', true ) : sw_options( 'newproduct_time' );
		$product_date = get_the_date( 'Y-m-d', $product->get_id() );
		$newdate = strtotime( $product_date ) + intval( $newtime ) * 24 * 3600;
		if( ! $product->is_in_stock() ) :
			$html .= '<span class="sw-outstock">'. esc_html__( 'Out Stock', 'sw_woocommerce' ) .'</span>';		
		else:
			if( $newtime != '' && $newdate > time() ) :
				$html .= '<span class="sw-newlabel">'. esc_html__( 'New', 'sw_woocommerce' ) .'</span>';			
			endif;
		endif;
		return apply_filters( 'sw_label_new', $html );
	}
}