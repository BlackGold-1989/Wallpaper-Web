<?php
include_once 'inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
$stmt = $db->prepare("SELECT * FROM status_users WHERE id='".$_GET['id']."'"); 
$stmt->execute(); 
$get_data = $stmt->fetch();

$getWallpapers = $db->prepare("SELECT COUNT(id) AS totalWallpapers FROM status_wallpapers WHERE user_id='".$_GET['id']."'");
$getWallpapers->execute();
$totalWallpapers = $getWallpapers->fetch();

$getPendingWallpapers = $db->prepare("SELECT COUNT(id) AS totalPendingWallpapers FROM status_wallpapers WHERE user_id='".$_GET['id']."' AND status='0'");
$getPendingWallpapers->execute();
$totalPendingWallpapers = $getPendingWallpapers->fetch();

$getApprovalWallpapers = $db->prepare("SELECT COUNT(id) AS totalApprovedWallpapers FROM status_wallpapers WHERE user_id='".$_GET['id']."' AND status='1'");
$getApprovalWallpapers->execute();
$totalApprovedWallpapers = $getApprovalWallpapers->fetch();

$getRejectedWallpapers = $db->prepare("SELECT COUNT(id) AS totalRejectedWallpapers FROM status_wallpapers WHERE user_id='".$_GET['id']."' AND status='2'");
$getRejectedWallpapers->execute();
$totalRejectedWallpapers = $getRejectedWallpapers->fetch();

$getData = $db->prepare("SELECT SUM(likes) AS totalLike,SUM(views) AS totalViews  FROM status_wallpapers WHERE user_id='".$_GET['id']."'");
$getData->execute();
$ttlData = $getData->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Wallpapers | View Profile</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="plugins/sweetalert/css/sweetalert.css" rel="stylesheet">

</head>

