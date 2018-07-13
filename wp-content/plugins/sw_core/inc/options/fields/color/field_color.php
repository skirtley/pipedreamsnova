<?php
class SW_Options_color extends SW_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since SW_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since SW_Options 1.0
	*/
	function render(){
		
		$class = (isset($this->field['class']))? esc_attr( $this->field['class'] ):'';
		
		echo '<div class="farb-popup-wrapper">';
		
		echo '<input type="text" id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.esc_attr( $this->value ).'" class="'.$class.' sw-popup-colorpicker" style="width:70px;"/>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div><span class="description">'.esc_html( $this->field['desc'] ).'</span></div>':'';
		
		echo '</div>';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since SW_Options 1.0
	*/
	function enqueue(){
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script(
			'sw-opts-field-color-js', 
			SW_OPTIONS_URL.'/options/fields/color/field_color.js', 
			array('jquery', 'wp-color-picker'),
			time(),
			true
		);
		
	}//function
	
}//class
?>