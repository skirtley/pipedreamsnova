/*
 *
 * SW_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function revo_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');

	jQuery('.revo-radio-img-'+labelclass).removeClass('revo-radio-img-selected');	
	
	jQuery('label[for="'+relid+'"]').addClass('revo-radio-img-selected');
}//function