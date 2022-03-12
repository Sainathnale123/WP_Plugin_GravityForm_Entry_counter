jQuery(document).ready( function () {
	jQuery('#entries_counter').DataTable({
		"lengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "All"]],
		"pageLength": 20,
		"order": [[0, 'desc' ]],
		"searching": false,
	});

	jQuery("#entries_show").submit(function (e) {
		 e.preventDefault();
	     var selected_value = jQuery('select').val();
	     var url = window.location.href+"&id="+jQuery('select').val();
	     window.location.href = url; 
	});
});


