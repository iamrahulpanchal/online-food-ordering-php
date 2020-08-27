<?php

require("connection.inc.php");

require("phpmailer/PHPMailer.php");
require("phpmailer/SMTP.php");
require("phpmailer/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_email($recipient, $subject, $html){
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                 
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = '';             
        $mail->Password   = '';                          
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                   
    
        $mail->setFrom('', '');
        $mail->addAddress($recipient);    
        $mail->addReplyTo('', '');

        $mail->isHTML(true);                        
        $mail->Subject = $subject;
        $mail->Body    = $html;
    
        $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function dateFormat($date){
    $str = strtotime($date);
    return date('d-m-Y',$str);
}

function getOrderById($order_id){
    global $con;
    $sql = "select * from order_master where om_id = ".$order_id;
    $data = array();
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }
    return $data;
}

function getDeliveryBoy($db_id){
    global $con;
    $sql = "select db_name from delivery_boy where db_id = ".$db_id;
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['db_name'];
}

function orderEmail($order_id, $u_id){
    $getUserDetails = getUserDetailsById($u_id);
    // prx($getUserDetails);
    $u_name = $getUserDetails['u_name'];
    $u_email = $getUserDetails['u_email'];

    $getOrderById = getOrderById($order_id);
    // prx($getOrderDetails);

    $o_id = $getOrderById[0]['om_id'];
    $total_amount = $getOrderById[0]['om_total_price'];
    $coupon_code = $getOrderById[0]['om_coupon_code'];
    $final_price = $getOrderById[0]['om_final_price'];
    // prx($order_id);
    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        
        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
        body {
          width: 100% !important;
          height: 100%;
          margin: 0;
          -webkit-text-size-adjust: none;
        }
        
        a {
          color: #3869D4;
        }
        
        a img {
          border: none;
        }
        
        td {
          word-break: break-word;
        }
        
        .preheader {
          display: none !important;
          visibility: hidden;
          mso-hide: all;
          font-size: 1px;
          line-height: 1px;
          max-height: 0;
          max-width: 0;
          opacity: 0;
          overflow: hidden;
        }
        /* Type ------------------------------ */
        
        body,
        td,
        th {
          font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
        }
        
        h1 {
          margin-top: 0;
          color: #333333;
          font-size: 22px;
          font-weight: bold;
          text-align: left;
        }
        
        h2 {
          margin-top: 0;
          color: #333333;
          font-size: 16px;
          font-weight: bold;
          text-align: left;
        }
        
        h3 {
          margin-top: 0;
          color: #333333;
          font-size: 14px;
          font-weight: bold;
          text-align: left;
        }
        
        td,
        th {
          font-size: 16px;
        }
        
        p,
        ul,
        ol,
        blockquote {
          margin: .4em 0 1.1875em;
          font-size: 16px;
          line-height: 1.625;
        }
        
        p.sub {
          font-size: 13px;
        }
        /* Utilities ------------------------------ */
        
        .align-right {
          text-align: right;
        }
        
        .align-left {
          text-align: left;
        }
        
        .align-center {
          text-align: center;
        }
        /* Buttons ------------------------------ */
        
        .button {
          background-color: #3869D4;
          border-top: 10px solid #3869D4;
          border-right: 18px solid #3869D4;
          border-bottom: 10px solid #3869D4;
          border-left: 18px solid #3869D4;
          display: inline-block;
          color: #FFF;
          text-decoration: none;
          border-radius: 3px;
          box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
          -webkit-text-size-adjust: none;
          box-sizing: border-box;
        }
        
        .button--green {
          background-color: #22BC66;
          border-top: 10px solid #22BC66;
          border-right: 18px solid #22BC66;
          border-bottom: 10px solid #22BC66;
          border-left: 18px solid #22BC66;
        }
        
        .button--red {
          background-color: #FF6136;
          border-top: 10px solid #FF6136;
          border-right: 18px solid #FF6136;
          border-bottom: 10px solid #FF6136;
          border-left: 18px solid #FF6136;
        }
        
        @media only screen and (max-width: 500px) {
          .button {
            width: 100% !important;
            text-align: center !important;
          }
        }
        /* Attribute list ------------------------------ */
        
        .attributes {
          margin: 0 0 21px;
        }
        
        .attributes_content {
          background-color: #F4F4F7;
          padding: 16px;
        }
        
        .attributes_item {
          padding: 0;
        }
        /* Related Items ------------------------------ */
        
        .related {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .related_item {
          padding: 10px 0;
          color: #CBCCCF;
          font-size: 15px;
          line-height: 18px;
        }
        
        .related_item-title {
          display: block;
          margin: .5em 0 0;
        }
        
        .related_item-thumb {
          display: block;
          padding-bottom: 10px;
        }
        
        .related_heading {
          border-top: 1px solid #CBCCCF;
          text-align: center;
          padding: 25px 0 10px;
        }
        /* Discount Code ------------------------------ */
        
        .discount {
          width: 100%;
          margin: 0;
          padding: 24px;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F4F4F7;
          border: 2px dashed #CBCCCF;
        }
        
        .discount_heading {
          text-align: center;
        }
        
        .discount_body {
          text-align: center;
          font-size: 15px;
        }
        /* Social Icons ------------------------------ */
        
        .social {
          width: auto;
        }
        
        .social td {
          padding: 0;
          width: auto;
        }
        
        .social_icon {
          height: 20px;
          margin: 0 8px 10px 8px;
          padding: 0;
        }
        /* Data table ------------------------------ */
        
        .purchase {
          width: 100%;
          margin: 0;
          padding: 35px 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_content {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_item {
          padding: 10px 0;
          color: #51545E;
          font-size: 15px;
          line-height: 18px;
        }
        
        .purchase_heading {
          padding-bottom: 8px;
          border-bottom: 1px solid #EAEAEC;
        }
        
        .purchase_heading p {
          margin: 0;
          color: #85878E;
          font-size: 12px;
        }
        
        .purchase_footer {
          padding-top: 15px;
          border-top: 1px solid #EAEAEC;
        }
        
        .purchase_total {
          margin: 0;
          font-weight: bold;
          color: #333333;
        }
        
        .purchase_total--label {
          padding: 0 15px 0 0;
        }
        
        body {
          background-color: #F4F4F7;
          color: #51545E;
        }
        
        p {
          color: #51545E;
        }
        
        p.sub {
          color: #6B6E76;
        }
        
        .email-wrapper {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F4F4F7;
        }
        
        .email-content {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        /* Masthead ----------------------- */
        
        .email-masthead {
          padding: 25px 0;
          text-align: center;
        }
        
        .email-masthead_logo {
          width: 94px;
        }
        
        .email-masthead_name {
          font-size: 16px;
          font-weight: bold;
          color: #A8AAAF;
          text-decoration: none;
          text-shadow: 0 1px 0 white;
        }
        /* Body ------------------------------ */
        
        .email-body {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #FFFFFF;
        }
        
        .email-body_inner {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #FFFFFF;
        }
        
        .email-footer {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        
        .email-footer p {
          color: #6B6E76;
        }
        
        .body-action {
          width: 100%;
          margin: 30px auto;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        
        .body-sub {
          margin-top: 25px;
          padding-top: 25px;
          border-top: 1px solid #EAEAEC;
        }
        
        .content-cell {
          padding: 35px;
        }
        /*Media Queries ------------------------------ */
        
        @media only screen and (max-width: 600px) {
          .email-body_inner,
          .email-footer {
            width: 100% !important;
          }
        }
        
        @media (prefers-color-scheme: dark) {
          body,
          .email-body,
          .email-body_inner,
          .email-content,
          .email-wrapper,
          .email-masthead,
          .email-footer {
            background-color: #333333 !important;
            color: #FFF !important;
          }
          p,
          ul,
          ol,
          blockquote,
          h1,
          h2,
          h3 {
            color: #FFF !important;
          }
          .attributes_content,
          .discount {
            background-color: #222 !important;
          }
          .email-masthead_name {
            text-shadow: none !important;
          }
        }
        </style>
        <!--[if mso]>
        <style type="text/css">
          .f-fallback  {
            font-family: Arial, sans-serif;
          }
        </style>
      <![endif]-->
      </head>
      <body>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td align="center">
              <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="email-masthead">
                    <a href="javascript:void(0)" class="f-fallback email-masthead_name">
                    Food Ordering
                  </a>
                  </td>
                </tr>
                <!-- Email Body -->
                <tr>
                  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <!-- Body content -->
                      <tr>
                        <td class="content-cell">
                          <div class="f-fallback">
                            <h1>Hi '.$u_name.'</h1>
                            <p>This is an invoice for your recent purchase.</p>
                            <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td class="attributes_content">
                                  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                      <td class="attributes_item">
                                        <span class="f-fallback">
                  <strong>Amount Due :</strong> Rs. '.$total_amount.'
                </span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="attributes_item">
                                        <span class="f-fallback">
                  <strong>Order ID :</strong> '.$o_id.'
                </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <!-- Action -->
                            
                            <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                             
                              <tr>
                                <td colspan="2">
                                  <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <th class="purchase_heading" align="left">
                                        <p class="f-fallback">Description</p>
                                      </th>
                                      <th class="purchase_heading" align="left">
                                        <p class="f-fallback">Qty</p>
                                      </th>
                                      <th class="purchase_heading" align="left">
                                        <p class="f-fallback">Amount</p>
                                      </th>
                                    </tr>';
                                    
                                    $getOrderDetails = getOrderDetails($o_id);
                                    // prx($getOrderDetails);
                                    $totalPrice = 0;
                                    foreach($getOrderDetails as $list) {
                                    $item_price = $list['od_qty']*$list['od_price'];
                                    $totalPrice = $totalPrice + $item_price;
                                    $html.='<tr>
                                      <td width="60%" class="purchase_item"><span class="f-fallback">'.$list['d_dish'].' ('.$list['dd_attribute'].')</span></td>
                                      <td width="20%" class="purchase_item"><span class="f-fallback">'.$list['od_qty'].'</span></td>
                                      <td width="20%" class="purchase_item"><span class="f-fallback">Rs. '.$item_price.'</span></td>
                                    </tr>';
                                    
                                    }

                                    if($getOrderById[0]['om_coupon_code']!='') {
                                    $html.='<tr>
                                      <td width="80%" class="purchase_footer" colspan="2">
                                        <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                      </td>
                                      <td width="20%" class="purchase_footer" style="text-align:left !important;">
                                        <p class="f-fallback purchase_total">Rs. '.$totalPrice.'</p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="80%" class="purchase_footer" colspan="2">
                                        <p class="f-fallback purchase_total purchase_total--label">Coupon Code</p>
                                      </td>
                                      <td width="20%" class="purchase_footer" style="text-align:left !important;">
                                        <p class="f-fallback purchase_total">'.$coupon_code.'</p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="80%" class="purchase_footer" colspan="2">
                                        <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                      </td>
                                      <td width="20%" class="purchase_footer" style="text-align:left !important;">
                                        <p class="f-fallback purchase_total">Rs. '.$final_price.'</p>
                                      </td>
                                    </tr>';
                                    }

                                  $html.='</table>
                                </td>
                              </tr>
                            </table>
                            <p>If you have any questions about this invoice, simply reply to this email or reach out to our support team for help.</p>
                            <p>Cheers,
                              <br>The Food Ordering Team</p>
                            <!-- Sub copy -->
                            
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>';
    return $html;
}

function pr($arr){
        echo "<pre>";
        print_r($arr);
}

function prx($arr){
        echo "<pre>";
        print_r($arr);
        die();
}

function getOrderDetails($order_id){
    global $con;
    $data = array();
    $sql = "select order_detail.od_dd_id, order_detail.od_price, order_detail.od_qty, dish_details.dd_attribute, dish.d_dish from order_detail, dish_details, dish where order_detail.od_o_id = '$order_id' and order_detail.od_dd_id = dish_details.dd_id and dish_details.dd_d_id = dish.d_id";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }
    return $data;
}

function get_safe_value($con, $str){
        if($str!=""){
                $str = mysqli_real_escape_string($con, $str);
                $str = trim($str);
                $str = strip_tags($str);
                return $str;
        }
}

function redirect($link){
        ?>
        <script>
                window.location.href = "<?php echo $link ?>";
        </script>
        <?php
        die();
}

function rand_str(){
    $str = str_shuffle("abcdefghijklmabcdefghijklmnopqrstuvwxyznopqrstuvwxyz");
    $str = substr($str, 0, 15);
    return $str;
}

function getUserDetailsById($uid){
    global $con;
    $sql = "select * from users where u_id = ".$uid;
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    // prx($row);
    return $row;
}

function removeDishFromCartById($dd_id, $u_id){
    global $con;
    if($u_id){
        $sql = "delete from dish_cart where dc_dd_id = '$dd_id' and dc_u_id = ".$u_id;
        $res = mysqli_query($con, $sql);
    } else {
        unset($_SESSION['cart'][$dd_id]);
    }
}

function emptyCart($u_id){
    global $con;
    if($u_id){
        $sql = "delete from dish_cart where dc_u_id = ".$u_id;
        $res = mysqli_query($con, $sql);
    } else {
        unset($_SESSION['cart']);
    }
}

function getDishDetailById($attr_id){
    global $con;
    $res = mysqli_query($con, "select dish.d_dish, dish.d_image, dish_details.dd_price from dish_details, dish where dish_details.dd_id = '$attr_id' and dish.d_id = dish_details.dd_d_id");
    $row = mysqli_fetch_assoc($res);
    return $row;
}

function getDishDetailsStatus($id){
    global $con;
    // $sql = "select dish_details.dd_status, dish.d_status, dish.d_id from dish_details, dish where dish_details.dd_id='$id' and dish_details.dd_d_id = dish.d_id";
    // $res = mysqli_query($con, $sql);
    // $row = mysqli_fetch_assoc($res);
    // if($row['d_status']==0){
    //     $id = $row['d_id'];
    //     $sql = "select dd_id from dish_details where dd_d_id = ".$id;
    //     $res = mysqli_query($con, $sql);
    //     while($row1 = mysqli_fetch_assoc($res)){
    //             removeDishFromCartById($row1['dd_id'],'');
    //     }
    // }
    // return $row['dd_status'];
}

function getDishCartStatus(){
    global $con;
    $cartArr = array();
    $dishDetailsID = array();
    if(isset($_SESSION['USER_ID'])){
        $u_id = $_SESSION['USER_ID'];
        $getUserCart = getUserCart($u_id);
        // prx($getUserCart);
        foreach($getUserCart as $list){
            $dishDetailsID[] = $list['dc_dd_id'];
        }
    } else {
        if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
            foreach($_SESSION['cart'] as $key=>$val){
                $dishDetailsID[] = $key;
            }
            // $cartArr = $_SESSION['cart'];
        }
        // prx($_SESSION['cart']);
    }

    foreach($dishDetailsID as $id){
        $sql = "select dish_details.dd_status, dish.d_status, dish.d_id from dish_details, dish where dish_details.dd_id='$id' and dish_details.dd_d_id = dish.d_id";
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        if($row['d_status']==0){
            $id = $row['d_id'];
            $sql = "select dd_id from dish_details where dd_d_id = ".$id;
            $res = mysqli_query($con, $sql);
            while($row1 = mysqli_fetch_assoc($res)){
                    removeDishFromCartById($row1['dd_id'],'');
            }
        }
        if($row['dd_status']==0){
            removeDishFromCartById($id,'');
        }
    }
}

function getUserFullCart($attr_id=''){
    $cartArr = array();
    if(isset($_SESSION['USER_ID'])){
        $u_id = $_SESSION['USER_ID'];
        $getUserCart = getUserCart($u_id);
        // prx($getUserCart);
        foreach($getUserCart as $list){
            $cartArr[$list['dc_dd_id']]['qty']=$list['dc_qty'];
            $getDishDetail = getDishDetailById($list['dc_dd_id']);

            $cartArr[$list['dc_dd_id']]['price']=$getDishDetail['dd_price'];
            $cartArr[$list['dc_dd_id']]['name']=$getDishDetail['d_dish'];
            $cartArr[$list['dc_dd_id']]['image']=$getDishDetail['d_image'];
        }
    } else {
        if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
            foreach($_SESSION['cart'] as $key=>$val){
                $cartArr[$key]['qty']=$val['qty'];
                $getDishDetail = getDishDetailById($key);

                $cartArr[$key]['price']=$getDishDetail['dd_price'];
                $cartArr[$key]['name']=$getDishDetail['d_dish'];
                $cartArr[$key]['image']=$getDishDetail['d_image'];
            }
            // $cartArr = $_SESSION['cart'];
        }
        // prx($_SESSION['cart']);
    }
    if($attr_id!=''){
        return $cartArr[$attr_id]['qty'];
    } else {
        return $cartArr;
    }
}

function manageUserCart($u_id, $qty, $attr){
    global $con;
    $sql = "select * from dish_cart where dc_u_id = '$u_id' and dc_dd_id = '$attr'";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)>0){
        $row = mysqli_fetch_assoc($res);
        $cart_id = $row['dc_id'];
        $sql = "update dish_cart set dc_qty = '$qty' where dc_id = '$cart_id'";
    } else {
        $dc_added_on = date('Y-m-d h:i:s');
        $sql = "insert into dish_cart(dc_u_id, dc_dd_id, dc_qty, dc_added_on) values ('$u_id','$attr','$qty','$dc_added_on')";
    }
    mysqli_query($con, $sql);
}

function getUserCart($u_id){
    global $con;
    $data = array();
    $sql = "select * from dish_cart where dc_u_id = '$u_id'";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }
    return $data;
}

