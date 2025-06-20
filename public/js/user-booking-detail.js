"use strict"
$(document).on('click','#decline_submit',function(){
	var optVal    = $('#decline_reason').val();
	if (optVal == ' '){

		$('.errorMessage').html(fieldRequired);
		return false;
		
	} else if (optVal == 'other') {
		var decline_reason = $('#decline_reason_other').val();

		if (decline_reason == '') {
			$('.decline_reason_other').html();
			return false;
		} else {
			return true;
		}
	}
});

$(document).on('click','#accept_submit',function(){
    if ($("#tos_confirm").prop('checked') == true){
        return true;
    } else {
        alert(acceptTermText);
    return false;
    }
});

$(document).ready(function () {
    $('#accept_reservation_form').validate({
        rules: {
            tos_confirm: {
                required: true
            }
        },
        submitHandler: function(form)
        {
            $("#accept_submit").on("click", function (e)
            {
                $("#accept_submit").attr("disabled", true);
                e.preventDefault();
            });

            $("#accept_spinner").removeClass('d-none');
            $("#accept_btn-text").text(accept);
            return true;

        },
        messages: {
            tos_confirm: {
                required:  fieldRequired,
            }
        }
    });

    $('#decline_reservation_form').validate({
        rules: {
            decline_reason: {
                required: true
            }
        },
        submitHandler: function(form)
        {
            $("#decline_submit").on("click", function (e)
            {
                $("#decline_submit").attr("disabled", true);
                e.preventDefault();
            });

            $("#decline_spinner").removeClass('d-none');
            $("#decline_btn-text").text(decline);
            return true;

        },
        messages: {
            decline_reason: {
                required:  fieldRequired,
            }
        }
    });
});