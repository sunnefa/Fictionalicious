<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 17.02.2011

/*
*	This is application/data/menu.php
*/

//get the menu items in an array to avoid repeating the html code
$menu = array('date' => 'Latest stories', 'a-z' => 'A &mdash; Z', 'views' => 'Most viewed', 'tags' => 'Tag cloud');

//if user profiles are turned on we want a users item in the array
if(USER_PROFILES) $menu['users'] = 'Users';

//if user registration is turned on we want a register item in the array
if(USER_REG) $menu['register'] = 'Register';

//we want the login link to appear last so we append it after everything else
//if the user is logged in we display the link as Admin
if(check_login()) {
	$menu['admin'] = 'Admin';	
}
//if the user is not logged in we display the link as Login
else {
	$menu['admin'] = 'Login';
}

$is_current = (isset($queries[0])) ? $queries[0] : null;

foreach($menu as $link => $name) {
	$menu[$link] = "<a href=\"" . URL_TO . "$link\">$name</a>";	
}

//we don't want to show the menu separator after the last link so we use $i to know where in the array the pointer is
$i = 1;
?>