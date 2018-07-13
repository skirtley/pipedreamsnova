<?php 
	/* 
	** Content Footer Mobile
	*/
	
?>
<footer id="footer" class="footer-mstyle2 theme-clearfix">
	<div class="footer-container">
		<div class="footer-open"></div>
		<?php if ( has_nav_menu('mobile_menu2') ) {?>
				<div class="menu-footer">
					<?php wp_nav_menu(array('theme_location' => 'mobile_menu2', 'menu_class' => 'nav mobile_menu2')); ?>
				</div>
		<?php } ?>
	</div>
</footer>