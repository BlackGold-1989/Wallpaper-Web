<?php
include_once '../inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
if (@$_POST['action'] == "add") {
	try
    {

        $title = $_POST['title'];
        $body = $_POST['message'];
        $google_api_key = "AAAAfckrWgk:APA91bHX1ntQja-YKPBzlx5HdOqowwdlF5LutZ9ZxjKmYM69GEWdKd2WRoOniRTyqCjzsxBHWKAROMxYB2a7L1btopE_-8c8eQB2bmsCsLs1ItrQYTjzxM96-bUjFmuq6F3tcoguIi65"; 

        $query = $db->prepare("SELECT device_token FROM `status_users` WHERE notification_status='1'");
        $query->execute();
        $dataresult = $query->fetchAll();
        $reg_id = array();
        foreach ($dataresult as $key => $value) {

            $registrationIds = $value['device_token'];
        #prep the bundle
            $msg = array
                (
                'body'  => $body,
                'title' => $title,
                'sound' => 1/*Default sound*/
                );
            $fields = array
                (
                'to'            => $registrationIds,
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
            
            
        }

        
    	// $token = "AAAAfckrWgk:APA91bHX1ntQja-YKPBzlx5HdOqowwdlF5LutZ9ZxjKmYM69GEWdKd2WRoOniRTyqCjzsxBHWKAROMxYB2a7L1btopE_-8c8eQB2bmsCsLs1ItrQYTjzxM96-bUjFmuq6F3tcoguIi65";

    	// $sth = $db->prepare("SELECT device_token FROM status_users WHERE notification_status='1'");
        

    	// inserting data into create table using prepare statement to prevent from sql injections
    	$stm = $db->prepare("INSERT INTO status_notification (title,message) VALUES (:title, :message)") ;
    	// inserting a record
    	$stm->execute(array(':title' => $_POST['title'] , 'message' => $_POST['message']));
    	echo json_encode(array('status' => 1, 'msg' => "Notification has been send.."));
	}
	catch (PDOException $e)
	{
		echo json_encode(array('status' => 0, 'msg' => "Something went wrong please try again.."));
	}
}

if (@$_POST['id']) {
    try
    {

        $stmtsql = $db->prepare("SELECT title,message FROM `status_notification` WHERE id='".$id."'");
        $stmtsql->execute();
        $resultsql = $stmtsql->fetch();

        $title = $resultsql['title'];
        $body = $resultsql['message'];

        $google_api_key = "AAAAfckrWgk:APA91bHX1ntQja-YKPBzlx5HdOqowwdlF5LutZ9ZxjKmYM69GEWdKd2WRoOniRTyqCjzsxBHWKAROMxYB2a7L1btopE_-8c8eQB2bmsCsLs1ItrQYTjzxM96-bUjFmuq6F3tcoguIi65"; 

        $query = $db->prepare("SELECT device_token FROM `status_users` WHERE notification_status='1'");
        $query->execute();
        $dataresult = $query->fetchAll();
        $reg_id = array();
        foreach ($dataresult as $key => $value) {

            $registrationIds = $value['device_token'];
        #prep the bundle
            $msg = array
                (
                'body'  => $body,
                'title' => $title,
                'sound' => 1/*Default sound*/
                );
            $fields = array
                (
                'to'            => $registrationIds,
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
        }

        echo json_encode(array('status' => 1, 'msg' => "Notification has been send.."));
        
    }
    catch (PDOException $e)
    {
        echo json_encode(array('status' => 0, 'msg' => "Something went wrong please try again.."));
    }
}
?>