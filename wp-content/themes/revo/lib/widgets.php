<?php
/**
 * Register sidebars and widgets
 */
function revo_unregister_default_widgets() {
	unregister_widget('WC_Widget_Featured_Products');
	unregister_widget('WC_Widget_Best_Sellers');
	unregister_widget('WC_Widget_Top_Rated_Products');
	unregister_widget( 'WC_Widget_Product_Categories' );
	if ( class_exists( 'WooCommerce' ) ) {
		include_once( get_template_directory() . '/widgets/woocommerce/widget-product-categories.php' );
		register_widget( 'Custom_WC_Widget_Product_Categories' );
	}
}
add_action('widgets_init', 'revo_unregister_default_widgets', 11);
 
/*
** Register Sidebar and Widgets
*/
function revo_widgets_init() {
	
	// Sidebars
	global $revo_widget_areas;
	$revo_widget_areas = revo_widget_setup_args();
	if ( count($revo_widget_areas) ){
		foreach( $revo_widget_areas as $sidebar ){
			$sidebar_params = apply_filters('revo_sidebar_params', $sidebar);
			register_sidebar($sidebar_params);
		}
	}

	// Widgets
	register_widget('Revo_Social_Widget');
	register_widget('Revo_Top_Widget');
}
add_action('widgets_init', 'revo_widgets_init');

/**
 * Posts widget class
 *
 * @since 2.8.0
*/

class Revo_Top_Widget extends Revo_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'sw_top', 'description' => esc_html__('SW top header widget', 'revo'));
		parent::__construct('sw_top', esc_html__('SW Top Widget', 'revo'), $widget_ops);
	}
}

class Revo_Social_Widget extends WP_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'sw_social', 'description' => esc_html__('SW Social Networks', 'revo'));
		parent::__construct('sw_social', esc_html__('SW Social', 'revo'), $widget_ops);
		$this->option_name='socials';
	}

	function widget($args, $instance){
		$socials  = isset($instance['socials']) && is_array($instance['socials']) ? $instance['socials'] : array();
		extract($args);
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ($title){
			echo $before_title . $title . $after_title;
		}
		?>
		<ul>
			<?php foreach ($socials as $social){?>
			<?php preg_match('/fa-.*?/', $social['icon'], $match); ?>
			<li><a href="<?php echo esc_url( $social['link'] ); ?>"
				title="<?php if (empty($match)) echo esc_attr( $social['icon'] ); ?>"> <?php if (empty($match)) echo esc_html( $social['icon'] ); else { ?>
					<i class="fa <?php echo esc_attr( $social['icon'] )?>"></i> <?php }?>
			</a></li>
			<?php } ?>
		</ul>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$socials = array();
		foreach ($new_instance['socials'] as $i => $social){
			if (isset($social['icon'])){
				$icon = trim(strip_tags($social['icon']));
				if ( !empty($icon) ){
					$link = trim(strip_tags($social['link']));
					if ( empty($link) ){
						$link = '#';
					}
					$socials[]= array( 'icon' => $icon, 'link' => $link );
				}
			}
		}
		$instance['socials'] = $socials;
		return $instance;
	}

	function form($instance){ 
		$title   = isset($instance['title']) ? sanitize_title($instance['title']) : '';
		$socials = isset($instance['socials']) && is_array($instance['socials']) ? $instance['socials'] : array();

		?>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title: ', 'revo'); ?>
	</label> <input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id('title') ); ?>"
		name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text"
		value="<?php echo esc_attr($title); ?>" />
</p>

<?php 
		// if saved data
		foreach ($socials as $j => $social){

			$name_j = $this->get_field_name($this->option_name).'['.$j.']';
			$id_j = $this->get_field_id($this->option_name).'_'.$j;

			$name_j_icon = $name_j.'[icon]';
			$id_j_icon = $id_j.'_icon';

			$name_j_link = $name_j.'[link]';
			$id_j_link = $id_j.'_link';
			?>
<p>
	<strong><?php echo esc_html__( 'Social', 'revo' ). ' ' .$j+1; ?>
	</strong><br>
	<?php if (key_exists('icon', $social)){?>
	<label for="<?php echo esc_attr( $id_j_icon ); ?>"><?php esc_html_e('fa-* | title', 'revo')?>
	</label> <input class="widefat" id="<?php echo esc_attr( $id_j_icon );?>"
		name="<?php echo esc_attr($name_j_icon); ?>" type="text"
		value="<?php echo esc_attr( $social['icon'] ); ?>"><br>
	<?php }?>
	<label for="<?php echo esc_attr( $id_j_link ); ?>"><?php esc_html_e('Link ', 'revo')?> </label>
	<input class="widefat" id="<?php echo esc_attr( $id_j_link );?>"
		name="<?php echo esc_attr($name_j_link); ?>" type="text"
		value="<?php echo esc_attr( $social['link'] ); ?>">
</p>
<?php
		}

		// revo fields for add new social network
		$i = (is_array($socials) && count($socials)) ? count($socials) : 0;

		$name_i = $this->get_field_name($this->option_name).'['.$i.']';
		$id_i = $this->get_field_id($this->option_name).'_'.$i;

		$name_i_icon = $name_i.'[icon]';
		$id_i_icon = $id_i.'_icon';

		$name_i_link = $name_i.'[link]';
		$id_i_link = $id_i.'_link';

		?>
<p>
	<strong><?php esc_html_e( 'Add a new social network', 'revo' ) ?></strong><br> <label
		for="<?php echo esc_attr( $id_i_icon ); ?>"><?php esc_html_e('Classname for Icon or Title', 'revo'); ?>
	</label> <input class="widefat" id="<?php echo esc_attr( $id_i_icon ); ?>"
		name="<?php echo esc_attr( $name_i_icon ); ?>" type="text" value=""
		placeholder="<?php esc_attr_e( 'Enter Font Awesome icon or Title', 'revo' ) ?>" /> <span><?php esc_html_e( 'If using as
		icon, please choose class name in Font Awesome. This is required.', 'revo' ) ?></span>
	<label for="<?php echo esc_attr( $id_i_link ); ?>"><?php esc_html_e('Link ', 'revo')?> </label>
	<input class="widefat" id="<?php echo esc_attr( $id_i_link ); ?>"
		name="<?php echo esc_attr( $name_i_link ); ?>" type="text" value=""
		placeholder="#" />
</p>
<?php
	}

}