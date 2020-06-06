$(window).on('load resize', function() {

	setTimeout(function() {
		$('.product-image-blowup').css('height', $('.product-image-blowup').width());

		$('.square-me').each(function() {
			var thisWidth = $(this).outerWidth();

			$(this).css('height', thisWidth);
		});	

		$('.product-image-thumb').css('height', $('.product-image-thumb').width()+18);
	},200);

});