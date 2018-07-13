<?php 
	/**
		** Theme: Responsive Page Listing
		** Author: Smartaddons
		** Version: 1.0
	**/
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a page for Sw Responsive Page Listing. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
?>
<div id="<?php echo esc_attr( 'page_list_' . $widget_id ) ?>" class="resp-page-listing " data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title"><?php echo ( $title1 != '' ) ? '<h3>'. esc_html( $title1 ) .'</h3>' : ''; ?></div>
		<div class="resp-lising-container clearfix">
			<?php 
				foreach( $category as $key => $page_id ) { 
					$page = get_post( $page_id );
					$class = ( has_post_thumbnail( $page_id ) ) ? 'has-thumbnail' : '';
					if( $page ) :
			?>			
				<div class="item-page-listing pull-left <?php echo esc_attr( $class ); ?>">
					<?php if( has_post_thumbnail( $page_id ) ) : ?>
					<div class="item-thumbnail">
						<a href="<?php echo get_permalink( $page_id ); ?>" title="<?php echo esc_attr( $page->post_title ); ?>"><?php echo get_the_post_thumbnail( $page_id ); ?></a>
					<?php endif; ?>
						<h4><a href="<?php echo get_permalink( $page_id ); ?>" title="<?php echo esc_attr( $page->post_title ); ?>"><?php echo esc_html( $page->post_title ) ?></a></h4>
					</div>
				</div>
				<?php endif; ?>
			<?php } ?>
		</div>
</div>