"use strict"

$(".cht_msg").on('keyup', function(event) {
    if (event.which === 13) {
        $('.chat').trigger("click");
    }
});