<?php

session_start();

require("../include/connection.inc.php");
require("../include/functions.inc.php");
require("../include/constants.inc.php");

date_default_timezone_set('Asia/Kolkata');

// prx($_SERVER);

// Change page title dynamically
$scriptName = $_SERVER['SCRIPT_NAME'];
$scriptNameArr = explode('/', $scriptName);
$pageName = $scriptNameArr[count($scriptNameArr) - 1];
$pageNameArr = explode('.',$pageName);
$pageTitle = $pageNameArr[0];
$pageTitle = str_replace('_', ' ', $pageTitle);
$pageTitle = ucwords($pageTitle);

if(!isset($_SESSION["a_loggedin"])){
        redirect("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?php echo $pageTitle ?></title>

        <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">

        <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css" />

        <link rel="stylesheet" href="assets/css/custom-css.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>
    <body class="sidebar-light">
        <div class="container-scroller">
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                    <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
                        <li class="nav-item nav-toggler-item">
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                                <span class="mdi mdi-menu"></span>
                            </button>
                        </li>
                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/logo.png" alt="logo" /></a>
                        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo.png" alt="logo" /></a>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <span class="nav-profile-name">Hello, <?php echo $_SESSION["a_name"]; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                        <li class="nav-item nav-toggler-item-right d-lg-none">
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                                <span class="mdi mdi-menu"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid page-body-wrapper">
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="mdi mdi-view-quilt menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="order.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Order Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Category Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">User Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="delivery_boy.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Delivery Boy Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="coupons.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Coupon Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dish.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Dish Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="banner.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Banner Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact_us.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Contact Us Master</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="setting.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Website Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="main-panel">
                    <div class="content-wrapper">