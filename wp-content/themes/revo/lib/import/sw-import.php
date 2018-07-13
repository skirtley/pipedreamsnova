<?php 
function sw_import_files() { 
	return array(
		array(
			'import_file_name'          => 'Multi Category Store 1',
			'page_title'				=> 'Home',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/slideshow1.zip' 
			),
			'local_import_options'        => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' 	=> 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu' => 'Verticle Menu'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/1.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/' ),
		),
	
		array(
			'import_file_name'          => 'Multi Category Store 2',
			'page_title'				=> 'Multi-category Store 2',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/slideshow2.zip' 
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu' => 'Verticle Menu'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/2.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-2/' ),
		),
		
		array(
			'import_file_name'          => 'Kids Fashion Store',
			'page_title'				=> 'Kids Fashion Store',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/slideshow-4.zip' 
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/3.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-4/' ),
		),
		
		array(
			'import_file_name'          => 'Fashion Store',				
			'page_title'				=> 'Fashion Store',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
				'local_import_revslider'  		 => array( 
					'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/slideshow3.zip' 
				),
				'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-4/4.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-3/' ),
		),
		
		array(
			'import_file_name'          => 'Fashion Store 2',
			'page_title'			   	=> 'Fashion Store 2',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/slider6.zip',
				'slide2' => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/slider6.zip' 
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-5/5.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-6/' ),
		),
		
		array(
			'import_file_name'          => 'Hitech Store',
			'page_title'				=> 'Hitech Store',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/slideshow-home5.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	 => array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-6/6.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-5/' ),
		),
		
		array(
			'import_file_name'          => 'Hitech Store 2',
			'page_title'				=> 'Hitech Store 2',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/slider7.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu' => 'Verticle Menu'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-7/7.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-7/' ),
    ),
		
		array(
			'import_file_name'          => 'Furniture Store',
			'page_title'				=> 'Furniture',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/slide-home8.zip',
			),
			'local_import_options'      => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu' => 'Verticle Menu'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-8/8.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-8/' ),
		),
		
		array(
			'import_file_name'          => 'Furniture Store 2',
			'page_title'				=> 'Furniture Store 2',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/slideshow12.zip',
			),
			'local_import_options'      => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu' => 'Verticle Menu'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-9/9.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/furniture-store-2/' ),
		),
		
		array(
			'import_file_name'          => 'Cosmetic Store',
			'page_title'				=> 'Home Page 9',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_options'      => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-10/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu1' => 'Primary Menu1',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-10/10.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-9/' ),
		),
		
		array(
			'import_file_name'          => 'Organic Store',
			'page_title'				=> 'Home Page 10',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
			'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/slidehome10.zip',
			),
			'local_import_options'      => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-11/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
				'vertical_menu1' => 'Verticle Menu1'
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-11/11.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-10/' ),
		),
		
		array(
			'import_file_name'          => 'Music Store',
			'page_title'				=> 'Home Page 11',
			'local_import_file'         => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'  => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  	=> array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/video_bg11.zip',
			),
			'local_import_options'      => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-12/theme_options.txt',
					'option_name' => 'revo_theme',
				),
			),
			'menu_locate'	=> array(
				'primary_menu' => 'Primary Menu',   /* menu location => menu name for that location */
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-12/12.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'revo' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_revo/home-page-11/' ),
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'sw_import_files' );