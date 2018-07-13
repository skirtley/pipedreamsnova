<?php get_template_part('header'); ?>
<div class="wrapper_404">
	<div class="container">
		<div class="row">
		<?php $revo_404page = sw_options( 'page_404' ); ?>
		<?php if( $revo_404page != '' ) : ?>
				<?php echo sw_get_the_content_by_id( $revo_404page ); ?>
		<?php else: ?>	
			<div class="content_404">
				<div class="item-left col-lg-5 col-md-5">
					<div class="erro-image">
						<span class="erro-key">
							<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-404.png">
						</span>
					</div>
				</div>
				<div class="item-right col-lg-7 col-md-7">
					<div class="block-top">
						<h2><span><?php esc_html_e( 'Oops, This Page Could Not Be Found', 'revo' ) ?></span></h2>
						<div class="warning-code"><p><?php esc_html_e( 'The page you are looking for does not appear to exit. Please Check the URL', 'revo' ) ?><br><?php esc_html_e( 'or try the search box below.', 'revo' ) ?></p></div>
					</div>
					<div class="block-middle">
						<div class="revo_search_404">
							<?php get_template_part( 'widgets/sw_top/search' ); ?>
						</div>
					</div>
					<div class="block-bottom">
						<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="<?php esc_attr_e( 'Go Home', 'revo' ) ?>"><?php esc_html_e( "Go Home", 'revo' )?></a>
						<a href="#" class=" btn-404 support" title="<?php esc_attr_e( 'Go Support', 'revo' ) ?>"><?php esc_html_e( "Go Support", 'revo' )?></a>					
					</div>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>

<?php get_template_part('footer'); ?>