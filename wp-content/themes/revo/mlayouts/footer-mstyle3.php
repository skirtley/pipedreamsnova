<?php 
	/* 
	** Content Footer Mobile
	*/
	
?>
<footer id="footer" class="footer-mstyle3 theme-clearfix">
	<div class="footer-container">
		<?php if ( has_nav_menu('mobile_menu3') ) {?>
				<div class="menu-footer">
					<?php wp_nav_menu(array('theme_location' => 'mobile_menu3', 'menu_class' => 'nav mobile_menu3')); ?>
				</div>
		<?php } ?>
	</div>
</footer>