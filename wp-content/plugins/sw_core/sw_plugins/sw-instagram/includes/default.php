<?php $widget_id = isset( $widget_id ) ? $widget_id : $this->generateID(); ?>
<div id="<?php echo esc_attr( $widget_id ); ?>" class="sw-instagram-gallery">
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
		if( isset( $instagram->data ) && count( $instagram->data ) > 0 ){
			foreach( $instagram->data as $key => $img ){
				$url[$key] = $img->link;
				$images[$key] = $img->images;
			}
			if( count( $images ) > 0 ) :
				?>
			<!-- Gallery Content -->

			<div class="intagram-gallery-content">

				<?php foreach( $images as $i => $image ) : ?>
					<div class="item pull-left">
						<a target="_blank" href="<?php echo esc_url( $url[$i] ); ?>"><img src="<?php echo esc_url( $image->standard_resolution->url );?>" alt=""/></a>
					</div>
				<?php endforeach; ?>
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