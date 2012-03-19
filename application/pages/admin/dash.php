<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is admin/pages/dash.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p>Welcome <?php echo $_SESSION['username']; ?></p>
<p>You have added <?php echo $num_stories; ?> stories, would you like to add some more?</p>