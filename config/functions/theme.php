<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.11

/*
*	This is config/functions/theme.php
*	Holds all theme functions
*/

/**
 * Loads the contents of the current theme's 'index.html'
 * returns string
*/
function load_theme() {
	//we check if the requested theme has the neccesary index file
	if(file_exists(THEME . "index.html")) {
	//if it's there we load the contents into a variable
	$theme = file_get_contents(THEME . "index.html");	
	}

	//if it's not there we return an error message. 
	else {
		$theme = theme_error();
	}
	return $theme;
}

/*
 * If the current theme's index.html file was not found
 * returns error page (string);
*/
function theme_error() {
	//Because the normal error handling function uses the theme we need to return a new html document, therefore we use the heredoc syntax
	//dirty trick. constants can't be used in heredoc so by putting it in a variable we can use it in the theme error page
		$folder = THEME;
		//the html for the theme error page
		$theme = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Theme error</title>
	</head>
	<body>
		<h1>Theme error</h1>
		<p>The <em>index.html</em> file in the $folder folder was not found. Please make sure it was uploaded correctly.</p>
	</body>
</html>		
EOT;
	return $theme;	
}

/*
 * Loads the main menu
 * returns string
*/
function load_menu() {
	global $queries;
	
	//start a new output buffer
	ob_start();
	
	//include the menu
	include DATA_DIR . 'menu.php';
	include PAGES_DIR . 'menu.php';
	
	//return the contents of the output buffer and clean it's contents
	return ob_get_clean();	
}

/**
 * Loads the content
 * @param $page - the page to be included
 * returns string (the contents of the output buffer)
*/
function load_content($page) {
	//start a new output buffer
	ob_start();
	
	//to be able to use the $page_title variable it must be global
	global $page_title;
	
	global $queries;
	
		switch($page) {
		default:
			$page_included = CONTROLLER_DIR . $page . '.php';
			break;
		case 'admin':
			$page_included = 'admin.php';
			break;
		case 'a-z':
		case 'date':
		case 'views':
		case 'users':
		case 'tags':
			$page_included = CONTROLLER_DIR . 'static.php';
	}

	
	//if the file exists we include it
	if(file_exists($page_included)) {
		include $page_included;
	}
	//if the file doesn't exist we return an error. this is so the viewer can't enter a wrong url
	else {
		fic_error("Error", "The $page controller does not exist", __FILE__, __LINE__ );
	}
	
	//return the contents of the output buffer and clean it's contents
	return ob_get_clean();	
}

/**
 * Initializes the theme
 * @param $page - the page requested
 * returns string
*/
function init_theme($page) {
	
	global $page_title;
	
	//load the theme
	$theme = load_theme();
	
	//load the main menu
	$menu = load_menu();
	
	//load the content
	$content = load_content($page);
	
	//if the page is not admin we replace the tokens with the content
	if($page != 'admin') {
		
	//a string holding the code for the mandatory javascript files+
	$javascript = "<script type='text/javascript' src='" . URL_TO . "scripts/jquery-1.5.min.js'></script>";
	$javascript .= "<script type='text/javascript' src='" . URL_TO . "scripts/validate.js'></script>";
	$javascript .= "</head>";
	
	//replace the {TITLE} token in the theme file with the title. The title is made up of the $page_title variable which changes for every page included and the TITLE constant which is set by the site_title in the settings table
	$theme = str_replace("{TITLE}", $page_title . " &mdash; " . TITLE, $theme);
	
	//replace the {MENU} token with the contents of the second output buffer and clean it. ob_get_clean() gets the contents of the latest output buffer, ie the one we started on line 56
	$theme = str_replace("{MENU}", $menu, $theme);
	
	//replace the {CONTENT} token in the theme file with the contents of the output buffer and clean it
	$theme = str_replace("{CONTENT}", $content, $theme);
	
	$theme = str_replace("{URL}", URL_TO, $theme);
	
	//link the mandatory javascript files. This is done here because the administrator can't be expected to remember the path to them all
	$theme = str_replace("</head>", $javascript, $theme);
	
	//add the mandatory Power link
	$theme = str_replace("</body>", "<div class=\"center small\">" . decode_str(POWER) . "</div></body>", $theme);
	
	return $theme;
	}
	
	//if the page is admin we don't need the theme so we just return the content
	else {
		return $content;	
	}
}

