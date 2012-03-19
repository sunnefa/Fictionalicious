<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.03.2011

/*
*	This isapplication/controllers/ admin/update_chapter.php
*/
//include the necessary data files
include DATA_DIR . 'chapters.php';
include DATA_DIR . 'stories.php';

//get the name of the story
$story_title = get_story_name($_REQUEST['story']);

//get the name of the chapter
$chapter_title = get_chapter_name($_REQUEST['chapter']);

//set the page title
$page_title = "Updating $chapter_title in $story_title";

//save the ids of the chapter and the story in variables
$id = sanitize($_REQUEST['story']);
$c_id = sanitize($_REQUEST['chapter']);

//get the chapters	
$chapter = get_chapter($id, 1, "AND c.id = $c_id");

//because we are only expecting one result we flatten the array
$chapter = flatten_array($chapter);

//check if there is a message session
if(isset($_SESSION['message']['success'])) $success = $_SESSION['message']['success'];

//include the html template
include ADMIN_PAGES_DIR . 'update_chapter.php';

//remove the session message
unset($_SESSION['message']);

//if the update button has been pressed
if(isset($_POST['story']) && is_numeric($_POST['story'])) { 
	$story = sanitize($_POST['story']);
	$chapter = sanitize($_POST['chapter']);
	$title = sanitize($_POST['title']);
	$cont = sanitize($_POST['cont']);
	$cont = htmlentities($cont);
	
	//update the chapter
	$update = update_chapter($cont, $title, $chapter);
	
	$_SESSION['message']['success']['chapter'] = "Chapter updated successfully";
	header("Location: ?page=update_chapter&story=$story&chapter=$chapter");
}
//if someone tried to access this page without supplying a story id or chapter id
if(!isset($_REQUEST['story']) || !isset($_REQUEST['chapter'])) fic_error("Invalid query string","This page cannot be accessed without a story id and a chapter id", __FILE__, __LINE__);


?>