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

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(strpos($email,"@gmail.com")){
        //check if the email is already in the database
        $check_email = "SELECT * FROM `hospitals` WHERE email = '$email'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data=mysqli_fetch_assoc($result);
            $hospitalID = $data['hospital_id'];
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'Hospital Login Sucessfully',
                    'id' => $hospitalID
                ]
            );
          
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'User not found.'
                ]
            );
        }

    }
    else{
        echo json_encode(
            [
                'success' => false,
                'message' => 'Invalid email'
            ]
        );
    }
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Please fill all the fields.'
        ]
    );
}