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
$action = isset($_POST["action"]) ? $_POST["action"] : ""; // lets get the action

// Check Connection
if ($con->connect_errno) {
    die("Connection Failed: " . $con->connect_error);
    echo 'action: ' . $action;
    return;
} else {
    //echo ("Sucess");
}