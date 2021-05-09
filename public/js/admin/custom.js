
$(document).ready(function(){
    //coupon code
    $(document).on('click',"#manual_coupon",function(){
        $("#coupon_code_field").fadeIn('slow');
    })
    $(document).on("click","#automatic_coupon",function(){
        $("#coupon_code_field").fadeOut('slow');
    })

    //check password
    
    /* $('#current_pass').keyup(function(){
        var current_pass=$('#current_pass').val();
        //alert(current_pass)
        $.ajax({
            type: "post",
            url: "/admin/check-password",
            data: {'current_pass':current_pass},
            success: function (response) {
                if (response=='true') {
                    $('#result').html("<span class='text-success'>Your password is correct</span>")
                }else{
                    $('#result').html("<span class='text-danger'>Your password is incorrect</span>")
                }
            },
            error:function(){
                alert('Something wrong')
            }
        });
    })
 */

    // $('.updateSectionStatus').click(function(){
    //     var status=$(this).text();
    //     var section_id=$(this).attr('section_id');
    //     // alert(status)
    //     // alert(section_id)
    //     $.ajax({
    //     type:'post',    
    //     url: "/admin/update-section-status",
    //     data:{status:status,section_id:section_id},
    //     success:function(res){
    //         // alert(res.section_id)
    //         // alert(res.status)
    //         if (res.status==1) {
    //             $('#section-'+section_id).html('Active')
    //         } else {
    //             $('#section-'+section_id).html('Inactive')
    //         }
    //     },
    //     error:function(){
    //         alert("Something Wrong..Please try later ")
    //     }
    //     })
    // })

    /* //category update status
    $('.updateCategoryStatus').click(function(){
        var status=$(this).text();
        var category_id=$(this).attr('category_id');
        $.ajax({
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(res){
                //alert(res.status)
                if (res.status==1) {
                    $('#category-'+category_id).html('Active')
                } else {
                    $('#category-'+category_id).html('Inactive')
                }
            },
            error:function(){
                alert("Something Wrong..Please try later ")
            }
        })
    }) */

    //category append level
    $('#section_id').change(function(){
       var section_id= $(this).val()
       //alert(section_id)
       $.ajax({
           type:'post',
           url:'/admin/append-category-level',
           data:{section_id:section_id},
           success:function(res){
                $('#append-category-lavel').html(res)
           },
           error:function(){
               alert("Something wrong!!! Please try later")
           }
       })
    })
    // status update
    $(document).on('click','.updateStatus',function(){
        var status=$(this).children('i').attr('status');
        var get_id=$(this).attr('get_id');
        var name=$(this).attr('id');
        name=name.split('-',1)
        $.ajax({
            type:'post',
            url:'/admin/update-status-'+name,
            data:{status:status,id:get_id},
            success:function(res){
                //alert(res.status)
                if (res.status==1) {
                    $('#'+name+'-'+res.get_id).html('<i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>')
                } else {
                    $('#'+name+'-'+res.get_id).html('<i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inactive"></i>')
                }
            },
            error:function(){
                alert("Something Wrong..Please try later ")
            }
        })
    })

    //confirm delete
    $(document).on('click','.confirm-delete',function(){
        var record=$(this).attr('record')
        var recorded=$(this).attr('recorded')
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href="/admin/delete-"+record+'/'+recorded;
            } 
          })
    })

    /* 
    ####add remove field
    */
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var remove_img_url = window.location.origin+"/images/icon/remove-icon.png";
    var addFieldId=$('.field_wrapper input').attr('id');
    var fieldHTML = '<div class="attribute"> <input title="Input Product Attribute Size" type="text" id="size" class="attr_size"  name="size[]" placeholder="Size" required/> <input title="Input Product Attribute SKU" type="text" class="attr_sku" id="sku" name="sku[]" placeholder="SKU" required/> <input type="number" title="Input Product Attribute Price" id="price" name="price[]" placeholder="Price" step="any" min=".1" required/> <input title="Input Product Attribute Stock" type="number" id="stock" name="stock[]" placeholder="Stock" required min="0" /> <input type="number" id="weight" name="weight[]" placeholder="Weight(g)" step="any" min=".1" title="Input Product Attribute Weight in (gram)" required/> <a href="javascript:void(0);" class="remove_button"> <img src="'+remove_img_url+'"/></a></div></a>'; //New input field html 

    var filterField='<div class="attribute"> <input type="text" id="filter_value" class="filter_value w-75"  name="filter_value[]" placeholder="Value" required/> <a href="javascript:void(0);" class="remove_button"> <img src="'+remove_img_url+'"/></a></div></a>'; 

    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            if (addFieldId=="productFilter") {
                $(wrapper).append(filterField); //Add field html
            } else {
                $(wrapper).append(fieldHTML); //Add field html
            }
        }
    });
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    //change attribute code
    $(document).on('focus', 'input', function(){ 
        $("#result").html('')
    })
    $(document).on('keyup', '.attr_size,.attr_sku', function(){ 
   // $('.attr_size,.attr_sku').keyup(function(){
        var getData=$(this).val();
        var getId=$('#productData').val();
        var id=$(this).attr('id');
        //alert(id);
        var showResult=$(this).parent().attr('class');
        var getSize=0;
        if (id==='size') {
            getSize=1;
        } 
       // alert(getData)
        $.ajax({
            type:'post',
            url:'/admin/check-attribute-code',
            data:{getData:getData,getId:getId,getSize:getSize},
            success:function(res){
                //alert(res.status)
                if (res.countData==0) {
                    $("#result").html("<span class='text-success'>This is available</span>")
                } else {
                    $("#result").html("<span class='text-danger'>This is not available</span>")
                }
            },
            error:function(){
                alert("Something Wrong..Please try later ")
            }
        })
    })
    $(document).on('keyup', '.filter_value', function(){ 
   // $('.attr_size,.attr_sku').keyup(function(){
        var getData=$(this).val();
        var getId=$('#productFilter').val();
        var id=$(this).attr('id');
        var showResult=$(this).parent().attr('class');
        
       // alert(getData)
        $.ajax({
            type:'post',
            url:'/admin/check-filter-value',
            data:{getData:getData,getId:getId},
            success:function(res){
                //alert(res.status)
                if (res.countData==0) {
                    $("#result").html("<span class='text-success'>This is available</span>")
                } else {
                    $("#result").html("<span class='text-danger'>This is not available</span>")
                }
            },
            error:function(){
                alert("Something Wrong..Please try later ")
            }
        })
    })

    //add_order_status_field
  $("#add_order_status_field").on('change',function(){
    var value=$("#add_order_status_field option:selected").text()
    if (value==="Shipped") {
        $('.shipped_field').fadeIn()
    }else{
        $('.shipped_field').fadeOut()
    }
  })

})
/*
### function
 */

