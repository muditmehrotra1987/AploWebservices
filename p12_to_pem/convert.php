<?php
$filename = 'Henk.p12';
$password = 'henk';
$results = array();
$worked = openssl_pkcs12_read(file_get_contents($filename), $results, $password);

	if($worked)
	{
		echo '<pre>', print_r($results, true), '</pre>';
		$handle = fopen("D:\\pem_file\\henk_pem.pem", "w");
		fwrite($handle, $results['pkey']);
	} 
	else 
	{
		echo openssl_error_string();
	}
?>