<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="sw-category-slider3">
	<?php	if( $title1 != '' ){ ?>
	<div class="block-title">
		<h3><span><?php echo $title1; ?></span></h3>
	</div>
	<?php } ?>
	<div class="resp-slider-container container">
		<div class="row">
			<?php
				if( !is_array( $category ) ){
					$category = explode( ',', $category );
				}
				$i = 0;
				foreach( $category as $cat ){

					$term = get_term_by('slug', $cat, 'product_cat');	
					if( $term ) :
					$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
					$thumb = wp_get_attachment_image( $thumbnail_id,'large' );
					$attributes = ( $i % 2 == 0) ? 'item-even' : 'item-odd';
			?>
				<?php echo ( ( $i + 2) % 4 == 0 )  ? '<div class="item-category-wrapper col-lg-6 col-md-6 col-sm-6 col-xs-12">' : '' ?>
				
				<div class="item item-product-cat col-lg-3 col-md-3 col-sm-3 col-xs-12 <?php echo esc_attr( $attributes) ?>">
						<div class="item-wrap">
							<?php if( $i % 2 == 0 ){ ?>
								<div class="item-content">
									<h4><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h4>
									<div class="des-cat"><?php echo  $term->description; ?></div>
									<a class="shop-by-now"href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html__('shop now','sw_woocommerce'); ?><i class="fa fa-angle-double-right"></i></a>
								</div>
							<?php } ?>
							<div class="item-image">
								<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
							</div>
							<?php if( $i % 2 == 1 ){ ?>
								<div class="item-content">
									<h4><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h4>
									<div class="des-cat"><?php echo  $term->description; ?></div>
									<?php $sale_of 	= get_woocommerce_term_meta( $term->term_id, 'sale_of', true ); if( $sale_of ) : ?>
									<div class="sal-of"><span><?php echo esc_html__(' Sale of ','sw_woocommerce')?></span><span class="sale"><?php echo esc_attr ( $sale_of ).esc_html__('%','sw_woocommerce'); ?></span></div>
									<?php endif; ?>
									<a class="shop-by-now"href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html__('shop now','sw_woocommerce'); ?><i class="fa fa-angle-double-right"></i></a>
								</div>
							<?php } ?>
						</div>
					</div>
					
					<?php echo ( ( $i + 1) % 4 == 0 )  ? '</div>' : '' ?>
				<?php endif; ?>
			<?php  $i++; } ?>
			</div>
	</div>
</div>		