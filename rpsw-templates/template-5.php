<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; ?>
 <div class="rpsw-post-slides">
 	<div class="post-content-position">
	<div class="rpsw-post-image-bg">
			<a href="<?php the_permalink(); ?>">
				<?php if( has_post_thumbnail()  ) { ?>
				<img src="<?php echo $feat_image; ?>" alt="<?php the_title(); ?>" />
				<?php  } ?>
			</a>
	</div>
	
	<div class="rpsw-post-content-outer wp-cell-12 wpcell">	
	<?php if($showCategory) { ?>
	<div class="rpsw-post-cat">		
			<?php echo $all_cat; ?>
		</div>
	<?php } ?>		
		  <h3 class="rpsw-post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
		<?php if($showDate || $showAuthor)    {  ?>	
			<div class="rpsw-post-date">
			    <?php if($showDate) { echo get_the_date(); } ?>	
			    <?php if($showDate !="" && $showAuthor !="" ) { ?> <span><?php  esc_html_e( '&nbsp;/&nbsp;', 'recent-post-slider-widget' ); ?> <?php } ?>
				<?php  if($showAuthor) { ?> <span><?php  esc_html_e( 'By:', 'recent-post-slider-widget' ); ?>  <?php the_author(); ?></span><?php } ?>
				<?php echo ($showAuthor && $showDate) ? '' : '' ?>
				
				</div>
				<?php }   ?>
				
				<?php if($showContent) {  ?>	
				<div class="rpsw-post-content">
					<?php
					$customExcerpt = get_the_excerpt();				
					if (has_excerpt($post->ID))  { ?>
						<div class="rpsw-sub-content"><?php echo $customExcerpt ; ?></div> 
					<?php } else {
						$excerpt = strip_shortcodes(strip_tags(get_the_content())); ?>
					<div class="rpsw-sub-content"><?php echo rpsw_limit_words($excerpt,$words_limit); ?></div>	
					<?php } ?>
					
					<?php if($showreadmore) { ?>
						<a class="rpsw-btn" href="<?php the_permalink(); ?>"><?php _e('Read More', 'recent-post-slider-widget'); ?></a>
					<?php } ?>
					
				</div>
				<?php } ?>
				</div>
	   </div>
		
	</div>