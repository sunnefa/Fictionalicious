<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 09.03.2011

/*
*	This is application/pages/admin/story_form.php
*/
?>
<form action="" method="post" class="edit" id="form-<?php if(isset($stories)) echo $stories['id'] ?>">
	<input type="hidden" value="<?php if(isset($stories)) echo $stories['id']; ?>" name="update" />
    <input name="old_tags" type="hidden" id="old_tags-<?php if(isset($stories)) echo $stories['id']; ?>" value="<?php if(isset($stories)) echo $stories['tags']; ?>" />

        	<ul class="left">
            	<li class="editor_container">
                	&nbsp;&nbsp;Title:
                	<input type="text" name="title" id="title-<?php if(isset($stories)) echo $stories['id']; ?>" value="<?php if(isset($stories)) echo $stories['title']; ?><?php if(isset($story)) echo $story['title']; ?>" />
                </li>
                
                <li class="clear"></li>
                <li class="editor_container desc">
                    &nbsp;&nbsp;Description:
                   	<textarea name="desc" id="desc-<?php if(isset($stories)) echo $stories['id']; ?>" class="description" rows="10" cols="77"><?php if(isset($stories)) echo stripslashes($stories['description']); ?><?php if(isset($story)) echo $story['description']; ?></textarea>
                </li>
				<?php if(isset($stories)): ?>
                <li>Status:
                	<div class="small">Note: Status cannot be changed on stories which have no chapters</div>
                <?php switch ($stories['status']):
					 	case 'No-chapters': ?>
                	<div class="small left">Complete&nbsp;<input disabled class="radio" type="radio" name="status" value="complete" /></div>
                	<div class="small">&nbsp;&nbsp;In-progress&nbsp;<input disabled class="radio" type="radio" name="status" value="in-progress" /></div>
                	<?php break; ?>
                	<?php case 'Complete': ?>
                	<div class="small left">Complete&nbsp;<input checked class="radio" type="radio" name="status" value="complete" /></div>
                	<div class="small">&nbsp;&nbsp;In-progress&nbsp;<input class="radio" type="radio" name="status" value="in-progress" /></div>
                	<?php break; ?>
                    <?php case 'In-progress': ?>
                	<div class="small left">Complete&nbsp;<input class="radio" type="radio" name="status" value="complete" /></div>
                	<div class="small">&nbsp;&nbsp;In-progress&nbsp;<input checked class="radio" type="radio" name="status" value="in-progress" /></div>
                	<?php break; ?>
                	<?php endswitch; ?>
                </li>
                <?php endif; ?>
                <li class="center">
                <?php if(isset($stories)): ?>
                	<input class="submit" type="submit" name="submit" value="Update" />
                <?php else: ?>
                	<input class="submit" type="submit" name="submit" value="Add story" />
                <?php endif; ?>
                </li>

            </ul>
            <ul class="tagscheck left editor_container" id="tags-<?php if(isset($stories)) echo $stories['id']; ?>">
            	<li>Tags:</li>
                <li><label for="new_tags-<?php if(isset($stories)) echo $stories['id']; ?>" class="tags">Add new tags</label><input type="text" id="new_tags-<?php if(isset($stories)) echo $stories['id']; ?>" class="new_tags" name="new_tags" /></li>
                <?php foreach($tags as $tag): ?>
                <?php if(isset($old)): ?>
                <?php if(in_array($tag['tag_name'], $old)): ?>
                <li class="tags"><input class="radio" checked type="checkbox" name="tags[]" value="<?php echo $tag['tag_name']; ?>" />
				&nbsp;<?php echo $tag['tag_name']; ?></li>
                <?php else: ?>
                <li class="tags"><input class="radio" type="checkbox" name="tags[]" value="<?php echo $tag['tag_name']; ?>" />
				&nbsp;<?php echo $tag['tag_name']; ?></li>
                <?php endif; ?>
                <?php else: ?>
                <li class="tags"><input class="radio" type="checkbox" name="tags[]" value="<?php echo $tag['tag_name']; ?>" />
				&nbsp;<?php echo $tag['tag_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </form>
