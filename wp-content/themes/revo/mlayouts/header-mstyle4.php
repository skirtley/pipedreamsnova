<?php 
	/* 
	** Content Header
	*/
	$revo_mobile_logo = sw_options( 'mobile_logo' );
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) || is_search()):?>
<header id="header" class="header header-mobile-style4">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile clearfix">
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
			</div>
			<div class="revo-logo pull-left">
				<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if( $revo_mobile_logo != '' ){ ?>
						<img src="<?php echo esc_url( $revo_mobile_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
					<?php }else{
						$logo = get_template_directory_uri().'/assets/img/logo-mobile2.png'; ?>
						<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
					<?php } ?>					
				</a>				
			</div>
			<div class="mobile-search pull-left">
				<div class="non-margin">
					<div class="widget-inner">
						<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
					</div>
				</div>
			</div>			
		</div>
	</div>
</header>
<?php else : ?>
<!--  header page -->
<?php get_template_part( 'mlayouts/breadcrumb', 'mobile' ); ?>
	<!-- End header -->
<?php endif; ?>