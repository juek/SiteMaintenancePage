gp_editor = {};

gp_editor.selectFile = function(target_input) {
	gp_editor.FinderSelect = function(fileUrl) { 
		if( fileUrl != "" ){
			target_input.val(fileUrl);
		}
		return true;
	};
	var finderPopUp = window.open(gpFinderUrl, 'gpFinder', 'menubar=no,width=960,height=450');
	if( window.focus ){ finderPopUp.focus(); }
}; 

$(".smp-select-image-button").on("click", function(e){
	e.preventDefault();
	var target_input = $(this).closest("td").find("input[type='text']");
	gp_editor.selectFile(target_input);
});