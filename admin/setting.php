<?php 

include("top.inc.php");

$error_msg = '';

if(isset($_POST['s_submit'])){
        $s_cart_min_price = get_safe_value($con, $_POST['s_cart_min_price']);
        $s_cart_min_price_msg = get_safe_value($con, $_POST['s_cart_min_price_msg']);
        $s_website_close = get_safe_value($con, $_POST['s_website_close']);
        $s_website_close_msg = get_safe_value($con, $_POST['s_website_close_msg']);

        $sql = "update setting set s_cart_min_price = '$s_cart_min_price', s_cart_min_price_msg = '$s_cart_min_price_msg', s_website_close = '$s_website_close', s_website_close_msg = '$s_website_close_msg' where s_id = '1'";
        $res = mysqli_query($con, $sql);
}

$sql = "select * from setting where s_id = '1'";
$res = mysqli_query($con, $sql);
$row= mysqli_fetch_assoc($res);
$s_cart_min_price = $row['s_cart_min_price'];
$s_cart_min_price_msg = $row['s_cart_min_price_msg'];
$s_website_close = $row['s_website_close'];
$s_website_close_msg = $row['s_website_close_msg'];

$websiteCloseArr = array('No','Yes');

?>

<div class="row">
    <h1 class="card-title ml-3">Website Settings</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="s_cart_min_price">Cart Min Price</label>
                        <input type="text" class="form-control" id="s_cart_min_price" name="s_cart_min_price" value="<?php echo $s_cart_min_price ?>" placeholder="Cart Min Price" required />
                    </div>
                    <div class="form-group">
                        <label for="s_cart_min_price_msg">Cart Min Price Msg</label>
                        <input type="text" class="form-control" id="s_cart_min_price_msg" name="s_cart_min_price_msg" value="<?php echo $s_cart_min_price_msg ?>" placeholder="Cart Min Price Msg" required />
                    </div>
                    <div class="form-group">
                        <label for="s_website_close">Website Close</label>
                        <select class="form-control" name="s_website_close">
                            <option value="">Select Option</option>
                            <?php foreach($websiteCloseArr as $key=>$val) {
                                if($s_website_close == $key){
                                    echo "<option value='$key' selected>$val</option>";
                                } else {
                                    echo "<option value='$key'>$val</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="s_website_close_msg">Website Close Msg</label>
                        <input type="text" class="form-control" id="s_website_close_msg" name="s_website_close_msg" value="<?php echo $s_website_close_msg ?>" placeholder="Website Close Msg" required />
                    </div>
                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="s_submit">Submit</button>
                    <button class="btn btn-light"><a href="categories.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>