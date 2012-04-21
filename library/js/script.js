var $j = jQuery.noConflict();
$j(document).ready(function(){
	
	// Reponsive videos
	$j(".content-right").fitVids();
	
	// Reponsive menus
	$j(".nav").mobileMenu();
	
	// Drop down menus
	$j(".main-navigation ul li ul, .secondary-navigation ul li ul").parent().addClass("arrow");
	$j(".main-navigation ul li, .secondary-navigation ul li").hover(function(){
        $j(this).addClass("hover");
        $j(this).find("ul:first").slideToggle("fast");
    }, function(){
        $j(this).removeClass("hover");
        $j(this).find("ul:first").hide("slow");
    
    });
	
	// Fancybox shortcode
	$j(".fancyimg").fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	
	// Equal height
	$j("article.cols").equalHeights();

});