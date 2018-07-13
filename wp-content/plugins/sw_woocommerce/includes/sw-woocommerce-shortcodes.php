<?php
/**
 * SW WooCommerce Shortcodes
 * @author 		flytheme
 * @version     1.0.0
 */

if ( class_exists( 'Vc_Manager' ) ) {
	require_once ( WCPATH . '/includes/visual-map.php' );
}
 /*
 * Featured product
 *
 */
 function sw_bestsale_shortcode($atts){
 	extract(shortcode_atts(array(
 		'number' => 5,
 		'title'=>'',
 		'title_length'  => 0,
 		'el_class'=>'',
 		'images' => '',
 		'template'=>'',
 		'item_slide'=>'',
 		'post_status' 	 => 'publish',
 		'post_type' 	 => 'product',
 		'meta_key' 		 => 'total_sales',
 		'orderby' 		 => 'meta_value_num',
 		'no_found_rows'  => 1
 		),$atts));
 	ob_start();
 	global $woocommerce;
 	$i='';
 	$pf_id = 'bestsale-'.rand().time();
 	$default =array( 'posts_per_page'=> $number,'post_type' => 'product','meta_key' => 'total_sales','orderby' => 'meta_value_num','no_found_rows' => 1); 

 	$default['meta_query'][] = array(
 		'key'     => '_price',
 		'value'   => 0,
 		'compare' => '>',
 		'type'    => 'DECIMAL',
	);
	$default = sw_check_product_visiblity( $default );
	
 	$r = new WP_Query($default);
 	$numb_post = count( $r -> posts );
 	if ( $r->have_posts() ) {
 		if($template== 'default'){
 			?>
 			<div id="<?php echo $pf_id ?>" class="sw-best-seller-product vc_element">
 				<?php 
 				if( $title != '' ){ 
 					$titles = strpos($title, ' ');
 					?>
 					<div class="box-title"><h3><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h3></div>
 					<?php } ?>
 					<div class="wrap-content">
 						<?php
 						while ( $r -> have_posts() ) : $r -> the_post();
 						global $product, $post;
 						?>

 						<div class="item">
 							<div class="item-inner">
 								<div class="item-img">
 									<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
 										<?php if( has_post_thumbnail() ){  ?>
 										<?php echo ( get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) ) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
 									}else{ ?>
 									<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>
 									<?php	} ?>
 								</a>
 							</div>
 							<div class="item-content">
 								<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
 								<div class="item-price"><?php echo $product->get_price_html() ?></div>			 
 							</div>
 						</div>
 					</div>
 					<?php 
 					endwhile;
 					wp_reset_postdata();
 					?>
 				</div>
 			</div>
 			<?php
 		}elseif($template == 'slide'){ ?>
 		<div id="<?php echo $pf_id ?>" class="sw-best-seller-product-slider vc_element carousel slide <?php echo $el_class ?>" data-interval="0">
 			<?php if( $title != '' ){
 				$titles = strpos($title, ' ');
 				?>
 				<div class="box-title"><h3><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h3></div>
 				<?php } ?>
 				<div class="customNavigation nav-left-product">
 					<a title="<?php echo esc_attr__( 'Previous', 'sw_woocommerce' ) ?>" class="btn-bs prev-bs"  href="#<?php echo $pf_id ?>" role="button" data-slide="prev"></a>
 					<a title="<?php echo esc_attr__( 'Next', 'sw_woocommerce' ) ?>" class="btn-bs next-bs" href="#<?php echo $pf_id ?>" role="button" data-slide="next"></a>
 				</div>
 				<div class="carousel-inner">
 					<div class="image-slide">
 						<?php echo wp_get_attachment_image( $images, 'large' ); ?>
 					</div>
 					<?php 
 					$i = 0;
 					while ( $r -> have_posts() ) : $r -> the_post();
 					global $product, $post;
 					if( ( $i % $item_slide ) == 0 && ( $item_slide != 0 ) ){
 						$active = ( $i == 0 ) ? 'active' : '';
 						?>
 						<div class="item <?php echo $active ?>" >
 							<?php } ?>
 							<div class="item-detail">
 								<div class="item-inner">
 									<div class="item-img">
 										<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
 											<?php 
 											if( has_post_thumbnail() ){  
 												echo ( get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) ) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
 											}else{ 
 												echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
 											}
 											?>
 										</a>
 									</div>
 									<div class="item-content">
 										<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
 										<div class="item-price"><p><?php echo $product->get_price_html() ?></p></div>
 									</div>
 								</div>
 							</div>
 							<?php if( ( $i+1 ) % ($item_slide) == 0 || ( $i+1 ) == $numb_post ){ ?>
 						</div>
 						<?php }
 						$i++;endwhile;
 						wp_reset_postdata();
 						?>
 					</div>
 				</div>
 				<?php 
 			}
 		}
 		$content = ob_get_clean();
 		return $content;
 	}
 	add_shortcode('BestSale','sw_bestsale_shortcode');

  /*
 * Best Sale product
 *
 */
  function sw_featured_shortcode($atts){
  	extract(shortcode_atts(array(
  		'number' => 5,
  		'title'=>'',
  		'title_length'  => 0,
  		'el_class'=>'',
  		'images' => '',
  		'template'=> '',
  		'category' => '',
  		'item_slide'=> 1,
  		'post_type' 	 => 'product'		
  		),$atts));
  	ob_start();
  	global $woocommerce;
  	$i='';
  	$pf_id = 'bestsale-'.rand().time();
  	$default = array( 'posts_per_page'=> $number,'post_type' => 'product', 'orderby' => 'name', 'order' => 'ASC',);
  	if( $category != '' ){
  		$term = get_term_by( 'slug', $category, 'product_cat' );	
  		$term_name = $term->name;
  		$default['tax_query'][] = array(
  			'taxonomy'  => 'product_cat',
  			'field'     => 'slug',
  			'terms'     => $category 
  			);	
  	}	 
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
	$default = sw_check_product_visiblity( $default );

  	$r = new WP_Query($default);
  	$numb_post = count( $r -> posts );
  	if ( $r->have_posts() ) {
  		if($template== 'default'){
  			?>
  			<div id="<?php echo $pf_id ?>" class="sw-featured-product vc_element">
  				<?php 
  				if( $title != '' ){ 
  					$titles = strpos($title, ' ');
  					?>
  					<div class="box-title"><h3><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h3></div>
  					<?php } ?>
  					<div class="wrap-content">
  						<?php
  						while ( $r -> have_posts() ) : $r -> the_post();
  						global $product, $post;
  						?>

  						<div class="item">
  							<div class="item-inner">
  								<div class="item-img">
  									<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
  										<?php if( has_post_thumbnail() ){  ?>
  										<?php echo ( get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) ) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
  									}else{ ?>
  									<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>
  									<?php	} ?>
  								</a>
  							</div>
  							<div class="item-content">
  								<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
  								<div class="item-price"><?php echo $product->get_price_html() ?></div>			 
  							</div>
  						</div>
  					</div>
  					<?php 
  					endwhile;
  					wp_reset_postdata();
  					?>
  				</div>
  			</div>
  			<?php
  		}elseif($template == 'slide'){ ?>
  		<div id="<?php echo $pf_id ?>" class="sw-featured-product-slider vc_element carousel carousel-fade slide <?php echo $el_class ?>" data-interval="0">
  			<?php if( $title != '' ){
  				$titles = strpos($title, ' ');
  				?>
  				<div class="box-title"><h3><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h3></div>
  				<?php } ?>
  				<div class="customNavigation nav-left-product">
  					<a title="<?php echo esc_attr__( 'Previous', 'sw_woocommerce' ) ?>" class="btn-bs prev-bs"  href="#<?php echo $pf_id ?>" role="button" data-slide="prev"></a>
  					<a title="<?php echo esc_attr__( 'Next', 'sw_woocommerce' ) ?>" class="btn-bs next-bs" href="#<?php echo $pf_id ?>" role="button" data-slide="next"></a>
  				</div>
  				<div class="carousel-inner">
  					<?php if(  $images ) : ?> 
  						<div class="image-slide">
  							<?php echo wp_get_attachment_image( $images, 'large' ); ?>
  						</div>
  					<?php endif; ?>
  					<?php 
  					$i = 0;
  					while ( $r -> have_posts() ) : $r -> the_post();
  					global $product, $post;
  					if( ( $i % $item_slide ) == 0 && ( $item_slide != 0 ) ){
  						$active = ( $i == 0 ) ? 'active' : '';
  						?>
  						<div class="item <?php echo $active ?>" >
  							<?php } ?>
  							<div class="item-detail">
  								<div class="item-inner">
  									<div class="item-img">
  										<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
  											<?php 
  											if( has_post_thumbnail() ){  
  												echo ( get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) ) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
  											}else{ 
  												echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
  											}
  											?>
  										</a>
  									</div>
  									<div class="item-content">
  										<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
  										<div class="item-price"><p><?php echo $product->get_price_html() ?></p></div>
  									</div>
  								</div>
  							</div>
  							<?php if( ( $i+1 ) % ($item_slide) == 0 || ( $i+1 ) == $numb_post ){ ?>
  						</div>
  						<?php }
  						$i++;endwhile;
  						wp_reset_postdata();
  						?>
  					</div>
  				</div>
  				<?php 
  			}
  		}
  		$content = ob_get_clean();
  		return $content;
  	}
  	add_shortcode('Featured','sw_featured_shortcode');

  /*
 * Latest product
 *
 */
  function sw_latest_products_shortcode($atts){
  	extract(shortcode_atts(array(
  		'number' => 5,
  		'title'=>'',
  		'title_length'  => 0,
  		'el_class'=>'',
  		'template'=>'',
  		'category' => '',
  		'item_slide'=>'',
  		'post_status' 	 => 'publish',
  		'post_type' 	 => 'product',
  		'orderby' 		 => 'date',
  		'order'          => 'DESC',
  		'no_found_rows'  => 1
  		),$atts));
  	ob_start();
  	global $woocommerce;
  	$pf_id = 'SW_latest_product-'.rand().time();
  	$default = array(
  		'post_type' => 'product',		
  		'post_status' => 'publish',
  		'showposts' => $number,
  		'orderby' 		 => $orderby,
  		'order'          => $order
  		);
  	if( $category != '' ){
  		$term = get_term_by( 'slug', $category, 'product_cat' );	
  		$term_name = $term->name;
  		$default['tax_query'] = array(
  			array(
  				'taxonomy'  => 'product_cat',
  				'field'     => 'slug',
  				'terms'     => $category )
  			);	
  	}
	$default = sw_check_product_visiblity( $default );
	
  	$list = new WP_Query( $default );
  	$numb_post = count( $list -> posts );
  	if ( $list->have_posts() ) {
  		if($template== 'default'){
  			?>
  			<div id="<?php echo $pf_id ?>" class="sw-latest-product vc_element">
  				<?php 
  				if( $title != '' ){
  					$titles = strpos($title, ' ');
  					?>
  					<div class="box-title"><h2><span><?php echo substr( $title, 0, $titles ) ?> </span><?php echo substr( $title, $titles + 1 ) ?></h2></div>
  					<?php } ?>
  					<div class="content-wrap">
  						<?php	while ( $list -> have_posts() ) : $list -> the_post();
  						global $product, $post;
  						?>
  						<div class="item">
  							<div class="item-inner clearfix">
  								<div class="item-thumbnail pull-left">
  									<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
  										<?php
  										if( has_post_thumbnail() ){  
  											the_post_thumbnail( 'shop_thumbnail' );
  										}else{ 
  											echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
  										}
  										?>
  									</a>
  									<?php echo revo_quickview();?>
  								</div>
  								<div class="item-content">
  									<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
  									<div class="item-price"><p><?php echo $product->get_price_html() ?></p></div>
  									<div class="item-button">
  										<?php woocommerce_template_loop_add_to_cart(); ?>	

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
  							<?php 
  							endwhile;
  							wp_reset_postdata();
  							?>
  						</div>
  					</div>
  					<?php 
  				} ?>
  				<?php
  			}
  			$content = ob_get_clean();
  			return $content;
  		}
  		add_shortcode('Latest','sw_latest_products_shortcode');

