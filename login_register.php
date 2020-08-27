<?php 

include('top.inc.php');

if(isset($_SESSION['USER_NAME'])){
    redirect('shop');
}

?>

<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4>login</h4>
                        </a>
                        <a data-toggle="tab" href="#lg2">
                            <h4>register</h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post" id="u_login_form">
                                        <input type="text" name="u_email" id="u_email" placeholder="Email" required />
                                        <p id="user_not_exist"></p>
                                        <input type="password" name="u_password" id="u_password" placeholder="Password" required />
                                        <input type="hidden" name="type" value="login" />
                                        <p id="password_error"></p>
                                        <p id="email_not_verify"></p>
                                        <input type="hidden" name="is_checkout" id="is_checkout" value="" />
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <button onclick="login_form()" type="submit" id="u_login" name="u_login"><span>Login</span></button>
                                                <a href="forgot_password">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post" id="u_register_form">
                                        <input type="text" name="u_name_reg" id="u_name_reg" placeholder="Username" required />
                                        <input type="password" name="u_password_reg" id="u_password_reg" placeholder="Password" required />
                                        <input type="text" name="u_mobile_reg" id="u_mobile_reg" placeholder="Mobile" required />
                                        <input name="u_email_reg" id="u_email_reg" placeholder="Email" type="email" required />
                                        <p id="email_error"></p>
                                        <p id="email_verify"></p>
                                        <input type="hidden" name="type" value="register" />
                                        
                                        <div class="button-box">
                                            <button type="submit" id="u_register" name="u_register">Register</button>
                                        </div> 
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
