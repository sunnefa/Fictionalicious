<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.02.2011

/*
*	This is application/controller/tag.php
*/

include DATA_DIR . 'tags.php';
include DATA_DIR . 'stories.php';

$tag_name = rm_underscores($queries[1]);

$current_page = (isset($queries[2])) ? str_replace('page', '', $queries[2]) : 1;

$tag = get_single_tag(addslashes($tag_name));

$total_results = $tag['total'];

$pagination = pagination($current_page, "tag/{$queries[1]}/page", $total_results);

$stories = get_stories($pagination['start'], "WHERE s.status != 'no-chapters' AND ta.tagid = {$tag['id']}");


//set the title
$page_title = "Tag: " . $tag_name;


include PAGES_DIR . 'tag.php';
?>