// ----------------------------------------------------------------
// Toastr
// ----------------------------------------------------------------

$(document).ready(function(){

	toastr.options = {
		"closeButton": false,
	    "debug": false,
	    "newestOnTop": false,
	    "progressBar": false,
	    "positionClass": "toast-bottom-center",
	    "preventDuplicates": false,
	    "onclick": null,
	    "showDuration": "300",
	    "hideDuration": "1000",
	    "timeOut": "3000",
	    "extendedTimeOut": "1000",
	    "showEasing": "swing",
	    "hideEasing": "linear",
	    "showMethod": "fadeIn",
	    "hideMethod": "fadeOut"
    };

});

$(function() {
	var toast_info = document.getElementById("toast-info");
	if (toast_info != null) {
		toastr.info(toast_info.innerHTML);
	}
});

$(function() {
	var toast_error = document.getElementById("toast-error");
	if (toast_error != null) {
		toastr.error(toast_error.innerHTML);
	}
});

$(function() {
	var toast_success = document.getElementById("toast-success");
	if (toast_success != null) {
		toastr.success(toast_success.innerHTML);
	}
});

$(function() {
	var toast_warning = document.getElementById("toast-warning");
	if (toast_warning != null) {
		toastr.warning(toast_warning.innerHTML);
	}
});