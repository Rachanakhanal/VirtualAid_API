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

//decoded the received json into and store into $_POST variable
$_POST = json_decode($json, true);

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_FILES['image'])
) {
    
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
//getimage
$image = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_size = $_FILES['image']['size'];
$image_ext = pathinfo($image, PATHINFO_EXTENSION);
$image_path = "images/".$image;
    //inserting data into database
    
// upload image file //  
// if ($image_size < 5000000) {

//     if ($image_ext == "jpg" || $image_ext == "png" || $image_ext == "jpeg") {
//         if (move_uploaded_file($image_tmp, $image_path)) {
//             $sql ="INSERT INTO `hospitals`(`name`, `phone`, `address`) VALUES ( '$name', '$phone', '$address')";
//             $query = mysqli_query($con, $sql);
//             if ($query) {
//                 $data = [
//                     'success' => true,
//       'message' => 'Hospital added successfully'
//                 ];
//                 echo json_encode($data);
//             } else {
//                 $data = [
//                     'success' => false,
//                     'message' => 'Something went wrong.'
//                 ];
//                 echo json_encode($data);

//             }
//         } else {
//             $data=['success'=>false, 'message'=>'Something went wrong.'];
//             echo json_encode($data);
//         }
//     } else {
//         $data=['success'=>false, 'message'=>'Image must be jpg, png or jpeg.'];
//         echo json_encode($data);
//     }
// } else {
//     $data=['success'=>false, 'message'=>'Image size must be less than 5MB.'];
//     echo json_encode($data);
// }

    // $sql ="INSERT INTO `hospitals`(`name`, `phone`, `address`) VALUES ( '$name', '$phone', '$address')";
   
    // $query = mysqli_query($con, $sql);
    // if ($query) {
    //     $data = [
    //         'success' => true,
    //         'message' => 'Hospital added successfully'
    //     ];
    //     echo json_encode($data);
    // } else {
    //     $data = [
    //         'success' => false,
    //         'message' => 'Something went wrong.'
    //     ];
    //     echo json_encode($data);
    // }

} else {
    $data = [
        'success' => false,
        'message' => 'Please fill all the fields.'
    ];
    echo json_encode($data);
}
?>
