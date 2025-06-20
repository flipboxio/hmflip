jQuery.validator.addMethod("laxEmail", function(value, element) {
    return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
}, validEmailText );

$('#signup_form').validate({
    rules: {
        first_name: {
            required: true,
            maxlength: 255
        },
        last_name: {
            required: true,
            maxlength: 255
        },
        email: {
            required: true,
            maxlength: 255,
            laxEmail:true
        },

        password: {
            required: true,
            minlength: 6
        }
    }
});

$(document).on('blur keyup', '#email', function() {
    var emailError = '';
    $('#customerModalBtn').attr('disabled', false);
    var email      = $('#email').val();
    var _token     = $('input[name="_token"]').val();
    $('.error-tag').html('').hide();
    if(email != '') {
        $.ajax({
            url:checkUserURL,
            method:"POST",
            data:{email:email, _token:_token},
            success:function(result) {
                if (result == 'not_unique') {
                    $('#emailError').html('<label class="text-danger">'+emailExistText+'</label>');
                    $('#email').addClass('has-error');
                    $('#customerModalBtn').attr('disabled', 'disabled');
                } else {
                    $('#email').removeClass('has-error');
                    $('#emailError').html('');
                    $('#customerModalBtn').attr('disabled', false);
                }
            }
        })
    } else {
        $('#emailError').html('');
    }

});

$("#phone").intlTelInput({
    separateDialCode: true,
    nationalMode: true,
    preferredCountries: ["us"],
    autoPlaceholder: "polite",
    placeholderNumberType: "MOBILE",
    utilsScript: "../public/backend/js/intl-tel-input-13.0.0/build/js/utils.js"
});

var hasPhoneError = false;
var hasEmailError = false;

//jquery validation
$.validator.setDefaults({
    highlight: function(element) {
        $(element).parent('div').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parent('div').removeClass('has-error');
    },
    errorPlacement: function (error, element) {
        $('#emailError').html('').hide();
        error.insertAfter(element);
    }
});

var countryData = $("#phone").intlTelInput("getSelectedCountryData");
$('#default_country').val(countryData.iso2);
$('#carrier_code').val(countryData.dialCode);

$("#phone").on("countrychange", function(e, countryData)
{
    formattedPhone();

    // log(countryData);
    $('#default_country').val(countryData.iso2);
    $('#carrier_code').val(countryData.dialCode);

    if ($.trim($(this).val()) !== '') {
        //Invalid Number Validation - Add
        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
            $('#tel-error').addClass('error').html(validInternationalNumber).css("font-weight", "bold");
            hasPhoneError = true;
            enableDisableButton();
            $('#phone-error').hide();
        } else  {
            $('#tel-error').html('');

            $.ajax({
                method: "POST",
                url: duplicateNumberCheckURL,
                dataType: "json",
                cache: false,
                data: {
                    'phone': $.trim($(this).val()),
                    'carrier_code': $.trim(countryData.dialCode),
                    '_token': token,
                }
            })
            .done(function(response)
            {
                if (response.status == true) {
                    $('#tel-error').html('');
                    $('#phone-error').show();

                    $('#phone-error').addClass('error').html(response.fail).css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                } else if (response.status == false) {
                    $('#tel-error').show();
                    $('#phone-error').html('');

                    hasPhoneError = false;
                    enableDisableButton();
                }
            });
        }
    } else {
        $('#tel-error').html('');
        $('#phone-error').html('');
        hasPhoneError = false;
        enableDisableButton();
    }
});

$("input[name=phone]").on('blur keyup', function(e)
{
    formattedPhone();
    if ($.trim($(this).val()) !== '') {
        if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
            $('#tel-error').addClass('error').html(validInternationalNumber).css("font-weight", "bold");
            hasPhoneError = true;
            enableDisableButton();
            $('#phone-error').hide();
        } else {
            var phone = $(this).val().replace(/-|\s/g,""); //replaces 'whitespaces', 'hyphens'
            var phone = $(this).val().replace(/^0+/,"");  //replaces (leading zero - for BD phone number)
            var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
            $.ajax({
                url: duplicateNumberCheckURL,
                method: "POST",
                dataType: "json",
                data: {
                    'phone': phone,
                    'carrier_code': pluginCarrierCode,
                    '_token': token,
                }
            })
            .done(function(response)
            {
                if (response.status == true) {
                    if (phone.length == 0) {
                        $('#phone-error').html('');
                    } else {
                        $('#phone-error').addClass('error').html(response.fail).css("font-weight", "bold");
                        hasPhoneError = true;
                        enableDisableButton();
                    }
                } else if (response.status == false) {
                    $('#phone-error').html('');
                    hasPhoneError = false;
                    enableDisableButton();
                }
            });
            $('#tel-error').html('');
            $('#phone-error').show();
            hasPhoneError = false;
            enableDisableButton();
        }
    } else {
        $('#tel-error').html('');
        $('#phone-error').html('');
        hasPhoneError = false;
        enableDisableButton();
    }
});

