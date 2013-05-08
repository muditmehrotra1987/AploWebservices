<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
		function msg()
		{
			/*var x = document.getElementById("flagvar").value;*/
			/*if(x == "1")*/
			window.location.href = "login.php";
			document.getElementById("login_failed").innerHTML = "Login Failed.Please enter your correct username and password";
        }
</script>
</head>

<body>
<?php
	if(isset($_POST) && array_key_exists('username', $_POST))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$isExist = false;
		if($username == "admin" && $password == "admin")
		{
			$isExist = true;
			echo "<script>alert('login');</script>";
			
			
		}
		
		if($isExist == false)
		{
			/*echo "<script>document.getElementById('msg').innerHTML='Wrong username or password';</script>";*/
			/*echo "<script>window.location.href='jlogin.php';</script>";*/
			echo "<script>msg();</script>";
		}
		
	}
	else
	{
?>


	<form id="login" name="login" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
		
    	<span id="login_failed"></span>
        <input type="hidden" id="flagvar" name="flagvar" /><br />
<br />

    	<label for="username">Username</label><input type="text" name="username" id="username" /><br />
<br />

        <label for="password">Password</label><input type="password" name="password" id="password" />
        <input type="submit" id="submit" name="submit" value="LogIn" />
    </form>
    
<?php } ?>
</body>
</html>
