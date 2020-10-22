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
    <title>Wallpaper | Wallpapers</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
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
                        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Wallpapers</a></li>
                    </ol>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddPhoto" data-whatever="@addPhoto">Add Wallpaper</button>

                    <a href="pending-wallpapers.php" class="btn btn-warning">Pending Wallpaper</a>
                    <a href="approved-wallpapers.php" class="btn btn-success">Approved Wallpaper</a>
                    <a href="rejected-wallpapers.php" class="btn btn-danger">Rejected Wallpaper</a>
                </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($_SESSION['alertType']) && isset($_SESSION['alertMessage'])) {
                        ?>
                            <div class="alert alert-<?php echo $_SESSION['alertType']; ?> alert-dismissible mt-3">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Message!</strong> <?php echo $_SESSION['alertMessage']; ?>
                            </div>
                        <?php
                            clearAlert();
                        }
                        ?>
                        <div id="errormsg" class="alert alert-danger alert-dismissible mt-3" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> Something went wrong please try again..
                        </div>

                        <div id="success-msg" class="alert alert-dismissible mt-3" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="msg"></span>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Wallpapers</h4>
                                <div class="table-responsive" id="table-display">
                                    <?php include('inc/photo_table.php'); ?>
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
        <!-- Add Photo -->
        <div class="modal fade" id="AddPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="addphoto" class="addphoto" id="addphoto" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Wallpapers</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category-id" class="col-form-label">Category Name:</label>
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="">----Select----</option>
                                    <?php
                                    $sth = $db->prepare("SELECT id,category,created_at FROM status_category");
                                    $sth->execute();
                                    $cat_result = $sth->fetchAll();
                                    foreach ($cat_result as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['category']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colour" class="col-form-label">Select Multiple images:</label>
                                <input type="file" multiple="true" class="form-control" name="file[]" id="file">
                                <input type="hidden" name="removeimg" id="removeimg">
                            </div>
                            <div class="gallery"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" name="submit" id="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Photo -->
        <div class="modal fade" id="EditPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="editphoto" class="editphoto" id="editphoto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Photo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        	<input type="hidden" class="form-control" id="id" name="id">
                            <input type="hidden" class="form-control" id="old_img" name="old_img">
                        	<input type="hidden" class="form-control" id="editdata" name="editdata" value="editphoto">
                            <div class="form-group">
                                <label for="category-id" class="col-form-label">Category Name:</label>
                                <select class="form-control" name="category_id" id="getcategory_id">
                                    <option value="">----Select----</option>
                                    <?php
                                    $sth = $db->prepare("SELECT id,category,created_at FROM status_category");
                                    $sth->execute();
                                    $cat_result = $sth->fetchAll();
                                    foreach ($cat_result as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['category']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colour" class="col-form-label">Select Multiple images:</label>
                                <input type="file" multiple="true" class="form-control" name="file" id="editfile">
                                <input type="hidden" name="removeimg" id="removeimg">
                            </div>
                            <div class="gallerys"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" name="update" id="update" class="btn btn-primary">Update</button>
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
        $(function() {
          $(".addphoto").validate({
            rules: {
              category_id: "required",
              file: "required",
            },
            messages: {
              category_id: "Please enter category name",
              file: "Please select image"
            },
          
            submitHandler: function(form) {
              form.submit();
            }
          });
        });
    </script>

    <script type="text/javascript">

    $("#submit").click(function(){
        
        var fd = new FormData(document.getElementById('addphoto'));
        // console.log($('#file')[0].files[0]);
        fd.append('file',$('#file')[0].files);
        fd.append('category_id',$("#category_id").val());
        fd.append('action','add');

        if( $(".addphoto").valid() ) {
            $('#loaderimg').show();
            $.ajax({
                url:'ajax/photo.php',
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    $("#loaderimg").hide();
                    jQuery("#AddPhoto").modal('hide');
                    $(".addphoto")[0].reset();
                    $('div.gallery').html('');  
                    if (data == 1) {
                        $('#msg').text('Photo added successfully..');
                        $('#success-msg').addClass('alert-success');
                                              
                        PhotoTable();
                        
                    } else {
                        $('#msg').text('Something went wrong..');
                        $('#success-msg').addClass('alert-danger');
                    }
                    $('#success-msg').css("display","block");
                    setTimeout(function() {
                        $("#success-msg").hide();
                        // alert('test');
                    }, 5000);
                    // location.href = "product.php"
                }
            });
        }
    });

    $("#update").click(function(){
        // alert('afad');

        var fd = new FormData(document.getElementById('editphoto'));
        var id= $("#id").val();
        var getcategory_id= $("#getcategory_id").val();
        var old_img= $("#old_img").val();
        var editdata= $("#editdata").val();
        fd.append('file',$('#editfile')[0].files[0]);
        
        if( $(".editphoto").valid() ) {
            $('#loaderimg').show();
            $.ajax({
                url:'ajax/photo.php',
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
                        jQuery("#EditPhoto").modal('hide');
                        $(".editphoto")[0].reset();
                        $('#msg').text(response['msg']);
                        $('#success-msg').addClass('alert-success');                  
                        // PhotoTable();
                        $('#success-msg').css("display","block");
                        setTimeout(function() {
                            $("#success-msg").hide();
                        }, 5000);

                    } else {
                        $('#editerrormsg').text(response['msg']);
                        $('#edit-error-msg').addClass('alert-danger');
                        $('#edit-error-msg').css("display","block");
                        setTimeout(function() {
                            $("#edit-error-msg").hide();
                        }, 5000);
                    }
                }
            });
        }
    });

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
                                PhotoTable();
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

    function PhotoTable() {
        $.ajax({
            url:'inc/photo_table.php',
            method:'POST',
            success:function(data){
                $('#table-display').html(data);
                $('#table-product').DataTable();
            }
        });
    }

    function GetData(id) {
        var ajaxscript = {
            ajax_url: 'ajax/photo.php'
        }
        $.ajax({
            url: ajaxscript.ajax_url,
            data: {
                action: 'edit',
                id: id
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                $("#editphoto")[0].reset(); 
                jQuery("#EditPhoto").modal('show');
                $('#id').val(response.id);
                $('#getcategory_id').val(response.cat_id);
                $('.gallerys').html("<img src='images/wallpapers/"+response.image+"' class='img-fluid' style='max-height: 200px;'>");
                $('#old_img').val(response.image);
            },
            error: function(error) {
            	$('#msg').text('Something went wrong..');
            	$('#success-msg').addClass('alert-danger');
            	$('#success-msg').css("display","block");
            	setTimeout(function() {
            	        $("#success-msg").hide();
            	        // alert('test');
            	}, 5000);
            }
        })
    }

    function DeleteData(id) {
        swal({
            title: "Are you sure?",
            text: "Do you want to delete this product?",
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
                var url='ajax/photo.php';
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
                            text: "Photo has been deleted.",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                $('#dataid'+id).remove();
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

    $(document).ready(function() {
        setTimeout(function() {
                $("#success-msg").hide();
                // alert('test');
        }, 5000);
    });
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