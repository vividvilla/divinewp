jQuery(document).ready(function($) {

  $("#menu-primary-navigation").before('<div id="primary-menu-icon"></div>');
	$("#primary-menu-icon").click(function() {
		$(".menu-primary").slideToggle();
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".menu-primary").removeAttr("style");
		}
	});
	
});