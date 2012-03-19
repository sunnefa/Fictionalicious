/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.9
Date created: 15.03.2011

*	This is scripts/settings.js
*/

$(document).ready(function() {
	$("a.help").click(function(e){
		e.preventDefault();
		var parent = $(this).parent();
		var help = parent.children("ul.help");
		$(help).slideToggle(300);
	});	

});