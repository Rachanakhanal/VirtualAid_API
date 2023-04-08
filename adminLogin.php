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
        $check_email = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($con, $check_email);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $data=mysqli_fetch_assoc($result);
            $userID = $data['user_id'];
            if($userID!=null){
                global $con;
                $check_admin = "SELECT * FROM `users_role` WHERE user_id = '$userID'";
                $result = mysqli_query($con,$check_admin);
                $count = mysqli_num_rows($result);
                if($count > 0){
                    $details = mysqli_fetch_assoc($result);
                    $userID =  $details['user_id'];
                    $databasePassword= $details['password'];
                    if($details['roleID'] == 1){
                        login($password,$databasePassword,$userID);
                    }else{
                        echo json_encode(
                            [
                                'success' => false,
                                'message' => 'Admin not found.'
                            ]
                        );
                    }
                }else{
                    return false;
                }
            }else{
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