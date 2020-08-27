<?php 

include('top.inc.php');

if($s_website_close==1){
    redirect('shop');
}

$cartArr = getUserFullCart();
if(count($cartArr)>0){

} else {
    redirect('shop');
}

$u_name = '';
$u_email = '';
$u_mobile = '';

$panelNumber = '2.';
$is_show = '';

if(isset($_SESSION['USER_ID'])){
    $panelNumber = '1.';
    $is_show = 'show';
    $uid = $_SESSION['USER_ID'];
    $data = getUserDetailsById($uid);
    $u_name = $data['u_name'];
    $u_email = $data['u_email'];
    $u_mobile = $data['u_mobile'];
}

$is_error = '';

if(isset($_POST['place_order'])){
    if($s_cart_min_price!=''){
        if($totalPrice>=$s_cart_min_price){

        } else {
            $is_error = 'yes';
        }
    }

    if($is_error==''){
        $checkout_name = get_safe_value($con, $_POST['checkout_name']);
        $checkout_email = get_safe_value($con, $_POST['checkout_email']);
        $checkout_mobile = get_safe_value($con, $_POST['checkout_mobile']);
        $checkout_zip = get_safe_value($con, $_POST['checkout_zip']);
        $checkout_address = get_safe_value($con, $_POST['checkout_address']);
        $payment_type = get_safe_value($con, $_POST['payment_type']);
        $om_added_on = date('Y-m-d h:i:s');
    
        if(isset($_SESSION['COUPON_CODE']) && ($_SESSION['FINAL_PRICE'])){
            $coupon_code = get_safe_value($con, $_SESSION['COUPON_CODE']);
            $final_price = get_safe_value($con, $_SESSION['FINAL_PRICE']);
        } else {
            $coupon_code = '';
            $final_price = $totalPrice;
        }
        
        $sql = "insert into order_master (om_u_id, om_u_name, om_u_email, om_u_mobile, om_u_address, om_total_price, om_coupon_code, om_final_price, om_zip, om_payment_status, om_order_status, om_added_on, om_payment_type) values ('".$_SESSION['USER_ID']."','$checkout_name','$checkout_email','$checkout_mobile','$checkout_address','$totalPrice','$coupon_code','$final_price','$checkout_zip','pending','1','$om_added_on', '$payment_type')";
        $res = mysqli_query($con, $sql);
    
        $insert_id = mysqli_insert_id($con);
        $_SESSION['ORDER_ID'] = $insert_id;
    
        foreach($cartArr as $key=>$val){
            $sql = "insert into order_detail (od_o_id, od_dd_id, od_price, od_qty) values ('$insert_id','$key','".$val['price']."','".$val['qty']."') ";
            $res = mysqli_query($con, $sql);
        }
    
        $emailHTML = orderEmail($insert_id, $_SESSION['USER_ID']);
    
        $getUserDetails = getUserDetailsById($_SESSION['USER_ID']);
        $u_email = $getUserDetails['u_email'];
        
        send_email($checkout_email, 'Order Placed Successfully', $emailHTML);

        emptyCart($_SESSION['USER_ID']);
    
        redirect('success');
    }
}

?>

<input type="hidden" id="cart_min_price" value="<?php echo $s_cart_min_price ?>">
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
</div>

