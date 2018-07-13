<?php 
/*
	* Name: Metabox Page
	* Develope: Smartaddons
*/
require_once( get_template_directory() . '/lib/metabox-category.php' );
/*
** Build array
*/
function revo_build_array( $case ){
	$build_arr = array();
	if( $case == 'page' ) :
		$build_arr = array( '' => esc_html__( 'Select Page', 'revo' ) );
		$pages = get_pages(); 
		foreach( $pages as $page ) {
			$build_arr[$page->ID] = $page->post_title;
		}
	elseif( $case == 'sidebar' ) :
		$wp_registered_sidebars = revo_widget_setup_args();
		$build_arr = array( '' => esc_html__( 'Select Sidebar', 'revo' ) );
		foreach( $wp_registered_sidebars as $sidebar ) {
			$build_arr[$sidebar['id']] = $sidebar['name'];
		}
	endif;
	return $build_arr;
}

/*
** Metabox array define
*/
function revo_metabox_init(){
	$revo_metabox_pages[] = array(
		'title' 	=> esc_html__( 'General', 'revo' ),
		'fields'	=> array(
			array(
				'type'	=> 'upload',
				'title'	=> esc_html__( 'Custom Logo', 'revo' ),
				'id'	=> 'page_logo',
				'description' => esc_html__( 'Upload custom Logo for this page', 'revo' ),
				'std' => ''
			),
			
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Home Template', 'revo' ),
				'id'	=> 'page_home_template',
				'description' => esc_html__( 'Select home template', 'revo' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Default', 'revo' ), 'home-style1' => esc_html__( 'Home Style1', 'revo' ), 'home-style2' => esc_html__( 'Home Style2', 'revo' ),
					'home-style3' => esc_html__( 'Home Style3', 'revo' ), 'home-style4' => esc_html__( 'Home Style4', 'revo' ), 'home-style5' => esc_html__( 'Home Style5', 'revo' ),
					'home-style6' => esc_html__( 'Home Style6', 'revo' ), 'home-style7' => esc_html__( 'Home Style7', 'revo' ), 'home-style8' => esc_html__( 'Home Style8', 'revo' ),
					'home-style9' => esc_html__( 'Home Style9', 'revo' ), 'home-style10' => esc_html__( 'Home Style10', 'revo' ), 'home-style11' => esc_html__( 'Home Style11', 'revo' ),
					'home-style12' => esc_html__( 'Home Style12', 'revo' ),	'page-style' => esc_html__( 'Page Style', 'revo' ), 'mobile-layout4' => esc_html__( 'Mobile Layout4', 'revo' )
				)
			),
			array(
				'type'	=> 'radio_img',
				'title'	=> esc_html__( 'Color Scheme', 'revo' ),
				'id'	=> 'scheme',
				'description' => esc_html__( 'Select one color scheme for this page', 'revo' ),
				'std'	 => 'none',
				'values' => array( 
					'none' => '#000000',
					'default'	=> '#f66759',
					'red' => '#df1e3b',
					'lightblue' => '#2874f0',
					'cyan' => '#689f38',
					'red'	=> '#dd2727',
					'green'	=> '#b0d235',
					'darkblue'	=> '#003764',
					'orange'	=> '#faa600',
					'pink' =>'#f5487d',
					'brown'	=> '#d19a34',
					'orange2'	=> '#feb900',
					'orange3'	=> '#ee8e12'
				)
			)
		)
	);

	$revo_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Typography', 'revo' ),
		'fields'	=> array(
			array(
				'type'	=> 'text',
				'title'	=> esc_html__( 'Google Fonts', 'revo' ),
				'id'	=> 'google_webfonts',
				'description' => esc_html__( ' Insert font style that you actually need on your webpage. Each font seperate by commas', 'revo' ),
				'std'	 => ''	
			),
			array(
				'type'	=> 'multiselect',
				'title'	=> esc_html__( 'Webfont Weight', 'revo' ),
				'id'	=> 'webfonts_weight',
				'description' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'revo' ),
				'std'	 => '',
				'values' => array( 
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900'
				)
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Webfont Assign to', 'revo' ),
				'id'	=> 'webfonts_assign',
				'description' => esc_html__( 'Select the place will apply the font style headers, every where or custom.', 'revo' ),
				'std'	 => '',
				'values' => array( 
					'headers' => esc_html__( 'Headers',    'revo' ),
					'all'     => esc_html__( 'Everywhere', 'revo' ),
					'custom'  => esc_html__( 'Custom',     'revo' )
				)
			),		
			array(
				'type'	=> 'text',
				'title'	=> esc_html__( 'Webfont Custom Selector', 'revo' ),
				'id'	=> 'webfonts_custom',
				'description' => esc_html__( 'Insert the places will be custom here, after selected custom Webfont assign.', 'revo' ),
				'std'	 => ''	
			),		
		)
	);
	$revo_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Header', 'revo' ),
		'fields'	=> array(
			array(
				'type'	=> 'checkbox',
				'title'	=> esc_html__( 'Hide header', 'revo' ),
				'id'	=> 'page_header_hide',
				'description' => esc_html__( 'Choose to show or hide the header. ', 'revo' ),
				'std' => '0'
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Header Style Select', 'revo' ),
				'id'	=> 'page_header_style',
				'description' => esc_html__( ' Chose to select header page content for this page. ', 'revo' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Header Style', 'revo' ), 'style1' => esc_html__( 'Header Style1', 'revo' ), 'style2' => esc_html__( 'Header Style2', 'revo' ), 'style3' => esc_html__( 'Header Style3', 'revo' ),
							'style4' => esc_html__( 'Header Style4', 'revo' ), 'style5' => esc_html__( 'Header Style5', 'revo' ),'style6' => esc_html__( 'Header Style6', 'revo' ),
							'style7' => esc_html__( 'Header Style7', 'revo' ), 'style8' => esc_html__( 'Header Style8', 'revo' ),'style9' => esc_html__( 'Header Style9', 'revo' ), 'style10' => esc_html__( 'Header Style10', 'revo' ),
							'style11' => esc_html__( 'Header Style11', 'revo' ), 'style12' => esc_html__( 'Header Style12', 'revo' )
				)
			)		
		)
	);

	$revo_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Footer', 'revo' ),
		'fields'	=> array(
			array(
				'type'	=> 'checkbox',
				'title'	=> esc_html__( 'Hide Footer', 'revo' ),
				'id'	=> 'page_footer_hide',
				'description' => esc_html__( 'Choose to show or hide the footer. ', 'revo' ),
				'std'	 => '0',
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Footer Page Select', 'revo' ),
				'id'	=> 'page_footer_style',
				'description' => esc_html__( ' Chose to select footer page content for this page. ', 'revo' ),
				'std'	 => '',
				'values' => revo_build_array( 'page' )
			)
		)
	);
	
	$revo_metabox_pages[] = array(
		'title' 	=> esc_html__( 'Sidebar', 'revo' ),
		'fields'	=> array(
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Sidebar Layout', 'revo' ),
				'id'	=> 'page_sidebar_layout',
				'description' => esc_html__( 'Choose layout sidebar for page', 'revo' ),
				'std'	 => '',
				'values' => array( '' => esc_html__( 'Select Sidebar', 'revo' ), 'full' => esc_html__( 'No Sidebar', 'revo' ), 'left' => esc_html__( 'Sidebar Left', 'revo' ), 'right' => esc_html__( 'Sidebar Right', 'revo' ) )
			),
			array(
				'type'	=> 'select',
				'title'	=> esc_html__( 'Sidebar ', 'revo' ),
				'id'	=> 'page_sidebar_template',
				'description' => esc_html__( ' Chose sidebar to show.', 'revo' ),
				'std'	 => '',
				'values' => revo_build_array( 'sidebar' )
			)		
		)
	);
	
	return apply_filters( 'sw_metabox_fields', $revo_metabox_pages );
}
add_action( 'init', 'revo_metabox_init', 100 );

