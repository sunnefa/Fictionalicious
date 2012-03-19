<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 06.03.2011

/*
*	This is application/pages/admin/update_story.php
*/

?>
<?php if(isset($_GET['update'])): ?>
<h1><?php echo $page_title; ?></h1>
<p><a href="<?php echo URL_TO; ?>admin/?page=stories">Back to story list</a></p>
<p><a href="<?php echo URL_TO; ?>admin/?page=add_chapter&story=<?php echo $_GET['update']; ?>">Add chapter</a></p>
<?php if(isset($success) && !empty($success)): ?>
	<?php foreach($success as $succ): ?>
    	<p><?php echo $succ; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<?php if(isset($errors) && !empty($errors)): ?>
	<?php foreach($errors as $error): ?>
    	<p style="color:#f00;"><?php echo $error; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>
<?php include ADMIN_PAGES_DIR . 'story_form.php'; ?>