(function($) {
	"use strict";
	
	$( 'a[data-toggle="collapse"]' ).on( 'click', function (){
		var target = $(this).data( 'target' );
		$(this).parent().toggleClass('active');
		$(target).toggle(300);
	});
	
	$( '.panel-title input[type="checkbox"]' ).on( 'click', function(){
		var value = 0, attr = $(this).attr('checked');
		if ( typeof attr !== typeof undefined && attr !== false ) {
			value = $(this).val();
		}
		var target = $(this).parents( '.panel-title' ).find( 'a[data-toggle="collapse"]' ).data( 'target' );
		if( value == 1 ){
			$(target).find( '.custom-picker' ).hide(300);
			$(target).find( '.form-upload' ).show(300);
		}else{
			$(target).find( '.form-upload' ).hide(300);
			$(target).find( '.custom-picker' ).show(300);
		}
	});
	
	$( '.form-upload' ).each( function(){
		var tar_parent = $(this);
		// Only show the "remove image" button when needed
		if ( ! tar_parent.find( '.thumbnail' ).val() ) {
			tar_parent.find( '.remove_image_button_custom' ).hide();
		}

		// Uploading files
		var file_frame;

		tar_parent.find( '.upload_image_button_custom' ).on( 'click', function( event ) {
			
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.downloadable_file = wp.media({
				title: 'Choose an image',
				button: {
					text: 'Use image'
				},
				multiple: false
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				var attachment = file_frame.state().get( 'selection' ).first().toJSON();
				console.log( attachment );
				tar_parent.find( '.thumbnail' ).val( attachment.id );
				tar_parent.find( '.product-thumbnail > img' ).attr( 'src', attachment.sizes.thumbnail.url );
				tar_parent.find( '.remove_image_button' ).show();
			});

			// Finally, open the modal.
			file_frame.open();
		});

		tar_parent.find( '.remove_image_button_custom' ).on( 'click', function() {
			tar_parent.find( '.product-thumbnail > img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
			tar_parent.find( '.thumbnail' ).val( '' );
			tar_parent.find( '.remove_image_button_custom' ).hide();
			return false;
		});
	});
})(jQuery);