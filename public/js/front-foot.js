"use strict"
$(".currency_footer").on('click', function() {
    var currency = $(this).data('curr');
        $.ajax({
            type: "POST",
            url: APP_URL + "/set_session",
            data: {
                "_token": token,
                'currency': currency
                },
            success: function(msg) {
                location.reload()
            },
    });
});

$(".language_footer").on('click', function() {
    var language = $(this).data('lang');
    $.ajax({
        type: "POST",
        url: APP_URL + "/set_session",
        data: {
                "_token": token,
                'language': language
            },
        success: function(msg) {
            location.reload()
        },
    });
});