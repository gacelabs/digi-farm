$(document).ready(function() {
	$('.location-panel').each(function(i, elem) {
		var input = $(elem).find('.address').get(0);
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			var lat = place.geometry.location.lat();
			var long = place.geometry.location.lng();
			$(elem).find('.latlng').attr('value', JSON.stringify({'lat': lat, 'lng': long}));
			initMap({'lat': lat, 'lng': long}, $(elem).find('.map-box').get(0));
		});
		if ($.trim($(input).val()) != '' && $.trim($(elem).find('.latlng').val())) {
			var latlng = $.parseJSON($(elem).find('.latlng').val());
			for (x in latlng) latlng[x] = parseFloat(latlng[x]);
			// console.log(latlng);
			initMap(latlng, $(elem).find('.map-box').get(0));
		}
	});

	$('.new-farm').off('click').on('click', function(e) {

	});
});

var initMap = function(latlng, mapUI) {
	var map = new google.maps.Map(mapUI, {
		zoom: 10,
		center: latlng
	});
	var marker = new google.maps.Marker({
		position: latlng,
		map: map
	});
}