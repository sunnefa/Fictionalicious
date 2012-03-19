<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is config/functions/login.php
*/

//check if the username and password are valid
function check_user($username, $password) {
	$referrer = $_SESSION['referrer'];
	
	
	
	$username = sanitize($username);
	$password = md5($password);
	$sql = mysql_query("SELECT password, status, level, id FROM " . PREFIX . "_users WHERE username = '$username' LIMIT 1");
	$pass = mysql_fetch_row($sql);
	
	//if no rows were returned the user doesn't exist
	if(mysql_num_rows($sql) < 1) {
		header("Location: ?error=1");	
	}
	
	//if the inputed password and the expected password don't match
	elseif($pass[0] != $password) {
		if(!isset($_SESSION['try'])) $_SESSION['try'] = 1;
		if(isset($_SESSION['try'])) {
			$_SESSION['try'] = $_SESSION['try']+1;
			
			if($_SESSION['try'] >= 4) {
				unset($_SESSION['try']);
				locked_user($pass[3]);	
			}
			else {
				header("Location: ?error=2");
			}
		}
	}
	
	//if the user's level is not set to active the user can't login
	elseif($pass[1] != 'active') {
		header("Location: ?error=3");	
	}
	
	//if it's all good we redirect the user to the dashboard
	else {
		$_SESSION['username'] = $username;
		$_SESSION['level'] = $pass[2];
		redirect(str_replace('?page=', '',$referrer));	
	}
}

//checks if a user is logged in
function check_login() {
	if(isset($_SESSION['username'])) {
		return true;
	}
	else {
		return false;
	}
}

//show the login form
function login_form() {
	//if the form has not been submitted
	if(!isset($_POST['submit'])) {
		
		$page = (isset($_GET['page'])) ? $_GET['page'] : 'dash';
		if(!isset($_SESSION['referrer'])) $_SESSION['referrer'] = $page;
		
		//if an error has been sent
		if(isset($_GET['error'])) {
			switch ($_GET['error']) {
				case 1:
					$error = 'That username was not found';
				break;
				case 2:
					$error = 'Wrong password';
				break;
				case 3:
					$error = 'That username is not active';
				break;
			}
		}
		if(isset($_POST['reset'])) {
			reset_user($_POST['id']);
			return;	
		}
		//include the form
		include ADMIN_PAGES_DIR . 'login.php';
	}
	//if the form has been submitted we check the user
	else {
		check_user($_POST['username'], $_POST['password']);	
	}
}

function locked_user($id) {
	include DATA_DIR .'users.php';
	$lock = lock_user($id);
	if(!$lock) $error = "Could not lock user";			
	include ADMIN_PAGES_DIR . 'locked_user.php';
}

function reset_user($id) {
		include DATA_DIR . 'users.php';
		
		//generate a random password
		$new_pass = generate_password();
		
		//update the password in the database
		$reset_pass = update_user_password($new_pass['enc_pass'], $id);
		
		//update the user's status
		$update_status = activate_user($id);
		
		//get some info about the user so we can email them
		$user_info = get_user_info($id);
		
		//email the user the new unencrypted password
		$send_email = new_password_email($user_info['email'], $user_info['username'], $new_pass['pass']);
		
		$sent = true;
		
		include ADMIN_PAGES_DIR . 'locked_user.php';

	
}
?>