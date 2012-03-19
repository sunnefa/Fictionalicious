<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is application/controllers/admin/static.php
*/

//the more or less static pages (the information changes but you can't change it through these only other pages)
switch($page) {
	
	//if the dashboard was requested
	case 'dash':
		//include the necessary data pages
		include DATA_DIR . 'stories.php';
		include DATA_DIR . 'users.php';
		
		//set the page title
		$page_title = 'Dashboard';
		
		//get the user id
		$userid = get_user_id(sanitize($_SESSION['username']));
		
		//get the number of stories they have written
		$num_stories = get_num_stories("WHERE authorid = $userid");
		
		break;
		
	//if the traffic page was requested
	case 'traffic':
		//include the necessary data pages
		include DATA_DIR . 'stories.php';
		include DATA_DIR . 'chapters.php';
		include DATA_DIR . 'users.php';

		//set the page title
		$page_title = 'Traffic';
		
		//get the userid
		$userid = get_user_id($_SESSION['username']);
		
		//get the stories by that user
		$stories = get_stories(0, "WHERE s.authorid = $userid");
		
		//for each story we need to get the chapters
		foreach($stories as $key => $story) {
			//get the chapters
			$stories[$key]['chapters'] = get_chapter($story['id'], 20);	
		}
		break;
	
	//if the logout page was requested
	case 'logout':
		//set the page title
		$page_title = 'Logout';
		
		//desttroy the session to log the user out
		session_destroy();
		
		break;
}

include ADMIN_PAGES_DIR . $page . '.php';

?>