<?php
session_start();
define("BASE_URL", "http://wallpaper.daxiao-itdev.com/");
define("FIREBASE_SERVER_KEY", "AAAAn1J2WIE:APA91bE3Nmmjsx5xkTQHe04xcVRkBJCL9fLqF8IWSSbD71R20D-sgM5fjpmrqBj4NxZEaSiL_8A81ksAOzil0dTdfL8P_JuAw-yNlo1W4ZnysHBI-x4ZTnuqhdcaIAJv2lf_dzksI8Bs");
Class Connection {
private  $server = "mysql:host=HOSTNAME;dbname=daxiaoit_wallpaper";
private  $user = "daxiaoit_kyc";
private  $pass = "Kyc19891118@";
private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
protected $con;
 
            public function openConnection()
             {
               try
                 {
          $this->con = new PDO($this->server, $this->user,$this->pass,$this->options);
          return $this->con;
                  }
               catch (PDOException $e)
                 {
                     echo "There is some problem in connection: " . $e->getMessage();
                 }
             }
public function closeConnection() {
     $this->con = null;
  }
}

function data_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'Gravity_wallpaper';
    $secret_iv = 'Gravity_wallpaper';
    
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key);
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );     
    if( $action == 'enc' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'dec' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
}

function input() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json,TRUE);
    $input_array = array();
    if(!empty($obj)) {
        foreach ($obj as $k => $v) {
           $input_array[$k] = clean_input($v);
        }
    }
    return $input_array;
}

function beliefmedia_dominant_color($image, $array = false, $format = 'rgb(%d, %d, %d)') {

  /* http://php.net/manual/en/function.imagecreatefromjpeg.php */
  $i = imagecreatefromjpeg($image);

  for ($x=0;$x<imagesx($i);$x++) {
    for ($y=0;$y<imagesy($i);$y++) {
      $rgb = imagecolorat($i,$x,$y);
      $r = ($rgb >> 16) & 0xFF; $g = ($rgb >> 8) & 0xFF; $b = $rgb & 0xFF;
 
       @$r_total += $r;
       @$g_total += $g;
       @$b_total += $b;
       @$total++;
    }
  }

  $r = round($r_total / $total);
  $g = round($g_total / $total);
  $b = round($b_total / $total);

  $rgb = ($array) ? array('r'=> $r, 'g'=> $g, 'b'=> $b) : sprintf($format, $r, $g, $b);

 return $rgb;
}

function timberpress_rgb_to_hex( $color ) {

    $pattern = "/(\d{1,3})\,?\s?(\d{1,3})\,?\s?(\d{1,3})/";

    // Only if it's RGB
    if ( preg_match( $pattern, $color, $matches ) ) {
      $r = $matches[1];
      $g = $matches[2];
      $b = $matches[3];

      $color = sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    return $color;
}   

function clean_input($data) {
    $data = trim(htmlentities(strip_tags($data)));
    if (get_magic_quotes_gpc())
       $data = stripslashes($data);
    return $data;
}

function logout() {
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    unset($_SESSION['username']);

    header("Location: index.php");
}

function setAlert($type, $message) {

 $_SESSION['alertType'] = $type;
 $_SESSION['alertMessage'] = $message;
 // print_r($_SESSION); die;
}

function clearAlert() {
 unset($_SESSION['alertType']);
 unset($_SESSION['alertMessage']);
 // print_r($_SESSION); die;
}
 
function api() {
  // User data to send using HTTP POST method in curl
  $data = array('purchase_key'=>'{PURCHACE_KEY}','domain'=>'{DOMAIN}', 'user_id' => '{USERID}');
   
  // Data should be passed as json format
  $data_json = json_encode($data);

  // API URL to send data
  $url = 'https://infotechgravity.com/codecanyon/api/verify.php';
   
  // curl initiate
  $ch = curl_init();
   
  curl_setopt($ch, CURLOPT_URL, $url);
   
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   
  // SET Method as a POST
  curl_setopt($ch, CURLOPT_POST, 1);
   
  // Pass user data in POST command
  curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
   
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
  // Execute curl and assign returned data
  $response  = curl_exec($ch);
   
  // Close curl
  curl_close($ch);
   
  // See response if data is posted successfully or any error
  // print_r ($response);

  $obj = json_decode($response);
  if ($obj->{'ResponseCode'} == "1") {
    return 1;
  } else {
    return 2;
  } 
}