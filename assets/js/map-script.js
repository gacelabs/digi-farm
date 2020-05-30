
var map, markers = [];
var infowindow = new google.maps.InfoWindow({
	content: $('#info-window').length ? $('#info-window').html() : '<div></div>'
});

var initMap = function(latlng, mapUI) {
	map = new google.maps.Map(mapUI, {
		zoom: 9,
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
	}
	updateMap();
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
		// markerCombiner();
		if (markers.length == 1) {
			map.setZoom(9);
		}
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
		}, function(error) {
			console.log(error);
			// handleLocationError(true, infoWindow, map.getCenter());
		});
	} else {
		// Browser doesn't support Geolocation
		console.log("Browser doesn't support Geolocation");
		// handleLocationError(false, infoWindow, map.getCenter());
	}
}

var markerCombiner = function() {
	setTimeout(function() {
		var markerCluster = new MarkerClusterer(map, markers, {
			imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
		});
		/*var mcOptions = {
			styles:[{
				url: "/assets/admin/images/map-cluster-green.svg",
				width: 34,
				height:34,
				fontFamily:"comic sans ms",
				textSize:12,
				textColor:"#FFFFFF",
			}]
		};
		var markerCluster = new MarkerClusterer(map, markers, mcOptions);*/
	}, 1500);
}