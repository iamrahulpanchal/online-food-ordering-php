<?php

session_start();

require('include/constants.inc.php');
require('include/connection.inc.php');
require('include/functions.inc.php');

$getSetting = getSetting();
// prx($getSetting);
$s_website_close = $getSetting['s_website_close'];
$s_cart_min_price = $getSetting['s_cart_min_price'];
$s_cart_min_price_msg = $getSetting['s_cart_min_price_msg'];
$s_website_close_msg = $getSetting['s_website_close_msg'];

getDishCartStatus();

if(isset($_POST['update_cart'])){
    if(isset($_SESSION['USER_ID'])){
        foreach($_POST['qty'] as $key=>$val){
            if($val[0]==0){
                $sql = "delete from dish_cart where dc_dd_id = $key and dc_u_id = ".$_SESSION['USER_ID'];
                $res = mysqli_query($con, $sql);
            } else {
                $sql = "update dish_cart set dc_qty = '$val[0]' where dc_dd_id = $key and dc_u_id = ".$_SESSION['USER_ID'];
                $res = mysqli_query($con, $sql);
            }
        }
    } else {
        foreach($_POST['qty'] as $key=>$val){
            if($val[0]==0){
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['qty']=$val[0];
            }
        }
    }
}

$cartArr = getUserFullCart();
// prx($cartArr);

$totalDish = count($cartArr);

$totalPrice=0;
foreach($cartArr as $list){
    $totalPrice = $totalPrice + ($list['qty']*$list['price']);
}

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
        <link rel="stylesheet" href="assets/css/slick.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <link rel="stylesheet" href="assets/css/ionicons.min.css" />
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/css/simple-line-icons.css" />
        <link rel="stylesheet" href="assets/css/jquery-ui.css" />
        <link rel="stylesheet" href="assets/css/meanmenu.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link rel="stylesheet" href="assets/css/responsive.css" />
        <link rel="stylesheet" href="assets/css/custom-css.css" />
        <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!-- header start -->
        <header class="header-area">
            <?php if(isset($_SESSION['USER_NAME'])) { ?>
            <div class="header-top black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 col-sm-4">

                        </div>
                        <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                            <div class="account-curr-lang-wrap f-right">
                                <ul>
                                    <li class="top-hover">
                                        <a href="javascript:void(0)">
                                            <?php if(!isset($_SESSION['USER_NAME'])) { ?>
                                                <?php echo "Setting"; ?>
                                            <?php } else {
                                                echo "Hi, <span id='user_name'>".$_SESSION['USER_NAME']."</span>";
                                            } ?>
                                            <i class="ion-chevron-down"></i>
                                        </a>
                                        <ul>
                                            <li><a href="profile">Profile </a></li>
                                            <li><a href="order_history">Order History</a></li>
                                            <li><a href="logout">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="header-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                            <div class="logo">
                                <a href="index">
                                    <!-- <img alt="" src="assets/img/logo/logo.png" /> -->
                                    <p class="logo-text">Food Ordering</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                            <div class="header-middle-right f-right">
                                <?php if(!isset($_SESSION['USER_NAME'])) {  ?>
                                <div class="header-login">
                                    <a href="login_register">
                                        <div class="header-icon-style">
                                            <i class="icon-user icons"></i>
                                        </div>
                                        <div class="login-text-content">
                                            <p>
                                                Register <br />
                                                or <span>Sign in</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                                <div class="header-wishlist">
                                    &nbsp;
                                </div>
                                <div class="header-cart">
                                    <a href="cart">
                                        <div class="header-icon-style">
                                            <i class="icon-handbag icons"></i>
                                            <span class="count-style" id="totalCartDish"><?php echo $totalDish ?></span>
                                        </div>
                                        <div class="cart-text">
                                            <span class="digit">My Cart</span>
                                            <span class="cart-digit-bold" id="totalPriceDish">Rs.&nbsp;<?php echo $totalPrice ?></span>
                                        </div>
                                    </a>
                                    <?php
                                    if($totalPrice!=0) { 
                                    ?>
                                    <div class="shopping-cart-content">
                                        <ul id="cart_ul">
                                            <?php
                                            foreach($cartArr as $key=>$list) {
                                            ?>
                                            <li class="single-shopping-cart" id="attr_<?php echo $key ?>">
                                                <div class="shopping-cart-img">
                                                    <a href="javascript:void(0)"><img alt="" style="width: 100%;" src="<?php echo IMAGE_DISPLAY_PATH.$list['image'] ?>"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="javascript:void(0)">
                                                        <?php echo $list['name'] ?>
                                                    </a></h4>
                                                    <h6>Qty : <?php echo $list['qty'] ?></h6>
                                                    <span>Rs. <?php echo $list['qty']*$list['price'] ?></span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key ?>')"><i class="ion ion-close close-btn"></i></a>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="shopping-cart-total">
                                            <h4>Total : <span class="shop-total">Rs. <?php echo $totalPrice; ?></span></h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                            <a href="" onclick="cart_checkout('cart')">view cart</a>
                                            <a href="" onclick="cart_checkout('checkout')">checkout</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-bottom transparent-bar black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li><a href="shop">Shop</a></li>
                                        <li><a href="about_us">About Us</a></li>
                                        <li><a href="contact_us">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mobile-menu">
                                <nav id="mobile-menu-active">
                                    <ul class="menu-overflow" id="nav">
                                        <li><a href="shop">Shop</a></li>
                                        <li><a href="about_us">About Us</a></li>
                                        <li><a href="contact_us">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        
    </body>
</html>
