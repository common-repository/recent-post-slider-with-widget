<?php
/**
 * Plugin Getting Started Page
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Action to add menu
add_action('admin_menu', 'rpsw_register_menu_page');
/**
 * Register plugin design page in admin menu
 * 
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
function rpsw_register_menu_page() {
	add_menu_page( __('Recent Post Slider', 'recent-post-slider-widget'), __('Recent Posts Slider Help', 'recent-post-slider-widget'), 'manage_options', 'rpsw-about', 'rpsw_getting_started_page', 'dashicons-sticky', 6 );
}
/**
 * Function to display plugin design HTML
 * 
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
function rpsw_getting_started_page() {
	$rpsw_all_tabs = rpsw_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? rpsw_sanitize_clean($_GET['tab']) : 'help-for-you';
?>
	<div class="wrap rpsw-wrap">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($rpsw_all_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array('page' => 'rpsw-about', 'tab' => $tab_key), admin_url('admin.php') );
			?>
			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_name; ?></a>
			<?php } ?>
		</h2>
		<div class="rpsw-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'help-for-you' ) {
				rpsw_howitwork_page();
			}
			if( isset($active_tab) && $active_tab == 'slider-shortcode' ) {
				rpsw_admin_slider_shortcode();
			}

			if( isset($active_tab) && $active_tab == 'grid-shortcode' ) {
				rpsw_admin_grid_shortcode();
			}


			if( isset($active_tab) && $active_tab == 'hire-wpexpert' ) {
				echo  rpsw_get_plugin_design('hire-wpexpert');
			}		
		?>
		</div><!-- end .rpsw-tab-cnt-wrp -->

	</div><!-- end .rpsw-wrap -->

<?php
}

/**
 * Gets the plugin design part feed
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
function rpsw_get_plugin_design( $feed_type = '' ) {
	
	$active_tab = isset($_GET['tab']) ? rpsw_sanitize_clean($_GET['tab']) : '';
	
	// If tab is not set then return
	if( empty($active_tab) ) {
		return false;
	}

	// Taking some variables
	$rpsw_all_tabs = rpsw_help_tabs();
	$transient_key 	= isset($rpsw_all_tabs[$active_tab]['transient_key']) 	? $rpsw_all_tabs[$active_tab]['transient_key'] 	: 'rpsw_' . $active_tab;
	$url 			= isset($rpsw_all_tabs[$active_tab]['url']) 			? $rpsw_all_tabs[$active_tab]['url'] 				: '';
	$transient_time = isset($rpsw_all_tabs[$active_tab]['transient_time']) ? $rpsw_all_tabs[$active_tab]['transient_time'] 	: 172800;
	$cache 			= get_transient( $transient_key );	
	if ( false === $cache ) {
		
		$feed 			= wp_remote_get( esc_url_raw( $url ), array( 'timeout' => 120, 'sslverify' => false ) );
		$response_code 	= wp_remote_retrieve_response_code( $feed );
		
		if ( ! is_wp_error( $feed ) && $response_code == 200 ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( $transient_key, $cache, $transient_time );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the data from the server. Please try again later.', 'recent-post-slider-widget' ) . '</div>';
		}
	}
	return $cache;	
}
/**
 * Function to get plugin feed tabs
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
function rpsw_help_tabs() {
	$rpsw_all_tabs = array(
						'help-for-you' 	=> array(
													'name' => __('Help For You', 'recent-post-slider-widget'),
												),
						'slider-shortcode' => array('name' => __('Slider shortcode Generator', 'recent-post-slider-widget'),),
						'grid-shortcode' => array('name' => __('Grid shortcode Generator', 'recent-post-slider-widget'),),
						'hire-wpexpert' 	=> array(
													'name'				=> __('WordPress Help ', 'recent-post-slider-widget'),
													'url'				=> 'https://wponlinehelp.com/wordpress-help/help-offers.php',
													'offer_key'		=> 'wpoh_offers_feed',
													'offer_time'	=> 98600,
												)
					);
	return $rpsw_all_tabs;
}
/**
 * Function to get 'How It Works' HTML
 *
 * @package WP Responsive Recent Post Slider
 * @since 1.0.0
 */
