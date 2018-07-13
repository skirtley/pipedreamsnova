<?php 
/**
	* Layout Featured
	* @version     1.0.0
**/


$term_name = esc_html__( 'Featured Products', 'sw_woocommerce' );
$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
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
	$viewall = get_term_link( $term->term_id, 'product_cat' );
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
	<div id="<?php echo $id; ?>" class="featured-mobile style-moblie clearfix">
		<div class="block-title">
			<h3><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h3>
			<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
		</div>
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
				<div class="item product <?php echo esc_attr( $class )?>" id="<?php echo 'product_'.$id.$post->ID; ?>">
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
		<div class="woocommmerce-shop"><a href="<?php echo esc_url($viewall); ?>" title="Woocommerce Shop"><?php echo esc_html__('See more','sw_woocommerce');?></a></div>
	</div>
<?php
}	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'There is not product in this category', 'sw_woocommerce' ) .'</p>
	</div>';
	}
?>