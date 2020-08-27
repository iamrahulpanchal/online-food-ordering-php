<?php

require('include/connection.inc.php');
require('include/functions.inc.php');
require('include/constants.inc.php');

session_start();

$u_id = $_SESSION['USER_ID'];
$type = get_safe_value($con, $_POST['type']);

if($type=='profile'){
    $u_name = get_safe_value($con, $_POST['u_name']);
    $u_mobile = get_safe_value($con, $_POST['u_mobile']);
    $_SESSION['USER_NAME'] = $u_name;
    $sql = "update users set u_name = '$u_name', u_mobile = '$u_mobile' where u_id = ".$_SESSION['USER_ID'];
    $res = mysqli_query($con, $sql);
    $arrSuccess = array("msg"=>"profileupdate");
    echo json_encode($arrSuccess);
}

if($type=='password'){
    $old_password = get_safe_value($con, $_POST['old_password']);
    $new_password = get_safe_value($con, $_POST['new_password']);
    $sql = "select * from users where u_id = ".$u_id;
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res)>0){
        $db_pass = $row['u_password'];
        if(password_verify($old_password, $db_pass)){
            $new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $sql = "update users set u_password = '$new_password' where u_id = ".$_SESSION['USER_ID'];
            $res = mysqli_query($con, $sql);
            $arrSuccess = array('status'=>'success');
        }  else {
            $arrSuccess = array('status'=>'error','msg'=>'Please enter your old password correctly.');
        }
        echo json_encode($arrSuccess);
    }
}

// pr($_POST);

?>