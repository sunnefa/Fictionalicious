<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 12.03.2011

/*
*	This is install.php
*/
error_reporting(0);
ob_start("output");

/*if(file_exists('.INSTALLED')) {
	echo "Fictionalicious is already installed";
	return;
}
*/
//if the install form has been submitted
if(isset($_POST['install'])) {
	
	//get the values from the form
	//values pertaining to the user
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$email = $_POST['email'];
	$time = time();
	
	//values needed for the settings table
	$table_prefix = $_POST['table_pre'];
	$title = $_POST['title'];
	$url = $_POST['url'];
	
	//values needed for the database connection
	$dbname = $_POST['dbname'];
	$dbuser = $_POST['dbuser'];
	$dbpass = $_POST['dbpass'];
	$dbhost = $_POST['dbhost'];
	
	$installed = array();
	
	//connect to the database
	$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	$database = mysql_select_db($dbname) or die(mysql_error());
	if(!$connect || !$database) $installed['database'] = false;
	else $installed['database'] = true;
	
	//create the tables
	$installed['tables'] = create_tables();
	
	//insert the settings
	$installed['settings'] = add_settings($url, $title);
	
	//create the admin user
	$installed['admin'] = create_admin($username, $email, $password, $time);
	
	//create the admin uploads folder
	$installed['uploads'] = create_uploads_folder();
	
	//write the db connect file
	$installed['config'] = write_db($dbhost, $dbname, $dbuser, $dbpass);
	
	//write the htaccess file
	$installed['htaccess'] = write_htaccess();
	
	//write the hidden installed file
	$installed['installed'] = write_installed();
	
	//check if anything went wrong with the install
	foreach($installed as $key => $install) {
		if($install == false) {
			switch($key) {
				case 'database':
					echo '<p>Could not connect to database</p>';
					break;
				case 'tables':
					echo '<p>Could not create database tables</p>';
					break;
				case 'settings':
					echo '<p>Could not insert settings</p>';
					break;
				case 'admin':
					echo '<p>Could not insert admin user</p>';
					break;
				case 'uploads':
					echo '<p>Could not create uploads folder for admin user</p>';
					break;
				case 'config':
					echo '<p>Could not write database connection file</p>';
					break;
				case 'htaccess':
					echo '<p>Could not write htaccess file</p>';
					break;
				case 'installed':
					echo '<p>Could not write INSTALLED file</p>';
					break;
			}
			$is_installed = false;
			echo '<p>Could not install Fictionalicous. Please delete any tables from your database, the admin uploads folder (if it was created) and make sure that all the required folders are writable, then try again</p>';
		}
	}
	if(!in_array(false, $installed)) $is_installed = true;
	if($is_installed == true) {
		echo '<p>Fictionalicious was successfully installed. Click <a href="' . $url . '/admin/">here</a> to login</p>';	
	}
	
}
//if the install form has not been submitted
else {
	//the default URL
	$_SERVER['PATH_INFO'] = 'http://' . $_SERVER['SERVER_NAME'] . str_replace('install.php', '', $_SERVER['REQUEST_URI']);
	$can_install = array();
	$errors = array();
	
	//do some pre-install checking
	if(!is_writable("config")) {
		$errors[] = "The config folder is not writable";
		$can_install[] = false;	
	}
	if(!is_writable("uploads")) {
		$errors[] = "The uploads folder is not writable";
		$can_install[] = false;	
	}
	$files = file_get_contents("filelist");
	$files = explode("\n", $files);
	foreach($files as $file) {
		if(!file_exists($file)) {
			$errors[] = "$file was not found please make sure it was uploaded correctly";
			$can_install[] = false;
		}
	}
	
	if(!in_array(false, $can_install)) {
?>
<form action="" method="post">
	<ul>
    	<li class="heading">User information<div class="small">Some information about the admin. Please choose the username carefully, it cannot be changed</div></li>
    	<li><label>Username</label><input type="text" name="username" /></li>
        <li><label>Password</label><input type="password" name="password" /></li>
        <li><label>Email</label><input type="email" name="email" /></li>
        <li class="heading">Some settings<div class="small">A few settings. Don't worry you can change these later</div></li>
        <li><label>Title</label><input type="text" name="title" value="Fictionalicious - Story publishing platform" /></li>
        <li><label>URL</label><input type="text" name="url" value="<?php echo $_SERVER['PATH_INFO']; ?>" /> <span class="small">(only change this if you know what you're doing)</span></li>
        <li class="heading">Database information<div class="small">Database settings. You should have recieved this information from your webhost</div></li>
        <li><label>Database table prefix</label><input type="text" name="table_pre" value="fic" /> <span class="small">(change this if you have many installs in the same database)</span></li>
        <li><label>Database host</label><input type="text" name="dbhost" /></li>
        <li><label>Database user</label><input type="text" name="dbuser" /></li>
        <li><label>Database pass</label><input type="text" name="dbpass" /></li>
        <li><label>Database name</label><input type="text" name="dbname" /></li>
        <li class="center"><input class="submit" type="submit" name="install" value="Install" /></li>
    </ul>
</form>
<?
	}
	else { ?><p class=" center">There was an error:</p>
		<?php foreach($errors as $error): ?>
        <p class="center error"><?php echo $error; ?></p>
		<?php endforeach; ?>
        <p class="center">Please correct all errors and try again</p>
<?php }
}

function create_tables() {
	global $table_prefix;
	//prepare the table structure
	$schema = file_get_contents("config/schema");
	$schema = preg_replace("(&pre)", $table_prefix, $schema);
	$schema = explode("&start", $schema);
	
	//create the tables
	foreach($schema as $table) {
		$result = mysql_query($table) or die(mysql_error());
	}
	if(!$result) return false;
	else return true;	
}

function add_settings($url, $title) {
	global $table_prefix;
	//prepare the settings data
	$settings = file_get_contents("config" . DIRECTORY_SEPARATOR . "settings");
	$settings = preg_replace("(&pre)", $table_prefix, $settings);
	$settings = preg_replace("(&def_url)", $url, $settings);
	$settings = preg_replace("(&title)", $title, $settings);
	$settings = explode('&start', $settings);
	
	//create the settings
	foreach($settings as $setting) {
		$result = mysql_query($setting) or die(mysql_error());
	}
	if(!$result) return false;
	else return true;	
}

function create_admin($username, $email, $password, $time) {
	global $table_prefix;
	$sql = "INSERT INTO " . $table_prefix ."_users VALUES (1, '$username', '$email', '$password', 'active', 'admin', '', 'images/profile.jpg', '$time')";
	$query = mysql_query($sql) or die(mysql_error());
	
	if(!$query) return false;
	else return true;
}

function create_uploads_folder() {
	$user_uploads = "uploads" . DIRECTORY_SEPARATOR . "10001";
	
	if(!mkdir($user_uploads, 0755)) return false;
	else return true;		
}

function write_installed() {
	$installed_file = '.INSTALLED';
	
	$write_installed = file_put_contents($installed_file, 'TRUE');
	if(!$write_installed) return false;
	else return true;
	
}

function write_htaccess() {
	$write_base = str_replace('install.php', '', $_SERVER['REQUEST_URI']);
	
	$htaccess_file = '.htaccess';
	$htaccess_data = "Options -Indexes
#Start Fictionalicious rules
	#Start ModRewrite
		<IfModule mod_rewrite.c>
		RewriteEngine On
		RewriteBase $write_base
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteRule (.*)/$ index.php [L]

		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_URI} !(.*)/$
		RewriteRule ^(.*)$ $1/ [L,R=301]


		</IfModule>
	#End ModRewrite
	
	#Start ErrorDocuments
		ErrorDocument 403 " . $write_base . "error/
		ErrorDocument 404 " . $write_base . "error/
		ErrorDocument 500 " . $write_base . "error/
	#End ErrorDocuments
	
#End Fictionalicious rules";
	
	$write_htaccess = file_put_contents($htaccess_file, $htaccess_data);
	if(!$write_htaccess) return false;
	else return true;	
}

