<?php

include("top.inc.php"); 

if(isset($_GET['c_id']) && ($_GET['c_id']!='')){
        $c_id = get_safe_value($con, $_GET['c_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $c_status = 1;
                if($type=='deactive'){
                        $c_status = 0;
                }
                $sql = "update categories set c_status = '$c_status' where c_id = '$c_id'";
                $res = mysqli_query($con, $sql);
                redirect('categories.php');
        }

        if($type=='delete'){
                $sql = "delete from categories where c_id = '$c_id'";
                $res = mysqli_query($con, $sql);
                redirect('categories.php');
        }

}

$sql = "select * from categories order by c_order";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Categories Master</h4>
        <a href="manage_categories.php"><h5 class="manage-text">Add New Categories</h5></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Order</th>
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
                                <td><?php echo $row['c_order'] ?></td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['c_added_on']);
                                                echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>
                                        
                                        <?php 
                                        if($row['c_status']==1){
                                                ?>
                                                <a href="?type=deactive&c_id=<?php echo $row['c_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&c_id=<?php echo $row['c_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
                                        <a href="manage_categories.php?c_id=<?php echo $row['c_id'] ?>"><label class="badge badge-success">Edit</label></a>&nbsp;
                                        <a href="?type=delete&c_id=<?php echo $row['c_id']; ?>"><label class="badge badge-danger delete_red">Delete</label></a>
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