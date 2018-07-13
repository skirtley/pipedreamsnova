<?php 
/**
* Product variation hook
* Athor: SmartAddons
**/

class Sw_Attribute_Metabox{
	public static function init(){
		$sw_attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( ! empty( $sw_attribute_taxonomies ) ) {
			foreach( $sw_attribute_taxonomies as $attr ){
				add_action( 'pa_'. $attr->attribute_name .'_add_form_fields',  __CLASS__ . '::sw_woocommerce_variation_fields', 200 );
				add_action( 'pa_'. $attr->attribute_name .'_edit_form_fields',  __CLASS__ . '::sw_woocommerce_edit_variation_fields', 200 );			
			}
			
			add_action( 'created_term',  __CLASS__ . '::sw_woocommerce_save_variation_fields', 10, 3 );
			add_action( 'edit_terms',  __CLASS__ . '::sw_woocommerce_save_variation_fields', 10, 3 );
			
			/* Enqueue Admin js */
			add_action( 'admin_enqueue_scripts',  __CLASS__ . '::sw_woocommerce_variation_color_script' );
		}
	}
	
	/**
	* Enqueue js for attribute color
	**/
	public static function sw_woocommerce_variation_color_script(){
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script('category_color_picker_js', WSURL . '/js/admin/category_color_picker.js', array( 'wp-color-picker' ), false, true);
	}
	
	/**
	* Create attribute color and image
	**/
	public static function sw_woocommerce_variation_fields() {
		?>
		<div class="form-field custom-picker">
			<label for="sw_variation_color"><?php _e( 'Color', 'sw_woocommerce' ); ?></label>
			<input name="sw_variation_color" id="sw_variation_color" type="text" value="" size="40" class="category-colorpicker"/>
		</div>
		
		<div class="form-field">
			<label><?php _e( 'Variation Thumbnail', 'sw_woocommerce' ); ?></label>
			<div id="variation_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="variation_thumbnail_id" name="variation_thumbnail_id" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'sw_woocommerce' ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'sw_woocommerce' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#variation_thumbnail_id' ).val() ) {
					jQuery( '.remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", 'sw_woocommerce' ); ?>',
						button: {
							text: '<?php _e( "Use image", 'sw_woocommerce' ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();
						
						jQuery( '#variation_thumbnail_id' ).val( attachment.id );
						jQuery( '#variation_thumbnail > img' ).attr( 'src', attachment.sizes.thumbnail.url );
						jQuery( '.remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.remove_image_button', function() {
					jQuery( '#variation_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#variation_thumbnail_id' ).val( '' );
					jQuery( '.remove_image_button' ).hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</div>
		<?php
	}
	
	/**
	* Edit Attribute form
	**/
	public static function sw_woocommerce_edit_variation_fields( $term ) {
		$sw_variation_color = get_term_meta( $term->term_id, 'sw_variation_color', true );
		$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'variation_thumbnail_id', true ) );
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
		}
	?>
		<tr class="form-field custom-picker custom-picker-edit">
			<th scope="row" valign="top"><label for="sw_variation_color"><?php _e( 'Color', 'sw_woocommerce' ); ?></label></th>
			<td>
				<input name="sw_variation_color" id="sw_variation_color" type="text" value="<?php echo esc_attr( $sw_variation_color ) ?>" size="40" class="category-colorpicker"/>
			</td>
		</tr>
		
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Variation Thumbnail', 'sw_woocommerce' ); ?></label></th>
			<td>
				<div id="variation_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="variation_thumbnail_id" name="variation_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'sw_woocommerce' ); ?></button>
					<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'sw_woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#variation_thumbnail_id' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", 'sw_woocommerce' ); ?>',
							button: {
								text: '<?php _e( "Use image", 'sw_woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment = file_frame.state().get( 'selection' ).first().toJSON();

							jQuery( '#variation_thumbnail_id' ).val( attachment.id );
							jQuery( '#variation_thumbnail img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#variation_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#variation_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
	<?php 
	}

	/** 
	* Save Custom Field Of Category Form 
	**/
	public static function sw_woocommerce_save_variation_fields( $term_id, $tt_id = '', $taxonomy = '', $prev_value = '' ) {
		if ( isset( $_POST['sw_variation_color'] ) ) {			
			$term_value = esc_attr( $_POST['sw_variation_color'] );
			update_term_meta( $term_id, 'sw_variation_color', $term_value, $prev_value );
		}
		
		if( isset( $_POST['variation_thumbnail_id'] ) ) {
			$term_value = intval( $_POST['variation_thumbnail_id'] );
			update_term_meta( $term_id, 'variation_thumbnail_id', $term_value, $prev_value );
		}
	}
}

Sw_Attribute_Metabox::init();
