    "use strict"
    $('select').on('change', function() {
        var dobError = '';
        var day = document.getElementById("user_birthday_day").value;
        var month = document.getElementById("user_birthday_month").value;
        var y = document.getElementById("user_birthday_year").value;
        var year = parseInt(y);
        var year2 = profile_update.birthday_year;
        var age = 18;
        var setDate = new Date(year + age, month - 1, day);
        var currdate = new Date();
        if (day == '' || month == '' || y == '') {
            $('#dobError').html('<label class="text-danger">' + fieldRequire + '</label>');
            year2.focus();
            return false;
        }

        else if (setDate > currdate) {
            $('#dobError').html('<label class="text-danger">' + ageGreater + '</label>');
            year2.focus();
            return false;
        } else {
            $('#dobError').html('<span class="text-success"></span>');
            return true;
        }
    });

    function ageValidate() {
        var dobError = '';
        var day = document.getElementById("user_birthday_month").value;
        var month = document.getElementById("user_birthday_day").value;
        var y = document.getElementById("user_birthday_year").value;
        var year = parseInt(y);
        var year2 = profile_update.birthday_year;
        var age = 18;

        var setDate = new Date(year + age, month - 1, day);
        var currdate = new Date();
        if (day == '' || month == '' || y == '') {
            $('#dobError').html('<label class="text-danger">' + fieldRequire + '</label>');
            year2.focus();
            return false;
        }
        else if (setDate > currdate) {
            $('#dobError').html('<label class="text-danger">' + ageGreater + '</label>');
            year2.focus();
            return false;
        } else {
            $('#dobError').html('<span class="text-success"></span>');
            return true;
        }
    }

    jQuery.validator.addMethod("laxEmail", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, email);

    $(document).ready(function() {
        $('#profile_update').validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 255
                },
                last_name: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    laxEmail: true
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
                $("#save_btn-text").text(saving);
                return true;
            },
            messages: {
                first_name: {
                    required: fieldRequire,
                    maxlength: maxCharacter,
                },
                last_name: {
                    required: fieldRequire,
                    maxlength: maxCharacter,
                },
                email: {
                    required: fieldRequire,
                    maxlength: maxCharacter,
                },
                phone: {
                    required: fieldRequire,
                    maxlength: maxCharacter,
                },
            }
        });
    });

  // flag for button disable/enable
    var hasPhoneError = false;
    var hasEmailError = false;

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
    $(document).ready(function() {
        $("#phone").intlTelInput({
            separateDialCode: true,
            nationalMode: true,
            preferredCountries: ["us"],
            autoPlaceholder: "polite",
            placeholderNumberType: "MOBILE",
            utilsScript: APP_URL+'/public/js/intl-tel-input-13.0.0/build/js/utils.js'
        });

        var countryData = $("#phone").intlTelInput("getSelectedCountryData");
        $('#default_country').val(countryData.iso2);
        $('#carrier_code').val(countryData.dialCode);

        $("#phone").on("countrychange", function(e, countryData) {
            formattedPhone();
            $('#default_country').val(countryData.iso2);
            $('#carrier_code').val(countryData.dialCode);
            if ($.trim($(this).val()) !== '') {
                //Invalid Number Validation - Add
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html(validInternationalNumber).css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#phone-error').hide();
                } else {
                    $('#tel-error').html('');

                    $.ajax({
                            method: "POST",
                            url: duplicateNumberCheckURL,
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
    });
    /*
    intlTelInput
    */

  // Validate phone via Ajax
    $(document).ready(function() {
        $("input[name=phone]").on('blur keyup', function(e) {
            formattedPhone();
            if ($.trim($(this).val()) !== '') {
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html(validInternationalNumber).css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#phone-error').hide();
                } else {
                    var phone = $(this).val().replace(/-|\s/g, ""); //replaces 'whitespaces', 'hyphens'
                    var phone = $(this).val().replace(/^0+/, ""); //replaces (leading zero - for BD phone number)
                    var customer_id = $('#user_id').val();

                    var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
                    $.ajax({
                            url: duplicateNumberCheckURL,
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
                                    $('#phone-error').addClass('error').html(numberExists).css("font-weight", "bold");
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

    $("#profile-review-count").on('click', function(e){
		e.preventDefault()
		$('html,body').animate({
			scrollTop: $("#profile-review-title").offset().top},
			'slow');
	});