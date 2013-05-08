<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ajax Pagination: Fresh Ajax pagination using PHP jQuery and mySQL.  99Points.Info Demos</title>
<link rel="stylesheet" type="text/css" media="screen" href="css.css" />
<script type="text/javascript" src="../assets/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="js.js"></script>
<script type="text/javascript" src="jquery-1.3.2.js"></script>
</head>
<body>


<?php
$per_page = 4;
include("dbcon.php");
$sql = "select * from records";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$pages = ceil($count/$per_page)
?>
<div align="center">

	
	<h1>Ajax Pagination: Fresh Ajax pagination using PHP jQuery and mySQL</h1>
	<div id="container">
	
		<div class="search-background">
			<label><img src="loader.gif" alt="" /></label>
		</div>
	
		<div id="content"></div>
	</div>
	<div id="paging_button">
		<ul>
		<?php
		//Show page links
		for($i=1; $i<=$pages; $i++)
		{
			echo '<li id="'.$i.'">'.$i.'</li>';
		}?>
		</ul>
	</div>
</div>


</body>
</html>
