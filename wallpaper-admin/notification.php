<?php
include_once 'inc/database.php'; 
$database = new Connection();
$db = $database->openConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Wallpaper | Notification</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Notification</a></li>
                    </ol>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNotification" data-whatever="@addnotification">Send new Notification</button>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div id="success-msg" class="alert alert-dismissible mt-3" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="msg"></span>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Notification</h4>
                                <div class="table-responsive" id="table-display">
                                    <?php include('inc/notification_table.php'); ?>
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
        <!-- Add Notification -->
        <div class="modal fade" id="AddNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                
                <form method="post" name="addnotification" class="addnotification" id="addnotification">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Notification</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="error-msg" class="alert alert-dismissible mt-3" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="emsg"></span>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-form-label">Notification Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Notification Title">
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-form-label">Message:</label>
                                <textarea class="form-control" name="message" id="message" placeholder="Type a message..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" name="submit" id="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
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
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

    <script src="plugins/sweetalert/js/sweetalert.min.js"></script>
    <script src="plugins/sweetalert/js/sweetalert.init.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    
    <script type="text/javascript">

    // Wait for the DOM to be ready
    $(document).ready(function(){
        
        $(function() {
          $(".addnotification").validate({
            rules: {
              title: "required",
              message: "required",
            },
            messages: {
              title: "Please enter title",
              message: "Please enter message"
            },
          
            submitHandler: function(form) {
              form.submit();
            }
          });
        });

        $("#submit").click(function(){
            var fd = new FormData(document.getElementById('addnotification'));
            fd.append('title',$("#title").val());
            fd.append('message',$("#message").val());
            fd.append('action','add');
            
            if( $("#addnotification").valid() ) {
                $('#loaderimg').show();
                $.ajax({
                    url:'ajax/notification.php',
                    method:'POST',
                    data:fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(response){
                        $("#loaderimg").hide();
                        // console.log(response['status']);
                        if (response['status'] == 1) {
                            jQuery("#AddNotification").modal('hide');
                            $(".addnotification")[0].reset();
                            $('#msg').text(response['msg']);
                            $('#success-msg').addClass('alert-success');                  
                            NotificationTable();
                            $('#success-msg').css("display","block");
                            setTimeout(function() {
                                $("#success-msg").hide();
                                // alert('test');
                            }, 5000);

                        } else {
                            $('#emsg').text(response['msg']);
                            $('#error-msg').addClass('alert-danger');

                            $('#error-msg').css("display","block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                                // alert('test');
                            }, 5000);
                        }
                    }
                });
            }
        });
    });

    function Resend(id) {
        swal({
            title: "Are you sure?",
            text: "Do you want to resend notification?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, cancel plz!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                var url='ajax/notification.php';
                $.ajax({
                    url: url,
                    data: {
                       action: 'delete',
                       id: id
                   },
                    method: 'POST',
                    success: function(response) {
                        swal({
                            title: "Approved!",
                            text: "Notification has been sent.",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                // $('#dataid'+id).remove();
                                swal.close();
                                // location.reload();
                            }
                        });
                    },
                    error: function(e) {
                        swal("Cancelled", "Something Went Wrong :(", "error");
                    }
                });
            } else {
                swal("Cancelled", "Your record is safe :)", "error");
            }
        });
    }

    function NotificationTable() {
        $.ajax({
            url:'inc/notification_table.php',
            method:'POST',
            success:function(data){
                $('#table-display').html(data);
                $('#table-category').DataTable();
            }
        });
    }
    </script>
</body>

</html>