//check password 
function checkPass(){
    
    var current_pass=$('#current_pass').val();
    if (current_pass!=='') {
        //alert(current_pass)
        $.ajax({
            type: "post",
            url: "/admin/check-password",
            data: {'current_pass':current_pass},
            success: function (response) {
                if (response=='true') {
                    $('#result').html("<span class='text-success'>Your password is correct</span>")
                }else{
                    $('#result').html("<span class='text-danger'>Your password is incorrect</span>")
                }
            },
            error:function(){
                alert('Something wrong')
            }
        });
    }else{
        $('#result').html("")
    }
}
$("#productName,#brandName,#categoryName").on('keyup',function(){
   var proname=$(this).val().toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
   $("#url").val(proname)
})
//check slug 
function checkSlug(){
    
    var getPath=$('#url').attr('getPath');
    var getId=$('#url').attr('getId');
    var getSlug=$('#url').val();
    //sectionId exist or not
    // if ($('#section_id').val()!='')
    // {
    // /* it exists */
    // var section_id= $('#section_id').val()
    // } 
    // else
    // {
       
    // /* it doesn't exist */
    //     var section_id=''
    //     $('#result').html("<span class='text-danger'>Please select section</span>")
    //     return false;
    // }
    //category_id exist or not
    // if ($('#category_id').val()!='')
    // {
    // /* it exists */
    // var category_id= $('#category_id').val()

    // }
    // else
    // {
    // /* it doesn't exist */
    // var category_id=''
    // $('#result').html("<span class='text-danger'>Please select category</span>")
    //         return false;
    // }
    //alert(getSlug+getId+getPath)
    if (getSlug!=='') {
        //alert(current_pass)
        $.ajax({
            type: "post",
            url: "/admin/check-"+getPath,
            data: {'getId':getId,'getSlug':getSlug},
            success: function (response) {
               // alert(response.countSlug)
                if (response.currentSlug==1) {
                    $('#result').html("<span class='text-info'>This is current url</span>")
                }else{
                    if (response.countSlug==0) {
                        $('#result').html("<span class='text-success'>This url is available</span>")
                    } else {
                        $('#result').html("<span class='text-danger'>This url is not available</span>")
                    }
                }
            },
            error:function(){
                alert('Something wrong')
            }
        });
    }else{
        $('#result').html("")
    }
}
//check code 
function checkCode(){
    
    var getPath=$('.codeCheck').attr('getPath');
    var getId=$('.codeCheck').attr('getId');
    var getCode=$('.codeCheck').val();
    
    //alert(getSlug+getId+getPath)
    if (getCode!=='') {
        //alert(current_pass)
        $.ajax({
            type: "post",
            url: "/admin/check-"+getPath,
            data: {'getId':getId,'getCode':getCode},
            success: function (response) {
               // alert(response.countSlug)
                if (response.currentSlug==1) {
                    $('#codeResult').html("<span class='text-info'>This is current code</span>")
                }else{
                    if (response.countSlug==0) {
                        $('#codeResult').html("<span class='text-success'>This code is available</span>")
                    } else {
                        $('#codeResult').html("<span class='text-danger'>This code is not available</span>")
                    }
                }
            },
            error:function(){
                alert('Something wrong')
            }
        });
    }else{
        $('#result').html("")
    }

}