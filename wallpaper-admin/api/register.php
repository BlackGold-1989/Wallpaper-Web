<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$username = $_POST['username'];
$email = $_POST['email'];
$password = data_crypt($_POST['password'],'enc');
$device_type = $_POST['device_type'];
$device_token = $_POST['device_token'];

if(!empty($username) && !empty($email) && !empty($password) && !empty($device_type) && !empty($device_token)) {
    try
    {
        // inserting data into create table using prepare statement to prevent from sql injections
        $stm = $db->prepare("INSERT INTO status_users (username,email,password,device_type,device_token) VALUES (:username, :email, :password, :device_type, :device_token)") ;
        // inserting a record
        $stm->execute(array(':username' => $username , ':email' => $email , ':password' => $password
         , 'device_type' => $device_type, 'device_token' => $device_token));

        $last_id = $db->lastInsertId();
        $google_api_key = "AAAAfckrWgk:APA91bHX1ntQja-YKPBzlx5HdOqowwdlF5LutZ9ZxjKmYM69GEWdKd2WRoOniRTyqCjzsxBHWKAROMxYB2a7L1btopE_-8c8eQB2bmsCsLs1ItrQYTjzxM96-bUjFmuq6F3tcoguIi65"; 
        #prep the bundle
            $msg = array
                (
                'body'  => "Enjoy the best wallpaper collection you ever had.",
                'title' => "Wallpaper",
                'sound' => 1/*Default sound*/
                );
            $fields = array
                (
                'to'            => $device_token,
                'notification'  => $msg
                );
            $headers = array
                (
                'Authorization: key=' . $google_api_key,
                'Content-Type: application/json'
                );
        #Send Reponse To FireBase Server
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

            $result = curl_exec ( $ch );
            // echo "<pre>";print_r($result);exit;
            curl_close ( $ch );

        $arrRecord['ResponseCode'] = 1;
        $arrRecord['ResponseMessage'] = 'Registration Successful';
        $arrRecord['ResponseData']['id'] = $last_id;
    }
    catch (PDOException $e)
    {
        $arrRecord['ResponseCode'] = 0;
        $arrRecord['ResponseMessage'] = 'Something went wrong please try again..';
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);
?>