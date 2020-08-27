<?php

require('include/connection.inc.php');
require('include/functions.inc.php');

$cu_name = get_safe_value($con, $_POST['cu_name']);
$cu_email = get_safe_value($con, $_POST['cu_email']);
$cu_subject = get_safe_value($con, $_POST['cu_subject']);
$cu_message = get_safe_value($con, $_POST['cu_message']);
$cu_added_on = date('Y-m-d h:i:s');

$sql = "insert into contact_us (cu_name, cu_email, cu_subject, cu_message, cu_added_on) values('$cu_name','$cu_email','$cu_subject','$cu_message', '$cu_added_on')";
$res = mysqli_query($con, $sql);

if($res){
    echo "Success";
} else {
    echo "Failed";
}

?>