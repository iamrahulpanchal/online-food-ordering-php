<?php 

include("top.inc.php");

$cc_id = '';
$cc_code = '';
$cc_type = '';
$cc_value = '';
$cc_cart_min_value = '';
$cc_expired_on = '';

$error_msg = '';


if(isset($_GET['cc_id']) && ($_GET['cc_id']!='')){
        $cc_id = get_safe_value($con, $_GET['cc_id']);
        $sql = "select * from coupon_code where cc_id = '$cc_id'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                        $cc_code = $row['cc_code'];
                        $cc_type = $row['cc_type'];
                        $cc_value = $row['cc_value'];
                        $cc_cart_min_value = $row['cc_cart_min_value'];
                        $cc_expired_on = $row['cc_expired_on'];
                }
        } else {
                redirect('coupons.php');
        }
        
}

if(isset($_POST['cc_submit'])){
        $cc_code = get_safe_value($con, $_POST['cc_code']);
        $cc_type = get_safe_value($con, $_POST['cc_type']);
        $cc_value = get_safe_value($con, $_POST['cc_value']);
        $cc_cart_min_value = get_safe_value($con, $_POST['cc_cart_min_value']);
        $cc_expired_on = get_safe_value($con, $_POST['cc_expired_on']);

        if($cc_id==''){
                $sql = "select * from coupon_code where cc_code = '$cc_code'";
        } else {
                // If update happens just for checking if it already exists.
                $sql = "select * from coupon_code where cc_code = '$cc_code' and cc_id != '$cc_id'";
        }
        // echo $sql;
        // die();
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){
                $error_msg = "Coupon code already exists...";
        } else {
                if($cc_id!=''){
                        $sql = "update coupon_code set cc_code = '$cc_code', cc_type = '$cc_type', cc_value = '$cc_value', cc_cart_min_value = '$cc_cart_min_value', cc_expired_on = '$cc_expired_on' where cc_id = '$cc_id'";
                } else {
                        $cc_status = 1;
                        $cc_added_on = date('d-m-y h:i:s');
                        $sql = "insert into coupon_code (cc_code, cc_type, cc_value, cc_cart_min_value, cc_expired_on, cc_status, cc_added_on) values ('$cc_code','$cc_type','$cc_value','$cc_cart_min_value','$cc_expired_on','$cc_status','$cc_added_on')";
                } 
                $res = mysqli_query($con, $sql);
                redirect("coupons.php");
        }     
}

?>

<div class="row">
    <?php if(isset($_GET['cc_id']) && ($_GET['cc_id']!='')) { ?>
        <h1 class="card-title ml-3">Edit Coupon</h1>
    <?php } else { ?>
        <h1 class="card-title ml-3">Add New Coupon</h1>
    <?php } ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="cc_code">Coupon Code</label>
                        <input type="text" class="form-control" id="cc_code" name="cc_code" value="<?php echo $cc_code ?>" placeholder="Coupon Code" required />
                    </div>
                    <div class="form-group">
                        <label for="cc_type">Coupon Type</label><br />
                        <select id="cc_type" name="cc_type" required>
                                <option value="">Select Coupon Type</option>
                                <?php 
                                        $arr = array('P'=>'Percentage','F'=>'Fixed');
                                        foreach($arr as $key=>$val){
                                                if($key == $cc_type){
                                                        echo "<option value = ".$key." selected>".$val."</option>";
                                                } else {
                                                        echo "<option value = ".$key.">".$val."</option>";
                                                }
                                        }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cc_value">Coupon Value</label>
                        <input type="text" class="form-control" id="cc_value" name="cc_value" value="<?php echo $cc_value ?>" placeholder="Coupon Value" required />
                    </div>
                    <div class="form-group">
                        <label for="cc_cart_min_value">Cart Min Value</label>
                        <input type="text" class="form-control" id="cc_cart_min_value" name="cc_cart_min_value" value="<?php echo $cc_cart_min_value ?>" placeholder="Cart Min Value" required />
                    </div>
                    <div class="form-group">
                        <label for="cc_expired_on">Expired On</label>
                        <input type="date" class="form-control" id="cc_expired_on" name="cc_expired_on" value="<?php echo $cc_expired_on ?>" placeholder="Expired On" />
                    </div>
                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="cc_submit">Submit</button>
                    <button class="btn btn-light"><a href="categories.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>