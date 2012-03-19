<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.02.2011

/*
*	This is application/pages/menu.php
*/

?>
<ul class="menu">
<?php foreach($menu as $link => $name): ?>
	<?php if(strpos($link, $is_current) !== false): ?>
    <li class="current">
    <?php else: ?>
    <li><?php endif; ?>
    <?php echo $name; ?>
    <?php if(count($menu) != $i && MENU_SEP != '' && !defined('ADMIN_MODE')): ?>
    	<?php if(preg_match("(.jpg|.gif|.png)", MENU_SEP)) : ?>
        <li><img src="<?php echo URL_TO . MENU_SEP; ?>" alt="Menu separator" /></li>
        <?php else: ?>
    	<li><?php echo MENU_SEP; ?></li>
    	<?php endif; ?>
    <?php endif; ?>
<?php ++$i; endforeach; ?>
</ul>