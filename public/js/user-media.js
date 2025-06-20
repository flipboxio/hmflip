"use strict"

$('#ajax_upload').validate({
    rules: {
        'photos': {
            accept: "image/jpg,image/jpeg,image/png,image/gif"
        }
    },
    messages: {
    'photos': {
            accept: acceptPhotosText,
            }
    },
    errorElement : 'div',
    errorLabelContainer: '.errorTxt_p'
});

$(document).on('submit', 'form', function(e) {

        $("#up_button").attr("disabled", true);
        
        $(".spinner").removeClass('d-none');
        $("#up_button_txt").text(uploadText);
})