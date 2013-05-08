<?php
$filename = 'Henk.p12';
$password = 'henk';
$results = array();
$worked = openssl_pkcs12_read(file_get_contents($filename), $results, $password);

	if($worked)
	{
		echo '<pre>', print_r($results, true), '</pre>';
		/**/
		/*$new_password = NULL;
		$result = NULL;*/
		$handle = fopen("D:\\pem_file\\henk_pem.pem", "w");
		fwrite($handle, $results['pkey']);
      	/*$worked = openssl_pkey_export_to_file($results['pkey'], "D:\\pem_file\\henk_pem.pem", $new_password);*/
		/*if($worked) 
		{*/
			 /*$uploadDirectory = "";
			 $filename = "";*/
			/* $file=fopen("D:\\pem_file\\henk_pem.pem","w+");
			 file_put_contents($file, $result);
			 echo "This is working";*/
			 /*return array(
				'success' => true,
				'filename'=>$filename . '.pem',
				'uploaddir' =>$uploadDirectory,
			 );*/
      /*	} 
		else
		{
         	return array('error' => openssl_error_string());
      	}*/
	} 
	else 
	{
		echo openssl_error_string();
	}
?>
<?php
/*	$ourFileName = "D:\\pem_file\\testFile.pem";
	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
	fclose($ourFileHandle);*/
?>