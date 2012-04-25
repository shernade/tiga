var $j = jQuery.noConflict();
$j(document).ready(function(){
	
	// Reponsive videos
	$j(".content-right").fitVids();
	
	// Reponsive menus
	$j(".secondary-nav").mobileMenu();
	
	// Drop down menus
	$j(".main-navigation ul li ul, .secondary-navigation ul li ul").parent().addClass("arrow");
	$j(".main-navigation ul li, .secondary-navigation ul li").hover(function(){
        $j(this).addClass("hover");
        $j(this).find("ul:first").slideToggle("fast");
    }, function(){
        $j(this).removeClass("hover");
        $j(this).find("ul:first").hide("slow");
    
    });
	
	jQuery(window).load(function() {
		jQuery('.flexslider').flexslider({
			slideshow: true,
			slideshowSpeed: 4000,
			pauseOnHover: true,
			prevText: "<span>&larr;</span>",
			nextText: "<span>&rarr;</span>"
		}).find(".featured-slides").hover(
			function() { $j(this).find(".slides-content").slideDown(); },
			function() { $j(this).find(".slides-content").slideUp(); }
		);
		
		
	});
	
	// Fancybox shortcode
	$j(".fancyimg, .format-gallery-item a").fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	
	// Equal height
	$j("article.cols").equalHeights();

});