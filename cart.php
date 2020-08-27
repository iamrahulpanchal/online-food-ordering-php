<?php 

include('top.inc.php');

if($s_website_close==1){
    redirect('shop');
}


?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Cart</li>
            </ul>
        </div>
    </div>
</div>

<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <?php
        $cartArr = getUserFullCart();
        if(count($cartArr)>0) {
        ?>
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="" method="post">
                    <div class="table-content table-responsive">
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Until Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // prx($cartArr);
                                foreach($cartArr as $key=>$list) {
                                ?>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img style="width: 100%;" src="<?php echo IMAGE_DISPLAY_PATH.$list['image'] ?>" alt="" /></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#"><?php echo $list['name'] ?></a></td>
                                    <td class="product-price-cart"><span class="amount">Rs. <?php echo $list['price'] ?></span></td>
                                    <td class="product-quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="qty[<?php echo $key ?>][]" value="<?php echo $list['qty'] ?>" />
                                        </div>
                                    </td>
                                    <td class="product-subtotal">Rs. <?php echo $list['qty']*$list['price'] ?></td>
                                    <td class="product-remove">
                                        <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key ?>','load')"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="shop">Continue Shopping</a>
                                </div>
                                <div class="cart-clear">
                                    <button name="update_cart">Update Shopping Cart</button>
                                    <a href="checkout">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else {
        echo "No Items in the Cart...";
    } ?>
    </div>
</div>


<?php include('footer.inc.php'); ?>