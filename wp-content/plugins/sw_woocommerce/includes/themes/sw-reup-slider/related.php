<?php 
	if( !is_singular( 'product' ) ){
		return ;
	}
	$related = array();
	global $post;
	if( function_exists( 'wc_get_related_products' ) ){
		$related = wc_get_related_products( $post->ID, $numberposts );
	}else{
		$related = $product->get_related($numberposts);
	}
	
	if ( sizeof( $related ) == 0 ) return;
	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => $numberposts,
		'post__in'             => $related,
		'post__not_in'         => array( $post->ID )
	) );
	
	$args = sw_check_product_visiblity( $args );
	
	$list = new WP_Query( $args );

	if ( $list -> have_posts() ){
?>
	<div id="<?php echo 'slider_' . $widget_id; ?>" class="sw-woo-container-slider related-products responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="resp-slider-container">
			<div class="box-slider-title">
				<?php echo '<h2><span>'. esc_html( $title1 ) .'</span></h2>'; ?>
			</div>
			<div class="slider responsive">			
			<?php 
				while($list->have_posts()): $list->the_post();global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
			?>
				<div class="item <?php echo esc_attr( $class )?>">
					<?php include( WCTHEME . '/default-item.php' ); ?>
				</div>
			<?php endwhile; wp_reset_postdata();?>
			</div>
		</div>					
	</div>
<?php
} 
?>