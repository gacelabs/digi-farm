$(document).ready(function() {
	$(document.body).find('table').each(function(i, elem) {
		if ($.fn.dataTable != undefined) $.fn.dataTable.ext.errMode = 'none';
		var text = $.trim($(elem).find('tr:first th:first small').text());
		// console.log(text)
		var blanks = {}, currency = {targets: []};
		if ($.inArray(text.toLowerCase(), ['photo','']) >= 0) {
			blanks.orderable = false;
			blanks.targets = [0];
		}
		var text2 = $.trim($(elem).find('tr:first th:last small').text());
		if ($.inArray(text2.toLowerCase(), ['actions','']) >= 0) {
			var last_cnt = $(elem).find('tr:first th').length - 1;
			blanks.targets.push(last_cnt);
		}
		// console.log(blanks)
		oSettings = {
			// stateSave: true,
			// responsive: true,
			"aaSorting": [[ 2, "asc" ]],
			columnDefs: [blanks],
			language: {
				"search": "",
				"lengthMenu": "_MENU_ Records",
				"infoEmpty": "",
				"emptyTable": "No products found.",
				"searchPlaceholder": "Search...",
				"info": "Total Records: <b>_TOTAL_</b>",
				"infoFiltered": " matched found",
				"paginate": {
					"first": "First",
					"last": "Last",
					"next": "Next",
					"previous": "Back"
				},
				"processing": "Getting entries...",
				"loadingRecords": "Loading entries...",
				/*ETO YUNG COMPLETE PROPERTIES NYA POI LABEL MO NALANG*/
				/*"decimal":        "",
				"emptyTable":     "No data available in table",
				"info":           "Showing _START_ to _END_ of _TOTAL_ entries",
				"infoEmpty":      "Showing 0 to 0 of 0 entries",
				"infoFiltered":   "(filtered from _MAX_ total entries)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Show _MENU_ entries",
				"loadingRecords": "Loading...",
				"processing":     "Processing...",
				"search":         "Search:",
				"zeroRecords":    "No matching records found",
				"paginate": {
					"first":      "First",
					"last":       "Last",
					"next":       "Next",
					"previous":   "Previous"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}*/
			}
		};

		$(elem).find('tr:first th:not(:first):not(:last)').each(function(j, elemTR) {
			if ($.trim($(elemTR).text()).toLowerCase().indexOf('updated') >= 0) {
				oSettings.order = [[j, 'desc']];
			}
			if ($.trim($(elemTR).text()).toLowerCase().indexOf('price') >= 0 || 
				$.trim($(elemTR).text()).toLowerCase().indexOf('rate') >= 0 || 
				$.trim($(elemTR).text()).toLowerCase().indexOf('amount') >= 0) {
				currency.targets.push(j);
			}
		});
		oSettings.columnDefs.push(currency);
		$(elem).DataTable(oSettings);
	});
	bsCustomFileInput.init();
	$('.select2').select2();
});