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


function checkIdValidUser($token)
{
    global $con;
    if ($token != null) {
        $check_token = "SELECT * FROM `personal_access_tokens` WHERE token = '$token'";
        $result = mysqli_query($con, $check_token);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $user_id = mysqli_fetch_assoc($result)['user_id'];
            return $user_id;
        } else {
            return null;
        }
    } else {
        return null;
    }
}
// Add appointment function
function addAppointment($date, $time, $hospital_id, $doctor_id, $user_id)
{
    global $con;

    // Insert appointment
    $appointment_query = "INSERT INTO appointments (date, time, status, hospital_id, doctor_id, user_id) VALUES ('$date', '$time', 'Unpaid', $hospital_id, $doctor_id, $user_id)";
    $appointment_result = mysqli_query($con, $appointment_query);

    // If appointment insertion successful, insert payment
    if ($appointment_result) {
        $appointment_id = mysqli_insert_id($con);
        $response = array("success" => true, "message" => "Appointment and payment added successfully!", "appointmentID" => $appointment_id);
            return $response;
            
        //$payment_query = "INSERT INTO payments (appointment_id, khalti_token) VALUES ($appointment_id, '$khalti_token')";
       // $payment_result = mysqli_query($con, $payment_query);


        // if ($payment_result) {
        //     $response = array("success" => true, "message" => "Appointment and payment added successfully!", "appointmentID" => $appointment_id);
        //     return $response;
        // } else {
        //     // If payment insertion failed, delete the appointment
        //     $delete_query = "DELETE FROM appointments WHERE appointment_id = $appointment_id";
        //     mysqli_query($con, $delete_query);
        //     $response = array("success" => false, "message" => "Error adding payment.");
        //     return $response;
        // }
    } else {
        $response = array("success" => false, "message" => "Error adding appointment.");
        return $response;
    }
}

// Check if all input fields are set
if (isset($obj['date'], $obj['time'], $obj['hospital_id'], $obj['doctor_id'], $obj['user_token'])) {
    $date = $obj['date'];
    $time = $obj['time'];
    //$status = $obj['status'];
    $hospital_id = $obj['hospital_id'];
    $doctor_id = $obj['doctor_id'];
    $user_id = checkIdValidUser($obj['user_token']);
    //$khalti_token = $obj['khalti_token'];

    $result = addAppointment($date, $time, $hospital_id, $doctor_id, $user_id);
    echo json_encode($result);
} else {
    $response = array("success" => false, "message" => "All fields are required.");
    echo json_encode($response);
}

// Close database connection
mysqli_close($con);
