<?php
	/* 
	** Content Header
	*/
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_colorset = sw_options('scheme');
	$revo_logo = sw_options('sitelogo');
	$disdisable_cart =  sw_options( 'disable_cart' );
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	$revo_menu_text 	= ( sw_options( 'menu_title_text' ) )	 ? sw_options( 'menu_title_text' )	: esc_html__( 'Categories', 'revo' );
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top">
		<div class="container">
			<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('top2')) {?>
					<div class="top-header">
							<?php dynamic_sidebar('top2'); ?>
					</div>
				<?php }?>
		</div>
	</div>
	<div class="header-mid clearfix">
		<div class="container">
			<div class="row">
			<!-- Logo -->
				<div class="top-header col-lg-3 col-md-2 col-sm-12 col-xs-12 pull-left">
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
	<div class="header-bottom clearfix">
		<div class="container">
			<div class="bottom-content clearfix">
				<!-- Primary navbar -->
				<?php if ( has_nav_menu('primary_menu') ) { ?>
					<div id="main-menu" class="main-menu clearfix col-lg-7 col-md-8 pull-left">
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
				<?php if( !$disdisable_cart ) :?>
				<div class="header-right pull-right">
					<?php get_template_part( 'woocommerce/minicart-ajax-style4' ); ?>
				</div>
				<?php endif; ?>
				<?php if( $sticky_menu ) : ?>
					<div class="sticky-search pull-right"><i class="fa fa-search"></i></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( has_nav_menu('vertical_menu') ) {?>
		<div class="vertical_megamenu">
			<div class="mega-left-title"><strong><?php echo esc_html( $revo_menu_text ) ?></strong></div>
			<div class="vc_wp_custommenu wpb_content_element">
				<div class="wrapper_vertical_menu">
					<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
				</div>
			</div>
		</div>
	<?php } ?>
</header>