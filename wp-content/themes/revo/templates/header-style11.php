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
			<!-- Logo -->
				<div class="top-header pull-left">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
			
			<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
					<div id="main-menu" class="main-menu clearfix pull-left">
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
				
				<!-- Cart header -->
				<div class="sw-revo-cart  pull-right">
					<?php get_template_part( 'woocommerce/minicart-ajax-style2' ); ?>
				</div>
				
				<!-- Sidebar Top Menu -->
				<div class="search-cate pull-right">
					<div class="search-icon"><i class="fa fa-search"></i></div>
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
			
			</div>
	</div>
</header>