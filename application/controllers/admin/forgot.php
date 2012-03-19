<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 23.03.2011

/*
*	This is application/controllers/admin/forgot.php
*/
if(isset($_SESSION['message']['success'])) $success = $_SESSION['message']['success'];
if(isset($_SESSION['message']['error'])) $errors = $_SESSION['message']['error'];

if($_GET['forgot'] == 'user') {
	$page_title = "Forgotten username";
	
	if(isset($_POST['username'])) {
		include DATA_DIR . 'users.php';
		$email = sanitize($_POST['email']);
		$username = get_username_by_email($email);
		if(!$username) {
			$_SESSION['message']['error']['email'] = "We were unable to find your username in our database";
			header("Location: ?forgot=user");
			return;
		}
		else {
			$sendmail = email_username($email, $username);
			$_SESSION['message']['success']['sent'] = "Your username has been sent to you";
			header("Location: ?forgot=user");
			return;
		}
	}
}
elseif($_GET['forgot'] == 'pass') {
	$page_title = "Forgotten password";
	if(isset($_POST['password'])) {
		include DATA_DIR . 'users.php';
		$username = sanitize($_POST['username']);
		
		$user_id = get_user_id($username);
		
		//generate a random password
		$new_pass = generate_password();
		
		//update the password in the database
		$reset_pass = update_user_password($new_pass['enc_pass'], $user_id);
		
		//get some info about the user so we can email them
		$user_info = get_user_info($user_id);
		
		//email the user the new unencrypted password
		$send_email = new_password_email($user_info['email'], $user_info['username'], $new_pass['pass']);
		$_SESSION['message']['success']['sent'] = "A new password has been emailed to you";
		header("Location: ?forgot=pass");
		return;
	}
}

include ADMIN_PAGES_DIR . 'forgot.php';
unset($_SESSION['message']);
?>