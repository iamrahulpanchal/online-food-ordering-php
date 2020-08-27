<?php

include("top.inc.php"); 

if(isset($_GET['b_id']) && ($_GET['b_id']!='')){
        $b_id = get_safe_value($con, $_GET['b_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='active' || $type=='deactive'){
                $b_status = 1;
                if($type=='deactive'){
                        $b_status = 0;
                }
                $sql = "update banner set b_status = '$b_status' where b_id = '$b_id'";
                $res = mysqli_query($con, $sql);
                redirect('banner.php');
        }

        if($type=='delete'){
                $sql = "delete from banner where b_id = '$b_id'";
                $res = mysqli_query($con, $sql);
                redirect('banner.php');
        }
}

$sql = "select *  from banner";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Banner Master</h4>
        <a href="manage_banner.php"><h5 class="manage-text">Add New Banner</h5></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Heading</th>
                                <th>Subheading</th>
                                <th>Link</th>
                                <th>Link Text</th>
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
                                <td><a target="_blank" href="<?php echo BANNER_IMG_DISPLAY_PATH.$row['b_image'] ?>"><img class="banner_img" src="<?php echo BANNER_IMG_DISPLAY_PATH.$row['b_image'] ?>" /></a></td>
                                <td><?php echo $row['b_heading'] ?></td>
                                <td><?php echo $row['b_sub_heading'] ?></td> 
                                <td><?php echo $row['b_link'] ?></td>
                                <td><?php echo $row['b_link_text'] ?></td>
                                <td>   
                                        <?php 
                                        if($row['b_status']==1){
                                                ?>
                                                <a href="?type=deactive&b_id=<?php echo $row['b_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&b_id=<?php echo $row['b_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
                                        <a href="manage_banner.php?b_id=<?php echo $row['b_id'] ?>"><label class="badge badge-success">Edit</label></a>&nbsp;
                                        <a href="?type=delete&b_id=<?php echo $row['b_id']; ?>"><label class="badge badge-danger delete_red">Delete</label></a>
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