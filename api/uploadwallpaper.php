<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$user_id = $_POST['user_id'];
$category_id = $_POST['category_id'];
$wallpaper_color = $_POST['wallpaper_color'];
$wallpaper_height = $_POST['wallpaper_height'];
$name = $_POST['name'];
    
if(!empty($user_id) && !empty($category_id) && !empty($name) && !empty($wallpaper_color) && !empty($wallpaper_height)) {

    try
    {
        // Get Image Dimension
        $fileinfo = @getimagesize($_FILES["wallpaper_image"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $allowed_image_extension = array(
            "png",
            "jpg",
            "jpeg"
        );
        
        // Get image file extension
        $file_extension = pathinfo($_FILES["wallpaper_image"]["name"], PATHINFO_EXTENSION);
        
        // Validate file input to check if is not empty
        if (! file_exists($_FILES["wallpaper_image"]["tmp_name"])) {
            $arrRecord['ResponseCode'] = 0;
            $arrRecord['ResponseMessage'] = 'Choose image file to upload.';
        }    // Validate file input to check if is with valid extension
        else if (! in_array($file_extension, $allowed_image_extension)) {
            $arrRecord['ResponseCode'] = 0;
            $arrRecord['ResponseMessage'] = 'Upload valiid images. Only PNG and JPEG are allowed.';
        } else {
            $img = explode(".", $_FILES["wallpaper_image"]["name"]);
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789_";
            $image = $chars[rand(0,strlen($chars))].round(microtime(true)) . '.' . end($img);

            if (move_uploaded_file($_FILES["wallpaper_image"]["tmp_name"], "../images/wallpapers/" . $image)) {
                $stm = $db->prepare("INSERT INTO status_wallpapers (user_id,cat_id,name,image,wallpaper_color,wallpaper_height) VALUES (:user_id, :cat_id, :name, :image, :wallpaper_color,:wallpaper_height)") ;
                // inserting a record
                $stm->execute(array(':user_id' => $user_id , ':cat_id' => $category_id, ':name' => $name , 'image' => $image, 'wallpaper_color' => $wallpaper_color, 'wallpaper_height' => $wallpaper_height ));
                $arrRecord['ResponseCode'] = 1;
                $arrRecord['ResponseMessage'] = 'Wallpaper uploaded successfully.';
            } else {
                $arrRecord['ResponseCode'] = 0;
                $arrRecord['ResponseMessage'] = 'Problem in uploading image files.';
            }
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