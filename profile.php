<?php 

include('top.inc.php');

if(!isset($_SESSION['USER_NAME'])){
    redirect('shop');
}

$u_email = '';
$u_mobile = '';
$u_name = '';

if(isset($_SESSION['USER_ID'])){
    $data = getUserDetailsById($_SESSION['USER_ID']);
    $u_email = $data['u_email'];
    $u_mobile = $data['u_mobile'];
    $u_name = $data['u_name'];
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">My Profile</li>
            </ul>
        </div>
    </div>
</div>

<div class="myaccount-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <form method="post" id="frmProfile">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Name</label>
                                                    <input type="text" id="u_name" name="u_name" value="<?php echo $u_name; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Email</label>
                                                    <input type="text" name="u_email" value="<?php echo $u_email; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Mobile</label>
                                                    <input type="text" name="u_mobile" value="<?php echo $u_mobile; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <button type="submit" name="save_profile" id="save_profile">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="profile" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form method="post" id="frmPassword">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Old Password</label>
                                                    <input type="password" name="old_password">
                                                    <p id="wrong_pass" style="margin-top: 15px; color: red;"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>New Password</label>
                                                    <input type="password" name="new_password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit" id="update_pass">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="password" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.inc.php'); ?>
