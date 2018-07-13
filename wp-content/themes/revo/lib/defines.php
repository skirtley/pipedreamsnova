<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('REVO_DIR') ){
	define( 'REVO_DIR', $lib_dir );
}

if( !defined('REVO_URL') ){
	define( 'REVO_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if (!isset($content_width)) { $content_width = 940; }

define("REVO_PRODUCT_TYPE","product");
define("REVO_PRODUCT_DETAIL_TYPE","product_detail");

if ( !defined('SW_THEME') ){
	define( 'SW_THEME', 'revo_theme' );
}

require_once( get_template_directory().'/lib/options.php' );

if( class_exists( 'SW_Options' ) ) :
function revo_Options_Setup(){
	global $sw_options, $options, $options_args;

	$options = array();
	$options[] = array(
			'title' => esc_html__('General', 'revo'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(	
					
					array(
						'id' => 'sitelogo',
						'type' => 'upload',
						'title' => esc_html__('Logo Image', 'revo'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'revo' ),
						'std' => get_template_directory_uri().'/assets/img/logo-default.png'
					),
					
					array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => esc_html__('Favicon', 'revo'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'revo' ),
						'std' => ''
					),
					
					array(
						'id' => 'tax_select',
						'type' => 'multi_select_taxonomy',
						'title' => esc_html__('Select Taxonomy', 'revo'),
						'sub_desc' => esc_html__( 'Select taxonomy to show custom term metabox', 'revo' ),
					),
					
					array(
						'id' => 'title_length',
						'type' => 'text',
						'title' => esc_html__('Title Length Of Item Listing Page', 'revo'),
						'sub_desc' => esc_html__( 'Choose title length if you want to trim word, leave 0 to not trim word', 'revo' ),
						'std' => 0
					),
					
					array(
					   'id' => 'page_404',
					   'type' => 'pages_select',
					   'title' => esc_html__('404 Page Content', 'revo'),
					   'sub_desc' => esc_html__('Select page 404 content', 'revo'),
					   'std' => ''
					),
			)		
		);
	
	$options[] = array(
			'title' => esc_html__('Schemes', 'revo'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(		
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'revo'),
					'sub_desc' => esc_html__( 'Select one of 12 predefined schemes', 'revo' ),
					'desc' => '',
					'options' => array(
									'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
									'blue' => array('title' => 'Blue', 'img' => get_template_directory_uri().'/assets/img/blue.png'),
									'lightblue' => array('title' => 'Light Blue', 'img' => get_template_directory_uri().'/assets/img/lightblue.png'),
									'red' => array('title' => 'Red', 'img' => get_template_directory_uri().'/assets/img/red.png'),
									'green' => array('title' => 'Green', 'img' => get_template_directory_uri().'/assets/img/green.png'),
									'darkblue' => array('title' => 'Darkblue', 'img' => get_template_directory_uri().'/assets/img/darkblue.png'),
									'orange' => array('title' => 'Orange', 'img' => get_template_directory_uri().'/assets/img/orange.png'),
									'brown' => array('title' => 'Brown', 'img' => get_template_directory_uri().'/assets/img/brown.png'),
									'pink' => array('title' => 'Pink', 'img' => get_template_directory_uri().'/assets/img/pink.png'),
									'cyan' => array('title' => 'Cyan', 'img' => get_template_directory_uri().'/assets/img/cyan.png'),
									'orange2' => array('title' => 'Orange 2', 'img' => get_template_directory_uri().'/assets/img/orange2.png'),
									'orange3' => array('title' => 'Orange 3', 'img' => get_template_directory_uri().'/assets/img/orange3.png'),
									), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
					
				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'revo' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'revo' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'revo'),
					'sub_desc' => esc_html__('Select main custom color.', 'revo'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_body',
					'type' => 'color',
					'title' => esc_html__('Body Color', 'revo'),
					'sub_desc' => esc_html__('Select main body custom color.', 'revo'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_border',
					'type' => 'color',
					'title' => esc_html__('Border Color', 'revo'),
					'sub_desc' => esc_html__('Select main border custom color.', 'revo'),					
					'std' => ''
				)			
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Layout', 'revo'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'layout',
						'type' => 'select',
						'title' => esc_html__('Box Layout', 'revo'),
						'sub_desc' => esc_html__( 'Select Layout Box or Wide', 'revo' ),
						'options' => array(
							'full' => esc_html__( 'Wide', 'revo' ),
							'boxed' => esc_html__( 'Boxed', 'revo' )
						),
						'std' => 'wide'
					),
				
					array(
						'id' => 'bg_box_img',
						'type' => 'upload',
						'title' => esc_html__('Background Box Image', 'revo'),
						'sub_desc' => '',
						'std' => ''
					),
					array(
							'id' => 'sidebar_left_expand',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12', 
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of left sidebar.', 'revo' ),
						),
					
					array(
							'id' => 'sidebar_right_expand',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'revo' ),
						),
						array(
							'id' => 'sidebar_left_expand_md',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'revo' ),
						),
					array(
							'id' => 'sidebar_right_expand_md',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar.', 'revo' ),
						),
						array(
							'id' => 'sidebar_left_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Tablet Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'revo' ),
						),
					array(
							'id' => 'sidebar_right_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Tablet Expand', 'revo'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'revo' ),
						),				
				)
		);
	$options[] = array(
			'title' => esc_html__('Mobile Layout', 'revo'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a mobile setting home page layout.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(				
				array(
					'id' => 'mobile_enable',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Mobile Layout', 'revo'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '1'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_logo',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile Image', 'revo'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo', 'revo' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),
				
				array(
					'id' => 'sticky_mobile',
					'type' => 'checkbox',
					'title' => esc_html__('Sticky Mobile', 'revo'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_content',
					'type' => 'pages_select',
					'title' => esc_html__('Mobile Layout Content', 'revo'),
					'sub_desc' => esc_html__('Select content index for this mobile layout', 'revo'),
					'std' => ''
				),
				
				array(
					'id' => 'mobile_header_style',
					'type' => 'select',
					'title' => esc_html__('Header Mobile Style', 'revo'),
					'sub_desc' => esc_html__('Select header mobile style', 'revo'),
					'options' => array(
							'mstyle1'  => esc_html__( 'Style 1', 'revo' ),
							'mstyle2'  => esc_html__( 'Style 2', 'revo' ),
							'mstyle3'  => esc_html__( 'Style 3', 'revo' ),
							'mstyle4'  => esc_html__( 'Style 4', 'revo' ),
							'mstyle5'  => esc_html__( 'Style 5', 'revo' ),
					),
					'std' => 'style1'
				),
				
				array(
					'id' => 'mobile_footer_style',
					'type' => 'select',
					'title' => esc_html__('Footer Mobile Style', 'revo'),
					'sub_desc' => esc_html__('Select footer mobile style', 'revo'),
					'options' => array(
							'mstyle1'  => esc_html__( 'Style 1', 'revo' ),
							'mstyle2'  => esc_html__( 'Style 2', 'revo' ),
							'mstyle3'  => esc_html__( 'Style 3', 'revo' ),
					),
					'std' => 'style1'
				),
				
				array(
					'id' => 'mobile_jquery',
					'type' => 'checkbox',
					'title' => esc_html__('Include Jquery Revolution', 'revo'),
					'sub_desc' => '',
					'desc' => '',
					'std' => '0'// 1 = on | 0 = off
				),
			)
	);
			
	$options[] = array(
		'title' => esc_html__('Header & Footer', 'revo'),
			'desc' => wp_kses( __('<p class="description">SmartAddons Framework comes with a header and footer setting that allows you to build style header.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
				 array(
					'id' => 'header_style',
					'type' => 'select',
					'title' => esc_html__('Header Style', 'revo'),
					'sub_desc' => esc_html__('Select Header style', 'revo'),
					'options' => array(
							'style1'  => esc_html__( 'Style 1', 'revo' ),
							'style2'  => esc_html__( 'Style 2', 'revo' ),
							'style3'  => esc_html__( 'Style 3', 'revo' ),
							'style4'  => esc_html__( 'Style 4', 'revo' ),
							'style5'  => esc_html__( 'Style 5', 'revo' ),
							'style6'  => esc_html__( 'Style 6', 'revo' ),
							'style7'  => esc_html__( 'Style 7', 'revo' ),
							'style8'  => esc_html__( 'Style 8', 'revo' ),
							'style9'  => esc_html__( 'Style 9', 'revo' ),
							'style10'  => esc_html__( 'Style 10', 'revo' ),
							'style11'  => esc_html__( 'Style 11', 'revo' ),
							'style12'  => esc_html__( 'Style 12', 'revo' ),
							),
					'std' => 'style1'
				),
				
				array(
					'id' => 'header_mid',
					'title' => esc_html__( 'Enable Background Header Mid', 'revo' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( ' enable background hedaer mid on header', 'revo' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
						'id' => 'bg_header_mid',
						'title' => esc_html__( 'Background header mid', 'revo' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose header mid background image', 'revo' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
				array(
					'id' => 'disable_search',
					'title' => esc_html__( 'Disable Search', 'revo' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable search on header', 'revo' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'disable_cart',
					'title' => esc_html__( 'Disable Cart', 'revo' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable cart on header', 'revo' ),
					'desc' => '',
					'std' => '0'
				),				
				
				array(
				   'id' => 'footer_style',
				   'type' => 'pages_select',
				   'title' => esc_html__('Footer Style', 'revo'),
				   'sub_desc' => esc_html__('Select Footer style', 'revo'),
				   'std' => ''
				),
				
				array(
					'id' => 'footer_copyright',
					'type' => 'editor',
					'sub_desc' => '',
					'title' => esc_html__( 'Copyright text', 'revo' )
				),	
				
			)
	);
	$options[] = array(
			'title' => esc_html__('Navbar Options', 'revo'),
			'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => esc_html__('Menu Type', 'revo'),
						'options' => array( 
							'dropdown' => esc_html__( 'Dropdown Menu', 'revo' ), 
							'mega' => esc_html__( 'Mega Menu', 'revo' ) 
						),
						'std' => 'mega'
					),	
				
				array(
						'id' => 'menu_location',
						'type' => 'menu_location_multi_select',
						'title' => esc_html__('Theme Location', 'revo'),
						'sub_desc' => esc_html__( 'Select theme location to active mega menu and menu responsive.', 'revo' ),
						'std' => 'primary_menu'
					),		
					
				array(
						'id' => 'sticky_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active sticky menu', 'revo'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
					
				array(
						'id' => 'menu_event',
						'type' => 'select',
						'title' => esc_html__('Menu Event', 'revo'),
						'options' => array( 
							'' 		=> esc_html__( 'Hover Event', 'revo' ), 
							'click' => esc_html__( 'Click Event', 'revo' ) 
						),
						'std' => ''
					),
				
				array(
					'id' => 'menu_number_item',
					'type' => 'text',
					'title' => esc_html__( 'Number Item Vertical', 'revo' ),
					'sub_desc' => esc_html__( 'Number item vertical to show', 'revo' ),
					'std' => 8
				),	
				
				array(
					'id' => 'menu_title_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Title Text', 'revo'),
					'sub_desc' => esc_html__( 'Change title text on vertical menu', 'revo' ),
					'std' => ''
				),
				
				array(
					'id' => 'menu_more_text',
					'type' => 'text',
					'title' => esc_html__('Vertical More Text', 'revo'),
					'sub_desc' => esc_html__( 'Change more text on vertical menu', 'revo' ),
					'std' => ''
				),
					
				array(
					'id' => 'menu_less_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Less Text', 'revo'),
					'sub_desc' => esc_html__( 'Change less text on vertical menu', 'revo' ),
					'std' => ''
				)	
			)
		);
	$options[] = array(
		'title' => esc_html__('Blog Options', 'revo'),
		'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it revo for default.
		'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a revo section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => esc_html__('Sidebar Blog Layout', 'revo'),
						'options' => array(
								'full' 	=> esc_html__( 'Full Layout', 'revo' ),		
								'left'	=> esc_html__( 'Left Sidebar', 'revo' ),
								'right' => esc_html__( 'Right Sidebar', 'revo' ),
						),
						'std' => 'left',
						'sub_desc' => esc_html__( 'Select style sidebar blog', 'revo' ),
					),
					array(
						'id' => 'blog_layout',
						'type' => 'select',
						'title' => esc_html__('Layout blog', 'revo'),
						'options' => array(
								'list'	=>  esc_html__( 'List Layout', 'revo' ),
								'grid' 	=>  esc_html__( 'Grid Layout', 'revo' )								
						),
						'std' => 'list',
						'sub_desc' => esc_html__( 'Select style layout blog', 'revo' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => esc_html__('Blog column', 'revo'),
						'options' => array(								
								'2' =>  esc_html__( '2 Columns', 'revo' ),
								'3' =>  esc_html__( '3 Columns', 'revo' ),
								'4' =>  esc_html__( '4 Columns', 'revo' )								
							),
						'std' => '2',
						'sub_desc' => esc_html__( 'Select style number column blog', 'revo' ),
					),
			)
	);	
	$options[] = array(
		'title' => esc_html__('Product Options', 'revo'),
		'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it revo for default.
		'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a revo section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Categories Config', 'revo' ),
				'desc' => '',
				'class' => 'revo-opt-info'
				),
			
			array(
				'id' => 'product_colcat_large',
				'type' => 'select',
				'title' => esc_html__('Product Category Listing column Desktop', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '4',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'revo' ),
				),

			array(
				'id' => 'product_colcat_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Medium Desktop', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'revo' ),
				),

			array(
				'id' => 'product_colcat_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Tablet', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'revo' ),
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product General Config', 'revo' ),
				'desc' => '',
				'class' => 'revo-opt-info'
				),
				
			array(
				'id' => 'product_banner',
				'title' => esc_html__( 'Select Banner', 'revo' ),
				'type' => 'select',
				'sub_desc' => '',
				'options' => array(
					'' 			=> esc_html__( 'Use Banner', 'revo' ),
					'listing' 	=> esc_html__( 'Use Category Product Image', 'revo' ),
					),
				'std' => '',
				),

			array(
				'id' => 'product_listing_banner',
				'type' => 'upload',
				'title' => esc_html__('Listing Banner Product', 'revo'),
				'sub_desc' => esc_html__( 'Use the Upload button to upload banner product listing', 'revo' ),
				'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Desktop', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'revo' ),
				),

			array(
				'id' => 'product_col_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Medium Desktop', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'revo' ),
				),

			array(
				'id' => 'product_col_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Tablet', 'revo'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'revo' ),
				),

			array(
				'id' => 'sidebar_product',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Layout', 'revo'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'revo' ),
					'full' 	=> esc_html__( 'Full Layout', 'revo' ),		
					'right' => esc_html__( 'Right Sidebar', 'revo' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product', 'revo' ),
				),

			array(
				'id' => 'product_quickview',
				'title' => esc_html__( 'Quickview', 'revo' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Quickview', 'revo' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_listing_countdown',
				'title' => esc_html__( 'Enable Countdown', 'revo' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product listing', 'revo' ),
				'std' => '1'
				),
			
			
			array(
				'id' => 'product_number',
				'type' => 'text',
				'title' => esc_html__('Product Listing Number', 'revo'),
				'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'revo' ),
				'std' => 12
				),
			
			array(
				'id' => 'newproduct_time',
				'title' => esc_html__( 'New Product', 'revo' ),
				'type' => 'number',
				'sub_desc' => '',
				'desc' => esc_html__( 'Set day for the new product label from the date publish product.', 'revo' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Single Config', 'revo' ),
				'desc' => '',
				'class' => 'revo-opt-info'
				),
			
			array(
				'id' => 'sidebar_product_detail',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Single Layout', 'revo'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'revo' ),
					'full' 	=> esc_html__( 'Full Layout', 'revo' ),		
					'right' => esc_html__( 'Right Sidebar', 'revo' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product single', 'revo' ),
				),
			
			array(
				'id' => 'product_single_style',
				'type' => 'select',
				'title' => esc_html__('Product Detail Style', 'revo'),
				'options' => array(
					'default'	=> esc_html__( 'Default', 'revo' ),
					'style1' 	=> esc_html__( 'Full Width', 'revo' ),	
					'style2' 	=> esc_html__( 'Full Width With Accordion', 'revo' ),	
					'style3' 	=> esc_html__( 'Full Width With Accordion 1', 'revo' ),	
				),
				'std' => 'default',
				'sub_desc' => esc_html__( 'Select style for product single', 'revo' ),
				),
			
			array(
				'id' => 'product_single_thumbnail',
				'type' => 'select',
				'title' => esc_html__('Product Thumbnail Position', 'revo'),
				'options' => array(
					'bottom'	=> esc_html__( 'Bottom', 'revo' ),
					'left' 		=> esc_html__( 'Left', 'revo' ),	
					'right' 	=> esc_html__( 'Right', 'revo' ),	
					'top' 		=> esc_html__( 'Top', 'revo' ),					
				),
				'std' => 'bottom',
				'sub_desc' => esc_html__( 'Select style for product single thumbnail', 'revo' ),
				),		
			
			
			array(
				'id' => 'product_zoom',
				'title' => esc_html__( 'Product Zoom', 'revo' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'revo' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_brand',
				'title' => esc_html__( 'Enable Product Brand Image', 'revo' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off product brand image show on single product.', 'revo' ),
				'std' => '1'
				),

			array(
				'id' => 'product_single_countdown',
				'title' => esc_html__( 'Enable Countdown Single', 'revo' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product single', 'revo' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Config For Product Categories Widget', 'revo' ),
				'desc' => '',
				'class' => 'revo-opt-info'
				),

			array(
				'id' => 'product_number_item',
				'type' => 'text',
				'title' => esc_html__( 'Category Number Item Show', 'revo' ),
				'sub_desc' => esc_html__( 'Choose to number of item category that you want to show, leave 0 to show all category', 'revo' ),
				'std' => 8
				),	

			array(
				'id' => 'product_more_text',
				'type' => 'text',
				'title' => esc_html__( 'Category More Text', 'revo' ),
				'sub_desc' => esc_html__( 'Change more text on category product', 'revo' ),
				'std' => ''
				),

			array(
				'id' => 'product_less_text',
				'type' => 'text',
				'title' => esc_html__( 'Category Less Text', 'revo' ),
				'sub_desc' => esc_html__( 'Change less text on category product', 'revo' ),
				'std' => ''
			)	
		)
);		
	$options[] = array(
			'title' => esc_html__('Typography', 'revo'),
			'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'info_typo1',
					'type' => 'info',
					'title' => esc_html( 'Global Typography', 'revo' ),
					'desc' => '',
					'class' => 'revo-opt-info'
				),
				
				array(
					'id' => 'google_webfonts',
					'type' => 'google_webfonts',
					'title' => esc_html__('Use Google Webfont', 'revo'),
					'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'revo' ), 
					'std' => ''
				),				
				
				array(
					'id' => 'webfonts_weight',
					'type' => 'multi_select',
					'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'revo' ),
					'title' => esc_html__('Webfont Weight', 'revo'),
					'options' => array(
							'100' => '100',
							'200' => '200',
							'300' => '300',
							'400' => '400',
							'500' => '500',
							'600' => '600',
							'700' => '700',
							'800' => '800',
							'900' => '900'
						),
					'std' => ''
				),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Header Tag Typography', 'revo' ),
					'desc' => '',
					'class' => 'revo-opt-info'
				),
				
				array(
					'id' => 'header_tag_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Header Tag Font', 'revo'),
					'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'revo' ), 
					'std' => ''
				),
				
				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Main Menu Typography', 'revo' ),
					'desc' => '',
					'class' => 'revo-opt-info'
				),
				
				array(
					'id' => 'menu_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Main Menu Font', 'revo'),
					'sub_desc' => esc_html__( 'Select custom font for main menu', 'revo' ), 
					'std' => ''
				),
				
				array(
					'id' => 'google_webfonts_api',
					'type' => 'text',
					'title' => esc_html__('Google Webfont API Key', 'revo'),
					'desc' => sprintf(__( 'Insert google font API key to use Google WebFonts. You can get a key <a href="%s" target="_blank">here</a>', 'revo' ), esc_url( 'https://developers.google.com/fonts/docs/developer_api' ) ), 
					'std' => ''
				),
				
			)
		);
	
	$options[] = array(
		'title' => __('Social', 'revo'),
		'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_222_share.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'social-share-fb',
						'title' => esc_html__( 'Facebook', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tw',
						'title' => esc_html__( 'Twitter', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tumblr',
						'title' => esc_html__( 'Tumblr', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-in',
						'title' => esc_html__( 'Linkedin', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
					array(
						'id' => 'social-share-instagram',
						'title' => esc_html__( 'Instagram', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-go',
						'title' => esc_html__( 'Google+', 'revo' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
					'id' => 'social-share-pi',
					'title' => esc_html__( 'Pinterest', 'revo' ),
					'type' => 'text',
					'sub_desc' => '',
					'desc' => '',
					'std' => '',
				)
					
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Popup Config', 'revo'),
			'desc' => wp_kses( __('<p class="description">Enable popup and more config for Popup.</p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_318_more-items.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'popup_active',
						'type' => 'checkbox',
						'title' => esc_html__( 'Active Popup Subscribe', 'revo' ),
						'sub_desc' => esc_html__( 'Check to active popup subscribe', 'revo' ),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'popup_background',
						'title' => esc_html__( 'Popup Background', 'revo' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose popup background image', 'revo' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
					array(
						'id' => 'popup_content',
						'title' => esc_html__( 'Popup Content', 'revo' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of popup mode', 'revo' ),
						'desc' => '',
						'std' => ''
					),	
					
					array(
						'id' => 'popup_form',
						'title' => esc_html__( 'Popup Form', 'revo' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on popup mode frontend.', 'revo' ),
						'desc' => '',
						'std' => ''
					),
					
				)
		);
	
	$options[] = array(
			'title' => esc_html__('Advanced', 'revo'),
			'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'revo'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it revo for default.
			'icon' => REVO_URL.'/admin/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a revo section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'show_cpanel',
						'title' => esc_html__( 'Show cPanel', 'revo' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'revo' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'widget-advanced',
						'title' => esc_html__('Widget Advanced', 'revo'),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'revo' ),
						'desc' => '',
						'std' => '1'
					),					
					
					array(
						'id' => 'social_share',
						'title' => esc_html__( 'Social Share', 'revo' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off social share', 'revo' ),
						'desc' => '',
						'std' => '1'
					),
					
					array(
						'id' => 'breadcrumb_active',
						'title' => esc_html__( 'Turn Off Breadcrumb', 'revo' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'revo' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'back_active',
						'type' => 'checkbox',
						'title' => esc_html__('Back to top', 'revo'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '1'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'direction',
						'type' => 'select',
						'title' => esc_html__('Direction', 'revo'),
						'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
						'std' => 'ltr'
					),
					
					
					array(
						'id' => 'advanced_css',
						'type' => 'textarea',
						'sub_desc' => esc_html__( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'revo' ),
						'title' => esc_html__( 'Custom CSS', 'revo' )
					),
					
					array(
						'id' => 'advanced_js',
						'type' => 'textarea',
						'placeholder' => esc_html__( 'Example: $("p").hide()', 'revo' ),
						'sub_desc' => esc_html__( 'Insert your own JS into this block. This customizes js throughout the theme', 'revo' ),
						'title' => esc_html__( 'Custom JS', 'revo' )
					)
				)
		);

	$options_args = array();

	//Setup custom links in the footer for share icons
	$options_args['share_icons']['facebook'] = array(
			'link' => 'http://www.facebook.com/SmartAddons.page',
			'title' => 'Facebook',
			'img' => REVO_URL.'/admin/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/smartaddons',
			'title' => 'Folow me on Twitter',
			'img' => REVO_URL.'/admin/img/glyphicons/glyphicons_322_twitter.png'
	);
	$options_args['share_icons']['linked_in'] = array(
			'link' => 'http://www.linkedin.com/in/smartaddons',
			'title' => 'Find me on LinkedIn',
			'img' => REVO_URL.'/admin/img/glyphicons/glyphicons_337_linked_in.png'
	);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = SW_THEME;
	$webfonts = ( sw_options( 'google_webfonts_api' ) ) ? sw_options( 'google_webfonts_api' ) : 'AIzaSyAL_XMT9t2KuBe2MIcofGl6YF1IFzfB4L4';
	$options_args['google_api_key'] = $webfonts; //must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'revo');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Revo Options ', 'revo');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "revo_theme_options"
	$options_args['page_slug'] = 'revo_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$sw_options = new SW_Options( $options, $options_args );
}
add_action( 'init', 'revo_Options_Setup', 0 );
// revo_Options_Setup();
endif; 


/*
** Define widget
*/
function revo_widget_setup_args(){
	$revo_widget_areas = array(
		
		array(
				'name' => esc_html__('Sidebar Left Blog', 'revo'),
				'id'   => 'left-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Right Blog', 'revo'),
				'id'   => 'right-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Top Header', 'revo'),
				'id'   => 'top',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Top Header3', 'revo'),
				'id'   => 'top1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Top Header8', 'revo'),
				'id'   => 'top2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Top Header9', 'revo'),
				'id'   => 'top9',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Top Header10', 'revo'),
				'id'   => 'top10',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),

		array(
				'name' => esc_html__('Banner Header12', 'revo'),
				'id'   => 'top11',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Contact Header', 'revo'),
				'id'   => 'contact-us',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Mid Header', 'revo'),
				'id'   => 'mid-header',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Mid Header2', 'revo'),
				'id'   => 'mid-header2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Mid Header12', 'revo'),
				'id'   => 'mid-header3',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Bottom Header', 'revo'),
				'id'   => 'bottom-header',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Right', 'revo'),
				'id'   => 'header-right',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Right Home4', 'revo'),
				'id'   => 'header-right4',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Right Home6', 'revo'),
				'id'   => 'header-right6',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Right Home9', 'revo'),
				'id'   => 'header-right9',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Right Home12', 'revo'),
				'id'   => 'header-right12',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => esc_html__('Header Left', 'revo'),
				'id'   => 'header-left',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Product', 'revo'),
				'id'   => 'left-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Product', 'revo'),
				'id'   => 'right-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Banner Mobile', 'revo'),
				'id'   => 'banner-mobile',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Detail Product', 'revo'),
				'id'   => 'left-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Detail Product', 'revo'),
				'id'   => 'right-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Bottom Detail Product', 'revo'),
				'id'   => 'bottom-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Bottom Detail Product Mobile', 'revo'),
				'id'   => 'bottom-detail-product-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Filter Mobile', 'revo'),
				'id'   => 'filter-mobile',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	
		array(
				'name' => esc_html__('Footer Copyright', 'revo'),
				'id'   => 'footer-copyright',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	);
	return apply_filters( 'revo_widget_register', $revo_widget_areas );
}