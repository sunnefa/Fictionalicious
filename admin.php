<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 01.03.2011

/*
*	This is admin.php
*/

//if 'admin.php' was requested we redirect to the pseudo folder admin/
if(preg_match("(admin.php)", $_SERVER['PHP_SELF'])) {
	header("Location: admin/");
}

//we need to tell the script that it is now in admin mode
define('ADMIN_MODE', true);
ob_start();

if(isset($_GET['forgot'])) {
	include ADMIN_CONTROLLER_DIR . 'forgot.php';	
}
elseif(!check_login()) {
	$page_title = 'Login';
	login_form();	
}
else {
	if(!isset($_GET['page'])) {
		$page = 'dash';	
	}
	else {
		$page = $_GET['page'];	
	}
	
	switch($page) {
		default:
			include ADMIN_CONTROLLER_DIR . $page . ".php";
			break;
		case 'dash':
		case 'traffic':
		case 'logout':
			include ADMIN_CONTROLLER_DIR . 'static.php';
			break;	
	}
	
}
$content = ob_get_clean();

$menu = load_admin_menu();
include ADMIN_SITE_DIR . 'index.php';

?>