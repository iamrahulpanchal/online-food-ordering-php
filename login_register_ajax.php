<?php

require('include/connection.inc.php');
require('include/functions.inc.php');
require('include/constants.inc.php');

session_start();

$type = get_safe_value($con, $_POST['type']);

if($type=='login'){
    $u_email = get_safe_value($con, $_POST['u_email']);
    $u_password = get_safe_value($con, $_POST['u_password']);
    $sql = "select * from users where u_email = '$u_email'";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)>0){
        $sql = "select * from users where u_email = '$u_email'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_assoc($res);
            $db_password = $row['u_password'];
            if($row['u_email_verify']==0){
                $arr = array('status'=>'email_verify','msg'=>'Check Your Email for Verifying Account First...','field'=>'email_not_verify');
                $html = SITE_PATH."verify?u_id=".$row['u_rand_str'];
                send_email($row['u_email'], 'Verify Your Email Address', $html);
            } else {
                if(password_verify($u_password, $db_password)){
                    $_SESSION['USER_NAME'] = $row['u_name'];
                    $_SESSION['USER_ID'] = $row['u_id'];

                    $arr = array('status'=>'login_success','msg'=>'');

                    if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                        foreach($_SESSION['cart'] as $key=>$val){
                            manageUserCart($_SESSION['USER_ID'], $val['qty'], $key);
                        }  
                    }
                } else {
                    $arr = array('status'=>'pass_error','msg'=>'Please enter correct password','field'=>'password_error');
                }
            }
        } else {
            $arr = array('status'=>'pass_error','msg'=>'Please enter correct password','field'=>'password_error');
        }
    } else {
        $arr = array('status'=>'user_error','msg'=>'User does not exist','field'=>'user_not_exist');
    }
    echo json_encode($arr);
}

if($type=='register'){
    $u_name_reg = get_safe_value($con, $_POST['u_name_reg']);
    $u_email_reg = get_safe_value($con, $_POST['u_email_reg']);
    $u_mobile_reg = get_safe_value($con, $_POST['u_mobile_reg']);
    $u_password_reg = get_safe_value($con, $_POST['u_password_reg']);
    $u_password_reg = password_hash($u_password_reg, PASSWORD_BCRYPT);
    $u_added_on = date('Y-m-d h:i:s');
    $sql = "select * from users where u_email = '$u_email_reg'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);
    if($count>0){
        $arr = array('status'=>'error','msg'=>'Email ID already Registered','field'=>'email_error');
    } else {
        $u_rand_str = rand_str();
        $sql = "insert into users (u_name, u_email, u_email_verify, u_mobile, u_password, u_added_on, u_status, u_rand_str) values('$u_name_reg', '$u_email_reg', '0', '$u_mobile_reg', '$u_password_reg', '$u_added_on', '1', '$u_rand_str')";
        $res = mysqli_query($con, $sql);
        $u_id = mysqli_insert_id($con);
        $html = SITE_PATH."verify?u_id=".$u_rand_str;
        send_email($u_email_reg, 'Verify Your Email Address', $html);
        $arr = array('status'=>'success','msg'=>'Please Check Your Email ID for Verification','field'=>'email_verify');
    }
    // pr($arr);
    echo json_encode($arr);
}

// pr($_POST);

?>