<?php
include_once 'inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();

$category_stmt = $db->prepare("SELECT count(id) as total FROM status_category"); 
$category_stmt->execute(); 
$ttl_category = $category_stmt->fetch();

$photo_stmt = $db->prepare("SELECT count(id) as total FROM status_wallpapers"); 
$photo_stmt->execute(); 
$ttl_photo = $photo_stmt->fetch();

$photo_pending_stmt = $db->prepare("SELECT count(id) as total FROM status_wallpapers WHERE status='0'"); 
$photo_pending_stmt->execute(); 
$ttl_pending_photo = $photo_pending_stmt->fetch();

$photo_approved_stmt = $db->prepare("SELECT count(id) as total FROM status_wallpapers WHERE status='1'"); 
$photo_approved_stmt->execute(); 
$ttl_approved_photo = $photo_approved_stmt->fetch();

$photo_rejected_stmt = $db->prepare("SELECT count(id) as total FROM status_wallpapers WHERE status='2'"); 
$photo_rejected_stmt->execute(); 
$ttl_rejected_photo = $photo_rejected_stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Wallpaper | Home</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
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

            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">
                                <h3 class="card-title text-white"><a href="category.php" style="color: #fff;">Total Category</a></h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $ttl_category['total']; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-list-alt"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white"><a href="wallpapers.php" style="color: #fff;">Total Wallpapers</a></h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $ttl_photo['total']; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-image"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white"><a href="pending-wallpapers.php" style="color: #fff;">Pending Wallpapers</a></h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $ttl_pending_photo['total']; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-image"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">
                                <h3 class="card-title text-white"><a href="approved-wallpapers.php" style="color: #fff;">Approved Wallpapers</a></h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $ttl_approved_photo['total']; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-image"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-7">
                            <div class="card-body">
                                <h3 class="card-title text-white"><a href="rejected-wallpapers.php" style="color: #fff;">Rejected Wallpapers</a></h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $ttl_rejected_photo['total']; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-image"></i></span>
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

    <!-- Chartjs -->
    <script src="plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="plugins/d3v3/index.js"></script>
    <script src="plugins/topojson/topojson.min.js"></script>
    <script src="plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="plugins/chartist/js/chartist.min.js"></script>
    <script src="plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="js/dashboard/dashboard-1.js"></script>

</body>

</html>