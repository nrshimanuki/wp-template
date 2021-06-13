(function ($) {

	/* menu
	------------------------------*/
	$('#menu_button, #menu_close').on('click', function() {
		if (!$('#menu_button').hasClass('-open')) {
			$('body').addClass('-menu_open');
			$('#menu_button').addClass('-open');
			// let height = $(window).height() - 125;
			// $('#site_nav__inner').css('height', height + 'px');
		} else {
			$('body').removeClass('-menu_open');
			$('#menu_button').removeClass('-open');
		}
	});

	// $('.l_menu_item').on('click', function() {
	// 	$(this).each(function(i,e) {
	// 		if ($(e).hasClass('close')) {
	// 			$(e).removeClass('close');
	// 			$(e).addClass('open');
	// 		} else if ($(e).hasClass('open')) {
	// 			$(e).removeClass('open');
	// 			$(e).addClass('close');
	// 		}
	// 	})
	// });




	/* slider
	------------------------------*/
	// $('.slider').slick({
	// 	autoplay: true,
	// 	autoplaySpeed: 3500,
	// 	arrows: false,
	// 	centerMode: true,
	// 	centerPadding: '400px',
	// 	dots: true,
	// 	speed: 1800,
	// 	infinite: true,
	// 	fade: true,
	// 	cssEase: 'linear',
	// 	responsive: [
	// 		{
	// 			breakpoint: 1600,
	// 			settings: {
	// 				centerPadding: '255px',
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 1300,
	// 			settings: {
	// 				centerPadding: '100px',
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 768,
	// 			settings: {
	// 				arrows: false,
	// 				centerMode: false,
	// 				slidesToShow: 1
	// 			}
	// 		}
	// 	]
	// });




	/* SmoothScroll
	------------------------------*/
	$('a[href^="#"]').click(function() {
		var speed = 500;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});




	/* slideToggle
	------------------------------*/
	$('.toggle').css('cursor','pointer').on('click', function() {
		$(this).next().slideToggle();
	});




	/* pagetop
	------------------------------*/
	// $('body').append('<a href="javascript:void(0);" id="pageTop"></a>');
	const pageTop = $('#pagetop');
	pageTop.on('click',function() {
		$('html, body').animate({scrollTop: '0'}, 500);
	});

	$(window).on('load scroll resize',function() {
		const showTop = 400;
		if($(window).scrollTop() > showTop) {
			pageTop.fadeIn();
		} else {
			pageTop.fadeOut();
		}
	});




	/* AjaxZip3
	------------------------------*/
	jQuery('#form_zip02').keyup(function(event) {
		AjaxZip3.zip2addr('form_zip01','form_zip02','form_address01','form_address02');
		return false;
	});




	/* parallax
	------------------------------*/
	// var setArea = $('.scroll_event'),
	// showHeight = 150;
	// setArea.css({display:'block',opacity:'0'});
	// $(window).on('load scroll resize',function(){
	// 	setArea.each(function(){
	// 		var setThis = $(this),
	// 		areaTop = setThis.offset().top;

	// 		if ($(window).scrollTop() >= (areaTop + showHeight) - $(window).height()){
	// 			setThis.stop().animate({opacity:'1'}, 600);
	// 		} else {
	// 			// setThis.stop().animate({opacity:'0'}, 600);
	// 		}
	// 	});
	// });

	// $(window).on('load', function(){
	// 	if(window.matchMedia('(max-width:768px)').matches){
	// 		AOS.init({
	// 			offset: 200,
	// 			duration: 900,
	// 			once: true,
	// 			delay: 0
	// 		});
	// 	} else {
	// 		AOS.init({
	// 			offset: 300,
	// 			duration: 900,
	// 			once: true,
	// 			delay: 0
	// 		});
	// 	}
	// });




	/* Photo Gallery
	------------------------------*/
	// $('.gallery_thumbnail_sp').on('mouseover touchend',function(){
	// 	$('.gallery_thumbnail_sp').removeClass('active');
	// 	$(this).addClass('active');
	// 	var dataUrl = $(this).attr('src');
	// 	var dataText = $(this).attr('alt');
	// 	$('#gallery_main_img_sp').attr('src', dataUrl);
	// 	$('#gallery_main_text').text(dataText);
	// });
	// $('.gallery_thumbnail_pc').on('mouseover touchend',function(){
	// 	$('.gallery_thumbnail_pc').removeClass('active');
	// 	$(this).addClass('active');
	// 	var dataUrl = $(this).attr('src');
	// 	var dataText = $(this).attr('alt');
	// 	$('#gallery_main_img_pc').attr('src', dataUrl);
	// 	$('#gallery_main_text').text(dataText);
	// });




	/* modal
	------------------------------*/
	// $('.modal_open').click(function() {
	// 	let imgSrc = $(this).attr('src');
	// 	$('#modal_img').attr('src', imgSrc);
	// 	$('#modal_area').fadeIn();
	// });

	// $('#modal_close , #modal_bg').click(function() {
	// 	$('#modal_area').fadeOut();
	// });




	/* mCustomScrollbar
	------------------------------*/
	// $(window).on("load",function(){
	// 	$(".i_induction_list").mCustomScrollbar();
	// });




}(jQuery));
