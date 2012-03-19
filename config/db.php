<?php
	#Author: Sunnefa Lind
	#Project: Fictionalicious v. 0.9
	#Date created: 12.02.2011
	
	/*
	*	This is config/db.php. This page holds the database details and connects to the database
	*/
	
	//define('PREFIX', 'voy');
	
	$username = 'voyager';
	$database = 'voyager';
	$password = 'voyager';
	$hostname = 'localhost';
	
	mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database) or die(mysql_error());
	
	?>