<?php
#Author: Sunnefa Lind
#Project: Fictionalicious v. 0.9
#Date created: 15.03.2011

/*
*	This is admin/pages/settings.php
*/
?>
<h1><?php echo $page_title; ?></h1>
<p>Here you can change some settings</p>
<?php if(isset($errors) && !empty($errors)): ?>
<p>The following errors occurred:</p>
<?php foreach ($errors as $error): ?>
<p style="color:#F00;"><?php echo $error; ?></p>
<?php endforeach; ?>
<?php elseif(isset($success) && !empty($success)): ?>
<?php foreach($success as $succ): ?>
<p><?php echo $succ; ?></p>
<?php endforeach; ?>
<?php endif; ?>

<form action="" method="post">
	<ul>
    	<li><label for="title">Title</label><input type="text" name="settings[title]" id="title" value="<?php echo TITLE; ?>" /> <a href="#" class="help">?</a>
        	<ul class="help small" style="display:none;">
            	<li>Story platform title</li>
                <li>This is the title that is displayed in the title bar of the browser. Some themes might also show this value and it is used in all emails sent, such as activation emails.</li>
            </ul>
        </li>
        
        <li><label for="per_page">Stories per page</label><input type="text" name="settings[per_page]" id="per_page" value="<?php echo PER_PAGE; ?>" /> <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>How many stories to display per page</li>
                <li>This value determines how many stories to display on each page. You can put any numerical value here except 0 and negative numbers.</li>
            </ul>
        </li>

    	<li><label for="menu_sep">Menu separator</label><input type="text" name="settings[menu_sep]" id="menu_sep" value="<?php echo htmlentities(MENU_SEP); ?>" /> <a href="#" class="help">?</a>
              <ul class="help small" style="display:none;">
            	<li>Menu item separator</li>
                <li>Separates menu items from each other. You can use any HTML entity, text or an image, or leave it empty. The menu can be styled further in your theme's CSS.</li>
            </ul>
        </li>

    	<li><label for="url_to">Default URL</label><input type="text" name="settings[url_to]" id="url_to" value="<?php echo URL_TO; ?>" /> <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>The default URL to your story platform</li>
                <li>This is the default URL to your story platform. All images, stylesheets etc use this value. It cannot be empty. Be careful when changing this value, only change it if you plan to move your story platform.</li>
            </ul>
        </li>
        
        <li><label for="use_cache">Enable caching?</label>
        <select name="settings[use_cache]" id="use_cache">
        <?php foreach($cache as $option): ?>
        	<?php if($option == USE_CACHE): ?>
        	<option selected value="<?php echo $option; ?>"><?php echo ucwords($option); ?></option>
            <?php else: ?>
            <option value="<?php echo $option; ?>"><?php echo ucwords($option); ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
        </select>
        <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>Cache settings</li>
                <li>This enables caching on your platform to speed up page requests. Be careful with this setting as it will delay any changes appearing.</li>
                <li><strong>none</strong> - Disables caching</li>
                <li><strong>all</strong> - caches everything</li>
                <li><strong>stories</strong> - caches only stories</li>
            </ul>
        </li>
        
       	<li><label for="cache_time">Cache time</label><input type="text" name="settings[cache_time]" id="cache_time" value="<?php echo CACHE_TIME; ?>" /> <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>Cache timeout</li>
                <li>The amount of time allowed to pass before a new cache file is generated. Enter this number in minutes, eg 60 is 1 hour</li>
            </ul>
        </li>
        
        <li><label for="user_profiles">Use user profiles?</label>
			<?php if(USER_PROFILES == 0): ?>
            <input type="radio" class="radio" checked name="settings[user_profiles]" id="user_profiles" value="0" /> No &nbsp;
            <input type="radio" class="radio" name="settings[user_profiles]" id="user_profiles" value="1" /> Yes
            <?php elseif(USER_PROFILES == 1): ?>
            <input type="radio" class="radio" name="settings[user_profiles]" id="user_profiles" value="0" /> No &nbsp;
            <input type="radio" class="radio" checked name="settings[user_profiles]" id="user_profiles" value="1" /> Yes
            <?php endif; ?>
        <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>User profiles</li>
                <li>Determines wether to display user profiles or not.</li>
                <li><strong>Yes</strong> - displays a link to the user's profile in storylists, an avatar in story view and a link to a list of users</li>
                <li><strong>No</strong> - removes all links to user profiles, removes avatars from story views and disables the profile page</li>
            </ul>
        </li>

        <?php if(USER_PROFILES): ?>
        <li><label for="users_per_col">Users per column?</label><input type="text" name="settings[users_per_col]" id="users_per_col" value="<?php echo USERS_PER_COL; ?>" /> <a href="#" class="help">?</a>
            <ul class="help small" style="display:none;">
            	<li>How many users per column</li>
                <li>This value determines how many users to display in each column on the user list. Set this to a high value if you have a large number of users.</li>
            </ul>
        </li>
        <?php endif; ?>
        
        <li><label for="user_reg">Users can register?</label>
			<?php if(USER_REG == 0): ?>
            <input type="radio" class="radio" checked name="settings[user_reg]" id="user_reg" value="0" /> No &nbsp;
            <input type="radio" class="radio" name="settings[user_reg]" id="user_reg" value="1" /> Yes
            <?php elseif(USER_REG == 1): ?>
            <input type="radio" class="radio" name="settings[user_reg]" id="user_reg" value="0" /> No &nbsp;
            <input type="radio" class="radio" checked name="settings[user_reg]" id="user_reg" value="1" /> Yes
            <?php endif; ?>
        <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>Can users register?</li>
                <li>Determines if users can register on your story platform or not. If this setting is set to <strong>No</strong> the registration page is disabled and the registration link is removed from the menu</li>
            </ul>
        </li>
        
        <li><label for="theme">Theme</label>
        	<select name="settings[theme]" id="theme">
            	<?php foreach($themes as $theme): ?>
                <?php if($theme == $curr_theme): ?>
                <option selected value="<?php echo $theme; ?>"><?php echo ucwords($theme); ?></option>
                <?php else: ?>
                <option value="<?php echo $theme; ?>"><?php echo ucwords($theme); ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select> <a href="#" class="help">?</a>
             <ul class="help small" style="display:none;">
            	<li>Your theme</li>
                <li>Select the theme you wish to use. All themes reside in the <strong><?php echo URL_TO; ?>themes/</strong> folder</li>
            </ul>
            </li>
            
            <li class="center"><input type="submit" name="settings[update]" class="submit" value="Update Settings" /></li>
        	

    </ul>
</form>