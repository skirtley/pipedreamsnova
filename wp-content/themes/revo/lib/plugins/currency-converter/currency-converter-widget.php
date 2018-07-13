<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Currency Converter Widget
 *
 * @package		WooCommerce
 * @category	Widgets
 * @author		WooThemes
 */
class WooCommerce_Widget_Currency_Converter extends WP_Widget {

	/** @var string Widgets ID */
	private $widget_id_base = 'woocommerce_currency_converter';

	/**
	 * Register the Widget with WP
	 */
	public static function register() {
		register_widget( 'WooCommerce_Widget_Currency_Converter' );
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( $this->widget_id_base, esc_html__( 'WooCommerce Currency Converter', 'revo' ), array(
			'classname'   => 'widget_currency_converter',
			'description' =>  esc_html__( 'Allow users to choose a currency for prices to be displayed in.', 'revo' )
		) );
	}

	/**
	 * Output the widget content
	 * @param  array $args
	 * @param  array $instance
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->widget_id_base );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		do_action( 'woocommerce_currency_converter', $instance, true );

		echo $after_widget;
	}

	/**
	 * Save settings form
	 * @param  array $new_instance
	 * @param  array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance['title']            = empty( $new_instance['title'] ) ? '' : wc_clean( $new_instance['title'] );
		$instance['currency_codes']   = empty( $new_instance['currency_codes'] ) ? '' : implode( "\n", array_map( 'wc_clean', explode( "\n", $new_instance['currency_codes'] ) ) );
		$instance['message']          = empty( $new_instance['message'] ) ? '' : wc_clean( $new_instance['message'] );
		$instance['show_reset']       = empty( $new_instance['show_reset'] ) ? '' : wc_clean( $new_instance['show_reset'] );
		$instance['show_symbols']     = empty( $new_instance['show_symbols'] ) ? '' : wc_clean( $new_instance['show_symbols'] );
		$instance['currency_display'] = empty( $new_instance['currency_display'] ) ? '' : wc_clean( $new_instance['currency_display'] );
		$instance['disable_location'] = empty( $new_instance['disable_location'] ) ? false : (bool) $new_instance['disable_location'];

		// We want to save the "disable_location" to options table
		// as this setting should be global and easily retrieved to
		// be set in cookie. TODO: move setting away from widget to
		// products tab in WC setting.
		update_option( 'wc_currency_converter_disable_location', empty( $new_instance['disable_location'] ) ? false : (bool) $new_instance['disable_location'] );

		update_option( 'wc_currency_converter_allowed_currencies', empty( $new_instance['currency_codes'] ) ? '' : implode( "\n", array_map( 'wc_clean', explode( "\n", $new_instance['currency_codes'] ) ) ) );

		return $instance;
	}

	/**
	 * Settings Form
	 * @param  array $instance
	 */
	public function form( $instance ) {
		$instance['currency_display'] = empty( $instance['currency_display'] ) ? '' : $instance['currency_display'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'revo' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php if ( isset( $instance['title'] ) ) echo esc_attr( $instance['title'] ); else echo esc_html__( 'Currency converter', 'revo' ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'currency_codes' ); ?>"><?php esc_html_e( 'Currency codes:', 'revo' ); ?> <small>(<?php esc_html_e( '1 per line', 'revo' ) ?>)</small></label>
			<textarea class="widefat" rows="5" cols="20" name="<?php echo $this->get_field_name( 'currency_codes' ); ?>" id="<?php echo $this->get_field_id( 'currency_codes' ); ?>"><?php if ( ! empty( $instance['currency_codes'] ) ) echo esc_attr( $instance['currency_codes'] ); else echo "USD\nEUR"; ?></textarea>
			<p class="description"><?php esc_html_e( "Use * to control how the amounts and currency symbols are displayed. Example: SEK* becomes 999kr. USD * becomes 999 $. If you omit * and just provide the currency (USD, EUR), WooCommerce's default currency position will be used.", 'revo' ); ?></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'currency_display' ); ?>"><?php esc_html_e( 'Currency Display Mode:', 'revo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'currency_display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'currency_display' ) ); ?>">
				<option value="" <?php selected( $instance['currency_display'], '' ) ?>><?php esc_html_e( 'Buttons', 'revo' ); ?></option>
				<option value="select" <?php selected( $instance['currency_display'], 'select' ) ?>><?php esc_html_e( 'Select Box', 'revo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'message' ); ?>"><?php esc_html_e( 'Widget message:', 'revo' ) ?></label>
			<textarea class="widefat" rows="5" cols="20" name="<?php echo $this->get_field_name( 'message' ); ?>" id="<?php echo $this->get_field_id( 'message' ); ?>"><?php if ( isset ( $instance['message'] ) ) echo esc_attr( $instance['message'] ); else esc_html_e( "Currency conversions are estimated and should be used for informational purposes only.", 'revo' ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_symbols' ); ?>"><?php esc_html_e( 'Show currency symbols in widget:', 'revo' ) ?></label>
			<input type="checkbox" class="" id="<?php echo esc_attr( $this->get_field_id( 'show_symbols' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_symbols') ); ?>" value="1" <?php if ( isset( $instance['show_symbols'] ) ) checked( $instance['show_symbols'], 1 ); ?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_reset' ); ?>"><?php esc_html_e( 'Show reset link:', 'revo' ) ?></label>
			<input type="checkbox" class="" id="<?php echo esc_attr( $this->get_field_id( 'show_reset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_reset' ) ); ?>" value="1" <?php if ( isset( $instance['show_reset'] ) ) checked( $instance['show_reset'], 1 ); ?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'disable_location' ); ?>"><?php esc_html_e( 'Disable location detection:', 'revo' ) ?></label>
			<input type="checkbox" class="" id="<?php echo esc_attr( $this->get_field_id( 'disable_location' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_location' ) ); ?>" value="1" <?php if ( isset( $instance['disable_location'] ) ) checked( $instance['disable_location'], 1 ); ?> />
			<p class="description"><?php esc_html_e( "The currency converter widget will default to the currency for a user's currenct location. Check this box to disable location detection and default to the store's currency.", 'revo' ); ?></p>
		</p>
		<?php
	}
}

WooCommerce_Widget_Currency_Converter::register();
