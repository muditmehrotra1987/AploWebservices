<?php
			
	$url = "http://localhost/zxzx/webservice_test.php"; 
	$ch = curl_init(); // start CURL
	curl_setopt($ch, CURLOPT_URL, $url); // set your URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // get the response as a variable
	$json = curl_exec($ch); // connect and get your JSON response 
	curl_close($ch);
	
	$data = json_decode($json, true); //Passing the second argument as true to json_decode force it to return associative array.
	//	var_dump($data);
	echo "*******************************************************Accessing Data from a JSON Webservice**************************************************************";
	//accessing json data
	
	echo "<br>id : ".$data[0]["player"]["id"]."<br>";
	echo "First Name : ".$data[0]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[0]["player"]["lastname"]."<br><br>";
	
	echo "id : ".$data[1]["player"]["id"]."<br>";
	echo "First Name : ".$data[1]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[1]["player"]["lastname"]."<br><br>";	
	
	echo "id : ".$data[2]["player"]["id"]."<br>";
	echo "First Name : ".$data[2]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[2]["player"]["lastname"]."<br><br>";
	
	echo "id : ".$data[3]["player"]["id"]."<br>";
	echo "First Name : ".$data[3]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[3]["player"]["lastname"]."<br><br>";
	
	echo "id : ".$data[4]["player"]["id"]."<br>";
	echo "First Name : ".$data[4]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[4]["player"]["lastname"]."<br><br>";
	
	echo "id : ".$data[5]["player"]["id"]."<br>";
	echo "First Name : ".$data[5]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[5]["player"]["lastname"]."<br><br>";	
	
	echo "id : ".$data[6]["player"]["id"]."<br>";
	echo "First Name : ".$data[6]["player"]["firstname"]."<br>";
	echo "Last Name : ".$data[6]["player"]["lastname"]."<br><br>";	
	
	/**************Print data using Loop**************************/
	echo "******************************************Accessing Data from a JSON Webservice using while() loop*******************************************************";
	$i = 0;
	while(sizeof($data)> $i)
	{
		echo "<br>id : ".$data[$i]["player"]["id"]."<br>";
		echo "First Name : ".$data[$i]["player"]["firstname"]."<br>";
		echo "Last Name : ".$data[$i]["player"]["lastname"]."<br><br>";
		$i++;
	}
?>