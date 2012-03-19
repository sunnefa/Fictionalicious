/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.7
Date created: 06.03.2011

*	This is scripts/edit_chapter.js. Submits deletes of chapters
*/

function del_chapter() {
	$('a.delete').click(function(e) {
    e.preventDefault();
    var parent = $(this).parent().parent().parent();
	var story = $(this).parent();
	var conf = confirm("Are you sure you want to delete this chapter?");
    if(conf == true) {
		$.ajax({
		  dataType: 'json',
		  type: 'get',
		  url: '?page=delete_chapter',
		  data: {
			"ajax": true,
			"story": story.attr('id').replace('story-',''),
			"chapter": parent.attr('id').replace('chapter-','')  
		  },
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
  	del_chapter();
});