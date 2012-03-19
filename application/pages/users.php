<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.02.2011

/*
*	This is application/pages/users.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<?php $i = 0; ?>
	<?php foreach($users as $user): ?>
    	<?php if($i == 0): ?>
<ul class="userlist">
		<?php elseif($i % USERS_PER_COL == 0): ?>
</ul><ul class="userlist">
    	<?php endif; ?>
	<li><?php echo $user['username']; ?> <span class="italic">(<?php echo $user['stories']; ?>)</span></li>
	<?php $i++; endforeach; ?>
</ul>
<div class="clear"></div>