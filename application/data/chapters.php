<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/chapters.php
*	Holds the CRUD for the chapters table
*/

/**
 * Selects all chapters from the database associated with the given story
 * @param $storyid - the id of the 'parent' story
 * @param $start - the starting position
 * @param $where - allows for additional where clauses
 * returns array
 */
function get_chapter($storyid, $start, $where = '') {
	
	$query = "SELECT 
	c.id, 
	c.title, 
	c.chapter_contents,
	c.views,
	s.title AS storytitle, 
	FROM_UNIXTIME(c.timestamp, '%a %D %b %Y') as date, 
	LENGTH(c.chapter_contents) - LENGTH(REPLACE(c.chapter_contents, ' ', '' )) +1 as words,
	u.username,
	s.description,
	u.avatar,
	GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC) AS tags
	FROM " . PREFIX . "_chapters AS c
	LEFT JOIN " . PREFIX . "_stories AS s ON c.storyid = s.id
	LEFT JOIN " . PREFIX . "_tagged ON s.id = " . PREFIX . "_tagged.storyid
	LEFT JOIN " . PREFIX . "_tags AS t ON t.id = " . PREFIX . "_tagged.tagid 
	LEFT JOIN " . PREFIX . "_users AS u ON s.authorid = u.id 
	WHERE c.storyid = $storyid
	$where
	GROUP BY c.id
	LIMIT $start";
	
	if(!defined('ADMIN_MODE')) {
		$query .= ", 1";	
	}
	
	//the query
	$get_chapter = mysql_query($query) or fic_error("MySQL error", mysql_error(), __FILE__, __LINE__);
	
	//the array holding the chapter contents
	$chapter = array();
	
	//get the chapter contents into the array
	while($row = mysql_fetch_assoc($get_chapter)) {
		
		//add links to the tags
		$row['tags'] = print_tags($row['tags']);
		
		//concatenate 'word' or 'words' to the value depending on what it is
		$row['words'] = print_word_count($row['words']);
		
		//concatenate 'views' to the views depending on the value
		$row['views'] = print_views($row['views']);
		
		//depending on the userprofile setting the username must be a link or not
		$row['username'] = print_user($row['username']);
		
		//convert new lines to paragraphs (a more semantic nl2br() function)
		$row['chapter_contents'] = html_entity_decode($row['chapter_contents']);
		
		//if the chapter doesn't already have p tags we add one to each new line
		if(!preg_match("[</p>]", $row['chapter_contents'])) $row['chapter_contents'] = nl2para($row['chapter_contents'], 'chapter_p');
		
		$chapter[] = $row;	
	}
	
	//because we only get one result we don't need the array to be multidimensional
	if(!defined('ADMIN_MODE')) {
		$chapter = flatten_array($chapter);
	}
	
	//return the chapter
	return $chapter;	
}

/**
 * Gets the number of chapters in a given story
 * @param $storyid - the id of the parent story
 * returns the number of chapters
*/
function get_num_chapters($storyid) {
	$sql = "SELECT COUNT(id) FROM " . PREFIX . "_chapters WHERE storyid = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not get number of chapters", mysql_error(), __FILE__, __LINE__);
	}
	$num = mysql_fetch_row($query);
	return $num[0];
}

/**
 * Gets the title of the given chapter
 * @param $chapterid - the id of the chapter
 * returns the chapter name
*/
function get_chapter_name($chapterid) {
	$sql = "SELECT title FROM " . PREFIX . "_chapters WHERE id = $chapterid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not get number of chapters", mysql_error(), __FILE__, __LINE__);
	}
	$name = mysql_fetch_row($query);
	return $name[0];
}

/**
 * Inserts a new chapter
 * @param $content - the contents of the chapter
 * @param $title - the title of the chapter
 * @param $timestamp - the current time
 * @param $storyid - the id of the parent story
 * returns inserted chapter id
*/
function add_chapter($content, $title, $timestamp, $storyid) {
	$sql = "INSERT INTO " . PREFIX . "_chapters (title, storyid, timestamp, chapter_contents) VALUES ('$title', $storyid, '$timestamp', '$content')";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not add chapter", mysql_error(). "\n" . $sql, __FILE__, __LINE__);	
	}
	return mysql_insert_id();
}

/**
 * Updates a given chapter
 * @param $content - the contents of the chapter
 * @param $title - the title of the chapter
 * @param $chapterid - the chapter id
 * returns boolean
*/
function update_chapter($content, $title, $chapterid) {
	$sql = "UPDATE " . PREFIX . "_chapters SET chapter_contents = '$content', title = '$title' WHERE id = $chapterid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not update chapter", mysql_error(). "\n" . $sql, __FILE__, __LINE__);	
	}
	return true;
}

/**
 * Deletes all chapters associated with a given story
 * @param $storyid - the id of the parent story
 * returns boolean
*/
function delete_chapters($storyid) {
	$sql = "DELETE FROM " . PREFIX . "_chapters WHERE storyid = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not delete chapters", mysql_error(), __FILE__, __LINE__);	
	}
	return true;
}

/**
 * Deletes a single chapter
 * @param $chapterid - the id of the chapter to be deleted
 * returns boolean
*/
function delete_single_chapter($chapterid) {
	$sql = "DELETE FROM " . PREFIX . "_chapters WHERE id = $chapterid";
	$query = mysql_query($sql);	
	if(!$query) {
		fic_error("Could not delete chapter", mysql_error(), __FILE__, __LINE__);	
	}
	return true;
}

/**
 *
 *
 *
*/
function update_chapter_views($chapterid) {
	$sql = "UPDATE " . PREFIX . "_chapters SET views = views + 1 WHERE id = $chapterid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not update chapter views", mysql_error(), __FILE__, __LINE);	
	}
	return true;
}
?>