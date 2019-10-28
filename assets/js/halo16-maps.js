var map;
var bounds;
var geocoder;
var service;
var place_ids;

function initialize() {

	var mapOptions = {
		zoom: 16,
		center: new google.maps.LatLng(43.9966644, 12.6515318),
		scrollwheel: false
	};

	map = new google.maps.Map(document.getElementById('halo16_map_'+halo16_maps.id), mapOptions);
	bounds = new google.maps.LatLngBounds();
	geocoder = new google.maps.Geocoder();
	service = new google.maps.places.PlacesService(map);
	place_ids = halo16_maps.map_place_id.split(',');

	getDetails(service,place_ids,0);

}

function getDetails(service,place_ids,i){
	if(i>=place_ids.length) return;
	service.getDetails({
				placeId: place_ids[i],
		}, function(place, status) {
				if (status === google.maps.places.PlacesServiceStatus.OK) {
						bounds.extend(place.geometry.location);
						mapsCallback(map,place.geometry.location,'map-pointer'+i);
				} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
		getDetails(service,place_ids,i+1);

	});
}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3&key='+halo16_maps.map_key+'&libraries=places&callback=initialize';
	document.body.appendChild(script);
}

function mapsCallback(map,center, icon){

	var image = {
	   url: halo16_maps.theme_folder + '/assets/images/' +icon+'.png',
	   scaledSize: new google.maps.Size(39, 60),
	};

	var marker = new google.maps.Marker({
		map: map,
		icon: image,
		position: center
	});

	var infowindow = null;

	google.maps.event.addDomListener(window, 'resize', function() {
		map.setCenter(center);
	});

	google.maps.event.addDomListener(marker, 'click', function() {
		if(infowindow){
			infowindow.open(map, marker);
		}
	});

	if(place_ids.length>1){
		map.setCenter(bounds.getCenter());
		map.fitBounds(bounds);
	} else {
		map.setCenter(center);
	}


}

window.onload = loadScript;
