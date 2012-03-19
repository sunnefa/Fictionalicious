<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.2011

/*
*	This is config/settings.php. Holds some basic settings.
*/

//enable errors
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'on');

//include the settings data file
include DATA_DIR . 'settings.php';

//get the settings into an array
$settings = get_settings();

//define a constant for each setting
foreach($settings as $setting) {
	//if the setting name is not theme
	if($setting['name'] != 'theme') define(strtoupper($setting['name']), $setting['value']);
	//if the setting name is theme we need to append the theme directory and the DS to the front and the end of the value
	else define(strtoupper($setting['name']), THEME_DIR . $setting['value'] . DS);	
}

//mandatory power setting
$power_left = '1a5975a94abccc2738d99a5a6a2759499daa0b29c9b999caec5d0d194af949e';
$power_right = 'c28592b48c7b999caec5d0d194af949e94d9aaae6167c4a';
?>