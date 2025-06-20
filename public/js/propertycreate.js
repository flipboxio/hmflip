"use strict"
function updateControls(addressComponents) {
    $('#street_number').val(addressComponents.streetNumber);
    $('#route').val(addressComponents.streetName);
    $('#city').val(addressComponents.city);
    $('#state').val(addressComponents.stateOrProvince);
    $('#postal_code').val(addressComponents.postalCode);
    $('#country').val(addressComponents.country);

    if (typeof(addressComponents.city)!== 'undefined') {
        $('#city').val(addressComponents.city);
    } else {
            $('#city').val(addressComponents.stateOrProvince); 
    }
    
    $('#state').val(addressComponents.stateOrProvince);
    $('#postal_code').val(addressComponents.postalCode);
    $('#country').val(addressComponents.country);
    if ( typeof(addressComponents.city) !== 'undefined' && addressComponents.country !== 'undefined' && typeof(addressComponents.city) !== null && addressComponents.country !== null && typeof(addressComponents.city) !== '' && addressComponents.country !== '') {
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

$('#list_space').validate({
    rules: {
        property_type_id: {
            required: true
        },
        space_type: {
            required: true
        },
        accommodates: {
            required: true
        },
        map_address: {
            required: true
        }
    },
    submitHandler: function(form)
    {
        $("#btn_next").on("click", function (e)
        {
            $("#btn_next").attr("disabled", true);
            e.preventDefault();
        });

        $(".spinner").removeClass('d-none');
        $("#btn_next-text").text(continueText);
        return true;
    },
    messages: {
        property_type_id: {
            required:  fieldRequiredText,
        },
        space_type: {
            required: fieldRequiredText,
        },
        accommodates: {
            required:  fieldRequiredText,
        },
        map_address: {
            required:  fieldRequiredText,
        },
    }
});
