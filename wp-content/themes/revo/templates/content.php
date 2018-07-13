<?php get_template_part('header'); ?>
<?php 
	$revo_sidebar_template = sw_options('sidebar_blog') ;
	$revo_blog_styles = ( sw_options('blog_layout') ) ? sw_options('blog_layout') : 'list';
?>

<div class="revo_breadcrumbs">
	<div class="container">
		<?php
			if (!is_front_page() ) {
				if (function_exists('revo_breadcrumb')){
					revo_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
				} 
			} 
		?>
	</div>
</div>

<div class="container">
	<div class="row sidebar-row">
		<!-- Left Sidebar -->
		<?php if ( is_active_sidebar('left-blog') && $revo_sidebar_template == 'left' ):
			$revo_left_span_class = 'col-lg-'.sw_options('sidebar_left_expand');
			$revo_left_span_class .= ' col-md-'.sw_options('sidebar_left_expand_md');
			$revo_left_span_class .= ' col-sm-'.sw_options('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($revo_left_span_class); ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>

		<?php endif; ?>
		
		<div class="category-contents <?php revo_content_blog(); ?>">
			<div class="listing-title">			
				<h1><span><?php revo_title(); ?></span></h1>				
			</div>
			<!-- No Result -->
			<?php if (!have_posts()) : ?>
			<?php get_template_part('templates/no-results'); ?>
			<?php endif; ?>			
			
			<?php 
				$revo_blogclass = 'blog-content blog-content-'. $revo_blog_styles;
				if( $revo_blog_styles == 'grid' ){
					$revo_blogclass .= ' row';
				}
			?>
			<div class="<?php echo esc_attr( $revo_blogclass ); ?>">
			<?php 			
				while( have_posts() ) : the_post();
					get_template_part( 'templates/content', $revo_blog_styles );
				endwhile;
			?>
			<?php get_template_part('templates/pagination'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<!-- Right Sidebar -->
		<?php if ( is_active_sidebar('right-blog') && $revo_sidebar_template =='right' ):
			$revo_right_span_class = 'col-lg-'.sw_options('sidebar_right_expand');
			$revo_right_span_class .= ' col-md-'.sw_options('sidebar_right_expand_md');
			$revo_right_span_class .= ' col-sm-'.sw_options('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($revo_right_span_class); ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>
</div>
<?php get_template_part('footer'); ?>
