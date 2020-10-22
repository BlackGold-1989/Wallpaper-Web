<?php
include_once '../inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
if (@$_POST['action'] == "add") {
	try
    {
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

	        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../images/category/" . $imgname)) {

	            $stmt = $db->prepare("SELECT count(category) as count FROM status_category WHERE category='".$_POST['category']."'"); 
	            $stmt->execute(); 
	            $row = $stmt->fetch();

	            if ($row['count'] > 0) {
	            	echo json_encode(array('status' => 0, 'msg' => "Category Name already exists"));
	            } else {
	                // inserting data into create table using prepare statement to prevent from sql injections
	                $stm = $db->prepare("INSERT INTO status_category (category,image,created_at) VALUES (:category, :image, :created_at)") ;
	                // inserting a record
	                $stm->execute(array(':category' => $_POST['category'] , 'image' => $imgname,':created_at' => date("Y-m-d")));
	                echo json_encode(array('status' => 1, 'msg' => "Category has been added successfully.."));
	            }
	        } else {
	        	echo json_encode(array('status' => 0, 'msg' => "Problem in uploading image files."));
	        }
	    }
	}
	catch (PDOException $e)
	{
		echo json_encode(array('status' => 0, 'msg' => "Something went wrong please try again.."));
	}
}

if (@$_POST['editdata'] == "editcategory") {

	$stmt = $db->prepare("SELECT count(category) as count FROM status_category WHERE category='".$_POST['category']."' AND id !='".$_POST['id']."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();

	if ($row['count'] > 0) {
		echo json_encode(array('status' => 0, 'msg' => "Category Name already exists"));
	} else {
	   	try
	   	{
	   	    if ($_FILES["file"]["tmp_name"] == '') {
	   	    	$data = [
	   	    	    'id' => $_POST['id'],
	   	    	    'category' => $_POST['category']
	   	    	];
	   	    	// print_r($data);
	   	    	$sql = "UPDATE status_category SET category=:category WHERE id=:id";
	   	    	$db->prepare($sql)->execute($data);
	   	    	echo json_encode(array('status' => 1, 'msg' => "Category has been added successfully.."));
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

	   	            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../images/category/" . $imgname)) {
	   	                $data = [
	   	                    'id' => $_POST['id'],
	   	                    'category' => $_POST['category'],
	   	                    'image' => $imgname,
	   	    	    		'featured' => $featured
	   	                ];
	   	                unlink('../images/category/'.$_POST['old_img'].'');
	   	                $sql = "UPDATE status_category SET category=:category,image=:image WHERE id=:id";
	   	                $db->prepare($sql)->execute($data);
	   	                echo json_encode(array('status' => 1, 'msg' => "Category has been updated successfully.."));
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
}

// echo $_POST['action']; exit();
if (@$_POST['action'] == "edit") {
	$stmt = $db->prepare("SELECT id,category,image FROM status_category WHERE id='".$_POST['id']."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	echo json_encode($row);
}
if (@$_POST['action'] == "delete") {
	$get_image = $db->prepare("SELECT id,category,image FROM status_category WHERE id='".$_POST['id']."'"); 
	$get_image->execute(); 
	$row = $get_image->fetch();
	unlink('../images/category/'.$row['image'].'');

	$stmt = $db->prepare("DELETE FROM status_category WHERE id = ?");
	$stmt->execute(array($_POST['id']));
	$count = $stmt->rowCount();

	// echo "DELETE FROM status_wallpapers WHERE cat_id = '".$_POST['id']."'"; exit();
	$stmt_product = $db->prepare("DELETE FROM status_wallpapers WHERE cat_id = ?");
	$stmt_product->execute(array($_POST['id']));

	echo $count;
}
?>