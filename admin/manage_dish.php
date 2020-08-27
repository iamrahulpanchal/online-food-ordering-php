<?php 

include("top.inc.php");

// echo IMAGE_DISPLAY_PATH;
// die();
// prx($_SERVER);

$d_id = '';
$d_c_id = '';
$d_dish = '';
$d_dish_detail = '';
$d_image = '';
$d_type = '';
$img_required = 'required';
$error_msg = '';



if(isset($_GET['d_id']) && ($_GET['d_id']!='')){
        $img_required = '';
        $d_id = get_safe_value($con, $_GET['d_id']);
        $sql = "select * from dish where d_id = '$d_id'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                        $d_c_id = $row['d_c_id'];
                        $d_dish = $row['d_dish'];
                        $d_dish_detail = $row['d_dish_detail'];
                        $d_image = $row['d_image'];
                        $d_type = $row['d_type'];
                }
        } else {
                redirect('dish.php');
        }
        
}

if(isset($_GET['dd_id']) && ($_GET['dd_id']!='')){
        $dd_id = get_safe_value($con, $_GET['dd_id']);
        $sql = "delete from dish_details where dd_id = '$dd_id'";
        $res = mysqli_query($con, $sql);
        redirect('manage_dish.php?d_id='.$d_id);
}

if(isset($_POST['d_submit'])){
        // prx($_POST);

        $d_c_id = get_safe_value($con, $_POST['d_c_id']);
        $d_dish = get_safe_value($con, $_POST['d_dish']);
        $d_dish_detail = get_safe_value($con, $_POST['d_dish_detail']);
        $d_type = get_safe_value($con, $_POST['d_type']);
        $d_added_on=date('Y-m-d h:i:s');
        
        if($d_id==''){
                $sql = "select * from dish where d_dish = '$d_dish'";
        } else {
                // If update happens just for checking if it already exists.
                $sql = "select * from dish where d_dish = '$d_dish' and d_id != '$d_id'";
        }

        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){
                $error_msg = "Dish already exists...";
        } else {
                $type = $_FILES['d_image']['type'];
                if($d_id==''){
                    if($type!='image/jpeg' && $type!='image/png'){
                        $error_msg="Invalid image format";
                    }else{
                        $d_image = rand(111111111,999999999).'_'.$_FILES['d_image']['name'];
                        move_uploaded_file($_FILES['d_image']['tmp_name'],IMAGE_UPLOAD_PATH.$d_image);
                        $sql = "insert into dish(d_c_id, d_dish, d_dish_detail, d_status, d_added_on, d_image, d_type) values ('$d_c_id','$d_dish','$d_dish_detail','1','$d_added_on', '$d_image','$d_type')";
                        $res = mysqli_query($con, $sql);
                        $recent_d_id=mysqli_insert_id($con);
                                        
                        $attributeArr=$_POST['dd_attribute'];
                        $priceArr=$_POST['dd_price'];
                        $statusArr = $_POST['dd_status'];
                        
                        foreach($attributeArr as $key=>$val){
                            $dd_attribute=$val;
                            $dd_price=$priceArr[$key];
                            $dd_status = $statusArr[$key];
                            $dd_added_on=date('Y-m-d h:i:s');
                            mysqli_query($con,"insert into dish_details(dd_d_id,dd_attribute,dd_price,dd_status,dd_added_on) values('$recent_d_id','$dd_attribute','$dd_price','$dd_status','$dd_added_on')");
                        }
                        redirect('dish.php');
                    }
                } else {
                        $image_condition = '';
                        if($_FILES['d_image']['name']!=''){
                            if($type!='image/jpeg' && $type!='image/png'){
                                $error_msg="Invalid image format";
                            }else{
                                $d_image=rand(111111111,999999999).'_'.$_FILES['d_image']['name'];
                                move_uploaded_file($_FILES['d_image']['tmp_name'],IMAGE_UPLOAD_PATH.$d_image);
                                $image_condition=", d_image='$d_image'";
                                $oldImageRow=mysqli_fetch_assoc(mysqli_query($con,"select d_image from dish where d_id='$d_id'"));
                                $oldImage=$oldImageRow['d_image'];
                                unlink(IMAGE_UPLOAD_PATH.$oldImage);
                            }
                        }
                        if($error_msg==''){
                                $sql = "update dish set d_c_id = '$d_c_id', d_dish = '$d_dish', d_dish_detail = '$d_dish_detail', d_type = '$d_type' $image_condition where d_id = '$d_id'";
                                mysqli_query($con, $sql);

                                $attributeArr = $_POST['dd_attribute'];
                                $priceArr = $_POST['dd_price'];
                                $statusArr = $_POST['dd_status'];
                                $ddIdArr = $_POST['dd_id'];

                                foreach($attributeArr as $key=>$val){
                                        $dd_attribute = $val;
                                        $dd_price = $priceArr[$key];
                                        $dd_status = $statusArr[$key];
                                        $dd_added_on=date('Y-m-d h:i:s');

                                        if(isset($ddIdArr[$key])){
                                                $ddid = $ddIdArr[$key];
                                                $sql = "update dish_details set dd_attribute='$dd_attribute',dd_price='$dd_price', dd_status='$dd_status' where dd_id = '$ddid'";
                                                mysqli_query($con, $sql);
                                        } else {
                                                echo $sql = "insert into dish_details(dd_d_id,dd_attribute,dd_price,dd_status,dd_added_on) values('$d_id','$dd_attribute','$dd_price','$dd_status','$dd_added_on')";
                                                mysqli_query($con, $sql);
                                        }
                                }
                                redirect('dish.php');
                        }
                }
        } 
}

