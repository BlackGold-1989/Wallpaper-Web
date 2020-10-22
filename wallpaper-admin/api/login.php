<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$email = $_POST['email'];
$password = data_crypt($_POST['password'],'enc');
$device_type = $_POST['device_type'];
$device_token = $_POST['device_token'];
    

if(!empty($email) && !empty($password) && !empty($device_type) && !empty($device_token)) {
	// echo "SELECT id FROM status_users where email='".$email."' AND password='".$password."'"; exit();
    $sth = $db->prepare("SELECT id FROM status_users where email='".$email."' AND password='".$password."'");
    $sth->execute();
    $result = $sth->fetch();
    if ($result) {

        $data = [
            'id' => $result['id'],
            'device_type' => $_POST['device_type'],
            'device_token' => $_POST['device_token']
        ];

        $sql = "UPDATE status_users SET device_type=:device_type,device_token=:device_token WHERE id=:id";
        $update = $db->prepare($sql)->execute($data);

        $arrRecord['ResponseCode'] = 1;
        $arrRecord['ResponseMessage'] = 'Login Successful';
        $arrRecord['ResponseData']['id'] = $result['id'];
    } else {
        $arrRecord['ResponseCode'] = 0;
        $arrRecord['ResponseMessage'] = 'Invalid email id or password';
    }
} else {
    $arrRecord['ResponseCode'] = 3;
    $arrRecord['ResponseMessage'] = 'All parameters required.';
}
echo json_encode($arrRecord);
?>