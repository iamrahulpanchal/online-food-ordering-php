<?php include('top.inc.php');?>

<div class="row">
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $start=date('Y-m-d'). ' 00-00-00';
                    $end=date('Y-m-d'). ' 23-59-59';
                    echo "Rs. ".getSale($start,$end);
                    ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">Total Sale</h4>
                    </div>
                    <i class="mdi mdi-shopping icon-lg text-primary ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $start=strtotime(date('Y-m-d'));
                    $start=strtotime("-7 day",$start);
                    $start=date('Y-m-d',$start);
                    $start=$start. ' 00-00-00';
                    $end=date('Y-m-d'). ' 23-59-59';
                    echo "Rs. ".getSale($start,$end);
                    ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">7 Days Sale</h4>
                        <p class="text-muted mb-0 font-weight-light">Last 7 Days Sale</p>
                    </div>
                    <i class="mdi mdi-shopping icon-lg text-danger ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $start=strtotime(date('Y-m-d'));
                    $start=strtotime("-30 day",$start);
                    $start=date('Y-m-d',$start);
                    $start=$start. ' 00-00-00';
                    $end=date('Y-m-d'). ' 23-59-59';
                    echo "Rs. ".getSale($start,$end);
                    ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">30 Days Sale</h4>
                        <p class="text-muted mb-0 font-weight-light">Last 30 Days Sale</p>
                    </div>
                    <i class="mdi mdi-shopping icon-lg text-info ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $start=strtotime(date('Y-m-d'));
                    $start=strtotime("-365 day",$start);
                    $start=date('Y-m-d',$start);
                    $start=$start. ' 00-00-00';
                    $end=date('Y-m-d'). ' 23-59-59';
                    echo "Rs. ".getSale($start,$end);
                    ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">365 Days Sale</h4>
                        <p class="text-muted mb-0 font-weight-light">Last 365 Days Sale</p>
                    </div>
                    <i class="mdi mdi-shopping icon-lg text-success ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $row=mysqli_fetch_assoc(mysqli_query($con,"select order_detail.od_dd_id, count(order_detail.od_dd_id) as t, dish_details.dd_d_id, dish.d_dish from order_detail, dish_details, dish WHERE order_detail.od_dd_id=dish_details.dd_id and dish_details.dd_d_id=dish.d_id GROUP BY order_detail.od_dd_id ORDER BY count(order_detail.od_dd_id) desc limit 1"));
                    echo $row['d_dish'];
                    echo "<br/>"; echo '<span style="font-size: 15px;">('.$row['t'].' Times)</span>'; ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">Most Liked Dish</h4>
                    </div>
                    <i class="mdi mdi-food icon-lg text-primary ml-auto"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="font-weight-light mb-4">
                    <?php 
                    $row=mysqli_fetch_assoc(mysqli_query($con,"select count(order_master.om_u_id) as t,users.u_name from order_master,users WHERE order_master.om_u_id=users.u_id GROUP BY order_master.om_u_id order by count(order_master.om_u_id) desc limit 1"));
                    echo $row['u_name'];
                    echo "<br/>"; echo '<span style="font-size: 15px;">('.$row['t'].' Times)</span>'; ?>
                </h1>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h4 class="font-weight-normal">Most Active User</h4>
                    </div>
                    <i class="mdi mdi-account icon-lg text-primary ml-auto"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$sql="select order_master.*, order_status.os_status from order_master, order_status where order_master.om_order_status = order_status.os_id order by order_master.om_id desc limit 5";
$res=mysqli_query($con,$sql);
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Latest 5 Order</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Order Id</th>
                                <th width="20%">Name/Email/Mobile</th>
                                <th width="20%">Address/Zipcode</th>
                                <th width="5%">Price</th>
                                <th width="10%">Payment Type</th>
                                <th width="10%">Payment Status</th>
                                <th width="10%">Order Status</th>
                                <th width="15%">Added On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($res)>0){ $i=1; while($row=mysqli_fetch_assoc($res)){ ?>
                            <tr>
                                <td>
                                    <div class="div_order_id">
                                        <a href="order_detail.php?id=<?php echo $row['om_id']?>"><?php echo $row['om_id']?></a>
                                    </div>
                                </td>
                                <td>
                                    <p><?php echo $row['om_u_name']?></p>
                                    <p><?php echo $row['om_u_email']?></p>
                                    <p><?php echo $row['om_u_mobile']?></p>
                                </td>

                                <td>
                                    <p><?php echo $row['om_u_address']?></p>
                                    <p><?php echo $row['om_zip']?></p>
                                </td>
                                <td style="font-size: 14px;">
                                    <?php echo $row['om_total_price']?>
                                    <br />
                                    <?php
								if($row['om_coupon_code']!=''){
								?>
                                    <?php echo $row['om_coupon_code']?>
                                    <br />
                                    <?php echo $row['om_final_price']?>
                                    <?php } ?>
                                </td>
                                <td><?php echo $row['om_payment_type']?></td>
                                <td>
                                    <div class="pay_status pay_status_<?php echo $row['om_payment_status']?>"><?php echo ucfirst($row['om_payment_status'])?></div>
                                </td>
                                <td><?php echo $row['os_status']?></td>
                                <td>
                                    <?php 
                                    $dateStr=strtotime($row['om_added_on']);
                                    echo date('d-m-Y h:s',$dateStr);
                                    ?>
                                </td>
                            </tr>
                            <?php 
						$i++;
						} } else { ?>
                            <tr>
                                <td colspan="6">No data found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.inc.php');?>
