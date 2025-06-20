"use strict"

$(document).on('submit', 'form', function() {
    $('button').attr('disabled', 'disabled');
});

$('#smsform').validate({
    rules: {
        phone: {
            required: true
        },
        twilio_sid: {
            required: true
        },
        twilio_token: {
            required: true
        },
        defaults: {
            required: true
        },
        status: {
            required: true
        }
    }
});

$.validator.setDefaults({
    highlight: function(element) {
        $(element).parent('div').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parent('div').removeClass('has-error');
    },
    errorPlacement: function(error, element) {
        $('#tel-error').html(' ').hide();
        error.insertAfter(element);

    }
});

$("#phone").intlTelInput({
    separateDialCode: true,
    nationalMode: true,
    preferredCountries: ["us"],
    autoPlaceholder: "polite",
    placeholderNumberType: "MOBILE",
    utilsScript: utilsScript
});

$('#default_country').val(countryData.iso2);
$('#carrier_code').val(countryData.dialCode);

$("#phone").on("countrychange", function(e, countryData) {
    formattedPhone();


    $('#default_country').val(countryData.iso2);
    $('#carrier_code').val(countryData.dialCode);

    if ($.trim($(this).val()) !== '') {
        //Invalid Number Validation - Add
        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this)
        .val()))) {
            $('#tel-error').addClass('error').html(validNumberText).css("font-weight", "bold");
            $('#tel-error').show();
            $('#phone-error').hide();
        } else {
            $('#phone-error').html('').show();
            $('#tel-error').hide();

        }
    } else {
        $('#tel-error').hide();

    }
});

$("input[name=phone]").on('blur keyup', function(e) {
    formattedPhone();
    $('#submitBtn').attr('disabled', false);
    if ($.trim($(this).val()) !== '') {
        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
            $('#tel-error').addClass('error').html(validNumberText).css("font-weight", "bold");
            $('#submitBtn').attr('disabled', 'disabled');

            $('#tel-error').show();
            $('#phone-error').hide();
        } else {

            $('#phone-error').show();
            $('#tel-error').hide();

        }
    } else {
        $('#tel-error').hide();

    }
});

function formattedPhone() {
    if ($('#phone').val != '') {
        var p = $('#phone').intlTelInput("getNumber").replace(/-|\s/g, "");
        $("#formatted_phone").val(p);
    }
}