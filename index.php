<?php
require('include/constants.inc.php');
require('include/connection.inc.php');
require('include/functions.inc.php');
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?php echo SITE_NAME ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/animate.css" />
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css" />
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link rel="stylesheet" href="assets/css/responsive.css" />
        <link rel="stylesheet" href="assets/css/custom-css.css" />
        <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <div class="slider-area">
            <div class="slider-active owl-dot-style owl-carousel">
                <?php 
                    $sql = "select * from banner where b_status = 1 order by b_id desc";
                    $res = mysqli_query($con, $sql);
                    while($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="single-slider pt-210 pb-220 bg-img" style="background-image: url(<?php echo BANNER_IMG_DISPLAY_PATH.$row['b_image'] ?>);">
                    <div class="container">
                        <div class="slider-content slider-animated-1">
                            <h1 class="animated"><?php echo $row['b_heading'] ?></h1>
                            <h3 class="animated"><?php echo $row['b_sub_heading'] ?></h3>
                            <div class="slider-btn mt-90">
                                <a class="animated" href="<?php echo $row['b_link'] ?>"><?php echo $row['b_link_text'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <script src="assets/js/vendor/jquery-1.12.0.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/imagesloaded.pkgd.min.js"></script>
        <script src="assets/js/isotope.pkgd.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
