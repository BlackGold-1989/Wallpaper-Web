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
    <title>Wallpaper | Category</title>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
                    </ol>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddCategory" data-whatever="@addcategory">Add Category</button>
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
                                <h4 class="card-title">All Category</h4>
                                <div class="table-responsive" id="table-display">
                                    <?php include('inc/category_table.php'); ?>
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
        <!-- Add Category -->
        <div class="modal fade" id="AddCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                
                <form method="post" name="addcategory" class="addcategory" id="addcategory" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="error-msg" class="alert alert-dismissible mt-3" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="emsg"></span>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category" class="col-form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <label for="colour" class="col-form-label">select image:</label>
                                <input type="file" class="form-control" name="file" id="file">
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

        <!-- Edit Category -->
        <div class="modal fade" id="EditCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="editcategory" class="editcategory" id="editcategory" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabeledit">Edit Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="edit-error-msg" class="alert alert-dismissible mt-3" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Message!</strong> <span id="editerrormsg"></span>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" name="id">
                            <input type="hidden" class="form-control" id="old_img" name="old_img">
                            <input type="hidden" class="form-control" id="editdata" name="editdata" value="editcategory">
                            <div class="form-group">
                                <label for="category_id" class="col-form-label">Category Name:</label>
                                <input type="text" class="form-control" id="getcategory_name" name="category" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <label for="colour" class="col-form-label">Select image:</label>
                                <input type="file" class="form-control" name="file" id="editfile">
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
    $(document).ready(function(){
        
        $(function() {
          $(".addcategory").validate({
            rules: {
              category: "required",
              file: "required",
            },
            messages: {
              category: "Please enter category name",
              file: "Please select image"
            },
          
            submitHandler: function(form) {
              form.submit();
            }
          });
          $(".editcategory").validate({
            rules: {
              category: "required",              
            },
            messages: {
              category: "Please enter category name"
            },
          
            submitHandler: function(form) {
              form.submit();
            }
          });
        });

        $("#submit").click(function(){
            var fd = new FormData(document.getElementById('addcategory'));
            fd.append('file',$('#file')[0].files[0]);
            fd.append('category',$("#category").val());
            fd.append('action','add');
            
            if( $("#addcategory").valid() ) {
                $('#loaderimg').show();
                $.ajax({
                    url:'ajax/category.php',
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
                            jQuery("#AddCategory").modal('hide');
                            $(".addcategory")[0].reset();
                            $('.gallery').html('');
                            $('#msg').text(response['msg']);
                            $('#success-msg').addClass('alert-success');                  
                            CatetgoryTable();
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

        $("#update").click(function(){
            // alert('afad');

            var fd = new FormData(document.getElementById('editcategory'));
            var id= $("#id").val();
            var category_name= $("#getcategory_name").val();
            var old_img= $("#old_img").val();
            var editdata= $("#editdata").val();
            fd.append('file',$('#editfile')[0].files[0]);
            
            if( $(".editcategory").valid() ) {
                $('#loaderimg').show();
                $.ajax({
                    url:'ajax/category.php',
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
                            jQuery("#EditCategory").modal('hide');
                            $(".editcategory")[0].reset();
                            $('#msg').text(response['msg']);
                            $('#success-msg').addClass('alert-success');                  
                            CatetgoryTable();
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
    });

    function CatetgoryTable() {
        $.ajax({
            url:'inc/category_table.php',
            method:'POST',
            success:function(data){
                $('#table-display').html(data);
                $('#table-category').DataTable();
            }
        });
    }


    function GetData(id) {
        var ajaxscript = {
            ajax_url: 'ajax/category.php'
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
                $(".editcategory")[0].reset();
                jQuery("#EditCategory").modal('show');
                $('#id').val(response.id);
                $('#getcategory_name').val(response.category);
                
                $('.gallerys').html("<img src='images/category/"+response.image+"' class='img-fluid' style='max-height: 200px;'>");
                $('#old_img').val(response.image);
            },
            error: function(error) {

                $('#errormsg').show();
            }
        })
    }

    function DeleteData(id) {
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
                var url='ajax/category.php';
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
                            text: "Category has been deleted.",
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
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
                 if (input.files) {
                     var filesAmount = input.files.length;
                     $('.gallery').html('');
                     $('.gallerys').html('');
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
                imagesPreview(this, '.gallerys');
                imagesPreview(this, '.gallery');
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