$(window).on('load resize', function() {

	setTimeout(function() {
		$('.product-image-blowup').css('height', $('.product-image-blowup').width());

		$('.product-image-thumb').css('height', $('.product-image-thumb').width()+18);
	},300);

});