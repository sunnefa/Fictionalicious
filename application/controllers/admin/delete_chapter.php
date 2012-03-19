<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 05.03.2011

/*
*	This is application/controllers/admin/delete_chapter.php
*/

//include the necessary files
include DATA_DIR . 'chapters.php';
include DATA_DIR . 'stories.php';

//get the title of the chapter
$chapter_title = get_chapter_name(sanitize($_GET['chapter']));

//if the update button has been pressed
if(isset($_GET['story']) && is_numeric($_GET['story']) && isset($_GET['chapter']) && is_numeric($_GET['chapter'])) {
	$story = sanitize($_GET['story']);
	$chapter = sanitize($_GET['chapter']);
		
	//delete the chapter
	$del_chapter = delete_single_chapter($chapter);
	
	//get the number of chapters left in the story
	$num_chapters = get_num_chapters($story);
	
	//if there are no chapters left
	if($num_chapters == 0) {
		//set the status
		$status = 'no-chapters';
		//update the status in the database
		$update_status = update_status($story, $status);;	
	}
	
	//if the page was accessed through ajax
	if(isset($_GET['ajax'])) {
		//create a message to return
		$message = array('msg' => $chapter_title . ' was successfully deleted', 'story' => $story);
		//encode it for javascript
		echo json_encode($message);
		//halt execution
		exit;
	}
}
//if someone tried to access this page without supplying storyid and chapter it
else {
	fic_error('Invalid query string', 'This page cannot be accessed without specifying a story id and a chapter id', __FILE__, __LINE__);	
}
?>