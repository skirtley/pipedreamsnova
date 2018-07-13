<?php 
/*
** Require files
*/

require_once( SWPATH . 'inc/options/options.php' );
require_once( SWPATH . 'inc/shortcodes.php' );
require_once( SWPATH . 'inc/maintaince/maintaince-function.php' );
require_once( SWPATH . 'inc/widgets/widget-advanced.php' );
if( sw_options( 'developer_mode' ) ) :
	require_once( SWPATH . 'inc/lessphp/less.php' );
endif;

function sw_options( $opt_name, $default = null ){
	$options = get_option( SW_THEME );
	if ( !is_admin() &&  isset( $options['show_cpanel'] ) && $options['show_cpanel'] ){
		$cookie_opt_name = SW_THEME.'_' . $opt_name;
		if ( array_key_exists( $cookie_opt_name, $_COOKIE ) ){
			return $_COOKIE[$cookie_opt_name];
		}
	}
	if( is_array( $options ) ){
		if ( array_key_exists( $opt_name, $options ) ){
			return $options[$opt_name];
		}
	}
	return $default;
}

add_filter( 'sw_options_sections_'. SW_THEME, 'sw_custom_section' );
function sw_custom_section( $sections ){
	$sections[] = array(
		'title' => esc_html__('Maintaincece Mode', 'sw_core'),
		'desc' => wp_kses( __('<p class="description">Enable and config for Maintaincece mode.</p>', 'sw_core'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it revo for default.
		'icon' => SW_OPTIONS_URL.'/options/img/glyphicons/glyphicons_136_computer_locked.png',
		//Lets leave this as a revo section, no options just some intro text set above.
		'fields' => array(
				array(
					'id' => 'maintaince_enable',
					'title' => esc_html__( 'Enable Maintaincece Mode', 'sw_core' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off Maintaince mode on this website', 'sw_core' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'maintaince_background',
					'title' => esc_html__( 'Maintaince Background', 'sw_core' ),
					'type' => 'upload',
					'sub_desc' => esc_html__( 'Choose maintance background image', 'sw_core' ),
					'desc' => '',
					'std' => get_template_directory_uri().'/assets/img/maintaince/bg-main.jpg'
				),
				
				array(
					'id' => 'maintaince_content',
					'title' => esc_html__( 'Maintaince Content', 'sw_core' ),
					'type' => 'editor',
					'sub_desc' => esc_html__( 'Change text of maintaince mode', 'sw_core' ),
					'desc' => '',
					'std' => ''
				),
				
				array(
					'id' => 'maintaince_date',
					'title' => esc_html__( 'Maintaince Date', 'sw_core' ),
					'type' => 'date',
					'sub_desc' => esc_html__( 'Put date to this field to show countdown date on maintaince mode.', 'sw_core' ),
					'desc' => '',
					'placeholder' => 'mm/dd/yy',
					'std' => ''
				),
				
				array(
					'id' => 'maintaince_form',
					'title' => esc_html__( 'Maintaince Form', 'sw_core' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on maintaince mode frontend.', 'sw_core' ),
					'desc' => '',
					'std' => ''
				),
				
			)
	);
	return $sections;
}

/*
** Social Link
*/
if( !function_exists( 'sw_social_link' ) ) {
	function sw_social_link(){
		$fb_link = sw_options('social-share-fb');
		$tw_link = sw_options('social-share-tw');
		$tb_link = sw_options('social-share-tumblr');
		$li_link = sw_options('social-share-in');
		$gg_link = sw_options('social-share-go');
		$pt_link = sw_options('social-share-pi');
		$it_link = sw_options('social-share-instagram');

		$html = '';
		if( $fb_link != '' || $tw_link != '' || $tb_link != '' || $li_link != '' || $gg_link != '' || $pt_link != '' ):
		$html .= '<div class="revo-socials"><ul>';
			if( $fb_link != '' ):
				$html .= '<li><a href="'. esc_url( $fb_link ) .'" title="'. esc_attr__( 'Facebook', 'sw_core' ) .'"><i class="fa fa-facebook"></i></a></li>';
			endif;
			
			if( $tw_link != '' ):
				$html .= '<li><a href="'. esc_url( $tw_link ) .'" title="'. esc_attr__( 'Twitter', 'sw_core' ) .'"><i class="fa fa-twitter"></i></a></li>';
			endif;
			
			if( $tb_link != '' ):
				$html .= '<li><a href="'. esc_url( $tb_link ) .'" title="'. esc_attr__( 'Tumblr', 'sw_core' ) .'"><i class="fa fa-tumblr"></i></a></li>';
			endif;
			
			if( $li_link != '' ):
				$html .= '<li><a href="'. esc_url( $li_link ) .'" title="'. esc_attr__( 'Linkedin', 'sw_core' ) .'"><i class="fa fa-linkedin"></i></a></li>';
			endif;
			
			if( $it_link != '' ):
				$html .= '<li><a href="'. esc_url( $it_link ) .'" title="'. esc_attr__( 'Instagram', 'sw_core' ) .'"><i class="fa fa-instagram"></i></a></li>';
			endif;
			
			if( $gg_link != '' ):
				$html .= '<li><a href="'. esc_url( $gg_link ) .'" title="'. esc_attr__( 'Google+', 'sw_core' ) .'"><i class="fa fa-google-plus"></i></a></li>';
			endif;
			
			if( $pt_link != '' ):
				$html .= '<li><a href="'. esc_url( $pt_link ) .'" title="'. esc_attr__( 'Pinterest', 'sw_core' ) .'"><i class="fa fa-pinterest"></i></a></li>';
			endif;
		$html .= '</ul></div>';
		endif;
		echo wp_kses( $html, array( 'div' => array( 'class' => array() ), 'ul' => array(), 'li' => array(), 'a' => array( 'href' => array(), 'class' => array(), 'title' => array() ), 'i' => array( 'class' => array() ) ) );
	}
}