function rpsw_howitwork_page() { ?>
	<style type="text/css">
		.rpsw-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>
<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								<h3 class="hndle">
									<span><?php _e( 'How It Works - Display and Shortcode', 'recent-post-slider-widget' ); ?></span>
								</h3>
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php _e('Basic Step for setup', 'recent-post-slider-widget'); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php _e('Step-1. This plugin create a menu "Recent Post Slider Help".', 'recent-post-slider-widget'); ?></li>
														<li><?php _e('Step-2. use this plugin get all the Recent or latest POST from WordPress Post with a using slider shortcode', 'recent-post-slider-widget'); ?></li>

														<li><?php _e('Step-3. use this plugin <b>Widget</b> with latest & Recent POST from WordPress Post with a using recent post slider widget.', 'recent-post-slider-widget'); ?></li>

														<li><?php _e('Step-4. you can all so use this post slider in sidebar using widget text get all the Recent or latest POST from WordPress Post with a using slider shortcode.', 'recent-post-slider-widget'); ?></li>
													</ul>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('How Shortcode Works', 'recent-post-slider-widget'); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php _e('Step-1. Create a page like Latest Post add the shortcode in a page.', 'recent-post-slider-widget'); ?></li>
														<li><?php _e('Step-2. Put below shortcode as per your need.', 'recent-post-slider-widget'); ?></li>
													</ul>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('All Shortcodes', 'recent-post-slider-widget'); ?>:</label>
												</th>
												<td>
													<span class="rpsw-shortcode-preview">[rpsw_recent_slider template="template-1"]</span> – <?php _e('Recent <b>Post Slider</b> Shortcode. Where you can use 5 designs Template.', 'recent-post-slider-widget'); ?></br>
													<span class="rpsw-shortcode-preview">[rpsw_recent_grid template="template-1"]</span> – <?php _e('Recent <b>Post Grid</b> Shortcode. Where you can use 5 designs Template.', 'recent-post-slider-widget'); ?></br></br>
													<span class="rpsw-shortcode-preview">Widget :- Recent Post Slider and Widget</span> – <?php _e('This plugin also works with widget. Where you can use 3 designs Template.', 'recent-post-slider-widget'); ?></br>
													
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('Need Support?', 'recent-post-slider-widget'); ?></label>
												</th>
												<td>
													<p><?php _e('Check plugin document for shortcode parameters and demo for designs.', 'recent-post-slider-widget'); ?></p> <br/>
													<a class="button button-primary" href="http://docs.wponlinehelp.com/" target="_blank"><?php _e('Documentation', 'recent-post-slider-widget'); ?></a>									
													<a class="button button-primary" href="http://demo.wponlinehelp.com/" target="_blank"><?php _e('Demo for Designs', 'recent-post-slider-widget'); ?></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }
/**
 * 'plugin Slider Short code Generater
 *
 * @package Post player gallery
 * @since 1.0
 */
