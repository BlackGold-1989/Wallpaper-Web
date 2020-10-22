<?php
include ('../inc/database.php');
require 'class.phpmailer.php';
$database = new Connection();
$db = $database->openConnection();

$_POST = input ();

$email = $_POST['email'];

if(!empty($email)) {
    try
    {

        $get_sql = $db->prepare("SELECT password FROM `status_users` WHERE `email`='".$email."'");
        $get_sql->execute();
        $result = $get_sql->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $mail = new PHPMailer(); // create a new object
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'wallpaper@wallpaper.daxiao-itdev.com';                 // SMTP username
            $mail->Password = 'Kyc19891118@';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('wallpaper@wallpaper.daxiao-itdev.com', 'Wallpaper');
            $mail->addAddress($email,'User');     // Add a recipient
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Forgot Password';
            $mail->Body    = "Your Password is : ".$result['password'];
            //$mail->AltBody = '';
            if(!$mail->Send()) {
                $arrRecord['ResponseCode'] = 0;
                $arrRecord['ResponseMessage'] = 'Something went wrong.';
            } else {
                $arrRecord['ResponseCode'] = 1;
                $arrRecord['ResponseMessage'] = 'Your password has been sent to your registered email.';
            }
        } else {
            $arrRecord['ResponseCode'] = 0;
            $arrRecord['ResponseMessage'] = 'Invalid email id please enter valid email id.';
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