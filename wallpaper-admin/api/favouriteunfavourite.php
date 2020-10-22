<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();
$user_id = $_POST['user_id'];
$wallpaper_id = $_POST['wallpaper_id'];
$favourite = $_POST['favourite'];

if(!empty($user_id) && !empty($wallpaper_id) && !empty($favourite)) {

    if ($favourite == "1") {
        $rowsCheck = $db->prepare("SELECT * FROM status_liked_wallpaper WHERE photo_id='".$wallpaper_id."' AND user_id='".$user_id."'");
        $rowsCheck->execute();
        $check = $rowsCheck->fetch();

        if ($check == "") {
            $data = [
                'id' => $wallpaper_id
            ];
            $sql = "UPDATE status_wallpapers SET likes= likes+1 WHERE id=:id";
            $count = $db->prepare($sql)->execute($data);

            if ($count > 0) {
                $rowsSelect = $db->prepare("SELECT likes FROM status_wallpapers WHERE id='".$wallpaper_id."'");
                $rowsSelect->execute();
                $rowc = $rowsSelect->fetch();

                $stm = $db->prepare("INSERT INTO status_liked_wallpaper (user_id,photo_id) VALUES (:user_id,:photo_id)") ;
                // inserting a record
                $res = $stm->execute(array('user_id' => $user_id , 'photo_id' => $wallpaper_id));

                $ResponseData = array(
                    "wallpaper_likes" => $rowc['likes']
                );

                $arrRecord['ResponseCode'] = 1;
                $arrRecord['ResponseMessage'] = 'Success';
                $arrRecord['ResponseData'] = $ResponseData;

              } else {
                  $arrRecord['ResponseCode'] = 0;
                  $arrRecord['ResponseMessage'] = 'Something went wrong';
              }
        } else {
          $arrRecord['ResponseCode'] = 2;
          $arrRecord['ResponseMessage'] = 'You already liked this wallpaper.';
        }
    } else {

        $data = [
            'id' => $wallpaper_id
        ];

        $sql = "UPDATE status_wallpapers SET likes= likes-1 WHERE id=:id";
        $count = $db->prepare($sql)->execute($data);

        if ($count > 0) {
            $rowsSelect = $db->prepare("SELECT likes FROM status_wallpapers WHERE id='".$wallpaper_id."'");
            $rowsSelect->execute();
            $rowc = $rowsSelect->fetch();

            $stmt = $db->prepare("DELETE FROM status_liked_wallpaper WHERE photo_id = ?");
            $stmt->execute(array($wallpaper_id));

            $ResponseData = array(
                "wallpaper_likes" => $rowc['likes']
            );

            $arrRecord['ResponseCode'] = 1;
            $arrRecord['ResponseMessage'] = 'Success';
            $arrRecord['ResponseData'] = $ResponseData;

          } else {
              $arrRecord['data']['success'] = 0;
              $arrRecord['data']['photos_likes'] = 'Something went wrong';
          }
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);

?>