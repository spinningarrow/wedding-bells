// For map
var renderMap = function (address) {
	
	// This is the minimum zoom level that we'll allow
	var minZoomLevel = 9;

	// Create a new roadmap setting the starting zoom level and center
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		zoomControl: true,
		center: new google.maps.LatLng(1.3416078021831142, 103.81290134257813),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	// Bounds for Singapore  
	var strictBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(1.2, 103), 
		new google.maps.LatLng(1.7, 105.03)
	);

	// Listen for the dragend event
	google.maps.event.addListener(map, 'dragend', function() {
		if ( strictBounds.contains(map.getCenter()) ) { return; }
		else { map.setCenter(pinLocation); }
	});

	// Limit the zoom level
	google.maps.event.addListener(map, 'zoom_changed', function() {
		if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
	});

	// Get "Singapore" and the zip code
	var zipcode = address.match(/singapore[\s]?[0-9]+$/i);
	zipcode = (zipcode !== null) ? zipcode[0] : address; // if matching didn't succeed, set it to address

	// Set the destination for the geolocationMap object
	geolocationMap.destinationName = zipcode;

	// Use Geocoder to convert address to latitude and longitude
	var geocoder = new google.maps.Geocoder();
	var pinLocation;

	geocoder.geocode(
		{
			'address': zipcode
		}, 
    
		function(results, status) {
			if(status == google.maps.GeocoderStatus.OK) {
				new google.maps.Marker({
					position: results[0].geometry.location,
					map: map,
					title: address
				});

				pinLocation = results[0].geometry.location;
				map.setCenter(pinLocation);
			}
		}
	);
};

// Geolocation using the Google Maps API
// Taken from http://blog.josemanuelperez.es/wp-content/demos/2010-07-maps-geoposition.html
// with several minor edits.
var geolocationMap = {

   destinationName: null, // this needs to be set by whatever calls the geolocation script

   getLocation: function (position) {
      geolocationMap.showMapAndRoute({ // apparently the 'this' reference is lost when this is used as a callback function, using the object name instead
         "lat": position.coords.latitude, 
         "lng": position.coords.longitude
      });
   },

   initiate_geolocation: function (skipHTML5) {

      if (!skipHTML5 && navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(this.getLocation, this.error);
      }

      else {
         
         // Google AJAX API fallback GeoLocation
         if (typeof google == 'object') {
            
            var geocoder = new google.maps.Geocoder();
            
            if (google.loader.ClientLocation) {
               
               this.showMapAndRoute({
                  "lat": google.loader.ClientLocation.latitude,
                  "lng": google.loader.ClientLocation.longitude
               });
            }

            else {
               console.log("Google Geocoder was unable to get the client position");
            }
         }
      }
   },

   showMapAndRoute: function (l) {

      var latlng = new google.maps.LatLng(l.lat,l.lng);

      var myOptions = {
         zoom: 8,
         mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      var map = new google.maps.Map(document.getElementById("map"), myOptions);
      var directionsDisplay = new google.maps.DirectionsRenderer();
      directionsDisplay.setMap(map);

      var request = {
         origin: l.lat + ',' + l.lng , 
         destination: this.destinationName,
         travelMode: google.maps.DirectionsTravelMode.DRIVING
      };
      
      var directionsService = new google.maps.DirectionsService();
      
      directionsService.route(request, function(result, status) {
      
         if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
         }
      });   
   },

   error: function (e) {

      switch(e.code) {

         case e.TIMEOUT:
            console.log('Timeout');
            break;
         
         case e.POSITION_UNAVAILABLE:
            console.log('Position unavailable');
            break;
         
         case e.PERMISSION_DENIED:
            console.log('Permission denied');
            break;
         
         case e.UNKNOWN_ERROR:
            console.log('Unknown error');
            break;
      }

      //try to get location using Google Geocoder
      this.initiate_geolocation(true);
   },
};