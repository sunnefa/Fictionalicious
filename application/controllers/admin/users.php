<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/controllers/admin/users.php
*/

if($_SESSION['level'] != 'admin') fic_error("Invalid access", "This user is not an admin and does not have access to this function", __FILE__, __LINE__);

//set the pate title
$page_title = 'Users';

//include the necessary data pages
include DATA_DIR . 'users.php';

//if a delete has been requested
if(isset($_POST['delete'])) {
	
	//include the necessary data pages
	include DATA_DIR . 'stories.php';
	include DATA_DIR . 'chapters.php';
	include DATA_DIR . 'tagged.php';
	
	//the user id
	$user_id = sanitize($_POST['id']);
	
	//the the ids of all the stories this user has written
	$stories = storyids_by_user($user_id);
	if($stories) {
		//foreach story we need to do some tasks
		foreach($stories as $story) {
			
			//delete the story
			$delete_story = delete_story($story);
			if(!$delete_stoy) $message = array('msg' => 'Could not delete story');
			
			//delete all the chapters in the story
			$delete_chapters = delete_chapters($story);
			if(!$delete_chapters) $message = array('msg' => 'Could not delete chapters');
			
			//delete the tag relationships
			$del_tagged = delete_all_by_story($story);
			if(!$del_tagged) $message = array('msg' => 'Could not delete tag-story relationships');		
		}
	}
	//delete the user's upload folder
	$del_upload = delete_upload_folder($user_id);
	if($del_upload) $message = array('msg' => 'Could not delete upload folder');
	
	//delete the user
	$delete_user = delete_user($user_id);
	
	//if  something went wrong
	if(!$delete_user) $message = array('msg' => 'Could not delete user');
	//if everything is fine
	else $message = array('msg' => 'User deleted successfully');
	
	//if the request was made through ajax
	if(isset($_POST['ajax'])) {
		//encode the message for javascript
		echo json_encode($message);
		
		//halt execution
		exit;	
	}
}

//if a lock has been requested
if(isset($_POST['lock'])) {
	$user_id = sanitize($_POST['id']);
	
	//lock the user
	$lock = lock_user($user_id);
	
	//if the lock was unsuccessful
	if(!$lock) $message = array('msg' => 'Could not lock user');
	
	//if everything went smoothly
	else $message = array('msg' => 'locked');
	
	//if the request was made through ajax
	if(isset($_POST['ajax'])) {
		//encode the message for javascript
		echo json_encode($message);
		
		//halt exectution
		exit;	
	}
}

//if a reset has been requested
if(isset($_POST['reset'])) {
	$user_id = sanitize($_POST['id']);
	
	//generate a random password
	$new_pass = generate_password();
	
	//update the password in the database
	$reset_pass = update_user_password($new_pass['enc_pass'], $user_id);
	
	//update the user's status
	$update_status = activate_user($user_id);
	
	//get some info about the user so we can email them
	$user_info = get_user_info($user_id);
	
	//email the user the new unencrypted password
	$send_email = new_password_email($user_info['email'], $user_info['username'], $new_pass['pass']);
	
	//the message to send back to the page
	$message = array('msg' => 'Password has been reset and the user notified', 'status' => 'active');
	
	//encode it for javascript
	echo json_encode($message);
	
	//halt exectution
	exit;	
}

//if activate was requested
if(isset($_POST['activate'])) {
	$user_id = $_POST['id'];
	
	//activate the user
	$activate = activate_user($user_id);
	
	//the message to send back
	$message = array('status' => 'active');
	
	//encode the message
	echo json_encode($message);
	
	//halt execution
	exit;	
}

//get the list of users
$users = get_users();

//include the html template
include ADMIN_PAGES_DIR . 'users.php';

?>