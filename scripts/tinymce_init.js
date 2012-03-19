tinyMCE.init({
        mode : "textareas",
		plugins : "spellchecker,searchreplace,contextmenu,wordcount,preview,fullscreen,inlinepopups",
        theme : "advanced",
		// Theme options
        theme_advanced_buttons1 : "bold,italic,underline,|,hr,|,justifyleft, justifycenter,|,cut,copy,paste,|,link,unlink,|,image,|,undo,redo,|,search,|,spellchecker,|,code,preview,fullscreen",
        theme_advanced_buttons2 :"",
        theme_advanced_buttons3 :"",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "bottom",
		
		// Skin options
        skin : "default",
		height: "500px",
		width: "520px"
});