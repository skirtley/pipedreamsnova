<?php 

if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}
if( !is_array( $category ) ){
	$category = explode( ',', $category );
}
$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="category-ajax-slider sw-ajax">
	<div class="tab-category-title block-title">
		<h2><span><?php echo $title1; ?></span></h2>
	</div>	
	<ul class="nav nav-tabs category-item-<?php echo esc_attr( count( $category ) ) ?>">
	<?php 
		$key = 0;
		foreach( $category as $cat ){
			$term = get_term_by('slug', $cat, 'product_cat');	
			if( $term ) :
			$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));
			$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
	?>
		<li class="<?php echo ( $key == 0 ) ? 'active loaded' : '' ?>">
			<a href="#<?php echo esc_attr( $widget_id . $term->term_id ); ?>" data-type="cat_ajax" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-category="<?php echo esc_attr( $term->term_id ); ?>" data-orderby="<?php echo esc_attr( $orderby ); ?>" data-toggle="tab" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
				<div class="item-image">
					<?php echo $thumb; ?>
				</div>
				<div class="item-content">
					<h3><?php echo esc_html( $term->name ); ?></h3>
				</div>
			</a>
		</li>
		<?php $key ++; ?>
		<?php endif; ?>
	<?php } ?>
	</ul>
	<div class="tab-content">
	<?php 
		$term = get_term_by('slug', $category[0], 'product_cat');	
		if( $term ) :
		$default = array(
			'post_type' => 'product',		
			'orderby' => $orderby,
			'post_status' => 'publish',
			'showposts' => $numberposts,
			'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'slug',
					'terms'     => $category[0] 
				)
			)	
		);
		$default = sw_check_product_visiblity( $default );
		$list = new WP_Query( $default );		
	?>
		<div id="<?php echo $widget_id . esc_attr( $term->term_id ); ?>" class="tab-pane fade in active">
		<?php if ( $list -> have_posts() ){ ?>
			<div id="<?php echo esc_attr( 'category_ajax_slider_' . $term->term_id ); ?>" class="sw-woo-container-slider responsive-slider woo-slider-default" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo esc_attr( $rtl ) ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">       
				<div class="slider-wrapper clearfix">
				<?php if( $thumbnail_id != 0 ){?>
					<div class="imgleft  img-effect pull-left">
						<a class="img-class " href="#">	<?php echo $thumb; ?></a>
					</div>		
				<?php } ?>
					<div class="resp-slider-container">
						<div class="slider responsive">	
					<?php 
						while($list->have_posts()): $list->the_post();
						global $product, $post; 
						$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
					?>
							<div class="item <?php echo esc_attr( $class )?> product">
								<?php include( WCTHEME . '/default-item.php' ); ?>
							</div>
						<?php endwhile; wp_reset_postdata();?>
						</div>
					</div>
				</div>
			</div>
			<?php }else{
				echo '<div class="alert alert-warning alert-dismissible" role="alert">
					<a class="close" data-dismiss="alert">&times;</a>
					<p>'. esc_html__( 'There is not product in this category', 'sw_woocommerce' ) .'</p>
				</div>';
			} ?>
		</div>
	<?php endif ?>
	</div>
</div>	