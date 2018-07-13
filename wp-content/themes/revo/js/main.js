(function($) {
	"use strict";
	
	/* 
	** Add Click On Ipad 
	*/
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
	
	/* Check variable if has swatches variation */
	if( $('body').hasClass( 'sw-wooswatches' ) ){
		$( '.sw-wooswatches .product-type-variable' ).each(function(){
			var h_swatches = $(this).find( '.sw-variation-wrapper' ).height() + 20;
			$(this).find( '.item-bottom' ).css( 'bottom', h_swatches );
		});
	}
	
	/*
	** Blog Masonry
	*/
	$(window).load(function() {
		if( $.isFunction( $.isotope ) ){
			$('body').find('.blog-content-grid').isotope({ 
				layoutMode : 'masonry'
			});
		}
	});
	
	/*
	** Search on click
	*/
	$('.header-style6 .search-cate .search-home6').on('click', function(){
		$('.top-form.top-search').toggleClass("open");
	});
	
	$('.header-style9 .search-home9 h3').on('click', function(){
		$('.top-form.top-search').toggleClass("open");
	});
	
	$('.header-style7 .vertical_megamenu .mega-left-title').on('click', function(){
		$('.header-style7 .vertical_megamenu').toggleClass("open");
	});
	
	$('.header-style8 .vertical_megamenu .mega-left-title').on('click', function(){
		$('.header-style8 .vertical_megamenu').toggleClass("open");
	});
	
	$('.header-right .menu-confirmation .text-confirmation').on('click', function(){
		$('.header-right .menu-confirmation').toggleClass("open");
	});
	
	$('.main-menu .header-close').on('click', function(){
		$('.main-menu').removeClass("open");
	});
	$('.header-open').on('click', function(){
		$('.main-menu').toggleClass("open");
	});
	/*
	**  show menu mobile
	*/
	$('.header-menu-categories .open-menu').on('click', function(){
		$('.main-menu').toggleClass("open");
	});
	
	$('.footer-mstyle1 .footer-menu .footer-search a').on('click', function(){
		$('.top-form.top-search').toggleClass("open");
	});
	
	$('.footer-mstyle1 .footer-menu .footer-more a').on('click', function(){
		$('.menu-item-hidden').toggleClass("open");
	});
	
	/*
	** js mobile
	*/
	$('.single-product.mobile-layout .social-share .title-share').on('click', function(){
		$('.single-product.mobile-layout .social-share').toggleClass("open");
	});
	$('.single-post.mobile-layout .social-share .title-share').on('click', function(){
		$('.single-post.mobile-layout .social-share').toggleClass("open");
	});

	$('.single-post.mobile-layout .social-share.open .title-share').on('click', function(){
		$('.single-post.mobile-layout .social-share').removeClass("open");
	});
	
	$('.products-nav .filter-product').on('click', function(){
		$('.products-wrapper .filter-mobile').toggleClass("open");
		$('.products-wrapper').toggleClass('show-modal');
	});
	
	$('.products-nav .filter-product').on('click', function(){
		if( $( ".products-wrapper .products-nav .filter-product" ).not( ".filter-mobile" ) ){
			$('.products-wrapper').removeClass('show-modal');
		}	
	});
	
	$('.header-mobile-style5 .header-top-mobile .header-right .search-mobile').on('click', function(){
		$('.header-mobile-style5 .header-top-mobile .mobile-search').toggleClass('open');
	});
	
	$('.header-mobile-style5 .header-top-mobile .header-menu-categories .show_menu ').on('click', function(){
		$('.header-mobile-style5 .header-top-mobile .header-menu-categories .vertical_megamenu').toggleClass('open');
	});
	
	$('.mobile-layout .back-history').on('click', function(){
		window.history.back();
	});
	
	$('.footer-mstyle2 .footer-container .footer-open').on('click', function(){
		$('.footer-mstyle2').toggleClass('open');
	});
	
	$('.footer-mstyle2 .mobile_menu2')
	.find('li:gt(7)') /*you want :gt(4) since index starts at 0 and H3 is not in LI */
	.hide()
	.end()
	.each(function(){
			if($(this).children('li').length > 8){ //iterates over each UL and if they have 5+ LIs then adds Show More...
				$(this).append(
					$('<li><a><span class="menu-title">See more</span><span class="menu-img"></span></a></li>')
					.addClass('showMore')
					.on('click',function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a><span class="menu-title">See less</span><span class="menu-img"></span></a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a><span class="menu-title">See more</span><span class="menu-img"></span></a>').show().siblings('li:gt(7)').hide(400);
						}
					})
					);
			}
		});
	
	$('.header-style1 .header-mid .sticky-search .fa-search').on('click', function(){
		$('.header-style1 .header-mid .sticky-search').toggleClass("open");
	});
	
	
	$('.header-style2 .header-bottom .sticky-search .fa-search').on('click', function(){
		$('.header-style2 .header-bottom .sticky-search').toggleClass("open");
	});
	
	$('.header-style5 .header-bottom .sticky-search .fa-search').on('click', function(){
		$('.header-style5 .header-bottom .sticky-search').toggleClass("open");
	});
	
	/*
	** js layout 8
	*/
	
	$('.header-style8 .header-bottom .sticky-search').on('click', function(){
		$('.header-style8 .header-mid .search-cate').slideToggle("slow");
	});
	
	/*
	** js layout 9
	*/
	
	$('.header-style9 .header-top .text-header-top .remove-banner').on('click', function(){
		$('.header-style9 .header-top').toggleClass("close");
	});
	
	/*
	** js layout 10
	*/
	
	$('.header-style11 .header-mid .search-icon .fa-search').on('click', function(){
		$('.header-style11 .header-mid .search-cate .revo_top .top-form.top-search').slideToggle();
	});
	
	/*
	** js layout 11
	*/
	
	$('.header-style10 .header-bottom .fa-search').on('click', function(){
		$('.header-style10 .header-bottom .sticky-search').toggleClass("open");
	});
	
	/*
	** js layout7
	*/
	
	$('.header-style7 .header-bottom .fa-search').on('click', function(){
		$('.header-style7 .header-bottom .sticky-search').toggleClass("open");
	});
	
	/*
	** js layout12
	*/
	
	$('.header-style12 .sw-setting').on('click', function(){
		$('.header-style12 .sw-setting .mid-header3').slideToggle("open");
	});

	$('.header-style12 .banner-close').on('click', function(){
		$('.header-style12 .top-banner').slideToggle("open");
	});

	$('.header-style12 .sticky-search i').on('click', function(){
		$('.header-style12 .sticky-search .sticky-search-content').slideToggle("open");
	});

	/*add title to button*/
	$("a.compare").attr('title', custom_text.compare_text);
	$(".yith-wcwl-add-button a").attr('title', custom_text.wishlist_text);
	$("a.fancybox").attr('title', custom_text.quickview_text);
	$("a.add_to_cart_button").attr('title', custom_text.cart_text);
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});
	/*
	** Product listing order hover
	*/
	$('ul.orderby.order-dropdown li ul').hide(); 
	$("ul.order-dropdown > li").each( function(){
		$(this).hover( function() {
			$('.products-wrapper').addClass('show-modal');
			$(this).find( '> ul' ).stop().fadeIn("fast");
		}, function() {
			$('.products-wrapper').removeClass('show-modal');
			$(this).find( '> ul' ).stop().fadeOut("fast");
		});
	});
	
	/*
	** Product listing select box
	*/
	$('.catalog-ordering .orderby .current-li a').html($('.catalog-ordering .orderby ul li.current a').html());
	$('.catalog-ordering .sort-count .current-li a').html($('.catalog-ordering .sort-count ul li.current a').html());
	
	/*
	** Quickview and single product slider
	*/
	$(document).ready(function(){
		/* 
		** Slider single product image
		*/
		$( '.product-images' ).each(function(){
			var $rtl 			= $('body').hasClass( 'rtl' );
			var $vertical		= $(this).data('vertical');
			var $img_slider 	= $(this).find('.product-responsive');
			var video_link 		= $(this).data('video');
			var $thumb_slider 	= $(this).find('.product-responsive-thumbnail' );
			var number_slider	= ( $vertical ) ? 4: 5;
			
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider,
				infinite: false
			});
			$thumb_slider.slick({
				slidesToShow: number_slider,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				rtl: $rtl,
				infinite: false,
				vertical: $vertical,
				verticalSwiping: $vertical,
				focusOnSelect: true,
				responsive: [
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 4    
					}
				},
				{
					breakpoint: 360,
					settings: {
						slidesToShow: 2    
					}
				}
				]
			});

			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
				var height = el.find('.product-responsive').outerHeight();
				var target = el.find( ' .item-video' );
				target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

				var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
				var thumb_target = el.find( '.item-video-thumb' );
				thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
			}, 1000);
			if( video_link != '' ) {
				$img_slider.append( '<button data-type="popup" class="featured-video-button fa fa-video-camera" data-video="'+ video_link +'"></button>' );
			}
		});
});

	/*
	** Hover on mobile and tablet
	*/
	var mobileHover = function () {
		$('*').on('touchstart', function () {
			$(this).trigger('hover');
		}).on('touchend', function () {
			$(this).trigger('hover');
		});
	};
	mobileHover();
	
	/*
	** Menu hidden
	*/
	$('.product-categories').each(function(){
		var number	 = $(this).data( 'number' ) - 1;
		var lesstext = $(this).data( 'lesstext' );
		var moretext = $(this).data( 'moretext' );
		if( number > 0 ) {
			$(this).find( 'li:gt('+ number +')' ).hide().end();		
			if( $(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a>'+ moretext +'   +</a></li>')
					.addClass('showMore')
					.on('click',function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html( '<a>'+ lesstext +'   -</a>' ).siblings(':hidden').show(400);
						}else{
							$(this).html( '<a>'+ moretext +'   +</a>' ).show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
					);
			}
		}
	});
	

	var w_width = $(window).width(); 
	if( w_width <= 480){
		jQuery('.mobile-layout .header-mobile-style5 .revo_resmenu')
		.find(' > li:gt(6) ') 
		.hide()
		.end()
		.each(function(){
			if($(this).children('li').length > 6){ 
				$(this).append(
					$('<li><a class="open-more-cat">More Categories</a></li>')
					.addClass('showMore')
					.on('click', function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a class="close-more-cat">Close Categories</a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a class="open-more-cat">More Categories</a>').show().siblings('li:gt(6)').hide(400);
						}
					})
					);
			}
		});
	}
	/* 
	** Fix accordion heading state 
	*/
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});	

	
	/*
	** Cpanel
	*/
	$('#cpanel').collapse();

	$('#cpanel-reset').on('click', function(e) {

		if (document.cookie && document.cookie != '') {
			var split = document.cookie.split(';');
			for (var i = 0; i < split.length; i++) {
				var name_value = split[i].split("=");
				name_value[0] = name_value[0].replace(/^ /, '');

				if (name_value[0].indexOf(cpanel_name)===0) {
					$.cookie(name_value[0], 1, { path: '/', expires: -1 });
				}
			}
		}

		location.reload();
	});

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');
				var date = new Date();
				date.setTime(date.getTime() + (30 * 1000));
				$.cookie( name , 0, { path: '/', expires: date });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;

			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});
	
	/*
	** Language
	*/
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
	 //console.log($(this).html());
	 $current = $(this).html();
	 $('#lang_sel ul > li > a.lang_sel_sel').html($current);
	 $a = $.cookie('lang_select_revo', $current, { expires: 1, path: '/'}); 
	});
	
	if( $.cookie('lang_select_revo') && $.cookie('lang_select_revo').length > 0 ) {
		$('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_revo'));
	}

	$('#lang_sel ul > li.icl-ar').click(function(){
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'revo_lang_en' , 1, { path: '/', expires: 1 });
	});
	
	$('#lang_sel ul > li.icl-en').click(function(){
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'revo_lang_en' , 0, { path: '/', expires: -1 });
	});
	
	var Revo_Lang = $.cookie( 'revo_lang_en' );
	if( Revo_Lang == null ){
		$('#lang_sel ul > li.icl-en').addClass( 'active' );
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
	}else{
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$('#lang_sel ul > li.icl-ar').addClass( 'active' );
	}
	
	/*
	** Clear header style 
	*/
	$( '.revo-logo' ).on('click', function(){
		$.cookie("revo_header_style", null, { path: '/' });
		$.cookie("revo_footer_style", null, { path: '/' });
	});
	
	/*
	** Footer accordion
	*/
	if ($(window).width() < 768) {	

		$('.footer .widget_nav_menu h2.widgettitle').append('<span class="icon-footer"></span>');
		$('.footer .wpb_content_element .info-footer h3').append('<span class="icon-footer"></span>');

		$(".footer .widget_nav_menu h2.widgettitle").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul.menu").slideToggle();
			});
		});
		
		$(".footer .wpb_content_element .info-footer h3").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul").slideToggle();
			});
		});	
		
	}
	
	if ($(window).width() < 768) {	
		
		$('.footer .footer-style7 .wpb_content_element .newletter h3').append('<span class="icon-footer"></span>');
		
		$(".footer .footer-style7 .wpb_content_element h3").each(function(){
			$(this).on('click', function(){
				$(this).parent().find(".wrapper-footer").slideToggle();
			});
		});	
		
		
		$('.footer .footer-home10 .wpb_content_element h3').append('<span class="icon-footer"></span>');

		$(".footer .footer-home10 .wpb_content_element h3").each(function(){
			$(this).on('click', function(){
				$(this).parent().find(".wrapper-footer").slideToggle();
			});
		});		
		
	}
	
	
	/*
	** Back to top
	**/
	$("#revo-totop").hide();
	var wh = $(window).height();
	var whtml = $(document).height();
	$(window).scroll(function () {
		if ($(this).scrollTop() > whtml/10) {
			$('#revo-totop').fadeIn();
		} else {
			$('#revo-totop').fadeOut();
		}
	});
	
	$('#revo-totop').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	/* end back to top */

 /*
 ** Fix js 
 */
 $('.wpb_map_wraper').on('click', function () {
 	$('.wpb_map_wraper iframe').css("pointer-events", "auto");
 });

 $( ".wpb_map_wraper" ).on('mouseleave', function() {
 	$('.wpb_map_wraper iframe').css("pointer-events", "none"); 
 });

	/*
	** Change Layout 
	*/
	$( window ).load(function() {	
		if( $( 'body' ).hasClass( 'tax-product_cat' ) || $( 'body' ).hasClass( 'post-type-archive-product' ) || $( 'body' ).hasClass( 'tax-dc_vendor_shop' ) ) {
			$('.grid-view').on('click',function(){
				$('.list-view').removeClass('active');
				$('.grid-view').addClass('active');
				jQuery("ul.products-loop").fadeOut(300, function() {
					$(this).removeClass("list").fadeIn(300).addClass( 'grid' );			
				});
			});
			
			$('.list-view').on('click',function(){
				$( '.grid-view' ).removeClass('active');
				$( '.list-view' ).addClass('active');
				$("ul.products-loop").fadeOut(300, function() {
					jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
				});
			});
			/* End Change Layout */
		} 
	});
	$(window).scroll(function() {    
		var whtop = $(window).scrollTop(); 
		if (whtop > 0) {
			$(".header-style4").addClass("header-ontop");
		} else {
			$(".header-style4").removeClass("header-ontop");
		} 
	});
	
	/*remove loading*/
	$(".sw-woo-tab").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});
	$(".responsive-slider").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});
}(jQuery));

