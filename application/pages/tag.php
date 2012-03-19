<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.02.2011

/*
*	This is application/pages/tag.php
*/
?>

<h1><?php echo $page_title; ?></h1>
<?php if($tag['description']): ?>
<p><?php echo $tag['description']; ?></p>
<?php endif; ?>
<hr />
<p class="pagination"><?php echo $pagination['output']; ?></p>
<?php foreach($stories as $story): ?>
	<?php include PAGES_DIR . 'stories.php'; ?>
<?php endforeach; ?>
<p class="pagination"><?php echo $pagination['output']; ?></p>
