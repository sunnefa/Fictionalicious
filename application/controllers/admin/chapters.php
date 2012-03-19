<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is application/controllers/admin/chapters.php
*/

//include the necessary datafiles
include DATA_DIR . 'chapters.php';

//if an id was not supplied or if it was not a number there is an error
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	fic_error("Invalid id", "A story id must be provided to access this page", __FILE__, __LINE__);	
}
//else everything is fine
else {
	$storyid = 	sanitize($_GET['id']);
}

//get the chapters
$get_chapters = get_chapter($storyid, 20);

//set the page variable
$page_title = 'Chapters in ' . $get_chapters[0]['storytitle'];

//include the html template
include ADMIN_PAGES_DIR . 'chapters.php';
?>