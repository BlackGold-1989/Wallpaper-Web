<?php
if (isset($_SESSION['email'])) {
  $username = $_SESSION['email'];
}else {
  header('location:login.php');
}
?>
<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <div class="brand-logo">
        <a href="home.php">
            <b class="logo-abbr"><h2 style="color: #fff;">W</h2> </b>
            <span class="logo-compact"><img src="images/logo-compact.png" alt=""></span>
            <span class="brand-title">
                <!-- <img src="images/logo-text.png" alt=""> -->
                <h2 style="color: #fff;">Wallpaper</h2>
            </span>
        </a>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<div class="header">    
    <div class="header-content clearfix">
        
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="images/logo.png" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <!-- <li>
                                    <a href="javascript:void();"><i class="icon-user"></i> <span>Profile</span></a>
                                </li>
                                <hr class="my-2"> -->
                                <li><a href="inc/logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>