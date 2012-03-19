<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/settings.php
*	Holds the CRUD for the setings table
*/

/**
 * Gets all the settings
 * returns array
*/
function get_settings() {
	$sql = "SELECT * FROM " . PREFIX . "_settings";
	$query = mysql_query($sql);
	if(!$query) fic_error("Could not select settings", mysql_error(), __FILE__, __LINE__);
	
	$settings = array();
	while($row = mysql_fetch_assoc($query)) {
		$settings[] = $row;	
	}
	return $settings;
}

/**
 * Updates the settings
 * @param $name - the name of the settings item
 * @param $value - the new value of the settings item
 * returns boolean
*/
function update_settings($name, $value) {
	$update = mysql_query("UPDATE " . PREFIX . "_settings SET value = '$value' WHERE name = '$name'");
	if(!$update) {
	fic_error("Could not update settings", mysql_error(), __FILE__, __LINE__);	
	}
	return true;	
}
?>