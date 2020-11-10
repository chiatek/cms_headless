// ----------------------------------------------------------------
// Dropzone
// ----------------------------------------------------------------

$(document).ready(function(){

  	$('#dropzone').dropzone({
		paramName: "userfile",
    	parallelUploads: 2,
    	maxFilesize:     50000,
    	filesizeBase:    1000,
    	addRemoveLinks:  true,
  	});
	
});