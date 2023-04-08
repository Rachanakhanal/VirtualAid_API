<?php

header("Access-Control-Allow-Origin: *");

function signup($fullname,$emailaddress,$address,$phone,$userName,$password){
    global $con;
    //password hash encrypts user entered password into hash
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_user = "INSERT INTO `users`(`full name`, `email address`, `address`,`phone`, `username`, `password`) VALUES ('$fullname','$emailaddress','$address','$phone','$userName','$encrypted_password')";
    $result = mysqli_query($con, $insert_user);
    if ($result) {
        echo json_encode([
                'success' => true,
                'message' => 'User created successfully',
            ]
        );
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'User creation failed'
            ]
        );
    }
}

function login($password, $databasePassword,$user_id)
{
   // password_verify function compares database password(hash password) with user entered password
    if(password_verify($password, $databasePassword)){
        //generating a token for logged in user
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        global $con;

        // inserting token into database 
        $insert_token = "INSERT INTO `personal_access_tokens`(`user_id`, `token`) VALUES ('$user_id','$token')";
        $result = mysqli_query($con,$insert_token);

        if($result){
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'User logged in successfully',
                    'token' => $token
                ]
            );
        }
        else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'User login failed'
                ]
            );
        }

    }else{
       echo json_encode(
          [
              'success' => false,
              'message' => 'Password is incorrect',
          ]
      );
    }
}


function checkIdValidUser($token)
{
    global $con;
    if ($token != null) {
        $check_token = "SELECT * FROM `personal_access_tokens` WHERE token = '$token'";
        $result = mysqli_query($con, $check_token);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $user_id = mysqli_fetch_assoc($result)['user_id'];
            return $user_id;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function checkIfAdmin($token)
{
    $user_id=checkIdValidUser($token);
    if($user_id!=null){
        global $con;
        $check_admin = "SELECT * FROM `users` WHERE id = '$user_id'";
        $result = mysqli_query($con, $check_admin);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $customer = mysqli_fetch_assoc($result);
            if ($customer['isAdmin'] == '1') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }else{
        return false;
    }
}



?>