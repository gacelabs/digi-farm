$(window).on('load resize change', function() {

$("#featured-horizontal-slider .center").slick({
		arrows: false,
		dots: true,
		infinite: true,
		speed: 400,
		autoplay: true,
		slidesToShow: 1,
		adaptiveHeight: true,
		swipeToSlide: true,
	});

	$("#category-slider .center").slick({
		arrows: false,
		dots: false,
		infinite: true,
		centerMode: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		swipeToSlide: true,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					centerMode: true,
					slidesToShow: 2,
					slidesToScroll: 1
				}
			}
		]
	});

	$('#product-image-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '#product-thumbnail-slider.slider-nav'
	});
	$('#product-thumbnail-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '#product-image-slider.slider-for',
		dots: false,
		centerMode: false,
		focusOnSelect: true,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					arrows: false
				}
			}
		]
	});
});