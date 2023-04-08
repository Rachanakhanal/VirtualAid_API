<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_function.php';
    $tokenCheck=checkIdValidUser($_GET['token']??null);
    if(isset($_GET['token']) && $tokenCheck != null){
        $userId=$tokenCheck;
        //get the user details
        $getUserDetails="SELECT * FROM users WHERE user_id = '$userId'";
        $result = mysqli_query($con, $getUserDetails);
        $data=mysqli_fetch_assoc($result);
        echo json_encode(
            [
                'success' => true,
                'message' => 'User found',
                'data' => $data
            ]
        );
    }else{
        echo json_encode(
            [
                'success' => false,
                'message' =>'Access denied'
            ]
        );
    }
?>


