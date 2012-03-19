<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is application/pages/admin/login.php
*/
?>
<h1>Login</h1>
<p>Please login with your username and password</p>
<?php if(isset($error)): ?>
<p><?php echo $error; ?></p>
<?php endif; ?>
<form action="" method="post" class="login">
    <ul>
        <li><label for="username">Username</label>
        <input id="username" name="username" class="login" type="text" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" /></li>
        
        <li><label for="password">Password</label>
        <input id="password" class="login" name="password" type="password" /></li>        
        
        <li class="center"><input type="submit" class="submit" name="submit" value="Login" /></li>
    </ul>
</form>
<p><a href="?forgot=pass">I forgot my password</a>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<a href="?forgot=user">I forgot my username</a></p>