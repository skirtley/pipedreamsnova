<?php if ( is_active_sidebar('left') ):
	$revo_left_span_class = 'col-lg-'.sw_options('sidebar_left_expand');
	$revo_left_span_class .= ' col-md-'.sw_options('sidebar_left_expand_md');
	$revo_left_span_class .= ' col-sm-'.sw_options('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($revo_left_span_class); ?>">
	<?php dynamic_sidebar('left'); ?>
</aside>
<?php endif; ?>