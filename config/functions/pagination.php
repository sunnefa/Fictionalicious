<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.11

/*
*	This is config/functions/pagination.php
*	Holds the pagination functions
*/

/*
 * Paginates results from the database
 * @param $current_page - the current page requested
 * @param $url - the url to use in the links returned
 * @param $total_results - the total number of results
 * returns an array containing:
 *	-the total pages
 *	-the start position
 *	-the pagination links for printing
*/
function pagination($current_page, $url, $total_results) {
	if(!is_numeric($current_page)) log_errors("Invalid page number - $current_page", "All pages must be numeric", __FILE__, __LINE__);
	
	//if the page requested is smaller than 1 we set the $page variable to 1
	if($current_page < 1) {
		$current_page = 1;	
	}
	
	if(defined('ADMIN_MODE')) {
		$start = ($current_page * 20) - 20;
		$total_pages = ceil($total_results / 20);
		$page = "Page";	
	}
	elseif(preg_match("(story)", $url)) {
		$start = ($current_page * 1) - 1;
		$total_pages = ceil($total_results / 1);
		$page = "Chapter";
	}
	else {
		$start = ($current_page * PER_PAGE) - PER_PAGE;
		$total_pages = ceil($total_results / PER_PAGE);
		$page = "Page";	
	}

	$output = "";
	
	//if the page requested is higher than the total number of pages we throw an error
	//this is only a fallback in case a viewer might enter a page number into the url
	if($current_page > $total_pages) {
		log_errors("Page request","The page requested is higher than the total number of pages available", __FILE__, __LINE__);
	}
	
	//for every page we need to display a link
	for($i = 1; $i <= $total_pages; $i++) {
		//if $i is not equal to the current page we make it a link
		if($i != $current_page && !defined('ADMIN_MODE')) {
			$output .= "&nbsp;&nbsp;<a href='" . URL_TO . "$url$i'>$page $i</a>";	
		}
		elseif($i != $current_page && defined('ADMIN_MODE')) {
			$output .= "&nbsp;<a href='" . URL_TO . "admin/$url$i'>Page $i</a>";	
		}
		//if $i is equal to the current page we don't make it a link
		else {
			$output .= "&nbsp;&nbsp;<a class=\"current\">$page $i</a>";	
		}
			
	}
	$data = array('start' => $start, 'output' => $output);
	return $data;
}

?>