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


if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

                $sql = "INSERT INTO `hospitals`(`name`, `phone`, `address`) VALUES ( '$name', '$phone', '$address')";
                $query = mysqli_query($con, $sql);
                if ($query) {
                    $data = [
                        'success' => true,
                        'message' => 'Hospital added successfully'
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
                $data = ['success' => false, 'message' => 'Something went wrong.'];
                echo json_encode($data);
            }
//         } else {
//             $data = ['success' => false, 'message' => 'Image must be jpg, png or jpeg.'];
//             echo json_encode($data);
//         }
//     } else {
//         $data = ['success' => false, 'message' => 'Image size must be less than 5MB.'];
//         echo json_encode($data);
//     }
// } else {
    
//     $data = [
//         'success' => false,
//         'message' => 'Please fill all the fields.'
//     ];
//     echo json_encode($data);

