<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
function get_rpsw_grid( $atts, $content = null ) {

	    extract(shortcode_atts(array(
		"template" 				=> 'template-1',
		"limit" 				=> '10',
		'grid' 			        => '1',
		"post_cat"              => '',	
        'posts'					=> array(),
        "hide_post"             => array(),        
        "show_date" 			=> 'true',
        "show_category_name" 	=> 'true',
        "show_content" 			=> 'true',
        "content_words_limit" 	=> '50',
		"post_type"       		=> 'post',		
		"taxonomy"				=> 'category',
		"show_author" 			=> 'true',
		"show_read_more" 		=> 'true',
		"image_size"			=> 'full',		
	), $atts));		    
	$unique 			= rpsw_get_fix();
	$shortcode_templates 	= rpsw_slider_templates();
	$posts_per_page 	= !empty($limit) 					? $limit 						: '-1';	
	$grid 	            = !empty($grid) 					? $grid 						: '1';	
	$cat 				= (!empty($post_cat)) 				? explode(',', $post_cat) 		: '';	
	$template 			= ($template && (array_key_exists(trim($template), $shortcode_templates))) ? trim($template) : 'template-1';
	$showCategory 		= ( $show_category_name == 'false' ) 		? false 				: true;	
	$showContent 		= ( $show_content == 'false' ) 		? false 						: true;
	$showDate 			= ( $show_date == 'false') 			? false 						: true;	
	$showAuthor 		= ( $show_author == 'false') 		? false 						: true;	
	$showreadmore 		= ( $show_read_more == 'false') 	? false 						: true;	
	$words_limit 		= !empty( $content_words_limit ) 	? $content_words_limit	 		: 20;
	$post_type 			= !empty($post_type)                ? $post_type 					: 'post';
	$taxonomy 			= !empty($taxonomy)					? $taxonomy						: 'category';
	$media_size 		= !empty($image_size) 				? $image_size 					: 'full'; // you can use thumbnail, medium, medium_large,large, full
	$exclude_post		= !empty($hide_post)				? explode(',', $hide_post) 		: array();
	$posts 				= !empty($posts)					? explode(',', $posts) 			: array();	
		
	// Shortcode file
	$template_file_path 	= RPSW_DIR . '/rpsw-templates/grid/template-1.php';
	$template_file 		= (file_exists($template_file_path)) ? $template_file_path : '';
	
	// For global variable
	global $post;	
	ob_start();	
	$countg = 1;	  	
    // Use WP Query Parameters
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
				<div class="rpsw-post-wrp rpsw-clearfix">
					<div class="rpsw-post-wrap rpsw-post-grid <?php echo $template; ?>">

						<?php
					 while ( $query->have_posts() ) : $query->the_post();
						$post_id 		= isset($post->ID) ? $post->ID : '';						
						$all_cat		= rpsw_get_all_category($post->ID, $taxonomy);
						$feat_image 	= rpsw_get_post_img( $post->ID, $media_size, true );
						$first_last_cls = '';
						 

				if( $countg == 1 ){
					$first_last_cls = 'rpsw-first';
				} elseif ( $countg == $grid ) {
					$countg = 0;
					$first_last_cls = 'rpsw-last';
				}

                  if ( is_numeric( $grid ) ) {
					if($grid == 1){
						$grids = 12;
					}else if($grid == 2){
						$grids = 6;
					}
					else if($grid == 3){
						$grids = 4;	
					}
					else if($grid == 4){
						$grids = 3;
					}
					 else{
                        $grids = $grid;
                    }
					$class = 'wp-cell-'.$grids.' wpcell';
				}				
				
							if( $template_file ) {
									include( $template_file );
								}
								$countg++;
							endwhile; ?>
					</div>
					
				</div>
		  <?php
            endif; 
             wp_reset_query();
		return ob_get_clean();
}
add_shortcode('rpsw_recent_grid', 'get_rpsw_grid');