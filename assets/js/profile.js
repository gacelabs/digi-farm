$(document).ready(function() {
	$('.location-panel').each(function(i, elem) {
		var input = $(elem).find('.address').get(0);
		var autocomplete = new google.maps.places.Autocomplete(input);

		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			var lat = place.geometry.location.lat();
			var long = place.geometry.location.lng();
			$(elem).find('.latlng').attr('value', JSON.stringify({'lat': lat, 'lng': long}));
			if (markers[i] != undefined) {
				replaceMarker({'lat': lat, 'lng': long}, i);
			} else {
				if (i == 0) {
					initMap({'lat': lat, 'lng': long}, $('#map-box').get(0));
				} else {
					addMarker({'lat': lat, 'lng': long}, true);
				}
			}
		});

		if ($.trim($(input).val()) != '' && $.trim($(elem).find('.latlng').val())) {
			var latlng = $.parseJSON($(elem).find('.latlng').val());
			for (x in latlng) latlng[x] = parseFloat(latlng[x]);
			if (i == 0) {
				initMap(latlng, $('#map-box').get(0));
			} else {
				addMarker(latlng, true);
			}
		}
	});

	$('.new-farm').off('click').on('click', function(e) {
		var template = $('#farm-location-template').clone(true).removeAttr('id');
		template.find('input').val('');
		template.find('label').remove();
		$('#farm-location-template').parents('.card-body').append(template);

		var index = $('.location-panel:last').index()-1;
		template.find('input').each(function(i, elem) {
			$(elem).attr('name', 'user_location['+index+']['+$(elem).data('name')+']');
		});

		var input = template.find('.address').get(0);
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			var lat = place.geometry.location.lat();
			var long = place.geometry.location.lng();
			template.find('.latlng').attr('value', JSON.stringify({'lat': lat, 'lng': long}));
			if (markers[index] != undefined) {
				replaceMarker({'lat': lat, 'lng': long}, index);
			} else {
				addMarker({'lat': lat, 'lng': long}, true);
			}
		});
	});

	$('#current_password').off('blur').on('blur', function(e) {
		var oThis = $(this);
		var oSettings = {
			url: 'account/app_settings',
			type: 'post',
			dataType: 'json',
			data: {value: oThis.val()},
			beforeSend: function() {
				oThis.removeClass('error');
			},
			success: function(bool) {
				// console.log(bool);
				if (bool == false) {
					oThis.addClass('error');
				}
			}
		};
		$.ajax(oSettings);
	});
});

var map, markers = [];
var infowindow = new google.maps.InfoWindow({
	content: $('#info-window')/*.clone().removeClass('hide')*/.html()
});
var initMap = function(latlng, mapUI) {
	map = new google.maps.Map(mapUI, {
		zoom: 10,
		center: latlng
	});
	addMarker(latlng);
	google.maps.event.addListener(map, "click", function(event) {
		infowindow.close();
	});
}

var addMarker = function(latlng, add) {
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		/*draggable: true,*/
		animation: google.maps.Animation.DROP,
	});
	markers.push(marker);
	if (add == true) {
		marker.setMap(map);
		updateMap();
	}
	marker.addListener('click', function() {
		toggleAction(this);
	});
}

var replaceMarker = function(latlng, index) {
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		/*draggable: true,*/
		animation: google.maps.Animation.DROP,
	});
	markers[index].setMap(null);
	marker.setMap(map);
	markers[index] = marker;
	updateMap();
	marker.addListener('click', function() {
		toggleAction(this);
	});
}

var updateMap = function() {
	setTimeout(function() {
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markers.length; i++) {
			if (markers[i] != undefined) {
				bounds.extend(markers[i].getPosition());
			}
		}
		map.fitBounds(bounds);
	}, 1000);
}

var toggleAction = function(marker) {
	/*if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	} else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}*/
	if (marker.infowindow != undefined) {
		marker.infowindow.close();
	}
	infowindow.open(map, marker);
}