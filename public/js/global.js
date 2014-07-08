$(document).ready(function(){
	$('.carousel').carousel();
	
	$('.menu li a').mouseover(function(){
		l= $(this).offset();
		w= $(this).width();
		pl= parseInt($(this).css('padding-left'));
		ml= $('.menu').offset().left;
		//console.log(l.left);

		$('.slide-down .node').stop().animate({left: l.left - ml + pl , width:w},100);
	});
	
	$('.menu li a').mouseout(function(){
		a=$('.menu li .active');
		l= a.offset();
		w= a.width();
		pl= parseInt($(this).css('padding-left'));
		ml= $('.menu').offset().left;

		$('.slide-down .node').stop().animate({left: l.left - ml + pl , width:w},300);
		
	});
	
	
	$('.menu li a').trigger('mouseout');
	$(window).resize(function(){
		$('.menu li a').trigger('mouseout');	
	});
});