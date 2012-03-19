<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is application/pages/admin/forgot.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<?php if(isset($success)): ?>
	<?php foreach($success as $succ): ?>
		<p><?php echo $succ; ?></p>
	<?php endforeach; ?>
<?php endif; ?>
<?php if(isset($errors)): ?>
	<?php foreach($errors as $error): ?>
		<p><?php echo $error; ?></p>
	<?php endforeach; ?>
<?php endif; ?>

<?php if($_GET['forgot'] == 'user'): ?>
<p>If you have forgotten your username, please enter your email below and your username will be sent to you</p>
<form action="" method="post">
	<ul>
    	<li><label for="email">Email address</label><input type="text" name="email" id="email" /></li>
		<li><input type="submit" class="submit" value="Submit" name="username" /></li>
    </ul>
</form>
<p>If you have forgotten your password please <a href="?forgot=pass">click here</a></p>


<?php elseif($_GET['forgot'] == 'pass'): ?>
<p>If you have forgotten your password, please enter your username and a new password will be emailed to you</p>
<form action="" method="post">
	<ul>
    	<li><label for="username">Username</label><input type="text" name="username" id="username" /></li>
		<li><input type="submit" class="submit" value="Submit" name="password" /></li>
    </ul>
</form>
<p>If you have forgotten your username please <a href="?forgot=user">click here</a></p>
<?php endif; ?>
<p><a href="<?php echo URL_TO; ?>admin/">Login</a></p>