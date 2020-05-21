$(document).ready(function() {

	$("#category-slider .center").slick({
		arrows: false,
		dots: false,
		infinite: true,
		centerMode: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					centerMode: true,
					slidesToShow: 3,
					slidesToScroll: 1
				}
			}
		]
	});

	$("#featured-horizontal-slider .center").slick({
		arrows: false,
		dots: true,
		infinite: true,
		speed: 400,
		autoplay: true,
		slidesToShow: 1,
		adaptiveHeight: true
	});

	$("#featured-vertical-slider .center").slick({
		vertical: true,
		arrows: false,
		dots: false,
		infinite: false,
		speed: 400,
		autoplay: false,
		slidesToShow: 2,
		adaptiveHeight: true
	});
});