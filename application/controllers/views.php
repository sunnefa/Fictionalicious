<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.02.2011

/*
*	This is application/controller/views.php
*/

//set the title of the current page
$page_title = "Most viewed";

//the sort option used in the storylist query
$sort = 'views';

include DATA_DIR . 'storylist.php';

include PAGES_DIR . 'storylist.php';

?>