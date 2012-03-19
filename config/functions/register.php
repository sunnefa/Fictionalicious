<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 23.02.2011

/* This is config/functions/register.php
* It holds the functions used to validate user registrations
*/

//validates the username
function validate_username($username) {
	$username = mysql_real_escape_string(trim($username));
	$message = array();
	
	//check if the given user name exists in the database
	$get_users = mysql_query("SELECT username FROM " . PREFIX . "_users WHERE BINARY username = '$username'");

	//make sure the username is not shorter than 5 characters
	if(strlen($username) < 5 || strlen($username) > 20) {
		$message = array('ok' => 'false', 'msg' => 'Username can not be shorter than 5 characters or longer than 20 characters');
	}
	
	//make sure there aren't any special characters or spaces in the user name
	elseif(preg_match('([^-a-zA-Z0-9_])', $username)) {
		$message = array('ok' => 'false', 'msg' => 'Please use only alphanumeric characters in usernames. Hyphens and underscores are allowed');
	}
	
	//we don't want the username to start with a number or consist of only numbers
	elseif(preg_match('(^[^a-zA-Z_-]{2}[a-zA-Z0-9_-]*?$)', $username)) {
		$message = array('ok' => 'false', 'msg' => 'Username can not start with a number and must have at least one letter');
	}
	
	
	//if any rows were returned it means the username is already taken
	elseif(mysql_num_rows($get_users)) {
		$message = array('ok' => 'false', 'msg' => 'That username is already taken');
	}
	
	//else we go a head and signal success
	else {
		$message = array('ok' => 'true', 'msg' => 'That username is valid');
	}
	
	return $message;	
}

//validate the email address
function validate_email($email) {
	$email = mysql_real_escape_string(trim($email));
	//check if the email exists
	$get_email = mysql_query("SELECT email FROM " . PREFIX . "_users WHERE email = '$email'");
	
	//check if all the expected symbol exist in the string
	if(!preg_match('([-a-zA-Z0-9_\.]+@[-a-zA-Z0-9_\.]+?\.[a-zA-Z\.]{2,6})', $email)) {
		$message = array('ok' => 'false', 'msg' => 'That is not a valid email address');
	}
	
	//check if the above query returned any results
	elseif(mysql_num_rows($get_email)) {
		$message = array('ok' => 'false', 'msg' => 'That email is already registered');
	}
	
	//if none of the aboe is true it's all good
	else {
		$message = array('ok' => 'true', 'msg' => 'That email is valid');	
	}
	
	return $message;	
}

//validate the cofirmation email
function validate_conf_email($email, $conf_email) {
	//if the emails don't match
	if($email != $conf_email) {
		$message = array('ok' => 'false', 'msg' => 'The emails do not match');	
	}
	//if the emails match
	else {
		$message = array('ok' => 'true', 'msg' => 'The emails match');	
	}
	
	return $message;
}

//validate the password
function validate_password($password) {	
	//password must be longer than 8 characters
	if(strlen($password) < 8) {
		$message = array('ok' => 'false', 'msg' => 'The password must be longer than 8 characters');	
	}
	
	//password has to have one uppercase letter
	elseif(preg_match('(^[^A-Z]*$)', $password)) {
		$message = array('ok' => 'false', 'msg' => 'Password must contain at least one uppercase character');	
	}
	
	//has to have one number
	elseif(preg_match('(^[^0-9]*$)', $password)) {
		$message = array('ok' => 'false', 'msg' => 'Password must contain at least one number');		
	}
	
	//has to have one lowercase letter
	elseif(preg_match('(^[^a-z]*$)', $password)) {
		$message = array('ok' => 'false', 'msg' => 'Password must contain at least one lowercase character');		
	}
	//if all is good
	else {
		$message = array('ok' => 'true', 'msg' => 'Password is strong');		
	}
	
	return $message;
}

//validate the cofirmed password
function validate_conf_password($password, $conf_password) {
	//if they don't match
	if($password != $conf_password) {
		$message = array('ok' => 'false', 'msg' => 'The passwords do not match');	
	}
	//if they match
	else {
		$message = array('ok' => 'true', 'msg' => 'The passwords match');	
	}
	
	return $message;
}

function check_old_email($email, $id) {
	$sql = mysql_query("SELECT email FROM " . PREFIX . "_users WHERE id = $id");
	if(!$sql) {
		log_errors("Can't check user email", mysql_error(), __FILE__, __LINE__);
		return 0;
	}
	return mysql_num_rows($sql);
}

//send an email to the email specified
function send_registration_email($username, $email, $id) {
	$title = TITLE;
	$to = $email;
	//we assume that the user with the id 1 is the admin user. That is the user created when the script is installed and it can not be deleted through the admin panel like all the other users
	$from = mysql_fetch_row(mysql_query("SELECT email FROM " . PREFIX . "_users WHERE id = 1"));
	$subject = "Thank you for registering at $title";
	//each line can not be longer than 70 chars so we use \n to break them appart. Because this is an HTML email we also use <br />
	$message = "Thank you for registering at $title!<br />\n
	Please press the link below to activate your account:<br />\n
	<a href=\"" . URL_TO . "activate/$id/\">" . URL_TO . "activate/$id/</a><br /><br />\n
	\n
	We look forward to reading your stories!<br />\n
	Regards,<br />\n
	The $title team
	";
	$headers = "From: {$from[0]}" . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	mail($to, $subject, $message, $headers);
	return true;
}

function new_password_email($user_email, $user_name, $password) {
	$title = TITLE;
	$from = mysql_fetch_row(mysql_query("SELECT email FROM " . PREFIX . "_users WHERE id = 1"));
	$subject = "Your new password at $title";
	$message = "Hi $user_name!\n<br />
	Thank you for requesting a new password at $title\n<br />
	A new random password has been generated for you:\n<br /><br />
	<strong>$password</strong>\n<br /><br />
	You can now log in and change your password to something more memorable.\n<br /><br />
	Regards,\n<br />
	The $title team
	";
	$headers = "From: {$from[0]}" . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	mail($user_email, $subject, $message, $headers);
	return true;
}

function email_username($email, $username) {
	$title = TITLE;
	$from = mysql_fetch_row(mysql_query("SELECT email FROM " . PREFIX . "_users WHERE id = 1"));
	$subject = "Your username at $title";
	$message = "Hi!<br />\n
	You requested that your username at $title be sent to you<br />\n
	Your username is:<br /><br />\n
	<strong>$username</strong><br /><br />\n
	If you have also forgotten your password please \n
	<a href=\"" . URL_TO . "admin/?forgot=pass\">click here</a><br />\n
	Regards,<br />\n
	The $title team
	";
	$headers = "From: {$from[0]}" . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	mail($email, $subject, $message, $headers);
	return true;	
}

?>