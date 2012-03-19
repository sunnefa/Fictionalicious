<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.02.2011

/*
*	This is config/initialize.php. This file initializes the script and includes some neccesary files
*/

//include the database connection
include('db.php');

//include the default paths
include('paths.php');

//include the settings
include('settings.php');

//include the error handling function
include(FUNC_DIR . 'errors.php');

//set_error_handler('fic_error');	

//include the basic functions
include(FUNC_DIR . 'basics.php');

//include the print functions
include(FUNC_DIR . 'print.php');

//include the pagination functions
include(FUNC_DIR . 'pagination.php');

//include the theme functions
include(FUNC_DIR . 'theme.php');

//include the registration functions
include(FUNC_DIR . 'register.php');

//include the login functions
include(FUNC_DIR . 'login.php');

//include the upload functions
include(FUNC_DIR . 'upload.php');

//define the mandatory POWER constant
define('POWER', $power_left . '94d9aaa06595d3d75f9584a8ab9aabc9' . $power_right);


?>