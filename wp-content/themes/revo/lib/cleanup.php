<?php
/**
 * Add and remove body_class() classes
 */
function revo_body_class($classes) {
	$page_metabox_hometemp  = get_post_meta( get_the_ID(), 'page_home_template', true );
	$menu_event		  		= sw_options( 'menu_event' );
	$disable_search 		=  sw_options( 'disable_search' );
	$sw_demo   		  		= get_option( 'sw_mdemo' );
	$single_video			= get_post_meta( get_the_ID(), 'featured_video_product', true );
	$revo_box_layout 		= sw_options( 'layout' );
	$product_single_style 	= sw_options( 'product_single_style' );
	$revo_direction 		= sw_options( 'direction' );
	$revo_single_thunbmail  = ( sw_options( 'product_single_thumbnail' ) ) ? sw_options( 'product_single_thumbnail' ) : 'bottom';
	
	if( $revo_direction == 'rtl' ){
		$classes[] = 'rtl';
	}
	
	/* WC Vendor class */
	if( class_exists( 'WC_Vendors' ) ) {
		$classes[] = 'wc-vendor-page';
		if( WCV_Vendors::is_vendor_page() ) {
			$classes[] = 'wc-vendor-listing';
		}
	}
	
	if( $menu_event == 'click' ){
		$classes[] = 'menu-click';
	}
	
	if( $sw_demo == 1 ){
		$classes[] = 'mobile-demo';
	}
	
	if( $single_video != '' && is_singular( 'product' ) ){
		$classes[] = 'product-video';
	}
	
	if( get_option( 'sw_wooswatches_enable' ) && !is_singular( 'product' ) ){
		$classes[] = 'sw-wooswatches';
	}
	
	if( revo_mobile_check() ){
		$classes[] = 'mobile-layout';
	}
	if( $disable_search  ){
		$classes[] = 'disable-search';
	}
	if( $revo_box_layout == 'boxed' ){
		$classes[] = 'boxed-layout';
	}
	if( $page_metabox_hometemp != '' && is_page() ){
		$classes[] = $page_metabox_hometemp;
	}

	// Add post/page slug
	if (is_single() || is_page() && !is_front_page()) {
		$classes[] = basename(get_permalink());
	}	
	
	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
			'page-template-default',
			$home_id_class
	);
	
	if( is_singular( 'product' ) ){
		$classes[] = 'single-product-' . $product_single_style;	
		$classes[] = 'product-thumbnail-' . $revo_single_thunbmail;
	}
	
	$classes = array_diff($classes, $remove_classes);
	return apply_filters( 'revo_custom_body_class', $classes );
}
add_filter('body_class', 'revo_body_class');


/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function revo_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
	$cache = preg_replace('/width="(.*?)?"/', 'width="100%"', $cache);
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'revo_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'revo_embed_wrap', 10, 2);

/**
 * Add class="thumbnail" to attachment items
 */
function revo_attachment_link_class($html) {
	$postid = get_the_ID();
	$html = str_replace('<a', '<a class="thumbnail"', $html);
	return $html;
}
add_filter('wp_get_attachment_link', 'revo_attachment_link_class', 10, 1);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function revo_caption($output, $attr, $content) {
	if (is_feed()) {
		return $output;
	}

	$defaults = array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => ''
	);

	$attr = shortcode_atts($defaults, $attr);

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ($attr['width'] < 1 || empty($attr['caption'])) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
	$attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

	$output  = '<figure' . $attributes .'>';
	$output .= do_shortcode($content);
	$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter('img_caption_shortcode', 'revo_caption', 10, 3);


/**
 * Clean up the_excerpt()
 */
function revo_excerpt_length($length) {
	return 40;
}

function revo_excerpt_more($more) {
	//return;
	return ' &hellip; <a href="' . get_permalink() . '">' . esc_html__('Readmore', 'revo') . '</a>';
}
add_filter('excerpt_length', 'revo_excerpt_length');
add_filter('excerpt_more',   'revo_excerpt_more');

/**
 * Remove unnecessary self-closing tags
 */
function revo_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'revo_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',   'revo_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'revo_remove_self_closing_tags'); // <img />


/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
function revo_change_mce_options($options) {
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

	if (isset($initArray['extended_valid_elements'])) {
		$options['extended_valid_elements'] .= ',' . $ext;
	} else {
		$options['extended_valid_elements'] = $ext;
	}

	return $options;
}
add_filter('tiny_mce_before_init', 'revo_change_mce_options');

/**
 * Add additional classes onto widgets
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function revo_widget_first_last_classes($params) {
	global $my_widget_num;

	$this_id = $params[0]['id'];
	$arr_registered_widgets = wp_get_sidebars_widgets();

	if (!$my_widget_num) {
		$my_widget_num = array();
	}

	if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
		return $params;
	}

	if (isset($my_widget_num[$this_id])) {
		$my_widget_num[$this_id] ++;
	} else {
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . esc_attr( $my_widget_num[$this_id] ) . ' ';

	if ($my_widget_num[$this_id] == 1) {
		$class .= 'widget-first ';
	} elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

	return $params;
}
add_filter('dynamic_sidebar_params', 'revo_widget_first_last_classes');

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function revo_nice_search_redirect() {
	global $revo_rewrite;
	if (!isset($revo_rewrite) || !is_object($revo_rewrite) || !$revo_rewrite->using_permalinks()) {
		return;
	}

	$search_base = $revo_rewrite->search_base;
	if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}
if (current_theme_supports('nice-search')) {
	add_action('template_redirect', 'revo_nice_search_redirect');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/revo-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function revo_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}
add_filter('request', 'revo_request_filter');



function revo_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'revo' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'revo_wp_title', 10, 2 );


add_filter('wp_link_pages_args','add_next_and_number');
function add_next_and_number($args){
    if($args['next_or_number'] == 'next_and_number'){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
					$prev .='<p>';
                    $prev .= _wp_link_page($i);
                    $prev .= $args['link_before'].$args['previouspagelink'] . $args['link_after'] . '</a></p>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
					$next .='<p>';
                    $next .= _wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a></p>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];    
    }
    return $args;
}
