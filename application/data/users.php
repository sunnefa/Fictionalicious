<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 18.03.2011

/*
*	This is application/data/users.php
*	Holds the CRUD for the users table
*/

/**
 * Gets the id of a user based on its username
 * @param $username - the username to check against
 * returns the userid
*/
function get_user_id($username) {
	$sql = "SELECT id FROM " . PREFIX . "_users WHERE username = '$username'";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not get user id", mysql_error(), __FILE__, __LINE__);	
	}
	$id = mysql_fetch_row($query);
	
	return $id[0];
}

/**
 * Gets a list of all users
 * returns an array
*/
function get_users($where = '') {
	$sql = "SELECT u.username, u.id, u.level, u.avatar, u.status, u.bio, (SELECT COUNT(s.id) FROM " . PREFIX . "_stories AS s WHERE s.authorid = u.id AND s.status != 'no-chapters') AS stories FROM " . PREFIX . "_users AS u LEFT JOIN " . PREFIX . "_stories AS s ON s.authorid = u.id AND s.status != 'no-chapters' $where GROUP BY u.id";
	$query = mysql_query($sql);
	if(!$query) {
		fic_error("Could not get users", mysql_error(), __FILE__, __LINE__);	
	}
	
	$users = array();
	
	while($row = mysql_fetch_assoc($query)) {
		if(!defined('ADMIN_MODE')) $row['username'] = print_user($row['username']);
		$users[] = $row;	
	}
	
	return $users;
}

/**
 * Gets a given user's info
 * @param $id - the user id to search by
 * returns an array
*/
function get_user_info($id) {
	$sql = mysql_query("SELECT id, username, level, email, avatar, bio, FROM_UNIXTIME(timestamp, '%a %D %b %Y') as date FROM " . PREFIX . "_users WHERE id = $id");
	if(!$sql || mysql_num_rows($sql) == 0) fic_error("Could not get user info", mysql_error(), __FILE__, __LINE__);
	
	$data = array();
	while($row = mysql_fetch_assoc($sql)) {
		$data[] = $row;
	}
		
	return flatten_array($data);
}

/**
 * Updates a user's biography
 * @param $bio - the user's biography
 * @param $id - the user's id
 * returns boolean
*/
function update_user_bio($bio, $id) {
	$update = mysql_query("UPDATE " . PREFIX . "_users SET bio = '$bio' WHERE id = $id");
	if(!$update) {
		log_errors("Can't update user bio", mysql_error(), __FILE__, __LINE__);
		return false;	
	}
	return true;
}

/**
 * Updates a user's avatar
 * @param $avatar - the user's avatar
 * @param $id - the user's id
 * returns boolean
*/
function update_user_avatar($avatar, $id) {
	$update = mysql_query("UPDATE " . PREFIX . "_users SET avatar = '$avatar' WHERE id = $id");
	if(!$update) {
		log_errors("Can't update user avatar", mysql_error(), __FILE__, __LINE__);
		return false;	
	}
	return true;
}

/**
 * Updates a user's email
 * @param $new_email - the user's new email
 * @param $id - the user's id
 * returns boolean
*/
function update_email($new_email, $id) {
	$update = mysql_query("UPDATE " . PREFIX . "_users SET email = '$new_email' WHERE id = $id");
	if(!$update) {
		log_errors("Can't update user email", mysql_error(), __FILE__, __LINE__);
		return false;
	}
	return true;
}

/**
 * Updates a user's password
 * @param $password - the user's password
 * @param $id - the user's id
 * returns boolean
*/
function update_user_password($password, $id) {
	$update = mysql_query("UPDATE " . PREFIX . "_users SET password = '$password' WHERE id = $id");
	if(!$update) {
		log_errors("Can't update user password", mysql_error(), __FILE__, __LINE__);
		return false;	
	}
	return true;	
}

/**
 * Updates a user's level
 * @param $level - the new level of the user
 * @param $id - the users's id
 * returns boolean
*/
function update_user_level($level, $id) {
	$sql = "UPDATE " . PREFIX . "_users SET level = '$level' WHERE id = $id";
	$update = mysql_query($sql);
	if(!$update) {
		log_errors("Can't update user level", mysql_error() . $sql, __FILE__, __LINE__);
		return false;
	}
	return true;	
}

/**
 * Deletes a user from the database
 * @param $user_id - the id of the user to be deleted
 * returns boolean
*/
function delete_user($user_id) {
	$sql = "DELETE FROM " . PREFIX . "_users WHERE id = $user_id";
	$query = mysql_query($sql);
	if(!$query) {
		log_errors("Could not delete user", mysql_error(), __FILE__, __LINE__);
		return false;	
	}
	return true;
}

/**
 * Locks a given user
 * @param $user_id - the id of the user to lock
 * returns boolean
*/
function lock_user($user_id) {
	$sql = "UPDATE " . PREFIX . "_users SET status = 'locked' WHERE id = $user_id";
	$query = mysql_query($sql);
	if(!$query) {
		log_errors("Could not lock user", mysql_error(), __FILE__, __LINE__);
		return false;	
	}
	return true;
}

/**
 * Sets a user's status to active
 * @param $user_id - the id of the user to activate
 * returns boolean
*/
function activate_user($user_id) {
	$sql = "UPDATE " . PREFIX . "_users SET status = 'active' WHERE id = $user_id";
	$query = mysql_query($sql);
	
	if(!$query) {
		log_errors("Could not activate user", mysql_error(), __FILE__, __LINE__);
		return false;
	}
	return true;
}

/**
 * Gets the user's username based on their email
 * @param $user_email - the email of the user
 * returns the username or false
*/
function get_username_by_email($user_email) {
	$sql = "SELECT username FROM " . PREFIX . "_users WHERE email = '$user_email'";
	$query = mysql_query($sql);
	if(!$query || mysql_num_rows($query) == 0) {
		log_errors("Could not find username", mysql_error(), __FILE__, __LINE__);
		return false;
	}
	$email = mysql_fetch_row($query);
	return $email[0];
}
?>