/*
** Most Viewed
*/
function sw_mostviewed_products_shortcode($atts){
	extract(shortcode_atts(array(		
		'title'					=> '',
		'title_length'  => 0,
		'numberposts' 	=> 5,
		'style'			=> '',
		'el_class'			=> '',
		'category'			=> '',
		'layout'  			=> 'default',
		'scroll' 				=> 1
		),$atts));
	ob_start();
	$most_id = 'mostviewed_' . rand().time();
	$default = array(
		'post_type' => 'product',		
		'post_status' => 'publish',
		'showposts' => $numberposts,
		'meta_key'	=> 'post_views_count',
		'orderby'   => 'meta_value_num'
		);
	if( $category != '' ){
		$term = get_term_by( 'slug', $category, 'product_cat' );	
		$term_name = $term->name;
		$default['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category )
			);	
	}
	$default = sw_check_product_visiblity( $default );
	
	$list = new WP_Query( $default );
	if ( $list -> have_posts() ){ 
		?>
		<div id="<?php echo esc_attr( $most_id ); ?>" class="sw-mostviewed <?php echo esc_attr( $style ); ?> <?php echo esc_attr( $el_class ); ?>">
			<?php 
			if( $title != '' ){
				$titles = strpos($title, ' ');
				?>
				<div class="box-title"><h2><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h2></div>
				<?php } ?>
				<div class="content-wrap">
					<?php 
					$count_items 	= 0;
					$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
					$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
					$i 				= 0;
					while($list->have_posts()): $list->the_post();global $product, $post;
					?>
					<div class="item">
						<div class="item-inner clearfix">
							<div class="item-thumbnail pull-left">
								<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
									<?php
									if( has_post_thumbnail() ){  
										the_post_thumbnail( 'shop_thumbnail' );
									}else{ 
										echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
									}
									?>
								</a>
								<?php echo revo_quickview();?>
							</div>
							<div class="item-content">
								<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php sw_trim_words( get_the_title(), $title_length ) ?></a></h4>
								<div class="item-price"><p><?php echo $product->get_price_html() ?></p></div>
								<div class="item-button">
									<?php woocommerce_template_loop_add_to_cart(); ?>	

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
						<?php $i++; endwhile; wp_reset_postdata();?>
					</div> 
				</div>
				<?php 
			}
			$content = ob_get_clean();
			return $content;
		}

		add_shortcode( 'product_mostvied', 'sw_mostviewed_products_shortcode' );

  /*
 * Onsale product
 *
 */
  function sw_onsale_shortcode($atts){
  	extract(shortcode_atts(array(
  		'number' => '',
  		'title' =>'',
  		'title_length'  => 0,
  		'category' => '',
  		'el_class'=>'',
  		'orderby' 		 => '',
  		'order'          => '',
  		'no_found_rows'  => 1
  		),$atts));

  	$default = array(
  		'post_type' => 'product',	
  		'meta_query' => array(			
  			array(
  				'key' => '_sale_price',
  				'value' => 0,
  				'compare' => '>',
  				'type' => 'NUMERIC'
  				),
  			),
  		'orderby' => $orderby,
  		'order' => $order,
  		'post_status' => 'publish',
  		'showposts' => $number	
  		);
  	if( $category != '' ){
  		$term = get_term_by( 'slug', $category, 'product_cat' );	
  		$term_name = $term->name;
  		$default['tax_query'] = array(
  			array(
  				'taxonomy'  => 'product_cat',
  				'field'     => 'slug',
  				'terms'     => $category ));
  	}
	$default = sw_check_product_visiblity( $default );
	
  	ob_start();
  	$pf_id = 'sw_onsale_product-'.rand().time();
  	$r = new WP_Query( $default );
  	$numb_post = count( $r -> posts );
  	if ( $r->have_posts() ) {
  		?>
  		<div id="<?php echo $pf_id ?>" class="sw-onsale-product vc_element">
  			<?php 
  			if( $title != '' ){
  				$titles = strpos($title, ' ');
  				?>
  				<div class="box-title"><h2><span><?php echo substr( $title, 0, $titles ) ?></span> <?php echo substr( $title, $titles + 1 ) ?></h2></div>
  				<?php }
  				while ( $r -> have_posts() ) : $r -> the_post();
  				global $product, $post;
  				?>
  				<div class="content-wrap">	
  					<div class="item">
  						<div class="item-inner clearfix">
  							<div class="item-thumbnail pull-left">
  								<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>">
  									<?php 
  									if( has_post_thumbnail() ){  
  										echo ( get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) ) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
  									}else{ 
  										echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
  									}
  									?>
  								</a>
  								<?php echo revo_quickview();?>
  							</div>
  							<div class="item-content">
  								<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
  								<div class="item-price"><p><?php echo $product->get_price_html() ?></p></div>
  								<div class="item-button">
  									<?php woocommerce_template_loop_add_to_cart(); ?>	
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
  					</div>
  					<?php 
  					endwhile;
  					wp_reset_postdata();
  					?>
  				</div>
  				<?php 
  			}
  			$content = ob_get_clean();
  			return $content;
  		}
  		add_shortcode('onsale','sw_onsale_shortcode');

 /*
 * Page Hot Deals product
 *
 */
 
 function sw_products_deal_shortcode($atts){
 	extract(shortcode_atts(array(		
 		'title'					=> '',
 		'title_length'  => 0,
 		'numberposts' 	=> 5,
 		'el_class'			=> '',
 		'category'			=> '',
 		'columns' 			=> 4,
 		'columns1' 			=> 4,
 		'columns2' 			=> 3,
 		'columns3' 			=> 2
 		),$atts));
 	ob_start();
 	$deal_id = 'sw_deal_'. rand().time();
 	$class_col = ' col-lg-'. ( 12 / $columns ) .' col-md-'. ( 12 / $columns1 ) .' col-sm-'. ( 12 / $columns2 ) .' col-xs-'. ( 12 / $columns3 ) ;
 	?>
 	<div id="<?php echo esc_attr( $deal_id ); ?>" class="sw-hotdeal <?php echo esc_attr( $el_class ); ?>">
 		<?php if( $title != '' ) : ?>
 			<div class="block-title">
 				<?php echo '<h2>' . $title . '</h2>'; ?>
 			</div>
 		<?php endif; ?>
 		<div class="sw-hotdeal-content clearfix row">
 			<?php 
 			$default = array(
 				'post_type'	=> 'product',
 				'showposts'	=> $numberposts,
 				'meta_query' => array(					
 					array(
 						'key' => '_sale_price',
 						'value' => 0,
 						'compare' => '>',
 						'type' => 'DECIMAL(10,5)'
 						)				
 					)
 				);
 			if( $category != '' ){
 				$default['tax_query'] = array(
 					array(
 						'taxonomy'	=> 'product_cat',
 						'field'	=> 'slug',
 						'terms'	=> $category
 						)
 					);
 			}
			$default = sw_check_product_visiblity( $default );
			
 			$list = new WP_Query( $default );
 			if( $list->have_posts() ) :
 				?>
 			<?php
 			while( $list->have_posts() ) : $list->the_post();
 			global $product, $post;
 			?>	
 			<div class="item <?php echo esc_attr( $class_col );?>">
 				<div class="item-wrap">
 					<div class="item-detail">										
 						<div class="item-img products-thumb">			
 							<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
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
 							<!-- add to cart, wishlist, compare -->
 							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
 						</div>								
 					</div>
 				</div>
 			</div>
 		<?php endwhile; wp_reset_postdata(); ?>
 	<?php endif; ?>
 </div>
</div>
<?php
$content = ob_get_clean();
return $content;
}
add_shortcode( 'product_deal', 'sw_products_deal_shortcode' );
/*
**	Countdown Banner
*/
function sw_banner_countdown_shortcode($atts){
	extract(shortcode_atts(array(		
		'title'			=> '',
		'el_class'	=> '',
		'images'		=> '',
		'date'			=> '',
		'url'			=> '',
		),$atts));
	ob_start();
	$bcd_id = 'banner_countdown_'.rand().time();
	$countdown_time = strtotime( $date );
	?>
	<div id="<?php echo esc_attr( $bcd_id ); ?>" class="banner-shortcode <?php echo $el_class ?>">
		<div class="container">
			<?php if( $title != '') { ?>
			<div class="wp-order-title">
				<div class="order-title">
					<?php
					$titles = strpos($title, ' ');
					$title1 = ($titles !== false) ? '<span>' . substr($title, 0, $titles) . '</span>' .' '. substr($title, $titles + 1): $title ;
					echo '<h2><strong>'. $title1 .'</strong></h2>';
					?>
				</div>
			</div>
			<?php } ?>
			<div class="banner-inner clearfix">
				<?php if( $images != '' && $url != '' ) : ?>
				<?php $img = wp_get_attachment_image( $images, 'full' ); ?>
				<div class="item-banner pull-left"><a href="<?php echo esc_url( $url ); ?>"><?php echo $img ?></a></div>
				<?php endif; ?>
				<div class="banner-countdown custom-font" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>"></div>
			</div>
      <div class="banner-close pull-right"><?php esc_html_e( "icon", 'sw_woocommerce' )?></div>
		</div>
	</div>
	<?php 
	$content = ob_get_clean();
	return $content;
}
add_shortcode( 'banner_countdown', 'sw_banner_countdown_shortcode' );


