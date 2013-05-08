<!--Code to calculate longitude and latitude-->
<?php

$address = "India+Allahabad";
$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
$response_a = json_decode($response);
$lat = $response_a->results[0]->geometry->location->lat;
echo "Latitude =  ". $lat;
echo "<br />";
$long = $response_a->results[0]->geometry->location->lng;
echo "Longitude =  ". $long;

?>
<!--****************************************************************************************************************************************************************-->

<!--Code to calculate distance between two longitudes and latitudes-->
<?php

function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  
  if ($unit == "K") 
  {
    return ($miles * 1.609344); 
  } 
  else if ($unit == "N") 
  {
      return ($miles * 0.8684);
  } 
  else 
  {
      return $miles;
  }  
}

echo "<br><br>".distance(32.9697, -96.80322, 29.46786, -98.53506, "m") . " miles";
echo "<br><br>".distance(32.9697, -96.80322, 29.46786, -98.53506, "k") . " kilometers";
echo "<br><br>".distance(32.9697, -96.80322, 29.46786, -98.53506, "n") . " nautical miles";

?>