<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.11

/*
*	This is config/functions/basics.php
*	Holds basic functions
*/

/**
 * Determines the direction of ORDER BY based on the given sort option (ASC OR DESC
 * @param $sort - the given sort option
 * returns string
*/
function direction($sort) {
	switch($sort) {
		case "s.timestamp":
			$direction = "DESC";
		break;
		
		case "views":
			$direction = "DESC";
		break;
		
		default:
			$direction = "ASC";
	}
	return $direction;
}

/**
 * Replaces all spaces with underscores (and ' with the html entity if it exists)
 * @param $str - the string to work on
 * returns string
*/
function add_underscores($str) {
	$str = str_replace(" ", "_", $str);
	if(preg_match("(')", $str)) $str = str_replace('\'', '&#39;', $str);
	return $str;	
}

/**
 * Replaces all underscores with spaces
 * @param $str - the string to work on
 * returns string
*/
function rm_underscores($str) {
	$str = str_replace("_", " ", $str);
	$str = urldecode($str);
	return $str;	
}

/**
 * Converts new lines (\n) to paragraphs
 * @param $str - the string to work on
 * @param $class - the class on the p tag added
 * returns string
*/
function nl2para($str, $class) {
	$str = "\t<p class=\"$class\">" . preg_replace("(\n|\r)", "</p>$0\t<p class=\"$class\">", $str) . "</p>";
	$str = str_replace("\t<p class=\"$class\"></p>", "", $str);
	return $str;	
}

/**
 * Removes p tags from a string
 * @param $str - the string to work on
 * returns string
*/
function rm_para($str) {
	$str = preg_match("(<p>)", $str) ? str_replace('<p>', '', $str) : $str;
	$str = preg_match("(</p>)", $str) ? str_replace('</p>', '', $str) : $str;
	return $str;	
}

/**
 * Takes a two dimensional array and flattens it to one dimension
 * @param $array - the array to work on
 * returns array
*/
function flatten_array($array) {
	$single = array();
	foreach($array as $one) {
		foreach($one as $key => $value) {
			$single[$key] = $value;	
		}
	}
	return $single;		
}

/**
 * Truncates a string to a given length
 * @param $str - the string to work on
 * @param $length - the length to truncate to
 * @param $trail - the trailing string
 * returns string
*/
function truncate($str, $length = 10, $trail = '...') {
	$length -= strlen($trail);
	if(strlen($str) > $length) {
		$output = substr($str, 0, $length).$trail;	
	}
	else {
		$output = $str;	
	}
	return $output;
}

/**
 * Sanitizes user input so it can be used in sql queries
 * @param $str - the string to work on
 * returns string
*/
function sanitize($str) {
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);	
	}
	$str = mysql_real_escape_string($str);
	
	return $str;
}

/**
 * Decodes an encrypted string
 * @param $str - the string to decode
 * returns decoded string
*/
function decode_str($str) {
	$hash = '';
	$j = 0;
	//the encoding key
	$key = md5(sha1("f63948992a8cd9f9a5bcadda6af666f5ad8d7a269cec69bafc1afc295adcb9d91a9a3a"));
	
	//for every character in the string
	for($i = 0; $i < strlen($str); $i+=2) {
		
		//every character is converted from hexadecimal to decimal and the string is reversed
		$ordstr = hexdec(strrev(substr($str,$i,2)));
		
		//if j is equal to the key length we reset it to 0
		if($j == strlen($key)) $j = 0;
		
		//every character is converted to ASCII values
		$ordkey = ord(substr($key,$j,1));
		
		//increment j
		$j++;
		
		//the hash is the ascii character that is left after the ordered string is subtracted from the ordered key
		$hash .= chr($ordstr - $ordkey);	
	}
	return $hash;
}

/**
 * Redirects using the header function
 * @param $page - the page to redirect to
 * returns unknown
*/
function redirect($page) {
	header("Location: ?page=$page");	
}

/**
 * Generates a random password
 * @param $length - optional length of the password
 * returns array
*/
function generate_password($length = 10) {
	$outp = "";
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$arr = str_split($chars);
	for($i = 0; $i < $length; $i++) {
		$rand = array_rand($arr);
		$outp .= $arr[$rand];
	}
	return array('pass' => $outp, 'enc_pass' => md5($outp));
}
?>