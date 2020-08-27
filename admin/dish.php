<?php

include("top.inc.php"); 

if(isset($_GET['d_id']) && ($_GET['d_id']!='')){
        $d_id = get_safe_value($con, $_GET['d_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $d_status = 1;
                if($type=='deactive'){
                        $d_status = 0;
                }
                $sql = "update dish set d_status = '$d_status' where d_id = '$d_id'";
                $res = mysqli_query($con, $sql);
                redirect('dish.php');
        }

        if($type=='delete'){
                $sql = "delete from dish where d_id = '$d_id'";
                $res = mysqli_query($con, $sql);
                redirect('dish.php');
        }
}

$sql = "select dish.*, categories.c_name from dish, categories where dish.d_c_id = categories.c_id order by dish.d_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Dish Master</h4>
        <a href="manage_dish.php"><h5 class="manage-text">Add New Dish</h5></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Dish</th>
                                <th>Image</th>
                                <th>Type</th>
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
                                <td><?php echo $row['c_name'] ?></td>
                                <td><?php echo $row['d_dish'] ?></td>
                                <td><a target="_blank" href="<?php echo IMAGE_DISPLAY_PATH.$row['d_image'] ?>"><img src="<?php echo IMAGE_DISPLAY_PATH.$row['d_image'] ?>" /></a></td>
                                <td><?php echo strtoupper($row['d_type']) ?></td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['d_added_on']);
                                                echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>   
                                        <?php 
                                        if($row['d_status']==1){
                                                ?>
                                                <a href="?type=deactive&d_id=<?php echo $row['d_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&d_id=<?php echo $row['d_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
                                        <a href="manage_dish.php?d_id=<?php echo $row['d_id'] ?>"><label class="badge badge-success">Edit</label></a>&nbsp;
                                        <a href="?type=delete&d_id=<?php echo $row['d_id']; ?>"><label class="badge badge-danger delete_red">Delete</label></a>
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