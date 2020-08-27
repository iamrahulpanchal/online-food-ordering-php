<?php

session_start();

require('include/connection.inc.php');
require('include/functions.inc.php');

$arr = array();

$coupon_code = get_safe_value($con, $_POST['coupon_code']);

$sql = "select * from coupon_code where cc_code='$coupon_code' and cc_status=1";
$res = mysqli_query($con, $sql);
$check = mysqli_num_rows($res);

$cartArr = getUserFullCart();

if($check>0){
    $row = mysqli_fetch_assoc($res);
    $cart_min_value = $row['cc_cart_min_value'];
    $coupon_type = $row['cc_type'];
    $coupon_code = $row['cc_code'];
    $coupon_value = $row['cc_value'];
    $expired_on = strtotime($row['cc_expired_on']);
    $curr_time = strtotime(date('Y-m-d'));

    $totalPrice=0;
    foreach($cartArr as $list){
        $totalPrice = $totalPrice + ($list['qty']*$list['price']);
    }

    if($totalPrice>$cart_min_value){
        if($curr_time > $expired_on){
            $arr = array('status'=>'expired','msg'=>'Coupon Code is Expired... ');
        } else {
            $coupon_code_apply = 0;
            if($coupon_type=='F'){
                $cart_value = $totalPrice - $coupon_value;
            }
            if($coupon_type=='P'){
                $coupon_value = ($coupon_value/100) * $totalPrice;
                $cart_value = $totalPrice - $coupon_value;
            }
            $_SESSION['COUPON_CODE']=$coupon_code;
            $_SESSION['FINAL_PRICE']=$cart_value;
            
            $arr = array('status'=>'success','msg'=>'Coupon Code Applied!', 'coupon_code'=>$coupon_code, 'coupon_value'=>$coupon_value,'cart_value'=>$cart_value);
        }
    } else {
        $arr = array('status'=>'min_value','msg'=>'Min Cart Value should be Rs. '.$cart_min_value);
    } 
} else {
    $arr = array('status'=>'error','msg'=>'Invalid Coupon Code');
}

echo json_encode($arr);

?>