$(document).ready(function() {
	$('.location-panel').each(function(i, elem) {
		var input = $(elem).find('.address').attr('data-index', i).get(0);
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

		if ($.trim($(elem).find('.latlng').val())) {
			var latlng = $.parseJSON($(elem).find('.latlng').val());
			for (x in latlng) latlng[x] = parseFloat(latlng[x]);
			if (i == 0) {
				initMap(latlng, $('#map-box').get(0));
			} else {
				addMarker(latlng, true);
			}
		}
		$(input).off('blur').on('blur', function() {
			if ($.trim($(this).val()) == '' && markers.length > 1) {
				markers[$(this).data('index')].setMap(null);
			}
		});
	});

	$('.new-farm').off('click').on('click', function(e) {
		var template = $('#farm-location-template').length ? $('#farm-location-template').clone(true).removeAttr('id') : $('[data-index=0]').clone(true);
		var index = $('.location-panel').length;
		template.attr('data-index', index);
		template.find('input').val('');
		template.find('label:eq(0)').remove();
		template.find('label:eq(1)').remove();
		$('#farm-location-template').parents('.card-body').append(template);
		// template.insertAfter($('#map-box'));

		// var index = $('.location-panel:last').index()-1;
		template.find('input').each(function(i, elem) {
			if ($(elem).data('name') != 'latlng') {
				$(elem).prev().find('label').attr('for', $(elem).data('name')+index);
			}
			$(elem).attr({'name':'user_location['+index+']['+$(elem).data('name')+']', 'id':$(elem).data('name')+index});
		});

		var input = template.find('.address').attr('data-index', index).get(0);
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
		$(input).off('blur').on('blur', function() {
			if ($.trim($(this).val()) == '' && markers.length > 1) {
				markers[$(this).data('index')].setMap(null);
			}
		});
	});

	bsCustomFileInput.init();
});