<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.2011

/*
*	This is application/controller/story.php
*/



include DATA_DIR . 'chapters.php';

$story_title = rm_underscores($queries[2]);

$storyid = $queries[1];

$chapter = (isset($queries[3])) ? str_replace('chapter', '', $queries[3]) : 1;

$total_chapters = get_num_chapters($storyid);

$pagination = pagination($chapter, "story/$storyid/{$queries[2]}/chapter", $total_chapters);

$chapter_cont = get_chapter($storyid, $pagination['start']);

$update_views = update_chapter_views($chapter_cont['id']);

$page_title = $story_title . " - " . $chapter_cont['title'];

include PAGES_DIR . 'story.php';

?>