<body>

    <div id="loaderimg" style="display: none">
        <img src="images/loader.gif" />
    </div>

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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="media align-items-center mb-4">
                                    <?php
                                    if ($get_data['profile_image'] == "") {
                                    ?>
                                        <img src="images/profile/user-avatar.png">
                                    <?php
                                    } else {
                                    ?>
                                        <img class="mr-3" src="images/profile/<?php echo $get_data['profile_image']; ?>" style="border-radius: 50%; width: 80px; height:80px" alt="">
                                    <?php
                                    }
                                    ?>
                                    <div class="media-body">
                                        <h3 class="mb-0"><?php echo $get_data['username']; ?></h3>
                                        <p class="text-muted mb-0"><?php echo $get_data['email']; ?></p>
                                    </div>
                                </div>
                                
                                <div class="row mb-5">
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-primary"><i class="icon-picture"></i></span>
                                            <h3 class="mb-0"><?php echo $totalWallpapers['totalWallpapers']; ?></h3>
                                            <p class="text-muted px-4">Total Wallpapers</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-warning"><i class="icon-clock"></i></span>
                                            <h3 class="mb-0"><?php echo $totalPendingWallpapers['totalPendingWallpapers']; ?></h3>
                                            <p class="text-muted px-4">Pending Wallpapers</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-success"><i class="icon-check"></i></span>
                                            <h3 class="mb-0"><?php echo $totalApprovedWallpapers['totalApprovedWallpapers']; ?></h3>
                                            <p class="text-muted px-4">Approved Wallpapers</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-danger"><i class="icon-close"></i></span>
                                            <h3 class="mb-0"><?php echo $totalRejectedWallpapers['totalRejectedWallpapers']; ?></h3>
                                            <p class="text-muted px-4">Rejected Wallpapers</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-dark"><i class="icon-eye"></i></span>
                                            <h3 class="mb-0">
                                                <?php if ($ttlData['totalViews'] == "") {
                                                    echo "0";
                                                } else {
                                                    echo $ttlData['totalViews']; 
                                                }
                                                ?>
                                            </h3>
                                            <p class="text-muted">Views</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-success"><i class="icon-like"></i></span>
                                            <h3 class="mb-0">
                                                <?php if ($ttlData['totalLike'] == "") {
                                                    echo "0";
                                                } else {
                                                    echo $ttlData['totalLike']; 
                                                }
                                                ?>
                                            </h3>
                                            <p class="text-muted">Likes</p>
                                        </div>
                                    </div>
                                </div>

                                <h4>Registered date</h4>
                                <p class="text-muted"><?php echo $get_data['created_at']; ?></p>
                                <ul class="card-profile__info">
                                    <li class="mb-1">
                                        <strong class="text-dark mr-4">Device Type</strong> 
                                        <span>
                                            <?php
                                            if ($get_data['device_type'] == "1") {
                                                echo "<span class='badge badge-info'>Android</span>";
                                            } else {
                                                echo "<span class='badge badge-info'>iPhone</span>";
                                            }
                                            ?>
                                        </span>
                                    </li>
                                    <li>
                                        <strong class="text-dark mr-4">Notification Status</strong> 
                                        <span>
                                            <?php
                                            if ($get_data['notification_status'] == "1") {
                                                echo "<span class='badge badge-success'>On</span>";
                                            } else {
                                                echo "<span class='badge badge-danger'>Off</span>";
                                            }
                                            ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <div id="success-msg" class="alert alert-dismissible mt-3" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="msg"></span>
                        </div>
                        <div id="card-display">
                            <?php include('inc/wallpapers.php'); ?>
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

    <script src="plugins/sweetalert/js/sweetalert.min.js"></script>
    <script src="plugins/sweetalert/js/sweetalert.init.js"></script>

    <script type="text/javascript">

        function DeleteImage(id) {
            swal({
                title: "Are you sure?",
                text: "Disable all related products when you delete this category. Do you want to delete this category?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plz!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    var ajaxscript = {
                            ajax_url: 'ajax/product.php'
                        }
                    $.ajax({
                        url: ajaxscript.ajax_url,
                        data: {
                            action: 'deleteimage',
                            id: id
                        },
                        method: 'POST', //Post method,
                        dataType: 'json',
                        success: function(response) {
                            $('.dataid'+id).remove();
                            swal({
                                title: "Approved!",
                                text: "Product image has been deleted.",
                                type: "success",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true,
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    // ViewImage();
                                }
                            });
                        },
                        error: function(e) {
                            swal("Cancelled", "Something Went Wrong :(", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Something went wrong :)", "error");
                }
            });
        }

        function WallpaperStatus(id,status) {
            swal({
                title: "Are you sure?",
                text: "Do you want to change status?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, change it!",
                cancelButtonText: "No, cancel plz!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    var ajaxscript = {
                            ajax_url: 'ajax/photo.php'
                        }
                    $.ajax({
                        url: ajaxscript.ajax_url,
                        data: {
                            action: 'status',
                            id: id,
                            status: status
                        },
                        method: 'POST', //Post method,
                        dataType: 'json',
                        success: function(response) {
                            swal({
                                title: "Approved!",
                                text: "Status has been changed.",
                                type: "success",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true,
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    ViewImage();
                                    swal.close();
                                }
                            });
                        },
                        error: function(e) {
                            swal("Cancelled", "Something Went Wrong :(", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Something went wrong :)", "error");
                }
            });
        }

        function ViewImage() {
            $.ajax({
                url:'inc/wallpapers.php?id=<?php echo $_GET['id']; ?>',
                method:'POST',
                success:function(data){
                    $("#demo").load(location.href + " #demo");
                    $('#card-display').html(data);
                    $('#table-image').DataTable();
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
                 if (input.files) {
                     var filesAmount = input.files.length;
                     $('div.gallery').html('');
                     var n=0;
                     for (i = 0; i < filesAmount; i++) {
                         var reader = new FileReader();
                         reader.onload = function(event) {
                              $($.parseHTML('<div>')).attr('class', 'imgdiv').attr('id','img_'+n).html('<img src="'+event.target.result+'" class="img-fluid"><span id="remove_"'+n+' onclick="removeimg('+n+')">&#x2716;</span>').appendTo(placeToInsertImagePreview); 
                             n++;
                         }
                         reader.readAsDataURL(input.files[i]);                                  
                    }
                 }
             };

            $('#file').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });
        
       });
       var images = [];
       function removeimg(id){
           images.push(id);
           $("#img_"+id).remove();
           $('#remove_'+id).remove();
           $('#removeimg').val(images.join(","));
       }
    </script>

</body>

</html>