<!DOCTYPE html>
<?php ?>
<html> 
<head> 
   <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
   <title>Google Maps JavaScript API v3 Example: Limit Panning and Zoom</title> 
   <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
   <script src="http://www.google.com/jsapi"></script>
   <!-- http://blog.josemanuelperez.es/wp-content/demos/2010-07-maps-geoposition.html -->
</head> 
<body> 
   <div id="map" style="width: 600px; height: 600px;"></div> 

   <script type="text/javascript"> 
  
   // This is the minimum zoom level that we'll allow
   var minZoomLevel = 9;
   var address = 'Singapore 637658';

   // Create a new roadmap setting the starting zoom level and center
   var map = new google.maps.Map(document.getElementById('map'), {
      zoom: minZoomLevel,
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
      if ( strictBounds.contains(map.getCenter()) ) {
         return; 
      }
      else { 
         map.setCenter(pinLocation); 
      }
   });

   // Limit the zoom level
   google.maps.event.addListener(map, 'zoom_changed', function() {
      if (map.getZoom() < minZoomLevel) {
         map.setZoom(minZoomLevel);
      }
   });

   // Use Geocoder to convert address to latitude and longitude
   var geocoder = new google.maps.Geocoder();
   var pinLocation;
   
   geocoder.geocode(
      {
         'address': address
      },
      
      function(results, status) {
         if(status == google.maps.GeocoderStatus.OK) {
            new google.maps.Marker({
               position: results[0].geometry.location,
               map: map
            });

            pinLocation = results[0].geometry.location;
            map.setCenter(pinLocation);
         }
   });

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

</script>

<!--
<script>
// Geolocation
/*
var map;

      function initialize() {
        var myOptions = {
          zoom: 6,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map'),
            myOptions);

        // Try HTML5 geolocation
        if(navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                                             position.coords.longitude);

            var infowindow = new google.maps.InfoWindow({
              map: map,
              position: pos,
              content: 'Location found using HTML5.'
            });

            map.setCenter(pos);
          }, function() {
            handleNoGeolocation(true);
          });
        } else {
          // Browser doesn't support Geolocation
          handleNoGeolocation(false);
        }
      }

      function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
          var content = 'Error: The Geolocation service failed.';
        } else {
          var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
          map: map,
          position: new google.maps.LatLng(60, 105),
          content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
      }

      google.maps.event.addDomListener(window, 'load', initialize);*/
</script>
-->