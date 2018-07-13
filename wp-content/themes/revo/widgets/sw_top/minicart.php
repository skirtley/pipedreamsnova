<?php 
	do_action( 'before' ); 
?>
<?php if ( class_exists( 'WooCommerce' ) && !sw_options( 'disable_cart' ) ) { ?>
<?php
	$revo_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	if($revo_page_header == 'style7'){
		get_template_part( 'woocommerce/minicart-ajax-style3' ); 
	}elseif($revo_page_header == 'style12'){
		get_template_part( 'woocommerce/minicart-ajax-style5' );
	}elseif($revo_page_header == 'style6'){
		get_template_part( 'woocommerce/minicart-ajax-style2' ); 
	}else{
		get_template_part( 'woocommerce/minicart-ajax' ); 
	}
	
?>
<?php } ?>