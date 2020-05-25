$(document).ready(function() {
	$('#current_password').off('blur').on('blur', function(e) {
		var oThis = $(this);
		var oSettings = {
			url: 'account/app_settings',
			type: 'post',
			dataType: 'json',
			data: {value: oThis.val()},
			beforeSend: function() {
				oThis.removeClass('error');
			},
			success: function(bool) {
				// console.log(bool);
				if (bool == false) {
					oThis.addClass('error');
				}
			}
		};
		$.ajax(oSettings);
	});
});