function write_db($dbhost, $dbname, $dbuser, $dbpass) {
	global $table_prefix;
	//create the  database connection file
	$db_file = "config" . DIRECTORY_SEPARATOR . "db.php";
	$db_data = "<?php
	#Author: Sunnefa Lind
	#Project: Fictionalicious v. 0.9
	#Date created: 12.02.2011
	
	/*
	*	This is config/db.php. This page holds the database details and connects to the database
	*/
	
	define('PREFIX', '$table_prefix');
	
	\$username = '$dbuser';
	\$database = '$dbname';
	\$password = '$dbpass';
	\$hostname = '$dbhost';
	
	mysql_connect(\$hostname, \$username, \$password) or die(mysql_error());
	mysql_select_db(\$database) or die(mysql_error());
	
	?>";

	$write_db = file_put_contents($db_file, $db_data);
	if(!$write_db) return false;
	else return true;
}

/*functions for outputting the form */
function output($buffer) {
	$before = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Install &mdash; Fictionalicious &mdash; A story publishing platform</title>
<style>
body {
	background:#CCC;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:16px;
	color:#333;
	margin:0;
}
#container {
	width:65%;
	margin:10px auto;
	border:1px #aaa solid;
	background:#ddd;
}
h1 {
	text-align:center;	
}
p {
	margin-left:30px;	
}
.heading {
	background:#eee;
	font-weight:bold;
	padding-left:10px;	
}
.error {
	color:#f00;	
}
.small {
	font-size:0.75em;
	font-weight:normal;	
}
.center {
	text-align:center;	
}
form ul {
	list-style:none;
	width:100%;
	margin:0 auto;
	padding:0;
}
input {
	width:250px;
	border:1px solid #ccc;
	padding:5px;	
}
input.submit {
	-moz-border-radius:20px;
	width:100px;
	height:25px;
	background:#eee;
	margin-top:20px;		
}

form ul li {
	padding:15px;
	border-bottom:1px solid #ccc;
}

form ul li label {
	display:block;
	float:left;	
	width:150px;
	padding:5px 20px 0 0;
}

</style>
</head>

<body>
<div id="container">
<h1>Fictionalicious 1 click installer</h1>

EOT;
	
	$after = <<<EOT
</div>
</body>
</html>
EOT;

	return $before . $buffer . $after;
}
?>