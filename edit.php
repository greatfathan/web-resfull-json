<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{			
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$device_value = mysqli_real_escape_string($mysqli, $_POST['device_value']);	
	$device_status = mysqli_real_escape_string($mysqli, $_POST['device_status']);	
	
	// checking fields 
	// for checking alfa numeric can use : ctype_alnum($var)
	if (!is_numeric($device_status) || !is_numeric($device_value)){		
		
		if(!is_numeric($device_status)) {
			echo "<font color='red'>Device status is not numeric.</font><br/>";
			echo "<br/><br/><a href='index.php'>Home</a>";	
		}
		
		if(!is_numeric($device_value)) {
			echo "<font color='red'>Device value field is not numeric.</font><br/>";
			echo "<br/><br/><a href='index.php'>Home</a>";	
		}	
	} else {	
		// updating the table
		// finally found the bugs, and now can updated SQL
		// https://stackoverflow.com/questions/23913629/php-cant-update-sql
		// https://www.webmasterworld.com/php/4351193.htm	
		// $randid = rand(100000,999999);
		$sqlupd = "UPDATE device SET device_value='$device_value', device_status='$device_status', device_rand='".rand(100000,999999)."' WHERE device_id='$id'";
		$result = mysqli_query($mysqli, $sqlupd);

		//redirectig to the display pdevice_status. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
// getting id from url
// isset for filter if there is no value for get
if (isset($_GET['id'])){
	$id = $_GET['id'];

	//selecting data associated with this particular id
	$result = mysqli_query($mysqli, "SELECT * FROM device WHERE device_id='$id'");  

	while($res = mysqli_fetch_array($result))
	{	
		$device_status = $res['device_status'];
		$device_value = $res['device_value'];
		$device_random = $res['device_rand'];
	}
	?>
	<html>
	<head>	
		<title>Edit Data</title>
	</head>

	<body>
		<a href="index.php">Home</a>
		<br/><br/>
		
		<form name="form1" method="post" action="edit.php">
			<table border="0">
				<tr> 
					<td>Device ID</td>
					<td><input type="text" name="device_id" value="<?php echo $_GET['id'];?>" disabled></td>
				</tr>
				<tr> 
					<td>Device Value</td>
					<td><input type="text" name="device_value" value="<?php echo $device_value;?>"></td>
				</tr>
				<tr> 
					<td>Device Status</td>
					<td><input type="text" name="device_status" value="<?php echo $device_status;?>"></td>
				</tr>	
				<tr> 
					<td>Device Random</td>
					<td><input type="text" name="device_random" value="<?php echo $device_random;?>" disabled></td>
				</tr>		
				<tr>
					<td><input type="hidden" name="id" value="<?php echo $_GET['id'];?>"</td>
					<td><input type="submit" name="update" value="Update"></td>
				</tr>
			</table>
		</form>
	</body>
	</html>
<?php
}
?>