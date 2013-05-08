<?php
			
	$url = "http://apollowebservice.10summer.com/most_popular_service.php"; 
	$ch = curl_init(); // start CURL
	curl_setopt($ch, CURLOPT_URL, $url); // set your URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // get the response as a variable
	$json = curl_exec($ch); // connect and get your JSON response 
	curl_close($ch);
	
	$data = json_decode($json, true); //Passing the second argument as true to json_decode force it to return associative array.
//	var_dump($data);
	echo "*******************************************************Accessing Data from a Apollo Webservice**************************************************************";
	//accessing json data
	
	echo "<br>Service Id : ".$data[0]["services"]["service_id"]."<br>";
	echo "Service Name : ".$data[0]["services"]["service_name"]."<br>";
	echo "Popularity : ".$data[0]["services"]["popularity"]."<br><br>";
	
	echo "<br>Service Id : ".$data[1]["services"]["service_id"]."<br>";
	echo "Service Name : ".$data[1]["services"]["service_name"]."<br>";
	echo "Popularity : ".$data[1]["services"]["popularity"]."<br><br>"; 
	
	echo "<br>Service Id : ".$data[2]["services"]["service_id"]."<br>";
	echo "Service Name : ".$data[2]["services"]["service_name"]."<br>";
	echo "Popularity : ".$data[2]["services"]["popularity"]."<br><br>";
	
?>