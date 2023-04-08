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

//check if all necessary values are present
if (isset($_POST["date"]) && isset($_POST["status"]) && isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["hospital_id"]) && isset($_POST["user_id"]) && isset($_POST["doctor_id"])) {

    // App will be posting these values to this server
    $date = $_POST["date"];
    $status = $_POST["status"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $hospital_id = $_POST["hospital_id"];
    $user_id = $_POST["user_id"];
    $doctor_id = $_POST["doctor_id"];

    $sql = "INSERT INTO appointments(date, status, date,start,end, user_id, status) VALUES ('$date', '$status', '$start','$end', '$hospital_id', '$user_id','$doctor_id')";

    $result = $con->query($sql);
    if ($result) {
        echo ("Success");
    } else {
        echo "Error: " . $con->error;
    }
} else {
    echo "Error: Required data not present.";
}

$con->close();
