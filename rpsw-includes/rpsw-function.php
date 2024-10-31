<?php
/**
 * Plugin All functions file
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Function to get constant number
 * 
 * @package WP Responsive Recent Post Slider
 * @since 1.2.2
 */
function rpsw_get_fix() {
  static $fix = 0;
  $fix++;
  return $fix;
}
/**
 * Function to get post featured image
 * 
 * @package WP Responsive Recent Post Slider
 * @since 1.2.5
 */
function rpsw_get_post_img( $post_id = '', $size = 'full') {
    $size   = !empty($size) ? $size : 'full';
    $image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

    if( !empty($image) ) {
        $image = isset($image[0]) ? $image[0] : '';
    }
    return $image;
}
/**
 * Function to get Taxonomies list 
 * 
 * @package WP Responsive Recent Post Slider Pro
 * @since 1.3.3
 */
function rpsw_get_all_category( $post_id = 0, $taxonomy = '' ) {
    $output = '';
    $terms  = get_the_terms( $post_id, $taxonomy );

    if( $terms && !is_wp_error($terms) && !empty($taxonomy) ) {
        $output .= '<ul class=" rpsw-post-categories">';
        foreach ( $terms as $term ) {
             $output .= '<li><a href="'.get_term_link($term).'" rel="'.$taxonomy.'"> '.$term->name.' </a></li>';
        }
        $output .= '</ul>';
    }
    return $output;
}
/**
 * Function to get shortcode designs
 * 
 * @package WP Responsive Recent Post Slider
 * @since 1.2.5
 */
function rpsw_slider_templates() {
    $design_arr = array(
        'template-1'  	=> __('template-1', 'recent-post-slider-widget'),
        'template-2'  	=> __('template-2', 'recent-post-slider-widget'),
        'template-3'  	=> __('template-3', 'recent-post-slider-widget'),
        'template-4' 	=> __('template-4', 'recent-post-slider-widget'),
        'template-5'    => __('template-5', 'recent-post-slider-widget'),
                     
	);
	return apply_filters('rpsw_slider_designs', $design_arr );
}
/* Function to get shortcode Cell
 * 
 * @package video player gallery
 * @since 1.0
 */
function rpsw_cell_arr() {
    $cell_arr = array(
        '1'    => __('1', 'recent-post-slider-widget'),
        '2'    => __('2', 'recent-post-slider-widget'),
        '3'    => __('3', 'recent-post-slider-widget'),
        '4'    => __('4', 'recent-post-slider-widget'),
        );  
    return apply_filters('sg_true_false', $cell_arr );
}
/* Function to get shortcode true false 
 * 
 * @package video player gallery
 * @since 1.0
 */
function rpsw_true_false() {
    $truefalse_arr = array(
        'true'    => __('True', 'recent-post-slider-widget'),
        'false'    => __('False', 'recent-post-slider-widget'),
       
        );  
    return apply_filters('sg_true_false', $truefalse_arr );
}
/**
 * Function to add array after specific key
 * 
 * @package recent-post-slider-widget
 * @since 1.2.5
 */
function rpsw_add_array(&$array, $value, $index, $from_last = false) {
    
    if( is_array($array) && is_array($value) ) {

        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }        
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }    
    return $array;
}
// Manage Category Shortcode Columns
add_filter("manage_category_custom_column", 'rpsw_category_columns' , 10, 3);
add_filter("manage_edit-category_columns", 'rpsw_category_manage_columns'); 
function rpsw_category_manage_columns($columns) {
   $new_columns['rpsw_shortcode'] = __( 'Category ID', 'recent-post-slider-widget' );
		$columns = rpsw_add_array( $columns, $new_columns, 2 );
		return $columns;
}
function rpsw_category_columns($ouput, $column_name, $tax_id) {
	if( $column_name == 'rpsw_shortcode' ) {
			$ouput .= $tax_id;			
	    }		
	    return $ouput;
}
// Manage conetnt limit
function rpsw_limit_words($string, $word_limit)
{
    if( !empty($string) ) {
        $content = strip_shortcodes( $string ); // Strip shortcodes
        $content = wp_trim_words( $string, $word_limit, '...' );
		return $content;
    }   
}
/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 *  @package Recent Posts Widget Designer
 * @since 1.0
 */
function rpsw_esc_attr($data) {
    return esc_attr( $data );
}
/**
 * Clean variables using sanitize text field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package Easy Accordion For Faq
 * @since 1.0
 */
function rpsw_sanitize_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'rpsw_sanitize_clean', $var );
    } else {
        $data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
        return wp_unslash($data);
    }
}