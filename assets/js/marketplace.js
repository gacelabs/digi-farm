$(document).ready(function() {
	var latlngs = $('#veggies_position').data('value');
	// console.log(latlngs);
	for(x in latlngs) {
		latlngs[x].lat = parseFloat(latlngs[x].lat);
		latlngs[x].lng = parseFloat(latlngs[x].lng);
		if (x == 0) {
			initMap(latlngs[x], $('#veggies-map').get(0));
		} else {
			addMarker(latlngs[x], true);
		}
	}
	markerCombiner();
});