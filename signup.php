<?php
header('Access-Control-Request-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

//defining server host name
$HostName = "localhost";
//defining database name
$DatabaseName = "doctorappointment";
//defining database user name 
$HostUser = "root";
//defining database pw
$HostPass = "";
//creating mysql connection
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
//storing the recived json into $json variable
$json = file_get_contents('php://input');
//decoded the recived json into and store into $obj variable
$obj = json_decode($json, true);
//getting name from $obj object
$name = $obj['name'];
//getting phone from $obj object
$phone = $obj['phone'];
//getting email from $obj object
$email = $obj['email'];
////getting userName from $obj object
$userName = $obj['userName'];
////getting pw from $obj object
$password = $obj['password'];
// getting confirm_password from $obj object
// $confirm_password = $obj['confirm_password'];


// checking whether email is already exist or not in mysql table
$CheckEmailSQL = "SELECT * FROM users WHERE email='$email'";
//executing email check mysql query
$checkEmail = mysqli_fetch_array(mysqli_query($con,$CheckEmailSQL));

// checking whether userName is already exist or not in mysql table
$CheckUsernameSQL = "SELECT * FROM users WHERE userName='$userName'";
//executing userName check mysql query
$checkUsername = mysqli_fetch_array(mysqli_query($con,$CheckUsernameSQL));

if(isset($checkEmail)){
    // If email already exists, show the message.
    $emailExist = 'Email Already Exist, Please Try Again With New Email Address..!';
    
    // Converting the message into JSON format.
    $existEmailJSON = json_encode($emailExist);
    
    // Echo the message on Screen.
    echo $existEmailJSON;
}
elseif(isset($checkUsername)){
    // If userName already exists, show the message.
    $usernameExist = 'Username Already Exist, Please Try Again With New Username..!';
    
    // Converting the message into JSON format.
    $existUsernameJSON = json_encode($usernameExist);
    
    // Echo the message on Screen.
    echo $existUsernameJSON;
}
    
 else{
 
    // Creating SQL query and insert the record into MySQL database table.
    // $Sql_Query = "insert into users (name,phone,email,userName,password,confirm_password) values ('$name','$phone','$email','$userName','$password','$confirm_password')";
    $Sql_Query = "insert into users (name,phone,email,userName,password) values ('$name','$phone','$email','$userName','$password')";
    
    
    if(mysqli_query($con,$Sql_Query)){
    
        // If the record inserted successfully then show the message.
       $MSG = 'User Registered Successfully' ;
        
       // Converting the message into JSON format.
       $json = json_encode($MSG);
        
       // Echo the message.
        echo $json ;
    
    }
    else{
    
    echo 'Try Again';
    echo mysqli_error(($con)) ;
    }
}
mysqli_close($con);

        

?>
