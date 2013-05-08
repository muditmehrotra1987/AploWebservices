<?php
	
	$server = 	'localhost';
	$username = 'root';
	$password = 'vertrigo';
	$database = 'test';
	
	// Connect to Database
	
	$link = @mysql_connect($server, $username, $password) or die ("Could not connect to server ... \n" . mysql_error ());	
	$db = @mysql_select_db($database, $link) or die ("Could not connect to database ... \n" . mysql_error ());
	
	$query = "select * from players";	
	$result = mysql_query($query, $link) or die(mysql_error());
	
	//$services = array();
	if(mysql_num_rows($result))
	{
		while($service = mysql_fetch_assoc($result)) 
		{
			$services[] = array('player'=>$service);
		}		
	}
	
	header('Content-type: application/json');
	echo json_encode($services);
	//OR
	//echo json_encode(array($services));
	
	@mysql_close($link);
	
?>