/*
** Rating Comment
*/
function sw_rating_shortcode($atts){
	extract(shortcode_atts(array(		
		'title'				=> '',
		'description'	=> '',
		'length'			=> 25,
		'numberposts'	=> 5,
		'columns' 		=> 4,
		'columns1' 		=> 4,
		'columns2' 		=> 3,
		'columns3' 		=> 2,
		'columns4' 		=> 1,
		'speed' 			=> 1000,
		'autoplay' 		=> 'false',
		'interval' 		=> 5000,
		'scroll' 			=> 1,
		'el_class'		=> ''
		),$atts));
	ob_start();
	?>
	<div id="<?php echo 'latest_review_' .rand().time(); ?>" class="responsive-slider sw-latest-review loading <?php echo esc_attr( $el_class ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php if( $title != '' ) : ?>
			<div class="box-slider-title">
				<h2 class="page-title-slider"><?php echo $title; ?></h2>
				<?php echo ( $description != '' ) ? '<div class="slider-description">'. $description .'</div>' : ''; ?>
			</div>   
		<?php endif; ?>
		<div class="resp-slider-container">
			<div class="slider responsive">	
				<?php 
				$comments = get_comments( array( 'orderby' => 'comment_date', 'order' => 'DESC', 'post_type' => 'product', 'status' => 'approve', 'number' => $numberposts ) );
				foreach( $comments as $key => $comment ) {
					$item_review = get_comment_meta( $comment->comment_ID, 'rating', true );
					?>
					<div class="item item-comment">
						<div class="item-content-top">
							<h4><?php echo esc_html( $comment->comment_author ); ?></h4>
							<div class="item-revivew" >
								<span style="width:<?php echo esc_attr( 17*intval( $item_review ) . 'px' ); ?>"></span>
							</div>
						</div>				
						<div class="item-content">
							<?php echo wp_trim_words( $comment->comment_content, $length, '...' ); ?> 
						</div>
						<div class="item-post">
							<?php 
							$comment_post = '<a href="'. get_permalink( $comment->comment_post_ID ) .'"> '. get_the_title( $comment->comment_post_ID ) .'</a>';
							echo sprintf( __( 'On: %s', 'sw_woocommerce' ), $comment_post ); 
							?>						
						</div>	
						<div class="item-date">
							<?php $post_time = strtotime( get_comment_date( get_option( 'date_format' ), $comment->comment_ID ) ); ?>
							<?php echo sprintf( __( 'Post %s ago', 'sw_woocommerce' ), human_time_diff( $post_time, current_time('timestamp') ) ); ?>
						</div>
					</div>
					<?php 
				}
				?>
			</div>
		</div>
	</div>
	<?php 
	$content = ob_get_clean();
	return $content;
}
add_shortcode( 'latest_rating', 'sw_rating_shortcode' );
