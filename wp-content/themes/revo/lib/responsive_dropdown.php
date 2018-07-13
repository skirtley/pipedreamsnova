<?php
class Revo_Resmenu{
	function __construct(){
		add_filter( 'wp_nav_menu_args' , array( $this , 'Revo_MenuRes_AdFilter' ), 100 ); 
		add_filter( 'wp_nav_menu_args' , array( $this , 'Revo_MenuRes_Filter' ), 110 );	
		add_action( 'wp_footer', array( $this  , 'Revo_MenuRes_AdScript' ), 110 );	
	}
	function Revo_MenuRes_AdScript(){
		$html  = '<script type="text/javascript">';
		$html .= '(function($) {
			/* Responsive Menu */
			$(document).ready(function(){
				$(".show-dropdown").on("click", function(){
					$(this).toggleClass("show");
					var $element = $(this).parent().find( "> ul" );
					$element.toggle( 300 );
				});
				$(document).click(function(e) {			
					var container = $( ".resmenu-container" );
					if ( typeof container != "undefined" && !container.is(e.target) && container.has(e.target).length === 0 && container.html().length > 0 ){
						container.find( ".navbar-toggle" ).addClass( "collapsed" );
						container.find( ".menu-responsive-wrapper" ).removeClass("in").addClass( "collapse" ).height(0);
					}
				});
			});
		})(jQuery);';
		$html .= '</script>';
		echo sprintf( $html );
	}
	function Revo_MenuRes_AdFilter( $args ){
		$args['container'] = false;		
		$menu = get_registered_nav_menus() ;
		foreach( $menu as $revo_theme_locate => $menu_description ){
			if( $revo_theme_locate == $args['theme_location'] ){
				if( isset( $args['revo_resmenu'] ) && $args['revo_resmenu'] == true ) {
					return $args;
				}		
				$ResNavMenu = $this->ResNavMenu( $args );
				$args['container'] = '';
				$args['container_class'].= '';	
				$args['menu_class'].= ($args['menu_class'] == '' ? '' : ' ') . 'revo-menures';			
				$args['items_wrap']	= '<ul id="%1$s" class="%2$s">%3$s</ul>'.$ResNavMenu;
			}
		}
		return $args;
	}
	function ResNavMenu( $args ){
		$args['revo_resmenu'] = true;		
		$select = wp_nav_menu( $args );
		return $select;
	}
	function Revo_MenuRes_Filter( $args ){
		/* Fix Menu on wp 4.7 */
		if( !isset( $args['revo_resmenu'] ) ){
			return $args;
		}
		$args['container'] = false;
		$menu = get_registered_nav_menus() ;
		foreach( $menu as $revo_theme_locate => $menu_description ){
			if( $revo_theme_locate == $args['theme_location'] ){
				$args['container'] = 'div';
				$args['container_class'].= 'resmenu-container';
				$args['items_wrap']	= '<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#ResMenu'. esc_attr( $revo_theme_locate ) .'">
					<span class="sr-only">Categories</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button><div id="ResMenu'. esc_attr( $revo_theme_locate ) .'" class="collapse menu-responsive-wrapper"><ul id="%1$s" class="%2$s">%3$s</ul></div>';	
				$args['menu_class'] = 'revo_resmenu';
				$args['walker'] = new Revo_ResMenu_Walker();
			}
		}
		return $args;
	}
}
class Revo_ResMenu_Walker extends Walker_Nav_Menu {
	function check_current($classes) {
		return preg_match('/(current[-_])|active|dropdown/', $classes);
	}

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"dropdown-resmenu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_html = '';
		parent::start_el($item_html, $item, $depth, $args);
		if( !$item->is_dropdown && ($depth === 0) ){
			$item_html = str_replace('<a', '<a class="item-link"', $item_html);			
			$item_html = str_replace('</a>', '</a>', $item_html);			
		}
		if ( $item->is_dropdown ) {
			$item_html = str_replace('<a', '<a class="item-link dropdown-toggle"', $item_html);
			$item_html = str_replace('</a>', '</a>', $item_html);
			$item_html .= '<span class="show-dropdown"></span>';
		}
		$output .= $item_html;
	}

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$element->is_dropdown = !empty($children_elements[$element->ID]);
		if ($element->is_dropdown) {			
			$element->classes[] = 'res-dropdown';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
new Revo_Resmenu();