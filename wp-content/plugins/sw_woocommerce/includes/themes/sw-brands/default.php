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
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="responsive-slider sw-brand-container-slider <?php echo esc_attr( $style ); ?> loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php if( $title1 != '') { ?>
			<?php if( $style == '') {?>
				<div class="title-home"><h2><?php echo esc_html( $title1 ); ?></h2></div>
			<?php }else{ ?>
				<div class="box-slider-title2"><?php echo ( $title1 != '' ) ? '<h2>'. esc_html( $title1 ) .'</h2>' : ''; ?></div>
			<?php } } ?>
		<div class="resp-slider-container">
			<div class="slider responsive">
				<?php 
					foreach( $term_brands as $j => $term_brand ) {
						$term = get_term_by( 'slug', $term_brand, 'product_brand' );
						if( $term ) :
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
						$thumb = wp_get_attachment_image( $thumbnail_id, array(170, 87) );
						$thubnail = ( $thumb != '' ) ? $thumb : '<img src="http://placehold.it/170x87" alt=""/>';
				?>
				<?php	if( ( $j % $item_row ) == 0 ) { ?>
					<div class="item item-brand-cat">
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
