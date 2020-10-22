<?php 
include_once 'inc/database.php'; 

if (isset($_SESSION['email'])) {
    header('location:home.php');
}

if (isset($_POST['signin'])) {    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = data_crypt($_POST['password'],'enc');
    $database = new Connection();
    $db = $database->openConnection();

    $get_sql = $db->prepare("SELECT `email`,`password` FROM `status_users` WHERE `email`='".$email."' AND `password`='".$password."'");
    $params = array($email,$password);
    $get_sql->execute($params);
    $result = $get_sql->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['email']=$result['email'];
        $_SESSION['role']=$result['role'];
        header('Location:home.php');
    } else {
        setAlert("danger","Invalid email or password");
  }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Wallpapers | Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.html">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    



    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    
                    <div class="form-input-content">
                        <?php
                        if (isset($_SESSION['alertType']) && isset($_SESSION['alertMessage'])) {
                        ?>
                            <div class="alert alert-<?php echo $_SESSION['alertType']; ?> alert-dismissible mt-3">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Fail!</strong> <?php echo $_SESSION['alertMessage']; ?>
                            </div>
                        <?php
                            clearAlert();
                        }
                        ?>
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="javascript:void();"> <h4>Wallpaper</h4></a>
        
                                <form class="mt-5 mb-5 login-input" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    <button class="btn login-form__btn submit w-100" type="submit" name="signin">Sign In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>





