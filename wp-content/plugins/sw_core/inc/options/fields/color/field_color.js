(function( $ ) {
	/*
	 *
	 * Flytheme_Options_color function
	 * Adds farbtastic to color elements
	 *
	 */
	$(document).ready(function(){
		$( '.sw-popup-colorpicker' ).each( function(){
			$(this).wpColorPicker();
		});		
	});
})( jQuery );