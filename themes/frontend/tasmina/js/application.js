$(document).ready(function() {
	$('.tips').tooltip();

	var offset = 220;
	var duration = 500;

	$.each($('#block-gallery .item .col-md-4'), function (index, value) { 
		var imgthumbs = $(this).find('img').attr("src");
		var base_url = imgthumbs;
		$(this).find(".thumbnail").css("background", 'url(' + imgthumbs + ')' + ' center center no-repeat');
	});

	$('.topclick').click(function(event) {
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

	$('.carousel').carousel({
		interval: 12000
	})

	$('#widget_product_list #new.tab-pane ul').bxSlider({
		slideWidth: 2000,
		minSlides: 4,
		maxSlides: 4,
		auto: true,
		pause: 12000,
		speed: 2000,
		useCSS: false,
		easing: 'easeOutElastic',
		pager:false,
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>'
	});

	$('#widget-testimoni .testimoni-slide').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		mode: 'fade',
		speed: 1000,
		pause: 8000,
		controls: false,
		auto: true,
		pager: false
	});

	if (window.matchMedia('(min-width: 320px)').matches) {
		$('.top-info ul.slide').bxSlider({
			minSlides: 1,
			maxSlides: 1,
			mode: 'fade',
			speed: 1000,
			pause: 8000,
			controls: false,
			auto: true,
			pager: false
		});
	}

	if (window.matchMedia('(min-width: 100px)').matches && window.matchMedia('(max-width: 1200px)').matches) {
		$("#navbar-collapse .nav").prepend("<li class='closeme'><div class='icons'>Tutup Menu</div><span class='sep_top'></span><span class='sep_bottom'></span></li>");
		$("#navbar-collapse").removeClass("collapse");
		$("#navbar-collapse .nav .closeme").click(function(event) {
			$("#navbar-collapse").removeClass("collapse");
		});

		$(".navbar-toggle").click(function(event) {
			$("#navbar-collapse").addClass("collapse");
		});

		var getref = $(".main-nav .nav > li:last-child a").attr("href");
		$(".navbar-header").append("<a href='"+getref+"' class='login_ref'><i class='fa fa-lock'></i>&nbsp; Login Member</a>");

		var col = $( "#table_product_2 tr:first-child th" ).length;
		var row1 = $( "#table_product_2 tr" ).length;

		if (row1 > 1) {
			$("#table_product_2 tr").hide();
			for (var i = 1; i < row1; i++) {
				var newRow1 = $("<tr>");
				var cols1 = "";
				cols1 += '<td colspan="2" width="30%">'+$("#table_product_2").find("tr:nth-child("+(i+1)+") th:nth-child(1)").html()+'</td>';
				cols1 += '<td colspan="2" width="70%">';
				for (var x = 1; x < col; x++) {
					cols1 += "<h5 class='header_title'>";
					cols1 += $("#table_product_2").find("tr:nth-child("+(i)+") th:nth-child("+(x+1)+")").html();
					cols1 += "</h5>";
					cols1 += $("#table_product_2").find("tr:nth-child("+(i+1)+") td:nth-child("+(x+1)+")").html();
					cols1 += "<br>";
				}
				cols1 += '</td>';
				newRow1.append(cols1);
				$("#table_product_2 tbody").append(newRow1);
			};
		};
	}

	if (window.matchMedia('(max-width: 480px)').matches) {
		$("#widget-submenu").insertAfter("#main-side > .panel");
		$('.stats .scroll-text ul').bxSlider({
			minSlides: 2,
			maxSlides: 2,
			autoStart: true,
			auto: true,
			controls: false,
			pager: false,
			useCSS: false,
			slideWidth: 2000,
			slideMargin: 2,
			mode: 'vertical',
			speed: 1000,
			pause: 4000
		});

		$(".login_ref").empty();
		$(".login_ref").append("<i class='fa fa-lock'></i>");

		var col = $( "#table_product_2 tr:first-child th" ).length;
		var row1 = $( "#table_product_2 tr" ).length;

		if (row1 > 1) {
			$("#table_product_2 tr").hide();
			for (var i = 1; i < row1-1; i++) {
				var newRow1 = $("<tr>");
				var cols1 = "";
				cols1 += '<td colspan="2" width="100%">';
				cols1 += '<div class="well">';
				cols1 += $("#table_product_2").find("tr:nth-child("+(i+1)+") th:nth-child(1)").html();
				cols1 += "</div>";
				for (var x = 1; x < col; x++) {
					cols1 += "<h5 class='header_title'>";
					cols1 += $("#table_product_2").find("tr:nth-child("+(i)+") th:nth-child("+(x+1)+")").html();
					cols1 += "</h5>";
					cols1 += $("#table_product_2").find("tr:nth-child("+(i+1)+") td:nth-child("+(x+1)+")").html();
					cols1 += "<br>";
				}
				cols1 += '</td>';
				newRow1.append(cols1);
				$("#table_product_2 tbody").append(newRow1);
			};
		};

		var vrow = $( "#event_info_tbl tr" ).length;
		$("#event_info_tbl tr").hide();
		for (var i = 0; i < vrow; i++) {
			var newRow2 = $("<tr>");
			var cols2 = "";
			cols2 += '<td colspan="2" width="100%">';
			cols2 += "<h5 class='header_title' style='font-family: robotobold;background:#5ea000;'>";
			cols2 += $("#event_info_tbl").find("tr:nth-child("+(i+1)+") td:nth-child("+(1)+")").html();
			cols2 += "</h5>";
			cols2 += $("#event_info_tbl").find("tr:nth-child("+(i+1)+") td:nth-child("+(3)+")").html();
			cols2 += "<br>";
			cols2 += '</td>';
			newRow2.append(cols2);
			$("#event_info_tbl tbody").append(newRow2);
		};

		var vrow2 = $( "#table_rekening tr" ).length;
		$("#table_rekening tr").hide();
		for (var i = 0; i < vrow2-1; i++) {
			var newRow3 = $("<tr>");
			var cols3 = "";
			cols3 += '<td colspan="3" width="100%" align="center">';
			cols3 += $("#table_rekening").find("tr:nth-child("+(i+1)+") td:nth-child("+(1)+")").html();
			cols3 += "<h5 style='font-family: robotobold;color:#5ea000;padding: 5px 0;'>";
			cols3 += $("#table_rekening").find("tr:nth-child("+(i+1)+") td:nth-child("+(2)+")").html();
			cols3 += "</h5>";
			cols3 += $("#table_rekening").find("tr:nth-child("+(i+1)+") td:nth-child("+(3)+")").html();
			cols3 += "<br>";
			cols3 += '</td>';
			newRow3.append(cols3);
			$("#table_rekening tbody").append(newRow3);
		};

		var col = $( "#table_product_3 tr:first-child th" ).length;
		var row1 = $( "#table_product_3 tr" ).length;

		if (row1 > 1) {
			$("#table_product_3 tr").hide();
			for (var i = 1; i < row1-1; i++) {
				var newRow1 = $("<tr>");
				var cols1 = "";
				cols1 += '<td colspan="2" width="100%">';
				cols1 += '<div class="well">';
				cols1 += $("#table_product_3").find("tr:nth-child("+(i+1)+") th:nth-child(1)").html();
				cols1 += "</div>";
				for (var x = 1; x < col; x++) {
					cols1 += "<h5 class='header_title'>";
					cols1 += $("#table_product_3").find("tr:nth-child("+(i)+") th:nth-child("+(x+1)+")").html();
					cols1 += "</h5>";
					cols1 += $("#table_product_3").find("tr:nth-child("+(i+1)+") td:nth-child("+(x+1)+")").html();
					cols1 += "<br>";
				}
				cols1 += '</td>';
				newRow1.append(cols1);
				$("#table_product_3 tbody").append(newRow1);
			};
		};

	}
	else if (window.matchMedia('(max-width: 767px)').matches) {
		$("#widget-submenu").insertAfter("#main-side > .panel");

		$('.stats .scroll-text ul').bxSlider({
			minSlides: 2,
			maxSlides: 2,
			autoStart: true,
			auto: true,
			controls: false,
			pager: false,
			useCSS: false,
			slideWidth: 2000,
			slideMargin: 2,
			mode: 'vertical',
			speed: 1000,
			pause: 4000
		});
	}
	else if (window.matchMedia('(max-width: 991px)').matches) {
		$("#widget-submenu").insertAfter("#main-side > .panel");
	}
	else if (window.matchMedia('(max-width: 1200px)').matches) {

	}
	else {
		$('.stats .scroll-text ul').bxSlider({
			minSlides: 5,
			maxSlides: 5,
			autoStart: true,
			auto: true,
			controls: false,
			pager: false,
			useCSS: false,
			slideWidth: 2000,
			slideMargin: 5,
			mode: 'vertical',
			speed: 1000,
			pause: 4000
		});
	}


});

$(document).ready(function() {
	$( '.dropdown' ).hover (function(){$(this).children('.sub-menu').slideDown(200);},function(){$(this).children('.sub-menu').slideUp(200);});

	// if (window.matchMedia('(min-width: 1200px)').matches) {
	// 	var stickyHeaderTop = $('.main-nav').offset().top;
	// 	$(window).scroll(function(){
	// 		if( $(window).scrollTop() > stickyHeaderTop ) {
	// 			$('#navbar-collapse').addClass('fixed');
	// 		} else {
	// 			$('#navbar-collapse').removeClass('fixed');
	// 		}
	// 	});
	// }

	if (window.matchMedia('(max-width: 1200px)').matches) {

	}
});
