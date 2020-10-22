<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();
$user_id = $_POST['user_id'];
$wallpaper_id = $_POST['wallpaper_id'];

if(!empty($user_id) && !empty($wallpaper_id)) {

    $stmt = $db->prepare("DELETE FROM status_liked_wallpaper WHERE photo_id = ? AND user_id = ?");
    $stmt->execute(array($wallpaper_id ,$user_id));

    $remove = $db->prepare("DELETE FROM status_wallpapers WHERE id = ? AND user_id = ?");
    $remove->execute(array($wallpaper_id ,$user_id));

    $arrRecord['ResponseCode'] = 1;
    $arrRecord['ResponseMessage'] = 'Success';

} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);

?>