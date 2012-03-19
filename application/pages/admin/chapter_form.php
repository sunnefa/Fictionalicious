<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 09.03.2011

/*
*	This is application/pages/admin/chapter_form.php
*/
?>
<form action="" method="post" class="edit">
	<input type="hidden" value="<?php if(isset($chapter)) echo $chapter['id']; ?>" name="chapter" />
    <input type="hidden" value="<?php if(isset($_GET['story'])) echo $_GET['story']; ?>" name="story" />
        	<ul>
            	<li class="editor_container">
                	&nbsp;&nbsp;Title:
                	<input type="text" name="title" id="title-<?php if(isset($chapter)) echo $chapter['id']; ?>" value="<?php if(isset($chapter)) echo $chapter['title']; else echo "Chapter " . ($num_chapters+1); ?>" />
                </li>
                
                <li class="editor_container desc">
                    &nbsp;&nbsp;Content:
                   	<textarea name="cont" id="cont-<?php if(isset($chapter)) echo $chapter['id']; ?>" class="chapters" rows="10" cols="77"><?php if(isset($chapter)) echo stripslashes($chapter['chapter_contents']); ?></textarea>
                </li>
                <li class="center">
                <?php if(isset($chapter)): ?>
                	<input class="submit" type="submit" name="submit" value="Update" />
                <?php else: ?>
                	<input class="submit" type="submit" name="submit" value="Add chapter" />
                <?php endif; ?>
                </li>

            </ul>
        </form>
