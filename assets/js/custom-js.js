function apply_coupon_code1(){
    var coupon_code = $('#coupon_code').val();
    if(coupon_code==''){
        $('#coupon_code_msg').html('Please Enter Coupon Code');
    } else {
        $('#coupon_code_msg').html('');
        $.ajax({
            url: 'coupon_code_ajax',
            type: 'post',
            data: 'coupon_code='+coupon_code,
            success: function(result){
                var data = $.parseJSON(result);
                if(data.status=='success'){
                    $('#coupon_code_msg').html(data.msg);
                    $('.coupon_price_box').css('display','block');
                    $('.final_price_box').css('display','block');
                    $('.coupon_code_str').html('Rs. '+data.coupon_value+' ('+data.coupon_code+')');
                    $('.final_price').html('Rs. '+data.cart_value);
                }
                if(data.status=='error'){
                    $('#coupon_code_msg').html(data.msg);
                }
                if(data.status=='expired'){
                    $('#coupon_code_msg').html(data.msg);
                }
                if(data.status=='min_value'){
                    $('#coupon_code_msg').html(data.msg);
                }
            }
        });
    }
}

function cart_min_price(){
    var s_cart_min_price = jQuery('#cart_min_price').val();
    alert(s_cart_min_price);
}

function setFoodType(type){
    jQuery('#type_filter_val').val(type);
    jQuery('#frm_cat_dish')[0].submit();
}

function setSearch(search_str){
    jQuery('#search_str').val($('#search').val());
    jQuery('#frm_cat_dish')[0].submit();
}

function delete_cart(attr_id, is_type){
    $.ajax({
        url: 'manage_cart_ajax',
        type: 'post',
        data: 'attr='+attr_id+'&type=delete',
        success: function(result){
            if(is_type=='load'){
                window.location.href = 'cart';
            } else {
                let data = $.parseJSON(result);
                $('#totalCartDish').html(data.totalCartDish);
                $('#shop_added_msg_'+attr_id).html('');
                $('#totalPriceDish').html('Rs. '+data.totalPriceDish);
                if(data.totalCartDish==0){
                    $('.shopping-cart-content').remove();
                } else {
                    $('.shop-total').html('Rs. '+data.totalPriceDish);
                    $('#attr_'+attr_id).remove();
                }
            }
        }
    });
}

function manageCart(d_id, type){
    let qty = $('#qty'+d_id).val();
    let attr = $('input[name="dd_radio_'+d_id+'"]:checked').val();
    let is_attr_checked = '';
    if(typeof attr==='undefined'){
        is_attr_checked = 'no';
    }
    if(qty>0 && is_attr_checked!='no'){
        $.ajax({
            url: 'manage_cart_ajax',
            type: 'post',
            data: 'qty='+qty+'&attr='+attr+'&type='+type,
            success: function(result){
                let data = $.parseJSON(result);
                Swal.fire({
                    title: 'Congratulations!',
                    text: 'Dish Added to Cart.',
                    icon: 'success',
                });
                $('#shop_added_msg_'+attr).html('&nbsp;(Added)');
                $('#totalCartDish').html(data.totalCartDish);
                $('#totalPriceDish').html('Rs. '+data.totalPriceDish);

                if(data.totalCartDish==1){
                    let tp = qty*data.price;
                    let html='<div class="shopping-cart-content"><ul id="cart_ul"><li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="" width="70px" height="70px" src="'+IMAGE_DISPLAY_PATH+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+'</a></h4><h6>Qty : '+qty+'</h6><span>Rs. '+tp+'</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick="delete_cart("'+attr+'")"><i class="ion ion-close close-btn"></i></a></div></li></ul><div class="shopping-cart-total"><h4>Total : <span class="shop-total">Rs. '+tp+'</span></h4></div><div class="shopping-cart-btn"><a href="cart">view cart</a><a href="checkout">checkout</a></div></div>';
                    $('.header-cart').append(html);
                } else {
                    let tp = qty*data.price;
                    $('#attr_'+attr).remove();
                    let html = '<li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="" width="70px" height="70px" src="'+IMAGE_DISPLAY_PATH+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+'</a></h4><h6>Qty : '+qty+'</h6><span>Rs. '+tp+'</span></div><div class="shopping-cart-delete"><a href="javascript:void(0 "onclick="delete_cart('+attr+')"><i class="ion ion-close close-btn"></i></a></div></li>';
                    $('#cart_ul').append(html);
                    $('.shop-total').html('Rs. '+data.totalPriceDish);
                }
            }
        });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Please Select the Item & Qty',
            icon: 'error',
        });
    }
}

