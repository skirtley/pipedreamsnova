jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.sw-opts-group-tab:first').slideDown('fast');
		jQuery('#sw-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+sw_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(sw_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.sw-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.sw-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).show();
			}else{
				jQuery(this).hide();
			}
			
		});
		
		jQuery('.sw-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#sw-opts-save').is(':visible')){
		jQuery('#sw-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#sw-opts-imported').is(':visible')){
		jQuery('#sw-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#sw-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#sw-opts-import-code-button').click(function(){
		if(jQuery('#sw-opts-import-link-wrapper').is(':visible')){
			jQuery('#sw-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#sw-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#sw-opts-import-link-button').click(function(){
		if(jQuery('#sw-opts-import-code-wrapper').is(':visible')){
			jQuery('#sw-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#sw-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#sw-opts-export-code-copy').click(function(){
		if(jQuery('#sw-opts-export-link-value').is(':visible')){jQuery('#sw-opts-export-link-value').fadeOut('slow');}
		jQuery('#sw-opts-export-code').toggle('fade');
	});
	
	jQuery('#sw-opts-export-link').click(function(){
		if(jQuery('#sw-opts-export-code').is(':visible')){jQuery('#sw-opts-export-code').fadeOut('slow');}
		jQuery('#sw-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
});