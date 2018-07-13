<?php 

/**
	* Layout Child Category 1
	* @version     1.0.0
**/
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woo Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}

$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
$viewall = get_permalink( wc_get_page_id( 'shop' ) );
$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category ) 
		),
		'meta_query' => array(			
			array(
				'key' => '_sale_price',
				'value' => 0,
				'compare' => '>',
				'type' => 'DECIMAL(10,5)'
			),
		),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}
$default = sw_check_product_visiblity( $default );

$term_name = '';
$term = get_term_by( 'slug', $category, 'product_cat' );
if( $term ) :
	$term_name = $term->name;
	$viewall = get_term_link( $term->term_id, 'product_cat' );
endif;

$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo 'slider_' . $widget_id; ?>" class="woo-slider-default sw-child-cat2 <?php echo esc_attr( $style );?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="child-top">
			<div class="box-title clearfix">
				<h3><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h3>
				<?php echo ( $description != '' ) ? '<div class="slider-description">'. $description .'</div>' : ''; ?>
				<button class="button-collapse collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo 'child_' . $widget_id; ?>"  aria-expanded="false">
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>					
				</button>
			</div>
				<?php 
			if( $term ) :
				$termchild 		= get_terms( 'product_cat', array( 'parent' => $term->term_id, 'hide_empty' => 0, $number_child ) );
				if( count( $termchild ) > 0 ){
			?>			
				<div class="childcat-content pull-left"  id="<?php echo 'child_' . $widget_id; ?>">
				
				<?php 
					echo '<ul>';
					foreach ( $termchild as $key => $child ) {
						echo '<li><a href="' . get_term_link( $child->term_id, 'product_cat' ) . '">' . $child->name . '</a></li>';
					}
					echo '<li><a href="' . $viewall . '"><i class="fa  fa-caret-right"></i>' .esc_html__('View all', 'sw_woocommerce') . '</a></li>';
					echo '</ul>';
				?>
				</div>
				<?php } ?>
			<?php endif; ?>
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
			?>
				<div class="item <?php echo esc_attr( $class )?> <?php echo ( ( $i== 0 ) ? 'first-item' : '');?> product">
					<div class="item-wrap">
						<div class="item-detail">										
							<div class="item-img products-thumb">
								<?php if( $i == 0) {?>
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
								
									<?php	sw_label_sales() ?>
								
								<?php }else{ ?>
									
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
								
								<?php } ?>
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
							</div>								
						</div>
					</div>
				 </div>
				<?php $i++; endwhile; wp_reset_postdata();?>
			</div>
		</div> 
	</div>
	<?php
	}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'There is not sales product in this category', 'sw_woocommerce' ) .'</p>
	</div>';
	}
?>