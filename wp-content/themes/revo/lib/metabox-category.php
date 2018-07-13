<?php 

/*
	* Name: Metabox Category
	* Develope: Smartaddons
*/

	$revo_taxies = sw_options( 'tax_select' );
	/* Add Custom field to category product */
	if( !empty( $revo_taxies ) ){
		foreach( $revo_taxies as $revo_tax ){
			add_action( $revo_tax . '_add_form_fields', 'revo_category_fields', 200 );
			add_action( $revo_tax . '_edit_form_fields', 'revo_edit_category_fields', 200 );
		}
		add_action( 'created_term', 'revo_save_category_fields', 10, 3 );
		add_action( 'edit_terms', 'revo_save_category_fields', 10, 3 );
	}
	
	function revo_category_fields(){
		$number  = array( 0 => esc_html__( 'Select column', 'revo' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'revo' ),
			'full' => esc_html__( 'Full Layout', 'revo' ),		
			'right' => esc_html__( 'Right Sidebar', 'revo' )
		);
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="extra1"><?php esc_html_e('Sale Of(%)','revo'); ?></label></th>
		<td>
			<input type="text" name="sale_of" id="sale_of" size="25" style="width:60%;" value="<?php echo esc_attr( $sale_of ) ?  esc_attr( $sale_of ) : ''; ?>"><br />
		</td>
	</tr>

	<div class="form-field">
		<label><?php  esc_html_e( 'Sidebar Product Layout', 'revo' ) ?></label>
		<select id="term_sidebar" name="term_sidebar">
			<?php 
				foreach( $sidebar as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>

	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for desktop screen', 'revo' ) ?></label>
		<select id="term_col_lg" name="term_col_lg">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for small desktop screen', 'revo' ) ?></label>
		<select id="term_col_md" name="term_col_md">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="form-field">
		<label><?php  esc_html_e( 'Select column for tablet screen', 'revo' ) ?></label>
		<select id="term_col_sm" name="term_col_sm">
			<?php 
				foreach( $number as $k => $v ){
					echo '<option value="'.esc_attr( $k ).'">'.esc_html( $v ).'</option>';
				}
			?>
		</select>
	</div>
<?php 
	}
	function revo_edit_category_fields( $term ){
		$number = array( 0 => esc_html__( 'Select column', 'revo' ), 1, 2, 3, 4 );
		$sidebar = array( 
			'left'	=> esc_html__( 'Left Sidebar', 'revo' ),
			'full' => esc_html__( 'Full Layout', 'revo' ),		
			'right' => esc_html__( 'Right Sidebar', 'revo' )
		);
		
		$term_col_lg  = get_term_meta( $term->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( $term->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( $term->term_id, 'term_col_sm', true );
		$term_sidebar = get_term_meta( $term->term_id, 'term_sidebar', true );
		$sale_of  = get_term_meta( $term->term_id, 'sale_of', true );
		
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="extra1"><?php esc_html_e('Sale Of(%)', 'revo'); ?></label></th>
		<td>
			<input type="text" name="sale_of" id="sale_of" size="25" style="width:60%;" value="<?php echo $sale_of ? $sale_of : ''; ?>"><br />
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Sidebar Product Layout', 'revo' ) ?></label></th>
		<td>	
			<select id="term_sidebar" name="term_sidebar">
				<?php 
					foreach( $sidebar as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_sidebar, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for desktop screen', 'revo' ) ?></label></th>
		<td>
			<select id="term_col_lg" name="term_col_lg">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_lg, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for medium desktop screen', 'revo' ) ?></label></th>
		<td>
			<select id="term_col_md" name="term_col_md">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_md, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php  esc_html_e( 'Select column for tablet screen', 'revo' ) ?></label></th>
		<td>
			<select id="term_col_sm" name="term_col_sm">
				<?php 
					foreach( $number as $k => $v ){
						echo '<option value="'.esc_attr( $k ).'" '.selected( $term_col_sm, $k, false ).'>'.esc_html( $v ).'</option>';
					}
				?>
			</select>
			<div class="clear"></div>
		</td>
	</tr>
<?php 
	}

	function revo_save_category_fields( $term_id, $tt_id = '', $taxonomy = '', $prev_value = '' ){
		$term_args = array( 'term_col_lg', 'term_col_md', 'term_col_sm', 'term_sidebar','sale_of' );
		foreach( $term_args as $value ){
			if( isset( $_POST[$value] ) ) {
				$term_value = '';
				if( preg_match_all( "/col/", $value, $output ) ){
					$term_value = intval( $_POST[$value] );
				}else{
					$term_value = esc_attr( $_POST[$value] );
				}
        update_term_meta( $term_id, $value, $term_value, $prev_value );
			}
		}
	}