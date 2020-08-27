<?php 

include('top.inc.php');

if(isset($_SESSION['USER_NAME'])){
    redirect('shop');
}

$msg = '';

if(isset($_POST['u_forgot'])){
    $u_email = get_safe_value($con, $_POST['u_email']);
    $sql = "select * from users where u_email = '$u_email'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res)>0){
        $rand_pass = str_shuffle("azdjdasjvk");
        $html = $rand_pass;
        send_email($row['u_email'],'Your Temporary Password',$html);
        $crypt_pass = password_hash($rand_pass, PASSWORD_BCRYPT);
        $sql = "update users set u_password = '$crypt_pass' where u_email = '$u_email'";
        mysqli_query($con, $sql);
    } else {
        $msg = 'User does not exists...';
    }
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Forgot Password</li>
            </ul>
        </div>
    </div>
</div>

<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row forgot-row">
            <form method="post">
                <input type="text" name="u_email" id="u_email" placeholder="Email" required />
                <p><?php echo $msg ?></p>
                <div class="button-box">
                    <div class="login-toggle-btn">
                        <button type="submit" id="u_forgot" name="u_forgot"><span>Send Password</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.inc.php'); ?>
