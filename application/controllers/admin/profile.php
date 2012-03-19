<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.03.2011

/*
*	This is admin/controllers/profile.php
*/

//include the necessary data file
include DATA_DIR . 'users.php';

//get the user id
$user_id = (isset($_GET['id']) && $_SESSION['level'] == 'admin') ? $_GET['id'] : get_user_id($_SESSION['username']);

//get the user's information 
$user_info = get_user_info($user_id);

//set the page title
$page_title = "{$user_info['username']} - Profile";

//if there are messages in the session
if(isset($_SESSION['message']['error'])) $errors = $_SESSION['message']['error'];
if(isset($_SESSION['message']['success'])) $success = $_SESSION['message']['success'];

//include the html template
include ADMIN_PAGES_DIR . 'profile.php';

//destroy the session message
unset($_SESSION['message']);

//if the form has been submitted
if(isset($_POST['submit'])) {
	$id = sanitize($_POST['userid']);
	
	//if the email is not empty
	if(!empty($_POST['new_email'])) {
		$new_email = sanitize($_POST['new_email']);
		$old_email = sanitize($_POST['old_email']);
		
		//validate the new email
		$valid = validate_email($new_email);
		//check taht the old email address is valid
		$old_valid = check_old_email($old_email, $id);
		
		//if it's invalid we return the error message
		if(!in_array('true', $valid)) {
			$_SESSION['message']['error']['email_updated'] = $valid['msg'];
		}
		//if it's invalid we return an error message
		elseif($old_valid != 1) {
			$_SESSION['message']['error']['email_updated'] = "The old email does not match the one we have in our database";
		}else {
			//update the email
			$updated = update_email($new_email, $id);
			//if it wasn't updated we return an error message
			if(!$updated) {
				$_SESSION['message']['error']['email_updated'] = "Could not update email address";
			}
			
			//if it was update we return a success message
			$_SESSION['message']['success']['email_updated'] = "Email address updated successfully";
		}
	}
	//if the password is not empty
	if(!empty($_POST['new_password'])) {
		$valid = validate_password($_POST['new_password']);
		$new_pass = md5(sanitize($_POST['new_password']));
		
		//if the new password is not strong enough
		if(!in_array('true', $valid)) {
			$_SESSION['message']['error']['password_updated'] = $valid['msg'];
		}
		//if it is fine we update the user's password
		else {
			$updated = update_user_password($new_pass, $id);
			
			//if something went wrong with updating the user's password
			if(!$updated) {
				$_SESSION['message']['error']['password_updated'] = "Could not update password";	
			}
			
			//if everything went fine with updating the user's password
			$_SESSION['message']['success']['password_updated'] = "Your password has been updated";
		}
	}
	//if the biography is not empty
	if(!empty($_POST['bio'])) {
		$bio = sanitize($_POST['bio']);
		//update the biography
		$update = update_user_bio($bio, $id);
		
		//get the old bio graphy from the user_info variable
		$old_bio = $user_info['bio'];
		
		//if they are the same we don't send a message
		if($bio == $old_bio) {
		}
		//if we couldn't update we send an error
		elseif(!$update) {
			$_SESSION['message']['error']['bio_updated'] = "Could not update biography";
		}
		//if everything went smoothly
		else {
			$_SESSION['message']['success']['bio_updated'] = "Your biogprahy has been updated";
		}
	}
	
	//if the avatar is not empty
	if(!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] == 0) {
		//the string we insert into the database
		$new_name = "uploads/1000" . $id . "/" . $_FILES['avatar']['name'];
		//upload the image
		$upload = upload_avatar($_FILES['avatar'], $id);
		//if the image was not uploaded
		switch($upload) {
			//everything went smoothly with the upload
			case 1:
				//update the database
				$update = update_user_avatar($new_name, $id);
				
				//if update was unsuccessful
				if(!$update) {
					$_SESSION['message']['error']['avatar'] = "Could not update avatar";
				}
				//if the update was successful
				else {
					$_SESSION['message']['success']['avatar'] = "Avatar successfully uploaded";
				}
				break;
			//the folder was not writable
			case 0:
				$_SESSION['message']['error']['avatar'] = "File could not be uploaded. Please make sure the uploads folder is CHMODED to 755";
				break;
			//the file was not an image
			case 2:
				$_SESSION['message']['error']['avatar'] = "Invalid file type. Please upload only images";
				break;
			//the file was larger than 100kb
			case 3:
				$_SESSION['message']['error']['avatar'] = "Invalid file size. Image cannot be larger than 100kb";
				break;
			//the file's dimensions were too large
			case 4:
				$_SESSION['message']['error']['avatar'] = "Invalid dimensions. Image's width or height cannot exceed 100px";
				break;
		}
	}
	
	//if the user's level has been changed
	if(isset($_POST['level'])) {
		$level = sanitize($_POST['level']);
		$old_level = $user_info['level'];
		
		//only update the level if it is different
		if($old_level != $level) {
			//update the user's level
			$update = update_user_level($level, $id);
			
			//if something went wrong
			if(!$update) $_SESSION['message']['error']['level'] = "Could not update user level";
			
			//if everything was fine
			else $_SESSION['message']['success']['level'] = "User level updated successfully";
		}
	}
	
	//if the id is set in the url we redirect to that id's profile
	if(isset($_GET['id'])) redirect('profile&id=' . $_GET['id']);
	
	//else redirect to the normal profile page
	else redirect('profile');
}
?>