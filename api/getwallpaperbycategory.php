<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();
$offset=0;
$pageIndex = $_POST['pageIndex'];
$numberOfRecords = $_POST['numberOfRecords'];
$category_id = $_POST['category_id'];
$user_id = $_POST['user_id'];

if (isset($user_id) != "") {

	if(!empty($pageIndex) && !empty($numberOfRecords) && !empty($category_id)) {

		if($pageIndex > 1)
		{
		    $offset = ($pageIndex - 1) * $numberOfRecords;
		}

		if ($category_id != ''){
			$sql = $db->prepare("SELECT sw.id, sw.user_id, sw.image, sw.wallpaper_color,sw.wallpaper_height, sw.views, sw.likes, sc.category, su.id as us_id, su.username ,su.profile_image
				FROM status_wallpapers as sw
				INNER JOIN status_category as sc ON sw.cat_id=sc.id
				INNER JOIN status_users as su ON sw.user_id=su.id
				WHERE sw.cat_id='".$category_id."' AND sw.status='1'
				ORDER BY sw.views DESC limit $offset, $numberOfRecords");
		} else {
		    $sql = $db->prepare("SELECT sw.id, sw.user_id, sw.image, sw.wallpaper_color,sw.wallpaper_height, sw.views, sw.likes, sc.category, su.id as us_id, su.username ,su.profile_image
		    	FROM status_wallpapers as sw
		    	INNER JOIN status_category as sc ON sw.cat_id=sc.id
		    	INNER JOIN status_users as su ON sw.user_id=su.id
		    	WHERE sw.status='1'
		    	ORDER BY sw.views DESC limit $offset, $numberOfRecords");
		}
		
		$sql->execute();
		$result = $sql->fetchAll();
		foreach ($result as $key => $value) {

			$checkFavorite = $db->prepare("SELECT user_id,photo_id FROM `status_liked_wallpaper` WHERE `photo_id`='".$value['id']."' AND user_id='".$user_id."'");
			$checkFavorite->execute();
			$checkdata = $checkFavorite->fetch(PDO::FETCH_ASSOC);

			if ($checkdata == "") {
			    $isFavorite = "2";
			} else {
			    $isFavorite = "1";
			}

		    if ($value['image'] == "") {
		        $image = "";
		    } else {
		        $image = BASE_URL."/images/wallpapers/".$value['image'];
		    }
		    if ($value['profile_image'] == "") {
		        $user_image = "";
		    } else {
		        $user_image = BASE_URL."/images/profile/".$value['profile_image'];
		    }

		    $data[] = array(
		        "id" => $value['id'],
		        "wallpaper_image" => $image,
		        "wallpaper_color" => $value['wallpaper_color'],
		        "wallpaper_height" => $value['wallpaper_height'],
		        "user_image" => $user_image,
		        "user_id" => $value['us_id'],
		        "user_name" => $value['username'],
		        "category_name" => $value['category'],
		        "wallpaper_likes" => $value['likes'],
		        "isFavourite" => $isFavorite,
		        "wallpaper_views" => $value['views']
		    );
		}
		if (isset($data)) {
		    if (!empty($data)) {
		        $arrRecord['ResponseCode'] = 1;
		        $arrRecord['ResponseMessage'] = 'Wallpapers Get Successfully';
		        $arrRecord['ResponseData'] = $data;
		    } else {
		        $arrRecord['ResponseCode'] = 0;
		        $arrRecord['ResponseMessage'] = 'Something went wrong';
		    }
		} else {
		    $arrRecord['ResponseCode'] = 0;
		    $arrRecord['ResponseMessage'] = 'No record found';
		}
	} else {
	    $arrRecord['ResponseCode'] = 3;
	    $arrRecord['ResponseMessage'] = 'All parameters required.';
	}
} else {
	if(!empty($pageIndex) && !empty($numberOfRecords) && !empty($category_id)) {

		if($pageIndex > 1)
		{
		    $offset = ($pageIndex - 1) * $numberOfRecords;
		}

		if ($category_id != ''){
			$sql = $db->prepare("SELECT sw.id, sw.user_id, sw.image, sw.wallpaper_color,sw.wallpaper_height, sw.views, sw.likes, sc.category, su.id as us_id, su.username ,su.profile_image
				FROM status_wallpapers as sw
				INNER JOIN status_category as sc ON sw.cat_id=sc.id
				INNER JOIN status_users as su ON sw.user_id=su.id
				WHERE sw.cat_id='".$category_id."' AND sw.status='1'
				ORDER BY sw.views DESC limit $offset, $numberOfRecords");
		} else {
		    $sql = $db->prepare("SELECT sw.id, sw.user_id, sw.image, sw.wallpaper_color,sw.wallpaper_height, sw.views, sw.likes, sc.category, su.id as us_id, su.username ,su.profile_image
		    	FROM status_wallpapers as sw
		    	INNER JOIN status_category as sc ON sw.cat_id=sc.id
		    	INNER JOIN status_users as su ON sw.user_id=su.id
		    	WHERE sw.status='1'
		    	ORDER BY sw.views DESC limit $offset, $numberOfRecords");
		}
		
		$sql->execute();
		$result = $sql->fetchAll();
		foreach ($result as $key => $value) {

		    if ($value['image'] == "") {
		        $image = "";
		    } else {
		        $image = BASE_URL."/images/wallpapers/".$value['image'];
		    }
		    if ($value['profile_image'] == "") {
		        $user_image = "";
		    } else {
		        $user_image = BASE_URL."/images/profile/".$value['profile_image'];
		    }

		    $data[] = array(
		        "id" => $value['id'],
		        "wallpaper_image" => $image,
		        "wallpaper_color" => $value['wallpaper_color'],
		        "wallpaper_height" => $value['wallpaper_height'],
		        "user_image" => $user_image,
		        "user_id" => $value['us_id'],
		        "user_name" => $value['username'],
		        "category_name" => $value['category'],
		        "wallpaper_likes" => $value['likes'],
		        "isFavourite" => "2",
		        "wallpaper_views" => $value['views']
		    );
		}
		if (isset($data)) {
		    if (!empty($data)) {
		        $arrRecord['ResponseCode'] = 1;
		        $arrRecord['ResponseMessage'] = 'Wallpapers Get Successfully';
		        $arrRecord['ResponseData'] = $data;
		    } else {
		        $arrRecord['ResponseCode'] = 0;
		        $arrRecord['ResponseMessage'] = 'Something went wrong';
		    }
		} else {
		    $arrRecord['ResponseCode'] = 0;
		    $arrRecord['ResponseMessage'] = 'No record found';
		}
	} else {
	    $arrRecord['ResponseCode'] = 3;
	    $arrRecord['ResponseMessage'] = 'All parameters required.';
	}
}
echo json_encode($arrRecord);

?>