jQuery(document).ready(function($) {
	// For Slider
	$( '.rpsw-post-slider' ).each(function( index ) {
		var slider_id   	= $(this).attr('id');			
		var slider_conf 	= $.parseJSON( $(this).closest('.rpsw-slick-slider-wrp').find('.rpsw-slider-conf').attr('data-conf'));
		if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
			jQuery('#'+slider_id).slick({
				slidesToShow 	: parseInt(slider_conf.slides_column),
                slidesToScroll 	: parseInt(slider_conf.slides_scroll),
				dots			: (slider_conf.dots) == "true" ? true : false,
				infinite		: true,
				arrows			: (slider_conf.arrows) == "true" ? true : false,
				speed			: parseInt(slider_conf.speed),
				autoplay		: (slider_conf.autoplay) == "true" ? true : false,
				prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
                nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
				autoplaySpeed	: parseInt(slider_conf.autoplay_interval),
				slidesToShow	: 1,
				slidesToScroll	: 1,				
			});
		}
	});
});