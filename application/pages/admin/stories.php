<?php
#Aulior: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is application/pages/admin/stories.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p>Select which story to edit</p>
	<ul class="story_row story_head">
    	<li class="story_list">Title</li>
        <li class="story_list">Date</li>
        <li class="story_list">Chapters</li>
        <li class="story_list">Tags</li>
        <li class="clear"></li>
    </ul>
<?php foreach($get_story as $stories): ?>
<?php //get the old tags
	$old = explode(',', $stories['tags']);
	
	foreach($old as $old_tag) {
		$old[] = trim($old_tag);	
	} ?>
	<ul class="story_row" id="story-<?php echo $stories['id']; ?>">
		<li class="story_list"><a href="?page=update_story&amp;update=<?php echo $stories['id']; ?>" class="edit"><?php echo $stories['title']; ?></a>
			<div class="edit_options">
                <a href="?page=add_chapter&amp;story=<?php echo $stories['id']; ?>">Add chapter</a> -
                <?php if($stories['chapters'] == 0): ?>
                Edit chapters -
                <?php else: ?>
                <a href="?page=chapters&amp;id=<?php echo $stories['id']; ?>">Edit chapters</a> -
                <?php endif; ?>
                <a href="?page=delete_story&amp;delete=<?php echo $stories['id']; ?>" class="delete">Delete</a>
            </div>
        </li>
		<li class="story_list"><?php echo $stories['date']; ?></li>
		<li class="story_list"><?php echo $stories['chapters']; ?> chapters</li>
		<li class="story_list tags"><?php echo $stories['tags']; ?></li>
		<li class="clear"></li>
        <li id="edit-<?php echo $stories['id']; ?>" style="display:none">
       <?php include ADMIN_PAGES_DIR . 'update_story.php'; ?>
        </li>
	</ul>
    
<?php endforeach; ?>
<?php echo $pagination['output']; ?>