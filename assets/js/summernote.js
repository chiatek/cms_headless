// ----------------------------------------------------------------
// Summernote
// ----------------------------------------------------------------

$(document).ready(function(){

    var image = "";

	$('#summernote').summernote({
		toolbar: [
			['all', ['style', 'bold', 'italic', 'underline', 'fontname', 'fontsize', 'color', 'ul', 'ol', 'paragraph', 'height', 'table', 'codeview', 'fullscreen']]
		  ],
		height: 500,
		maxHeight: 500,
		minHeight: 500,
		followingToolbar: false,
		toolbarContainer: '.summernote-toolbar',
		codemirror: {
  			theme: 'material',
			lineNumbers: true
		}
	})
	.on('summernote.change', function() {
		$('.btn-publish').prop('disabled', false);
	});

	$('[data-editor]').click(function () {
		$('[data-editor]').removeClass("selected");
		$(this).addClass("selected");

		image = this.dataset.editor;
	});

	$('#editor-btn').click(function () {
		$summernote = $("#summernote");
		$summernote.summernote("insertImage",image);
	});

});