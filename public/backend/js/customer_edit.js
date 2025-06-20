    "use strict"
    $('#edit_customer').validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 255
            },
            last_name: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                maxlength: 255,
                laxEmail: true
            },
            password: {
                minlength: 6
            }
            
        },
        submitHandler: function(form)
        {
    
            $("#submitBtn").on("click", function (e)
            {
                $("#submitBtn").attr("disabled", true);
                e.preventDefault();
            });
    
    
            return true;
        },
    
        errorPlacement: function (error, element) {
            error.insertAfter(element);
    
        },
    
        messages: {
        first_name: {
            required:  requiredFieldText,
            maxlength: maxLengthText,
        },
        last_name: {
            required:  requiredFieldText,
            maxlength: maxLengthText,
        },
        email: {
            required:  requiredFieldText,
            maxlength: maxLengthText,
        },
        password: {
            minlength: minLengthText,
        }
        }
    });
    
    $(document).on('blur keyup', '#email', function() {
        var emailError = '';
        var email      = $('#email').val();
        var _token     = $('input[name="_token"]').val();
        $('.error-tag').html('').hide();
        if (email != '') {
        $.ajax({
            url:checkUserURL,
            method:"POST",
            data:{
                    email:email,
                    "_token": _token,
                    },
            success:function(result)
            {
                if (result == 'not_unique') {
                    $('#emailError').html('<label class="text-danger">'+emailExistText+'</label>');
                    $('#email').addClass('has-error');
                    $('#btn').attr('disabled', 'disabled');
                } else {
                    $('#email').removeClass('has-error');
                    $('#emailError').html('');
                    $('#btn').attr('disabled', false);
                }
            }
        })
        } else {
            $('#emailError').html('');
        }
    
    });
        //jquery validation
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).parent('div').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent('div').removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                $('#tel-error').html('').hide();
                error.insertAfter(element);
            }
        });

        /*
        intlTelInput
        */
         $("#phone").intlTelInput({
            separateDialCode: true,
            nationalMode: true,
            preferredCountries: ["us"],
            autoPlaceholder: "polite",
            placeholderNumberType: "MOBILE",
            utilsScript: url,
        });

        var countryData = $("#phone").intlTelInput("getSelectedCountryData");
        $('#default_country').val(countryData.iso2);
        $('#carrier_code').val(countryData.dialCode);

        $("#phone").on("countrychange", function(e, countryData) {
            formattedPhone();
            // log(countryData);
            $('#default_country').val(countryData.iso2);
            $('#carrier_code').val(countryData.dialCode);
            if ($.trim($(this).val()) !== '') {
                //Invalid Number Validation - Add
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html(tel_error).css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#phone-error').hide();
                } else {
                    $('#tel-error').html('');

                    $.ajax({
                            method: "POST",
                            url: duplicate_check_url,
                            dataType: "json",
                            cache: false,
                            data: {
                                "_token": token,
                                'phone': $.trim($(this).val()),
                                'carrier_code': $.trim(countryData.dialCode),
                                'id': $('#user_id').val(),
                            }
                        })
                        .done(function(response) {
                            if (response.status == true) {
                                $('#tel-error').html('');
                                $('#phone-error').show();

                                $('#phone-error').addClass('error').html(response.fail).css("font-weight", "bold");
                                hasPhoneError = true;
                                enableDisableButton();
                            } else if (response.status == false) {
                                $('#tel-error').show();
                                $('#phone-error').html('');

                                hasPhoneError = false;
                                enableDisableButton();
                            }
                        });
                }
            } else {
                $('#tel-error').html('');
                $('#phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });
        /*
        intlTelInput
        */

        // Validate phone via Ajax
        $(document).ready(function() {
            $("input[name=phone]").on('blur keyup', function(e) {
                formattedPhone();
                if ($.trim($(this).val()) !== '') {
                    if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this)
                    .val()))) {
                        $('#tel-error').addClass('error').html(
                            'Please enter a valid International Phone Number.').css("font-weight",
                            "bold");
                        hasPhoneError = true;
                        enableDisableButton();
                        $('#phone-error').hide();
                    } else {
                        var phone = $(this).val().replace(/-|\s/g, ""); //replaces 'whitespaces', 'hyphens'
                        var phone = $(this).val().replace(/^0+/,
                        ""); //replaces (leading zero - for BD phone number)
                        var customer_id = $('#user_id').val();

                        var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
                        $.ajax({
                                url: duplicate_check_url,
                                method: "POST",
                                dataType: "json",
                                data: {
                                    'phone': phone,
                                    'carrier_code': pluginCarrierCode,
                                    '_token': token,
                                    'id': customer_id
                                }
                            })
                            .done(function(response) {
                                if (response.status == true) {
                                    if (phone.length == 0) {
                                        $('#phone-error').html('');
                                    } else {
                                        $('#phone-error').addClass('error').html(
                                            "The number has already been taken!").css("font-weight",
                                            "bold");
                                        hasPhoneError = true;
                                        enableDisableButton();
                                    }
                                } else if (response.status == false) {
                                    $('#phone-error').html('');
                                    hasPhoneError = false;
                                    enableDisableButton();
                                }
                            });
                        $('#tel-error').html('');
                        $('#phone-error').show();
                        hasPhoneError = false;
                        enableDisableButton();
                    }
                } else {
                    $('#tel-error').html('');
                    $('#phone-error').html('');
                    hasPhoneError = false;
                    enableDisableButton();
                }
            });
        });

        function formattedPhone() {
            if ($('#phone').val != '') {
                var p = $('#phone').intlTelInput("getNumber").replace(/-|\s/g, "");
                $("#formatted_phone").val(p);
            }
        }

        /**
         * [check submit button should be disabled or not]
         * @return {void}
         */
        function enableDisableButton() {
            if (!hasPhoneError && !hasEmailError) {
                $('form').find("button[type='submit']").prop('disabled', false);
            } else {
                $('form').find("button[type='submit']").prop('disabled', true);
            }
        }