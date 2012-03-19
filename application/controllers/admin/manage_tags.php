<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.03.2011

/*
*	This is application/controllers/admin/manage_tags.php
*/

if($_SESSION['level'] != 'admin') fic_error("Invalid access", "This user is not an admin and does not have access to this function", __FILE__, __LINE__);

//include the neccesary data files
include DATA_DIR . 'tags.php';
include DATA_DIR . 'tagged.php';

//if the update button has been pressed
if(isset($_POST['submit'])) {
	$tag_name = sanitize($_POST['tag_name']);
	$tag_desc = sanitize($_POST['desc']);
	$tag_id = sanitize($_POST['tag_id']);
	
	//update the tag
	$update = update_tag($tag_name, $tag_desc, $tag_id);
	
	//if the request came through ajax
	if(isset($_POST['ajax'])) {
		//a message to send
		$message = array('desc' => $tag_desc, 'name' => $tag_name);
		//encode it for javascript
		echo json_encode($message);
		//halt execution
		exit;
	}
}

//if the delete button was pressed
if(isset($_POST['delete'])) {
	$tag_id = sanitize($_POST['id']);
	
	//remove the tag
	$remove_tag = delete_tag($tag_id);
	
	//if the tag was successfully removed
	if($remove_tag) {
		//remove any relationships it has with stories
		$remove_relation = delete_all_by_tag($tag_id);
	}	
	
	//if the request was made through ajax
	if(isset($_POST['ajax'])) {
		//a message to send back
		$message = array('mess' => 'Tag deleted');
		//encode it for javascript
		echo json_encode($message);
		//halt execution
		exit;	
	}
}

//set the page title
$page_title = 'Manage Tags';

//get the list of tags
$tags = get_tag_list("t.tag_name ASC");

//include the html template
include ADMIN_PAGES_DIR . 'manage_tags.php';
?>