<?php

include("top.inc.php"); 

if(isset($_GET['cu_id']) && ($_GET['cu_id']!='')){
        $cu_id = get_safe_value($con, $_GET['cu_id']);
        $type = get_safe_value($con, $_GET['type']);

        if($type=='delete'){
                $sql = "delete from contact_us where cu_id = '$cu_id'";
                $res = mysqli_query($con, $sql);
                redirect('contact_us.php');
        }

}

$sql = "select * from contact_us order by cu_id desc";
$res = mysqli_query($con, $sql);

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Contact Us Master</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
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
                                <td><?php echo $row['cu_name'] ?></td>
                                <td><?php echo $row['cu_email'] ?></td>
                                <td><?php echo $row['cu_subject'] ?></td>
                                <td><?php echo $row['cu_message'] ?></td>
                                <td>
                                        <?php 
                                                $dateStr = strtotime($row['cu_added_on']);
                                                echo date('d M Y', $dateStr);
                                        ?>
                                </td>
                                <td>
                                    <a href="?type=delete&cu_id=<?php echo $row['cu_id']; ?>"><label class="badge badge-danger delete_red">Delete</label></a>
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