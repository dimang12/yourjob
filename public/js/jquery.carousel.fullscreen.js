/******************************************************************************
	Transforms the basic Twitter Bootstrap Carousel into Fullscreen Mode
	@author Fabio Mangolini
     http://www.responsivewebmobile.com
******************************************************************************/
jQuery(document).ready(function() {
	limitHeight= $(window).outerHeight() * 0.4;
	$('.carousel .item').css({'margin': 0, 'width': $(window).width(), 'height': $(window).height()-limitHeight});
	//$('.carousel-inner').css({'z-index': 1});
	$('.header-carousel div.item img').each(function() {
		var imgSrc = $(this).attr('src');
		console.log(imgSrc);
		$(this).parent().css({'background': 'url('+imgSrc+') center center no-repeat', 'background-size': 'cover', '-moz-background-size': 'cover'});
		$(this).remove();
	});

	$(window).on('resize', function() {
		limitHeight= $(window).outerHeight() * 0.3;
		$('.carousel .item').css({'width': $(window).outerWidth(), 'height': $(window).outerHeight()-limitHeight});
	});	
});