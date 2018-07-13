<?php 

$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
$viewall = get_permalink( wc_get_page_id( 'shop' ) );
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
	<a class="close" data-dismiss="alert">&times;</a>
	<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
</div>';
}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="sw-category-slider6">
	<div class="block-title clearfix">
		<?php
		$titles = strpos($title1, ' ');
		$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
		echo '<h3>'. $title .'</h3>';
		?>
		<div class="description1"><?php echo $desciption; ?></div>
		<a class="view-all" href="<?php echo esc_url( $viewall ) ?>"><?php esc_html_e( 'All Categories', 'sw_woocommerce' ) ?></a>
	</div>
	<div class="resp-slider-container">
		<div class="responsive">
			<?php
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
			foreach( $category as $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');	
				if( $term ) :
					$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'full' );
				?>
				<div class="item item-product-cat">					
					<div class="item-image">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
						<div class="item-content">
							<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php } ?>
		</div>
	</div>
</div>		