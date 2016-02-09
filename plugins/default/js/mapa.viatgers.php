/*
 * Marca els viatges de l'usuari a Google Maps
 */

var map;
var trips;
var img_trips = "<?php echo ossn_site_url("components/option-trips/images/img_trips.png"); ?>";      
var img_live_logo = "<?php echo ossn_site_url("components/option-trips/images/live_logo.png"); ?>";

function initialize() {
      <!-- var img_trips = 'components/option-trips/images/img_trips.png'; -->
      <!-- var img_trips = <?php ossn_site_url(); ?> + 'components/option-trips/images/img_trips.png'; -->
      
       
      trips = $.post("<?php echo ossn_site_url("components/OptionTrips/actions/map/get.php"); ?>", function(respo){
                 alert(respo);
                 //var parsed = JSON.parse(respo);
                 //alert(parsed[0][1]);
                 //var trips = [];
                 //for(var i in parsed){
                   // trips.push(parsed[i]);
                 //}
                 //alert(parsed);
                 //return parsed;
               });

     //alert(trips[0]);  
        
     
     
     
      var live = [['Barcelona', 41.38506389999999, 2.1734034999999494]];
      /* 
      var trips = [
        ['San Francisco', 37.7749295, -122.41941550000001],
        ['Mountain View', 37.3860517, -122.0838511],
        ['Dublin', 53.3498053, -6.260309699999993],
        ['Roma', 41.90278349999999, 12.496365500000024]
      ];*/
      //Configuració posicionament mapa per defecta
      map = new google.maps.Map(document.getElementById('google-map-trips'), {
        zoom: 1,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: google.maps.MapTypeId.HYBRID
      });
      var infowindow = new google.maps.InfoWindow();
      var marker, i;

      //Marca on viu actualment usuari
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(live[0][1], live[0][2]),
        title: live[0][0],
        map: map,
        icon: img_live_logo,
        animation: google.maps.Animation.DROP
      });
      
      //Recorre bucle array marcan posicions viatges
      for (i = 0; i < trips.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(trips[i][1], trips[i][2]),
          map: map,
          icon: img_trips//,
          //animation: google.maps.Animation.DROP //BOUNCE o DROP
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(trips[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }

/*Agafar latitude i Longitude*/
var address = (document.getElementById('my-address'));
  var autocomplete = new google.maps.places.Autocomplete(address);
  autocomplete.setTypes(['geocode']);
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
    if (!place.geometry) {
          return;
      }

    var address = '';
    if (place.address_components) {
        address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
    }
  });
}
function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("my-address").value;
    //alert(address);
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
           marker = new google.maps.Marker({
              position: new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()),
              title: address,
              map: map,
              icon: img_trips,
             
           });

         

          //alert("Latitude: "+results[0].geometry.location.lat());
          //alert("Longitude: "+results[0].geometry.location.lng());
      } 

      else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}


    google.maps.event.addDomListener(window, 'load', initialize);
