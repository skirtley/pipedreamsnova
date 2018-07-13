<?php get_template_part('header'); ?>

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
		<?php if ( is_active_sidebar('left-blog') && revo_sidebar_template() == 'left' ):
			$revo_left_span_class = 'col-lg-'.sw_options('sidebar_left_expand');
			$revo_left_span_class .= ' col-md-'.sw_options('sidebar_left_expand_md');
			$revo_left_span_class .= ' col-sm-'.sw_options('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($revo_left_span_class); ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>
	
		<div class="single main <?php revo_content_blog(); ?>" >
			<?php while (have_posts()) : the_post(); ?>
			<?php $related_post_column = sw_options('sidebar_blog'); ?>
			<div <?php post_class(); ?>>
				<?php $pfm = get_post_format();?>
				<div class="entry-wrap">
					<?php if( $pfm == '' || $pfm == 'image' ){?>
						<?php if( has_post_thumbnail() ){ ?>
							<div class="entry-thumb single-thumb">
								<?php the_post_thumbnail('revo_detail_thumb'); ?>
							</div>
							<?php revo_get_time() ?>
						<?php }?>
					<?php } ?>
					<h1 class="entry-title clearfix"><?php the_title(); ?></h1>
					<div class="entry-content clearfix">
						<div class="entry-meta clearfix">
							<span class="entry-author">
								<i class="fa fa-user"></i><?php esc_html_e('Post By:', 'revo'); ?> <?php the_author_posts_link(); ?>
							</span>
							<div class="entry-comment">
								<a href="<?php comments_link(); ?>">
									<i class="fa fa-comments-o"></i>
									<?php echo $post->comment_count . ( ( $post->comment_count > 1 ) ? esc_html__(' Comments ', 'revo') : esc_html__(' Comment ', 'revo') ); ?>
								</a>
							</div>
							<?php if( ! has_post_thumbnail() ){ ?>
								<span class="entry-date">
									<i class="fa fa-clock-o"></i><?php echo ( get_the_title() ) ? date( 'M j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
								</span>
							<?php } ?>
							<?php if(get_the_tag_list()) { ?>
								<div class="entry-tag single-tag pull-left">
									<?php echo get_the_tag_list('<i class="fa fa-tags"></i><span class="custom-font title-tag"></span>',' , ','');  ?>
								</div>
							<?php } ?>
						</div>
						<div class="entry-summary single-content ">
							<?php the_content(); ?>
							
							<div class="clear"></div>
							<!-- link page -->
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'revo' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>	
						</div>
						
						<div class="clear"></div>			
						<div class="single-content-bottom clearfix">
							<!-- Tag -->
							
							<!-- Social -->
							<?php revo_get_social() ?>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div> 
				<?php if( get_the_author_meta( 'description',  $post->post_author ) != '' ): ?>
				<div id="authorDetails" class="clearfix">
					<div class="authorDetail">
						<div class="avatar">
							<?php echo get_avatar( $post->post_author , 100 ); ?>
						</div>
						<div class="infomation">
							<h4 class="name-author"><span><?php echo get_the_author_meta( 'user_nicename', $post->post_author )?></span></h4>
							<p><?php the_author_meta( 'description',  $post->post_author ) ;?></p>
						</div>
					</div>
				</div> 
				<?php endif; ?>
				<div class="clearfix"></div>
				<!-- Relate Post -->
				<?php 
					global $post;
					global $related_term;
					$class_col= "";
					$categories = get_the_category($post->ID);								
					$category_ids = array();
					foreach($categories as $individual_category) {$category_ids[] = $individual_category->term_id;}
					if ($categories) {
						if($related_post_column =='full'){
							$class_col .= 'col-lg-3 col-md-3 col-sm-3';
							$related = array(
								'category__in' => $category_ids,
								'post__not_in' => array($post->ID),
								'showposts'=>4,
								'orderby'	=> 'name',	
								'ignore_sticky_posts'=>1
								 );
						} else {
							$class_col .= 'col-lg-4 col-md-4 col-sm-4';
							$related = array(
								'category__in' => $category_ids,
								'post__not_in' => array($post->ID),
								'showposts'=>3,
								'orderby'	=> 'name',	
								'ignore_sticky_posts'=>1
								 );
						} 
				?>
						<div class="single-post-relate">
							<h4><?php esc_html_e('Related News', 'revo'); ?></h4>
							<div class="row">
							<?php
								$related_term = new WP_Query($related);
								while($related_term -> have_posts()):$related_term -> the_post();
									$format = get_post_format();
							?>
								<div <?php post_class( $class_col ); ?> >
									<?php if ( get_the_post_thumbnail() ) { ?>
									<div class="item-relate-img">
										<div class="entry-meta">
											<?php revo_get_time(); ?>
										</div>
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('revo_related_post'); ?></a>
									</div>
									<?php } ?>

									<div class="item-relate-content">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<div class="entry-meta">
											<div class="entry-comment">
												<i class="fa fa-comments-o"></i>
												<?php 
													$qty_comment = $post->comment_count;
													if($qty_comment > 1 ){
														echo $qty_comment. ' '. esc_html__(' Comments ', 'revo');
													} else {
														echo $qty_comment. ' '. esc_html__(' Comment ', 'revo');
													}
												?>
											</div>
											<?php if(get_the_tag_list()) { ?>
												<div class="entry-tag single-tag pull-left">
													<?php echo get_the_tag_list('<i class="fa fa-tag"></i><span class="custom-font title-tag"></span>',' , ','');  ?>
												</div>
											<?php } ?>
										</div>
										<a class="read-more" href="<?php the_permalink(); ?>"><i class="fa fa-caret-right"></i><?php echo esc_html__('Read More','revo');?></a>
									</div>
								</div>
								<?php
									endwhile;
									wp_reset_postdata();
								?>
							</div>
						</div>
						<?php } ?>
					
					<div class="clearfix"></div>
					<!-- Comment Form -->
					<?php comments_template('/templates/comments.php'); ?>
			</div>
			<?php endwhile; ?>
		</div>
		
		<!-- Right Sidebar -->
		<?php if ( is_active_sidebar('right-blog') && revo_sidebar_template() == 'right' ):
			$revo_right_span_class = 'col-lg-'.sw_options('sidebar_right_expand');
			$revo_right_span_class .= ' col-md-'.sw_options('sidebar_right_expand_md');
			$revo_right_span_class .= ' col-sm-'.sw_options('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr( $revo_right_span_class ); ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>	
</div>
<?php get_template_part('footer'); ?>
