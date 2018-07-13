<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_colorset = sw_options('scheme');
	$revo_logo = sw_options('sitelogo');
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top clearfix">
		<div class="container">
			<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('top9')) {?>
							<?php dynamic_sidebar('top9'); ?>
				<?php }?>
		</div>
	</div>
	<div class="header-bottom clearfix">
		<div class="container">
			<div class="row">
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu1') ) { ?>
					<div id="main-menu" class="main-menu clearfix col-lg-5 col-md-5 col-sm-3 col-xs-3 pull-left">
						<nav id="primary-menu" class="primary-menu">
							<div class="mid-header clearfix">
								<div class="navbar-inner navbar-inverse">
										<?php
											$revo_menu_class = 'nav nav-pills';
											if ( 'mega' == sw_options('menu_type') ){
												$revo_menu_class .= ' nav-mega';
											} else $revo_menu_class .= ' nav-css';
										?>
										<?php wp_nav_menu(array('theme_location' => 'primary_menu1', 'menu_class' => $revo_menu_class)); ?>
								</div>
							</div>
						</nav>
					</div>			
				<?php } ?>
				<!-- Logo -->
				<div class="top-header col-lg-3 col-md-4 col-sm-5 col-xs-5">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
				<div class="header-right pull-right">
						<?php if (is_active_sidebar('header-right9')) {?>
						<div class="top-header">
								<?php dynamic_sidebar('header-right9'); ?>
						</div>
				<?php }?>
				</div>
			</div>
		</div>
	</div>
</header>