$('#u_login_form').on('submit', function(e){
    $('#email_not_verify').html('Please Wait...');
    $('#user_not_exist').html('');
    $('#password_error').html('');
    $.ajax({
        url: 'login_register_ajax',
        type: 'post',
        data: $('#u_login_form').serialize(),
        success: function(result){
            let data = $.parseJSON(result);
            if(data.status=='user_error'){
                $('#'+data.field).html(data.msg);
            }
            if(data.status=='pass_error'){
                $('#'+data.field).html(data.msg);
            }
            if(data.status=='email_verify'){
                $('#'+data.field).html(data.msg);
            }
            var is_checkout = $('#is_checkout').val();
            console.log(is_checkout);
            if(is_checkout=='yes'){
                window.location.href = "checkout";
            } else if (data.status=='login_success'){
                window.location.href = "shop";
            }
        }
    });
    e.preventDefault();
});

$('#u_register_form').on('submit', function(e){
    $('#email_error').html('');
    $('#email_verify').html('Please Wait...');
    $('#u_register').attr('disabled',true);
    $.ajax({
        url: 'login_register_ajax',
        type: 'post',
        data: $('#u_register_form').serialize(),
        success: function(result){
            $('#email_verify').html('');
            $('#u_register').attr('disabled',false);
            var data = JSON.parse(result);
            if(data.status=='error'){
                jQuery('#'+data.field).html(data.msg);
            }
            if(data.status=='success'){
                // jQuery('#email_error').html('');
                jQuery('#'+data.field).html(data.msg);
                $('#u_register_form')[0].reset();
            }
        }
    });
    e.preventDefault();
});

$('#frmPassword').on('submit', function(e){
    $('#update_pass').attr('disabled',true);
    $.ajax({
        url: 'update_profile_ajax',
        type: 'post',
        data: $('#frmPassword').serialize(),
        success: function(result){
            var data = JSON.parse(result);
            if(data.status=='success'){
                $('#update_pass').attr('disabled',false);
                Swal.fire({
                    title: 'Success!',
                    text: 'Password Updated Successfully!!',
                    icon: 'success',
                });
            }
            if(data.status=='error'){
                $('#wrong_pass').html(data.msg);
            }
        }
    });
    e.preventDefault();
});

$('#frmProfile').on('submit', function(e){
    $('#save_profile').attr('disabled',true);
    $.ajax({
        url: 'update_profile_ajax',
        type: 'post',
        data: $('#frmProfile').serialize(),
        success: function(result){
            var data = JSON.parse(result);
            if(data.msg = 'profilesuccess'){
                $('#user_name').html($('#u_name').val());
                $('#save_profile').attr('disabled',false);
                Swal.fire({
                    title: 'Success!',
                    text: 'Profile Updated Successfully!!',
                    icon: 'success',
                });
            }
        }
    });
    e.preventDefault();
});

function cart_checkout(page){
    window.location.href = page;
}

function contact_submit(){
    let cu_name = $('#cu_name').val();
    let cu_email = $('#cu_email').val();
    let cu_subject = $('#cu_subject').val();
    let cu_message = $('#cu_message').val();
    $.ajax({
        url: 'contact_us_ajax',
        type: 'post',
        data: {
            cu_name: cu_name,
            cu_email: cu_email,
            cu_subject: cu_subject,
            cu_message: cu_message,
        },
        success: function(result){
            Swal.fire({
                title: 'Success!',
                text: 'Thank You for Contacting Us!',
                icon: 'success',
            });
        }
    });
}

function set_checkbox(id){
    var cat_dish = jQuery('#cat_dish').val();
    var check = cat_dish.search(":" + id);
    if(check!='-1'){
        cat_dish = cat_dish.replace(":" + id,'');
    } else {
        cat_dish = cat_dish + ":" + id;
    }
    jQuery('#cat_dish').val(cat_dish);
    jQuery('#frm_cat_dish')[0].submit();
}

function updateRating(id, om_id){
    var rate = $('#rate_'+id).val();
    var rate_str = $('#rate_'+id+ " option:selected").text();
    // alert(rate);
    if(rate==''){

    } else {
        $.ajax({
            url: 'update_rating_ajax',
            type: 'post',
            data: 'id='+id+'&rate='+rate+'&oid='+om_id,
            success: function(result){
                $('#rating'+id).html(rate_str);
            } 
        })
    }
}