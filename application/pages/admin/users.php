<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is admin/pages/dash.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p id="mess"></p>
<ul class="story_head story_row">
<li class="user_list user_id">Id</li>
<li class="user_list">Username</li>
<li class="user_list user_avatar">Status</li>
<li class="user_list user_stories">Stories</li>
<li class="user_list user_avatar">Avatar</li>
<li class="user_list">Bio</li>
<li class="clear"></li>
</ul>
<?php foreach($users as $user): ?>
<ul class="story_row" id="user-<?php echo $user['id']; ?>">
    <li class="user_list user_id"><?php echo $user['id']; ?></li>
    <li class="user_list"><?php echo $user['username']; ?> - <?php echo $user['level']; ?>
    	<?php if($user['id'] == 1): ?>
        <div class="edit_options"><a href="?page=profile&amp;id=1">Edit</a></div>
        <?php else: ?>
        <div class="edit_options"><a href="?page=profile&amp;id=<?php echo $user['id']; ?>">Edit</a> - <a href="#" class="delete">Delete</a> - 
        
        <?php switch($user['status']):
			case 'active': ?>
				<a href="#" class="lock">Lock</a><?php
				break;
			case 'locked': ?>
				<a href="#" class="pass">Reset password</a><?php
				break;
			case 'inactive': ?>
				<a href="#" class="activate">Activate</a><?php
				break;
		endswitch; ?>
        
        </div><?php endif; ?>
    </li>
    <li class="user_list user_avatar" id="status-<?php echo $user['id']; ?>"><?php echo $user['status']; ?></li>
    <li class="user_list user_stories"><?php echo $user['stories']; ?></li>
    <li class="user_list user_avatar"><img src="<?php echo URL_TO . $user['avatar']; ?>" height="30" /></li>
    <li class="user_list small"><?php echo truncate(rm_para($user['bio']), 90); ?></li>
    <li class="clear"></li>
</ul>
<?php endforeach; ?>