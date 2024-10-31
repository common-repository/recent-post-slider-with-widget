<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; ?>
 
 <div class="post-slides">
	<div class="post-overlay">
		<div class="wp-cell-6 wpcell">
	<div class="post-image-bg">
	<a href="<?php the_permalink(); ?>">	
		<?php if( has_post_thumbnail()  ) { ?>
		<img src="<?php echo $feat_image; ?>" alt="<?php the_title(); ?>" />
		<?php  } ?>
	</a>
	</div>
	</div>
	<div class="wp-cell-6 wpcell">
	<?php if($showCategory) { ?>
						<div class="recentpost-categories">		
								<?php echo $all_cat; ?>
							</div>
						<?php } ?>
	<div class="post-short-content">
	<div class="item-meta bottom">
			  <h2 class="wp-post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
	<?php if($showDate || $showAuthor)    {  ?>	
			<div class="wp-post-date">		
				<?php if($showDate) { echo get_the_date(); } ?>	
			    <?php if($showDate !="" && $showAuthor !="" ) { ?> <span><?php  esc_html_e( '&nbsp;/&nbsp;', 'recent-post-slider-widget' ); ?> <?php } ?>
				<?php  if($showAuthor) { ?> <span><?php  esc_html_e( 'By:', 'recent-post-slider-widget' ); ?>  <?php the_author(); ?></span><?php } ?>
				</div>
				<?php }   ?>
		
				<?php if($showContent) {  ?>	
				<div class="wp-post-content">
					<?php
					$customExcerpt = get_the_excerpt();				
					if (has_excerpt($post->ID))  { ?>
						<div class="wp-sub-content"><?php echo $customExcerpt ; ?></div> 
					<?php } else {
						$excerpt = strip_shortcodes(strip_tags(get_the_content())); ?>
					<div class="wp-sub-content"><?php echo rpsw_limit_words($excerpt,$words_limit); ?></div>					
					<?php } ?>

					<?php if($showreadmore) { ?>
						<a class="readmorebtn" href="<?php the_permalink(); ?>"><?php _e('Read More', 'recent-post-slider-widget'); ?></a>
					<?php } ?>

				</div>
				<?php } ?>
				</div>
		</div>
	</div>
		</div>
	</div>