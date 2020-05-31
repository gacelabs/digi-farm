$(document).ready(function() {

	$('.product-image-thumb').on('click', function() {
		var image_element = $(this).find('img');
		$('.product-image').prop('src', $(image_element).attr('src'));
		$('.product-image-thumb.active').removeClass('active');
		$(this).addClass('active');
	});

	$('#qty').bind('blur input', function() {
		if ($.trim($(this).val()) == '' || (!isNaN($(this).val()) && parseInt($(this).val()) < 0)) {
			$(this).val(1);
		}
		// console.log($(this).val())
		var iVal = parseInt($(this).val());
		if (iVal > $(this).data('max')) {
			$(this).val($(this).data('max'));
		}
	});

});