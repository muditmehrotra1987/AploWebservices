<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jscript Test</title>
<script type="text/javascript">
	function touchButton()
	{
		var username = prompt("What is your name?", "Enter your name here");
		if(username)
		{
			alert("Its nice to meet you "+username+".");
			document.getElementById("cbutton").src = "images/remove2.png";
		}
	}
	function chknumber()
	{
		if(isNaN(document.getElementById("ChkNumber").value))
		{
			alert("It accept only integer value");
		}
	}
	function chkName()
	{
		if(document.getElementById("chkName").value == "" || document.getElementById("chkName").value == null)
		{
			alert("Cannot be blank");
		}
	}
</script>
</head>

<body onload="alert('Welcome User');">
	<img name="cbutton" id="cbutton" src="images/remove1.png" onclick="touchButton();" />
    <form name="order" id="order" method="post">
    	<input type="text" id="ChkNumber" name="ChkNumber" onchange="chknumber();" /><br />
        <input type="text" id="chkName" name="chkName" onblur="chkName();" />
    </form>
</body>
</html>