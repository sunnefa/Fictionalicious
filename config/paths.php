<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 11.02.2011

/*
*	This is config/paths.php. It defines folder paths as constants for easier use.
*/

//define the directory separator
define('DS', DIRECTORY_SEPARATOR);

//set the root directory
define('ROOT', dirname(dirname(__FILE__)) . DS);



/*
* COMMON DIRECTORIES
*/

//the config directory path
define('CONFIG_DIR', ROOT . 'config' . DS);

//define the cache directory path
define('CACHE_DIR', ROOT . 'cache' . DS);

//the functions directory path
define('FUNC_DIR', CONFIG_DIR . 'functions' . DS);

//the uploads directory path
define('UPLOADS', ROOT . 'uploads' . DS);

//theme directory name
define('THEME_DIR', ROOT . 'themes' . DS);


/*
* FRONT END DIRECTORIES
*/

//the application directory path
define('APPLICATION', ROOT . 'application' . DS);

//pages directory name
define('PAGES_DIR', APPLICATION . 'pages' . DS);

//controller directory name
define('CONTROLLER_DIR', APPLICATION . 'controllers' . DS);

//data directory name
define('DATA_DIR',  APPLICATION . 'data' . DS);



/*
* ADMIN DIRECTORIES
*/

//define the site directory path
define('ADMIN_SITE_DIR', APPLICATION . 'site' . DS);

//pages directory name
define('ADMIN_PAGES_DIR', PAGES_DIR . 'admin' . DS);

//controller directory name
define('ADMIN_CONTROLLER_DIR', CONTROLLER_DIR . 'admin' . DS);

//data directory name
define('ADMIN_DATA_DIR',  DATA_DIR . 'admin' . DS);

?>