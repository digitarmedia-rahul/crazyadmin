<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
$c_date = date("Y-m-d H:i:s");
$date = date("Y-m-d");

include('login_check.php');
include_once 'includes/general.class.php';
include("includes/pagination.php");
$general = new General;
$general->set_connection($mysqli);
// fetch the current url to get the page name
$parts = Explode('/', $_SERVER["PHP_SELF"]);
$currenttab = $parts[count($parts) - 1];
if($currenttab == 'manage-bob.php'){
  $currenttab = 'carzy-brands.php';
}
$userDetails = $general->GetUserDetails($_SESSION['ADMINUSERID'], $_SESSION['ADMIN_USERNAME']);

if ($userDetails === 0) {
  die('Access-denied');
}

$uid   = $_SESSION['ADMINUSERID'];

?>
<header class="main-header">
  <!-- Logo -->

  <a href="dashboard.php" class="logo">

    <!-- logo for regular state and mobile devices -->
    <span class="logo-mini"><b>M</b>LB</span>
    <!-- <img src="assets/images/logo.png" alt="eduacademy" class="brand-image elevation-3" style="opacity: .8; height: 50px;"> -->
    <h3 class="text-center" style="margin-top: revert;border: 1px solid #656060;padding: 5px;border-radius:20px;"><i><b>Crazy Offers</b></i></h3>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" style="height: 30px;">

    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu" >
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu user user-menu">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="hidden-xs">Hi&nbsp;<?php if (!empty($userDetails['admin_name'])) {
                                              echo $userDetails['admin_name'];
                                            } ?>&nbsp;</span>
          </a>

          <ul class="dropdown-menu">
            <li class="header">
              <?php if (!empty($userDetails['admin_name'])) {
                echo $userDetails['admin_name'];
              } ?><br>

              <span><?php if (!empty($userDetails['admin_email'])) {
                      echo $userDetails['admin_email'];
                    } ?></span>

            </li>

            <li>
              <!-- inner menu: contains the actual data -->

              <ul class="menu">

                <li>

                  <a href="profile.php"><i class="fa fa-user"></i>My Profile</a>

                </li>
                <li>

                  <a href="dashboard.php"><i class="fa fa-dashboard text-yellow"></i> Dashboard</a>

                </li>
                <li>

                  <a href="logout.php"><i class="fa fa-power-off text-red"></i> Logout</a>


                </li>

              </ul>

            </li>

          </ul>

        </li>

      </ul>

    </div>

  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" id="scrollspy">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li <?php if ($currenttab == 'dashboard.php') { ?>class="active" <?php } ?>><a href="dashboard.php"><span class="icon dashboard-color"><i class="fa fa-home"></i> <span>Dashboard</span></span></a></li>
      <li class="treeview <?php if ($currenttab == 'carousel-home-top.php' or $currenttab == 'card-animation-home.php' or $currenttab == 'top-brand-home.php'or $currenttab == 'carzy-brands.php') {
          echo 'active menu-open';
        } ?>">
        <a href="javascript:void(0)"><span class="icon dashboard-color">
            <i class="fa fa-gear"></i><span>Home</span></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu opentalleft">
          <li <?php if ($currenttab == 'carousel-home-top.php') { ?>class="active" <?php } ?>><a href="carousel-home-top.php"><span class="icon dashboard-color"><i class="fa fa-arrow-right"></i> <span>Carousel-Top</span></span></a></li>
          <li <?php if ($currenttab == 'card-animation-home.php') { ?>class="active" <?php } ?>><a href="card-animation-home.php"><span class="icon dashboard-color"><i class="fa fa-arrow-right"></i> <span>Card-animation</span></span></a></li>
          <li <?php if ($currenttab == 'top-brand-home.php') { ?>class="active" <?php } ?>><a href="top-brand-home.php"><span class="icon dashboard-color"><i class="fa fa-arrow-right"></i> <span>Top-Brand-List</span></span></a></li>
          <li <?php if ($currenttab == 'carzy-brands.php') { ?>class="active" <?php } ?>><a href="carzy-brands.php"><span class="icon dashboard-color"><i class="fa fa-arrow-right"></i> <span>Best of Brands</span></span></a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>

<style type="text/css">
  span.logo-lg {
    margin: 0px 50px;
    font-size: 22px;
    font-weight: 700;
  }

  .sidebar-menu li a i {
    margin-right: 10px;
  }
</style>