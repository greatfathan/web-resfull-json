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

	if($id > 0) {
		//fetching data in descending order (lastest entry first)
		//$result = mysql_query("SELECT * FROM device ORDER BY id DESC"); // mysql_query is deprecated
		$result = mysqli_query($mysqli, "SELECT id,device_id,device_status,device_value,device_rand FROM device WHERE id = '$id'"); // using mysqli_query instead

		// membuat obj kelas
		$obj = new stdClass();
		while($res = mysqli_fetch_array($result)) { 
			// membuat properti dinamis didalam kelas
			$obj->id = $res['id'];
			$obj->device_id = $res['device_id'];
			$obj->device_status = $res['device_status'];
			$obj->device_value = $res['device_value'];
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

if($action == "update") {
	if($id > 0) {
		$value = 0;
		if(isset($_GET['value'])) {
			$value = $_GET['value'];
		}
		$query = "UPDATE device SET device_value = '$value', device_rand='".rand(1,1000000)."' WHERE id = '$id'";
		//fetching data in descending order (lastest entry first)
		//$result = mysql_query("SELECT * FROM device ORDER BY id DESC"); // mysql_query is deprecated
		mysqli_query($mysqli, $query); // using mysqli_query instead

		// membuat obj kelas
		$obj = new stdClass();
		$obj->status = "ok";

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