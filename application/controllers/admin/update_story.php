<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 06.03.2011

/*
*	This is application/controllers/admin/update_story.php
*/

//include the necessary data files
include DATA_DIR . 'stories.php';
include DATA_DIR . 'tags.php';
include DATA_DIR . 'tagged.php';

//if the update button has been pressed or the page has been accessed through ajax
if(isset($_POST['update']) && is_numeric($_POST['update'])) {
	$id = mysql_real_escape_string($_POST['update']);
	$title = sanitize($_POST['title']);
	$desc = sanitize($_POST['desc']);
	
	//if the status is empty we need to set it to no-chapters
	if(!empty($_POST['status'])) $status = strtolower($_POST['status']);
	else $status = 'no-chapters';
	
	//update the story
	$update = update_story($desc, $title, $status, $id);
	if(!$update) $_SESSION['message']['error']['story'] = "Could not update story";
	
	//prepare the old tags
	$old_tags = strtolower(sanitize($_POST['old_tags']));
	$old_tags = explode(',',$old_tags);
	sort($old_tags);
	
	foreach($old_tags as $key => $old_tag) {
		unset($old_tags[$key]);
		$old_tags[] = trim($old_tag);
	}
	
	$tags = $_POST['tags'];
	
	//prepare the new tags
	if(isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
		$new_tags = strtolower(sanitize($_POST['new_tags']));
		$new_tags = explode(',',$new_tags);
		sort($new_tags);
		foreach($tags as $tag) {
			foreach($new_tags as $key => $new) {
				if($new == $tag) {
					unset($new_tags[$key]);	
				}
			}
		}
		foreach($new_tags as $new) $tags[] = $new;
		
	}
	
	
	//process the new tags
	foreach ($tags as $tag) {
		$tag = trim($tag);
		//add the tag and get its id back
		$tagid = add_tag($tag);
		//if it wasn't added there is an error
		if(!$tagid) $_SESSION['message']['error']['tags'] = "Could not add tag to the database";
		//check if the tag has a relationship with the story
		$check_story_tag = check_story_tag_relation($tagid, $id);
		//if it doesn't we add it, if it does we don't need to do anything
		if($check_story_tag == 0) {
			//add the tag-story relationship
			$add_tag_story = add_story_tag_relation($tagid, $id);
			//if it wasn't added there is an error
			if(!$add_tag_story) $_SESSION['message']['error']['tag_story'] = "Could not add tag-story relationship";
		}
	}
	//if there are differences between the old tags and the new tags
	$difference = array_diff($old_tags, $tags);
	//process the old tags
	foreach($difference as $diff) {
		$_SESSION['message']['error']['tags'] = $diff;
		$diff = trim($diff);
		//check if the tag exists (in case it's been deleted accidentally)
		$tagid = check_tag_exists($diff);
		if(!$tagid) $_SESSION['message']['error']['tag_story'] = "Could not select tag";
		//delete the story tag relation ship
		$delete =  delete_story_tag_relation($tagid, $id);
		if(!$delete) $_SESSION['message']['error']['tag_story'] = "Could not delete tag story relationship";	
	}
	
	//if everything was fine we signal success
	$_SESSION['message']['success']['story'] = "Story updated successfully";
	
	//redirect back to the page
	header("Location: ?page=update_story&update=$id");
}

//if update is set through the url
if(isset($_GET['update']) && is_numeric($_GET['update'])) {
	
	//get the id of the story
	$id = sanitize($_GET['update']);
	
	//get the story from the database
	$stories = get_stories('0', "WHERE s.id = $id");
	
	//because we are only expecting one result we need to flatten the array
	$stories = flatten_array($stories);
	
	//get all the tags
	$tags = get_tag_list("tag_name");
	
	//get the old tags
	$old = explode(',', $stories['tags']);
	
	foreach($old as $old_tag) {
		$old[] = trim($old_tag);	
	}
	
	//if there are success message
	if(isset($_SESSION['message']['success'])) $success = $_SESSION['message']['success'];
	if(isset($_SESSION['message']['error'])) $error = $_SESSION['message']['error'];
	
	//set the page title
	$page_title = "Update story - " . $stories['title'];
	
	//include the html template
	include ADMIN_PAGES_DIR . 'update_story.php';
}
//if no id was given there is an error
else {
	fic_error('Invalid story id', 'This page cannot be accessed without specifying a story id', __FILE__, __LINE__);	
}

	//delete the session message
	unset($_SESSION['message']);
	unset($_SESSION['story']);	

?>