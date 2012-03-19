<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.03.2011

/*
*	This is application/controllers/admin/settings.php
*/

//we do not need to include the application/data/settings.php in this file because it is already included in config/settings.php

if($_SESSION['level'] != 'admin') fic_error("Invalid access", "This user is not an admin and does not have access to this function", __FILE__, __LINE__);

//set the page title
$page_title = 'Settings';

//do some preparations for the theme selection
//scan the theme directory for files
$themes = scandir(THEME_DIR);

//remove hidden and dot files
foreach ($themes as $key => $theme) {
	if($theme == "." || $theme == "..") unset($themes[$key]);	
}

//remove the theme directory and the DS from the current theme
$curr_theme = str_replace(THEME_DIR, '', THEME);
$curr_theme = str_replace(DS, '', $curr_theme);

//set what options there are for the cache
$cache = array('none','all','stories');

//check if there are session messages
if(isset($_SESSION['message']['error'])) $errors = $_SESSION['message']['error'];
if(isset($_SESSION['message']['success'])) $success = $_SESSION['message']['success'];

//include the html template
include ADMIN_PAGES_DIR . 'settings.php';

//remove the session message
unset($_SESSION['message']);

//if the update button has been pressed
if(isset($_POST['settings'])) {
	//an array to push the settings into
	$settings = array();
	
	//for every item in the settings array
	foreach($_POST['settings'] as $name => $value) {
		
		//the title cannot be empty
		if($name == 'site_title' && empty($value)) $_SESSION['message']['error']['title'] = "Title cannot be empty";
		
		//stories per page must be higher than 0
		elseif($name == 'stories_per_page' && $value <= 0) $_SESSION['message']['error']['per_page'] = "Stories per page must be higher than 0";
		
		//the default url must be a valid URL
		elseif($name == 'default_url') {
			if(empty($value) || !preg_match("(http|https)", $value)) {
				$_SESSION['message']['error']['url'] = "Default URL cannot be empty and it must be a valid URL";	
			}
		}
		
		//the cache time out cannot be a negative value
		elseif($name == 'cache_time' && $value < 0) $_SESSION['message']['error']['cache'] = "Cache time cannot be negative";
		
		//users per column cannot be a negative value
		elseif($name == 'users_per_column' && $value <= 0) $_SESSION['message']['error']['users'] = "Users per column must be higher than 0";
		else {
			//push the settings into an array
			$settings[$name] = sanitize($value);
			
			//remove the update item
			unset($settings['update']);
		}
	}
	
	//for every setting update it to its new value
	foreach($settings as $name => $value) {
		$update = update_settings($name, $value);
	}
	//if the update went all right
	if($update) $_SESSION['message']['success']['settings'] = "Settings updated successfully";
	
	//redirect back to the settings page
	redirect('settings');
}
?>