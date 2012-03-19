<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.11

/*
*	This is config/functions/errors.php
*/

/**
 * Handles all errors
 * @param $type - the type of error
 * @param $msg - the error message
 * @param $file - the file the error occurred in
 * @param $line - the line the error occurred on
 * returns a 404 page
*/
function fic_error($type, $msg, $file, $line) {	
	//write to the error log file
	log_errors($type,$msg,$file,$line);
	
	//delete the output buffer but suppress error messages in case it's empty
	@ob_end_clean();
	
	//the message to display to the user.
	$content = <<<EOT
		<h1>404 Not found</h1>
		<p>The page you are looking for does not exist</p>
		<p>Please go back and select another link</p>	
EOT;
	
	if(!defined('ADMIN_MODE')) {
		//load the theme
		$theme = load_theme();
		
		//set the title
		$theme = str_replace('{TITLE}', '404 Not found &mdash; ' . TITLE, $theme);
		
		//add the menu
		$theme = str_replace('{MENU}', load_menu(CONTROLLER_DIR . "menu.php"), $theme);
		
		//add the content
		$theme = str_replace('{CONTENT}', $content, $theme);

		//output the theme
		echo $theme;
	}
	else {
		$page = "";
		$menu = load_admin_menu();
		$page_title = '404 Not found';
		include(ADMIN_SITE_DIR . 'index.php');	
	}
	//exit the script so nothing more will be executed
	exit;	
}

/**
 * Logs all errors
 * @param $type - the error type
 * @param $msg - the error message
 * @param $file - the file the error occurred in
 * @param $line - the line the error occurred on
 * returns unknown
*/
function log_errors($type, $msg, $file, $line) {
	// define the log file
	$error_file = "error.log"; 
	
	//get the error message into a string
	$error = "Date: " . date("d-m-Y H:i:s", time()) . "\n";
	$error .= "Error type: $type\n";
	$error .= "Error message: $msg\n";
	$error .= "Script: $file\n";
	$error .= "Line $line\n\n";
	
	//write the error message to the log file
	error_log($error, 3, $error_file);	
}
?>