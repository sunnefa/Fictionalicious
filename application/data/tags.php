<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/tags.php
*	Holds the CRUD for the tags table
*/

/**
 * Gets a list of tags
 * @param $order - an optional sort order of tags
 * @param $where - an optional where clause
 * returns array
*/
function get_tag_list($order = '', $where = '') {
	//the query
	$sql = "SELECT t.tag_name, t.id, t.description,
			(SELECT COUNT(ta.storyid) FROM " . PREFIX . "_tagged AS ta WHERE ta.tagid = t.id) AS total,
			(SELECT COUNT(s.id) FROM " . PREFIX . "_stories AS s WHERE s.status != 'no-chapters') AS num
			FROM " . PREFIX . "_tags AS t 
			LEFT JOIN " . PREFIX . "_tagged AS ta ON t.id = ta.tagid
			LEFT JOIN " . PREFIX . "_stories AS s ON ta.storyid = s.id $where GROUP BY t.id ORDER BY $order";
	$query = mysql_query($sql);
	
	if(!$query) {
		fic_error("Could not select tags", mysql_error(), __FILE__, __LINE__);	
	}
	
	//get the tags into an array
	$tags = array();
	while($row = mysql_fetch_assoc($query)) {
		//if admin mode is not on, make a link out of each tag and give it a class depending on its story count
		if(!defined('ADMIN_MODE')) $row['tag_name'] = print_tag_cloud($row['tag_name'], $row['total'], $row['num']);
		$tags[] = $row;	
	}
	//return the array
	return $tags;	
}

/**
 * Gets info about a single tag based on its name
 * @param $tag_name - the name of the tag
 * returns array
*/
function get_single_tag($tag_name) {
	$sql = "SELECT t.id, t.description, COUNT(s.id) AS total
		FROM " . PREFIX . "_tags AS t
		JOIN " . PREFIX . "_tagged AS ta ON t.id = ta.tagid
		JOIN " . PREFIX . "_stories AS s ON s.id = ta.storyid
		WHERE tag_name = '$tag_name' AND s.status != 'no-chapters'";
	
	$query = mysql_query($sql);
	
	if(!$query) fic_error("Could not get tag $tag_name", mysql_error() . $sql, __FILE__, __LINE__);
		
	//put the results into an array
	$tag = array();
	while($row = mysql_fetch_assoc($query)) {
		$tag[] = $row;	
	}
	
	//because we only get one set of results we don't need the array to be multidimensional
	$tag = flatten_array($tag); 
	
	//return the array
	return $tag;
}

/**
 * Add tags to the database
 * @param $tag - the tagname
 * returns tag id
 */
function add_tag($tag) {
	//trim whitespace
	$tag = trim($tag);
	//check if the tag exists
	$tag_exists = check_tag_exists($tag);
	//if it does we a relationship with the story
	if(!$tag_exists) {
		$add_tag = mysql_query("INSERT INTO " . PREFIX . "_tags (tag_name) VALUES ('$tag')");
		if(!$add_tag) {
			fic_error("Could not insert tag", mysql_error(), __FILE__, __LINE__);	
		}
		return mysql_insert_id();
	} else {
		return $tag_exists;	
	}
}

/**
 * Checks if a single tag exists in the database
 * @param $tag - the tagname
 * returns boolean or the id of an existing tag
 */
function check_tag_exists($tag) {
	$query = "SELECT id FROM " . PREFIX . "_tags WHERE tag_name = '$tag'";
	$sql = mysql_query($query);
	
	if(!$sql) {
		fic_error("Could not select tag", mysql_error(), __FILE__, __LINE__);	
	}
	if(mysql_num_rows($sql) != 0) {
		$id = mysql_fetch_row($sql);
		return $id[0];
	}
	else return false;
}

/**
 * Updates a single tag
 * @param $tag_name - the name of the tag to be updated
 * @param $tag_desc - the description of the tag
 * @param $id - the id of the tag
 * returns boolean
*/
function update_tag($tag_name, $tag_desc, $id) {
	$sql = "UPDATE " . PREFIX . "_tags SET tag_name = '$tag_name', description = '$tag_desc' WHERE id = $id";
	$query = mysql_query($sql);
	if(!$query) {
		log_errors("Could not update tag", mysql_error() . $sql, __FILE__, __LINE__);
		return false;	
	}
	return true;
}

/**
 * Deletes a single tag
 * @param $tag_id - the id of the tag to be deleted
 * returns boolean
*/
function delete_tag($tag_id) {
	$sql = "DELETE FROM " . PREFIX . "_tags WHERE id = $tag_id";
	$query = mysql_query($sql);
	if(!$query) fic_error("Could not delete tag", mysql_error(), __FILE__, __LINE__);
	return true;
}
?>