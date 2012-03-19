<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 05.03.2011

/*
*	This is application/controllers/admin/delete_story.php
*/

//include the necessary data files
include DATA_DIR . 'stories.php';
include DATA_DIR . 'tagged.php';
include DATA_DIR . 'chapters.php';

//if a story id has been submitted for deletion
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
	$id = mysql_real_escape_string($_GET['delete']);
	
	//we want to get the name of the story
	$name = get_story_name($id);
	
	//delete the story from the database
	$del_story = delete_story($id);
	
	//delete the chapters from the database
	$del_chapters = delete_chapters($id);
	
	//delete the tag relationships
	$del_tagged = delete_all_by_story($id);	
	
	//if the page was accessed through ajax
	if(isset($_GET['ajax'])) {
		//the message to send back
		$message = array('msg' => $name . ' was successfully deleted');
		//encode it for javascript
		echo json_encode($message);
		//declare no script as false
		$no_script = false;
		//halt exectution
		exit;
	}
}
//if a story id was not supplied there is an error
else {
	fic_error('Invalid story id', 'This page cannot be accessed without specifying a story id', __FILE__, __LINE__);	
}
?>