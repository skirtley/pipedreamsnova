<?php
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_twitter_'.rand().time();
$sw_slider_tweets = Get_Connection( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $twitter_cache, $twitter_username, $twitter_number, $exclude_replies );
if(!empty($sw_slider_tweets)){
	?>
	<!-- Wrapper for slides -->
	<div id="<?php echo $widget_id;?>" class="sw-twitter-slider carousel slide" data-ride="carousel" data-interval="0">		
		<div class="box-slider-title">
			<?php echo '<h2>'. esc_html( $title1 ) .'</h2>'; ?>
			<i class="fa fa-twitter" aria-hidden="true"></i>
		</div>
		<div class="carousel-inner">
			<?php
			$count_item = ( count($sw_slider_tweets) >= $twitter_number ) ? $twitter_number : count($sw_slider_tweets);
			$i = 0;
			foreach($sw_slider_tweets as $tweet){
				if( $i % $twitter_row == 0 ){
					?>
					<div class="item<?php if( $i == 0 ){echo ' active';}?>">
						<?php
					}
					?>
					<div class="item-twiter">
						<div class="item-twitter-right">
							<div class="item-top clearfix">
								<a href="<?php echo 'https://twitter.com/'.esc_attr( $twitter_username ) ?>" title="<?php echo esc_attr( $twitter_username )?>"><?php echo $twitter_username ?></a>
								<div class="meta-time"><?php echo sw_relative_time( $tweet['created_at'] ); ?></div>
							</div>
							<?php 
							if(!empty($tweet['text'])){
								if(empty($tweet['status_id'])){ $tweet['status_id'] = ''; }								
								print '<div class="tweet-text">'.sw_convert_links($tweet['text']).'</div>';
								print '<div class="tweet-btn">
									<a class="reply-tweet" target="_blank" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet['status_id'].'"><i class="fa fa-share"></i>'. __('Reply', 'sw_core').' </a>
									<a class="retweet" href="https://twitter.com/intent/retweet?tweet_id='.$tweet['status_id'].'"><i class="fa fa-retweet"></i>'. __('Retweet', 'sw_core').'</a>
									<a class="favorite-tweet" href="https://twitter.com/intent/favorite?tweet_id='.$tweet['status_id'].'"><i class="fa fa-star"></i>'. __('Favorite', 'sw_core').' </a>
								</div>';
								print '</div></div>';

							}

							if( ( $i+1 ) % $twitter_row == 0 || ( $i+1 ) == $count_item ){ ?> </div><?php } 
								$i++;
						}
						?>	
					</div>
				<!-- Indicators -->
				  <ol class="carousel-indicators">
					<?php
						$i = 0;
						foreach($sw_slider_tweets as $tweet){
					?>
						<li data-target="#<?php echo $widget_id; ?>" data-slide-to="<?php echo esc_attr( $i ); ?>" class="<?php echo ( $i==0 )? 'active':''; ?>"></li>
					<?php $i++; } ?>
				  </ol>
				</div>
				<!-- end Wrapper for slides -->
				<?php
			}
			?>

