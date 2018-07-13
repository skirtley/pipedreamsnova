<?php 
	if( !is_singular( 'product' ) ){
		return ;
	}
	global $product, $woocommerce, $woocommerce_loop;
	$upsells = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_upsell_ids() : $product->get_upsells();
	if( count($upsells) == 0 || is_archive() ) return ;	
	$default = array(
		'post_type' => 'product',
		'post__in'   => $upsells,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$list = new WP_Query( $default );

	if ( $list -> have_posts() ){
?>
	<div id="<?php echo 'sliderup_' . $widget_id; ?>" class="sw-woo-container-slider upsells-products responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
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