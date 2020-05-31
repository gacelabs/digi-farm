$(document).ready(function() {
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

	$('.home-panel').each(function(i, elem) {
		var mapUI = $('#map-box-'+i).attr('data-index', i).get(0);
		var thisLatLng = currLatLng;
		if ($('#latlng').val() != '') {
			thisLatLng = $.parseJSON($('#latlng').val());
		}
		for (x in thisLatLng) thisLatLng[x] = parseFloat(thisLatLng[x]);

		var map = new google.maps.Map(mapUI, {
			zoom: 19,
			center: thisLatLng
		});
		// maps.push(map);
		var marker = new google.maps.Marker({
			position: thisLatLng,
			map: map,
			draggable: true,
			animation: google.maps.Animation.DROP,
		});
		// markers.push(marker);
		setDragEvent(marker);

		var input = $(elem).find('.address').attr('data-index', i).get(0);
		var autocomplete = new google.maps.places.Autocomplete(input);

		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			var lat = place.geometry.location.lat();
			var long = place.geometry.location.lng();
			// console.log({'lat': lat, 'lng': long})
			$('#latlng').attr('value', JSON.stringify({'lat': lat, 'lng': long}));
			
			google.maps.event.clearListeners(marker, 'dragend');
			marker.setMap(null);
			var newMark = new google.maps.Marker({
				position: {'lat': lat, 'lng': long},
				map: map,
				draggable: true,
				animation: google.maps.Animation.DROP,
			});

			newMark.setMap(map);
			setDragEvent(newMark);
			var bounds = new google.maps.LatLngBounds();
			bounds.extend(newMark.getPosition());
			map.fitBounds(bounds);
		});
	});
});

function setDragEvent(marker) {
	google.maps.event.addListener(marker, 'dragend', function () {
		var uiInputAddress = $('#home_address');

		var position = marker.getPosition();
		$('#lat').attr('value', position.lat());
		$('#lng').attr('value', position.lng());

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			latLng: position
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				console.log(results[0].formatted_address);
				uiInputAddress.attr('value', results[0].formatted_address);
				uiInputAddress.val(results[0].formatted_address);
			} else {
				console.log(status);
				uiInputAddress.attr('value', '');
				uiInputAddress.val('');
			}
		});
	});
}