/**
 * Writes to the cache files
 * @param $cache_file - the file to write to
 * @param $content - the content to write to the file
 * returns nothing
*/
function write_cache($cache_file, $content) {						
	// open the cache file for writing
	$file = fopen($cache_file, 'w'); 
	
	// save the contents of output buffer to the file
	fwrite($file, $content);
	
	// close the file
	fclose($file); 	
}

/**
 * Check if cache is enabled and return the different results
 * @param $page - the page requested
 * @param $queries - the query strings
 * returns string (the html contents)
*/
function cache_check($page, $queries) {
	//if caching is turned on we need to set the file to write to
	$cache_file = CACHE_DIR . implode('.', $queries) . '.txt';
	
	//the timeout will be the setting times 60
	$timeout = CACHE_TIME * 60;
	
	//we want to do different things depending on the USE_CACHE setting
	switch(USE_CACHE) {
		
		//if stories are to be cached
		case 'stories':
			//check if a story page was requested, if the cache file was found and wether it's expired
			if(in_array('story', $queries) && file_exists($cache_file) && (time() - $timeout < filemtime($cache_file))) {
				$content = file_get_contents($cache_file);
				return $content;
			}
			//if a story has been requested and the cache file does not exist
			elseif(in_array('story', $queries) && !file_exists($cache_file) || (time() - $timeout > filemtime($cache_file))) {
				$content = init_theme($page);
				$content .= "\n<!-- Cached on " . date('d-m-Y', filemtime($cache_file)) . " -->";
				write_cache($cache_file, $content);				
				return $content;
			}
			
			//if it's a different kind of page
			else {
				return init_theme($page);	
			}
		break;
		
		//if everything is to be cached
		case 'all':
			//if the cache file exists
			if(file_exists($cache_file) && (time() - $timeout < filectime($cache_file))) {
				$content = file_get_contents($cache_file);
				return $content;	
			}
			//if it doesn't
			elseif(!file_exists($cache_file) || (time() - $timeout > filectime($cache_file))) {
				$content = init_theme($page);
				$content .= "\n<!-- Cached on " . date('d-m-Y', time()) . " -->";
				write_cache($cache_file, $content);
				return $content;	
			}
		break;
		
		//if nothing is to be cached
		case 'none':
			return init_theme($page);
		break;
		
		//in case the USE_CACHE setting has been set to 0 or empty
		default:
			return init_theme($page);
	}
}

/**
 * Loads the admin menu
 * returns string
*/	
function load_admin_menu() {	
	//we don't want this to be outputted to the browser until we need it
	ob_start();
	
	//include the menu template
	include ADMIN_DATA_DIR . 'menu.php';
	include PAGES_DIR . 'menu.php';
	
	//return the outout and clean the buffer
	return ob_get_clean();	
}

/**
 * Parses the url requested
 * returns array
*/
function url_parser() {
	//if there is no trailing slash in the url we add it
	if (substr($_SERVER["REQUEST_URI"], -1, 1) != "/") $_SERVER["REQUEST_URI"] .= "/";
	
	//separate the uri into an array by slashes
	$queries = explode("/", $_SERVER["REQUEST_URI"]);
	//remove the first element because it's empty
	array_shift($queries);
	//remove the last element because it's empty
	array_pop($queries);
	
	//separate the default url into an array by slashes
	$paths = explode("/", URL_TO);
	
	//check if any of the items in the $queries array are equal to the items in the $paths array and remove them if they are
	foreach ($queries as $key => $query) {
		foreach($paths as $path) {
			if($query == $path) {
				unset($queries[$key]);	
			}
		}
	}
	
	//to make sure that the indexes are always right, we recalculate them
	$queries = array_values($queries);
	
	return $queries;
}

/**
 * Checks if the power is on
 * @param $content - the content of the page requested
 * returns string
*/
function power_check($content) {
	
	//if the power constant is not defined or we can't find Powered by in the content there is an error
	if(!defined('POWER') || !preg_match("(Powered by)", $content)) {
	
		//we can't use the theme here because this is a fatal error so we use heredoc syntax
		$error = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Error</title>
	</head>
	<body>
		<h1>Error</h1>
		<p>You have removed the mandatory <strong>Powered by Fictionalicious</strong> link. The script will not work until you have restored it.</p>
	</body>
</html>		
EOT;
		//return the error page and stop execution
		return $error;
		exit;	
	}
	//if there was no error everything is fine and we just return the content back to the browser
	else return $content;
}
?>