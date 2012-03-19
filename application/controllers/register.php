<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 19.02.2011

/*
*	This is application/controller/register.php
*/

if(USER_REG) {
	if(isset($_POST['check'])) {
		if ($_POST['check'] == 'username') {
			echo json_encode(validate_username($_POST['username']));
			exit;
		}
		
		if ($_POST['check'] == 'email') {
			echo json_encode(validate_email($_POST['email']));
			exit;
		}	
	}
	elseif(isset($_POST['register'])) {
		$page_title = "Error";
		$valid = array();
		
		$valid_user = validate_username($_POST['username']);
		
		if($valid_user['ok'] != 'true') {
			$_SESSION['message']['error']['username'] = "<p>{$valid_user['msg']}</p>";
			$valid[] = false;	
		}
		else {
			$valid[] = true;	
		}
		
		$valid_email = validate_email($_POST['email']);
		
		if($valid_email['ok'] != 'true') {
			$_SESSION['message']['error']['email'] = "<p>{$valid_email['msg']}</p>";
			$valid[] = false;	
		}
		else {
			$valid[] = true;	
		}
		
		$valid_conf_email = validate_conf_email($_POST['confEmail'], $_POST['email']);
		
		if($valid_conf_email['ok'] != 'true') {
			$_SESSION['message']['error']['confemail'] = "<p>{$valid_conf_email['msg']}</p>";
			$valid[] = false;	
		}
		else {
			$valid[] = true;	
		}
		
		$valid_password = validate_password($_POST['password']);
		
		if($valid_password['ok'] != 'true') {
			$_SESSION['message']['error']['password'] = "<p>{$valid_password['msg']}</p>";
			$valid[] = false;	
		}
		else {
			$valid[] = true;	
		}
		
		$valid_conf_password = validate_conf_password($_POST['confPass'], $_POST['password']);
		
		if($valid_conf_password['ok'] != 'true') {
			$_SESSION['message']['error']['confpassword'] =  "<p>{$valid_conf_password['msg']}</p>";
			$valid[] = false;	
		}
		else {
			$valid[] = true;	
		}
		
		if(in_array(false, $valid)) {
				
		}
		else {
			$username = sanitize($_POST['username']);
			$email = sanitize($_POST['email']);
			$password = md5(sanitize($_POST['password']));
			$time = time();
			
			$add_user = mysql_query("INSERT INTO " . PREFIX . "_users (username, email, password, timestamp) VALUES ('$username', '$email', '$password', '$time')");
			$user_uploads = "uploads" . DS . "1000" . mysql_insert_id();
			mkdir($user_uploads, 0755);	
		
		
			if(send_registration_email($username, $email, mysql_insert_id())) {
				header("Location: " . URL_TO . "register/thankyou");
			}
		}
	}
	
	if(isset($queries[1]) && $queries[1] == 'activate') {
		include DATA_DIR . 'users.php';
		$activate = activate_user($queries[2]);
	}
	
	
	//set the title of the current page
	$page_title = "Register";
	
	if(isset($_SESSION['message']['error'])) $errors = $_SESSION['message']['error'];
	
	include PAGES_DIR . 'register.php';
	
	unset($_SESSION['message']);


} else {
	fic_error("No registration", "Users are not allowed to register. If you want to access this page, please change your settings", __FILE__, __LINE__);	
}
?>