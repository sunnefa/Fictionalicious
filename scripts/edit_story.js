/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.9
Date created: 06.03.2011

*	This is scripts/edit_story.js. Submits deletes of stories
*/

function del_story() {
	$('a.delete').click(function(e) {
    e.preventDefault();
    var parent = $(this).parent().parent().parent();
	var conf = confirm("Are you sure you want to delete this story?");
    if(conf == true) {
		$.ajax({
		  dataType: 'json',
		  type: 'get',
		  url: '?page=delete_story',
		  data: 'ajax=true&delete=' + parent.attr('id').replace('story-', ''),
		  beforeSend: function() {	
		  parent.animate({'backgroundColor': '#d88'}, 300);
		  },
		  success: function(j) {
			parent.slideUp(300, function () {
				parent.remove();	
			});
			var mess = $('#mess');
			mess.slideDown(300, function () {
				mess.html(j.msg);
			});
			setTimeout(function () {
				mess.slideUp(300);
			}, 3000);
		  }
		});
	}
	else {
		window.location.reload();	
	}
  });	
}


$(document).ready(function() {
  	del_story();
});