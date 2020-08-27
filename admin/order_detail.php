<?php 
include('top.inc.php');
if(isset($_GET['om_id']) && $_GET['om_id']>0){
    $om_id=get_safe_value($con, $_GET['om_id']);

    $getOrderById = getOrderById($om_id);

    if(isset($_GET['order_status'])){
        $order_status = get_safe_value($con, $_GET['order_status']);
        $sql_cancel='';
        if($order_status=='5'){
            $om_cancel_at =date('Y-m-d h:i:s');
            $sql_cancel = ", om_cancel_by='admin', om_cancel_at='$om_cancel_at'";
        }
        $sql = "update order_master set om_order_status = '$order_status'$sql_cancel where om_id = ".$om_id;
        // prx($sql);
        $res = mysqli_query($con, $sql);
        redirect('order_detail.php?om_id='.$om_id);
    }

    if(isset($_GET['delivery_boy'])){
        $delivery_boy = get_safe_value($con, $_GET['delivery_boy']);
        $sql = "update order_master set om_db_id = '$delivery_boy' where om_id = ".$om_id;
        $res = mysqli_query($con, $sql);
        redirect('order_detail.php?om_id='.$om_id);
    }
    
    $sql = "select order_master.*, order_status.os_status from order_master, order_status where order_master.om_order_status = order_status.os_id and order_master.om_id = '$om_id' order by order_master.om_id desc";
    $res = mysqli_query($con, $sql);

    if(mysqli_num_rows($res)>0){
        $orderRow = mysqli_fetch_assoc($res);
        // prx($orderRow);
    } else {
        redirect('index.php');
    }
} else {
	redirect('index.php');
}
?>

<div class="page-header">
    <h3 class="page-title"> Invoice </h3>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card px-2">
            <div class="card-body">

                <div class="container-fluid">
                    <h3 class="text-right my-5">Order ID : <?php echo $om_id?></h3>
                    <hr>
                </div>

                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 pl-0">
                    <p class="mt-5 mb-2"><b>Food Ordering</b></p>
                    <p>Bhayandar, Maharashtra.</p>
                    </div>
                    <div class="col-lg-3 pr-0">
                    <p class="mt-5 mb-2 text-right"><b>Invoice to</b></p>
                    <p class="text-right">
                        <?php  echo $orderRow['om_u_name']?><br/>
                        <?php  echo $orderRow['om_u_address']?><br/>
                        <?php  echo $orderRow['om_zip']?><br/>
                        Delhi
                    </p>
                    </div>
                </div>

                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 pl-0">
                    <p class="mb-0 mt-5">Order Date : <?php  echo dateFormat($orderRow['om_added_on']) ?></p>
                    </div>
                </div>

                <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                    <div class="table-responsive w-100">
                    <table class="table">
                        <thead>
                        <tr class="bg-dark">
                            <th>#</th>
                            <th>Dish</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Unit Cost</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $getOrderDetails=getOrderDetails($om_id);
                        // prx($getOrderDetails);
                        $pp=0;
                        $i=1;
                        foreach($getOrderDetails as $list){
                        $pp=$pp+($list['od_price']*$list['od_qty']);	
                        ?>
                        
                        <tr class="text-right">
                            <td class="text-left"><?php echo $i?></td>
                            <td class="text-left"><?php echo $list['d_dish']?> (<?php echo $list['dd_attribute']?>)</td>
                            <td><?php echo $list['od_qty']?></td>
                            <td>Rs. <?php echo $list['od_price']?></td>
                            <td>Rs. <?php echo $list['od_price']*$list['od_qty']?></td>
                        </tr>
                        <?php 
                        $i++;
                        } ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="container-fluid mt-5 w-100">
                    <h5 class="text-right mb-5">Total : Rs.<?php echo $pp?></h5>
                    <?php if($getOrderById[0]['om_coupon_code']!=''){ ?>
                    <h5 class="text-right mb-5">Coupon Code : <?php echo $getOrderById[0]['om_coupon_code']; ?></h5>
                    <h5 class="text-right mb-5">Final Price : Rs. <?php echo $getOrderById[0]['om_final_price']; ?></h5>
                    <?php } ?>
                    <hr>
                </div>

                <div class="container-fluid w-100" style="text-align: right;">
                    <a href="../download_invoice.php?o_id=<?php echo $om_id?>" class="btn btn-primary mt-2"><i class="mdi mdi-printer mr-1"></i>PDF</a>
                </div>
                
                <?php
                $orderStatusRes=mysqli_query($con,"select * from order_status order by os_status");
                $orderDeliveryBoyRes=mysqli_query($con,"select * from delivery_boy where db_status=1 order by db_name");
                ?>
                <div class="mt-4">
                    <?php
                        // prx($orderRow);
                        echo "<h5>Order Status : ".$orderRow['os_status']."</h5>";
                    ?>
                    <select class="form-control" name="order_status" id="order_status" onchange="updateOrderStatus()">
                        <option val=''>Update Order Status</option>
                        <?php 
                        while($orderStatusRow=mysqli_fetch_assoc($orderStatusRes)){
                            echo "<option value=".$orderStatusRow['os_id'].">".$orderStatusRow['os_status']."</option>";
                        }
                        ?>
                    </select>

                    <br/>

                    <?php
                        // prx($orderRow);
                        if($orderRow['om_db_id']==0){
                            echo "<h5>Delivery Boy : Not Assigned</hr>";
                        } else {
                            echo "<h5>Delivery Boy : ".getDeliveryBoy($orderRow['om_db_id'])."</h5>";
                        }
                        
                    ?>
                    <select class="form-control" name="delivery_boy" id="delivery_boy" onchange="updateDeliveryBoy()">
                        <option val=''>Assign Delivery Boy</option>
                        <?php 
                        while($orderDeliveryBoyRow=mysqli_fetch_assoc($orderDeliveryBoyRes)){
                            echo "<option value=".$orderDeliveryBoyRow['db_id'].">".$orderDeliveryBoyRow['db_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                
            </div>
        </div>
    </div>     
</div>

<script>
function updateOrderStatus(){
	var order_status=jQuery('#order_status').val();
	if(order_status!=''){
		var oid="<?php echo $om_id?>";
		window.location.href='order_detail.php?om_id='+oid+'&order_status='+order_status;
	}
}

function updateDeliveryBoy(){
    var delivery_boy=jQuery('#delivery_boy').val();
	if(delivery_boy!=''){
		var oid="<?php echo $om_id?>";
		window.location.href='order_detail.php?om_id='+oid+'&delivery_boy='+delivery_boy;
	}
}
</script>	

<?php include('footer.inc.php');?>