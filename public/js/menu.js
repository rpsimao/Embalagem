$(document).ready(function(){
	$(".trigger").click(function(){
		$(".panel_menu").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
	
	$(".disabled").hide();
	
});