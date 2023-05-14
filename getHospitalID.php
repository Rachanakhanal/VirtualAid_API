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

if(isset($_POST['token'])){
    $token = $_POST['token'];
    checkHospitalID($token);
}
else{
    echo json_encode(
        [
            'success' => true,
            'message' => "token not found"
        ]
        );
};

function checkHospitalname($token)
{
        global $con;
        $check_name = "SELECT * FROM `Hospitals` WHERE name = '$name'";
        $result = mysqli_query($con, $check_name);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $Hospital_id = mysqli_fetch_assoc($result)['name'];
            //return $HospitalID;
            echo json_encode(
                [
                    'success' => true,
                    'id' => $Hospital_id
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => true,
                    'message' => "Error"
                ]
            );
        }
}
?>