<?php 
/**
	* Layout Countdown Default
	* @version     1.0.0
**/

$term_name = esc_html__( 'All Categories', 'sw_woocommerce' );
$default = array(
	'post_type' => 'product',	
	'meta_query' => array(
		array(
			'key' => '_sale_price',
			'value' => 0,
			'compare' => '>',
			'type' => 'DECIMAL(10,5)'
		),
		array(
			'key' => '_sale_price_dates_from',
			'value' => time(),
			'compare' => '<',
			'type' => 'NUMERIC'
		),
		array(
			'key' => '_sale_price_dates_to',
			'value' => time(),
			'compare' => '>',
			'type' => 'NUMERIC'
		)
	),
	'orderby' => $orderby,
	'order' => $order,
	'post_status' => 'publish',
	'showposts' => $numberposts	
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	$term_name = $term->name;
	$default['tax_query'] = array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category 
		)
	);
}
$default = sw_check_product_visiblity( $default );

$countdown_id = 'sw_tab_countdown_'.$this->generateID();
$countdown_id2 = 'sw_tab_countdown2_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
<div id="<?php echo $countdown_id; ?>" class="sw_tab_countdown3">
<?php if( $title1 != '' ){?>
			<div class="block-title">
				<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h3>'. $title .'</h3>';
				?>
			</div>
<?php } ?>
<div  class="tab-countdown-slide clearfix">
		<div class="top-tab-slider clearfix">	
			<div id="<?php echo 'mytab_' . $countdown_id; ?>" class="sw-tab-slider responsive-slider loading" data-lg="4" data-md="4" data-sm="3" data-xs="3" data-mobile="3" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="false" data-vertical="true">
				<ul class="nav nav-tabs slider responsive">
					<?php
						$i = 0;
						while($list->have_posts()): $list->the_post();	
						global $post;
					?>
					<li class="<?php echo ( $i == 0  ) ? 'active' : '' ?>">
						<a href="#<?php echo 'product_tab_'.$post->ID; ?>" data-toggle="tab">
							<?php echo get_the_post_thumbnail( $post->ID, 'shop_thumbnail' ); ?>
						</a>
					</li>
					<?php
						$i++; endwhile; wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
		<div class="top-tab-slider-full clearfix">	
			<div id="<?php echo 'tab2_' . $countdown_id2; ?>" class="sw-tab-slider2 responsive-slider loading hidden-lg hidden-md" data-lg="3" data-md="3" data-sm="3" data-xs="3" data-mobile="2" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="false" data-vertical="false">
				<ul class="nav nav-tabs slider responsive">
					<?php
						$i = 0;
						while($list->have_posts()): $list->the_post();	
						global $post;
					?>
					<li <?php echo ( $i == 0  ) ? 'active' : '' ?>>
						<a href="#<?php echo 'product_tab_'.$post->ID; ?>" data-toggle="tab">
							<?php echo get_the_post_thumbnail( $post->ID, array(100,100) ); ?>
						</a>
					</li>
					<?php
						$i++; endwhile; wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
		<div class="tab-content clearfix">
			<?php
				$count_items 	= 0;
				$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
				$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
				$i 				= 0;
				while($list->have_posts()): $list->the_post();
				global $product, $post;
				$start_time = get_post_meta( $post->ID, '_sale_price_dates_from', true );
				$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );	

				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
			?>
			<div class="tab-pane <?php echo ( $i == 0 ) ? 'active' : ''; ?>" id="<?php echo 'product_tab_'.$post->ID; ?>" >
				<div class="item">
					<div class="item-wrap">
						<div class="item-detail">										
							<div class="item-img products-thumb">
								<?php sw_label_sales() ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php 
										$id = get_the_ID();
										if ( has_post_thumbnail() ){
												echo get_the_post_thumbnail( $post->ID, 'shop_single' ) ? get_the_post_thumbnail( $post->ID, 'shop_single' ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';		
										}else{
											echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';
										}
									?>
								</a>
							</div>
							<div class="item-content">															
								<div class="product-countdown" data-date="<?php echo esc_attr( $countdown_date ); ?>"  data-starttime="<?php echo esc_attr( $start_time ); ?>"></div>
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>
																<!-- rating  -->
								<?php 
									$rating_count = $product->get_rating_count();
									$review_count = $product->get_review_count();
									$average      = $product->get_average_rating();
								?>
								<div class="reviews-content">
									<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*17 ).'px"></span>' : ''; ?></div>
								</div>	
								<!-- end rating  -->		
								<div class="description"><?php echo $post->post_excerpt; ?></div>				
								<!-- price -->
								<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
								<?php } ?>
								 <!-- add to cart, wishlist, compare -->
								<div class="item-button">
									<?php woocommerce_template_loop_add_to_cart(); ?>
									<div class="button-group">
										<?php
										if ( class_exists( 'YITH_WCWL' ) ){
												echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
										} ?>
										<?php if ( class_exists( 'YITH_WOOCOMPARE' ) ){ 
											?>
											<div class="woocommerce product compare-button">
												<a href="javascript:void(0)" class="compare button"  title="<?php esc_html_e( 'Add to Compare', 'sw_woocommerce' ) ?>" data-product_id="<?php echo esc_attr($post->ID); ?>" rel="nofollow"> <?php esc_html('compare','sw_woocommerce'); ?></a>
											</div>
										<?php } ?>								
										<?php echo revo_quickview(); ?>
									</div>
								</div>							
							</div>
							
							</div>
					</div>
				</div>
			</div>
			<?php
				$i++; endwhile; wp_reset_postdata();
			?>
		</div>

</div>
</div>
<?php
	} 
?>
<script type="text/javascript">
/* (function ($) {
	"use strict";
	$('#<?php echo 'mytab_' . $countdown_id; ?> a').click(function (e) {
		console.log( $(this) );
		e.preventDefault();
		$(this).tab('show');
	});
})(jQuery);*/
</script>