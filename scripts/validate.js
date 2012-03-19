/*
Author: Sunnefa Lind
Project: Fictionalicious v. 0.7
Date created: 19.02.2011

*	This is scripts/validate.js. Validates the registration form
*/

var valid = new Array(false, false, false, false, false);
var get_url = window.location.href;
get_url = get_url.replace('register/', '');
var image = '<img src="' + get_url + 'images/ajax-loader.gif" height="11" width="16" />';
var url = window.location.href;
//url = url.replace('register', 'process');

//validate the username
function username() {  
	var validateUsername = $('#usernameMess');
	var t = this; 
    if (this.value != this.lastValue) {
      if (this.timer) clearTimeout(this.timer);
      validateUsername.removeClass('error').html(image);
      
      this.timer = setTimeout(function () {
        $.ajax({
          url: url,
          data: 'check=username&username=' + t.value,
          dataType: 'json',
          type: 'post',
          success: function (j) {
            validateUsername.html(j.msg);
			if(j.ok == 'true') valid.splice(0,1,true);
			if(j.ok == 'false') valid.splice(0,1,false);
          }
        });
      }, 200);
      
      this.lastValue = this.value;
    }	
}

//vaidate the email
function email() {
	var validateEmail = $('#emailMess');
	var t = this; 
	if (this.value != this.lastValue) {
		if (this.timer) clearTimeout(this.timer);
		validateEmail.removeClass('error').html(image);
		
		this.timer = setTimeout(function () {
			$.ajax({
				url: url,
				data: 'check=email&email=' + t.value,
				dataType: 'json',
				type: 'post',
				success: function (j) {
					validateEmail.html(j.msg);
					if(j.ok == 'true') valid.splice(1,1,true);
					if(j.ok == 'false') valid.splice(1,1,false);
				}
			});
		}, 200);
		
		this.lastValue = this.value;
	}	
}

//validate the cofirmation email
function confEmail() {
	var validateConfEmail = $('#confEmailMess');
  	var origEmail = $('#email');
	var t = this; 
    if (this.value != this.lastValue) {
      if (this.timer) clearTimeout(this.timer);
      validateConfEmail.removeClass('error').html(image);
      
      this.timer = setTimeout(function () {
            if(t.value != origEmail.val()) {
				validateConfEmail.html('The emails don\'t match');
				valid.splice(2,1,false);
			}
			else if(t.value == origEmail.val()) {
				validateConfEmail.html('The emails match');
				valid.splice(2,1,true);
			}
      }, 200);
      
      this.lastValue = this.value;
    }	
}

//validate the password
function password() {
	var validatePassword = $('#passwordMess');
	var t = this; 
    if (this.value != this.lastValue) {
      if (this.timer) clearTimeout(this.timer);
      validatePassword.removeClass('error').html(image);
      
      this.timer = setTimeout(function () {
		  if(t.value.length < 8) {
			validatePassword.html('Password must be longer than 8 characters');
			valid.splice(3,1,false);  
		  }
		  else if(t.value.match(/^[^A-Z]*$/)) {
            validatePassword.html('Password must contain at least one uppercase letter');
			valid.splice(3,1,false);
		  }
		  else if(t.value.match(/^[^0-9]*$/)) {
		  	validatePassword.html('Password must contain at least one number');
			valid.splice(3,1,false);
		  }
		  else if(t.value.match(/^[^a-z]*$/)) {
			  validatePassword.html('Password must contain at least one lowecase letter');
			  valid.splice(3,1,false);  
		  }
		  else {
			validatePassword.html('Password is strong');
			valid.splice(3,1,true);  
		  }
      }, 200);
      
      this.lastValue = this.value;
    }	
}

//validate the cofirmation password
function confPass() {
	var validateConfPass = $('#confPassMess');
  	var origPass = $('#password');
	var t = this; 
    if (this.value != this.lastValue) {
      if (this.timer) clearTimeout(this.timer);
      validateConfPass.removeClass('error').html(image);
      
      this.timer = setTimeout(function () {
            if(t.value != origPass.val()) {
				validateConfPass.html('The passwords don\'t match');
				valid.splice(4,1,false);
			}
			else {
				validateConfPass.html('The passwords match');
				valid.splice(4,1,true);	
			}
      }, 200);
      
      this.lastValue = this.value;
    }	
}

function enable() {
	$.each(
		valid,
		function(intIndex, objValue ){
			if(objValue != true) {
				$('#submit_button').attr('disabled', true);
			}
			else {
				$('#submit_button').attr('disabled', false);
			}
		}
	);
}



$(document).ready(function () {	
	var events = 'blur keyup change focus';

	$('#submit_button').attr('disabled', true);
	
	//validate the username
	$('#username').bind(events, username);
	$('#username').bind(events, enable);
	
	//validate the email
	$('#email').bind(events, email);
	$('#email').bind(events, enable);
	
	//validate the confirmation email
	$('#confEmail').bind(events, confEmail);
	$('#confEmail').bind(events, enable);
	
	//validate the password
	$('#password').bind(events, password);
	$('#password').bind(events, enable);
	
	//validate the confirmation password
	$('#confPass').bind(events, confPass);
	$('#confPass').bind(events, enable);
  
});