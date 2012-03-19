<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is admin/application/data/menu.php
*/

//get the menu items in an array to avoid repeating the html code
$menu = array('?page=dash' => 'Dashboard', '?page=add_story' => 'Add story', '?page=stories' => 'Edit stories', '?page=traffic' => 'Traffic');

//if user profiles are turned on we want a profile item in the array
if(USER_PROFILES) $menu['?page=profile'] = 'Profile';

//we only want to show the tag manager and user manager if the user logged in has admin level clearance
if(isset($_SESSION['username'])) {
	if($_SESSION['level'] == 'admin') {
		$menu['?page=manage_tags'] = 'Tag manager';
		$menu['?page=settings'] = 'Settings';
		$menu['?page=users'] = 'Users';
	}
}

//we want the logout link to appear last so we append it after everything else
$menu['?page=logout'] = 'Logout';

$is_current = (isset($_GET['page'])) ? $_GET['page'] : null;

foreach($menu as $link => $name) {
	$menu[$link] = "<a href=\"" . URL_TO . "admin/$link\">$name</a>";	
}
$i = 0;
?>