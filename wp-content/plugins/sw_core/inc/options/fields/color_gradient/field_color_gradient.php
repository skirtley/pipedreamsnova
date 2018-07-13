<?php
class SW_Options_color_gradient extends SW_Options{	
	
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
		
		echo '<div class="farb-popup-wrapper" id="'.esc_attr( $this->field['id'] ).'">';
		
		echo esc_html__('From:', 'sw_core').' <input type="text" id="'.esc_attr( $this->field['id'] ).'-from" name="'.$this->args['opt_name'].'['.$this->field['id'].'][from]" value="'.esc_attr( $this->value['from'] ).'" class="'.$class.' popup-colorpicker" style="width:70px;"/>';
		echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.esc_attr( $this->field['id'] ).'-frompicker" class="color-picker"></div></div></div>';
		
		echo esc_html__(' To:', 'sw_core').' <input type="text" id="'.esc_attr( $this->field['id'] ).'-to" name="'.$this->args['opt_name'].'['.$this->field['id'].'][to]" value="'.esc_attr( $this->value['to'] ).'" class="'.$class.' popup-colorpicker" style="width:70px;"/>';
		echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'-topicker" class="color-picker"></div></div></div>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
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
		
		wp_enqueue_script(
			'sw-opts-field-color-js', 
			SW_Options_URL.'fields/color/field_color.js', 
			array('jquery', 'farbtastic'),
			time(),
			true
		);
		
	}//function
	
}//class
?>