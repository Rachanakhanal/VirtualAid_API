<?php

// establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctorappointment";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['id'])){
    $hospitalID = $_POST['id'];
    // query to retrieve appointments with doctor, hospital, and user names
$sql = "SELECT appointments.appointment_id, appointments.date, appointments.status, 
doctors.name AS doctor_name, users.name AS user_name, appointments.time 
FROM appointments 
INNER JOIN doctors ON appointments.doctor_id = doctors.doctor_id 
INNER JOIN users ON appointments.user_id = users.user_id 
WHERE appointments.hospital_id = $hospitalID 
LIMIT 0, 25
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
    // create variable to store appointment data
    $appointments = [];

    // add appointment data to variable
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }

    // echo appointment data and success message
    echo json_encode([
        'success' => true,
        'data' => $appointments,
        'message' => 'Appointments fetched successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Appointments fetched failed'
    ]);
}
}
else{
    echo json_encode([
        'success' => false,
        'message' => 'Access Denied'
    ]);
}



mysqli_close($conn);
