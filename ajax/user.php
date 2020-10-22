<?php
include_once '../inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
if (@$_POST['action'] == "delete") {
	$get_image = $db->prepare("SELECT profile_image FROM status_users WHERE id='".$_POST['id']."'"); 
	$get_image->execute(); 
	$row = $get_image->fetch();

	if (@$row['profile_image'] != '') {
		unlink('../images/profile/'.$row['profile_image'].'');
	}	

	$stmt = $db->prepare("DELETE FROM status_users WHERE id = ?");
	$stmt->execute(array($_POST['id']));
	$count = $stmt->rowCount();

	$stmt_wallpaper = $db->prepare("DELETE FROM status_wallpapers WHERE user_id = ?");
	$stmt_wallpaper->execute(array($_POST['id']));
	echo $count;
}
?>