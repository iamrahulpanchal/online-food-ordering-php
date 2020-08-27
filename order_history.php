<?php
include ("top.inc.php");
if(!isset($_SESSION['USER_ID'])){
	redirect('shop');
}
$uid = $_SESSION['USER_ID'];
$sql= "select order_master.*, order_status.* from order_master, order_status where order_master.om_order_status = order_status.os_id and order_master.om_u_id = '$uid' order by order_master.om_id desc";
$res=mysqli_query($con,$sql);

if(isset($_GET['om_cancel_id'])){
    $om_cancel_id = get_safe_value($con, $_GET['om_cancel_id']) ;
    $om_cancel_at = date('Y-m-d h:i:s');
    $sql1 = "update order_master set om_order_status='5', om_cancel_by='user', om_cancel_at='$om_cancel_at' where om_id='$om_cancel_id' and om_order_status='1' and om_u_id='$uid'";
    // prx($sql1);
    $res1 = mysqli_query($con, $sql1);
    redirect('order_history');
}

?>

<div class="cart-main-area pt-95 pb-100">
            <div class="container">
                <h3 class="page-title">Order History</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form method="post">
							<div class="table-content table-responsive">
								
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Price</th>
                                            <th>Address</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php if(mysqli_num_rows($res)>0){
										$i=1;
										while($row=mysqli_fetch_assoc($res)){
										?>
										<tr>
                                            <td>
                                                <a href="order_detail.php?om_id=<?php echo $row['om_id']; ?>" style="color: blue;"><?php echo $row['om_id'] ?></a><br>
                                                <a href="download_invoice?o_id=<?php echo $row['om_id']; ?>" style="color: red;">Invoice</a>
                                            </td>
                                            <td>Rs. <?php echo $row['om_final_price'] ?></td>
                                            <td><?php echo $row['om_u_address'] ?></td>
											<td id="pay_status" class="pay_status_<?php echo $row['om_payment_status'] ?>"><?php echo $row['om_payment_status'] ?></td>
                                            <td>
                                                <?php echo $row['os_status'] ?>
                                                <?php
                                                if($row['om_order_status']==1){
                                                    echo "<br><a style='color: blue;' href='?om_cancel_id=".$row['om_id']."'>Cancel Order</a>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
										<?php }} ?>
                                    </tbody>
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