<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$user_id = $_POST['user_id'];

if(!empty($user_id)) {

    $sth = $db->prepare("SELECT id,username,email,profile_image,notification_status FROM status_users where id='".$user_id."'");
    $sth->execute();
    $result = $sth->fetch();

    if ($result['profile_image'] == "") {
        $profile_image = "";
    } else {
        $profile_image = BASE_URL."/images/profile/".$result['profile_image'];
    }
    $data = array(
        "id" => $result['id'],
        "username" => $result['username'],
        "email" => $result['email'],
        "profile_image" => $profile_image, 
        "notification" => $result['notification_status'],
    );

    if ($result) {
        $arrRecord['ResponseCode'] = 1;
        $arrRecord['ResponseMessage'] = 'Profile Get Successfully';
        $arrRecord['ResponseData'] = $data;
    } else {
        $arrRecord['ResponseCode'] = 0;
        $arrRecord['ResponseMessage'] = 'Invalid user id';
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);
?>