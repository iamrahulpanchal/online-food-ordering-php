<?php

session_start();

require('include/connection.inc.php');
require('include/functions.inc.php');

$u_id = $_SESSION['USER_ID'];
$id = get_safe_value($con, $_POST['id']);
$rate = get_safe_value($con, $_POST['rate']);
$oid = get_safe_value($con, $_POST['oid']);
$sql = "insert into rating (r_u_id, r_dd_id, r_rating, r_o_id) values('$u_id','$id','$rate','$oid')";
$res = mysqli_query($con, $sql);

if($res){
    echo "Success";
} else {
    echo "Failed";
}

?>