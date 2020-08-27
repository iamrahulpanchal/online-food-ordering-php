<?php

session_start();

require("../include/connection.inc.php");
require("../include/functions.inc.php");

$error_msg = "";

if(isset($_POST["db_login"])){
        $db_mobile = get_safe_value($con, $_POST["db_mobile"]);
        $db_password = get_safe_value($con, $_POST["db_password"]);

        $sql = "select * from delivery_boy where db_mobile = '$db_mobile'";
        $res = mysqli_query($con, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
                $sql = "select * from delivery_boy where db_mobile = '$db_mobile' and db_password = '$db_password'";
                $res = mysqli_query($con, $sql);
                $count = mysqli_num_rows($res);
                if($count > 0){
                        $row = mysqli_fetch_assoc($res);
                        $_SESSION["db_loggedin"] = "yes";
                        $_SESSION["db_name"] = $row["db_name"];
                        $_SESSION["db_id"] = $row["db_id"];
                        redirect("index.php");
                } else {
                        $error_msg = "Please enter correct password.";
                }
        } else {
                $error_msg = "Mobile Number not Registered";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Delivery Boy | Login</title>
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
                                    <p class="db_header">Delivery Boy Login</p>
                                </div>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" id="db_mobile" placeholder="Mobile" name="db_mobile" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="db_password" placeholder="Password" name="db_password" required />
                                    </div>
                                    <div class="error_msg">
                                            <p><?php echo $error_msg; ?></p>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="db_login">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
    </body>
</html>