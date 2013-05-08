<?php
	if(isset($_POST['address']))
	{
		/*$address = "Allahabad+India";*/
		
		$address = urlencode($_POST['address']);
		
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
		$long = $response_a->results[0]->geometry->location->lng;
		$formatted_address = $response_a->results[0]->formatted_address;
		
		echo "<h2>Latitude of ".urldecode($address)." =  ".$lat."</h2>";		
		echo "<h2>Longitude of ".urldecode($address)." =  ".$long."</h2>";
		
		/*echo "<h1> Formatted Address is : ".$formatted_address."</h1>";*/
		
		?>
        <u><h2><?php echo urldecode($address); ?> on Google Map!</h2></u>
        <iframe width="960" height="550" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address;?>&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formatted_address);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
		
<?php
		echo "<br><br><a href='google_maps2.php'>Back to find more Longitude and Latitude</a>";
	}	
	else
	{	
?>	
    <form name="address" id="address" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    	<label for="address">Enter your address here : </label><input type="text" name="address" id="address" />
        <input type="submit" name="submit" value="Find my Latitude &amp; Longitude" id="submit" />
    </form> 
    	
<?php	
	}	
?>