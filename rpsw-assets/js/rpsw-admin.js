sg_rpsw_slider();
sg_rpsw_grid();//Call to slider shortcode ganrater
function sg_rpsw_grid() {   
    var sg_main = "[rpsw_recent_grid ";       
    var rpsw_grid_template = jQuery('#rpsw_grid_template').val();
    var rpsw_grid_limit = jQuery('#rpsw_grid_limit').val();
    var rpsw_grid_cell = jQuery('#rpsw_grid_cell').val();
    var rpsw_grid_cat = jQuery('#rpsw_grid_cat').val();
    var rpsw_grid_post = jQuery('#rpsw_grid_post').val();   
    var rpsw_grid_exclude_post = jQuery('#rpsw_grid_exclude_post').val(); 
    var rpsw_grid_date_show = jQuery('#rpsw_grid_date_show').val();
    var rpsw_grid_cat_show = jQuery('#rpsw_grid_cat_show').val();  
    var  rpsw_grid_content_show = jQuery('#rpsw_grid_content_show').val();
    var  rpsw_grid_word_limit = jQuery('#rpsw_grid_word_limit').val(); 
    var  rpsw_grid_post_type  = jQuery('#rpsw_grid_post_type').val();    
    var  rpsw_grid_taxonomy  = jQuery('#rpsw_grid_taxonomy').val();
    var rpsw_grid_author = jQuery('#rpsw_grid_author').val();   
     var rpsw_grid_read_more = jQuery('#rpsw_grid_read_more').val();
 if (rpsw_grid_template == 'default-template') {} else { sg_main = sg_main + ' template="' + rpsw_grid_template + '"';}
 if (rpsw_grid_limit == '-1') {} else { sg_main = sg_main + ' limit="' + rpsw_grid_limit + '"';}
 if (rpsw_grid_cell == 'nocell') {} else { sg_main = sg_main + ' grid="' + rpsw_grid_cell + '"';}
 if (rpsw_grid_cat == 'nocat') {} else { sg_main = sg_main + ' post_cat="' + rpsw_grid_cat + '"';}
 if (rpsw_grid_post == ' ') {} else { sg_main = sg_main + 'post="' + rpsw_grid_post + '"';}
 if (rpsw_grid_exclude_post == ' ') {} else { sg_main = sg_main + 'post="' + rpsw_grid_exclude_post + '"';} 
 if (rpsw_grid_date_show == 'default-value') {} else { sg_main = sg_main + ' show_date="' + rpsw_grid_date_show + '"';}
 if (rpsw_grid_cat_show == 'default-value') {} else { sg_main = sg_main + ' show_category_name="' + rpsw_grid_cat_show + '"';}
 if (rpsw_grid_content_show == 'default-value') {} else { sg_main = sg_main + ' show_content="' + rpsw_grid_content_show + '"';}
 if (rpsw_grid_post_type == ' ') {} else { sg_main = sg_main + ' post_type="'+ rpsw_grid_post_type + '"';}
 if (rpsw_grid_taxonomy == ' ') {} else { sg_main = sg_main + ' taxonomy="'+ rpsw_grid_taxonomy + '"';}
 if (rpsw_grid_author == 'default-value') {} else { sg_main = sg_main + ' show_author="'+ rpsw_grid_author + '"';}
 if (rpsw_grid_read_more == 'default-value') {} else { sg_main = sg_main + ' show_read_more="'+ rpsw_grid_read_more + '"';} 
   sg_main = sg_main + ']';
    jQuery("#rpsw_sg_grid_shortcode").text(sg_main);
    jQuery("#rpsw_sg_grid_shortcode_php").text("'"+sg_main+"'");
}
function sg_rpsw_slider() {   
    var sg_main = "[rpsw_recent_slider  ";      
    var rpsw_slider_template = jQuery('#rpsw_slider_template').val();
    var rpsw_slider_limit = jQuery('#rpsw_slider_limit').val();
    var  rpsw_slider_cat = jQuery('#rpsw_slider_cat').val();  
    var  rpsw_slider_post = jQuery('#rpsw_slider_post').val();  
    var  rpsw_slider_exclude_post = jQuery('#rpsw_slider_exclude_post').val();
    var  rpsw_slider_date_show = jQuery('#rpsw_slider_date_show').val();
    var  rpsw_slider_cat_show = jQuery('#rpsw_slider_cat_show').val(); 
    var  rpsw_slider_content_show = jQuery('#rpsw_slider_content_show').val(); 
    var  rpsw_content_word_limit = jQuery('#rpsw_content_word_limit').val(); 
    var rpsw_slider_dots = jQuery('#rpsw_slider_dots').val();
    var rpsw_slider_arrow = jQuery('#rpsw_slider_arrow').val();  
    var rpsw_slider_autoplay = jQuery('#rpsw_slider_autoplay').val();  
    var rpsw_slider_autoplay_interval = jQuery('#rpsw_slider_autoplay_interval').val();
    var rpsw_slider_speed = jQuery('#rpsw_slider_speed').val(); 
    var rpsw_post_type = jQuery('#rpsw_post_type').val(); 
    var rpsw_taxonomy = jQuery('#rpsw_taxonomy').val(); 
    var rpsw_show_author = jQuery('#rpsw_show_author').val();  
    var rpsw_read_more = jQuery('#rpsw_read_more').val();    
 if (rpsw_slider_template == 'default-template') {} else { sg_main = sg_main + ' template="' + rpsw_slider_template + '"';}
 if (rpsw_slider_limit == '-1') {} else { sg_main = sg_main + 'limit="' + rpsw_slider_limit + '"';}
 if (rpsw_slider_cat == 'nocat') {} else { sg_main = sg_main + 'post_cat="' + rpsw_slider_cat + '"';} 
 if (rpsw_slider_post == ' ') {} else { sg_main = sg_main + 'post="' + rpsw_slider_post + '"';} 
 if (rpsw_slider_exclude_post == ' ') {} else { sg_main = sg_main + ' hide_post="' + rpsw_slider_exclude_post + '"';}
 if (rpsw_slider_date_show == 'default-value') {} else { sg_main = sg_main + ' show_date="' + rpsw_slider_date_show + '"';}
 if (rpsw_slider_cat_show == 'default-value') {} else { sg_main = sg_main + ' show_category_name="' + rpsw_slider_cat_show + '"';}
 if (rpsw_slider_content_show == 'default-value') {} else { sg_main = sg_main + ' show_content="' + rpsw_slider_content_show + '"';}
 if (rpsw_content_word_limit == ' ') {} else { sg_main = sg_main + ' content_words_limit="' + rpsw_content_word_limit + '"';}
 if (rpsw_slider_dots == 'default-value') {} else { sg_main = sg_main + ' bullet="' + rpsw_slider_dots + '"';}
 if (rpsw_slider_arrow == 'default-value') {} else { sg_main = sg_main + ' arrows="' + rpsw_slider_arrow + '"';}
 if (rpsw_slider_autoplay == 'default-value') {} else { sg_main = sg_main + ' autoplay="' + rpsw_slider_autoplay + '"';}
 if (rpsw_slider_autoplay_interval == '3000') {} else { sg_main = sg_main + ' autoplay="' + rpsw_slider_autoplay_interval + '"';}
 if (rpsw_slider_speed == '1000') {} else { sg_main = sg_main + ' speed="' + rpsw_slider_speed + '"';}
 if (rpsw_post_type == ' ') {} else { sg_main = sg_main + ' post_type="'+ rpsw_post_type + '"';} 
 if (rpsw_taxonomy == ' ') {} else { sg_main = sg_main + ' taxonomy="'+ rpsw_taxonomy + '"';}
 if (rpsw_show_author == 'default-value') {} else { sg_main = sg_main + ' show_author="'+ rpsw_show_author + '"';}
 if (rpsw_read_more == 'default-value') {} else { sg_main = sg_main + ' show_read_more="'+ rpsw_read_more + '"';}
   sg_main = sg_main + ']';
    jQuery("#rpsw_sg_slider_shortcode").text(sg_main);
    jQuery("#rpsw_sg_slider_shortcode_php").text("'"+sg_main+"'");
}