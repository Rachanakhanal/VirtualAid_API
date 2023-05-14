<?php
header('Access-Control-Request-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$HostName = "localhost";
$DatabaseName = "doctorappointment";
$HostUser = "root";
$HostPass = "";

//creating mysql connection
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

//storing the received json into $json variable
$json = file_get_contents('php://input');

//decoded the received json into and store into $obj variable
$obj = json_decode($json, true);

global $con;
if(!isset($_GET['hospital_id'])) {
	echo json_encode([
		'success' => false,
		'message' => 'Hospital Id is missing',
	]);
}

$hospital_id = $_GET['hospital_id'];
//get departments from the database
$departments = "SELECT * FROM departments WHERE `hospital_id` = '$hospital_id'";
    $result = mysqli_query($con, $departments);
    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['image'] = 'https://thumbs.dreamstime.com/b/default-placeholder-doctor-half-length-portrait-photo-avatar-gray-color-default-placeholder-doctor-half-length-portrait-113622206.jpg';
            $data[] = $row;
        }
        echo json_encode(
            [
                'success' => true,
                'data' => $data,
                'message' => 'Departments fetched Successfully'
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Error fetching departments'
            ]
        );
    }