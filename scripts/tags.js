/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.7
Date created: 06.03.2011

*	This is scripts/edit_story.js. Submits edits of story titles, tags and descriptions
*/

function slide_edit() {
	$("a.edit").click(function(e){
		e.preventDefault();
		var id = $(this).parent().parent().parent().attr('id').replace('tag-', '');
		var edit = $('#edit-' + id);
		edit.slideToggle(300);	
	});	
}

function del_tag() {
	$('a.delete').click(function(e) {
    e.preventDefault();
	var parent = $(this).parent().parent().parent();
	var tag_id = parent.attr('id').replace('tag-','');
	var conf = confirm("Are you sure you want to delete this tag?");
    if(conf == true) {
		$.ajax({
		  dataType: 'json',
		  type: 'post',
		  url: '?page=manage_tags',
		  data: {
			"ajax": true,
			"delete": true,
			"id": tag_id
		  },
		  beforeSend: function() {	
		  parent.animate({'backgroundColor': '#d88'}, 300);
		  },
		  success: function(j) {
			parent.slideUp(300, function () {
				parent.remove();	
			});
			var mess = $('.mess');
			mess.slideDown(300, function () {
				mess.html(j.mess);
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
  	slide_edit();
	del_tag();

	
	$('.submit').click(function(e){
		e.preventDefault();
		var id = $(this).parent().parent().parent().parent().attr('id').replace('edit-', '');
		console.log(id);
		var name = $('#name-' + id);
		var desc = tinyMCE.get('desc-' + id);
		var parent = $(this).parent().parent().parent().parent();
		var tag_name_li = $('ul#tag-' + id).children('.tag_name').children('.edit');
		var tag_desc_li = $('ul#tag-' + id).children('.tag_desc');
	
		$.ajax({
			dataType: 'json',
	  		type: 'post',
      		url: '?page=manage_tags',
      		data: {
				"tag_name" : name.val(),
				"desc": desc.getContent(),
				"tag_id": id,
				"submit": true,
				"ajax": true
				},
			beforeSend: function () {
				parent.slideToggle(300);
			},
			success: function (j) {
				desc.setContent(j.desc);
				name.val(j.name);
				tag_name_li.html(j.name);
				tag_desc_li.html(j.desc);
				
			}
		});
		
	});
});