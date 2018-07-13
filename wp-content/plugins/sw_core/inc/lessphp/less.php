<?php
/**
 * Wordpress Less
*/

if($wp_config = @file_get_contents(ABSPATH."wp-config.php") ){
	if( !preg_match_all("/WP_MEMORY_LIMIT/", $wp_config, $output_array) ) {
		$wp_config = str_replace("\$table_prefix", "define('WP_MEMORY_LIMIT', '256M');\n\$table_prefix", $wp_config);
		@file_put_contents(ABSPATH."wp-config.php", $wp_config);
	}
}

add_action( 'wp', 'sw_less_construct', 20 );
function sw_less_construct(){
	if( function_exists( 'sw_options' ) ) :
	require_once ( SW_OPTIONS_DIR .'/lessphp/3rdparty/lessc.inc.php' );
	
	$color =  sw_options('scheme_color');
	$bd_color =  sw_options('scheme_body');
	$bdr_color =  sw_options('scheme_border');
	
	if ( sw_options('developer_mode') ){
		define('LESS_PATH', get_template_directory().'/assets/less');
		define('CSS__PATH', get_template_directory().'/css');
		
		$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
		$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : sw_options('scheme');
		$ya_direction = sw_options( 'direction' );
		$scheme_vars = get_template_directory().'/templates/presets/default.php';
		$output_cssf = CSS__PATH.'/app-default.css';
		if ( $scheme && file_exists(get_template_directory().'/templates/presets/'.$scheme.'.php') ){
			$scheme_vars = get_template_directory().'/templates/presets/'.$scheme.'.php';
			$output_cssm = CSS__PATH."/mobile-{$scheme}.css";
			$output_cssf = CSS__PATH."/app-{$scheme}.css";
		}
		if ( file_exists($scheme_vars) ){
			include $scheme_vars;
			if( $color != '' ){
				$less_variables['color'] = $color;
			}
			if(  $bd_color != '' ) {
				$less_variables['body-color'] = $bd_color;
			}
			if(  $bdr_color != '' ){
				$less_variables['border-color'] = $bdr_color;
			}
			
			try {
				// less variables by theme_mod
				// $less_variables['sidebar-width'] = sw_options()->sidebar_collapse_width.'px';
				
				$less = new lessc();
				
				
				$less->setImportDir( array(LESS_PATH.'/app/', LESS_PATH.'/bootstrap/') );
				
				$less->setVariables($less_variables);
				
				$cache = $less->cachedCompile(LESS_PATH.'/app.less');
				file_put_contents($output_cssf, $cache["compiled"]);
				
				/* Mobile */
				$mobile_cache = $less->cachedCompile(LESS_PATH.'/mobile.less');
				file_put_contents($output_cssm, $mobile_cache["compiled"]);				
				
				/* RTL Language */
				$rtl_cache = $less->cachedCompile(LESS_PATH.'/app/rtl.less');
				file_put_contents(CSS__PATH.'/rtl.css', $rtl_cache["compiled"]);
			
				$responsive_cache = $less->cachedCompile(LESS_PATH.'/app-responsive.less');
				file_put_contents(CSS__PATH.'/app-responsive.css', $responsive_cache["compiled"]);
			} catch (Exception $e){
				exit;
			}
		}
	}
	endif;
}
