<?php

include("top.inc.php"); 

if(isset($_GET['db_id']) && ($_GET['db_id']!='')){
        $db_id = get_safe_value($con, $_GET['db_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $db_status = 1;
                if($type=='deactive'){
                        $db_status = 0;
                }
                $sql = "update delivery_boy set db_status = '$db_status' where db_id = '$db_id'";
                $res = mysqli_query($con, $sql);
                redirect('delivery_boy.php');
        }
}

$sql = "select * from delivery_boy order by db_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Delivery Boy Master</h4>
        <a href="manage_delivery_boy.php"><h5 class="manage-text">Add New Delivery Boy</h5></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile</th>
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
                                <td><?php echo $row['db_name'] ?></td>
                                <td><?php echo $row['db_mobile'] ?></td>
                                <td>
                                        <?php 
                                                echo $row['db_added_on']; 
                                                // $dateStr = strtotime($row['db_added_on']);
                                                // echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>   
                                        <?php 
                                        if($row['db_status']==1){
                                                ?>
                                                <a href="?type=deactive&db_id=<?php echo $row['db_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&db_id=<?php echo $row['db_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
                                        <a href="manage_delivery_boy.php?db_id=<?php echo $row['db_id'] ?>"><label class="badge badge-success">Edit</label></a>&nbsp;
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