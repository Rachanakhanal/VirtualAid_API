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

if (isset($obj['appointment_id'], $obj['khalti_token'])) {
    $appointment_id = $obj['appointment_id'];
    $khalti_token = $obj['khalti_token'];

    $payment_query = "INSERT INTO payments (appointment_id, khalti_token) VALUES ('$appointment_id', '$khalti_token')";
    $payment_result = mysqli_query($con, $payment_query);

    if ($payment_result) {
        $response = array("success" => true, "message" => "Payment added successfully!");
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Error adding payment.");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "All fields are required.");
    echo json_encode($response);
}

$con->close();
