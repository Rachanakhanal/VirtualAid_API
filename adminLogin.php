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

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(strpos($email,"@gmail.com")){
        //check if the email is already in the database
        $check_email = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data=mysqli_fetch_assoc($result);
            $userID = $data['user_id'];
            if($userID!=null) {
                if($data['role'] == 'admin') {
                    $token = bin2hex(openssl_random_pseudo_bytes(16));
                    //insert the token into the database
                    $insert_token = "INSERT INTO personal_access_tokens (user_id, token) VALUES ('$userID', '$token')";
                    $result2 = mysqli_query($con, $insert_token);
                    
                    echo json_encode(['status' => 'success', 'users' => $data]);
                    
                } else {
                    echo json_encode(
                        [
                            'success' => false,
                            'message' => 'Admin not found.'
                        ]
                    );
                }
            } else {
                return false;
            }
          
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'User not found.'
                ]
            );
        }
    }
    else {
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



