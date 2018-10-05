<?php
//including the database connection file
include_once("config.php");

// http://iot.karyakita.id/restful.php?action=update&id=4&value=-1440
// kondisi dengan menggunakan metode ternary operator
// $id = isset($_GET['id']) ? $_GET['id'] : 0 ;

$id = 0;
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}

$action = "";

if(isset($_GET['action'])) {
	$action = $_GET['action'];
}

if($action == "detail") {
	// find string IOT on $id
	if (strpos($id, 'IOT') !== false){	
		//fetching data in descending order (lastest entry first)
		//$result = mysql_query("SELECT * FROM device ORDER BY id DESC"); // mysql_query is deprecated
		$result = mysqli_query($mysqli, "SELECT device_id,device_status,device_value,device_rand FROM device WHERE device_id = '$id'"); 

		// membuat obj kelas
		$obj = new stdClass();
		while($res = mysqli_fetch_array($result)) { 
			// membuat properti dinamis didalam kelas
			$obj->device_id = $res['device_id'];
			$obj->device_value = $res['device_value'];
			$obj->device_status = $res['device_status'];
			$obj->device_rand = $res['device_rand'];
		}

		header('Access-Control-Allow-Origin: *'); 
		header("Access-Control-Allow-Credentials: true");
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
		header('Content-Type: application/json');
		echo json_encode($obj);
	}
}
?>