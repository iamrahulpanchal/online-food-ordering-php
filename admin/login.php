<?php

session_start();

require("../include/connection.inc.php");
require("../include/functions.inc.php");

$error_msg = "";

if(isset($_POST["a_login"])){
        $a_username = get_safe_value($con, $_POST["a_username"]);
        $a_password = get_safe_value($con, $_POST["a_password"]);

        $sql = "select * from admin where a_username = '$a_username'";
        $res = mysqli_query($con, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
                $sql = "select * from admin where a_username = '$a_username' and a_password = '$a_password'";
                $res = mysqli_query($con, $sql);
                $count = mysqli_num_rows($res);
                if($count > 0){
                        $row = mysqli_fetch_assoc($res);
                        $_SESSION["a_loggedin"] = "yes";
                        $_SESSION["a_name"] = $row["a_name"];
                        redirect("index.php");
                } else {
                        $error_msg = "Please enter correct password.";
                }
        } else {
                $error_msg = "Please enter valid username.";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Food Ordering Admin</title>

        <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
        <link rel="stylesheet" href="assets/css/vendor.bundle.base.css" />

        <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css" />

        <link rel="stylesheet" href="assets/css/custom-css.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>
    <body class="sidebar-light">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row w-100">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="brand-logo text-center">
                                    <img src="assets/images/logo.png" alt="logo" />
                                </div>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" id="a_username" placeholder="Username" name="a_username" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="a_password" placeholder="Password" name="a_password" required />
                                    </div>
                                    <div class="error_msg">
                                            <p><?php echo $error_msg; ?></p>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="a_login">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/vendor.bundle.base.js"></script>

        <script src="assets/js/Chart.min.js"></script>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>

        <script src="assets/js/off-canvas.js"></script>
        <script src="assets/js/hoverable-collapse.js"></script>
        <script src="assets/js/template.js"></script>
        <script src="assets/js/settings.js"></script>
        <script src="assets/js/todolist.js"></script>

        <script src="assets/js/dashboard.js"></script>
    </body>
</html>