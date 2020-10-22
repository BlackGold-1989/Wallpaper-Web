<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$user_id = $_POST['user_id'];
$notification_status = $_POST['status'];

$arrRecord = array();

if(!empty($user_id) &&  !empty($notification_status)) {

    $data = [
        'id' => $user_id,
        'notification_status' => $notification_status
    ];

    $sql = "UPDATE status_users SET notification_status=:notification_status WHERE id=:id";
    $count = $db->prepare($sql)->execute($data);

    if ($count > 0) {
        $arrRecord['ResponseCode'] = 1;
        $arrRecord['ResponseMessage'] = 'Notification Status Changed Successfully';
    } else {
        $arrRecord['ResponseCode'] = 0;
        $arrRecord['ResponseMessage'] = 'Something went wrong please try again.';
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);
?>