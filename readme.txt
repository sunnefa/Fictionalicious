Fictionalicious - a story publishing platform

### Installation instructions ###

- To install Fictionalicious upload all the files into the directory in which you wish to install it. Make sure that the cache and uploads directories are readable before you run the installer and that all files were uploaded.

- If you run into problems running the installer, please delete any database tables and the admin uploads folder (uploads/10001) before trying again.

- After install you can login and start adding you stories.


### Theme guide ###

- If you wish to create your own theme create a new folder in the theme directory and create an index.html. You can create your css stylesheet in anyway you like, either in a special file or inline.

- Please note that all images and stylesheets referenced in your theme's index.html must have a path that is relative to the root folder of your Fictionalicious install.

- You can use four tokens to display the content.
	{URL} - displays the full url as per your settings
	{TITLE} - displays the full title as per your settings
	{MENU} - displays the main navigation menu
	{CONTENT} - displays all the content
	
You can add these tokens as many times as you want in your index.html.
For a list of the css classes and selectors your might want to use in your stylesheet, please refer to the default theme's style.css file