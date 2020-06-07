$(document).ready(function() {

	var subtotal = parseFloat($('#subtotal').text());
	var total = parseFloat($('#total_amount').text());
	$('.delivery_option').off('click').on('click', function(e) {
		if ($(this).is(':checked')) {
			$('#step_2').removeClass('d-none');
			$('#delivery_fee').removeClass('d-none');
			total = subtotal + $('#delivery_fee').data('price');
		} else {
			$('#step_2').addClass('d-none');
			$('#delivery_fee').addClass('d-none');
			$('.payment_method_id').removeAttr('checked');
			total -= $('#delivery_fee').data('price');
		}
		$('#total_amount').text(total);
	});

	$('.payment_method_id').off('click').on('click', function(e) {
		total = subtotal + $('#delivery_fee').data('price');
		if (!$(this).is(':checked')) {
			$('#step_3').addClass('d-none');
			$('#transaction_fee').addClass('d-none');
		} else {
			$('#transaction_fee').removeClass('d-none');
			total += $('#transaction_fee').data('price');
			$('#step_3').removeClass('d-none');
		}
		$('#total_amount').text(total);
	});

});