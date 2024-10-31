<?php
/**
 * Plugin Name: Recent Post Slider with Widget
 * Plugin URI: https://wponlinehelp.com/plugins/
 * Text Domain: recent-post-slider-widget
 * Domain Path: /languages/
 * Description: Simple to use with display WordPresss Recent and Tending Post Slider on your website with many Design using a shortcode. 
 * Author: parechpachani007
 * Version: 1.1
 * Author URI: https://wponlinehelp.com/
 *
 * @package WordPress
 * @author parechpachani
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Basic plugin definitions
 * 
 * @package Recent Post Slider with Widget
 * @since 1.0
 */
if( !defined( 'RPSW_VERSION' ) ) {
	define( 'RPSW_VERSION', '1.1' ); // Version of plugin
}
if( !defined( 'RPSW_DIR' ) ) {
	define( 'RPSW_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( !defined( 'RPSW_URL' ) ) {
	define( 'RPSW_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( !defined( 'RPSW_POST_TYPE' ) ) {
	define( 'RPSW_POST_TYPE', 'post' ); // Plugin post type 'post'
}

if( !defined( 'RPSW_CAT' ) ) {
	define( 'RPSW_CAT', 'category' ); // Plugin category
}

add_action('plugins_loaded', 'rpsw_load_textdomain');
function rpsw_load_textdomain() {
	load_plugin_textdomain( 'recent-post-slider-widget', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
/* Function For Manage Post Category Shortcode Columns
 * 
 * @package Recent Post Slider with Widget
 * @since 1.1
 */	
add_filter("manage_category_custom_column", 'post_teams_columns', 10, 3);
add_filter("manage_edit-category_columns", 'post_category_manage_columns'); 
function post_category_manage_columns($theme_columns) {
    $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'post_shortcode' => __( 'Category Shortcode', 'recent-post-slider-widget' ),
            'slug' => __('Slug'),
            'posts' => __('Posts')
			);
    return $new_columns;
}

function post_teams_columns($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'category');
    switch ($column_name) {      

        case 'title':
            echo get_the_title();
        break;
        case 'post_shortcode':
		echo '[rpsw_recent_grid  post_cat="' . $theme_id. '"]<br />';
		echo '[rpsw_recent_slider  post_cat="' . $theme_id. '"]';
        break;

        default:
            break;
    }
    return $out; 
}	 
// Function file
require_once( RPSW_DIR . '/rpsw-includes/rpsw-function.php' );
// Script Fils
require_once( RPSW_DIR . '/rpsw-includes/rpsw-script.php' );
// Shortcodes
require_once( RPSW_DIR . '/rpsw-includes/rpsw-shortcodes/rpsw-slider.php' );
require_once( RPSW_DIR . '/rpsw-includes/rpsw-shortcodes/rpsw-grid.php' );
// Widgets class
require_once( RPSW_DIR . '/rpsw-widget/rpsw-recent-posts-widget.php' );

// How it work file, Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( RPSW_DIR . '/rpsw-includes/rpsw-admin/rpsw-how-it-work.php' );
}
