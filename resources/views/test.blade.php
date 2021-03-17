<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Finding Me</title>
<script>
function getLocation()
{
  // Check whether browser supports Geolocation API or not
  if (navigator.geolocation) { // Supported
  
    // To add PositionOptions
	
	navigator.geolocation.getCurrentPosition(getPosition);
  } else { // Not supported
	alert("Oops! This browser does not support HTML Geolocation.");
  }
}
function getPosition(position)
{ 
  var position_latitude_1 = -7.055286522681598;
  var position_longitude_1 = 107.56162952882028;
  // var position_latitude_2 = -7.05528851910623;
  // var position_longitude_2 = 107.5617468754628;
  var position_latitude_2 = position.coords.latitude;
  var position_longitude_2 = position.coords.longitude;
  var jarak = getDistanceFromLatLonInKm(position_latitude_1,position_longitude_1,position_latitude_2,position_longitude_2)
  console.log(jarak);
  document.getElementById("location").innerHTML = 
	  "Latitude: " + position_latitude_2 + "<br>" +
	  "Longitude: " + position_longitude_2;
}

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d *1000;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

// To add catchError(positionError) function
function catchError(positionError) {
  switch(positionError.code)
  {
	case positionError.TIMEOUT:
	  alert("The request to get user location has aborted as it has taken too long.");
	  break;
	case positionError.POSITION_UNAVAILABLE:
	  alert("Location information is not available.");
	  break;
	case positionError.PERMISSION_DENIED:
	  alert("Permission to share location information has been denied!");
	  break;
	default:
	  alert("An unknown error occurred.");
  }
}

</script>


</head>
<body>
<h1>Finding Me</h1>
<button onclick="getLocation()">Where am I?</button>
<p id="location"></p>
</body>
</html>