<?php
class SW_Options_multi_field extends SW_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since SW_Options 1.0.5
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		if (is_array($value)) {
			foreach ($value as $k => $val) {
				if (isset($val['style-name']) ) {
					$v = trim($val['style-name']);
					if ( !empty($v)) $this->value[$k] = $val;
				}
			}
		}
		
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since SW_Options 1.0.5
	*/
	function render(){
		
		$parent->args['opt_name'] = $this->args['opt_name'].'['.$this->field['id'].'][0]' ;
		$class = (isset($this->field['class']))?esc_attr( $this->field['class'] ):'regular-text';
		
		echo '<table id="'.esc_attr( $this->field['id'] ).'-table">';
		
		if(isset($this->value) && is_array($this->value)){
			foreach($this->value as $k => $value){
				foreach ($this->field['sub_fields'] as $field ) { 
					echo '<tr>';
					echo '<td>'.esc_html( $field['title'] ).'</td><td>';
					$class_field = 'SW_Options_'.$field['type'];
					$render = new $class_field($field, $value[$field['id']], $parent);
					$render->render();
					echo '</td></tr>';
				}
			}//foreach
		}else{
			if ( isset($this->field['sub_fields']) && is_array($this->field['sub_fields']) ){
				foreach ($this->field['sub_fields'] as $field ) { 
					echo '<tr>';
					echo '<td>'.esc_html( $field['title'] ).'</td><td>';
					$class_field = 'SW_Options_'.$field['type'];
					$render = new $class_field($field, '', $parent);
					$render->render();
					echo '</td></tr>';
				}
			}
		
		}//if
				
		echo '</table>';
		
		echo '<a href="javascript:void(0);" class="sw-opts-multi-field-add" rel-id="'.esc_attr( $this->field['id'] ).'-table" rel-name="'.$this->args['opt_name'].'['.$this->field['id'].'][]">'.esc_html__('Add More', 'sw_core').'</a><br/>';
		
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since SW_Options 1.0.5
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'sw-opts-field-multi-field-js', 
			SW_Options_URL.'fields/multi_field/field_multi_field.js', 
			array('jquery'),
			time(),
			true
		);
		
	}//function
	
}//class
?>