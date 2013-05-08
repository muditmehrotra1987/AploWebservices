<?php

	$img = file_get_contents('images/remove1.png');
	$enc_img = base64_encode($img);
	
/*	echo "content-type:image/png; base64,".$enc_img;*/
	
	header("Content-type: image/png");
	$dec_img = base64_decode($enc_img);	
	echo '<img src="data:image/png;base64,' . base64_encode($img) . '" />';
?>