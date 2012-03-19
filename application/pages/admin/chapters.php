<?php
#Aulior: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	liis is admin/pages/stories.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p>Select which chapter to edit</p>
<p><a href="?page=stories">Back to story list</a></p>
<p><a href="?page=add_chapter&amp;story=<?php echo $storyid; ?>">Add a chapter</a></p>
<p id="mess"></p>
	<ul class="story_row story_head">
    	<li class="story_list">Title</li>
        <li class="story_list">Date</li>
        <li class="story_list">Word count</li>
        <li class="clear"></li>
    </ul>
<?php foreach($get_chapters as $chapter): ?>
	<ul class="story_row" id="chapter-<?php echo $chapter['id']; ?>">
		<li class="story_list"><a href="?page=update_chapter&amp;story=<?php echo $storyid; ?>&amp;chapter=<?php echo $chapter['id']; ?>" class="edit"><?php echo $chapter['title']; ?></a>
			<div class="edit_options" id="story-<?php echo $storyid; ?>"><a href="?page=delete_chapter&amp;story=<?php echo $storyid; ?>&amp;chapter=<?php echo $chapter['id']; ?>" class="delete">Delete</a></div>
        </li>
		<li class="story_list"><?php echo $chapter['date']; ?></li>
		<li class="story_list"><?php echo $chapter['words']; ?></li>
		<li class="clear"></li>
        <li id="edit-<?php echo $chapter['id']; ?>" style="display:none">
       <?php include ADMIN_PAGES_DIR . 'update_chapter.php'; ?>
        </li>
	</ul>
    
<?php endforeach; ?>