<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is application/controllers/admin/stories.php
*/

$page_title = 'Stories';

include DATA_DIR . 'stories.php';
include DATA_DIR . 'users.php';
include DATA_DIR . 'tags.php';

//if a page is not set in the URL the current page is 1
if(!isset($_GET['p'])) {
	$current_page = 1;	
}
//if the page is set in the URL and it is numeric we set the $page variable to the page requested in the URL
else {
	$current_page = $_GET['p'];	
}

//get the userid
$userid = get_user_id($_SESSION['username']);

//get the total number of stories by this user
$total_results = get_num_stories("WHERE s.authorid = $userid");

//get the pagination results back
$pagination = pagination($current_page, '?page=stories&p=', $total_results);

//fetch the stories
$get_story = get_stories($pagination['start'], "WHERE s.authorid = $userid");

$tags = get_tag_list('tag_name');

//include the html template
include ADMIN_PAGES_DIR . 'stories.php';

?>