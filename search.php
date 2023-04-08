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
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    
    // Searching for hospital and doctor names using the query
    $sql = "SELECT 
    hospitals.hospital_id,
    hospitals.name as hospital_name, 
    doctors.name as doctor_name, 
    departments.name as department_name 
FROM hospitals 
LEFT JOIN doctors ON hospitals.hospital_id = doctors.hospital_id 
LEFT JOIN departments ON doctors.department_id = departments.department_id 
WHERE hospitals.name LIKE '%$query%' OR doctors.name LIKE '%$query%' OR departments.name LIKE '%$query%'";

    // Executing the query
    $result = $con->query($sql);
    
    // Checking for query errors
    if($result) {
         // Returning search results in JSON format
        $searchResults = array();
        while($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
        echo json_encode([
            'success' => true,
            'data'=>$searchResults,
        ]);
    }
    else {
        echo json_encode([
            'success' => false,
            'message' => 'Data Query Failed'
        ]);
    }
    
} else {
    echo "No Result Found";
}