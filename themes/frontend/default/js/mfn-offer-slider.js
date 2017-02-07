if ( typeof( mfn_slider_args )==='undefined' ) mfn_slider_args = [];
var mfn_slider_timeout = ( mfn_slider_args.timeout ) ? mfn_slider_args.timeout : 5000;
var mfn_slider_auto = ( mfn_slider_args.auto ) ? true : false;
var mfn_slider_pause = ( mfn_slider_args.pause ) ? true : false;
var mfn_slider_controls = ( mfn_slider_args.controls ) ? true : false;

function MfnSlider(){
	
	var slider = jQuery('#Slider ul.slider-wrapper');
	slider.css('visibility','visible');	
	
	slider.responsiveSlides({
		auto: mfn_slider_auto,				// Boolean: Animate automatically, true or false
		speed: 0,            				// Integer: Speed of the transition, in milliseconds
		timeout: mfn_slider_timeout,		// Integer: Time between slide transitions, in milliseconds
		pager: mfn_slider_controls,       	// Boolean: Show pager, true or false
		nav: false,							// Boolean: Show navigation, true or false
		pause: mfn_slider_pause,        	// Boolean: Pause on hover, true or false
		pauseControls: mfn_slider_pause,	// Boolean: Pause when hovering controls, true or false
		namespace: "mfn-slider",			// String: change the default namespace used
		before: before,						// Function: Before callback
		after: after 						// Function: After callback
	});
	
	// mfn_slider_controls
	if( mfn_slider_controls ){
		var slider_tabs = jQuery("#Slider ul.mfn-slider_tabs");
		jQuery('#Slider').removeClass('no-pager');
		
		slider_tabs
			.addClass('jcarousel-skin-tango')
			.jcarousel({
				visible: 4,
		        wrap: 'last',
		        buttonPrevHTML: '<a class="jcarousel-prev">&lsaquo;</a>',
		        buttonNextHTML: '<a class="jcarousel-next">&rsaquo;</a>'
			});
		
		slider.find('li').each(function(index) {
			var title = (jQuery(this).find('.pager_title').text());
			var thumbnail = (jQuery(this).find('.thumbnail img').attr('src'));
			var id = index + 1;
	
			slider_tabs
				.find('.jcarousel-item-' + id + ' a')
				.empty()
				.append('<div class="photo"><img src="'+ thumbnail +'" alt="" class="scale-with-grid"></div>')
				.append('<h5>'+ title +'</h5>')
				/*.append('<svg width="8" height="4" xmlns="http://www.w3.org/2000/svg"><path id="svg_1" d="M0 0 L4 4 L8 0 Z" stroke-width="0" stroke="#000000" fill="#3E3E3E"/></svg>');*/

		});

		jQuery('#Slider .jcarousel-skin-tango').append('<div class="mfn-slider_tabs_bg"></div>');	
	}
	
	function before(idx, length){
		var carousel = jQuery(slider_tabs).data('jcarousel');
		var current = idx + 1;
		var next =  current < length ? current + 1 : 0;

		slider.find('.slide-img').css({'display':'none', 'margin-left':-2405});
		slider.find('.desc h3').css({'display':'none', 'margin-left':-376});
		slider.find('.desc h2').css({'display':'none', 'margin-left':-376});
		slider.find('.desc p').css({'display':'none', 'margin-left':960});
		slider.find('.desc a.button').css({'display':'none', 'margin-left':960});

		// mfn_slider_controls
		if( mfn_slider_controls ){
			if( current > carousel.last || current < carousel.first ){
				jQuery('#Slider .jcarousel-next').click();
			}
		}
	}
	
	function after(){
		slider.find('.slide-img').css({'display':'inline'}).stop().animate({'margin-left':0}, 600);
		slider.find('.desc h3').css({'display':'block'}).stop().delay(250).animate({'margin-left':0}, 400);
		slider.find('.desc h2').css({'display':'block'}).stop().delay(400).animate({'margin-left':0}, 450);
		slider.find('.desc p').css({'display':'block'}).stop().delay(350).animate({'margin-left':0}, 450);
		slider.find('.desc a.button').css({'display':'inline-block'}).stop().delay(450).animate({'margin-left':0}, 500);
	}

}
	
jQuery(document).ready(function(){
	var mfn_slider = new MfnSlider();
});