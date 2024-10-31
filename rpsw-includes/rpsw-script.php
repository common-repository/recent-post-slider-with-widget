<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Rpsw_Script {
	
	function __construct() {
		
		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'rpsw_front_style') );
		
		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'rpsw_front_script') );	

		add_action( 'admin_enqueue_scripts', array($this, 'wp_rpsw_admin_script'));

		
	}

	/**
	 * Function to add style at front side
	 * 
	 * @package WP Responsive Recent Post Slider
	 * @since 1.0.0
	 */
	function rpsw_front_style() { 
		
		// Registring and enqueing slick slider css
		if( !wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', RPSW_URL.'rpsw-assets/css/slick.css', array(), RPSW_VERSION );
			wp_enqueue_style( 'wpos-slick-style' );
		}
		
		// Registring and enqueing public css
		wp_register_style( 'rpsw-public-style', RPSW_URL.'rpsw-assets/css/recent-post-style.css', array(), RPSW_VERSION );
		wp_enqueue_style( 'rpsw-public-style' );

		// Registring and enqueing public css
		wp_register_style( 'wpoh-font-awesome', RPSW_URL.'rpsw-assets/css/font-awesome.min.css', array(), RPSW_VERSION );
		wp_enqueue_style( 'wpoh-font-awesome' );
	}
	
	/**
	 * Function to add script at front side
	 * 
	 * @package WP Responsive Recent Post Slider
	 * @since 1.0.0
	 */
	function rpsw_front_script() {
		
		// Registring slick slider script
		if( !wp_script_is( 'wpoh-slick-js', 'registered' ) ) {
			wp_register_script( 'wpoh-slick-js', RPSW_URL.'rpsw-assets/js/slick.min.js', array('jquery'), RPSW_VERSION, true );
		}
		
		// Registring and enqueing public script
		wp_register_script( 'rpsw-public-script', RPSW_URL.'rpsw-assets/js/rpsw-public.js', array('jquery'), RPSW_VERSION, true );
		wp_localize_script( 'rpsw-public-script', 'Wppsac', array(
																	'is_mobile' => (wp_is_mobile()) ? 1 : 0,
																	'is_rtl' 	=> (is_rtl()) 		? 1 : 0
																	));
	}

	function wp_rpsw_admin_script() {
        // Registring and enqueing admin css
        wp_register_script( 'rpsw-admin-script', RPSW_URL.'rpsw-assets/js/rpsw-admin.js', array('jquery'), RPSW_VERSION, true);
        wp_enqueue_script( 'rpsw-admin-script' );
}
}
$rpsw_script = new Rpsw_Script();