$(document).on('submit', '#payment-form', function(){

    $('#paytr-button').prop('disabled', true);
    $(".spinner").removeClass('d-none')
})