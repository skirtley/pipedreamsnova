<?php 
	$show_tab 			= ( isset( $show_tab ) ) 		? $show_tab : true;
	$show_loadmore 	= ( isset( $show_loadmore ) ) 	? $show_loadmore : true;
	$title	 				= ( isset( $title ) ) 			? $title : '';
	$description 		= ( isset( $description ) ) 	? $description : '';
	if( count($portfolio) == 0 ){
		return ;
	}
	$attributes     = '';
	if( $style == 'masonry' ){
		$attributes .= 'portfolio-item p-column-'.$col1;
	}else{
		$attributes .= 'grid-item p-lg-'.$col1 .' p-md-'.$col2 .' p-sm-'.$col3 .' p-xs-'.$col4; 
	}	
	$args = array(
		'post_type' => 'portfolio',
		'tax_query' => array(
			array(
				'taxonomy'	=> 'portfolio_cat',
				'field' 	=> 'slug',
				'terms'		=> $portfolio
			)
		),
		'orderby'	=> $orderby,
		'showposts' => $number
	);
	$query = new WP_Query( $args );
	$max_page = $query -> max_num_pages;
	if( $query->have_posts() ) :
?>
<div id="<?php echo esc_attr( $pf_id ); ?>" class="revo-portfolio <?php echo esc_attr( $style ) ?>" data-categories="<?php echo implode( ',', $portfolio ); ?>" data-max_page="<?php echo esc_attr( $max_page ); ?>" data-number="<?php echo esc_attr( $number ) ?>" data-orderby="<?php echo esc_attr( $orderby ) ?>" data-order="<?php echo esc_attr( $order ) ?>" data-style="<?php echo esc_attr( $style ) ?>" data-attributes="<?php echo esc_attr( $attributes ) ?>">
	<!-- Tab  -->
	<?php if( $show_tab == 'yes' ){ ?>
	<div class="portfolio-tab">
		<ul id="tab_<?php echo esc_attr( $pf_id ); ?>">
			<li class="selected" data-portfolio-filter="*"><?php _e( 'All', 'sw_core' ); ?></li>
		<?php
			foreach( $portfolio as $cat_id ){
				$cat = get_term_by( 'slug', $cat_id, 'portfolio_cat' );
				echo '<li data-portfolio-filter=".'. $cat -> slug.'">' .esc_html( $cat -> name ). '</li>';
			}
		?>
		</ul>
	</div>
	<?php } ?>
	<!-- Container -->
	<div class="portfolio-container <?php echo ( $style != 'masonry' ) ? 'row' : '';?>" >
		<ul id="container_<?php echo esc_attr( $pf_id ); ?>" class="portfolio-content clearfix <?php echo ( $style != 'masonry' ) ? 'row' : '';?>" >
		<?php
			while( $query -> have_posts() ) : $query -> the_post();
			global $post;
			$img_size  	= get_post_meta( $post->ID, 'img_size', true );
			$pterms	   	= get_the_terms( $post->ID, 'portfolio_cat' );
			$width		= 0;
			$height 	= 0;
			if( $img_size == 'default' ){
				$width 	= 400;
				$height = 270;
			}else if( $img_size == 'p-double-width' ){
				$width 	= 682;
				$height = 230;
			}else if( $img_size == 'p-double-wh' ){
				$width 	= 800;
				$height = 540;
			}
			$term_str  = '';
			if( count($pterms) > 0 ){
				foreach( $pterms as $key => $term ){
					$term_str .= $term -> slug . ' ';
				}
			}	
			$img = '';
			if( $style == 'masonry' ){
			?>
				<li class="grid-item <?php echo $attributes.' '.esc_attr( $term_str ). ' '. esc_attr( $img_size ); ?>">
					<div class="portfolio-item-inner">
						<div class="portfolio-in">
							<?php 
								if( has_post_thumbnail() ){
									$img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
								}
							?>
							<a class="portfolio-img" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'large' ); ?>
							</a>
							<div class="p-item-content">
								<a class="p-item-title" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<a href="<?php the_permalink(); ?>" class="p-item item-more" title="<?php the_title_attribute(); ?>"><span class="fa fa-link"></span></a>
								<a href="<?php echo esc_attr( $img ); ?>" class="p-item item-popup" title="<?php the_title_attribute(); ?>"><span class="fa fa-search"></span></a>
							</div>
						</div>
					</div>
				</li>
			<?php }else{ ?>					
				<li class="grid-item <?php echo $attributes.' '.esc_attr( $term_str ); ?>">
					<div class="portfolio-item-inner">
						<div class="portfolio-in">
							<?php 
								if( has_post_thumbnail() ){
									$img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
								}
							?>
							<a class="portfolio-img" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'large' ); ?>
							</a>
							<div class="p-item-content">
								<a class="p-item-title" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<a href="<?php the_permalink(); ?>" class="p-item item-more" title="<?php the_title_attribute(); ?>"><span class="fa fa-link"></span></a>
								<a href="<?php echo esc_attr( $img ); ?>" class="p-item item-popup" title="<?php the_title_attribute(); ?>"><span class="fa fa-search"></span></a>
							</div>
						</div>
					</div>
				</li>
		<?php 
			}
			endwhile;
			wp_reset_postdata();
		?>
		</ul>
	</div>
	<!-- btn loadmore  -->
	<?php if( $show_tab == 'yes' ){ ?>
	<div class="btn-loadmore">
		<span class="respl-image-loading"></span>
		<span class="des-load" data-label="<?php esc_html_e( "Show More Portfolio", 'sw_core' ) ?>" data-label-loaded="<?php esc_html_e( "All Items Loaded", 'sw_core' ) ?>"></span>
	</div>
	<?php } ?>
</div>
<?php endif; ?>