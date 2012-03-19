<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is controllers/admin/add_story.php
*/


//include the neccessary data files
include DATA_DIR . 'stories.php';
include DATA_DIR . 'tags.php';
include DATA_DIR . 'tagged.php';
include DATA_DIR . 'users.php';

//set the page title
$page_title = 'Add story';

//get the list of tags into a variable
$tags = get_tag_list('tag_name');

//check if the story information has been saved into a session
if(isset($_SESSION['story'])) $story = $_SESSION['story'];
//check if any errors have been saved into a session
if(isset($_SESSION['message']['error'])) $errors = $_SESSION['message']['error'];


//include the html template
include ADMIN_PAGES_DIR . 'add_story.php';

//unset the session message and story
unset($_SESSION['message']);
unset($_SESSION['story']);

//if the story form was submitted
if(isset($_POST['submit'])) {
	//sanitize the description
	$desc = sanitize($_POST['desc']);
	//sanitize the title
	$title = sanitize($_POST['title']);
	//the tags
	$tags = (isset($_POST['tags'])) ? $_POST['tags'] : array();
	
	//add the input from the for to the session so we can display it again when we reload the page on error
	$_SESSION['story']['description'] = $desc;
	$_SESSION['story']['title'] = $title;
	$_SESSION['story']['tags'] = $tags;

	//determines if we can add the story or not
	$can_add = array();
	
	//if the description is empty there is an error
	if(empty($desc)) {
		$_SESSION['message']['error']['description'] = "You must write a description for your story";
		redirect('add_story');
		$can_add[] = false;
	}
	//if the title is empty there is an error
	if(empty($title)) {
		$_SESSION['message']['error']['title'] = "You must write a title for your story";
		redirect('add_story');
		$can_add[] = false;
	}
	
	//if the form wasn't empty we can go a head and add the story
	if(!in_array(false, $can_add)) {
		//get the users id
		$userid = get_user_id($_SESSION['username']);
		
		//get the current time
		$timestamp = time();
		
		//add the story and get its id back
		$storyid = add_story($desc, $title, $userid, $timestamp);
		
		//if it wasn't added there is an error
		if(!$storyid) $_SESSION['message']['error']['story'] = "Could not add the story to the database";
		
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
		
		//for each tag we add it to the database and add a relationship with the story
		foreach($tags as $tag) {
			
			//add the tag and get its id back
			$tagid = add_tag($tag);
			//if it wasn't added there is an error
			if(!$tagid) $_SESSION['message']['error']['tags'] = "Could not add tag to the database";
			
			//add the tag-story relationship
			$add_tag_story = add_story_tag_relation($tagid, $storyid);
			//if it wasn't added there is an error
			if(!$add_tag_story) $_SESSION['message']['error']['tag_story'] = "Could not add tag-story relationship";
		}
		
		//if everything is fine we signal success
		$_SESSION['message']['success']['story_added'] = "Story added successfully";
		
		//redirect to the update story page so the user can update the story if they want to
		redirect("update_story&update=$storyid");
	}
}

?>