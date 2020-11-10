// ----------------------------------------------------------------
// Disable submit until a change is made to the form
// ----------------------------------------------------------------

$(function () {
	var checkboxes = $('.delete-chk');
	checkboxes.change(function() {
		$('.delete-btn').prop('disabled', checkboxes.filter(':checked').length < 1);
	});
	$('.delete-chk').change();
});

$(function () {
    $('.save-btn').prop('disabled', true);

	//When a input is changed check all the inputs and if all are filled, enable the button
	$('input,textarea,select').change(function() {
		var isValid = true;
		$('input,textarea,select').filter('[required]:visible').each(function() {
			if ($(this).val() === '')
				isValid = false;
			});
			if(isValid) {
				$('.save-btn').prop('disabled', false);
			}
			else {
				$('.save-btn').prop('disabled', true);
		};
	});

	$('[data-avatar],[data-theme],[data-icon],[data-media]').click(function () {
		$('.save-btn').prop('disabled', false);
	});
});

// ----------------------------------------------------------------
// Mirror and filter post_title to post_slug
// ----------------------------------------------------------------

$(function () {
	var slug = document.getElementById("post_slug");

	$("#post_title").keyup(function() {
		slug.value = this.value;
		slug.value = slug.value.trim();
		slug.value = slug.value.replace(/ /g,"_");
		slug.value = slug.value.toLowerCase();
	});
});

// ----------------------------------------------------------------
// Disable/enable post_title and page_selection
// ----------------------------------------------------------------

$(function () {
	var name = document.getElementById("post_title");
	var file_name = document.getElementById("post_slug");
	var x = document.getElementById("file_type");
	var i;

	$('#file_type').change(function() {
		for (i = 0; i < x.length; i++) {
			if ($(this).val() === x.options[i].value) {
				name.value = file_name.value = $(this).val();
			}
		}

		if ($(this).val() != "") {
			$('#post_title').prop('disabled', true);
		}
		else {
			$('#post_title').prop('disabled', false);
		}
	});
});

// ----------------------------------------------------------------
// Spinner
// ----------------------------------------------------------------

$(function () {
	$('.spinner').on('click', function() {
		var $this = $(this);
		var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> ' + $this.text();
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}
		setTimeout(function() {
			$this.html($this.data('original-text'));
		}, 2000);
	});
});

$(function () {
	$('.spinner-fa').on('click', function() {
		var $this = $('.spinner-fa i');
		var loadingText = $this.toggleClass('<i class="fa fa-circle-o-notch fa-spin"></i>');
		if ($(this).html() !== loadingText) {
			$this.data('original-text', $(this).html());
			$this.html(loadingText);
		}
		setTimeout(function() {
			$this.html($this.data('original-text'));
		}, 2000);
	});
});

// ----------------------------------------------------------------
// Delete confirmation
// ----------------------------------------------------------------

function confirm_delete() {
	var x = confirm("Are you sure you want to delete?");
	if (x)
		return true;
  	else
		return false;
}

// ----------------------------------------------------------------
// Settings
// ----------------------------------------------------------------

if (document.body.contains(document.getElementById('setting_root'))) {
    let documentRoot = document.getElementById("setting_root").value;

    if (documentRoot !== "") {
        documentRoot += "/";
    }
    
    document.getElementById("setting_media").innerHTML = documentRoot;
    document.getElementById("setting_css").innerHTML = documentRoot;
}