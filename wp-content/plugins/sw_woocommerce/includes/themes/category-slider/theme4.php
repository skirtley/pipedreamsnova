<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="sw-category-slider4">
	<?php	if( $title1 != '' ){ ?>
	<div class="block-title">
		<h3><span><?php echo $title1; ?></span></h3>
	</div>
	<?php } ?>
	<?php	if( $desciption != '' ){ ?>
		<div class="description1"><?php echo $desciption; ?>
	</div>
	<?php } ?>
	<div class="resp-slider-container">
		<div class="slider">
		<?php
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
			foreach( $category as $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');	
				if( $term ) :
				$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'large' );
		?>
			<div class="item item-product-cat">					
				<div class="item-image">
					<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
				</div>
				<div class="item-content">
					<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
					<div class="product-count"><?php echo $term->count; ?><?php echo esc_html__(' Products ','sw_woocommerce'); ?></div>
					<div class="shop-now"><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php esc_html_e( 'Shop now', 'sw_woocommerce' ) ?><i class="fa fa-angle-double-right"></i></a></div>
				</div>
			</div>
			<?php endif; ?>
		<?php } ?>
		</div>
	</div>
</div>		