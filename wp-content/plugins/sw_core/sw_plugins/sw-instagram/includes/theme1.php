<?php $widget_id = isset( $widget_id ) ? $widget_id : $this->generateID(); ?>
<div id="<?php echo esc_attr( $widget_id ) ?>" class="sw-instagram-slider responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<?php if( $title != '' ) : ?>
		<h3><span><?php echo $title; ?></span></h3>
	<?php endif; ?>
	<?php
	$instagram = get_transient ( 'instagram_gallery' );
	if( empty( $instagram ) ){
		$instagrams = $this->Get_Instagram_Gallery( $userid, $access_token, $numberposts );
		set_transient( 'instagram_gallery', $instagrams, 60*60*12 );
	}else{
		$instagram = $this->Get_Instagram_Gallery( $userid, $access_token, $numberposts );
	}
	$url = array();
	$images = array();
	if( !isset( $instagram->meta->error_message ) ) {
		$widget_id = isset( $widget_id ) ? $widget_id : 'sw_instagram_gallery_'. rand().time();
		if( isset( $instagram->data ) && is_array( $instagram->data ) && count( $instagram->data ) > 0 ){
			foreach( $instagram->data as $key => $img ){
				$url[$key] = $img->link;
				$images[$key] = $img->images;
			}
			if( count( $images ) > 0 ) :
				?>
			<!-- Gallery Content -->
				<div class="resp-slider-container">
					<div class="slider responsive">
						<?php foreach( $images as $i => $image ) : ?>
							<div class="item">
								<a target="_blank" href="<?php echo esc_url( $url[$i] ); ?>"><img src="<?php echo esc_url( $image->standard_resolution->url );?>" alt=""/><span class="fa fa-instagram"></span></a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php 
			endif;
		} 
	}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>' . $instagram->meta->error_message . '</p>
	</div>'; 
}
?>
</div>