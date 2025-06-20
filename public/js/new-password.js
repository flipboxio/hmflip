"use strict"
jQuery.validator.addMethod("notEqual", function(value, element, param) {
	return this.optional(element) || value != $(param).val();
	}, passwordDifferentText );

$(document).ready(function () {
    $('#change_pass').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 30,
                notEqual: "#old_password"
            },
            password_confirmation: {
                required: true,
                equalTo: "#new_password",
                notEqual: "#old_password"
            }
        },
        submitHandler: function(form)
        {
            $("#save_btn").on("click", function (e)
            {
                $("#save_btn").attr("disabled", true);
                e.preventDefault();
            });

            $(".spinner").removeClass('d-none');
            $("#save_btn-text").text(updatePasswordText);
            return true;
        },
        messages: {
            old_password: {
                required:  requiredFieldText,
            },
            new_password: {
                required:  requiredFieldText,
                minlength: minLengthText,
                maxlength: maxLengthText,
            },
            password_confirmation: {
                required:  requiredFieldText,
                minlength: minLengthText,
                equalTo:   equalText,
            }
        }
    });
});