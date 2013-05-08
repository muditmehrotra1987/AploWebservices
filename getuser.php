<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', 'vertrigo');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("test", $con);

$sql="SELECT * FROM players WHERE id = '".$q."'";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Firstname</th>
<th>Lastname</th>

</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['firstname'] . "</td>";
  echo "<td>" . $row['lastname'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?>