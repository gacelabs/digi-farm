$(document).ready(function() {

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

});


$(window).on('load change resize', function() {

	$('.card-image>img').css('height', $('.card-image>img').width()+10);
});