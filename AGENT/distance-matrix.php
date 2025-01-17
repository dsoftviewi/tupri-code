<!DOCTYPE html>
<html>
  <head>
    <title>localDis Matrix service</title>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #map-canvas {
        height: 100%;
        width: 50%;
      }
      #content-pane {
        float:right;
        width:48%;
        padding-left: 2%;
      }
      #outputDiv {
        font-size: 11px;
      }
    </style>
    <script>
var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];

//var origin1 = new google.maps.LatLng(55.930, -3.118);
var origin2 = 'Madurai,Tamilnadu,India';
var destinationA = 'Chennai,TamilNadu,India';
var destinationB = 'Tiruchirappalli,TamilNadu,India';
//var destinationB = new google.maps.LatLng(50.087, 14.421);

var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

function initialize() {
  var opts = {
    center: new google.maps.LatLng(55.53, 9.4),
    zoom: 10
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), opts);
  geocoder = new google.maps.Geocoder();
}

function calculateDistances() {
	geocoder = new google.maps.Geocoder();
  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [origin2],
      destinations: [destinationA,destinationB],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false
    }, callback);
}

function callback(response, status) {
	
  if (status != google.maps.DistanceMatrixStatus.OK) {
    alert('Error was: ' + status);
  } else {
    var origins = response.originAddresses;
    var destinations = response.destinationAddresses;
    var outputDiv = document.getElementById('outputDiv');
    outputDiv.innerHTML = '';
    //deleteOverlays();

    for (var i = 0; i < origins.length; i++) {
      var results = response.rows[i].elements;
     // addMarker(origins[i], false);
      for (var j = 0; j < results.length; j++) {
        //addMarker(destinations[j], true);
		alert('dis '+results[j].distance.text);
        outputDiv.innerHTML += origins[i] + ' to ' + destinations[j]
            + ': ' + results[j].distance.text + ' in '
            + results[j].duration.text + '<br>';
      }
    }
  }
}

/*function addMarker(location, isDestination) {
  var icon;
  if (isDestination) {
    icon = destinationIcon;
  } else {
    icon = originIcon;
  }
  geocoder.geocode({'address': location}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      bounds.extend(results[0].geometry.location);
      map.fitBounds(bounds);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        icon: icon
      });
      markersArray.push(marker);
    } else {
      alert('Geocode was not successful for the following reason: '
        + status);
    }
  });
}

function deleteOverlays() {
  for (var i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(null);
  }
  markersArray = [];
}*/

//google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="content-pane">
      <div id="inputs">
        <pre>
var origin1 = new google.maps.LatLng(55.930, -3.118);
var origin2 = 'Greenwich, England';
var destinationA = 'Stockholm, Sweden';
var destinationB = new google.maps.LatLng(50.087, 14.421);
        </pre>
        <p><button type="button" onclick="calculateDistances();">Calculate
          distances</button></p>
      </div>
      <div id="outputDiv"></div>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>