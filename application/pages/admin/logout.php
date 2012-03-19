<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is application/pages/admin/logout.php
*/

?>
<h1><?php echo $page_title; ?></h1>
<p>You have been successfully logged out.</p>
<p>Redirecting in 5 seconds</p>
<?php header("Refresh:5; url=" . URL_TO . "admin/"); ?>