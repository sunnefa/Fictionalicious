<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.02.2011

/*
*	This is application/pages/storylist.php
*/
?>

<h1><?php echo $page_title; ?></h1>
<? foreach($stories as $story): ?>
	<?php include PAGES_DIR . 'stories.php'; ?>
<?php endforeach; ?>
<p class="pagination"><?php echo $pagination['output']; ?></p>
