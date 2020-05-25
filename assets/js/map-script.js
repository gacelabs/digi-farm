
var map, markers = [];
var infowindow = new google.maps.InfoWindow({
	content: $('#info-window').length ? $('#info-window').html() : '<div></div>'
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

var geoLocation = function(mapUI) {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			initMap(pos, mapUI);
		}, function(a,b,c) {
			console.log(a,b,c);
			// handleLocationError(true, infoWindow, map.getCenter());
		});
	} else {
		// Browser doesn't support Geolocation
		console.log("Browser doesn't support Geolocation");
		// handleLocationError(false, infoWindow, map.getCenter());
	}
}