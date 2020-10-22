<?php
include ('../inc/database.php');
$database = new Connection();
$db = $database->openConnection();

    $sth = $db->prepare("SELECT id,category,image FROM status_category");
    $sth->execute();
    $result = $sth->fetchAll();
    $i = 1;
    foreach ($result as $key => $value) {

        if ($value['image'] == "") {
            $image = "";
        } else {
            $image = BASE_URL."/images/category/".$value['image'];
        }

        $data[] = array(
            "id" => $value['id'],
            "category_name" => $value['category'],
            "category_image" => $image
        );
    }
    if (isset($data)) {
        if (!empty($data)) {
            $arrRecord['ResponseCode'] = "1";
            $arrRecord['ResponseMessage'] = 'Categories Get Successfully';
            $arrRecord['ResponseData'] = $data;
        } else {
            $arrRecord['ResponseCode'] = "0";
            $arrRecord['ResponseMessage'] = 'no record found';
        }
    } else {
        $arrRecord['ResponseCode'] = "0";
        $arrRecord['ResponseMessage'] = 'no record found';
    }
    echo json_encode($arrRecord);
    //echo '<pre>',print_r($arrRecord,1),'</pre>';
?>