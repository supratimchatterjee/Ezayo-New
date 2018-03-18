
jQuery(document).ready(function($) {

	/** Marquee **/
	$('.marquee > div').marquee();
	/** Marquee **/

	$(".textwidget > p").click(function(){
		$(this).next().toggleClass("open");
	});

	/*==Apply button==*/
	$(".content-banner .uk-button-primary").click(function(){
		$('html, body').animate({
	        scrollTop: $("#application_button").offset().top
	    }, 1000);
		$( ".application_button" ).trigger( "click" );
	});

	// Autocontrol archive post excerpt length
	$(window).load(function(){
		if($(window).width() > 767) {
			$('.post-excerpt').dotdotdot({
				height: 88
			});
		} else {
			$('.post-excerpt').dotdotdot({
				height: 58
			});
		}
	});

	//Beautify Videos
	$("#page").fitVids();

});
