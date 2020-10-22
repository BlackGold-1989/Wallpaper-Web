<?php
include_once '../inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
// echo $_POST['action']; exit();

if (@$_POST['action'] == "add") {

	if ($_FILES['file']['name'][0] != "") {
		foreach ($_FILES['file']['name'] as $key => $value) {

			$img = explode(".", $_FILES['file']['name'][$key]);
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789_";
			$imgname = $chars[rand(0,strlen($chars))].round(microtime(true)) . '.' . end($img);

			$file_tmpname = $_FILES['file']['tmp_name'][$key]; 

			move_uploaded_file($file_tmpname, "../images/wallpapers/" . $imgname);
         $colors = beliefmedia_dominant_color("../images/wallpapers/" . $imgname);

         $wallpaper_color = timberpress_rgb_to_hex($colors).'ff';

         list($width, $height) = getimagesize("../images/wallpapers/" . $imgname);
         if ($width > $height) {
            $wallpaper_height = '140';
             // echo "Landscape";
         } else {
            $wallpaper_height = '310';
             // echo "Portrait or Square";
         }

        //  echo $wallpaper_color;

			$stm = $db->prepare("INSERT INTO `status_wallpapers`(`id`,`user_id`, `cat_id`,`image`,`wallpaper_color`,`wallpaper_height`,`status`, `created_at`) VALUES (NULL,'1','".$_POST['category_id']."','".$imgname."','".$wallpaper_color."','".$wallpaper_height."','1','".date("Y-m-d")."')") ;
			$stm->execute(); 
		}
		echo 1;
	} else 	{
	    echo 0;
	}
}

if (@$_POST['action'] == "edit") {
	$stmt = $db->prepare("SELECT id,cat_id,image FROM status_wallpapers WHERE id='".$_POST['id']."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	echo json_encode($row);
}

if (@$_POST['editdata'] == "editphoto") {
   	try
   	{
   	    if ($_FILES["file"]["tmp_name"] == '') {
   	    	$data = [
	    		    'id' => $_POST['id'],
	    		    'cat_id' => $_POST['category_id'],
              'wallpaper_color' => $_POST['wallpaper_color']
	    		];
          
   	    	$sql = "UPDATE status_wallpapers SET cat_id=:cat_id WHERE id=:id";
        	$result = $db->prepare($sql)->execute($data);
   	    	echo json_encode(array('status' => 1, 'msg' => "Photo has been added successfully.."));
   	    } else {
   	        // Get Image Dimension
   	        $fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);
   	        $width = $fileinfo[0];
   	        $height = $fileinfo[1];
   	        
   	        $allowed_image_extension = array(
   	            "png",
   	            "jpg",
   	            "jpeg"
   	        );
   	        
   	        // Get image file extension
   	        $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
   	        
   	        // Validate file input to check if is not empty
   	        if (! file_exists($_FILES["file"]["tmp_name"])) {
   	            echo json_encode(array('status' => 0, 'msg' => "Choose image file to upload."));
   	        }    // Validate file input to check if is with valid extension
   	        else if (! in_array($file_extension, $allowed_image_extension)) {
   	            echo json_encode(array('status' => 0, 'msg' => "Upload valiid images. Only PNG and JPEG are allowed."));
   	        } else {

   	            $img = explode(".", $_FILES["file"]["name"]);
   	            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789_";
   	            $imgname = $chars[rand(0,strlen($chars))].round(microtime(true)) . '.' . end($img);

   	            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../images/wallpapers/" . $imgname)) {
   	                $data = [
	                	    'id' => $_POST['id'],
	                	    'cat_id' => $_POST['category_id'],
	                	    'image' => $imgname,
	                	];
   	                unlink('../images/wallpapers/'.$_POST['old_img'].'');
   	                $sql = "UPDATE status_wallpapers SET cat_id=:cat_id,image=:image WHERE id=:id";
	                	$result = $db->prepare($sql)->execute($data);
   	                echo json_encode(array('status' => 1, 'msg' => "Photo has been updated successfully.."));
   	            } else {
   	            	echo json_encode(array('status' => 0, 'msg' => "Problem in uploading image files."));
   	            }
   	        }
   	    }

   	}
   catch (PDOException $e)
   {
   	echo json_encode(array('status' => 0, 'msg' => "Something went wrong please try again.."));
   }
}

if (@$_POST['action'] == "delete") {

	$get_image = $db->prepare("SELECT image FROM status_wallpapers WHERE id='".$_POST['id']."'"); 
	$get_image->execute(); 
	$row = $get_image->fetch();
	unlink('../images/wallpapers/'.$row['image'].'');

	$deleteimg = $db->prepare("DELETE FROM status_wallpapers WHERE id = ?");
	$deleteimg->execute(array($_POST['id']));
	$countimgs = $deleteimg->rowCount();
	echo $countimgs;
}

if (@$_POST['action'] == "status") {
   $get_token = $db->prepare("SELECT sw.user_id,sw.name,su.device_token 
      FROM status_wallpapers as sw
      INNER JOIN status_users as su on sw.user_id = su.id
      WHERE sw.id='".$_POST['id']."' AND su.notification_status='1'"); 
   $get_token->execute(); 
   $row = $get_token->fetch();
   $google_api_key = FIREBASE_SERVER_KEY;

   $registrationIds = $row['device_token'];

  #prep the bundle
      if ($_POST['status'] == "1") {
        $msg = array
            (
            'body'  => "Congratulation! Your wallpaper '".$row['name']."' is approved.",
            'title' => "Approved",
            'sound' => 1/*Default sound*/
            );
      } elseif ($_POST['status'] == "2"){
        $msg = array
            (
            'body'  => "Sorry! Your wallpaper '".$row['name']."' is rejected.",
            'title' => "Rejected",
            'sound' => 1/*Default sound*/
            );
      }
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

      curl_close ( $ch );

   $data = [
      'id' => $_POST['id'],
      'status' => $_POST['status']
   ];

   $sql = "UPDATE status_wallpapers SET status=:status WHERE id=:id";
   $result = $db->prepare($sql)->execute($data);

   echo json_encode(array('status' => 1, 'msg' => "Photo has been updated successfully.."));
}
?>