<?php 

ob_start();
if( $product->get_type() === 'variable' ){
	$img_size 						= ( get_option( 'sw_wooswatches_tooltip_size' ) ) ? get_option( 'sw_wooswatches_tooltip_size' ) : 'shop_catalog';
	$attributes 					= $product->get_variation_attributes();
	$meta_variation_check = get_post_meta( $post->ID,  'sw_variation_check', true );
	$meta_variation       = get_post_meta( $post->ID,  'sw_variation', true ); 
	if( !empty( $attributes ) && sizeof( $attributes ) > 0 ){
?>
	<div class="sw-variation-wrapper">
	<?php foreach( $attributes as $key => $attribute ){	?>
		<div class="sw-custom-variation">
		<?php if( taxonomy_exists( $key ) ){ ?>				
			<?php 
				$terms = wc_get_product_terms( $product->get_id(), $key, array( 'fields' => 'all' ) );	
				foreach ( $terms as $i => $term ) {
					$color  	= get_term_meta( $term->term_id, 'sw_variation_color', true );
					$thumb_id = absint( get_woocommerce_term_meta( $term->term_id, 'variation_thumbnail_id', true ) );
					$attr 		= ( $color != '' ) ? 'class="variation-color" style="background-color: '. esc_attr( $color ) .';"' : '';
					
					if( $thumb_id ){					
						$attr 				= ( $thumb_id ) ? 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $thumb_id ) ) .' );"' : '';
						$img_url			= wp_get_attachment_image_src( $thumb_id, $img_size );
					}
					if ( in_array( $term->slug, $attribute ) ) {
			?>
					<label class="radio-label sw-radio-variation sw-radio-variation-<?php echo esc_attr( $i )  ?>" title="<?php echo esc_attr( $term->slug ) ?>">
						<span <?php echo $attr; ?>><?php echo $term->name; ?></span>
					</label>
			<?php
					}
				}
			}else{
				$attr 			 = '';
				foreach( $attribute as $j => $option ){
					$variation_check = isset( $meta_variation_check[$key] ) ? $meta_variation_check[$key] : 0;
					$variation_color = isset( $meta_variation[$key]['color'][$j] ) ? $meta_variation[$key]['color'][$j] : '';
					$variation_image = isset( $meta_variation[$key]['image'][$j] ) ? $meta_variation[$key]['image'][$j] : 0;
					if( !$variation_check && $variation_color != '' ){
						$attr = 'class="variation-color" style="background-color: '. esc_attr( $variation_color ) .'"';
					}
					if( $variation_check && $variation_image ){
						$attr = 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $variation_image ) ) .' )"';
					}
			?>
				<label class="radio-label sw-radio-variation sw-radio-variation-<?php echo esc_attr( $j )  ?>" title="<?php echo esc_attr( $option ) ?>">
					<span <?php echo $attr; ?>><?php echo $option; ?></span>
				</label>
			<?php 
				}
			}
		?>
		</div>
		<?php 
		}
?>
	</div>
<?php 
	}
}
$html = ob_get_clean();
echo apply_filters( 'sw_wooswatches_single_frontend', $html );