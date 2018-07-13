<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="sw-category-mobile2"  data-append=".resp-slider-container" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
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
			$j = 0;
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
			foreach( $category as $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');	
				if( $term ) :
				$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'revo_thumbnail_mobile' );
				$thubnail = ( $thumb != '' ) ? $thumb : '<img src="'.esc_url( 'http://placehold.it/210x270' ) .'" alt=""/>';
		?>
			<?php if( $j % $item_row == 0 ){ ?>
				<div class="item item-product-cat">
			<?php } ?>
				<div class="item-wrap">
					<div class="item-image">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thubnail; ?></a>
					</div>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
					</div>
				</div>
				<?php if( ( $j+1 ) % $item_row == 0 ){?> </div><?php } ?>
				
				<?php endif; ?>
			<?php $j++; }?>
		</div>
	</div>
</div>		