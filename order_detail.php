<?php
include ("top.inc.php");
if(!isset($_SESSION['USER_ID'])){
	redirect('shop');
}

if(isset($_GET['om_id']) && ($_GET['om_id']>0)){
    $om_id = get_safe_value($con, $_GET['om_id']);
    $getOrderById = getOrderById($om_id);
    
    if($getOrderById[0]['om_u_id']==$_SESSION['USER_ID']){
        $getOrderDetails = getOrderDetails($om_id);
    } else {
        redirect('shop');
    }
} else {
    redirect('shop');
}

?>

<div class="cart-main-area pt-95 pb-100">
            <div class="container">
                <h3 class="page-title">Order Details</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form method="post">
							<div class="table-content table-responsive">
                            <table>
                                <tr>
                                    <th>Dish</th>
                                    <th>Attribute</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Total Price</th>
                                    <?php if($getOrderById[0]['om_order_status']==4) { ?>
                                        <th>Rating</th>
                                    <?php } ?>
                                </tr>
                                <?php
                                $getOrderDetails=getOrderDetails($om_id);
                                // prx($getOrderDetails);
                                foreach($getOrderDetails as $list){
                                ?>
                                    <tr>
                                        <td><?php echo $list['d_dish']?></td>
                                        <td><?php echo $list['dd_attribute']?></td>
                                        <td>Rs. <?php echo $list['od_price']?></td>
                                        <td><?php echo $list['od_qty']?></td>
                                        <td>Rs. <?php echo $list['od_price']*$list['od_qty']?></td>
                                        <?php if($getOrderById[0]['om_order_status']==4) { ?>
                                            <td id="rating<?php echo $list['od_dd_id'] ?>"><?php echo getRating($list['od_dd_id'], $om_id); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php
include("footer.inc.php");
?>