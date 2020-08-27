<?php 

include("top.inc.php");

// echo IMAGE_DISPLAY_PATH;
// die();
// prx($_SERVER);

$b_id = '';
$b_heading = '';
$b_sub_heading = '';
$b_link = '';
$b_link_text = '';
$img_required = 'required';
$error_msg = '';



if(isset($_GET['b_id']) && ($_GET['b_id']!='')){
        $img_required = '';
        $b_id = get_safe_value($con, $_GET['b_id']);
        $sql = "select * from banner where b_id = '$b_id'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
                        $b_heading = $row['b_heading'];
                        $b_sub_heading = $row['b_sub_heading'];
                        $b_link = $row['b_link'];
                        $b_link_text = $row['b_link_text'];
                }
        } else {
                redirect('banner.php');
        }
        
}

if(isset($_POST['b_submit'])){
        // prx($_POST);

        $b_heading = get_safe_value($con, $_POST['b_heading']);
        $b_sub_heading = get_safe_value($con, $_POST['b_sub_heading']);
        $b_link = get_safe_value($con, $_POST['b_link']);
        $b_link_text = get_safe_value($con, $_POST['b_link_text']);
        $b_added_on=date('Y-m-d h:i:s');
        
                $type = $_FILES['b_image']['type'];
                if($b_id==''){
                    if($type!='image/jpeg' && $type!='image/png'){
                        $error_msg="Invalid image format";
                    }else{
                        $b_image = rand(111111111,999999999).'_'.$_FILES['b_image']['name'];
                        move_uploaded_file($_FILES['b_image']['tmp_name'],BANNER_IMG_UPLOAD_PATH.$b_image);
                        $sql = "insert into banner(b_heading, b_sub_heading, b_link, b_link_text, b_added_on, b_image, b_status) values ('$b_heading','$b_sub_heading','$b_link','$b_link_text','$b_added_on', '$b_image','1')";
                        
                        $res = mysqli_query($con, $sql);
                        redirect('banner.php');
                    }
                } else {
                    $image_condition = '';
                    if($_FILES['b_image']['name']!=''){
                        if($type!='image/jpeg' && $type!='image/png'){
                            $error_msg="Invalid image format";
                        }else{
                            $b_image=rand(111111111,999999999).'_'.$_FILES['b_image']['name'];
                            move_uploaded_file($_FILES['b_image']['tmp_name'],BANNER_IMG_UPLOAD_PATH.$b_image);
                            $image_condition=", b_image='$b_image'";
                            
                            $oldImageRow=mysqli_fetch_assoc(mysqli_query($con,"select b_image from banner where b_id='$b_id'"));
                            $oldImage=$oldImageRow['b_image'];
                            unlink(BANNER_IMG_UPLOAD_PATH.$oldImage);
                        }
                    }
                    if($error_msg==''){
                            $sql = "update banner set b_heading = '$b_heading', b_sub_heading = '$b_sub_heading', b_link = '$b_link', b_link_text = '$b_link_text' $image_condition where b_id = '$b_id'";
                            mysqli_query($con, $sql);
                            redirect('banner.php');
                    }
                }
}

?>

<div class="row">
    <?php if(isset($_GET['b_id']) && ($_GET['b_id']!='')) { ?>
        <h1 class="card-title ml-3">Edit Banner</h1>
    <?php } else { ?>
        <h1 class="card-title ml-3">Add New Banner</h1>
    <?php } ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="b_image">Image</label>
                        <input type="file" class="form-control" id="b_image" name="b_image" placeholder="Image" <?php echo $img_required; ?> />
                    </div>
                    <div class="form-group">
                        <label for="b_heading">Heading</label>
                        <input type="text" class="form-control" id="b_heading" name="b_heading" value="<?php echo $b_heading ?>" placeholder="Heading" required />
                    </div>
                    <div class="form-group">
                        <label for="b_sub_heading">Sub Heading</label>
                        <input type="text" class="form-control" id="b_sub_heading" name="b_sub_heading" value="<?php echo $b_sub_heading ?>" placeholder="Sub Heading" required />
                    </div>
                    <div class="form-group">
                        <label for="b_link">Link</label>
                        <input type="text" class="form-control" id="b_link" name="b_link" value="<?php echo $b_link ?>" placeholder="Link" required />
                    </div>
                    <div class="form-group">
                        <label for="b_link_text">Link Text</label>
                        <input type="text" class="form-control" id="b_link_text" name="b_link_text" value="<?php echo $b_link_text ?>" placeholder="Link Text" required />
                    </div>
                    <div class="error_msg">
                        <p><?php echo $error_msg; ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="b_submit">Submit</button>
                    <button class="btn btn-light"><a href="banner.php">Cancel</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.inc.php"); ?>