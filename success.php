<?php 

include('top.inc.php');

if(isset($_SESSION['ORDER_ID'])){

} else {
    redirect('shop');
}

if(isset($_SESSION['COUPON_CODE'])){
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['FINAL_PRICE']);
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Success</li>
            </ul>
        </div>
    </div>
</div>
<div class="about-us-area pt-50 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-7 d-flex align-items-center">
                <div class="overview-content-2">
                    <h2>Order Placed <span>Successfully!</span></h2>
                    <h4>Your Order ID : <?php echo $_SESSION['ORDER_ID']; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['ORDER_ID']); ?>

<?php include('footer.inc.php'); ?>