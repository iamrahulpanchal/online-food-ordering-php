<?php 

include("top.inc.php");

$c_name = '';
$c_order = '';
$error_msg = '';
$c_id = '';

if(isset($_GET['c_id']) && ($_GET['c_id']!='')){
        $c_id = get_safe_value($con, $_GET['c_id']);
        $sql = "select * from categories where c_id = '$c_id'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                        $c_name = $row['c_name'];
                        $c_order = $row['c_order'];
                }
        } else {
                redirect('categories.php');
        }
        
}

if(isset($_POST['c_submit'])){
        $c_name = get_safe_value($con, $_POST['c_name']);
        $c_order = get_safe_value($con, $_POST['c_order']);

        if($c_id==''){
                $sql = "select * from categories where c_name = '$c_name'";
        } else {
                // If update happens just for checking if categories already exists.
                $sql = "select * from categories where c_name = '$c_name' and c_id != '$c_id'";
        }
        // echo $sql;
        // die();
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){
                $error_msg = "Category already exists...";
        } else {
                if($c_id!=''){
                        $sql = "update categories set c_name = '$c_name', c_order = '$c_order' where c_id = '$c_id'";
                } else {
                        $c_status = 1;
                        $c_added_on=date('Y-m-d h:i:s');
                        $sql = "insert into categories (c_name, c_order, c_status, c_added_on) values ('$c_name','$c_order','$c_status','$c_added_on')";
                } 
                $res = mysqli_query($con, $sql);
                redirect("categories.php");
        }     
}

?>

<div class="row">
    <?php if(isset($_GET['c_id']) && ($_GET['c_id']!='')) { ?>
        <h1 class="card-title ml-3">Edit Category</h1>
    <?php } else { ?>
        <h1 class="card-title ml-3">Add New Category</h1>
    <?php } ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="c_name">Category Name</label>
                        <input type="text" class="form-control" id="c_name" name="c_name" value="<?php echo $c_name ?>" placeholder="Category Name" required />
                    </div>
                    <div class="form-group">
                        <label for="c_order">Category Order</label>
                        <input type="text" class="form-control" id="c_order" name="c_order" value="<?php echo $c_order ?>" placeholder="Category Order" required />
                    </div>
                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="c_submit">Submit</button>
                    <button class="btn btn-light"><a href="categories.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>