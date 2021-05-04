$(document).ready(function() {
//custom function 
//lettersonly
jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters allow");
    
    // validate signup form on keyup and submit
    $("#signupForm").validate({
        rules: {
            reg_first_name: "required",
            reg_last_name: "required",
            reg_email: {
                required: true,
                email: true,
                remote: "check-user-email",
            },
            reg_password: {
                required: true,
                minlength: 4
            },
            reg_mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
        },
        messages: {
            reg_first_name: "Please enter your first name",
            reg_last_name: "Please enter your last name",
            reg_email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
                remote:"Email is already exists"
                },
            reg_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 4 characters long"
            },
            reg_mobile: {
                required: "Please enter mobile number",
                minlength: "Your Mobile number must be at least 11 characters long",
                maxlength: "Your Mobile number must be at least 11 characters long",
                digits: "Please enter valid mobile number",
            },
        }
    });
   
    $("#userAccount").validate({
        rules: {
            first_name: {
                required:true,
                lettersonly:true,
            },
            last_name: {
                required:true,
                lettersonly:true,
            },
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
        },
        messages: {
            first_name: {
                required:"Please enter your first name",
            },
            last_name: {
                required:"Please enter your last name",
            },
            mobile: {
                required: "Please enter mobile number",
                minlength: "Your Mobile number must be at least 11 characters long",
                maxlength: "Your Mobile number must be at least 11 characters long",
                digits: "Please enter valid mobile number",
            },
        }
    });
    // validate login form on keyup and submit
    $("#loginFormModel").validate({
        rules: {
            login_email: {
                required: true,
                email: true,
            },
            login_password: {
                required: true,
                minlength: 4
            },
        },
        messages: {
            reg_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 4 characters long"
            },
            reg_email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
                }
        }
    });
    // validate login form on keyup and submit
    $("#loginForm").validate({
        rules: {
            login_email: {
                required: true,
                email: true,
            },
            login_password: {
                required: true,
                minlength: 4
            },
        },
        messages: {
            reg_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 4 characters long"
            },
            reg_email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
                }
        }
    });
    // Password updated
    $("#userPassword").validate({
        rules: {
            password_old: {
                required: true,
                minlength: 4,
                remote:"/check-password"
            },
            password_new: {
                required: true,
                minlength: 4
            },
            password_confirm: {
                required: true,
                minlength: 4,
                equalTo:"#password_new"
            },
        },
        messages: {
            password_old: {
                required: "Please provide a old password",
                minlength: "Your password must be at least 4 characters long",
                remote:'Old password not matched'
            },
            password_new: {
                required: "Please provide a new password",
                minlength: "Your password must be at least 4 characters long"
            },
            password_confirm: {
                required: "Please provide a confirm password",
                minlength: "Your password must be at least 4 characters long",
                equalTo:"Confirm password not match with new password",
            },
        }
    });
    // validate forget password and submit
    $("#forgetPassword").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
           
            email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
                }
        }
    });
  
    //checkout form
    $("#checkoutForm").validate({
        rules: {
            
            billing_first_name: {
                required:true,
                lettersonly:true,
            },
            billing_last_name: {
                required:true,
                lettersonly:true,
            },
            billing_address_1: "required",
            billing_country: "required",
            billing_state: "required",
            billing_city: "required",
            billing_pincode: "required",
            billing_mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
            billing_email: {
                required: true,
                email: true,
            },

            //delivery
            delivery_method:"required",
            delivery_pickup_dateTime:"required",
            delivery_first_name: {
                required:true,
                lettersonly:true,
            },
            delivery_last_name: {
                required:true,
                lettersonly:true,
            },
            delivery_address_1: "required",
            delivery_country: "required",
            delivery_state: "required",
            delivery_city: "required",
            delivery_pincode: "required",
            delivery_mobile: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
            delivery_email: {
                required: true,
                email: true,
            },
            payment_gatway:"required",
        },
        messages: {
           //billing
            billing_first_name: {
                required:"Please enter your first name",
            },
            billing_last_name: {
                required:"Please enter your last name",
            },
            billing_address_1:"Please enter your address 1",
            billing_country:"Please enter your country",
            billing_state:"Please enter your state",
            billing_city:"Please enter your city",
            billing_pincode:"Please enter your pincode",
            billing_mobile: {
                required: "Please enter mobile number",
                minlength: "Your Mobile number must be at least 11 characters long",
                maxlength: "Your Mobile number must be at least 11 characters long",
                digits: "Please enter valid mobile number",
            },
            //delivery
            delivery_method:"Please select delivery methods",
            delivery_pickup_dateTime:"Please select date",
            billing_email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
            },
            delivery_first_name: {
                required:"Please enter your first name",
            },
            delivery_last_name: {
                required:"Please enter your last name",
            },
            delivery_address_1:"Please enter your address 1",
            delivery_country:"Please enter your country",
            delivery_state:"Please enter your state",
            delivery_city:"Please enter your city",
            delivery_pincode:"Please enter your pincode",
            delivery_mobile: {
                required: "Please enter mobile number",
                minlength: "Your Mobile number must be at least 11 characters long",
                maxlength: "Your Mobile number must be at least 11 characters long",
                digits: "Please enter valid mobile number",
            },
            delivery_email:{
                required:"Please enter email address",
                email:"Please enter valid email address",
            },
            payment_gatway:"Please select a payment method",
        }
    });

});