'use strict';
$(document).on('click', '#payment-form-submit', function(){
    $('#payment-form').trigger('submit');
    $(this).prop('disabled', true);
    $('.spinner').removeClass('d-none');
})