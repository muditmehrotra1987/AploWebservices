<html>
<head></head>
<body>
<input type="checkbox" checked="checked" name="bdrm[]" value="Any">
<input type="checkbox" name="bdrm[]" value="1">
<input type="checkbox" name="bdrm[]" value="2">
<input type="checkbox" name="bdrm[]" value="3">

<input type="checkbox" checked="checked" name="btrm[]" value="Any">
<input type="checkbox" name="btrm[]" value="1">
<input type="checkbox" name="btrm[]" value="2">

<input type="checkbox" checked="checked" name="pets[]" value="Any">
<input type="checkbox" name="pets[]" value="Yes">
<input type="checkbox" name="pets[]" value="No">

<?php
	var_dump( mail( '+919935084204@airtel.com', '', 'This was sent with PHP.' ) );
?>
</body>
</html>