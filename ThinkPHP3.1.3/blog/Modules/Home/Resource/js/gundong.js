jQuery(document).ready(function($){
$('#roll_top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
$('#ct').click(function(){$('html,body').animate({scrollTop:$('#comments').offset().top}, 800);});
$('#fall').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 800);});
// context
$('.entry_box_s').hover(
	function() {
		$(this).find('.context_t').stop(true,true).fadeIn();
	},
	function() {
		$(this).find('.context_t').stop(true,true).fadeOut();
	}
);
// more
$('.entry_box').hover(
	function() {
		$(this).find('.archive_more').stop(true,true).fadeIn();
	},
	function() {
		$(this).find('.archive_more').stop(true,true).fadeOut();
	}
);

$("#filter-btn").click(function () {
	$(this).next().animate({width: 'toggle'});
});

$("#filter-btn2").click(function () {
	$(this).prev().animate({width: 'toggle'});
});
});
