<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.03.2011

/*
*	This is application/pages/admin/update_chapter.php
*/

?>
<?php if(isset($_GET['chapter'])): ?>
    <h1><?php echo $page_title; ?></h1>
    <p><a href="<?php echo URL_TO; ?>admin/?page=chapters&amp;id=<?php echo $_GET['story']; ?>">Back to chapter list for <?php echo $story_title; ?></a></p>
    <p><a href="<?php echo URL_TO; ?>admin/?page=add_chapter&amp;story=<?php echo $_GET['story']; ?>">Add another chapter</a></p>
    <?php if(isset($success) && !empty($success)): ?>
		<?php foreach($success as $succ): ?>
        	<p><?php echo $succ; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
<?php include ADMIN_PAGES_DIR . 'chapter_form.php'; ?>