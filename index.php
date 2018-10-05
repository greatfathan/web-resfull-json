<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM device ORDER BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($mysqli, "SELECT * FROM device ORDER BY device_id DESC"); // using mysqli_query instead
?>

<html>
<head>	
	<title>e-Tilting</title>
</head>

<body>
<a href="add.html">Add New Data</a><br/><br/>

	<table width='80%' border=0>

	<tr bgcolor='#CCCCCC'>
		<td>Device ID</td>
		<td>Device Status</td>
		<td>Device Value</td>
		<td>Device Random</td>
		<td>Update</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['device_id']."</td>";
		echo "<td>".$res['device_status']."</td>";
		echo "<td>".$res['device_value']."</td>";	
		echo "<td>".$res['device_rand']."</td>";			
		echo "<td><a href=\"edit.php?id=$res[device_id]\">Edit</a> | <a href=\"delete.php?id=$res[device_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
</body>
</html>
