"use strict"
jQuery.validator.addMethod("laxEmail", function(value, element) {
    // allow any non-whitespace characters as the host part
    return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
}, validEmailText );

if (page == 'forgotPass') { 
    $("#reset_btn").on("click", function (e)
    {
        $(".email-error").hide();
    });

    $('#forgot_password_form').validate({
    rules: {
        email: {
            required: true,
            maxlength: 255,
            laxEmail: true
        }
    },
    submitHandler: function(form)
    {
        $("#reset_btn").on("click", function (e)
        {
            $("#reset_btn").attr("disabled", true);
            e.preventDefault();
        });

        $(".spinner").removeClass('d-none');
        $("#btn_next-text").text(resetLinkSentText);
        return true;
    },
    messages: {
    email: {
            required:  fieldRequirdText,
            maxlength: maxlengthText,
        }
    }
    });
} else if (page == 'login') {
    $('#login_form').validate({
        rules: {
            email: {
                required: true,
                maxlength: 255,
                laxEmail: true
            },

            password: {
                required: true
            }
        },
        submitHandler: function(form)
        {
            $("#btn").on("click", function (e)
            {
                $("#btn").attr("disabled", true);
                e.preventDefault();
            });


            $(".spinner").removeClass('d-none');
            $("#btn_next-text").text(loginText);
            return true;
        },
        messages: {
            email: {
                required:  fieldRequirdText,
                maxlength: maxlengthText,
            },

            password: {
                required: fieldRequirdText,
            }
        }
    });
} else if (page == 'resetPass') {
    $('#password-form').validate({
        rules: {
			password: {
				required: true,
				minlength: 6,
			},

			password_confirmation: {
				required: true,
				minlength: 6,
				equalTo: "#new_password"
			}
        },

        messages: {
            password: {
                required:  fieldRequirdText,
                minlength: minlengthText,
            },

            password_confirmation: {
                required:  fieldRequirdText,
                minlength: minlengthText,
                equalTo:   equalToText,
            }
        }
    });
}