add_action( 'admin_init', 'revo_page_init', 100 );
add_action( 'save_post', 'revo_page_save_meta', 10, 1 );
function revo_page_init(){
	add_meta_box( 'revo_page_meta', esc_html__( 'Page Metabox', 'revo' ), 'revo_page_meta', array( 'page', 'post', 'product' ), 'normal', 'low' );
}	

/*
** Metabox HTML
*/
function revo_page_meta(){
	global $post;
	wp_nonce_field( 'revo_page_save_meta', 'revo_metabox_plugin_nonce' );
	$revo_metabox_pages = revo_metabox_init();
	$except_args = array( 'General', 'Typography' );
	$current_screen =  get_current_screen()->post_type;	
	if( in_array( $current_screen, array( 'post', 'page', 'product' ) ) ) : 
		wp_enqueue_style( 'metabox_style', REVO_URL .'/admin/css/metabox.css', array(), null );
		wp_enqueue_script( 'tab_script', REVO_URL .'/admin/js/tab.js', array(), null, true );
		wp_enqueue_script( 'revo-opts-field-radio_img-js',	REVO_URL.'/admin/js/field_radio_img.js',	array('jquery'), time(), true	);
	endif; 
?>
	<div class="revo-metabox" id="revo_metabox">
		<div class="revo-metabox-content">
			<ul class="nav nav-tabs">
			<?php 
				$i = 0;
				foreach( $revo_metabox_pages as $metabox ){ 
					if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
						continue;
					}
					$active = ( $i == 0 ) ? 'active' : '';
					echo '<li class="' . esc_attr( $active ) . '"><a href="#revo_'. strtolower( str_replace( ' ', '', $metabox['title'] ) ) .'" data-toggle="tab">' . $metabox['title'] . '</a></li>';
					$i ++;
				} 
			?>
			</ul>
			<div class="tab-content">
			<?php 
				$i = 0;
				foreach( $revo_metabox_pages as $metabox ){ 
					$active = ( $i == 0 ) ? 'active' : '';	
					if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
						continue;
					}
			?>
				<div class="tab-pane <?php echo esc_attr( $active ); ?>" id="revo_<?php echo strtolower( str_replace( ' ', '', $metabox['title'] ) ) ; ?>">
					<?php if( isset( $metabox['fields'] ) && count( $metabox['fields'] ) > 0 ) {?>
						<?php 
							foreach( $metabox['fields'] as $meta_field ) { 
							$values = isset( $meta_field['values'] ) ? $meta_field['values'] : '';
						?>
							<div class="tab-inner clearfix">
								<div class="flytab-description pull-left">
								
									<!-- Title meta field -->
									<?php if( $meta_field['title'] != '' ) { ?>
									<div class="flytab-item-title">
										<?php echo $meta_field['title']; ?>
									</div>
									<?php } ?>
									
									<!-- Description -->
									<?php if( $meta_field['description'] != '' ) { ?>
									<div class="flytab-item-shortdes">
										<?php echo $meta_field['description']; ?>
									</div>
									<?php } ?>
								</div>
								<!-- Meta content -->
								<div class="flytab-content">
									<?php revo_render_html( $meta_field['id'], $meta_field['type'], $values, $meta_field['std'] ); ?>									
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php $i ++; } ?>
			</div>
		</div>
	</div>
<?php 
}

