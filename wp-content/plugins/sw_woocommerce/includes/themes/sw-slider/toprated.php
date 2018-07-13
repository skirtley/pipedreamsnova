<?php 

/**
	* Layout Top Rated
	* @version     1.0.0
**/


$term_name = esc_html__( 'Top Rated Products', 'sw_woocommerce' );
$default = array(
	'post_type'		=> 'product',		
	'post_status' 	=> 'publish',
	'no_found_rows' => 1,					
	'showposts' 	=> $numberposts						
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
	endif;
	
	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'slug',
			'terms'		=> $category,
			'operator' 	=> 'IN'
		)
	);
}
$default = sw_check_product_visiblity( $default );

if( sw_woocommerce_version_check( '3.0' ) ){	
	$default['meta_key'] = '_wc_average_rating';	
	$default['orderby'] = 'meta_value_num';
}else{	
	add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
}

$id = 'sw_toprated_'.$this->generateID();
$list = new WP_Query( $default );

if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider toprated-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title">
			<h3><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h3>
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
					<?php include( WCTHEME . '/default-item2.php' ); ?>
			<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			
			<?php 
				$i++; endwhile;
				remove_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
				wp_reset_postdata();
			?>
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