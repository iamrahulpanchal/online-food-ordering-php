<?php 

include("top.inc.php");

$db_name = '';
$db_mobile = '';
$db_password = '';
$error_msg = '';
$db_id = '';

if(isset($_GET['db_id']) && ($_GET['db_id']!='')){
        $db_id = get_safe_value($con, $_GET['db_id']);
        $sql = "select * from delivery_boy where db_id = '$db_id'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                        $db_name = $row['db_name'];
                        $db_mobile = $row['db_mobile'];
                        $db_password = $row['db_password'];
                }
        } else {
                redirect('delivery_boy.php');
        }
        
}

if(isset($_POST['db_submit'])){
        $db_name = get_safe_value($con, $_POST['db_name']);
        $db_mobile = get_safe_value($con, $_POST['db_mobile']);
        $db_password = get_safe_value($con, $_POST['db_password']);

        if($db_id==''){
                $sql = "select * from delivery_boy where db_mobile = '$db_mobile'";
        } else {
                // If update happens just for checking if it already exists.
                $sql = "select * from delivery_boy where db_mobile = '$db_mobile' and db_id != '$db_id'";
        }

        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){
                $error_msg = "Delivery boy already exists...";
        } else {
                if($db_id!=''){
                        $sql = "update delivery_boy set db_name = '$db_name', db_mobile = '$db_mobile', db_password = '$db_password' where db_id = '$db_id'";
                        $res = mysqli_query($con, $sql);
                } else {
                        $db_status = 1;
                        $db_added_on = date('d-m-y h:i:s');
                        // prx($db_added_on);
                        $sql = "insert into delivery_boy (db_name, db_mobile, db_password, db_status, db_added_on) values ('$db_name','$db_mobile','$db_password','$db_status','$db_added_on')";
                        $res = mysqli_query($con, $sql);
                        // prx($sql);
                } 
                redirect("delivery_boy.php");
        }     
}

?>

<div class="row">
    <?php if(isset($_GET['db_id']) && ($_GET['db_id']!='')) { ?>
        <h1 class="card-title ml-3">Edit Delivery Boy Details</h1>
    <?php } else { ?>
        <h1 class="card-title ml-3">Add New Delivery Boy</h1>
    <?php } ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="db_name">Name</label>
                        <input type="text" class="form-control" id="db_name" name="db_name" value="<?php echo $db_name ?>" placeholder="Delivery Boy Name" required />
                    </div>
                    <div class="form-group">
                        <label for="db_mobile">Mobile</label>
                        <input type="text" class="form-control" id="db_mobile" name="db_mobile" value="<?php echo $db_mobile ?>" placeholder="Delivery Boy Mobile" required />
                    </div>
                    <div class="form-group">
                        <label for="db_password">Password</label>
                        <input type="text" class="form-control" id="db_password" name="db_password" value="<?php echo $db_password ?>" placeholder="Delivery Boy Password" required />
                    </div>
                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="db_submit">Submit</button>
                    <button class="btn btn-light"><a href="delivery_boy.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>