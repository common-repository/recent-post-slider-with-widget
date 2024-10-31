<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
function get_rpsw_slider( $atts, $content = null ) {
	    extract(shortcode_atts(array(
		"template" 				=> 'template-1',
		"limit" 				=> '10',
		"post_cat"              => '',	
        'posts'					=> array(),
        "hide_post"             => array(),        
        "show_date" 			=> 'true',
        "show_category_name" 	=> 'true',
        "show_content" 			=> 'true',
        "content_words_limit" 	=> '50',
		"bullet"    			=> 'true',
		"arrows"     			=> 'true',				
		"autoplay"     			=> 'false',		
		"autoplay_interval" 	=> '3000',				
		"speed"             	=> '500',
		"post_type"       		=> 'post',		
		"taxonomy"				=> 'category',
		"show_author" 			=> 'true',
		"show_read_more" 		=> 'true',
		"image_size"			=> 'full',		
	), $atts));		    
	$unique 			= rpsw_get_fix();
	$shortcode_templates 	= rpsw_slider_templates();
	$posts_per_page 	= !empty($limit) 					? $limit 						: '-1';	
	$cat 				= (!empty($post_cat)) 				? explode(',', $post_cat) 		: '';	
	$template 			= ($template && (array_key_exists(trim($template), $shortcode_templates))) ? trim($template) : 'template-1';
	$showCategory 		= ( $show_category_name == 'false' ) 		? false 				: true;	
	$showContent 		= ( $show_content == 'false' ) 		? false 						: true;
	$showDate 			= ( $show_date == 'false') 			? false 						: true;	
	$showAuthor 		= ( $show_author == 'false') 		? false 						: true;	
	$showreadmore 		= ( $show_read_more == 'false') 	? false 						: true;	
	$words_limit 		= !empty( $content_words_limit ) 	? $content_words_limit	 		: 20;
	$dots 				= ( $bullet == 'false' ) 			? 'false' 						: 'true';
	$arrows 			= ( $arrows == 'false' ) 			? 'false' 						: 'true';
	$autoplay 			= ( $autoplay == 'false' ) 			? 'false' 						: 'true';
	$autoplay_interval 	= (!empty($autoplay_interval)) 		? $autoplay_interval 			: 3000;
	$slides_column 	= (!empty($post_cell)) 		                ? $post_cell        			: 1;
	$speed 				= (!empty($speed)) 					? $speed 						: 500;
	$post_type 			= !empty($post_type)                ? $post_type 					: 'post';
	$taxonomy 			= !empty($taxonomy)					? $taxonomy						: 'category';
	$media_size 		= !empty($image_size) 				? $image_size 					: 'full'; // you can use thumbnail, medium, medium_large,large, full
	$exclude_post		= !empty($hide_post)				? explode(',', $hide_post) 		: array();
	$posts 				= !empty($posts)					? explode(',', $posts) 			: array();	
		
	// Shortcode file
	$template_file_path 	= RPSW_DIR . '/rpsw-templates/' . $template . '.php';
	$template_file 		= (file_exists($template_file_path)) ? $template_file_path : '';
	// Enqueus required script
	wp_enqueue_script( 'wpoh-slick-js' );
	wp_enqueue_script( 'rpsw-public-script' );	
	// Slider configuration
	$slider_conf = compact('dots', 'arrows', 'autoplay', 'autoplay_interval','speed', 'slides_column', 'rtl');
	// Taking some global
	global $post;	
	ob_start();		
    // WP Query Parameters
	$args = array (
		'post_type'      		=> $post_type,
		'post_status' 			=> array( 'publish' ),
		'orderby'        		=> 'date',
		'order'          		=> 'DESC',
		'posts_per_page' 		=> $posts_per_page,
		'post__not_in'	 		=> $exclude_post,
		'post__in'				=> $posts,				
	);
 	// Category Parameter
	if($cat != "") {
		$args['tax_query'] = array(
									array(
											'taxonomy' 		=> $taxonomy,
											'field' 		=> 'term_id',
											'terms' 		=> $cat,
								));
	}
	$query = new WP_Query($args);
	$post_count = $query->post_count;         
             if ( $query->have_posts() ) :
			 ?>
				<div class="rpsw-slick-slider-wrp rpsw-clearfix">
					<div id="recent-post-slider-<?php echo $unique; ?>" class="rpsw-post-wrap rpsw-post-slider <?php echo $template; ?>">
						<?php
					 while ( $query->have_posts() ) : $query->the_post();
						$post_id 		= isset($post->ID) ? $post->ID : '';						
						$all_cat		= rpsw_get_all_category($post->ID, $taxonomy);
						$feat_image 	= rpsw_get_post_img( $post->ID, $media_size, true );	
							if( $template_file ) {
									include( $template_file );
								}
							endwhile; ?>
					</div>
					<div class="rpsw-slider-conf rpsw-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
				</div>
		  <?php
            endif; 
             wp_reset_query();
		return ob_get_clean();
}
add_shortcode('rpsw_recent_slider', 'get_rpsw_slider');