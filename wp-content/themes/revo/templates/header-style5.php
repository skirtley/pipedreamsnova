<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$revo_colorset = sw_options('scheme');
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top">
		<div class="container">
			<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('top')) {?>
					<div class="top-header">
							<?php dynamic_sidebar('top'); ?>
					</div>
				<?php }?>
		</div>
	</div>
	<div class="header-mid">
		<div class="container">
			<div class="row">
			<!-- Logo -->
				<div class="top-header col-lg-3 col-md-3 col-sm-12">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
			<!-- Sidebar Top Menu -->
				<div class="search-cate pull-left">
					<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
						<?php dynamic_sidebar( 'search' ); ?>
					<?php else : ?>
					<div class="widget revo_top-3 revo_top non-margin">
						<div class="widget-inner">
							<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<?php if (is_active_sidebar('contact-us')) {?>
					<div  class="contact-us-header pull-right">
							<?php dynamic_sidebar('contact-us'); ?>
					</div>
				<?php }?>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<div class="row">
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
					<div id="main-menu" class="main-menu clearfix col-lg-9 col-md-9 pull-left">
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
				<?php if( $sticky_menu ) : ?>
						<div class="sticky-search pull-right">
							<i class="fa fa-search"></i>
							<div class="sticky-search-content">
								<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
							</div>
						</div>
				<?php endif; ?>
				<div class="header-right col-lg-3 col-md-3 col-sm-4 col-xs-4 pull-right">
					<?php if (is_active_sidebar('bottom-header')) {?>
						<?php dynamic_sidebar('bottom-header'); ?>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</header>