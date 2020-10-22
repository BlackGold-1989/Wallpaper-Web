<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$user_id = $_POST['user_id'];
$username = $_POST['username'];

if(!empty($user_id) && !empty($username)) {
    try
    {

        if (@$_FILES["profile_image"]["tmp_name"]) {
            // Get Image Dimension
            $fileinfo = @getimagesize($_FILES["profile_image"]["tmp_name"]);
            $width = $fileinfo[0];
            $height = $fileinfo[1];
            $allowed_image_extension = array(
                "png",
                "jpg",
                "jpeg"
            );
            
            // Get image file extension
            $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
            
            // Validate file input to check if is not empty
            if (! file_exists($_FILES["profile_image"]["tmp_name"])) {
                $arrRecord['success'] = 0;
                $arrRecord['msg'] = 'Choose image file to upload.';
            }    // Validate file input to check if is with valid extension
            else if (! in_array($file_extension, $allowed_image_extension)) {
                $arrRecord['success'] = 0;
                $arrRecord['msg'] = 'Upload valiid images. Only PNG and JPEG are allowed.';
            } else {
                $img = explode(".", $_FILES["profile_image"]["name"]);
                $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789_";
                $image = $chars[rand(0,strlen($chars))].round(microtime(true)) . '.' . end($img);

                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], "../images/profile/" . $image)) {
                    //Update OTP
                    $update_sql = "UPDATE `status_users` SET `username`='".$username."',profile_image='".$image."' WHERE `id`='".$user_id."'";
                    // Prepare statement
                    $stmt = $db->prepare($update_sql);
                    // execute the query
                    $stmt->execute();
                    $arrRecord['ResponseCode'] = 1;
                    $arrRecord['ResponseMessage'] = 'Profile has been updated.';
                } else {
                    $arrRecord['ResponseCode'] = 0;
                    $arrRecord['ResponseMessage'] = 'Problem in uploading image files.';
                }
            }
        } else {

            $update_sql = "UPDATE `status_users` SET `username`='".$username."' WHERE `id`='".$user_id."'";
                    // Prepare statement
            $stmt = $db->prepare($update_sql);
            // execute the query
            $stmt->execute();
            $arrRecord['ResponseCode'] = 1;
            $arrRecord['ResponseMessage'] = 'Profile has been updated.';
        }
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