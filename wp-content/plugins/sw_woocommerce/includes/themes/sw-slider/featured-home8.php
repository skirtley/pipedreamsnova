<?php 
/**
	* Layout Featured
	* @version     1.0.0
**/


$term_name = esc_html__( 'Featured Products', 'sw_woocommerce' );
$default = array(
	'post_type'				=> 'product',
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> $numberposts,
	'orderby' 				=> $orderby,
	'order' 				=> $order,
);

if( sw_woocommerce_version_check( '3.0' ) ){	
	$default['tax_query'][] = array(						
		'taxonomy' => 'product_visibility',
		'field'    => 'name',
		'terms'    => 'featured',
		'operator' => 'IN',	
	);
}else{
	$default['meta_query'] = array(
		array(
			'key' 		=> '_featured',
			'value' 	=> 'yes'
		)					
	);				
}
	
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
	endif;
	
	$default['tax_query'][] = array(
		'taxonomy'	=> 'product_cat',
		'field'		=> 'slug',
		'terms'		=> $category
	);
}
$default = sw_check_product_visiblity( $default );

$id = 'sw_featured_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider featured-product2 clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title">
			<h3><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h3>
			<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
		</div>
		<div class="resp-slider-container">			
			<div class="slider responsive">			
			<?php 
				$count_items 	= 0;
				$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
				$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
				$i 				= 0;
				while($list->have_posts()): $list->the_post();global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
				if( $i % $item_row == 0 ){
			?>
				<div class="item product <?php echo esc_attr( $class )?>">
			<?php } ?>
					<div class="item-wrap2">
						<div class="item-detail">										
							<div class="item-img products-thumb">
								<?php sw_label_sales();?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'revo_shop-image' ); ?></a>
								<div class="item-button">
									<?php if ( class_exists( 'YITH_WOOCOMPARE' ) ){ ?>
										<div class="woocommerce product compare-button">
											<a href="javascript:void(0)" class="compare button"  title="<?php esc_html_e( 'Add to Compare', 'sw_woocommerce' ) ?>" data-product_id="<?php echo esc_attr($post->ID); ?>" rel="nofollow"> <?php esc_html('compare','sw_woocommerce'); ?></a>
										</div>
									<?php } ?>
									<?php
											if ( class_exists( 'YITH_WCWL' ) ){
													echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
											} ?>
																					
									<?php echo revo_quickview(); ?>
								</div>
							</div>										
							<div class="item-content">
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
								<!-- price -->
								<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
								<?php } ?>	
								<!-- add to cart -->
								<?php woocommerce_template_loop_add_to_cart(); ?>	
							</div>								
						</div>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i++; endwhile; wp_reset_postdata();?>
			</div>
		</div>					
	</div>
<?php
}	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'There is not product in this category', 'sw_woocommerce' ) .'</p>
	</div>';
	}
?>