<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.02.2011

/*
*	This is index.php. All requests are made through this page
*/

//check if the script is installed and if it is not redirect to the install file
if(!file_exists('.INSTALLED')) header("Location: " . str_replace('index.php', 'install.php', $_SERVER['PHP_SELF']));

//we need to initialize the script. initialize.php includes all other neccessary settings and functionc files
if(!include('config/initialize.php')) {
	die('An error occured when initializing the script. This error happenend in index.php on line' . __LINE__ . '. If you are the administrator please go to the Fictionalicious <a href="http://www.fictionalicious.com/forum" target="_blank">forums</a> and report the error.');
}

//we start a session
session_start();

//parse the url requested so we can load the right page
$queries = url_parser();

//we need to check if a page has been requested
if(!empty($queries)) {
	$page = $queries[0];	
}
//if a page hasn't been requested we set the $page variable to the default start page which is latest stories
else {
	$page = 'date';	
}

//get the contents
$content = cache_check($page, $queries);

//append the version number
$content .= "<!-- Fictionalicious v. 0.9 -->";

//if an admin page was not requested we do the power check
if($page != 'admin') echo power_check($content);	

//if it was an admin page we don't need the power check
else echo $content;
?>