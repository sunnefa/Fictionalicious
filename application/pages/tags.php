<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.02.2011

/*
*	This is application/pages/tag.php
*/
?>

<h1><?php echo $page_title; ?></h1>
<div class="tags">
	<?php foreach($tags as $tag): ?>
    <?php echo $tag['tag_name']; ?>&nbsp;
    <?php endforeach; ?>
</div>
