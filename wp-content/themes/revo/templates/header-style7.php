<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$revo_colorset = sw_options('scheme');
	$revo_logo = sw_options('sitelogo');
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	$revo_menu_text 	= ( sw_options( 'menu_title_text' ) )	 ? sw_options( 'menu_title_text' )	: esc_html__( 'Categories', 'revo' );
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
	<div class="header-mid clearfix">
		<div class="container">
			<div class="row">
			<!-- Logo -->
				<div class="top-header col-lg-3 col-md-3 col-sm-12 pull-left">
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
				<div class="mid-header header-right pull-right">
					<?php if (is_active_sidebar('mid-header')) {?>
						<?php dynamic_sidebar('mid-header'); ?>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom clearfix">
		<div class="container">
			<div class="rows">
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
					<div id="main-menu" class="main-menu clearfix">
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
				<?php if( $sticky_menu ): ?>
					<i class="fa fa-search"></i>
					<div class="sticky-search pull-right">
						<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( has_nav_menu('vertical_menu') ) {?>
		<div class="vertical_megamenu">
			<div class="mega-left-title"><strong><?php echo esc_html( $revo_menu_text ); ?></strong></div>
			<div class="vc_wp_custommenu wpb_content_element">
				<div class="wrapper_vertical_menu">
					<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
				</div>
			</div>
		</div>
	<?php } ?>
</header>