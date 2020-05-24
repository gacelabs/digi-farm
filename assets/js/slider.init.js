$(document).ready(function() {

	$(".location-slider").slick({
		arrows: false,
		dots: false,
		infinite: true,
		centerMode: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		swipeToSlide: true,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

});