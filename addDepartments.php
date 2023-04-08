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

if (isset($obj['name']) && isset($obj['description']) && isset($obj['hospital_id'])) {
    $name = $obj['name'];
    $description = $obj['description'];
    $hospital_id = $obj['hospital_id'];

    //inserting data into database
    $sql ="INSERT INTO `departments`(`name`, `description`, `hospital_id`) VALUES ('$name','$description','$hospital_id')";
   
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data = [
            'success' => true,
            'message' => 'Department added successfully'
        ];
        echo json_encode($data);
    } else {
        $data = [
            'success' => false,
            'message' => 'Something went wrong.'
        ];
        echo json_encode($data);
    }
} else {
    $data = [
        'success' => false,
        'message' => 'Please fill all the fields.'
    ];
    echo json_encode($data);
}
?>
