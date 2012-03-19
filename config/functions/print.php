<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 17.02.11

/*
*	This is config/print.php. Holds all functions that print something
*/

/**
 * Adds a link with the right class around a tag
 * @param $tag - the tag name
 * @param $count - the number of stories associated with the tag
 * @param $total - the total number to stories
 * returns string
*/
function print_tag_cloud($tag, $count, $total) {
	
	$class = "";
	
	//how many percent the count is of the total number of stories
	$percentage = round(($count / $total) * 100);
	
	if($percentage < 5) {
		$class = "smallest";	
	}
	elseif($percentage >= 5 && $percentage < 20) {
		$class = "small";		
	}
	elseif($percentage >= 20 && $percentage < 40) {
		$class = "medium";	
	}
	elseif($percentage >= 40 && $percentage < 60) {
		$class = "big";	
	}
	elseif($percentage >= 60 && $percentage < 80) {
		$class = "bigger";	
	}
	elseif($percentage > 80) {
		$class = "biggest";	
	}
	
	$output = "<a href='" . URL_TO . "tag/" . add_underscores($tag) . "' class='$class'>$tag</a>&nbsp;&nbsp;";
	return $output;
	
}

/**
 * Adds links around tags in a comma delimited list
 * @param $tags - a comma delimited list of tags
 * returns string
*/
function print_tags($tags) {
	//the output
	$output = "";
	//explode the tags into an array
	$tags = explode(',', $tags);
	//define i to see if the cursor is at the last tag
	$i = 0;
	
	//for each tag
	foreach($tags as $tag) {
		
		//increment i
		$i++;
		
		//if admin mode is defined we change nothing
		if(defined('ADMIN_MODE')) {
			$output .= $tag;	
		}
		
		//if admin mode is not defined we add a link around the tag
		else {
			$output .= '<a href="' . URL_TO . 'tag/' . add_underscores($tag) . '">' . $tag . '</a>';
		}
		//if the cursor is at the last tag or if there is only one tag in the list we don't add a comma
		if(count($tags)	<= 1 || count($tags) == $i) {
			$output .= "";	
		}
		//if it is not at the last tag we add a comma and a space
		else {
			if(defined('ADMIN_MODE')) $output .= ', ';
			else $output .= ",&nbsp;";	
		}
	}
	return $output;
}

/*
 * Appends 'views' to the view count
 * @param $views - the number of views given
 * returns string
*/
function print_views($views) {
	//if there are no views we need to print 'No' instead of nothing or 0
	if(!$views) {
		$output = "No views";	
	}
	//else we print the number of views
	else {
		$output = $views . " views";	
	}
	
	return $output;
}

/*
 * Appends 'words' or 'word' to the number of words
 * @param $words - the number of words given
 * returns string
*/
function print_word_count($words) {
	//if there are no words in the story we need to print 0
	if(!$words) {
		$output = "0 words";	
	}
	elseif($words == 1) {
		$output = $words . " word";	
	}
	//else we print the number of words
	else {
		$output = $words . " words";	
	}
	
	return $output;
}

/**
 * Adds a link around a user name depending on the user profile setting
 * @param $username - the given username
 * returns a string
*/
function print_user($username) {	
	//if userprofiles are turned on we print a link to the profile
	if(USER_PROFILES == 1) {
		$output = "<a href='" . URL_TO . "profile/user/$username'>$username</a>";
	}
	
	//if they're not we just print the name
	else {
		$output = $username;	
	}
	
	return $output;
}

/**
 * Adds a link around the title of a story
 * @param $title - the title of the story
 * @param $id - the id of the story
 * returns string
*/
function print_title($title, $id) {
	if(defined('ADMIN_MODE')) {
		$output = $title;	
	}
	else {
		$output = '<a href="' . URL_TO . 'story/' . $id . '/' . add_underscores($title) . '">' . $title . '</a>';
	}
	return $output;			
}

?>