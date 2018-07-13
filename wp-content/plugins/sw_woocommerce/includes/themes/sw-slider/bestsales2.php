<?php 

/**
* Layout Best Sales
* @version     1.0.0
**/


$term_name = esc_html__( 'Best Sales', 'sw_woocommerce' );
$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
$default = array(
	'post_type' 			=> 'product',		
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'   => 1,
	'showposts'				=> $numberposts,
	'meta_key' 		 		=> 'total_sales',
	'orderby' 		 		=> 'meta_value_num '. $orderby ,
	'order' => $order,
	);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
	$viewall = get_term_link( $term->term_id, 'product_cat' );
	endif;

	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'	=> 'slug',
			'terms'	=> $category,
			'operator' => 'IN'
		)
	);

}
$default = sw_check_product_visiblity( $default );

$id = 'sw_bestsales_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
	?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider best-selling-product style2 clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title clearfix">
			<?php
			$titles = strpos($title1, ' ');
			$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
			echo '<h3>'. $title .'</h3>';
			?>
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
						<div class="item-wrap">
							<div class="item-detail">										
								<div class="item-img products-thumb">		
									<?php 
									do_action( 'woocommerce_before_shop_loop_item_title' ); 
									?>
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
									<!-- rating  -->
									<?php 
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
									?>
									<div class="reviews-content">
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
									</div>									
									<!-- end rating  -->
									<div class="item-button"><?php woocommerce_template_loop_add_to_cart(); ?></div>
									<div class="item-bottom">
										<?php
										if ( class_exists( 'YITH_WCWL' ) ){
											echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
										} 
										?>	
										<?php if ( class_exists( 'YITH_WOOCOMPARE' ) ){ 
											?>
											<div class="woocommerce product compare-button">
												<a href="javascript:void(0)" class="compare button"  title="<?php esc_html_e( 'Add to Compare', 'sw_woocommerce' ) ?>" data-product_id="<?php echo esc_attr($post->ID); ?>" rel="nofollow"> <?php esc_html('compare','sw_woocommerce'); ?></a>
											</div>
										<?php } ?>
										</div>
									</div>								
								</div>
							</div>

							<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
							<?php $i++; endwhile; wp_reset_postdata();?>
						</div>
					</div>					
				</div>
				<?php
			}else{
				echo '<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p>'. esc_html__( 'There is not product in this category', 'sw_woocommerce' ) .'</p>
			</div>';
		}	
		?>