function formattedPhone()
{
    if ($('#phone').val != '') {
        var p = $('#phone').intlTelInput("getNumber").replace(/-|\s/g,"");
        $("#formatted_phone").val(p);
    }
}

/**
* [check submit button should be disabled or not]
* @return {void}
*/
function enableDisableButton()
{
    if (!hasPhoneError && !hasEmailError) {
        $('form').find("button[type='button']").prop('disabled',false);
    } else {
        $('form').find("button[type='button']").prop('disabled',true);
    }
}

$('#add_pr').validate({
    rules: {
        map_address: {
            required: true
        },
        host_id: {
            required: true
        }
    }
});

function updateControls(addressComponents) {

    $('#street_number').val(addressComponents.streetNumber);
    $('#route').val(addressComponents.streetName);

    if (typeof(addressComponents.city)!== 'undefined') {
        $('#city').val(addressComponents.city);
    } else {
      $('#city').val(addressComponents.stateOrProvince);
    }
    $('#state').val(addressComponents.stateOrProvince);
    $('#postal_code').val(addressComponents.postalCode);
    $('#country').val(addressComponents.country);
    if( typeof(addressComponents.city) !== 'undefined' && addressComponents.country !== 'undefined' && typeof(addressComponents.city) !== null && addressComponents.country !== null && typeof(addressComponents.city) !== '' && addressComponents.country !== ''){
        $('#map_address').val(addressComponents.city + ',' + addressComponents.country_fullname);
    } else {
       if (addressComponents.stateOrProvince != '' && addressComponents.country_fullname != '') {
          $('#map_address').val(addressComponents.stateOrProvince + ',' + addressComponents.country_fullname);
       }
    }

}

$('#us3').locationpicker({
    location: {
        latitude: 0,
        longitude: 0
    },
    radius: 0,
    addressFormat: "",
    inputBinding: {
        latitudeInput: $('#latitude'),
        longitudeInput: $('#longitude'),
        locationNameInput: $('#map_address')
    },
    enableAutocomplete: true,
    onchanged: function (currentLocation, radius, isMarkerDropped) {
        var addressComponents = $(this).locationpicker('map').location.addressComponents;
        updateControls(addressComponents);
    },
    oninitialized: function (component) {
        var addressComponents = $(component).locationpicker('map').location.addressComponents;
        updateControls(addressComponents);
    }
});

var customerBtn = $( window ).width();
if(customerBtn <768) {
    $('#respo').css("margin-bottom","7px");
}
$('#customerModal').on('hidden.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
    $('#signup_form').validate().resetForm();
    $('#signup_form').find('.error').removeClass('error');
    $('#signup_form').find('#error_msg').hide();
});

$('#signup_form').on('submit', function(e) {
    e.preventDefault();
    var first_name      = $('#first_name').val();
    var last_name       = $('#last_name').val();
    var email           = $('#email').val();
    var phone           = $('#phone').val();
    var carrier_code    = $('#carrier_code').val();
    var formatted_phone = $('#formatted_phone').val();
    var default_country = $('#default_country').val();
    var password        = $('#password').val();
    var status          = $('#status').val();
    var token           = $('input[name="_token"]').val();
    if (first_name && last_name && email) {
        $.ajax({
            url:$(this).attr('action'),
            type:'POST',
            data:{
                'first_name':first_name,
                'last_name':last_name,
                'email':email,
                'password':password,
                'status':status,
                'phone':phone,
                'carrier_code':carrier_code,
                'formatted_phone':formatted_phone,
                'default_country':default_country,
                '_token':token
            },
            dataType:'JSON'
        })
        .done(function(response) {
            if (response.status == 1) {
            $('#customerModal').modal('hide');
            $('#host_id').append('<option data-icon-class="icon-star-alt" value="' + response.user.id + '" selected = "selected">' + response.user.first_name + ' ' + response.user.last_name + '</option>');
            $('#signup_form')[0].reset();
            }
        })
        .fail(function(error) {
        });
    } else {
        $('#signup_form').submit();
    }
});

