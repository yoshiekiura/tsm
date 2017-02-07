$(document).ready(function() {
	$('.tips').tooltip();
	//$('audio').audioPlayer();

	var offset = 220;
	var duration = 500;

	$.each($('#block-gallery .item .col-md-4'), function (index, value) { 
		//console.log($(this).find('img').attr("src") + ':' + $(value).text()); 
		var imgthumbs = $(this).find('img').attr("src");
		var base_url = imgthumbs;
		$(this).find(".thumbnail").css("background", 'url(' + imgthumbs + ')' + ' center center no-repeat');
	});

	$('#scroll-top').click(function(event) {
		event.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	});

	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'facebook', 
		slideshow:5000,
		deeplinking: false, 
		social_tools: false,
		autoplay_slideshow:false
	});

	$('.slide .bxslider').bxSlider({
		slideWidth: 2000,
		minSlides: 1,
		maxSlides: 1,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic'
		// pager:false,
	});

	$('#widget-partner .slide').bxSlider({
		slideWidth: 2000,
		minSlides: 1,
		maxSlides: 1,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic',
		pager:true,
		pagerCustom: '#bx-pager-partner',
		controls: false
	});

	
	$('#widget-promo-side .slide').bxSlider({
		minSlides: 2,
		maxSlides: 2,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic',
		pager:false,
		mode: 'vertical',
		controls: false
	});

	$('#widget-news-side .slide').bxSlider({
		slideWidth: 2000,
		minSlides: 1,
		maxSlides: 1,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic',
		pager:false,
		mode: 'vertical',
		controls: false
	});

	$('#widget-member .slide').bxSlider({
		nextSelector: '.nav-next._5th',
		prevSelector: '.nav-prev._5th',
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		slideWidth: 2000,
		minSlides: 1,
		maxSlides: 1,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic',
		pager:false
	});

	$('.slide-testimonial').bxSlider({
		nextSelector: '.nav-next._4th',
		prevSelector: '.nav-prev._4th',
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		slideWidth: 2000,
		minSlides: 2,
		maxSlides: 2,
		auto: true,
		pause: 12000,
		speed: 2000,
		pager:false
	});

	var count_list_promo = $('#widget-reward #list_promo > .panel-body > .row > .col-md-3').size();
	if(count_list_promo < 4) {
		//alert("jumlah " + count_list_promo);
	} else {
		$('#list_promo .panel-body > .row').bxSlider({
			nextSelector: '.nav-next._2nd',
			prevSelector: '.nav-prev._2nd',
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>',
			slideWidth: 2000,
			minSlides: 4,
			maxSlides: 4,
			auto: true,
			pause: 10000,
			pager:false
		});
	}
	//alert("jumlah div child " + $('#widget-reward #list_promo > .panel-body > .row > .col-md-3').size());

});

$(document).ready(function() {
	$( '.dropdown' ).hover(
		function(){
			$(this).children('.sub-menu').slideDown(200);
		},
		function(){
			$(this).children('.sub-menu').slideUp(200);
		}
		);

	$(function(){
		var stickyHeaderTop = $('.top-info').offset().top;

		$(window).scroll(function(){
			if( $(window).scrollTop() > stickyHeaderTop ) {
				$('.top-info').css({position: 'fixed', top: '0px'});
				$('.top-info').addClass('fixed');
			} else {
				$('.top-info').css({position: 'absolute', top: '0px'});
				$('.top-info.fixed').removeClass('fixed');
			}
		});
	});

	$(window).load(function(){
		$('#popupmodal').modal('show');
		setTimeout(function(){
			$('#popupmodal').modal('hide');
		}, 10000);
	});
});