function cartpage(){
    ?>
    <script>window.location.href = 'cart';</script>
    <?php
}

function getSetting(){
    global $con;
    $sql = "select * from setting where s_id = '1'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row;
}

function getRatingList($d_id, $om_id){
    $ratingArr = array('Bad','Below Average','Average','Good','Very Good');
    $html = '<select id="rate_'.$d_id.'" onchange="updateRating('.$d_id.','.$om_id.')" class="form-control rating-drop">';
    $html .= '<option value="">Select Rating</option>';
    foreach($ratingArr as $key=>$val){
        $id = $key+1;
        $html .= "<option value='$id'>$val</option>";
    }
    $html .= '</select>';
    return $html;
}

function getRating($did, $oid){
    global $con;
    $sql = "select * from rating where r_o_id='$oid' and r_dd_id='$did'";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)>0){
        $row = mysqli_fetch_assoc($res);
        $rating = $row['r_rating'];
        $ratingArr = array('','Bad','Below Average','Average','Good','Very Good');
        echo $ratingArr[$rating];
    } else {
        echo getRatingList($did, $oid);
    }
}

function getRatingByDishId($id){
    global $con;
    $ratingArr = array('','Bad','Below Average','Average','Good','Very Good');
    $sql = "select dd_id from dish_details where dd_d_id='$id'";
    $res = mysqli_query($con, $sql);
    $str = '';
    while($row = mysqli_fetch_assoc($res)){
        $str.="r_dd_id='".$row['dd_id']."' or ";
    }
    $str = rtrim($str, " or");
    $sql = "select sum(r_rating) as rating, count(*) as total from rating where $str";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    if($row['total']>0){
        $totalRate = $row['rating']/$row['total'];
        echo "&nbsp;<span style='color:red;'>(".$ratingArr[round($totalRate)].")</span>";
    } else {
      echo "&nbsp;<span style='color:red;'>(No Rating)</span>";
    }
}

function getSale($start, $end){
    global $con;
    $sql = "select sum(om_final_price) as total_sale from order_master where om_order_status=4 and om_added_on between '$start' and '$end'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total_sale'];
}

?>