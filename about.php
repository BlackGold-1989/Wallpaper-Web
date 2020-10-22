<?php
include_once 'inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();

$stmt = $db->prepare("SELECT id,about,created_at FROM status_about WHERE id='1'"); 
$stmt->execute(); 
$row = $stmt->fetch();

if (isset($_POST['update'])) {
    $data = [
        'id' => 1,
        'about' => $_POST['about'],
    ];
    // print_r($data);
    $sql = "UPDATE status_about SET about=:about WHERE id=:id";
    $result = $db->prepare($sql)->execute($data);

    if ($result) {
        setAlert("success","About content has been updated successfully..");
    } else {
        setAlert("danger","Something went wrong");      
    }
    header('Location:about.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Wallpaper | About Us</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

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

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Header start
        ***********************************-->
        <?php include('inc/header.php'); ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include('inc/sidebar.php'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Terms and Conditions</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($_SESSION['alertType']) && isset($_SESSION['alertMessage'])) {
                        ?>
                            <div class="alert alert-<?php echo $_SESSION['alertType']; ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> <?php echo $_SESSION['alertMessage']; ?>
                            </div>
                        <?php
                            clearAlert();
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">About Us</h4>
                                <p class="text-muted"><code></code>
                                </p>
                                <div id="terms-conditions-three" class="terms-conditions">
                                    <form method="post">
                                        <textarea class="form-control" id="ckeditor" name="about"><?php echo $row['about']; ?></textarea>
                                        <button type="submit" name="update" class="btn mb-1 btn-primary mt-5">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <?php include('inc/footer.php'); ?>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('ckeditor');
    </script>

</body>

</html>