<div id="map" style="width: 600px; height: 400  px;"></div> 
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript"> 

   // This is the minimum zoom level that we'll allow
   var minZoomLevel = 9;
   var address = '<?php echo $address; ?>';//'Buona Vista MRT, Singapore';

   var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(1.3416078021831142, 103.81290134257813),
      mapTypeId: google.maps.MapTypeId.ROADMAP
   });

   var geocoder = new google.maps.Geocoder();

      var pinLocation;

      geocoder.geocode({
         'address': address
      }, 
      function(results, status) {
         if(status == google.maps.GeocoderStatus.OK) {
            new google.maps.Marker({
               position: results[0].geometry.location,
               map: map,
               title: '<?php echo $address; ?>'
            });

            pinLocation = results[0].geometry.location;
            map.setCenter(pinLocation);
         }
      });

   // Bounds for Singapore  
   var strictBounds = new google.maps.LatLngBounds(
     new google.maps.LatLng(1.2, 103), 
     new google.maps.LatLng(1.7, 105.03)
   );

      // Listen for the dragend event
      google.maps.event.addListener(map, 'dragend', function() {
         if ( strictBounds.contains(map.getCenter()) ) { return; }
         else {  console.log(map.getCenter()); map.setCenter(pinLocation); }
      });

   // Limit the zoom level
   google.maps.event.addListener(map, 'zoom_changed', function() {
     if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
   });

</script>