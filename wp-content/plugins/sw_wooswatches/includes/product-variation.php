<?php 
/*
** Product variation hook
*/

/* check if wooswatches not enable */
if( get_option( 'sw_wooswatches_enable' ) === 'no' ) :
	return;
endif;

class SW_WooSwatches_Frontend{
	public function __construct(){
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'sw_woocommerce_custom_variation' ), 10, 2 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'sw_wooswatches_custom_variation_listing' ), 200 );
		add_action( 'sw_wooswatches_custom', array( $this, 'sw_wooswatches_custom_variation_custom' ), 200 );
	}
	
	/**
	* Single Product Variation
	**/
	function sw_woocommerce_custom_variation( $html, $args ){
		global $post;	
		$options   = $args['options'];
		$product   = $args['product'];
		$attribute = $args['attribute'];
		$name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class     = $args['class'];
		
		$meta_variation_check = get_post_meta( $post->ID,  'sw_variation_check', true );
		$meta_variation       = get_post_meta( $post->ID,  'sw_variation', true ); 
			
		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}	
		
		$html = '';
		if ( ! empty( $options ) ) {
			$attr 		= '';
			$img_size = ( get_option( 'sw_wooswatches_tooltip_size' ) ) ? get_option( 'sw_wooswatches_tooltip_size' ) : 'shop_catalog';
			$html 	 .= '<div class="sw-custom-variation">';			
			$width 		= ( get_option( 'sw_wooswatches_w_size' ) ) ? get_option( 'sw_wooswatches_w_size' ) : 0;
			$height		= ( get_option( 'sw_wooswatches_h_size' ) ) ? get_option( 'sw_wooswatches_h_size' ) : 0;
			
			$wh_attr  = ( $width && $height ) ? 'style="width:'. esc_attr( $width ) .'px; height: '. esc_attr( $height ) .'px;" ' : '' ;
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );								
				foreach ( $terms as $key => $term ) {
					$color  	= get_term_meta( $term->term_id, 'sw_variation_color', true );
					$thumb_id = absint( get_woocommerce_term_meta( $term->term_id, 'variation_thumbnail_id', true ) );
					$active 	= ( checked( sanitize_title( $args['selected'] ), $term->slug, false ) ) ? ' selected' : '';				
					$attr 		= ( $color != '' ) ? 'class="variation-color" style="background-color: '. esc_attr( $color ) .';"' : '';
					$parent_attr = '';
					if( $thumb_id ){					
						$attr 				= ( $thumb_id ) ? 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $thumb_id ) ) .' );"' : '';
						$img_url			= wp_get_attachment_image_src( $thumb_id, $img_size );
						$parent_attr  = ( get_option( 'sw_wooswatches_tooltip_enable' ) ) ? 'data-toogle="tooltip" data-img="'. esc_url( $img_url[0] ).'" data-width="' . esc_attr( $img_url[1] ) . '" data-height="' . esc_attr( $img_url[2] ) . '"' : '';				
					}
					$parent_attr   .= $wh_attr;
					if ( in_array( $term->slug, $options ) ) {
						$html .= '<label class="radio-label sw-radio-variation sw-radio-variation-'. esc_attr( $key .' '. $active ) .'" title="'. esc_attr( $term->slug )  .'" for="'. esc_attr( $term->slug . '_' . $key ) . '" '. $parent_attr .'>';
						$html .= '<input type="radio" id="'.  esc_attr( $term->slug . '_' . $key ) .'" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" value="' . esc_attr( $term->slug ) . '" '. checked( sanitize_title( $args['selected'] ), $term->slug, false ) .'/>';
						$html .= '<span '. $attr .'>'. $term->name .'</span>';
						$html .= '</label>';
					}
				}			
			}else {
				$variation_check = isset( $meta_variation_check[$attribute] ) ? $meta_variation_check[$attribute] : 0;
				foreach ( $options as $key => $option ) {					
					$variation_color = isset( $meta_variation[$attribute]['color'][$key] ) ? $meta_variation[$attribute]['color'][$key] : '';
					$variation_image = isset( $meta_variation[$attribute]['image'][$key] ) ? $meta_variation[$attribute]['image'][$key] : 0;
					$parent_attr     = '';
					
					if( !$variation_check && $variation_color != '' ){
						$attr = 'class="variation-color" style="background-color: '. esc_attr( $variation_color ) .'"';
					}
					if( $variation_check && $variation_image ){
						$attr 			 = 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $variation_image ) ) .' )"';
						$img_url		 = wp_get_attachment_image_src( $variation_image, $img_size );
						$parent_attr = ( get_option( 'sw_wooswatches_tooltip_enable' ) ) ? 'data-toogle="tooltip" data-img="'. esc_url( $img_url[0] ) .'" data-width="' . esc_attr( $img_url[1] ) . '" data-height="' . esc_attr( $img_url[2] ) . '"' : '';		
					}
					$parent_attr  .= $wh_attr;
					
					// This handles < 2.4.0 bw compatibility where text attr were not sanitized.
					$checked = sanitize_title( $args['selected'] ) === $args['selected'] ? checked( $args['selected'], sanitize_title( $option ), false ) : checked( $args['selected'], $option, false );
					$active = ( $checked ) ? 'selected' : '';

					$html .= '<label class="radio-label sw-radio-variation sw-radio-variation-'. esc_attr( $key .' '. $active ) .'"  title="'. esc_attr( $option )  .'"  for="'. esc_attr( $option . '_' . $key ) . '" '. $parent_attr .'>';
					$html .= '<input type="radio" id="'.  esc_attr( $option . '_' . $key ) .'" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" value="' . esc_attr( $option ) . '" '. $checked .'/>';
					$html .= '<span '. $attr .'>'. $option .'</span>';
					$html .= '</label>';
				}
			}
			$html .= '</div>';
		}
		return apply_filters( 'sw_wooswatches_single_frontend', $html );
	}

	
	function sw_wooswatches_custom_variation_listing(){		
		if( get_option( 'sw_wooswatches_enable_listing' ) === 'no' ){
			return;
		}
		
		if( !is_shop() && !is_product_category() ):
			return;
		endif;
		
		global $product, $post; 
		
		include( WSPATH . '/includes/custom-variation-frontend.php' );
	}
	
	function sw_wooswatches_custom_variation_custom(){
		global $product, $post; 
		
		include( WSPATH . '/includes/custom-variation-frontend.php' );
	}
}

new SW_WooSwatches_Frontend();