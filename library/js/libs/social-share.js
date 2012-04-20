var $j = jQuery.noConflict();
$j(document).ready(function(){

	// Google plus button
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	
	// Pinterest share 'PIN IT' button 
	(function() {
		window.PinIt = window.PinIt || { loaded:false };
		if (window.PinIt.loaded) return;
		window.PinIt.loaded = true;
		function async_load(){
			var s = document.createElement("script");
			s.type = "text/javascript";
			s.async = true;
			if (window.location.protocol == "https:")
				s.src = "https://assets.pinterest.com/js/pinit.js";
			else
				s.src = "http://assets.pinterest.com/js/pinit.js";
			var x = document.getElementsByTagName("script")[0];
			x.parentNode.insertBefore(s, x);
		}
		if (window.attachEvent)
			window.attachEvent("onload", async_load);
		else
			window.addEventListener("load", async_load, false);
	})();
	
	// Stumbleupon Button
	(function() { 
		var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
		li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
	 })();

});