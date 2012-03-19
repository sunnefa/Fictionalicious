<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.02.2011

/*
*	This is application/pages/profile.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<img src="<?php echo URL_TO . $user['avatar']; ?>" style="float:left; margin-right:10px;" />
<p class="story_info italic">Registered since <?php echo $user['date']; ?> - Has written <?php echo $total_results; ?> stories</p>

<?php if($user['bio']): ?>
<p class="story_info"><?php echo $user['bio']; ?></p>
<?php endif; ?>
<div class="clear"></div>
<hr />
<?php if(count($stories) > 0): ?>
	<? foreach($stories as $story): ?>
        <?php include PAGES_DIR . 'stories.php'; ?>
    <?php endforeach; ?>
 	<p class="pagination"><?php echo $pagination['output']; ?></p>
<?php else: ?>
<p>This user has not written any stories</p>
<?php endif; ?>