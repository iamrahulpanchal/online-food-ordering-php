<?php

include("top.inc.php"); 

if(isset($_GET['cc_id']) && ($_GET['cc_id']!='')){
        $cc_id = get_safe_value($con, $_GET['cc_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $cc_status = 1;
                if($type=='deactive'){
                        $cc_status = 0;
                }
                $sql = "update coupon_code set cc_status = '$cc_status' where cc_id = '$cc_id'";
                $res = mysqli_query($con, $sql);
                redirect('coupons.php');
        }

        if($type=='delete'){
                $sql = "delete from coupon_code where cc_id = '$cc_id'";
                $res = mysqli_query($con, $sql);
                redirect('coupons.php');
        }

}

$sql = "select * from coupon_code order by cc_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Coupons Master</h4>
        <a href="manage_coupons.php"><h5 class="manage-text">Add New Coupons</h5></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Cart Min Value</th>
                                <th>Expired On</th>
                                <th>Added On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($res)>0) {
                                $i = 1; 
                                while($row = mysqli_fetch_assoc($res)) { 
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row['cc_code'] ?></td>
                                <td><?php echo $row['cc_type'] ?></td>
                                <td><?php echo $row['cc_value'] ?></td>
                                <td><?php echo $row['cc_cart_min_value'] ?></td>
                                <td>
                                        <?php 
                                        if($row['cc_expired_on']=='0000-00-00'){
                                                echo "NA";
                                        } else {
                                                echo $row['cc_expired_on'];
                                        }
                                        ?>
                                </td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['cc_added_on']);
                                                echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>
                                        
                                        <?php 
                                        if($row['cc_status']==1){
                                                ?>
                                                <a href="?type=deactive&cc_id=<?php echo $row['cc_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&cc_id=<?php echo $row['cc_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
                                        <a href="manage_coupons.php?cc_id=<?php echo $row['cc_id'] ?>"><label class="badge badge-success">Edit</label></a>&nbsp;
                                        <a href="?type=delete&cc_id=<?php echo $row['cc_id']; ?>"><label class="badge badge-danger delete_red">Delete</label></a>
                                </td>
                            </tr>
                            <?php 
                                $i++; }  }  
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