function rpsw_admin_slider_shortcode() { ?>	
	<style type="text/css">
		.shortcode-bg{background-color: #f0f0f0;padding: 10px 5px;display: inline-block;margin: 0 0 5px 0;font-size: 16px;border-radius: 5px;}
		.rpsw_admin_shortcode_generator label{font-weight: 700; width: 100%; float: left;}
		.rpsw_admin_shortcode_generator select{width: 100%;}
	</style>
	<div id="post-body-content">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<h3 style="font-size: 18px;">
						<?php _e('Create Post Slider Shortcode :-', 'recent-post-slider-widget') ?>
					</h3>
					<div class="inside">
						<table cellpadding="10" cellspacing="10">
							<tbody><tr><td valign="top">
								<div class="postbox" style="width:300px;">
								<form id="shortcode_generator" style="padding:20px; height: 500px; overflow-x: hidden;" class="rpsw_admin_shortcode_generator">
									<p><label for="rpsw_slider_template"><?php _e('1) Select Template:', 'recent-post-slider-widget'); ?></label>
										<?php $sg_tempalte = rpsw_slider_templates() ?>
										<select id="rpsw_slider_template" name="rpsw_slider_template"
										onchange="sg_rpsw_slider()">
										<option value="default-template">Default Template</option>
										<?php  foreach ($sg_tempalte as $k): ?>
											<option value="<?php _e($k, 'recent-post-slider-widget') ?>">
												<?php _e($k, 'recent-post-slider-widget') ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
								<p><label for="rpsw_slider_limit"><?php _e('2) Set Post Limit:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_slider_limit" name="rpsw_slider_limit" type="text" value="-1"
										      onchange="sg_rpsw_slider()">
										      <span class="howto"> <?php _e('for all "-1" Enter any Numeric No.).', 'recent-post-slider-widget'); ?></span>
							   </p>
										<p><label for="rpsw_slider_cat">
												<?php _e('3) Select Category:', 'recent-post-slider-widget') ?></label>
												<?php
												$args = array("post_type"=>RPSW_POST_TYPE, "post_status"=> "publish");
												$terms = get_terms(['taxonomy' => RPSW_CAT,$args]);	      						
												 ?>
												<select id="rpsw_slider_cat" name="rpsw_slider_cat" onchange="sg_rpsw_slider()">
												   <option value="nocat">All Post</option>
													<?php if ($terms!='') {
													foreach ($terms as $key => $value) { ?>
														<option value="<?php echo $value->term_id; ?>">
															<?php echo $value->name;  ?>
														</option>													
													<?php  } } ?>
												</select>
												<span class="howto"> By Default All Post.</span> 												
											</p>
											
										<p><label for="rpsw_slider_post"><?php _e('4) If Display Specific Post:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_slider_post" name="rpsw_slider_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_rpsw_slider()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>
							            <p><label for="rpsw_slider_exclude_post"><?php _e('5) If No Display Specific Post:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_slider_exclude_post" name="rpsw_slider_exclude_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_rpsw_slider()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>


							             <p>
                                                <label for="rpsw_slider_date_show"><?php _e('6) Display Date:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_date_show = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_date_show" name="rpsw_slider_date_show" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_date_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Date.</span>
                                    </p>

							             <p>
                                                <label for="rpsw_slider_cat_show"><?php _e('7) Display Category:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_cat_show = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_cat_show" name="rpsw_slider_cat_show" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_cat_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Category.</span>
                                    </p>
                                     <p>
                                                <label for="rpsw_slider_content_show"><?php _e('8) Display content:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_content_show = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_content_show" name="rpsw_slider_content_show" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_content_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display content.</span>
                                    </p>

                                     <p><label for="rpsw_content_word_limit"><?php _e('9) Set Content Word Limit:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_content_word_limit" name="rpsw_content_word_limit" type="text" value=" " placeholder="Enter Number" 
										      onchange="sg_rpsw_slider()">
										      <span class="howto"> <?php _e('Enter Any Number like: 25, 15, 5 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>

							         <p>
                                                <label for="rpsw_slider_dots"><?php _e('10) Set slider Pagination Dots:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_dots = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_dots" name="rpsw_slider_dots" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_dots as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Post Pagination dots Bullets.</span>
                                    </p>

							            <p>
                                                <label for="rpsw_slider_arrow"><?php _e('11) Set slider Arrow: ', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_arrow = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_arrow" name="rpsw_slider_arrow" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_arrow as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Post Arrow for previous and next Slide.</span>
                                    </p>
                                    <p>
                                                <label for="rpsw_slider_autoplay"><?php _e('12)  Set Post Autoplay ', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_slider_autoplay = rpsw_true_false(); ?>
                                                <select id="rpsw_slider_autoplay" name="rpsw_slider_autoplay" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_slider_autoplay as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Post Automatic Scrolling.</span>
                                    </p>
                                    
                                    <p><label for="rpsw_slider_autoplay_interval"><?php _e('13) Moving speed Interval Between Two slide:', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_slider_autoplay_interval" name="rpsw_slider_autoplay_interval" value="3000" onchange="sg_rpsw_slider()" type="text">
										      <span class="howto"> (Set Slide Moving speed intervals, value in Milliseconds. Defoult value is 3000, e.x. 1000 =1 sec. ).</span>
									</p>
									 <p><label for="rpsw_slider_speed"><?php _e('14) Slides Moving Speed:', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_slider_speed" name="rpsw_slider_speed" value="1000" onchange="sg_rpsw_slider()" type="text">
										      <span class="howto"> (set with different post type.).</span>
									</p>
									 <p><label for="rpsw_post_type"><?php _e('15):Post Type', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_post_type" name="rpsw_post_type" value=" " onchange="sg_rpsw_slider()" type="text">
										      <span class="howto"> (Set Different Post type. Enter Post type.  ).</span>
									</p>
									 <p><label for="rpsw_taxonomy"><?php _e('16): Taxonomy', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_taxonomy" name="rpsw_taxonomy" value=" " onchange="sg_rpsw_slider()" type="text">
										      <span class="howto"> (set with Different Taxonomy. ).</span>
									</p>
									  <p>
                                                <label for="rpsw_show_author"><?php _e('17) Display Author:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_show_author = rpsw_true_false(); ?>
                                                <select id="rpsw_show_author" name="rpsw_show_author" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_show_author as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Author.</span>
                                    </p>
                                    <p>
                                                <label for="rpsw_show_read_more"><?php _e('18) Display Read More Button:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_read_more = rpsw_true_false(); ?>
                                                <select id="rpsw_read_more" name="rpsw_read_more" onchange="sg_rpsw_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_read_more as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Author.</span>
                                    </p>	
                                   
                                 
                                    
                                   
										</form>
									</div>
								</td>
								<td valign="top"><h3><?php _e('Shortcode:', 'recent-post-slider-widget'); ?></h3> 
									<p style="font-size: 16px;"><?php _e('Use this shortcode to display the Recent Post Slider in your posts or pages! Just copy this piece of text and place it where you want it to display.', 'recent-post-slider-widget'); ?> </p>

									<div id="rpsw_sg_slider_shortcode" style="margin:20px 0; padding: 10px;
									background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								</div>
								<div style="margin:20px 0; padding: 10px;
								background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								&lt;?php echo do_shortcode(<span id="rpsw_sg_slider_shortcode_php"></span>); ?&gt;
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- .inside -->
		<hr>
	</div>
	</div>
    </div>
	</div>		
<?php }


function rpsw_admin_grid_shortcode() { ?>	
	<style type="text/css">
		.shortcode-bg{background-color: #f0f0f0;padding: 10px 5px;display: inline-block;margin: 0 0 5px 0;font-size: 16px;border-radius: 5px;}
		.rpsw_admin_shortcode_generator label{font-weight: 700; width: 100%; float: left;}
		.rpsw_admin_shortcode_generator select{width: 100%;}
	</style>
	<div id="post-body-content">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<h3 style="font-size: 18px;">
						<?php _e('Create Post Grid Shortcode :-', 'recent-post-slider-widget') ?>
					</h3>
					<div class="inside">
						<table cellpadding="10" cellspacing="10">
							<tbody><tr><td valign="top">
								<div class="postbox" style="width:300px;">
								<form id="shortcode_generator" style="padding:20px; height: 500px; overflow-x: hidden;" 
								       class="rpsw_admin_shortcode_generator">
									<p><label for="rpsw_grid_template"><?php _e('1) Select Template:', 'recent-post-slider-widget'); ?></label>
										<?php $sg_tempalte = rpsw_slider_templates() ?>
										<select id="rpsw_grid_template" name="rpsw_grid_template"
										onchange="sg_rpsw_grid()">
										<option value="default-template">Default Template</option>
										<?php  foreach ($sg_tempalte as $k): ?>
											<option value="<?php _e($k, 'recent-post-slider-widget') ?>">
												<?php _e($k, 'recent-post-slider-widget') ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
								<p><label for="rpsw_grid_limit"><?php _e('2) Set Post Limit:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_grid_limit" name="rpsw_grid_limit" type="text" value="-1"
										      onchange="sg_rpsw_grid()">
										      <span class="howto"> <?php _e('for all "-1" Enter any Numeric No.).', 'recent-post-slider-widget'); ?></span>
							   </p>


							   	<p><label for="rpsw_grid_cell">
												<?php _e('3) Select Grid:', 'recent-post-slider-widget') ?></label>
												<select id="rpsw_grid_cell" name="rpsw_grid_cell" onchange="sg_rpsw_grid()">
												   <option value="nocell">Select Columns</option>
												   <option value="1">1</option>
												   <option value="2">2</option>
												   <option value="3">3</option>
												   <option value="4">4</option>
												   <option value="5">5</option>
												   <option value="6">6</option>													
												</select>												
											</p>
										<p><label for="rpsw_grid_cat">
												<?php _e('4) Select Category:', 'recent-post-slider-widget') ?></label>
												<?php
												$args = array("post_type"=>RPSW_POST_TYPE, "post_status"=> "publish");
												$terms = get_terms(['taxonomy' => RPSW_CAT,$args]);	      						
												 ?>
												<select id="rpsw_grid_cat" name="rpsw_grid_cat" onchange="sg_rpsw_grid()">
												   <option value="nocat">All Post</option>
													<?php if ($terms!='') {
													foreach ($terms as $key => $value) { ?>
														<option value="<?php echo $value->term_id; ?>">
															<?php echo $value->name;  ?>
														</option>													
													<?php  } } ?>
												</select>
												<span class="howto"> By Default All Post.</span> 												
											</p>
											
										<p><label for="rpsw_grid_post"><?php _e('5) If Display Specific Post:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_grid_post" name="rpsw_grid_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_rpsw_grid()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>
							            <p><label for="rpsw_grid_exclude_post"><?php _e('6) If No Display Specific Post:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_grid_exclude_post" name="rpsw_grid_exclude_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_rpsw_grid()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>


							             <p>
                                                <label for="rpsw_grid_date_show"><?php _e('7) Display Date:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_grid_date_show = rpsw_true_false(); ?>
                                                <select id="rpsw_grid_date_show" name="rpsw_grid_date_show" onchange="sg_rpsw_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_grid_date_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Date.</span>
                                    </p>

							             <p>
                                                <label for="rpsw_grid_cat_show"><?php _e('8) Display Category:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_grid_cat_show = rpsw_true_false(); ?>
                                                <select id="rpsw_grid_cat_show" name="rpsw_grid_cat_show" onchange="sg_rpsw_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_grid_cat_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Category.</span>
                                    </p>
                                     <p>
                                                <label for="rpsw_grid_content_show"><?php _e('9) Display content:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_grid_content_show = rpsw_true_false(); ?>
                                                <select id="rpsw_grid_content_show" name="rpsw_grid_content_show" onchange="sg_rpsw_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_grid_content_show as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display content.</span>
                                    </p>

                                     <p><label for="rpsw_grid_word_limit"><?php _e('10) Set Content Word Limit:', 'recent-post-slider-widget'); ?></label>
						                    <input id="rpsw_grid_word_limit" name="rpsw_grid_word_limit" type="text" value=" " placeholder="Enter Number" 
										      onchange="sg_rpsw_grid()">
										      <span class="howto"> <?php _e('Enter Any Number like: 25, 15, 5 etc).', 'recent-post-slider-widget'); ?></span>
							            </p>

							       

                                  
                                 
									
									 <p><label for="rpsw_grid_post_type"><?php _e('11):Post Type', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_grid_post_type" name="rpsw_grid_post_type" value=" " onchange="sg_rpsw_grid()" type="text">
										      <span class="howto"> (Set Different Post type. Enter Post type.  ).</span>
									</p>
									 <p><label for="rpsw_grid_taxonomy"><?php _e('12): Taxonomy Name', 'recent-post-slider-widget');?> </label>
						                    <input id="rpsw_grid_taxonomy" name="rpsw_grid_taxonomy" value=" " onchange="sg_rpsw_grid()" type="text">
										      <span class="howto"> (set with Different Taxonomy. ).</span>
									</p>
									  <p>
                                                <label for="rpsw_grid_author"><?php _e('13) Display Author:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_grid_author = rpsw_true_false(); ?>
                                                <select id="rpsw_grid_author" name="rpsw_grid_author" onchange="sg_rpsw_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_grid_author as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Author.</span>
                                    </p>
                                    <p>
                                                <label for="rpsw_show_read_more"><?php _e('14) Display Read More Button:', 'recent-post-slider-widget'); ?> 
                                                </label>
                                                <?php $rpsw_grid_read_more = rpsw_true_false(); ?>
                                                <select id="rpsw_grid_read_more" name="rpsw_grid_read_more" onchange="sg_rpsw_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($rpsw_grid_read_more as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'recent-post-slider-widget') ?>">
                                                            <?php _e($i, 'recent-post-slider-widget') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Display Author.</span>
                                    </p>	
                                   
                                 
                                    
                                   
										</form>
									</div>
								</td>
								<td valign="top"><h3><?php _e('Shortcode:', 'recent-post-slider-widget'); ?></h3> 
									<p style="font-size: 16px;"><?php _e('Use this shortcode to display the Recent Post grid in your posts or pages! Just copy this piece of text and place it where you want it to display.', 'recent-post-slider-widget'); ?> </p>

									<div id="rpsw_sg_grid_shortcode" style="margin:20px 0; padding: 10px;
									background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								</div>
								<div style="margin:20px 0; padding: 10px;
								background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								&lt;?php echo do_shortcode(<span id="rpsw_sg_grid_shortcode_php"></span>); ?&gt;
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- .inside -->
		<hr>
	</div>
	</div>
    </div>
	</div>		
<?php }