?>

<div class="row">
    <?php if(isset($_GET['d_id']) && ($_GET['d_id']!='')) { ?>
        <h1 class="card-title ml-3">Edit Dish</h1>
    <?php } else { ?>
        <h1 class="card-title ml-3">Add New Dish</h1>
    <?php } ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="d_c_id">Category</label>
                        <select name="d_c_id" id="d_c_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                        $sql = "select * from categories where c_status = 1";
                                        $res = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_assoc($res)) {
                                                if($row['c_id']==$d_c_id){
                                                        echo "<option value=".$row['c_id']." selected>".$row['c_name']."</option>";
                                                } else {
                                                        echo "<option value=".$row['c_id'].">".$row['c_name']."</option>";
                                                }
                                        }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="d_dish">Dish</label>
                        <input type="text" class="form-control" id="d_dish" name="d_dish" value="<?php echo $d_dish ?>" placeholder="Dish" required />
                    </div>
                    <div class="form-group">
                        <label for="d_type">Type</label>
                        <select name="d_type" id="d_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <?php
                                    $arrType = array("veg","non-veg");
                                    foreach($arrType as $list){
                                        if($list==$d_type){
                                            echo "<option value='$list' selected>".strtoupper($list)."</option>";
                                        } else {
                                            echo "<option value='$list'>".strtoupper($list)."</option>";
                                        }
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="d_dish_detail">Dish Detail</label>
                        <textarea class="form-control" id="d_dish_detail" name="d_dish_detail" placeholder="Dish Detail" required><?php echo $d_dish_detail ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="d_image">Image</label>
                        <input type="file" class="form-control" id="d_image" name="d_image" placeholder="Image" <?php echo $img_required; ?> />
                    </div>
                    
                    <div class="form-group" id="dd_box">
                        <label>Dish Attributes</label>
                        <?php if($d_id==0) { ?>
                        <div class="row">
                                <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Attribute" name="dd_attribute[]" required>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control" placeholder="Price" name="dd_price[]" required>
                                </div>
                                <div class="col-3">
                                        <select style="color: black;" class="form-control"  required name="dd_status[]">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                </div>
                        </div>
                        <?php } else { 
                                  $sql = "select * from dish_details where dd_d_id = '$d_id'";
                                  $dd_res = mysqli_query($con, $sql);
                                  $i=1;
                                  while($dd_row = mysqli_fetch_assoc($dd_res)) {
                        ?>
                        <div class="row mt-2">
                                <div class="col-4">
                                        <input type="hidden" name="dd_id[]" value="<?php echo $dd_row['dd_id'] ?>">
                                        <input type="text" class="form-control" placeholder="Attribute" name="dd_attribute[]" required value="<?php echo $dd_row['dd_attribute'] ?>">
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control" placeholder="Price" name="dd_price[]" required value="<?php echo $dd_row['dd_price'] ?>">
                                </div>
                                <div class="col-3">
                                    <select style="color: black;" class="form-control" required name="dd_status[]">
                                        <option value="">Select Status</option>
                                        <?php
                                        if($dd_row['dd_status']==1){
                                        ?>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Deactive</option>
                                        <?php } else {
                                            ?>
                                            <option value="1">Active</option>
                                            <option value="0" selected>Deactive</option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                                <?php if($i != 1) { ?>
                                        <div class="col-2 remove_attr_btn"><button type="button" class="btn badge badge-success mr-2" onclick="remove_attr_new('<?php echo $dd_row['dd_id'] ?>')">Remove</button></div>
                                <?php } ?>
                        </div>
                        <?php $i++; } } ?>
                    </div>

                    <button type="button" class="btn badge badge-danger mr-2" onclick="add_more_attr()">Add More Attributes</button>

                    <!-- For removing div -->
                    <input type="hidden" id="add_more" value="1" />

                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="d_submit">Submit</button>
                    <button class="btn btn-light"><a href="delivery_boy.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>