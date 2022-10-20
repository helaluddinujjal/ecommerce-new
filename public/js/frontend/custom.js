var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});
var DeleteToast = Swal.mixin({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
})
host = window.location.host;
    if (host == 'localhost') {
        var url = 'http://localhost/ecommerce-new/public';
    }else{
        var url = 'http://'+host;
    }
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on('click', "#home_pagi p a", function (event) {
        event.preventDefault()
        var page = $(this).attr('href').split('page=')[1];
        if (page.length) {
            $.ajax({
                type: 'get',
                url: url+'/',
                data: { page: page },
                success: function (res) {
                    $('#home_pagi').hide();
                    $('#home_pagi').before(res);
                    console.log(res)
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something Wrong..Please try later"
                    })
                }
            })
        } else {
            return false

        }

    })

    $(document).on('click', "#products .pagination a", function (event) {
        event.preventDefault()
        var page = $(this).attr('href').split('page=')[1];
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');

        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { page: page, sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html('');
                $('.show_product').html(res);
                console.log(res)
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(document).on('change', "#sort-by", function (event) {
        //var page= $(this).attr('href').split('page=')[1];
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');
        //var data=[fabric_filter,sleeve_filter,pattern_filter,fit_filter,occation_filter,brand_filter]

        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html('');
                $('.show_product').html(res);
                //$('#firstItem').text('5');
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })

    $(".fabric").on('click', function () {
        //alert(filterClass)
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');
        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html('');
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(".sleeve").on('click', function () {

        //alert(filterClass)
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');

        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(".pattern").on('click', function () {

        //alert(filterClass)
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');

        $.ajax({

            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(".fit").on('click', function () {

        //alert(filterClass)
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');

        $.ajax({

            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(".occation").on('click', function () {

        //alert(filterClass)
        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');

        $.ajax({

            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    $(".brand").on('click', function () {

        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');
        // alert(brand_filter)

        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })

    // uncheck all
    $('.uncheckAll').on('click', function () {
        var clearAttr = $(this).attr('clear');
        $('.' + clearAttr + '[type="checkbox"]:checked').prop('checked', false);

        var sec_url = $('#sec_url').val();
        var cat_url = $('#cat_url').val();
        var sort_by = $('#sort-by').val();
        var fabric_filter = get_filter('fabric');
        var sleeve_filter = get_filter('sleeve');
        var pattern_filter = get_filter('pattern');
        var fit_filter = get_filter('fit');
        var occation_filter = get_filter('occation');
        var brand_filter = get_filter('brand');
        // alert(brand_filter)

        $.ajax({
            type: 'get',
            url: url+'/' + sec_url + '/' + cat_url,
            data: { sec: sec_url, cat: cat_url, sort_by: sort_by, fabric_filter: fabric_filter, sleeve_filter: sleeve_filter, pattern_filter: pattern_filter, fit_filter: fit_filter, occation_filter: occation_filter, brand_filter: brand_filter },
            success: function (res) {
                $('.show_product').html(res);
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    //uncheck all after page refress
    $(':checkbox:checked').prop('checked', false);
    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + '[name="value"]:checked').each(function () {
            filter.push($(this).val());
        })

        return filter;
    }

    //get price

    $(document).on('change', '#getSize', function (event) {
        var proSize = $(this).val()
        if (proSize == "") {
            var hidden_attr_price = $("#hidden_attr_price").text()
            var hidden_dis_price = $("#hidden_dis_price").text()
            var hidden_percentage = $("#hidden_percentage").text()
            var hidden_attr_stock = $("#hidden_attr_stock").text()
            var hidden_attr_weight = $("#hidden_attr_weight").text()
            if (hidden_dis_price.length) {
                $('#attr_price').text(hidden_attr_price);
                $('#dis_price').text(hidden_dis_price);
                $('#percentage').text(hidden_percentage);
                $('#attr_stock').text(hidden_attr_stock);
                $('#attr_weight').text(hidden_attr_weight);
            } else {
                $('#attr_price').text(hidden_attr_price);
                $('#attr_stock').text(hidden_attr_stock);
                $('#attr_weight').text(hidden_attr_weight);
            }
            Toast.fire({
                icon: 'warning',
                title: "Please Select Size"
            })
            return false;
        }
        var productId = $(this).attr('product_id')
        $.ajax({
            type: 'post',
            url: url+'/get-attr-price',
            data: { proSize: proSize, productId: productId },
            success: function (res) {
                if (res.productData.dis_price > 0) {
                    $('#attr_price').text('');
                    $('#dis_price').text('');
                    $('#percentage').text('');
                    $('#attr_stock').text('');
                    $('#attr_weight').text('');
                    $('#attr_price').text(res.currency + res.productData['attr_price']);
                    $('#dis_price').text(res.currency + res.productData['final_price']);
                    $('#percentage').text(res.productData['percentage']);
                    $('#attr_stock').text(res.productData['attr_stock']);
                    $('#attr_weight').text(res.productData['attr_weight']);
                } else {
                    $('#attr_price').text('');
                    $('#attrStock').text('');
                    $('#attr_price').text(res.currency + res.productData['attr_price']);
                    $('#attr_stock').text(res.productData['attr_stock']);
                    $('#attr_weight').text(res.productData['attr_weight']);
                }

            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })
    //update cart item
    $(document).on('input', "input.quantity", function (e) {
        var value = $(this).val();
        var cartId = $(this).attr('data');
        if (value < 1) {
            Toast.fire({
                icon: 'error',
                title: 'Item quantity must be 1 or greater!!!'
            })
            $(this).val('1');
        } else {
            $.ajax({
                type: 'post',
                url: url+'/cart-qty-updated',
                data: { value: value, cartId: cartId },
                success: function (res) {
                    if (res.status === false) {
                        Toast.fire({
                            icon: 'error',
                            title: res.msg
                        })
                    }
                    $("#cartItemAppend").html('')
                    $("#cartItemAppend").html(res.view)
                    $(".totalCartItems").html(res.totalCartItems)
                    $(".order_summery").html(res.order_summery)
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something Wrong..Please try later"
                    })
                }
            })
        }
    })
    //delete cart item
    $(document).on('click', ".deleteCartItem", function (e) {
        var cartId = $(this).attr('data');
        DeleteToast.fire({
            icon: 'error',
            text: 'Item will delete from the cart',
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: 'post',
                    url: url+'/cart-item-deleted',
                    data: { cartId: cartId },
                    success: function (res) {
                        if (res.status === true) {
                            if (res.status === true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.msg
                                })
                            }
                            $("#cartItemAppend").html('')
                            $("#cartItemAppend").html(res.view)
                            $(".order_summery").html(res.order_summery)
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: "Something Wrong..Please try later"
                            })
                        }
                    },
                    error: function () {
                        Toast.fire({
                            icon: 'error',
                            title: "Something Wrong..Please try later"
                        })
                    }
                })
            }
        })
    })

    //get state
    $(document).on('change', '#country', function () {
        var country_id = $(this).val();
        var main_div = $(this).parent().parent().parent();
        var state_name_attr = main_div.find("#state:visible").attr('name');
        var city_name_attr = main_div.find("#city:visible").attr('name');
        if (country_id === '') {
            Toast.fire({
                icon: 'warning',
                title: "Please select country"
            })
            main_div.find("input#state:visible").remove()
            main_div.find("input#city:visible").remove()
            main_div.find("#countryEmoji:visible").text(" ")
            if (main_div.find('select#state:visible').length == 0) {
                main_div.find("label[for='state']:visible").after('<select id="state" autocomplete="off" name="' + state_name_attr + '" placeholder="Please input state name" type="text" class="form-control" required="required"></select>')
                main_div.find("label[for='city']:visible").after('<select id="city" autocomplete="off" name="' + city_name_attr + '" placeholder="Please input city name" type="text" class="form-control" required="required"></select>')
            }
            setTimeout(function () {
                main_div.find("select#state:visible").find('option').remove().end()
            }, 500)
            return false;
        }
        $.ajax({
            type: 'post',
            url: url+'/get-state',
            data: { country_id: country_id },
            success: function (res) {
                main_div.find("#countryEmoji:visible").html("<i>" + res.emoji + "</i>")
                if (res.states.length) {
                    main_div.find("input#state:visible").remove()
                    main_div.find("input#city:visible").remove()
                    if (main_div.find('select#state:visible').length == 0) {
                        main_div.find("label[for='state']:visible").after('<select id="state" autocomplete="off" name="' + state_name_attr + '" placeholder="Please input state name" type="text" class="form-control" required="required"></select>')

                    }
                    if (main_div.find("select#city:visible").length == 0) {
                        main_div.find("label[for='city']:visible").after('<select id="city" autocomplete="off" name="' + city_name_attr + '" placeholder="Please input city name" type="text" class="form-control" required="required"><option value="">Select City</option></select>')
                    }
                    main_div.find("#state:visible").find('option').remove().end()
                    main_div.find("#city:visible").find('option').remove().end()
                    main_div.find("#state:visible").append('<option value="">Select State</option>');
                    $.each(res.states, function (key, value) {
                        main_div.find('#state:visible').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                    })
                } else {
                    main_div.find("select#state:visible").remove()
                    main_div.find("select#city:visible").remove()
                    if (main_div.find("input#state:visible").length == 0) {
                        main_div.find("label[for='state']:visible").after('<input id="state" name="' + state_name_attr + '" placeholder="Please input state name" type="text" class="form-control" required="required">')

                    }
                    if (main_div.find("input#city:visible").length == 0) {
                        main_div.find("label[for='city']:visible").after('<input id="city" name="' + city_name_attr + '" placeholder="Please input city name" type="text" class="form-control" required="required">')

                    }
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })

    //get city
    $(document).on('change', '#state', function () {
        var state_id = $(this).val();
        var main_div = $(this).parent().parent().parent();
        var city_name_attr = main_div.find("#city:visible").attr('name');
        if (state_id === '') {
            Toast.fire({
                icon: 'warning',
                title: "Please select state"
            })
            main_div.find("input#city:visible").remove()
            if (main_div.find("select#city:visible").length == 0) {
                main_div.find("label[for='city']:visible").after('<select id="city" autocomplete="off" name="' + city_name_attr + '" placeholder="Please input city name" type="text" class="form-control" required="required"></select>')
            }
            setTimeout(function () {
                main_div.find("select#state:visible").find('option').remove().end()
            }, 500)
            return false;
        }
        $.ajax({
            type: 'post',
            url: url+'/get-cities',
            data: { state_id: state_id },
            success: function (res) {
                if (res.cities.length) {
                    main_div.find("input#city:visible").remove()
                    if (main_div.find("select#city:visible").length == 0) {
                        main_div.find("label[for='city']:visible").after('<select id="city" autocomplete="off" name="' + city_name_attr + '" type="text" class="form-control" placeholder="Select City" required="required"></select>')
                    }
                    main_div.find("#city:visible").find('option').remove().end()
                    $.each(res.cities, function (key, value) {
                        main_div.find('#city:visible').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                    })
                } else {
                    if (main_div.find("input#city:visible").length == 0) {
                        main_div.find("select#city:visible").remove()
                        main_div.find("label[for='city']:visible").after('<input id="city" name="' + city_name_attr + '" placeholder="Please input city name" type="text" class="form-control" required="required">')
                    }
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })

    // coupon apply
    $(document).on('submit', "#couponForm", function () {
        var user = $(this).attr('user');
        if (user == 1) {
            var coupon_code = $("#coupon_code").val();
            if (coupon_code.length) {
                $.ajax({
                    type: 'post',
                    url: url+'/apply-coupon',
                    data: { coupon_code: coupon_code },
                    success: function (res) {
                        if (res.status == 'true') {
                            Toast.fire({
                                icon: 'success',
                                title: res.msg
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.msg
                            })
                        }
                        $("#cartItemAppend").html(res.view)
                        $(".totalCartItems").html(res.totalCartItems)
                        $(".order_summery").html(res.order_summery)
                    },
                    error: function () {
                        Toast.fire({
                            icon: 'error',
                            title: "Something Wrong..Please try later"
                        })
                    }
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: "Code must not be empty."
                })
            }
        } else {
            Toast.fire({
                icon: 'error',
                title: "Please login to apply coupon."
            })
        }
    })

    //checkout

    $(document).on('click', '#checkout-next', function (e) {
        $("html").animate({ scrollTop: $("#checkoutForm").offset().top }, "800");
        if ($("#checkoutForm").valid()) {
            var billing_address = $("#billing-address").css('display')
            var delivery_address = $("#delivery-address").css('display')
            var payment_method = $("#payment-method").css('display')
            var order_review = $("#order-review").css('display')

            $("#checkout-prev").attr('href', 'javascript:void(0)')
            if (billing_address == "block") {
                sessionStorage.setItem("ch_country", $("#country.billingCountry").find('option:selected').val());
                sessionStorage.setItem("ch_pincode", $("#pincode.billingPincode").val());
                $("#billing-address").fadeOut(300)
                $("#delivery-address").delay(300).fadeIn(300)
                $("#next-text").text("Payment Method")
                $("#prev-text").text("Billing Address")
                $("#billing-menu").removeClass("active").addClass("disabled")
                $("#delivery-menu").addClass("active").removeClass('disabled')
                return false
            } else if (delivery_address == "block") {

                //get delivery chargss
                if ($("input[name='delivery_method']:checked").val() === "Flat Rate") {
                    if ($("#check_to_different_address").is(":checked")) {
                        deliveryCharges($("#country.deliveryCountry").find('option:selected').text())
                        sessionStorage.setItem("ch_country", $("#country.deliveryCountry").find('option:selected').val());
                        sessionStorage.setItem("ch_pincode", $("#pincode.deliveryPincode").val());
                    } else {
                        deliveryCharges($("#country.billingCountry").find('option:selected').text())
                    }
                }
                if (sessionStorage.getItem('deliveryCharges') == 1) {
                    $("#delivery-address").fadeOut(300)
                    $("#payment-method").delay(300).fadeIn(300)
                    $("#next-text").text("Order Review")
                    $("#prev-text").text("Delivery Address")
                    $("#delivery-menu").removeClass("active").addClass('disabled')
                    $("#payment-menu").addClass("active").removeClass("disabled")
                }
                return false
            } else if (payment_method == "block") {

                //delivery chargss conditon
                if ($("input[name='delivery_method']:checked").val() === "Flat Rate") {
                    if ($("#check_to_different_address").is(":checked")) {
                        deliveryCharges($("#country.deliveryCountry").find('option:selected').text())
                    } else {
                        deliveryCharges($("#country.billingCountry").find('option:selected').text())
                    }
                }
                if (sessionStorage.getItem('deliveryCharges') == 1) {

                    if ($("input[name='delivery_method']:checked").val() === "Flat Rate") {
                        var ch_pin="ch_prepaid";
                        if ($("input[name='payment_gatway']:checked").val() === "COD") {
                            ch_pin="ch_cod";
                        }
                        $.ajax({
                            type: 'post',
                            url: url+'/get-country-pincode',
                            data: { country: sessionStorage.getItem("ch_country"), ch_pin: ch_pin, pincode: sessionStorage.getItem("ch_pincode") },
                            success: function (res) {
                                if (res.status === false) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: res.msg
                                    })
                                } else {
                                    $("#payment-method").fadeOut(300)
                                    $("#order-review").delay(300).fadeIn(300)
                                    $("#prev-text").text("Payment Method")
                                    $("#checkout-next").attr('type', 'submit')
                                    $("#next-text").text("Place an Order")
                                    $("#payment-menu").removeClass("active").addClass('disabled')
                                    $("#review-menu").addClass("active").removeClass("disabled")
                                }
                            },
                            error: function () {
                                Toast.fire({
                                    icon: 'error',
                                    title: "Something Wrong..Please try later"
                                })
                            }
                        })
                    }else{
                        $("#payment-method").fadeOut(300)
                        $("#order-review").delay(300).fadeIn(300)
                        $("#prev-text").text("Payment Method")
                        $("#checkout-next").attr('type', 'submit')
                        $("#next-text").text("Place an Order")
                        $("#payment-menu").removeClass("active").addClass('disabled')
                        $("#review-menu").addClass("active").removeClass("disabled")
                    }

                }
                return false
            }
        }

    });
    var cart_link = $("#checkout-prev").attr('href')
    $(document).on('click', '#checkout-prev', function (e) {
        $("html").animate({ scrollTop: $("#checkoutForm").offset().top }, "800");
        var billing_address = $("#billing-address").css('display')
        var delivery_address = $("#delivery-address").css('display')
        var payment_method = $("#payment-method").css('display')
        var order_review = $("#order-review").css('display')

        // return false;
        if (delivery_address == "block") {
            $("#delivery-address").fadeOut(300)
            $("#billing-address").delay(300).fadeIn(300)
            $("#next-text").text("Delivery Address")
            $("#prev-text").text("Basket")
            $("#delivery-menu").removeClass("active").addClass('disabled')
            $("#billing-menu").addClass("active").removeClass("disabled")
            $("#checkout-prev").attr('href', cart_link)
            return false
        } else if (payment_method == "block") {
            $("#payment-method").fadeOut(300)
            $("#delivery-address").delay(300).fadeIn(300)
            $("#prev-text").text("Billing Address")
            $("#next-text").text("Payment Method")
            $("#payment-menu").removeClass("active").addClass('disabled')
            $("#delivery-menu").addClass("active").removeClass("disabled")
            return false
        } else if (order_review == "block") {
            $("#order-review").fadeOut(300)
            $("#payment-method").delay(300).fadeIn(300)
            $("#next-text").text("Order Review")
            $("#prev-text").text("Delivery Address")
            $("#review-menu").removeClass("active").addClass('disabled')
            $("#payment-menu").addClass("active").removeClass("disabled")
            $("#checkout-next").attr('type', 'button')
            return false
        }
    });
    //delete delivery aaddress
    $(document).on('click', ".deleteDeliveryAddress", function (e) {
        var delAddId = $(this).attr('data');
        DeleteToast.fire({
            icon: 'error',
            text: 'Item will delete from the cart',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/delivery-address-deleted/" + delAddId;
            }
        })
    })

    //checkout radio button condition
    //select method
    $(document).on('click', ".box.shipping-method", function () {
        var value = $("input[name='delivery_method']:checked").val()
        if (value == "Flat Rate") {
            $("#delivery_method_content").fadeIn('300');
            $("#check_to_different_address").prop("checked", true);
            $("#diff_address_fields").fadeIn('300');

            //delivery chargss conditon for flat rate
            if ($("#check_to_different_address").is(":checked")) {
                if ($("#country.deliveryCountry").val()) {
                    deliveryCharges($("#country.deliveryCountry").find('option:selected').text())
                }
            } else {
                deliveryCharges($("#country.billingCountry").find('option:selected').text())
            }
        } else {
            $("#delivery_method_content").fadeOut('300');
            $("#check_to_different_address").prop("checked", false);

            //delivery chargss conditon for local pickup
            deliveryCharges()
        }
    })
    //select defferent address
    $(document).on('click', "#check_to_different_address", function () {
        if ($(this).is(":checked")) {
            $("#diff_address_fields").fadeIn('300');
        } else {
            var country = $('#country.billingCountry option:selected').text();
            deliveryCharges(country)
            $("#diff_address_fields").fadeOut('300');
        }
    })
    //select delivery address
    $(document).on('click', ".deliveryAdd", function () {
        var del_add_id = $(this).attr('data')
        $.ajax({
            type: 'post',
            url: url+'/delivery-address',
            data: { del_add_id: del_add_id },
            success: function (res) {
                if (res.status === false) {
                    Toast.fire({
                        icon: 'error',
                        title: "Something Wrong..Please try later"
                    })
                }
                $("#ajax_del_add_field_data").html('')
                $("#ajax_del_add_field_data").html(res.view)
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "Something Wrong..Please try later"
                })
            }
        })
    })

    //get sdelivery charges
    $(document).on('change', "#country.deliveryCountry", function () {
        var country = $(this).find('option:selected').text();
        deliveryCharges(country)
    })

    $(".ch_pincode input[name='ch_pin']").click(function () {
        alert('You clicked radio!');
        if ($('input:radio[name=ch_pin]:checked').val() == "ch_cod") {
            alert("");
            //$('#select-table > .roomNumber').attr('enabled',false);
        }
    });

    $(document).on('click', '#ch_pincode_cod', function () {
        if (this.checked) {
            $('#ch_pincode_prepaid').prop('checked', false);
            $('#pincode_box').removeClass("d-none");
        } else {
            // $('.ch_pincode').prop('checked', false);
            $('#pincode_box').addClass("d-none");
        }
    })
    $(document).on('click', '#ch_pincode_prepaid', function () {
        if (this.checked) {
            $('#ch_pincode_cod').prop('checked', false);
            $('#pincode_box').removeClass("d-none");
        } else {
            // $('.ch_pincode').prop('checked', false);
            $('#pincode_box').addClass("d-none");
        }
    })

    $(document).on('click', '#ch_country_pincode_submit', function () {
        if ($('#country_ch_pin').val()) {
            var country = $('#country_ch_pin').val();
            var ch_pin = $('.ch_pincode:checked').val() == undefined ? '' : $('.ch_pincode:checked').val();
            var pincode = $('#pincode_box').val() == undefined ? '' : $('#pincode_box').val();
            $.ajax({
                type: 'post',
                url: url+'/get-country-pincode',
                data: { country: country, ch_pin: ch_pin, pincode: pincode },
                success: function (res) {
                    if (res.status === false) {
                        Toast.fire({
                            icon: 'error',
                            title: res.msg
                        })
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        })
                    }
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: "Something Wrong..Please try later"
                    })
                }
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: "Country must be selected"
            })
        }
    })
})
function deliveryCharges(country) {
    $.ajax({
        type: 'post',
        url: url+'/get-delivery-charges',
        data: { country: country },
        success: function (res) {
            if (res.msg) {
                Toast.fire({
                    icon: 'error',
                    title: res.msg
                })
                sessionStorage.setItem('deliveryCharges', 0);
            } else {
                sessionStorage.setItem('deliveryCharges', 1);
            }
            $(".order_summery").html('')
            $(".order_summery").html(res.view)
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: "Something Wrong..Please try later"
            })
        }
    })
}
function deliveryByPincode(country, state, city) {
    alert(country + state + city)
    $.ajax({
        type: 'post',
        url: url+'/get-delivery-payment-method-by-pincode',
        data: { country: country, state: state, city: city },
        success: function (res) {
            if (res.msg) {
                Toast.fire({
                    icon: 'error',
                    title: res.msg
                })
                sessionStorage.setItem('availabele_pincode', 0);
            } else {
                sessionStorage.setItem('availabele_pincode', 1);
            }
            $("#payment-method").html('')
            $("#payment-method").html(res.pincodeView)
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: "Something Wrong..Please try later"
            })
        }
    })
}
