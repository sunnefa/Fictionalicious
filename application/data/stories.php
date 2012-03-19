<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/stories.php
*	Holds the CRUD for the stories table
*/

/**
 * Selects all stories from the database based on the given parameters
 * @param $start - the starting position
 * @param $where - allows for additional where clauses
 * @param $sort - the column to order by
 * @param $direction - ascending or descending
 * returns array
 */
function get_stories($start, $where = '', $sort = 'date', $direction = 'ASC') {
	
	$query = "SELECT 
	s.title, 
	FROM_UNIXTIME(s.timestamp, '%a %D %b %Y') as date, 
	s.id,
	s.description, 
	s.status,
	COUNT(s.id) AS total,
	(SELECT COUNT(c.id) FROM " . PREFIX . "_chapters AS c WHERE c.storyid = s.id) AS chapters,
	(SELECT SUM(c.views) FROM " . PREFIX . "_chapters AS c WHERE c.storyid = s.id) AS views,
	(SELECT SUM(LENGTH(c.chapter_contents) - LENGTH(REPLACE(c.chapter_contents, ' ', '' )) +1) FROM " . PREFIX . "_chapters AS c WHERE c.storyid = s.id) AS words,
	(SELECT GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC) FROM " . PREFIX . "_tags AS t JOIN " . PREFIX . "_tagged AS tag ON tag.tagid = t.id WHERE tag.storyid = s.id) AS tags,
	u.username
	FROM " . PREFIX . "_stories AS s
	LEFT JOIN " . PREFIX . "_users AS u ON s.authorid = u.id
    JOIN " . PREFIX . "_tagged AS ta ON s.id = ta.storyid
	$where
	GROUP BY s.id
	ORDER BY $sort $direction
	LIMIT $start";
	
	//if we are in admin mode we want to return 20 results
	if(defined('ADMIN_MODE')) {
		$query .= ", 20";
	}
	//if not we want to use the PER_PAGE setting
	else {
		$query .= ", " . PER_PAGE;	
	}
	
	//the mysql query
	$get_story = mysql_query($query);
	
	//if the query was unsuccessful we throw an error
	if(!$get_story) {
		fic_error("Could not select stories", mysql_error(), __FILE__, __LINE__);	
	}
	
	//make an array out of the results returned
	$stories = array();
	while($row = mysql_fetch_assoc($get_story)) {
		
		//print the tags as links
		$row['tags'] = print_tags($row['tags']);
		
		//concatenate 'word' or 'words' to the word count depending on the value
		$row['words'] = print_word_count($row['words']);
		
		//if userprofiles are turned on this adds a link to the user name
		$row['username'] = print_user($row['username']);
		
		//concatenate 'views' to the views depending on the value
		$row['views'] = print_views($row['views']);
				
		//make the title a link
		$row['title'] = print_title($row['title'], $row['id']);
		
		//print the status with a capital first letter
		$row['status'] = ucwords($row['status']);
		
		$row['description'] = rm_para($row['description']);
		
		$stories[] = $row;	
	}
	//return the array of stories
	return $stories;	
}

/**
 * Adds stories to the database
 * @param $desc - the description of the story
 * @param $title - the title of the story
 * @param $userid - the id of the author
 * @$timestamp - the current time when the function was called
 * return the insert id
*/
function add_story($desc, $title, $userid, $timestamp) {
	//the query
	$query = "INSERT INTO " . PREFIX . "_stories (description, title, authorid, timestamp) VALUES ('$desc', '$title', $userid, '$timestamp')";
	
	$insert = mysql_query($query);
	
	//if the query was unsuccessful we throw an error
	if(!$insert) {
		fic_error("Could not add the story to the database", mysql_error(), __FILE__, __LINE__);	
	}
	//return the insert id of the story
	return mysql_insert_id();	
}

/**
 * Updates stories in the database
 * @param $desc - the story description
 * @param $title - the story title
 * @param $status - the story status
 * @param $storyid - the id of the story
 * returns boolean
*/
function update_story($desc, $title, $status, $storyid) {
	//the query
	$query = mysql_query("UPDATE " . PREFIX . "_stories SET title = '$title', description = '$desc', status = '$status' WHERE id = $storyid");
	
	//if the query was unsuccessful we throw an error
	if(!$query) {
		fic_error("Could not update the story", mysql_error(), __FILE__, __LINE__);	
	}
	return true;	
}

/**
 * Deletes a story from the database
 * @param $storyid - the id of the story
 * returns boolean
*/
function delete_story($storyid) {
	$sql = "DELETE FROM " . PREFIX . "_stories WHERE id = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not delete story", mysql_error(), __FILE__, __LINE__);	
	}
	return true;
}

/**
 * Gets the title of a given story
 * @param $storyid - the id of the story
 * returns the title
*/
function get_story_name($storyid) {
	$sql = "SELECT title FROM " . PREFIX . "_stories WHERE id = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not delete story", mysql_error(), __FILE__, __LINE__);	
	}
	$title = mysql_fetch_row($query);	
	return $title[0];
}

/**
 * Updates the status of a given story
 * @param $storyid - the id of the story
 * @param $status - the new status of the story
 * returns boolean
*/
function update_status($storyid, $status) {
	$sql = "UPDATE " . PREFIX . "_stories AS s SET s.status = '$status' WHERE s.id = $storyid";	
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not update story status", mysql_error(), __FILE__, __LINE__);	
	}
	return true;
}

/**
 * Gets the number of stories by given user
 * @param $where - a where clause to limit the data
 * returns number of stories
*/
function get_num_stories($where) {
	$sql = "SELECT COUNT(id) AS total FROM " . PREFIX . "_stories as s $where";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could get number of stories", mysql_error(), __FILE__, __LINE__);	
	}
	$num = mysql_fetch_row($query);
	return $num[0];	
}

function storyids_by_user($user_id) {
	$sql = "SELECT id FROM " . PREFIX . "_stories WHERE authorid = $user_id";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not get stories by user", mysql_error(), __FILE__, __LINE__);	
	}
	$ids = array();
	while($row = mysql_fetch_row($query)) {
		$ids[] = $row[0];
	}
	return $ids;
}
?>