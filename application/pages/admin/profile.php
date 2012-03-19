<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.03.2011

/*
*	This is admin/pages/profile.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<?php if(isset($_GET['id'])): ?>
<p>Edit user <?php echo $user_info['username']; ?> - <a href="?page=users">Back to user manager</a></p>
<?php else: ?>
<p>Here you can update your profile</p>
<?php endif; ?>
<?php if(isset($errors) && !empty($errors)): ?>
<p>The following errors occurred when updating your profile</p>
	<?php foreach($errors as $error): ?>
    	<p style="color:#f00;"><?php echo $error; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<?php if(isset($success) && !empty($success)): ?>
	<?php foreach($success as $succ): ?>
    	<p style="color:#00F;"><?php echo $succ; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="userid" value="<?php echo $user_info['id']; ?>"/>
	<ul>
    	<li><label for="old_email">Old email address</label><input type="text" name="old_email" value="<?php echo $user_info['email']; ?>" /></li>
        <li><label for="new_emal">New email address</label><input type="text" name="new_email" /></li>
   <!-- 'autocomplete="off"' is not valid XHTML but prevents certain browsers from asking if the user wants to save the password -->
        <li><label for="new_password">New password</label><input autocomplete="off" type="password" name="new_password" /></li>
        <li><label for="bio">Biography</label><textarea class="description" name="bio" cols="36" rows="10"><?php echo $user_info['bio']; ?></textarea></li>
        <li><label for="avatar">Avatar <div class="small">Max size: 100x100px<img src="<?php echo URL_TO . $user_info['avatar']; ?>" style="float:left; margin-right:10px;" /></div>&nbsp;&nbsp;</label><input type="file" name="avatar" /></li>
        
		<?php if(isset($_GET['id']) && $_SESSION['level'] == 'admin' && $user_info['id'] != 1): ?>
        <li class="clear"></li>
        <li>
        	<label for="level">Level</label>
            <select name="level" id="level">
            <?php if($user_info['level'] == 'admin'): ?>
            	<option selected value="admin">Admin</option>
                <option value="user">User</option>
            <?php else: ?>
                <option value="admin">Admin</option>
                <option selected value="user">User</option>
            <?php endif; ?>
            </select>
        </li>
        <?php endif; ?>
        
        <li class="center"><input type="submit" name="submit" class="submit" value="Update" /></li>
    </ul>
</form>