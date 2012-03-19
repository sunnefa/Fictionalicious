<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 02.03.2011

/*
*	This is admin/pages/add_story.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<?php if(isset($errors) && !empty($errors)): ?>
<p>The following errors occured</p>
<?php foreach($errors as $error): ?>
<p style="color:#f00;"><?php echo $error; ?></p>
<?php endforeach; ?>
<?php endif; ?>
<?php include ADMIN_PAGES_DIR . 'story_form.php'; ?>