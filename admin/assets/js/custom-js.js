function add_more_attr(){
        let add_more = jQuery('#add_more').val();
        add_more++;
        jQuery('#add_more').val(add_more);
        $html = '<div class="row mt-2" id="dd_box'+add_more+'"><div class="col-4"><input type="text" class="form-control" placeholder="Attribute" name="dd_attribute[]" required></div><div class="col-3"><input type="text" class="form-control" placeholder="Price" name="dd_price[]" required></div><div class="col-3"><select style="color:black;" required class="form-control" name="dd_status[]"><option value="">Select Status</option><option value="1">Active</option><option value="0">Deactive</option></select></div><div class="col-2 remove_attr_btn"><button type="button" class="btn badge badge-success mr-2" onclick="remove_attr('+add_more+')">Remove</button></div></div>';
        jQuery('#dd_box').append($html);
}

function remove_attr(id){
        jQuery('#dd_box'+id).remove();
}

function remove_attr_new(id){
        let result = confirm('Are you sure?');
        if(result==true){
                let curr_path = window.location.href;
                window.location.href = curr_path+"&dd_id="+id;
        }
}