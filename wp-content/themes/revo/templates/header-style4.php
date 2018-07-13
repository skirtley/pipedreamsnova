<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$revo_colorset = sw_options('scheme');
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top">
		<div class="container">
				<!-- Logo -->
				<div class="top-header col-xs-12">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
				<div class="header-open">
					<span class="btn_menu_line"></span>
					<span class="btn_menu_line"></span>
					<span class="btn_menu_line"></span>
				</div>
				<?php if (is_active_sidebar('header-left')) {?>
					<div  class="header-left pull-left">
							<?php dynamic_sidebar('header-left'); ?>
					</div>
				<?php }?>
				<?php if (is_active_sidebar('header-right4')) {?>
					<div  class="header-right pull-right">
							<?php dynamic_sidebar('header-right4'); ?>
					</div>
				<?php }?>
		</div>
		<!-- Primary navbar -->
			<?php if ( has_nav_menu('primary_menu') ) { ?>
				<div id="main-menu" class="main-menu clearfix">
					<div class="header-close">
						<span class="btn_menu_line"></span>
						<span class="btn_menu_line"></span>
						<span class="btn_menu_line"></span>
					</div>
					<nav id="primary-menu" class="primary-menu">
						<div class="mid-header clearfix">
							<div class="navbar-inner navbar-inverse">
									<?php
										$revo_menu_class = 'nav nav-pills';
										if ( 'mega' == sw_options('menu_type') ){
											$revo_menu_class .= ' nav-mega';
										} else $revo_menu_class .= ' nav-css';
									?>
									<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $revo_menu_class)); ?>
							</div>
						</div>
					</nav>
				</div>			
			<?php } ?>
		<!-- /Primary navbar -->
	</div>
</header>