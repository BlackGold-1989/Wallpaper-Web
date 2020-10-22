<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();
$wallpaper_id = $_POST['wallpaper_id'];

if(!empty($wallpaper_id)) {
	$data = [
	    'id' => $wallpaper_id
	];
	$sql = "UPDATE status_wallpapers SET views= views+1 WHERE id=:id";
	$count = $db->prepare($sql)->execute($data);

	if ($count > 0) {
	    $rowsSelect = $db->prepare("SELECT views FROM status_wallpapers WHERE id='".$wallpaper_id."'");
	    $rowsSelect->execute();
	    $rowc = $rowsSelect->fetch();

	    $ResponseData = array(
	        "wallpaper_views" => $rowc['views']
	    );

	    $arrRecord['ResponseCode'] = 1;
	    $arrRecord['ResponseMessage'] = 'Success';
	    $arrRecord['ResponseData'] = $ResponseData;

	  } else {
	      $arrRecord['ResponseCode'] = 0;
	      $arrRecord['ResponseMessage'] = 'Something went wrong';
	  }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);

?>