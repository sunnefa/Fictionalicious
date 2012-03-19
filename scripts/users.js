/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.7
Date created: 20.03.2011

*	This is scripts/users.js. Submits deletes, deactivation and locking of users
*/

function del_user() {
	$('a.delete').click(function(e) {
    e.preventDefault();
	var parent = $(this).parent().parent().parent();
	var user_id = parent.attr('id').replace('user-','');
	var conf = confirm("Are you sure you want to delete this user? All stories this user has written will also be deleted");
    if(conf == true) {
		$.ajax({
		  dataType: 'json',
		  type: 'post',
		  url: '?page=users',
		  data: {
			"ajax": true,
			"delete": true,
			"id": user_id
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

function lock_user() {
	$('a.lock').click(function(e) {
    e.preventDefault();
	var elem = $(this);
	var parent = $(this).parent().parent().parent();
	var user_id = parent.attr('id').replace('user-','');
	var status = $('#status-' + user_id);
	var conf = confirm("Are you sure you want to lock this user?");
    if(conf == true) {
		$.ajax({
		  dataType: 'json',
		  type: 'post',
		  url: '?page=users',
		  data: {
			"ajax": true,
			"lock": true,
			"id": user_id
		  },
		  beforeSend: function() {
			  parent.slideUp(300, function () {
			});	
		  },
		  success: function(j) {
			elem.html('Reset password');
			elem.removeClass('lock');
			elem.addClass('pass');
			elem.unbind('click');
			elem.click(function(e) {
				e.preventDefault();
				reset_password();
				});
			status.html(j.msg);
			parent.slideDown(300, function () {
				
			});
		  }
		});
	}
	else {
		window.location.reload();	
	}
  });	
}

function reset_password() {
	$('a.pass').click(function(e) {
    e.preventDefault();
	var elem = $(this);
	var parent = $(this).parent().parent().parent();
	var user_id = parent.attr('id').replace('user-','');
	var status = $('#status-' + user_id);
	$.ajax({
	  dataType: 'json',
	  type: 'post',
	  url: '?page=users',
	  data: {
		"ajax": true,
		"reset": true,
		"id": user_id
	  },
	  beforeSend: function() {
		  parent.slideUp(300, function () {
		});	
	  },
	  success: function(j) {
		  status.html(j.status);
		  elem.html('Lock');
		  elem.removeClass('pass');
		  elem.addClass('lock');
		  elem.unbind('click');
		  elem.click(function(e) {
			e.preventDefault();
			lock_user();
		  });
		  var mess = $('#mess');
		  
		  mess.slideDown(300, function () {
			  mess.html(j.msg);
		  });
		setTimeout(function () {
			mess.slideUp(300);
		}, 3000);
		parent.slideDown(300, function () {
		});
	  }
	});
  });	
}

function activate_user() {
	$('a.activate').click(function(e) {
    e.preventDefault();
	var elem = $(this);
	var parent = $(this).parent().parent().parent();
	var user_id = parent.attr('id').replace('user-','');
	var status = $('#status-' + user_id);
	$.ajax({
	  dataType: 'json',
	  type: 'post',
	  url: '?page=users',
	  data: {
		"ajax": true,
		"activate": true,
		"id": user_id
	  },
	  beforeSend: function() {
		  parent.slideUp(300, function () {
		});	
	  },
	  success: function(j) {
		  status.html(j.status);
		  elem.html('Lock');
		  elem.removeClass('activate');
		  elem.addClass('lock');
		  elem.unbind('click');
		  elem.click(function(e) {
			e.preventDefault();
			lock_user();
		  });
		parent.slideDown(300, function () {
		});
	  }
	});
  });	
}



$(document).ready(function() {
	del_user();
	lock_user();
	reset_password();
	activate_user();

});