/*
** Check comment form
*/
function submitform(){
	if(document.commentform.comment.value=='' || document.commentform.author.value=='' || document.commentform.email.value==''){
		alert('Please fill the required field.');
		return false;
	} else return true;
}
(function($){		
	
	/*Verticle Menu*/
	if( !( $('#header').hasClass( 'header-style7' ) ) ) {
		$('.vertical-megamenu').each(function(){
			var number	 = $(this).parent().data( 'number' ) - 1;
			var lesstext = $(this).parent().data( 'lesstext' );
			var moretext = $(this).parent().data( 'moretext' );
			$(this).find(	' > li:gt('+ number +')' ).hide().end();		
			if($(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a class="open-more-cat">'+ moretext +'</a></li>')
					.addClass('showMore')
					.on('click', function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a class="close-more-cat">'+ lesstext +'</a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a class="open-more-cat">'+ moretext +'</a>').show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
					);
			}
		});
	}


	$(".widget_nav_menu li.menu-compare a").hover(function() {
		$(this).css('cursor','pointer').attr('title', custom_text.compare_text);
	}, function() {
		$(this).css('cursor','auto');
	});
	$(".widget_nav_menu li.menu-wishlist a").hover(function() {
		$(this).css('cursor','pointer').attr('title', custom_text.wishlist_text);
	}, function() {
		$(this).css('cursor','auto');
	});
	
	var w_width = $(window).width();	
	if( $('#header' ).hasClass('header-style7') && w_width >= 1024 ){	
		
		function h7_vertical_align(){
			var w_height = $(window).outerHeight();
			var h7_vtarget = $('.header-style7 .vertical_megamenu .wrapper_vertical_menu' );
			var h7_offset = w_height - h7_vtarget.height();					
			return h7_vtarget.parents( '.vertical_megamenu' ).css( 'top', ( h7_offset/2 + 50 )  );
		}
		$(document).ready(function(){
			h7_vertical_align();
		});
		
		$(window).on('resize', function(){
			h7_vertical_align();
		});
		var h7_rtl = $('body').hasClass('rtl');
		$('.header-style7 .vertical_megamenu .mega-left-title').on( 'click', function(e) {						
			var parent = $('.header-style7 .vertical_megamenu');
			var width = parent.width();
			if( !h7_rtl ){
				left = parent.css('left');
				if ( parseFloat(left) < -10 ) {
					parent.animate({
						left: '0px',
					}, "slow");
					parent.find( ' .mega-left-title' ).animate({
						left:  width ,
					}, "slow");				
				} else {
					parent.animate({
						left: '-' + width ,
					}, "slow");	
					parent.find( ' .mega-left-title' ).animate({
						left: '0px',
					}, "slow");
				}
			}else{
				right = parent.css('right');
				if ( parseFloat(right) < -10 ) {
					parent.animate({
						right: '0px',
					}, "slow");
					parent.find( ' .mega-left-title' ).animate({
						right:  width ,
					}, "slow");				
				} else {
					parent.animate({
						right: '-' + width ,
					}, "slow");	
					parent.find( ' .mega-left-title' ).animate({
						right: '0px',
					}, "slow");
				}
			}
			if ( $(this).hasClass('active') ) {
				$(this).removeClass('active');
			} 
			e.preventDefault();
		});
}

$(window).scroll(function() {   
	if( $( 'body' ).hasClass( 'mobile-layout' ) ) {
		var target = $( '.mobile-layout #header-page' );
		var sticky_nav_mobile_offset = $(".mobile-layout #header-page").offset();
		if( sticky_nav_mobile_offset != null ){
			var sticky_nav_mobile_offset_top = sticky_nav_mobile_offset.top;
			var scroll_top = $(window).scrollTop();
			if ( scroll_top > sticky_nav_mobile_offset_top ) {
				$(".mobile-layout #header-page").addClass('sticky-mobile');
			}else{
				$(".mobile-layout #header-page").removeClass('sticky-mobile');
			}
		}
	}
});
var w_width = $(window).width();	
if( $('#header' ).hasClass('header-style8') && w_width >= 1024 ){	

	function h8_vertical_align(){
		var w_height = $(window).outerHeight();
		var h8_vtarget = $('.header-style8 .vertical_megamenu .wrapper_vertical_menu' );
		var h8_offset = w_height - h8_vtarget.height();					
		return h8_vtarget.parents( '.vertical_megamenu' ).css( 'top', ( h8_offset/2 + 50 )  );
	}
	$(document).ready(function(){
		h8_vertical_align();
	});

	$(window).on('resize', function(){
		h8_vertical_align();
	});
	var h8_rtl = $('body').hasClass('rtl');
	$('.header-style8 .vertical_megamenu .mega-left-title').on( 'click', function(e) {						
		var parent = $('.header-style8 .vertical_megamenu');
		var width = parent.width();
		if( !h8_rtl ){
			left = parent.css('left');
			if ( parseFloat(left) < -10 ) {
				parent.animate({
					left: '0px',
				}, "slow");
				parent.find( ' .mega-left-title' ).animate({
					left:  width ,
				}, "slow");				
			} else {
				parent.animate({
					left: '-' + width ,
				}, "slow");	
				parent.find( ' .mega-left-title' ).animate({
					left: '0px',
				}, "slow");
			}
		}else{
			right = parent.css('right');
			if ( parseFloat(right) < -10 ) {
				parent.animate({
					right: '0px',
				}, "slow");
				parent.find( ' .mega-left-title' ).animate({
					right:  width ,
				}, "slow");				
			} else {
				parent.animate({
					right: '-' + width ,
				}, "slow");	
				parent.find( ' .mega-left-title' ).animate({
					right: '0px',
				}, "slow");
			}
		}
		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} 
		e.preventDefault();
	});
}

	/**
	* Quickview
	**/
	if( $('body').html().match( /sw-quickview-bottom/ ) ){
		var qv_target =  $('.sw-quickview-bottom');
		$(document).on( 'click', 'button[data-type="popup"]', function(){
			var video_url = $(this).data( 'video' );
			qv_target.addClass( 'show loading' );					
			setTimeout(function(){
				qv_target.find( '.quickview-inner' ).append( '<div class="video-wrapper"><iframe width="560" height="390" src="'+ video_url +'" frameborder="0" allowfullscreen></iframe></div>' );	
				qv_target.find( '.quickview-content' ).css( 'margin-top', ( $(window).height() - qv_target.find( '.quickview-content' ).outerHeight() ) /2 );
				qv_target.removeClass( 'loading' );
			}, 1000);
		});
		$(document).on( 'click', 'a[data-type="quickview"]', function(){
			var product_id = $(this).data( 'product_id' ), ajaxurl = $(this).data( 'ajax_url' ).replace( '%%endpoint%%', 'revo_quickviewproduct' );
			ajaxurl = ajaxurl.replace( '%endpoint%', 'revo_quickviewproduct' );
			qv_target.addClass( 'show loading' );
			var data 		= {
				action: 'revo_quickviewproduct',
				product_id: product_id,
				
			};
			jQuery.post(ajaxurl, data, function(response) {
				qv_target.find( '.quickview-inner' ).append( response );				
				qv_target.removeClass( 'loading' );
				$( '.quickview-container .product-images' ).each(function(){
					var $id 					= this.id;
					var $rtl 					= $('body').hasClass( 'rtl' );
					var $img_slider 	= $(this).find('.product-responsive');
					var $thumb_slider = $(this).find('.product-responsive-thumbnail' )
					$img_slider.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						fade: true,
						arrows: false,
						rtl: $rtl,
						asNavFor: $thumb_slider
					});
					$thumb_slider.slick({
						slidesToShow: 4,
						slidesToScroll: 1,
						asNavFor: $img_slider,
						arrows: true,
						focusOnSelect: true,
						rtl: $rtl,
						responsive: [				
						{
							breakpoint: 360,
							settings: {
								slidesToShow: 2    
							}
						}
						]
					});

					var el = $(this);
					setTimeout(function(){
						el.removeClass("loading");
						var height = el.find('.product-responsive').outerHeight();
						var target = el.find( ' .item-video' );
						target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

						var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
						var thumb_target = el.find( '.item-video-thumb' );
						thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
						qv_target.find( '.quickview-content' ).css( 'margin-top', ( $(window).height() - qv_target.find( '.quickview-content' ).outerHeight() ) /2 );
					}, 1000);
				});				
			});
		});
		
		$( '.quickview-close' ).on('click', function(){
			qv_target.removeClass( 'show' );
			qv_target.find( '.quickview-inner' ).html('');			
		});
		$(document).click(function(e) {			
			var container = qv_target.find( '.quickview-inner' );
			if ( !container.is(e.target) && container.has(e.target).length === 0 && qv_target.find( '.quickview-inner' ).html().length > 0 ){
				qv_target.removeClass( 'show' );
				qv_target.find( '.quickview-inner' ).html('');
			}
		});
	}
	
	/*
	** Ajax login
	*/
	$('form#login_ajax').on('submit', function(e){
		var target = $(this);		
		var usename = target.find( '#username').val();
		var pass 	= target.find( '#password').val();
		if( usename.length == 0 || pass.length == 0 ){
			target.find( '#login_message' ).addClass( 'error' ).html( custom_text.message );
			return false;
		}
		target.addClass( 'loading' );
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: custom_text.ajax_url,
			headers: { 'api-key':target.find( '#woocommerce-login-nonce').val() },
			data: { 
				'action': 'revo_custom_login_user', //calls wp_ajax_nopriv_ajaxlogin
				'username': target.find( '#username').val(), 
				'password': target.find( '#password').val(), 
				'security': target.find( '#woocommerce-login-nonce').val() 
			},
			success: function(data){
				target.removeClass( 'loading' );
				target.find( '#login_message' ).html( data.message );
				if (data.loggedin == false){
					target.find( '#username').css( 'border-color', 'red' );
					target.find( '#password').css( 'border-color', 'red' );
					target.find( '#login_message' ).addClass( 'error' );
				}
				if (data.loggedin == true){
					target.find( '#username').removeAttr( 'style' );
					target.find( '#password').removeAttr( 'style' );
					document.location.href = data.redirect;
					target.find( '#login_message' ).removeClass( 'error' );
				}
			}
		});
		e.preventDefault();
	});
	
})(jQuery);

jQuery(document).ready(function ($) {
	$('.header-style9 .header-top .text-header-top .remove-banner').on('click', function(){
		$('.header-style9 .header-top').toggleClass("hidden");
	});
});
