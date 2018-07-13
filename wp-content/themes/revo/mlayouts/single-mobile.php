<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
	<div class="body-wrapper theme-clearfix">
		<div class="body-wrapper-inner">
			<?php get_template_part( 'mlayouts/breadcrumb', 'mobile' ); ?>
			<div class="container">
					<div class="single main" >
						<?php get_template_part('mlayouts/content', 'single');	?>
					</div>
			</div>
<?php get_template_part('footer'); ?>
