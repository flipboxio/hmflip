"use strict"

$(document).on('click', '#withdraw_submit', function(){
    var dataURL = APP_URL+'/withdraws';
    var amount = $('#amount').val();
       if(amount == '0' || amount =="") $('#error-message').html(notEnoughAmount);
    else{
        $.ajax({
            url: dataURL,
            data: {
                "_token": token,
                'amount': amount,
            },
            type: 'post',
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    window.location.href = withdrawURL;
                } else {
                    $('#error-message').html(res.message);
                }
            },
            error: function (request, error) {

            }
        });
    }
});