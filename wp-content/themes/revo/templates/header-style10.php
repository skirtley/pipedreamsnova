<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$revo_colorset = sw_options('scheme');
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_logo = sw_options('sitelogo');
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top">
		<div class="container">
			<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('top10')) {?>
					<div class="top-header">
							<?php dynamic_sidebar('top10'); ?>
					</div>
				<?php }?>
		</div>
	</div>
	<div class="header-mid clearfix">
		<div class="container">
			<div class="row">
			<!-- Logo -->
				<div class="top-header col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-left">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
			<!-- Sidebar Top Menu -->
				<div class="search-cate col-lg-5 col-md-5 col-sm-12 col-xs-12 pull-left">
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
				<div class="header-right col-lg-4 col-md-4 col-sm-6 col-xs-6">
				<?php if (is_active_sidebar('contact-us')) {?>
					<div  class="contact-us-header pull-right">
							<?php dynamic_sidebar('contact-us'); ?>
					</div>
				<?php }?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom clearfix">
		<div class="container">
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
</header>