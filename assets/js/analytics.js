// ----------------------------------------------------------------
// AJAX for analytics selection
// ----------------------------------------------------------------

$(document).ready(function(){
    var path = "";
    var date = $("#analytics-date").val();

    // Load Google Charts with default values
    ajax_analytics("7daysAgo");

    // Load Google Analytics with default values
    ajax_data(date, "date");
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(draw_chart);
});

function ajax_data(value, name) {
    var id = "";
    var url = $("#site-url").val();

    if (name == "date") {
        value = value + "/" + $("#analytics-metric").val();
    }

    if (name == "metrics") {
        value = $("#analytics-date").val() + "/" + value;
    }

    path = url + value;
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(draw_chart);
}

// Load Google Analytics stats
function ajax_analytics(str) {
    if (str == "") {
        document.getElementById("ajax-ga-stats").innerHTML = "";
        return;
    }
    else {
        var url = $("#site-url").val();

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
                document.getElementById("ajax-ga-stats").innerHTML = this.responseText;
            }
        };

        xmlhttp.open("GET",url + str,true);
        xmlhttp.send();
    }
}

// Load Google Charts
function draw_chart() {
    var jsonData = $.ajax({
        url: path,
        dataType: "json",
        async: false
        }).responseText;

    var options = {
        legend: { position: 'top', alignment: 'start' },
        backgroundColor: { fill:'transparent' },
        is3D: true,
    };

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.AreaChart(document.getElementById('ajax-ga-chart'));
    chart.draw(data, options);
}