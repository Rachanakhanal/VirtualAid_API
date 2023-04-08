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

if (isset($obj['name']) && isset($obj['phone']) && isset($obj['doctor_charge']) && isset($obj['hospital_id']) && isset($obj['department_id'])) {
    $name = $obj['name'];
    $phone = $obj['phone'];
    $doctor_charge =$obj['doctor_charge'];
    $hospital_id = $obj['hospital_id'];
    $department_id = $obj['department_id'];

    //inserting data into database
    $sql ="INSERT INTO `doctors`(`name`, `phone`, `doctor_charge`, `hospital_id`, `department_id`) VALUES ('$name','$phone','$doctor_charge','$hospital_id','$department_id')";
   
    $query = mysqli_query($con, $sql);
    if ($query) {
        $data = [
            'success' => true,
            'message' => 'Doctor added successfully'
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
