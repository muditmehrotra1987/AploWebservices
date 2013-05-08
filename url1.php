<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<?php 
	
		function keymaker($id){ 
			//generate the secret key anyway you like. It could be a simple string like in this example or a database 
			//look up of info unique to the user or id. It could include date/time to timeout keys. 
			$secretkey='1HutysK98UuuhDasdfafdCrackThisBeeeeaaaatchkHgjsheIHFH44fheo1FhHEfo2oe6fifhkhs'; 
			$key=md5($id.$secretkey); 
			return $key; 
		} 
		$contentid='123'; 
		/*$url='http://site.com/view.php?id=123&urlkey='.keymaker($contentid); 
		echo $url; */
		echo "<a href=url2.php?id=123&urlkey=".keymaker($contentid).">GO!!</a>";
	?>

</body>
</html>
