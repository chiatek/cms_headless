// ----------------------------------------------------------------
// DataTables
// ----------------------------------------------------------------

$(document).ready(function(){

	$('#edit-table').dataTable({
		"columnDefs": [
			{ "orderable": false, "targets": 0 }
		],
		"language": {
			"emptyTable": "No results found"
		}
	});

});
