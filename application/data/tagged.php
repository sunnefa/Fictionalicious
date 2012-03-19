<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/tagged.php
*	Holds the CRUD for the tagged table
*/

/**
 * Adds the relationship between stories and tags
 * @param $tagid - the tag id
 * @param $storyid - the story id
 * returns boolean
 */
function add_story_tag_relation($tagid, $storyid) {
	$query = "INSERT INTO " . PREFIX . "_tagged (tagid, storyid) VALUES ($tagid, $storyid)";
	$insert = mysql_query($query);
	if(!$insert) {
		fic_error("Could not add tag-story relationship", mysql_error(), __FILE__, __LINE__);	
	}
	return true;
}

/**
 * Deletes the relationship between stories and tags
 * @param $tagid - the tag id
 * @param $storyid - the story id
 * returns boolean
 */
function delete_story_tag_relation($tagid, $storyid) {
	$sql = "DELETE FROM " . PREFIX . "_tagged WHERE tagid = $tagid AND storyid = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		log_errors("Could not delete tag-story relationship", mysql_error() . $sql, __FILE__, __LINE__);	
	}
	return $sql;
}

/**
 * Checks if there is a relation between a story and a tag
 * @param $tagid - the id of the tag to check against
 * @param $storyid - the id of the story to check against
 * return the number of results
*/
function check_story_tag_relation($tagid, $storyid) {
	$sql = "SELECT tagid FROM " . PREFIX . "_tagged WHERE tagid = $tagid AND storyid = $storyid";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not select tag-story relationship", mysql_error(), __FILE__, __LINE__);	
	}
	return mysql_num_rows($query);	
}

/**
 * Deletes all tag-story relationships with the given storyid
 * @param $storyid - the id of the story to check against
 * returns boolean
*/
function delete_all_by_story($storyid) {
	$sql = "DELETE FROM " . PREFIX . "_tagged WHERE storyid = $storyid";
	$query = mysql_query($sql);
	if(!$query) fic_error("Could not delete tag-story relationships", mysql_error(), __FILE__,__LINE__);	
	return true;
}

/**
 * Deletes all tag-story relationships with the given tagid
 * @param $tag_id - the id of the tag to check against
 * returns boolean
*/
function delete_all_by_tag($tag_id) {
	$sql = "DELETE FROM " . PREFIX . "_tagged WHERE tagid = $tag_id";
	$query = mysql_query($sql);
	if(!$query) fic_error("Could not delete tag-story relationships", mysql_error(), __FILE__, __LINE__);
	return true;	
}
?>