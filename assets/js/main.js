$(document).ready(function() {

	$(".center").slick({
		arrows: false,
		dots: false,
		infinite: true,
		centerMode: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		autoplay: true,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					centerMode: true,
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

});