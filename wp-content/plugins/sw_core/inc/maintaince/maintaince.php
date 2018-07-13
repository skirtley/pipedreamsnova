<?php get_template_part('templates/head'); ?>
<?php  $maintaince_attr = ( sw_options( 'maintaince_background' ) != '' ) ? 'style="background: url( '. esc_url( sw_options( 'maintaince_background' ) ) .' )"' : ''; ?>
<body class="sw-maintaince">
	<div class="body-wrapper" <?php echo $maintaince_attr; ?>>
		<div class="header-maintaince">
			<div class="header-logo">
				<div class="container">
					<div class="row">
						<h1>
							<?php $main_logo = sw_options( 'sitelogo' ); ?>
							<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php if( $main_logo != '' ){ ?>
									<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
								<?php }else{
									$logo = get_template_directory_uri().'/assets/img/logo.png';
								?>
									<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
								<?php } ?>
							</a>
						</h1>
					</div>
				</div>
			</div>
		</div>
	
		<div id="main-content" class="main-content">
			<div class="container">
				<div class="page-top">
					<?php echo stripslashes( sw_options( 'maintaince_content' ) ); ?>
				</div>
				<div class="page-bottom">
				
					<div id="countdown-container" class="countdown-container"></div>
					<?php if( sw_options( 'maintaince_form' ) != '' ): ?> 
					<div class="form-subscribers">
						<div class="form-wrap">
							<?php echo do_shortcode( sw_options( 'maintaince_form' ) ); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<!-- Social Link -->
					<?php sw_social_link() ?>
				
				</div>
			</div>
		</div>	
		<?php $sw_copyright_text = sw_options( 'footer_copyright' );  ?>
		<div class="copyright">
			<address>
				<?php if( $sw_copyright_text == '' ) : ?>
					&copy;<?php echo sprintf(__(  '%d SW %s. All Rights Reserved. Powered by <a class="mysite" href="%s">WPThemeGo</a>', 'sw_core' ), date('Y'), wp_get_theme()->Name, esc_url( 'http://www.wpthemego.com/' ) ); ?>
				<?php else: ?>
					<?php echo wp_kses( $sw_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
			</address>
		</div>
	</div>
<?php wp_footer(); ?>	
</body>
</html>