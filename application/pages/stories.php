<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.02.2011

/*
*	This is application/pages/stories.php
*/
?>

    
<div class="story">
    <p class="story_title">
    <?php echo $story['title']; ?>
    </p>
    
    <p class="story_description">
        <?php echo $story['description']; ?>
    </p>
    
    <p class="story_info">
        Added on <?php echo $story['date']; ?> by <?php echo $story['username']; ?>
        &nbsp;&ndash;&nbsp;
        <span class="italic"><?php echo $story['status']; ?></span>
        &nbsp;&ndash;&nbsp;
        <?php echo $story['views']; ?>
        &nbsp;&ndash;&nbsp;
        <span class="italic"><?php echo $story['words']; ?></span>
        &nbsp;&ndash;&nbsp;
        <?php echo $story['chapters']; ?> chapters
        <span class="break"></span>
    	Tags: <?php echo $story['tags']; ?>
    </p>
</div>