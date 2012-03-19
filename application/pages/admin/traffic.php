<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.03.2011

/*
*	This is admin/pages/traffic.php
*/

?>
<h1><?php echo $page_title; ?></h1>
<p>Traffic to your stories</p>
<ul class="story_row story_head">
	<li class="story_list">Title</li>
    <li class="story_list">Views</li>
    <li class="clear"></li>
</ul>
<?php foreach($stories as $story): ?>
<ul class="story_row">
	<li class="story_list bold"><?php echo $story['title']; ?></li>
    <li class="story_list"><?php echo $story['views']; ?></li>
    <li class="clear"><span class="small">Break down by chapters:</span>
    <div class="clear"></div>
    	<?php $i = 0; foreach($story['chapters'] as $chapter): ?>
        <?php if($i % 2 == 0): ?>
        <ul class="normal story_row">
        <?php else: ?>
        <ul class="story_row alternate">
        <?php endif; ?>
        	<li class="story_list"><?php echo $chapter['title']; ?></li>
            <li class="story_list"><?php echo $chapter['views']; ?></li>
            <li class="clear"></li>
        </ul>
        <div class="clear"></div>
        <?php $i++; endforeach; ?>
    </li>
</ul>
<div class="clear"></div>
<?php endforeach; ?>