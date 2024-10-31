<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; ?>
 <div class="<?php echo $first_last_cls.' '.$class;?>">
 	<div class="rpsw-image-outter">
	<div class="rpsw-post-image-bg">
			<a href="<?php the_permalink(); ?>">
				<?php if( has_post_thumbnail()  ) { ?>
				<img src="<?php echo $feat_image; ?>" alt="<?php the_title(); ?>" />
				<?php  } ?>
			</a>
	</div>
	
	<div class="rpsw-post-content ">	
	<?php if($showCategory) { ?>
	<div class="rpsw-post-cat">		
			<?php echo $all_cat; ?>
		</div>
	<?php } ?>		
		  <h3 class="rpsw-post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
		<?php if($showDate || $showAuthor)    {  ?>	
			<div class="rpsw-post-date"> <i class="fa fa-calculator" aria-hidden="true"></i>
			    <?php if($showDate) { echo get_the_date(); } ?>				    
				<?php  if($showAuthor) { ?> <span><i class="fa fa-user" aria-hidden="true"></i>  <?php the_author(); ?></span><?php } ?>
				<?php echo ($showAuthor && $showDate) ? '' : '' ?>
				</div>
				<?php }   ?>
				
				<?php if($showContent) {  ?>	
				<div class="rpsw-content">
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