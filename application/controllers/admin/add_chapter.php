<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is application/controllers/admin/add_chapter.php
*/

//include the necessary data files
include DATA_DIR . 'chapters.php';
include DATA_DIR. 'stories.php';

//get the story title
$story_title = get_story_name(sanitize($_GET['story']));

//get the number of chapters in the story
$num_chapters = get_num_chapters($_GET['story']);

//set the page title
$page_title = 'Add a chapter to ' . $story_title;

//include the html template
include ADMIN_PAGES_DIR . 'add_chapter.php';

//if the submit button has been pressed
if(isset($_POST['submit'])) {
	$content = htmlentities(sanitize($_POST['cont']));
	$title = sanitize($_POST['title']);
	$story = sanitize($_POST['story']);
	$timestamp = time();
	
	if($num_chapters == 0) {
		$status = 'in-progress';
		$update_status = update_status($story, $status);
	}
	
	//add the chapter and return the id
	$add_chapter = add_chapter($content, $title, $timestamp, $story);
	
	$_SESSION['message']['success']['chapter'] = "Chapter has been added successfully";
	
	
	
	header("Location: ?page=update_chapter&story=$story&chapter=$add_chapter");
}

?>