<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Distance Finder</title>

<meta type="description" content="Find the distance between two places on the map and the shortest route."/>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

<script type="text/javascript">

	var location1;
	var location2;
	
	var address1;
	var address2;
	
	var latlng;
	var geocoder;
	var map;
	
	var distance;
	
	// finds the coordinates for the two locations and calls the showMap() function
	function initialize()
	{
		
		geocoder = new google.maps.Geocoder(); // creating a new geocode object
		
		// getting the two address values
		address1 = document.getElementById("address1").value;
		address2 = document.getElementById("address2").value;
		
		// finding out the coordinates
		if (geocoder)
		{
			geocoder.geocode( { 'address': address1}, function(results, status)
			{
				if (status == google.maps.GeocoderStatus.OK)
				{
					//location of first address (latitude + longitude)
					location1 = results[0].geometry.location;
				} else
				{
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
			geocoder.geocode( { 'address': address2}, function(results, status)
			{
				if (status == google.maps.GeocoderStatus.OK)
				{
					//location of second address (latitude + longitude)
					location2 = results[0].geometry.location;
					// calling the showMap() function to create and show the map
					showMap();
				} else
				{
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
		}

	}
	
	//create and show map
	function showMap()
	{
	
		// center of the map (compute the mean value between the two locations)
		latlng = new google.maps.LatLng((location1.lat()+location2.lat())/2,(location1.lng()+location2.lng())/2);
		
		// set map options
		// set zoom level
		// set center
		// map type
		
		var mapOptions = 
		{
			zoom: 1,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};
		
		// create a new map object
		// set the div id where it will be shown
		// set the map options
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		
		// show route between the points
		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.map.DirectionsRenderer({supressMarkers: true, supressInfoWindows: true});
		directionsDisplay.setMap(map);
		var request = {
			origin:location1, 
			destination:location2,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) 
		{
			if (status == google.maps.DirectionsStatus.OK) 
			{
				directionsDisplay.setDirections(response);
				distance = "The distance between the two points on the chosen route is: "+response.routes[0].legs[0].distance.text;
				distance += "<br/>The aproximative driving time is: "+response.routes[0].legs[0].duration.text;
				document.getElementById("distance_road").innerHTML = distance;
			}
		});
				// show a line between the two points
		var line = new google.maps.Polyline({
			map: map, 
			path: [location1, location2],
			strokeWeight: 7,
			strokeOpacity: 0.8,
			strokeColor: "#FFAA00"
		});
		
		// create the markers for the two locations		
		var marker1 = new google.maps.Marker({
			map: map, 
			position: location1,
			title: "First location"
		});
		var marker2 = new google.maps.Marker({
			map: map, 
			position: location2,
			title: "Second location"
		});
		
	}
	
	

</script>

</head>

<body>
</body>
</html>
