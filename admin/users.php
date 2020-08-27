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

$sql = "select * from users order by u_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Users Master</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
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
                                <td><?php echo $row['u_name'] ?></td>
                                <td><?php echo $row['u_email'] ?></td>
                                <td><?php echo $row['u_mobile'] ?></td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['u_added_on']);
                                                echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>   
                                        <?php 
                                        if($row['u_status']==1){
                                                ?>
                                                <a href="?type=deactive&u_id=<?php echo $row['u_id']; ?>"><label class="badge badge-info">Active</label></a>&nbsp;
                                                <?php
                                        } else {
                                                ?>
                                                <a href="?type=active&u_id=<?php echo $row['u_id']; ?>"><label class="badge badge-danger">Deactive</label></a>&nbsp;
                                                <?php
                                        }
                                        ?>
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