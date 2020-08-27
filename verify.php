<?php 

include('top.inc.php');

$msg = '';

if(isset($_GET['u_id']) && ($_GET['u_id']!='')){
    $u_id = get_safe_value($con, $_GET['u_id']);
    $sql = "update users set u_email_verify = 1  where u_rand_str = '$u_id'";
    // pr($sql);
    $res = mysqli_query($con, $sql);
    $msg = "Congratulations! Your Email ID is Verified Now...";
} else {
    redirect('index');
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Email Verify</li>
            </ul>
        </div>
    </div>
</div>

<div class="container verify_container">
    <div class="row">
        <div class="col-12">
            <h4 class="contact-title">
                <?php echo $msg ?>
            </h4>
        </div>
    </div>
</div>

<?php include('footer.inc.php'); ?>