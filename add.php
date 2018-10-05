<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {		
	$device_status = mysqli_real_escape_string($mysqli, $_POST['device_status']);
	$device_value = mysqli_real_escape_string($mysqli, $_POST['device_value']);
		
	// checking fields value or status or type
	// for detecting empty can use empty($device_status) or isset($device_status)	
	if (!is_numeric($device_status) || !is_numeric($device_value)){		
		
		if(!is_numeric($device_status)) {
			echo "<font color='red'>Device status is not numeric.</font><br/>";
		}
		
		if(!is_numeric($device_value)) {
			echo "<font color='red'>Device value field is not numeric.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	

		// searching biggest value of device_id
		$query = "SELECT MAX(device_id) AS 'maxValue' FROM device";

		$count = count($query);
		if (!empty($count)){
			$process = mysqli_query($mysqli, $query);
			$data = mysqli_fetch_array($process, MYSQLI_BOTH);
			$dataresult = $data['maxValue'];

			// Take value from database with known separate value
			// ex 'iot01' only take '01'
			// after substring then convert into int
			$queue = (int) substr($dataresult, 3, 2);

			// add 1 for next value
			$queue++;

			// Make new device id
			// command sprintf("%02s", $queue); for 2 value formatting
			// ex sprintf("%02s", 3); maka akan dihasilkan '03'
			$char = "IOT";
			$device_id = $char . sprintf("%02s", $queue);
			echo $device_id;

			$result = mysqli_query($mysqli, "INSERT INTO device (device_id,device_status,device_value,device_rand) VALUES('$device_id','$device_status','$device_value','".rand(100000,999999)."')");

		} else {	
			$result = mysqli_query($mysqli, "INSERT INTO device (device_id,device_status,device_value,device_rand) VALUES('IOT01','$device_status','$device_value','".rand(100000,999999)."')");
		}
			
			//display success message
			echo "<font color='green'>  Data added successfully.";
			echo "<br/><br/><a href='index.php'>View Result</a>";
		
	}
}
?>
</body>
</html>
