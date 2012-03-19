<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date create: 01.03.2011

/*
*	This is application/site/index.php
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/jquery-1.5.min.js"></script>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/jquery.color.js"></script>
<?php if($page == 'stories'): ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/edit_story.js"></script>
<?php elseif($page == 'chapters'): ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/edit_chapter.js"></script>
<?php elseif($page == 'settings'): ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/settings.js"></script>
<?php elseif($page == 'manage_tags'): ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/tags.js"></script>
<?php elseif($page == 'users'): ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/users.js"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo URL_TO; ?>scripts/tinymce_init.js"></script>

<link rel="stylesheet" href="<?php echo URL_TO; ?>application/site/style.css" />
</head>

<body>
<div id="header">
	<div class="left">Back to <a href="<?php echo URL_TO; ?>"><?php echo TITLE; ?></a></div>
    <?php if(check_login()): ?>
    	<div class="right">
    		You are logged in as <?php echo $_SESSION['username']; ?>&nbsp; | &nbsp; <a href="?page=logout">Logout</a>
    	</div>
    <?php endif; ?>
    
</div>

<?php if(check_login()): ?>
<div id="container">
	<div id="left-side">
        <?php echo $menu; ?>
    </div>
    
    <div id="content">
        <?php echo $content; ?>
    </div>

</div>
<?php else: ?>
<div id="login_box">
    <?php echo $content; ?>
</div>
<?php endif; ?>
</body>
</html>