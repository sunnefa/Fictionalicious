<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is application/pages/admin/locked_user.php
*/
?><?php if(!isset($sent)): ?>
<h1>Your username has been locked</h1>
<?php if(isset($error)): ?>
<p><?php echo $error; ?></p>
<?php endif; ?>
<p style="color:#f00;">Third strike!</p>
<p>We are terribly sorry but to protect your account it has been locked after you inserted your password wrongly three times</p>
<p>Please click below to request a new password and unlock your account</p>
<p><form action="" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input class="submit" type="submit" name="reset" value="Request password" /></form></p>
<?php else: ?>
<h1>New password sent</h1>
<p>A new password has been generated and emailed to you. You can use that to log in and change your password to something more memorable</p>
<p><a href="<?php echo URL_TO; ?>admin/">Click here to log in</a></p>
<?php endif; ?>
