<?php

session_start();

require("../include/connection.inc.php");
require("../include/functions.inc.php");

$error_msg = "";

if(!isset($_SESSION["db_loggedin"])){
    redirect('login');
}

$db_id = $_SESSION["db_id"];

if(isset($_GET['set_om_id'])){
    $om_delivered_on = date('Y-m-d h:i:s');
    $set_om_id = get_safe_value($con, $_GET['set_om_id']);
    $sql = "update order_master set om_payment_status='success', om_order_status='4', om_delivered_on='$om_delivered_on' where om_id='$set_om_id' and om_db_id='$db_id'";
    // prx($sql);
    $res = mysqli_query($con, $sql);
    redirect('index.php');
}

$sql= "select order_master.*, order_status.os_status from order_master, order_status where order_master.om_order_status = order_status.os_id and order_master.om_db_id = '$db_id' and order_master.om_order_status!=4 order by order_master.om_id desc";
$res=mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Order</title>

        <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
        <link rel="stylesheet" href="assets/css/vendor.bundle.base.css" />
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css" />
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
                                <span class="nav-profile-name">Hello, <?php echo $_SESSION["db_name"] ?></span>
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
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Master</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>User Details</th>
                                                        <th>Address</th>
                                                        <th>Price</th>
                                                        <th>Payment Status</th>
                                                        <th>Order Status</th>
                                                        <th>Added On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php while($row = mysqli_fetch_assoc($res)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['om_id']; ?></td>
                                                        <td>
                                                            <p>Name : <?php echo $row['om_u_name'] ?></p>
                                                            Mobile : <?php echo $row['om_u_mobile'] ?>
                                                        </td>
                                                        <td>
                                                            <p><?php echo $row['om_u_address'] ?></p>
                                                            Zip : <?php echo $row['om_zip'] ?>
                                                        </td>
                                                        <td>Rs. <?php echo $row['om_final_price'] ?></td>
                                                        <td id="pay_status" class="pay_status_<?php echo $row['om_payment_status'] ?>"><?php echo $row['om_payment_status'] ?></td>
                                                        <td><a href="?set_om_id=<?php echo $row['om_id'] ?>">Set Delivered</a></td>
                                                        <td>
                                                                <?php 
                                                                        $dateStr = strtotime($row['om_added_on']);
                                                                        echo "<p>".date('d M Y', $dateStr)."</p>";
                                                                        echo date('h:i', $dateStr);
                                                                ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020<a href="javascript:void(0)" target="_blank"> Rahul Panchal</a>. All rights reserved.</span>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <script src="assets/js/custom-js.js"></script>
        <script src="assets/js/vendor.bundle.base.js"></script>
        <script src="assets/js/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables.bootstrap4.js"></script>

        <script src="assets/js/Chart.min.js"></script>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>

        <script src="assets/js/off-canvas.js"></script>
        <script src="assets/js/hoverable-collapse.js"></script>
        <script src="assets/js/template.js"></script>
        <script src="assets/js/settings.js"></script>
        <script src="assets/js/todolist.js"></script>

        <script src="assets/js/dashboard.js"></script>
        <script src="assets/js/data-table.js"></script>
    </body>
</html>
