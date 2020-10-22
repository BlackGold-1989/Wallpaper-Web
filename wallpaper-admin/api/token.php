<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

if (isset($_POST['token_id']) )
{
    $token_id=$_POST['token_id'];
    $device_type=$_POST['device_type'];
    $user_token = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ) .substr( md5( time() ), 1);

    $stm = $db->prepare("INSERT INTO status_token (token_id,device_type,user_token) VALUES (:token_id, :device_type,:user_token)") ;
    // inserting a record
    $res = $stm->execute(array(':token_id' => $token_id , 'device_type' => $device_type , 'user_token' => $user_token));

    if($res){
        $json[]=array("id"=>"True","user_token"=>$user_token);
        $jdata['Status'] =  $json;
        echo json_encode($jdata);
    }
    else{
        $ar[]=array("id"=>"False");
        $arr['Status']=$ar;
        echo json_encode($arr);
    }
}
else{
    $ar[]=array("id"=>"All parameter required");
    $arr['Status']=$ar;
    echo json_encode($arr);
    //echo '<pre>',print_r($arr,1),'</pre>';
}
?>