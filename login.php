<?php
header('Access-Control-Request-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

  $HostName = "localhost";
  $DatabaseName = "doctorappointment";
  $HostUser = "root";
  $HostPass = "";
  //creating mysql connection
  $con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
  //storing the recived json into $json variable
  $json = file_get_contents('php://input');
  //decoded the recived json into and store into $obj variable
  $obj = json_decode($json, true);
//   print_r($_POST) ;
//   $obj = $_POST;
  //getting email from $obj object
  $email = $obj['email'];
  $password = $obj['password'];
  $loginQuery = "select * from users where email = '$email' and password = '$password' ";
  $result = mysqli_query($con,$loginQuery);
  $check = mysqli_fetch_array(mysqli_query($con, $loginQuery));
  if (isset($check)){
    $data = mysqli_fetch_assoc($result);
    $user_id = $data['user_id'];
    $token = bin2hex(openssl_random_pseudo_bytes(16));
        //insert the token into the database
        $insert_token = "INSERT INTO personal_access_tokens (user_id, token) VALUES ('$user_id', '$token')";
        $result2 = mysqli_query($con, $insert_token);
        
    echo json_encode(['status' => 'success', 'users' => $check]) ;
  }

  else{
    echo json_encode(['status' => 'fail', 'error' => "Invalid Credentials"]) ;
  }
  mysqli_close($con);
  ?>