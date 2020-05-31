$(document).ready(function() {

	$('.product-image-thumb').on('click', function() {
		var image_element = $(this).find('img');
		$('.product-image').prop('src', $(image_element).attr('src'));
		$('.product-image-thumb.active').removeClass('active');
		$(this).addClass('active');
	});

});