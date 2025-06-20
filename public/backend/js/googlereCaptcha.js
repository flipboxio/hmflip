'use strict';

if(selectedRecaptchaPlace == '') {
    $("#recaptcha_preference").select2({
        placeholder: recaptchaPlaceholder,
        allowClear: true
    });
} else {

    let preference_place = selectedRecaptchaPlace.split(',');

    $("#recaptcha_preference").select2({
        placeholder: recaptchaPlaceholder,
        allowClear: true
    }).select2().val(preference_place).trigger("change");
}


if(selectedRecaptchaPlace == 'disable') {
    $('.recaptcha_preference').prop('multiple', false).attr('name', 'recaptcha_preference').select2();
    $('.recaptcha_preference').val('disable');
}

function isStoredKeySecret()
{
    if (reCaptchaKey == '' || reCaptchaSecret == '') {
        $('.recaptchaError').html(errorText + '<a class ="" href ="' + reCaptchaURL + '">' + hereText + '</a>');
    }
}

$(document).on('change', '#recaptcha_preference', function() {
    var places = $(this).val();

    
    if(typeof(places) != 'string') {

        $.each($(this).val(), function(key, value) {

            if (value == 'disable') {

                $('.recaptcha_preference').prop('multiple', false).attr('name', 'recaptcha_preference').select2();
                $('.recaptcha_preference').val('disable');
                $('.recaptchaError').text('');

                return false;

            } else {

                isStoredKeySecret();
            }
        });
    } else {
        if (places != 'disable') {

            isStoredKeySecret();
            $('.recaptcha_preference').prop('multiple', true).attr('name', 'recaptcha_preference[]').select2();  

        }
    }
    
})

$(document).on('click', '.reCaptcha_submit', function(){
    $('#google_recaptcha_api_credentials').submit();
    $(this).prop('disabled', true);
})