<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.02.2011

/*
*	This is application/controllers/static.php
*/

switch($page) {
	case 'date':
	case 'a-z':
	case 'views':
		switch($page) {
			case 'date': $page_title = "Latest stories"; $sort = 's.timestamp'; break;
			case 'a-z': $page_title = "A - Z"; $sort = 'title'; break;
			case 'views': $page_title = "Most viewed"; $sort = 'views'; break;
		}
		
		include DATA_DIR . 'stories.php';
		//get the current page
		$current_page = (isset($queries[1])) ? str_replace("page", "", $queries[1]) : 1;
		
		//get the total number of stories
		$total_results = get_num_stories("WHERE s.status != 'no-chapters'");
				
		//determine the direction of the sort (ASC or DESC)
		$direction = direction($sort);
		
		//get the pagination results back
		$pagination = pagination($current_page, "$page/page", $total_results);
		
		//fetch the stories
		$stories = get_stories($pagination['start'], "WHERE s.status != 'no-chapters'", $sort, $direction);
		include PAGES_DIR . 'storylist.php';
		break;		
			
			
	case 'tags':
		$page_title = "Tag cloud";
		include DATA_DIR . 'tags.php';
		$tags = get_tag_list("RAND()", "WHERE s.status != 'no-chapters'");
		include PAGES_DIR . 'tags.php';
		break;
		
	case 'users':
		$page_title = "Users";
		include DATA_DIR . 'users.php';
		$users = get_users("WHERE u.status != 'inactive'");
		include PAGES_DIR . 'users.php';
		break;
}



?>