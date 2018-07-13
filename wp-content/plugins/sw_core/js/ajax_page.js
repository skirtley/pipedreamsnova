/*
	** Category Ajax Js
	** Version: 1.0.0
*/
(function ($) {
	$(document).ready(function(){
		/* Category slider ajax */
		var el = $( '.active [data-type=page-ajax]' );
		el.each( function(){
			var els = $(this);
			sw_page_listing_ajax( els );
		});		
		$('[data-type=page-ajax]').on('click', function() {
			sw_page_listing_ajax( $(this) );
		});
		
		
		function sw_page_listing_ajax( element ) {			
			var target 		= $( element.attr( 'href' ) );
			var pageid  	= element.data( 'id' );
			var action = 'sw_page_listing';
			var ajaxurl   = sw_page.ajax_url;
			if( target.html() == '' ){
				target.parent().addClass( 'loading' );
				var data 		= {
					action: action,
					pageid: pageid
				};
				jQuery.post(ajaxurl, data, function(response) {
					target.html( response );
					target.parent().removeClass( 'loading' );
				});
			}
		}
		
	});
})(jQuery);