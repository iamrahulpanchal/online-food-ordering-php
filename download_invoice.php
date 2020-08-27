
<?php

session_start();

require('include/constants.inc.php');
require('include/connection.inc.php');
require('include/functions.inc.php');
require('vendor/autoload.php');

if(isset($_SESSION['a_loggedin'])){

} else {
    if(!isset($_SESSION['USER_ID'])){
        redirect('shop');
    }
}

if(isset($_GET['o_id'])){
    $o_id = get_safe_value($con, $_GET['o_id']);
    if(isset($_SESSION['a_loggedin'])){

    } else {
        $check = mysqli_query($con, "select * from order_master where om_id = ".$o_id);
        $row = mysqli_fetch_assoc($check);
        // prx($row);
        if($check['om_u_id']!=$_SESSION['USER_ID']){
            redirect('shop');
        }
    }
    $orderEmail = orderEmail($o_id, $_SESSION['USER_ID']);

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($orderEmail);
    $file=time().'.pdf';
    $mpdf->Output($file,'D');
}



?>