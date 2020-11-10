// ----------------------------------------------------------------
// Wizard multiple step form
// ----------------------------------------------------------------

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

// Display the specified tab of the form
function showTab(n) {

	var x = document.getElementsByClassName("tab");
	x[n].style.display = "block";
	if (n == 0) {
	document.getElementById("prevBtn").style.display = "none";
	}
	else {
	document.getElementById("prevBtn").style.display = "inline";
	}

	if (n == (x.length - 1)) {
	document.getElementById("nextBtn").innerHTML = "Finish";
	}
	else {
	document.getElementById("nextBtn").innerHTML = "Next";
	}

	fixStepIndicator(n) //run a function that displays the correct step indicator
}

// Figure out which tab to display
function nextPrev(n) {

	var x = document.getElementsByClassName("tab");

	if (n == 1 && !validateForm()) return false; // Exit the function if any field in the current tab is invalid

	x[currentTab].style.display = "none"; // Hide the current tab
	currentTab = currentTab + n; // Increase or decrease the current tab by 1

	if (currentTab >= x.length) { // Check if you have reached the end of the form
		document.getElementById("regForm").submit(); // Sumbit the form
		return false;
	}

	showTab(currentTab);// Otherwise, display the correct tab:
}

// Validation of the form fields
function validateForm() {

	var x, i, z, valid = true;
	x = document.getElementsByClassName("tab");
	y = x[currentTab].getElementsByClassName("required");
	z = x[currentTab].getElementsByTagName("select");

	for (i = 0; i < y.length; i++) { // Check every input field in the current tab
		if (y[i].value == "") { // Check if a field is empty
		  y[i].className += " invalid"; // Add an "invalid" class to the field
		  valid = false; // Set the current valid status to false
		}
		if (y[i].type == "hidden") {
			valid = true;
		}
	}

	for (i = 0; i < z.length; i++) { // Check every input field in the current tab
		if (z[i].value == "") { // Check if a field is empty
		  z[i].className += " invalid"; // Add an "invalid" class to the field
		  valid = false; // Set the current valid status to false
		}
		if (z[i].type == "hidden") {
			valid = true;
		}
	}

	if (valid) { // If the valid status is true, mark the step as finished and valid
		document.getElementsByClassName("indicator")[currentTab].className += " finish";
	}
	return valid; // Return the valid status
}

// Remove the "active" class of all steps
function fixStepIndicator(n) {

	var i, x, y;
	x = document.getElementsByClassName("indicator");
	y = document.getElementsByClassName("step");
	for (i = 0; i < x.length; i++) {
		x[i].className = x[i].className.replace(" active", "");
		y[i].className = y[i].className.replace(" active", "");
		y[i].className = y[i].className.replace(" hidden", "");
		y[i].className += " hidden";
	}

	x[n].className += " active"; // Add the "active" class on the current step
	y[n].className += " active";
	y[n].className = y[n].className.replace(" hidden", "");
}

// ----------------------------------------------------------------
// AJAX Database
// ----------------------------------------------------------------

function getdata(str) {
	if (str == "") {
		document.getElementById("ajax_output").innerHTML = "";
        return;
    }
	else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
		else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajax_output").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","insert_saved_query/"+str,true);
        xmlhttp.send();
    }
}