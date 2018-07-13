<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;
$attachments 	     	  =	 array();
$revo_featured_video   = get_post_meta( $post->ID, 'featured_video_product', true );
$revo_single_thunbmail = ( sw_options( 'product_single_thumbnail' ) ) ? sw_options( 'product_single_thumbnail' ) : 'bottom';
$post_thumbnail_id	 	  = get_post_thumbnail_id( $post->ID );
?>
<div id="product_img_<?php echo esc_attr( $post->ID ); ?>" class="woocommerce-product-gallery woocommerce-product-gallery--with-images images product-images loading" data-vertical="<?php echo ( $revo_single_thunbmail == 'left' || $revo_single_thunbmail == 'right' ) ? 'true' : 'false'; ?>" data-video="<?php echo ( $revo_featured_video != '' ) ?  esc_url( 'https://www.youtube.com/embed/' . $revo_featured_video ) : ''; ?>">
	<figure class="woocommerce-product-gallery__wrapper">
	<div class="product-images-container clearfix <?php echo esc_attr( 'thumbnail-' . $revo_single_thunbmail ); ?>">
		<?php 
			$attachments = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
			if( has_post_thumbnail() ){ 				
				$image_id 	 = get_post_thumbnail_id();
				array_unshift( $attachments, $image_id );
				$attachments = array_unique( $attachments );
			}
			if( sizeof( $attachments ) ){			
		?>
		<!-- Image Slider -->
		<div class="slider product-responsive">
			<?php 
				foreach ( $attachments as $key => $attachment ) { 
				$full_size_image  = wp_get_attachment_image_src( $attachment, 'full' );
				$thumbnail_post   = get_post( $attachment );

				$attributes = array(
					'class' => 'wp-post-image',
					'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
					'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);
			?>
			<div data-thumb="<?php echo wp_get_attachment_image_url( $attachment, 'shop_thumbnail' ) ?>" class="woocommerce-product-gallery__image">	
				<a href="<?php echo wp_get_attachment_url( $attachment ) ?>"><?php echo wp_get_attachment_image( $attachment, 'shop_single', false, $attributes ); ?></a>
			</div>
			<?php } ?>
		</div>
		<!-- Thumbnail Slider -->
		<?php do_action('woocommerce_product_thumbnails'); ?>
		<?php }else{ ?>			
			<div class="single-img-product">
				<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'revo' ) ), $post->ID ); ?>
			</div>
		<?php } ?>
	</div>
	</figure>
</div>