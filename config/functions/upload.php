<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 14.03.11

/*
*	This is config/functions/upload.php. Holds all functions that upload files
*/

function upload_avatar($file, $userid) {
	//the name of the new file
	$new_name = UPLOADS . "1000" . $userid . "/" . $file['name'];
	
	//get the image size (dimensions)
	$image_size = getimagesize($file['tmp_name']);
	
	//if the file is not an image
	if(!preg_match("(.jpg|.jpeg|.gif|.png)", $new_name)) return 2;
	
	//if the size is larger than 100kb
	elseif($file['size'] > 100000) return 3;
	
	//if the dimensions are larger than 100px
	elseif($image_size[0] > 100 || $image_size[1] > 100) return 4;
	
	//get the contents of the uploads directory
	$old_files = scandir(UPLOADS . "1000" . $userid);
	
	//remove the hidden files from the array
	foreach($old_files as $key => $old_file) {
		if($old_file == "." || $old_file == "..") {
			unset($old_files[$key]);	
		}
	}
	//delete any images that might be in the folder already
	foreach($old_files as $old_file) {
		unlink(UPLOADS . "1000" . $userid . "/" . $old_file);
	}	
	
	//upload the image
	$upload = move_uploaded_file($file['tmp_name'], $new_name);
	//if the upload was successful
	if(!$upload) return 0;
	
	return true;
}

function delete_upload_folder($id) {
	$folder = UPLOADS . "1000" . $id;
	$files = scandir($folder);
	
	foreach($files as $key => $file) {
		if($file == '.' || $file == '..') unset($files[$key]);
	}
	if(!empty($files)) {
		$files = array_values($files);
		$rm_files = unlink($folder . '/' . $files[0]);
		if(!$rm_files) {
			log_errors("Could not remove files", "Couldn't remove files from uploads folder", __FILE__, __LINE__);
			return false;	
		}
	}
	$rm_folder = rmdir($folder);
		if(!$rm_folder) {
			log_errors("Could not remove files", "Couldn't remove files from uploads folder", __FILE__, __LINE__);
			return false;	
		}
	return true;
}
?>