<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 16.03.2011

/*
*	This is admin/pages/manage_tags.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p class="mess"></p>
<ul class="story_row story_head">
	<li class="tag_name">Tag name</li>
    <li class="tag_desc">Description</li>
    <li class="clear"></li>
</ul>
<?php foreach($tags as $tag): ?>
<ul class="story_row" id="tag-<?php echo $tag['id']; ?>">
	<li class="tag_name"><a class="edit"><?php echo $tag['tag_name']; ?></a>
    <div class="edit_options"><a href="#" class="edit">Edit</a> - <a href="#" class="delete">Delete</a></div>
    </li>
    <li class="tag_desc"><?php echo rm_para($tag['description']); ?></li>
    <li class="clear"></li>
    <li id="edit-<?php echo $tag['id']; ?>" style="display:none;">
        <form method="post" action="">
        	<ul>
            	<li class="editor_container">&nbsp;Tag name
                <input type="text" id="name-<?php echo $tag['id']; ?>" name="tag_name" value="<?php echo $tag['tag_name']; ?>" /></li>
                <li class="editor_container desc">&nbsp;Tag description
                <textarea cols="10" rows="10" id="desc-<?php echo $tag['id']; ?>" class="description" name="desc"><?php echo $tag['description']; ?></textarea></li>
                <li class="center"><input type="submit" class="submit" name="submit" value="Update" /></li>
            </ul>
        </form>
    </li>
</ul>

<?php endforeach; ?>