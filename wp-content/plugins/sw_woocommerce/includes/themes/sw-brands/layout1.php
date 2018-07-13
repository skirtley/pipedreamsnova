<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : 'sw_brand_'.$this->generateID();
	$term_brands = array();
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	if( count( $category ) == 1 && $category[0] == 0 ){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0, 'number' => $numberposts ) );
		foreach( $terms as $key => $cat ){
			$term_brands[$key] = $cat -> slug;
		}
	}else{
		$term_brands = $category;
	}
	
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="brand-mobile style-moblie">
		<?php if( $title1 != '') { ?>
				<div class="block-title"><h3><?php echo esc_html( $title1 ); ?></h3></div>
		<?php } ?>
		<div class="resp-slider-container">
			<div class="items-wrapper clearfix">
				<?php 
					foreach( $term_brands as $j => $term_brand ) {
						$term = get_term_by( 'slug', $term_brand, 'product_brand' );
						if( $term ) :
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
						$thumb = wp_get_attachment_image( $thumbnail_id, array(110, 75) );
						$thubnail = ( $thumb != '' ) ? $thumb : '<img src="http://placehold.it/170x87" alt=""/>';
				?>
				<?php	if( ( $j % $item_row ) == 0 ) { ?>
					<div class="item">
				<?php } ?>
						<div class="item-image">
							<?php echo '<a href="'. get_term_link( $term->term_id, 'product_brand' ).'">'.$thubnail .'</a>'; ?>
						</div>
				<?php if( ( $j+1 ) % $item_row == 0 || ( $j+1 ) == $numberposts ){?> </div><?php  } ?>
					<?php endif; ?>
				<?php } ?>
			</div>
		</div>
	</div>
