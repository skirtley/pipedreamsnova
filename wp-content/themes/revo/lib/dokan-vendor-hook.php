<?php 
/*
	* Name: Dokan Vendor Hook
	* Develop: SmartAddons
*/

add_action( 'wp', 'revo_dokan_hook' );
function revo_dokan_hook(){
	 if ( dokan_is_store_page () ) {
		remove_action( 'woocommerce_before_main_content', 'revo_banner_listing', 10 );
	}
}
