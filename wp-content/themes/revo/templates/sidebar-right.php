<?php if ( is_active_sidebar('right') ):
	$revo_right_span_class = 'col-lg-'.sw_options('sidebar_right_expand');
	$revo_right_span_class .= ' col-md-'.sw_options('sidebar_right_expand_md');
	$revo_right_span_class .= ' col-sm-'.sw_options('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($revo_right_span_class); ?>">
	<?php dynamic_sidebar('right'); ?>
</aside>
<?php endif; ?>