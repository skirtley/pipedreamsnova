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
<div id="<?php echo esc_attr( 'page_list_' . $widget_id ) ?>" class="resp-ajax-page-listing">
	<div class="block-title"><?php echo ( $title1 != '' ) ? '<h3>'. esc_html( $title1 ) .'</h3>' : ''; ?></div>
	<div class="page-listing-content clearfix">
		<ul class="nav nav-tabs pull-left">
			<?php 
				$key = 0;
				foreach( $category as  $page_id ) { 
					$page = get_post( $page_id );
					if( $page ) {
			?>			
				<li class="<?php echo ( $key == 0 ) ? 'active' : ''; ?>">
						<a href="<?php echo esc_attr( '#'. $widget_id . $page_id ); ?>" data-toggle="tab" data-type="page-ajax" data-id="<?php echo esc_attr( $page_id ); ?>"  title="<?php echo esc_attr( $page->post_title ); ?>"><?php echo esc_html( $page->post_title ); ?></a>
				</li>
				<?php $key ++; } ?>
			<?php } ?>
		</ul>
		<div class="tab-content">
			<?php 
				$key = 0;
				foreach( $category as  $page_id ) { 
					$page = get_post( $page_id );
					if( $page ) :
			?>			
				<div id="<?php echo esc_attr( $widget_id . $page_id ); ?>" class="tab-pane fade in <?php echo ( $key == 0 ) ? 'active' : '' ?>"></div>
				<?php $key ++; endif; ?>
			<?php } ?>
		</div>
	</div>
</div>