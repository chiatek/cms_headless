// ----------------------------------------------------------------
// CodeMirror
// ----------------------------------------------------------------

$(document).ready(function(){

	var editor = CodeMirror.fromTextArea(document.getElementById("cm-textarea"), {
		lineNumbers: true,
		autoCloseBrackets: true,
		lineWrapping: true,
		theme: "material",
		indentUnit: 4,
		extraKeys: {
			"F11": function(cm) {
		  		cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
		  		if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
      	}
	});
});