<?php

include("top.inc.php"); 

if(isset($_GET['u_id']) && ($_GET['u_id']!='')){
        $u_id = get_safe_value($con, $_GET['u_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $u_status = 1;
                if($type=='deactive'){
                        $u_status = 0;
                }
                $sql = "update users set u_status = '$u_status' where u_id = '$u_id'";
                $res = mysqli_query($con, $sql);
                redirect('users.php');
        }
}

$sql = "select order_master.*, order_status.os_status from order_master, order_status where order_master.om_order_status = order_status.os_id order by order_master.om_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Order Master</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User Details</th>
                                <th>Address</th>
                                <th>Price</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Added On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($res)>0) {
                                while($row = mysqli_fetch_assoc($res)) { 
                            ?>
                            <tr>
                                <td><a href="order_detail.php?om_id=<?php echo $row['om_id'] ?>"><?php echo $row['om_id'] ?></a></td>
                                <td>
                                    <p>Name : <?php echo $row['om_u_name'] ?></p>
                                    <p>Email : <?php echo $row['om_u_email'] ?></p>
                                    Mobile : <?php echo $row['om_u_mobile'] ?>
                                </td>
                                <td>
                                    <p><?php echo $row['om_u_address'] ?></p>
                                    Zip : <?php echo $row['om_zip'] ?>
                                </td>
                                <td>Rs. <?php echo $row['om_final_price'] ?></td>
                                <td id="pay_status" class="pay_status_<?php echo $row['om_payment_status'] ?>"><?php echo $row['om_payment_status'] ?></td>
                                <td><?php echo $row['os_status'] ?></td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['om_added_on']);
                                                echo "<p>".date('d M Y', $dateStr)."</p>";
                                                echo date('h:i', $dateStr);
                                        ?>
                                </td>
                            </tr>
                            <?php }  }  
                                else {
                                        ?>
                                        <td colspan="6" class="text-center">No Records Found</td>
                                        <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.inc.php"); ?>