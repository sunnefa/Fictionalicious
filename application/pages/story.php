<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.2011

/*
*	This is application/pages/story.php
*/
?>

<h1><?php echo $page_title; ?></h1>
<p class="story_info">
    	By <?php echo $chapter_cont['username']; ?>
        &nbsp;&ndash;&nbsp;
    	<span class="italic">Updated <?php echo $chapter_cont['date']; ?></span>
         &nbsp;&ndash;&nbsp;
        <?php echo $chapter_cont['words']; ?>
    </p>
    <p class="story_description"><?php echo $chapter_cont['description']; ?></p>
    <p class="story_info">Tags: <?php echo $chapter_cont['tags']; ?></p>
    <hr />
<p class="pagination"><?php echo $pagination['output']; ?></p>
<div class="chapter">
    <?php echo $chapter_cont['chapter_contents']; ?>
</div>
<p class="pagination"><?php echo $pagination['output']; ?></p>
