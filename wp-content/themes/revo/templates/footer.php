<?php 	
	$revo_page_footer   	 = ( get_post_meta( get_the_ID(), 'page_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_footer_style', true ) : sw_options( 'footer_style' );
	$revo_copyright_text 	 = sw_options( 'footer_copyright' );
?>

<footer id="footer" class="footer default theme-clearfix">
	<!-- Content footer -->
	<div class="container">
		<?php 
			if( $revo_page_footer != '' ) :
				echo sw_get_the_content_by_id( $revo_page_footer ); 
			endif;
		?>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<!-- Copyright text -->
			<div class="copyright-text">
				<?php if( $revo_copyright_text == '' ) : ?>
					<p>&copy;<?php echo date('Y') .' '. esc_html__('WordPress Theme SW Revo. All Rights Reserved. Designed by ','revo'); ?><a class="mysite" href="<?php echo esc_url( 'http://wpthemego.com/' ); ?>"><?php esc_html_e('WPThemeGo.Com','revo');?></a>.</p>
				<?php else : ?>
					<?php echo wp_kses( $revo_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
			</div>
			<?php if (is_active_sidebar('footer-copyright')){ ?>
			<div class="sidebar-copyright">
				<?php dynamic_sidebar('footer-copyright'); ?>
			</div>
		<?php } ?>
		</div>
	</div>
</footer>