/*
** Function Render HTML
*/
function revo_render_html( $id, $type, $values, $std ){
	global $post;
	$meta_value = '';
	if( get_post_meta( $post->ID, $id, true ) != '' ){
			$meta_value = get_post_meta( $post->ID, $id, true );
	}else if( isset( $std ) && $std != '' ){
		$meta_value = $std;
	}
	$html = '';
	switch( $type ) {
		case 'text' :
			$html .= '<input type="text" value="'. esc_attr( $meta_value ) .'" id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'"/>';
		break;
		
		case 'textarea' :
			$html .= '<texarea id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'"/>'. esc_attr( $meta_value ) .'</texarea>';
		break;
		
		case 'editor' :
			wp_editor( $meta_value, $id, array() );
		break;
		
		case 'select' :
			$html .= '<select id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'">';
				foreach( $values as $key => $value ) {
					$html .= '<option value="'. esc_attr( $key ) .'" '. selected( $meta_value, $key, false ) .'>'. $value .'</option>';
				}
			$html .= '</select>';
		break;
		
		case 'multiselect' :
			$multi_value = array();
			if( is_array( $meta_value ) ){
				$multi_value = $meta_value;
			}else{
				$multi_value[] = $meta_value;
			}
			$select_value = $multi_value;
			$html .= '<select id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'[]" multiple>';
				foreach( $values as $key => $value ) {
					$check = ( in_array( $key, $select_value ) ) ? 'selected="selected"' : '';
					$html .= '<option value="'. esc_attr( $key ) .'" '. $check .'>'. $value .'</option>';
				}
			$html .= '</select>';
		break;
		
		case 'checkbox' :
			$html .= '<input type="checkbox" name="'. esc_attr( $id ) .'" value="1" '. checked( $meta_value, 1, false ) .'/>';
		break;
		
		case 'radio_img' :
			$i = 0;
			$html .= '<div class="page-metabox-radio-img">';
			foreach( $values as $key => $value ) {
				$key_val = ( $key == 'none' ) ? esc_html__( 'No Select', 'revo' ) : $key; 
				$selected = ( checked( $meta_value, $key, false ) != '' ) ? ' revo-radio-img-selected' : '';
				$html .= '<label class="radio-label revo-radio-img'.$selected.' revo-radio-img-'. esc_attr( $id ) .'" for="'. esc_attr( $id ) .'_'. $i .'">';
				$html .= '<input type="radio" id="'. esc_attr( $id ) .'_'. $i .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '.checked($meta_value, $key, false).'/>';
				$html .= '<div class="page-radio-color" style="background: '. esc_attr( $value ) .'" onclick="jQuery:revo_radio_img_select(\''. esc_attr( $id ) .'_'. $i .'\', \''. esc_attr( $id ) .'\');"></div>';
				$html .= '<br/><span>'. esc_attr( $key_val ) .'</span>';
				$html .= '</label>';
				$i ++;
			}
			$html .= '</div>';
		break;
		
		case 'radio' :
			$i = 0;
			$html .= '<div class="page-metabox-radio">';
			foreach( $values as $key => $value ) {
				$html .= '<label class="radio-label '. esc_attr( $id ) .'" for="'. esc_attr( $id ) .'_'. $i .'">';
				$html .= '<input type="radio" id="'. esc_attr( $id ) .'_'. $i .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '.checked($meta_value, $key, false).'/>';
				$html .= '';
				$html .= '<br/><span>'. esc_attr( $value ) .'</span>';
				$html .= '</label>';
				$i ++;
			}
			$html .= '</div>';
		break;
		
		case 'multicheckbox' :
			$multi_value = array();
			if( is_array( $meta_value ) ){
				$multi_value = $meta_value;
			}else{
				$multi_value[] = $meta_value;
			}
			$checkbox_value = $multi_value;
			foreach( $values as $key => $value ) {
				$check = ( in_array( $key, $checkbox_value ) ) ? 'checked' : '';
				$html .= '<div class="metabox-multicheck pull-left"><input type="checkbox" name="'. esc_attr( $id ) .'[]" value="'. esc_attr( $key ) .'" '. $check .'/>';
				$html .= '<br/><label>'. $value .'</label></div>';
			}
		break;
		
		case 'upload' :
			$upload_img = wp_get_attachment_image_url( $meta_value, 'thumbnail' ) ? wp_get_attachment_image_url( intval($meta_value), 'thumbnail' ) : '';
			ob_start();
		?>
			<div class="upload-formfield">
				<div id="metabox_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $upload_img ); ?>" alt="" width="30" height="30" /></div>
				<div class="metabox-thumbnail-wrapper">
					<input type="hidden" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $meta_value ) ?>"/>
					<button type="button" class="upload_image_button button"><?php echo esc_html__( 'Upload/Add image', 'revo' ) ?></button>
					<button type="button" class="remove_image_button button"><?php echo esc_html__( 'Remove image', 'revo' ) ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#<?php echo esc_js( $id ); ?>' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( "Choose an image", 'revo' ); ?>',
							button: {
								text: '<?php esc_html_e( "Use image", 'revo' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment = file_frame.state().get( 'selection' ).first().toJSON();
							
							jQuery( '#<?php echo esc_js( $id ); ?>' ).val( attachment.id );
							console.log('#<?php echo esc_js( $id ); ?>');
							jQuery( '#metabox_thumbnail > img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#metabox_thumbnail > img' ).attr( 'src', 'http://placehold.it/30x30' );
						jQuery( '#<?php echo esc_js( $id ); ?>' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
	<?php
			$html .= ob_get_clean();
		break;
		
		case 'color' :
			$color_value = isset( $meta_value ) ? $meta_value : $std;			
			$html .= '<input type="text" id="'.esc_attr( $id ).'" name="'. esc_attr( $id ) .'" value="'.esc_attr( $color_value ).'" class="revo-popup-colorpicker" style="width:70px;"/>';
		break;
	}
	echo $html;
}

function revo_page_save_meta( $post_id ){	
	if ( ! isset( $_POST['revo_metabox_plugin_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['revo_metabox_plugin_nonce'], 'revo_page_save_meta' ) ) {
		return;
	}
	$revo_metabox_pages = revo_metabox_init(); 	
	$except_args = array( 'General', 'Typography' );
	$current_screen =  isset( get_current_screen()->post_type ) ? get_current_screen()->post_type : '';	
	foreach( $revo_metabox_pages as $key => $metabox ){ 
		if( ( $current_screen == 'post' || $current_screen == 'product' ) && ( in_array( $metabox['title'], $except_args ) ) ){
			continue;
		}		
		foreach( $metabox['fields'] as $meta_field ) {
			$checkbox_val = isset( $_POST[$meta_field['id']] ) ? $_POST[$meta_field['id']] : 0;
			update_post_meta( $post_id, $meta_field['id'], $checkbox_val );
			
			if( isset( $_POST[$meta_field['id']] ) ){
				$data = $_POST[$meta_field['id']];
				switch( $meta_field['type'] ) {
					case 'text' :
						$data = sanitize_text_field( $_POST[$meta_field['id']] );
					break;
					
					case 'email' :
						$data = sanitize_email( $_POST[$meta_field['id']] );
					break;
					
					case 'number' :
						$data = intval( $_POST[$meta_field['id']] );
					break;
					
					case 'upload' :
						$data = intval( $_POST[$meta_field['id']] );
					break;
					
					case 'radio_img' :
						$data = $_POST[$meta_field['id']];
					break;

				}
				update_post_meta( $post_id, $meta_field['id'], $data );
			}else{
				if( $meta_field['std'] != '' ){
					update_post_meta( $post_id, $meta_field['id'], $meta_field['std'] );
				}
			}
		}
	}
}

