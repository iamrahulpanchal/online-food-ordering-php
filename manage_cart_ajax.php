<?php

session_start();

require('include/connection.inc.php');
require('include/functions.inc.php');

// prx($_POST);

$attr = get_safe_value($con, $_POST['attr']);
$type = get_safe_value($con, $_POST['type']);

if($type=='delete'){
    if(isset($_SESSION['USER_ID'])){
        $sql = "delete from dish_cart where dc_dd_id = '$attr' and dc_u_id = ".$_SESSION['USER_ID'];
        $res = mysqli_query($con, $sql);
    } else {
        unset($_SESSION['cart'][$attr]);
    }
    $totalDish = count(getUserFullCart());
    $getUserFullCart = getUserFullCart();
    $totalPrice=0;
    foreach($getUserFullCart as $list){
        $totalPrice = $totalPrice + ($list['qty']*$list['price']);
    }
    $arr=array('totalCartDish'=>$totalDish, 'totalPriceDish'=>$totalPrice);
    echo json_encode($arr);
}

if($type=='add'){
    $qty = get_safe_value($con, $_POST['qty']);
    if(isset($_SESSION['USER_ID'])){
        $u_id = $_SESSION['USER_ID'];
        manageUserCart($u_id, $qty, $attr);
    } else {
        $_SESSION['cart'][$attr]['qty']=$qty;
    }
    $getUserFullCart = getUserFullCart();
    $totalPrice=0;
    foreach($getUserFullCart as $list){
        $totalPrice = $totalPrice + ($list['qty']*$list['price']);
    }
    $getDishDetail = getDishDetailById($attr);
    $price = $getDishDetail['dd_price'];
    $name = $getDishDetail['d_dish'];
    $image = $getDishDetail['d_image'];
    $totalDish = count(getUserFullCart());
    $arr=array('totalCartDish'=>$totalDish, 'totalPriceDish'=>$totalPrice, 'price'=>$price, 'name'=>$name, 'image'=>$image);
    echo json_encode($arr);
}

?>