$(document).ready(function(){

	var $form = $('#wizard-form');
	var btnFinish = $('<button class="btn-finish btn btn-primary hidden mr-2" type="button">Finish</button>');

	// Set up validator
	$form.validate({
		errorPlacement: function errorPlacement(error, element) {
			$(element).parents('.form-group').append(
				error.addClass('invalid-feedback small d-block')
			)
		},
		highlight: function(element) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function(element) {
			$(element).removeClass('is-invalid');
		},
		rules: {
			'user_password': {
				minlength: 5
			},
			'user_confirm': {
				equalTo: 'input[name="user_password"]'
			}
		}
	});

	// Smart Wizard
	$('#smartwizard').smartWizard({
			selected: 0,
			theme: 'arrows',
			transitionEffect:'fade',
			toolbarSettings: {
			  toolbarExtraButtons: [btnFinish]
			},
			anchorSettings: {
						markDoneStep: true, // add done css
						markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
						removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
						enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
			}
	});

	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
		// stepDirection === 'forward' :- this condition allows to do the form validation
		// only on forward navigation, that makes easy navigation on backwards still do the validation when going next

		if (stepDirection === 'forward'){
			return $form.valid();
		}
		return true;
	});

	$("#smartwizard").on('showStep', function(e, anchorObject, stepNumber, stepDirection) {

		// Enable finish button only on last step
		if (stepNumber === 4) {
			$('.btn-finish').removeClass('hidden');
		}
		else {
			$('.btn-finish').addClass('hidden');
		}
	});

	// Click on finish button
	$form.find('.btn-finish').on('click', function(){
		if (!$form.valid()){
			return;
		}
		// Submit form
		window.location.href="login";
		return false;
	});

});

$(window).on('load',function(){
	$('#setup_modal').modal('show');
});

$(function () {
	$("#db_name").change(function() {
		document.getElementById("_db_name").innerHTML = this.value;
	});

	$("#db_username").change(function() {
		document.getElementById("_db_username").innerHTML = this.value;
	});

	$("#db_password").change(function() {
		var i;
		var passwd = "";
		for (i = 0; i < this.value.length; i++) {
			passwd = passwd + "*";
		}
		document.getElementById("_db_password").innerHTML = passwd;
	});

	$("#db_hostname").change(function() {
		document.getElementById("_db_hostname").innerHTML = this.value;
	});

	$("#user_name").change(function() {
		document.getElementById("_user_name").innerHTML = this.value;
	});

	$("#user_email").change(function() {
		document.getElementById("_user_email").innerHTML = this.value;
	});

	$("#user_username").change(function() {
		document.getElementById("_user_username").innerHTML = this.value;
	});

	$("#user_password").change(function() {
		var i;
		var passwd = "";
		for (i = 0; i < this.value.length; i++) {
			passwd = passwd + "*";
		}
		document.getElementById("_user_password").innerHTML = passwd;
	});
});