/* Author:
M.Satrya - http://twitter.com/msattt
*/

var $j = jQuery.noConflict();

$j(document).ready(function(){
	
	// Reponsive videos
	$j( "#content" ).fitVids();
	
	// Reponsive menus
	$j( ".secondary-nav" ).tinyNav();
	$j( ".main-nav" ).tinyNav();
	
	// Drop down menus
	$j( ".main-navigation ul li ul, .secondary-navigation ul li ul" ).parent().addClass( "arrow" );
	$j( ".main-navigation ul li, .secondary-navigation ul li" ).hover(function(){
        $j(this).addClass( "hover" );
        $j(this).find( "ul:first" ).slideToggle( "fast" );
    }, function(){
        $j(this).removeClass( "hover" );
        $j(this).find( "ul:first" ).slideUp( "fast" );
    
    });

	// Blog page w/ slider
    $j( ".rslides" ).responsiveSlides({
		auto: true,
        pager: true,
        nav: false,
        speed: 500,
		pauseControls: true,
		pause: true		    
	}).find( ".featured-slides" ).hover(
		function() { $j(this).find( ".slides-content" ).slideDown(); },
		function() { $j(this).find( ".slides-content" ).slideUp(); }
	);
	
});