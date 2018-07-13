/*
 *
 * SW_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function sw_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');

	jQuery('.sw-radio-img-'+labelclass).removeClass('sw-radio-img-selected');	
	
	jQuery('label[for="'+relid+'"]').addClass('sw-radio-img-selected');
}//function