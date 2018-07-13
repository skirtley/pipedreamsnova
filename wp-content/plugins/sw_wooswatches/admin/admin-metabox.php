<?php 
/**
* Metabox SW WooSwatches
**/

?>

<div class="panel woocommerce_options_panel" id="sw_wooswatches_data">
	<div class="sw-wooswatches-panel">
		<?php 
			foreach( $attributes as $key => $attribute ){ 
				if( taxonomy_exists( $key ) ){
					continue;
				}
				$meta_variation_check_content = ( isset( $meta_variation_check[$key] ) ) ? $meta_variation_check[$key] : 0;						
		?>
		<div class="panel-content-wrapper">
			<div class="panel-title parent-title">
				<a href="javascript:void(0)"  data-toggle="collapse" data-target="#panel_<?php echo esc_attr( str_replace( ' ', '_', $key ) ); ?>"><?php echo $key; ?></a>
				<div class="checkbox-content" data-color_title="<?php echo esc_attr__( 'Color', 'sw_wooswatches' ); ?>" data-img_title="<?php echo esc_attr__( 'Image', 'sw_wooswatches' ); ?>" title="<?php esc_attr_e( 'Select variation image or color', 'sw_wooswatches' ); ?>">
					<input type="checkbox" id="<?php echo esc_attr( 'check_content[' . $key .']' ); ?>" name="<?php echo esc_attr( 'sw_variation_check[' . $key .']' ); ?>" value="1" <?php echo checked( $meta_variation_check_content, 1 ) ?>>
					<label for="<?php echo esc_attr( 'check_content[' . $key .']' ); ?>"></label>
				</div>
			</div>
			<?php if( !empty( $attribute ) && sizeof( $attribute ) > 0 ) : ?>
				<div class="panel-content hide" id="panel_<?php echo esc_attr( str_replace( ' ', '_', $key ) ); ?>">
				<?php 
					foreach( $attribute as $i => $attr ){ 
					$meta_variation_color = ( isset( $meta_variation[$key]['color'][$i] ) ) ? $meta_variation[$key]['color'][$i] : '';
					$meta_variation_image = ( isset( $meta_variation[$key]['image'][$i] ) ) ? $meta_variation[$key]['image'][$i] : 0;
					$swatches_img 				= ( $meta_variation_image ) ? wp_get_attachment_url( $meta_variation_image ) : wc_placeholder_img_src();
				?>
					<div class="panel-title"  data-toggle="collapse" data-target="#panel_<?php echo esc_attr( str_replace( ' ', '_', $key . $attr ) ); ?>">
						<a href="javascript:void(0)"  data-toggle="collapse" data-target="#panel_<?php echo esc_attr( str_replace( ' ', '_', $key . $attr ) ); ?>"><?php echo $attr; ?></a>								
					</div>
					<div class="panel-content hide" id="panel_<?php echo esc_attr( str_replace( ' ', '_', $key . $attr ) ); ?>">
						<div class="form-field custom-picker" <?php echo ( $meta_variation_check_content ) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
							<label for="sw_variation_color"><?php _e( 'Color', 'sw_wooswatches' ); ?></label>
							<input name="<?php echo esc_attr( 'sw_variation['. $key .'][color][]' ) ?>" id="sw_variation_color_<?php echo esc_attr( $key . $attr ); ?>" value="<?php echo esc_attr( $meta_variation_color ); ?>" type="text" value="" size="40" class="category-colorpicker"/>
						</div>
						<div class="form-field form-upload" <?php echo ( $meta_variation_check_content ) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
							<label><?php _e( 'Variation Image', 'sw_wooswatches' ); ?></label>
							<div class="product-thumbnail"  style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $swatches_img ); ?>" width="60px" height="60px" /></div>
							<div style="line-height: 60px;">
								<input type="hidden" class="thumbnail" id="sw_variation_image_<?php echo esc_attr( $key . $attr ); ?>" name="<?php echo esc_attr( 'sw_variation['. $key .'][image][]' ) ?>" value="<?php echo esc_attr( $meta_variation_image ); ?>"/>
								<button type="button" class="upload_image_button_custom button"><?php _e( 'Upload/Add image', 'sw_wooswatches' ); ?></button>
								<button type="button" class="remove_image_button_custom button"><?php _e( 'Remove image', 'sw_wooswatches' ); ?></button>
							</div>				
							<div class="clear"></div>
						</div>
					</div>
				<?php	} ?>
				</div>
			<?php endif; ?>
			</div>
		<?php } ?>
	</div>
</div>