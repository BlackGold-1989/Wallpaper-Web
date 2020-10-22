<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$user_id = $_POST['user_id'];
$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];

$arrRecord = array();

$rowsSelect = $db->prepare("SELECT password FROM status_users where id='".$user_id."'");
$rowsSelect->execute();
$rowc = $rowsSelect->fetch();


if(!empty($user_id) &&  !empty($oldpassword) && !empty($newpassword)) {
    if ($rowc['password'] == $oldpassword) {
        $data = [
            'password' => $newpassword,
            'id' => $user_id
        ];

        $sql = "UPDATE status_users SET password=:password WHERE id=:id";
        $count = $db->prepare($sql)->execute($data);

        if ($count > 0) {
            $arrRecord['ResponseCode'] = 1;
            $arrRecord['ResponseMessage'] = 'Password has been changed';
        } else {
            $arrRecord['ResponseCode'] = 0;
            $arrRecord['ResponseMessage'] = 'Something went wrong please try again.';
        }
    } else {
        $arrRecord['ResponseCode'] = 0;
        $arrRecord['ResponseMessage'] = 'Old password not matched.';
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);
?>