<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <?php 
                        if(!isset($_SESSION['USER_ID'])) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-1">Checkout Method</a></h5>
                            </div>
                            <div id="payment-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="checkout-login">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-white">LOGIN</h4>
                                                </div>
                                                <p></p>
                                                <form method="post" id="u_login_form">
                                                    <div class="login-form">
                                                        <label>Email Address * </label>
                                                        <input type="email" name="u_email" placeholder="Email" required />
                                                        <p style="margin-top: 10px;" id="user_not_exist"></p>
                                                    </div>
                                                    <div class="login-form">
                                                        <label>Password *</label>
                                                        <input type="password" name="u_password" placeholder="Password" required />
                                                        <input type="hidden" name="type" value="login" />
                                                        <p style="margin-top: 10px;" id="password_error"></p>
                                                        <p style="margin-top: 10px;" id="email_not_verify"></p>
                                                        <input type="hidden" name="is_checkout" id="is_checkout" value="yes" />
                                                    </div>
                                                    <div class="checkout-login-btn">
                                                        <button type="submit" class="checkout_login" id="login_submit" class="my_btn">Login</button>
                                                        <a href="login_register" style="background-color: #e02c2b;color:#fff;">Register Now</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span><?php echo $panelNumber ?></span> <a data-toggle="collapse" data-parent="#faq" href="#payment-2">Other Information</a></h5>
                            </div>
                            <div id="payment-2" class="panel-collapse collapse <?php echo $is_show ?>">
                                <div class="panel-body">
                                    <form method="post">
                                    <div class="billing-information-wrapper">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>First Name</label>
                                                    <input type="text" name="checkout_name" value="<?php echo $u_name; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Email Address</label>
                                                    <input type="email" name="checkout_email" value="<?php echo $u_email; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Mobile</label>
                                                    <input type="text" name="checkout_mobile" value="<?php echo $u_mobile; ?>" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Zip/Postal Code</label>
                                                    <input type="text" name="checkout_zip" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Address</label>
                                                    <input type="text" name="checkout_address" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Coupon Code</label>
                                                    <div style="display: flex; align-items: center;">
                                                    <input type="text" style="width: 150px;" name="coupon_code" id="coupon_code" />
                                                    <button class="cc_button" type="button" onclick="apply_coupon_code1()" name="apply_coupon" id="apply_coupon_1">Apply</button>
                                                    <p id="coupon_code_msg" class="error_msg coupon_error"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ship-wrapper">
                                            <div class="single-ship">
                                                <input type="radio" name="payment_type" value="cod" checked />
                                                <label>Cash on Delivery (COD)</label>
                                            </div>
                                            <!-- <div class="single-ship">
                                                <input type="radio" name="payment_type" value="paytm" />
                                                <label>Paytm</label>
                                            </div> -->
                                            <?php if($is_error == 'yes') { ?>
                                                <p style="margin-top: 10px; font-size: 18px; color: red; font-weight:500;"><?php echo $s_cart_min_price_msg ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <button type="submit" name="place_order">Place Your Order</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="checkout-progress" style="padding: 20px;">
                    <div class="shopping-cart-content-box">
                        <h4 style="font-size: 20px;">Checkout Progress</h4>
                        <ul style="margin-top: 30px;">
                            <?php foreach($cartArr as $key=>$list){ ?>
                            <li class="single-shopping-cart" id="attr_<?php echo $key ?>" style="display: flex; margin-top: 15px;">
                                <div class="shopping-cart-img">
                                    <a href="javascript:void(0)"><img style="width: 70px;" alt="" src="<?php echo IMAGE_DISPLAY_PATH.$list['image'] ?>"></a>
                                </div>
                                <div class="shopping-cart-title">
                                    <h4><a href="#"><?php echo $list['name']?></a></h4>
                                    <h6>Qty: <?php echo $list['qty']?></h6>
                                    <span>Rs. <?php echo $list['qty']*$list['price'];?></span>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="shopping-cart-total">
                            <h4>Total : <span class="shop-total">Rs. <?php echo $totalPrice?></span></h4>
                        </div>		
                        <div class="shopping-cart-total coupon_price_box">
                            <h4>Coupon Value : <span class="shop-total coupon_code_str"></span></h4>
                        </div>	
                        <div class="shopping-cart-total final_price_box">
                            <h4>Final Price : <span class="shop-total final_price"></span></h4>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
if(isset($_SESSION['COUPON_CODE'])){
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['FINAL_PRICE']);
}
?>

<?php include('footer.inc.php'); ?>