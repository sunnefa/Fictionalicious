<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.02.2011

/*
*	This is application/controller/proile.php
*/

if(USER_PROFILES) {

	include DATA_DIR . 'users.php';
	include DATA_DIR . 'stories.php';
	
	$username = $queries[2];
	
	$current_page = (isset($queries[3])) ? str_replace("page", "", $queries[3]) : 1;
	
	$userid = get_user_id($username);
	
	$user = get_user_info($userid);
	
	$total_results = get_num_stories("WHERE s.authorid = $userid AND s.status != 'no-chapters'");
	
	$pagination = pagination($current_page, "profile/user/$username", $total_results);

	$stories = get_stories($pagination['start'], "WHERE s.status != 'no-chapters' AND s.authorid = {$user['id']}");
	
	$page_title = "Profile - " . $username;
	
	include PAGES_DIR . 'profile.php';
}
else {
	fic_error("No profile", "User profiles are not turned on, if you wish to view this page please change your settings", __FILE__, __LINE__);	
}
?>