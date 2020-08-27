<?php 

include('top.inc.php');

$cat_dish = '';
$type_filter_val = '';
$cat_dish_arr = array();
$search_str = '';
if(isset($_GET['cat_dish'])){
    $cat_dish = get_safe_value($con, $_GET['cat_dish']);
    $cat_dish_arr = array_filter(explode(':', $cat_dish));
    // pr($cat_dish_arr);
    $cat_dish_str = implode(",",$cat_dish_arr);
}

if(isset($_GET['type_filter_val'])){
    $type_filter_val = get_safe_value($con, $_GET['type_filter_val']);
}

if(isset($_GET['search_str'])){
    $search_str = get_safe_value($con, $_GET['search_str']);
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Shop</li>
            </ul>
        </div>
    </div>
</div>

<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="banner-area pb-30">
                    <a href="javascript:void(0)"><img alt="" src="assets/img/banner/banner-49.jpg" /></a>
                </div>
                <?php if($s_website_close==1) { ?>
                <p class="website_close"><?php echo $s_website_close_msg ?></p>
                <?php } ?>
                <div class="type_filter">
                    <div class="filter_radio_buttons" style="display: flex; align-items: center; font-size: 16px;">
                    <?php 
                        $arrType = array("veg","non-veg","both");
                        foreach($arrType as $list){
                            $type_radio_selected = '';
                            if($list==$type_filter_val){
                                $type_radio_selected = "checked='checked'";
                            }
                            ?>
                            <input type="radio" <?php echo $type_radio_selected ?> name="d_type_filter" value="<?php echo $list ?>" onclick="setFoodType('<?php echo $list ?>')" />&nbsp;<?php echo strtoupper($list) ?>&nbsp;&nbsp;&nbsp;
                            <?php
                        }
                    ?>
                    </div>
                    <div class="search-box" style="margin-left: auto; display: flex; align-items:center;">
                        <input type="text" id="search" value="<?php echo $search_str; ?>" />
                        <button onclick="setSearch()" class="submit btn-style" style="margin-top: 0; margin-left: 10px;" type="submit">Search</button>
                    </div>
                </div>
                <?php
                    $d_c_id = '0'; 
                    $p_sql = "select * from dish where d_status = 1";
                    if($cat_dish!=''){
                        $p_sql .= " and d_c_id in ($cat_dish_str)";
                    }
                    if($type_filter_val!='' && $type_filter_val!='both'){
                        $p_sql .= " and d_type = '$type_filter_val'";
                    }
                    if($search_str!=''){
                        $p_sql .= " and d_dish like '%$search_str%'";
                    }
                    $p_res = mysqli_query($con, $p_sql);
                    $p_count = mysqli_num_rows($p_res);
                    if($p_count>0) {
                ?>
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <?php while($p_row = mysqli_fetch_assoc($p_res)) {?>
                                <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="javascript:void(0)">
                                                <img src=<?php echo IMAGE_DISPLAY_PATH.$p_row['d_image'] ?> alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h4>
                                                <?php
                                                    if($p_row['d_type']=='veg'){
                                                        echo "<img src='assets/img/icon-img/veg.png' />";
                                                    } else {
                                                        echo "<img src='assets/img/icon-img/non-veg.png' />";
                                                    }
                                                ?>
                                                <a href="javascript:void(0)" class="dish_text"><?php echo $p_row['d_dish'] ?><br><br><?php getRatingByDishId($p_row['d_id']) ?></a>
                                            </h4>
                                            <?php 
                                                $attr_sql = "select * from dish_details where dd_status = 1 and dd_d_id = '".$p_row['d_id']."' order by dd_price asc";
                                                $attr_res = mysqli_query($con, $attr_sql);
                                            ?>
                                            <?php
                                                while($attr_row=mysqli_fetch_assoc($attr_res)) {
                                            ?>
                                                <?php if($s_website_close==0) { ?>
                                                <div class="product-price-wrapper">
                                                    <input type="radio" id="dd_radio_<?php echo $attr_row['dd_d_id']; ?>" name="dd_radio_<?php echo $attr_row['dd_d_id']; ?>" value="<?php echo $attr_row['dd_id']; ?>">
                                                    <p><?php echo $attr_row['dd_attribute']; ?>
                                                    <p class="dd_price">(Rs. <?php echo $attr_row['dd_price']; ?>)</p>
                                                    <?php
                                                    $added_msg = '';
                                                    if(array_key_exists($attr_row['dd_id'],$cartArr)){
                                                        $added_qty = getUserFullCart($attr_row['dd_id']);
                                                        $added_msg = "(Added)";
                                                        ?>
                                                        <!-- <p>&nbsp;Qty : <?php echo $added_qty ?></p> -->
                                                    <?php } ?>
                                                    <b style="color:red" id="shop_added_msg_<?php echo $attr_row['dd_id'] ?>">&nbsp;<?php echo $added_msg ?></b>
                                                </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($s_website_close==0) { ?>
                                            <div class="qty-cart">
                                                <select class="qty-drop form-control" id="qty<?php echo $p_row['d_id'] ?>">
                                                    <option value="0">Qty</option>
                                                    <?php
                                                    for($i=1;$i<=5;$i++){
                                                        echo "<option value=".$i.">$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <i class="fa fa-cart-plus" aria-hidden="true" onclick="manageCart('<?php echo $p_row['d_id'] ?>','add')"></i>
                                            </div>
                                            <?php } else { ?>
                                                <div class="qty-cart">
                                                    <p style="color: red; font-weight: 500;"><?php echo $s_website_close_msg; ?></p>
                                                </div>
                                                <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } else {
                    echo "<h5>No Dishes Found!</h5>";
                }
                ?>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Food Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq">
                                <li><a href="shop"><u>Clear All</u></a></li>
                                <?php 
                                    $sql = "select * from categories where c_status = 1 order by c_order desc";
                                    $res = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_assoc($res)) {
                                        $is_checked='';
                                        if(in_array($row['c_id'],$cat_dish_arr)){
                                            $is_checked="checked='checked'";
                                        }
                                        echo "<li class='cat_li'><input type='checkbox' $is_checked onclick=set_checkbox('".$row['c_id']."') id='cat_arr_cb' name='cat_arr[]' value='".$row['c_id']."' />".$row['c_name']."</li>";
                                    } 
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="get" id="frm_cat_dish">
    <input type="hidden" name="cat_dish" id="cat_dish" value="<?php echo $cat_dish; ?>" />
    <input type="hidden" name="type_filter_val" id="type_filter_val" value="<?php echo $type_filter_val; ?>" />
    <input type="hidden" name="search_str" id="search_str" value="<?php echo $search_str; ?>">
</form>

<?php include('footer.inc.php') ?>