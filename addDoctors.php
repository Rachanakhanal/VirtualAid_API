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

if (isset($obj['name']) && isset($obj['phone']) && isset($obj['doctor_charge']) && isset($obj['hospital_name']) && isset($obj['department_name'])) {
    $name = $obj['name'];
    $phone = $obj['phone'];
    $doctor_charge = $obj['doctor_charge'];
    $hospital_name = $obj['hospital_name'];
    $department_name = $obj['department_name'];

    // Get hospital ID from database
    $sql2 = "SELECT hospital_id FROM hospitals WHERE name = '$hospital_name'";

    $query2 = mysqli_query($con, $sql2);

    if ($query2 && mysqli_num_rows($query2) > 0) {
        $hospital = mysqli_fetch_assoc($query2);
        $hospital_id = $hospital['hospital_id'];

        // Get department ID from database
        $sql3 = "SELECT department_id FROM departments WHERE name = '$department_name'";

        $query3 = mysqli_query($con, $sql3);

        if ($query3 && mysqli_num_rows($query3) > 0) {
            $department = mysqli_fetch_assoc($query3);
            $department_id = $department['department_id'];

            //inserting data into database
            $sql = "INSERT INTO `doctors`(`name`, `phone`, `doctor_charge`, `hospital_id`, `department_id`) VALUES ('$name','$phone','$doctor_charge','$hospital_id','$department_id')";

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
                'message' => 'Department not found'
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'success' => false,
            'message' => 'Hospital not found'
        ];
        echo json_encode($data);
    }
} else {
    $data = [
        'success' => false,
        'message' => 'Required parameters missing'
    ];
    echo json_encode($data);
}
