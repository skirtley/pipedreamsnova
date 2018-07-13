<?php 
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
?>
<div class="sw-tab-mobile sw-ajax style-moblie" id="<?php echo esc_attr( $widget_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="woocommmerce-shop"><a href="<?php echo esc_url( $viewall ); ?>" title="<?php esc_html_e( 'Woocommerce Shop', 'sw_woocommerce' ) ?>"><?php echo esc_html__('View all','sw_woocommerce');?></a></div>
			<ul class="nav nav-tabs">
				<?php 
						$active = $tab_active -1;
						$tab_title = '';
						foreach( $select_order as $i  => $so ){						
							switch ($so) {
							case 'latest':
								$tab_title = __( 'New arrivals', 'sw_woocommerce' );
							break;
							case 'rating':
								$tab_title = __( 'Top Rating', 'sw_woocommerce' );
							break;
							case 'bestsales':								
								$tab_title = __( 'Best Selling', 'sw_woocommerce' );
							break;						
							default:
								$tab_title = __( 'Featured Products', 'sw_woocommerce' );
							}
					?>
					<li <?php echo ( $i == $active )? 'class="active loaded"' : ''; ?>>
						<a href="#<?php echo esc_attr( $so. '_' .$widget_id ) ?>" data-type="so_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
					</li>			
				<?php } ?>
			</ul>
		</div>		
		<div class="tab-content clearfix">	
		<!-- Product tab slider -->						
			<div class="tab-pane active" id="<?php echo esc_attr( $select_order[$active]. '_' .$widget_id ) ?>">
			<?php 
				$default = array();			
				if( $select_order[$active] == 'latest' ){
					$default = array(
						'post_type'	=> 'product',
						'paged'		=> 1,
						'showposts'	=> $numberposts,
						'orderby'	=> 'date'
					);						
				}
				if( $select_order[$active] == 'rating' ){
					$default = array(
						'post_type'		=> 'product',							
						'post_status' 	=> 'publish',
						'no_found_rows' => 1,					
						'showposts' 	=> $numberposts						
					);
					if( sw_woocommerce_version_check( '3.0' ) ){	
						$default['meta_key'] = '_wc_average_rating';	
						$default['orderby'] = 'meta_value_num';
					}else{	
						add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
					}
				}
				if( $select_order[$active] == 'bestsales' ){
					$default = array(
						'post_type' 			=> 'product',							
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'showposts'				=> $numberposts,
						'meta_key' 		 		=> 'total_sales',
						'orderby' 		 		=> 'meta_value_num',						
					);
				}
				if( $select_order[$active] == 'featured' ){
					$default = array(
						'post_type'	=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'	=> 1,
						'showposts' 		=> $numberposts,						
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
				}
				if( $category != '' ){
					$default['tax_query'][] = array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category,
						'operator' 	=> 'IN'
					);
				}
				$default = sw_check_product_visiblity( $default );
				
				$list = new WP_Query( $default );
				if( $select_order[$active] == 'rating' && ! sw_woocommerce_version_check( '3.0' ) ){			
					remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
				}
				if( $list->have_posts() ) :
			?>	
				<div id="<?php echo esc_attr( 'tab_mobile'. $target ); ?>" class="sw-mobile-tab"> 
					<div class="resp-slider-container">
						<div class="items-wrapper clearfix">	
							<?php 
								$count_items = 0;
								$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
								$i = 0;
								while($list->have_posts()): $list->the_post();					
								global $product, $post;
								$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
								$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
								if( $i % $item_row == 0 ){
							?>
								<div class="item product <?php echo esc_attr( $class )?>">
								<?php } ?>
									<div class="item-wrap">
										<div class="item-detail">
											<div class="item-image">									
												<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
												<?php sw_label_sales() ?>
											</div>
											<div class="item-content">
												<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
												<!-- Price -->
												<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
												<?php } ?>								
											</div>															
										</div>
									</div>
								<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
							<?php $i ++; endwhile; wp_reset_postdata();?>
						</div> 
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>			
		<!-- End product tab slider -->
	</div>
</div>
