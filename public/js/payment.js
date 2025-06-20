"use strict"
$(document).ready(function() {
    $('#checkout-form').validate({
        submitHandler: function(form)
        {
 			$("#payment-form-submit").on("click", function (e)
            {
            	$("#payment-form-submit").attr("disabled", true);
                e.preventDefault();
            });


            $(".spinner").removeClass('d-none');
            return true;
        }
    });

    $('#payment-method-select').on('change', function(){
        var payment = $(this).val();
        if (payment !== 'paypal'){
            $('.paypal-div').addClass('display-off')
        } else {
            $('.paypal-div').removeClass('display-off')
        }
      });

      $('#country-select').on('change', function() {
        var country = $(this).find('option:selected').text();
        $('#country-name-set').html(country);
      })
});