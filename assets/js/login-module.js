jQuery(document).ready(function(){  
    jQuery("#preloder").hide();

    /** Login Form Validation */
    jQuery('form[id="loginForm"]').validate({
        rules: {          
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 6,
          }
        },
        messages: {          
            email: 'Please enter a valid email',
            password: {
                minlength: 'Password must be at least 6 characters long'
            }
        },
        submitHandler: function(form) {
           //  e.preventDefault();
            var formData = jQuery(form).serialize()
            jQuery.ajax({
                type : 'POST',
                url : 'src/login.php',
                dataType: 'json',
                data: formData,
                success : function (data){
                    if(data.result == 'fail'){
                        jQuery("#preloder").hide();
                        jQuery('#ajax-message').html(data.message);
                    }else{
                        jQuery("#loginForm").trigger('reset');
                        jQuery("#preloder").hide();
                        jQuery('#ajax-message').html(data.message);
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 500);
                    }                    
                },
                error : function(){
                    jQuery("#preloder").show();
                },
                beforeSend : function(){
                    jQuery("#preloder").show();
                },
                complete : function(){
                    jQuery("#preloder").hide();
                }
            });
        }

        
    });
    
    /** Registration Form Validation */
    jQuery('form[id="registerForm"]').validate({
        rules: {         
            first_name: {required: true },
            last_name: {required: true },
            email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 6,
          },
          c_password: {
            required: true,
            minlength: 6,
            equalTo: "#password",
          },
        },
        messages: {            
            email: 'Please enter a valid email',
            password: {
                minlength: 'Password must be at least 6 characters long'
            }
        },
        submitHandler: function(form) {
            return true;
        }

        
    });
    

});