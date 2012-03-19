<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 19.02.2011

/*
*	This is application/pages/register.php
*/



?>
<?php if(isset($queries[1])): ?>
	<?php if($queries[1] == 'thankyou'): ?>

<h1><?php echo $page_title; ?> - Thank you!</h1>
<p>Thank you for registering at <?php echo TITLE; ?>. An email has been sent to the email address you provided with instructions on how to activate your account.</p>
<p>The <?php echo TITLE; ?> team</p>
<p><a href="<?php echo URL_TO; ?>">Click here to go back to the home page</a></p>

	<?php elseif($queries[1] = 'activate'): ?>
    
<h1><?php echo $page_title; ?> - Activated!</h1>
<p>Thank you! You account has now been activated, you can now log in <a href="<?php echo URL_TO; ?>admin">here</a></p>

    <?php endif; ?>

<?php else: ?>

<h1><?php echo $page_title; ?></h1>
<p>Use this form to register on <?php echo TITLE; ?></p>
<?php if(isset($errors)): ?>
<?php foreach($errors as $error): ?>
<?php echo $error; ?>
<?php endforeach; ?>
<?php endif; ?>
<p class="italic">All fields are mandatory</p>
<form method="post" onsubmit="return allow_sub()" action="">
    <ul>
        <li>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" />
            <span id="usernameMess"></span>
        </li>
        
        <li>
            <label for="email">Email address</label>
            <input type="text" name="email" id="email" />
            <span id="emailMess"></span>
        </li>
        
        <li>
            <label for="confEmail">Confirm email</label>
            <input type="text" name="confEmail" id="confEmail" />
            <span id="confEmailMess"></span>
        </li>
        
        <li>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" />
            <span id="passwordMess"></span>
        </li>
        
        <li>
            <label for="confPass">Confirm password</label>
            <input type="password" name="confPass" id="confPass" />
            <span id="confPassMess"></span>
        </li>
        
        <li>
            <input type="submit" id="submit_button" name="register" value="Register" />
        </li>
        
    </ul>
</form>

<?php endif; ?>