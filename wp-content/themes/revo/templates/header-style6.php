<?php
	/* 
	** Content Header
	*/
	$sticky_menu 		= sw_options( 'sticky_menu' );
	$revo_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
	$revo_colorset = sw_options('scheme');
	$disable_search =  sw_options( 'disable_search' );
	$revo_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $revo_page_header );?>">
	<div class="header-top">
		<div class="container">
			<!-- Sidebar Top Menu -->
				<?php if (is_active_sidebar('top1')) {?>
					<div class="top-header">
							<?php dynamic_sidebar('top1'); ?>
					</div>
				<?php }?>
		</div>
	</div>
	<div class="header-mid">
		<div class="container">
			<div class="row">
				<?php if (is_active_sidebar('header-left')) {?>
					<div  class="header-left pull-left">
							<?php dynamic_sidebar('header-left'); ?>
					</div>
				<?php }?>
				<!-- Logo -->
				<div class="top-header col-lg-8 col-md-7 col-sm-6 col-xs-5">
					<div class="revo-logo">
						<?php revo_logo(); ?>
					</div>
				</div>
				<?php if (is_active_sidebar('header-right6')) {?>
					<div  class="header-right pull-right">
							<?php dynamic_sidebar('header-right6'); ?>
					</div>
				<?php }?>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<div class="row">
			<?php if( $sticky_menu ) : ?>
				<div class="revo-logo pull-left">
						<?php revo_logo(); ?>
				</div>
				<?php endif; ?>
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
				<!-- Sidebar Top Menu -->
				<?php if( !$disable_search ) : ?>
				<div class="search-cate pull-right">
					<span class="search-home6"><i class="fa fa-search"></i></span>
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
				<?php endif; ?>
				<?php if( $sticky_menu ) : ?>
					<div class="cart-sticky clearfix">
						<?php get_template_part( 'woocommerce/minicart-ajax-style2' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>