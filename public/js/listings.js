"use strict"
   
    
if(page == 'basics') {
    //Basic
    $('#listing_bes').validate({
        submitHandler: function(form)
        {
            $("#btn_next").on("click", function (e)
            {
                $("#btn_next").attr("disabled", true);
                e.preventDefault();
            });


            $(".spinner").removeClass('d-none');
            $("#btn_next-text").text(nextText);
            return true;
        }
    });
} else if(page == 'description') {
    //Description
    $('#list_des').validate({
        rules: {
            name: {
                required: true
            },
            summary: {
                required: true,
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
            $("#btn_next-text").text(nextText);
            return true;
        },
        messages: {
            name: {
                required: fieldRequiredText,
            },
            summary: {
                required:  fieldRequiredText,
                maxlength: maxlengthText,
            }
        }
    });
} else if(page == 'details') {
    //Details
    $('#listing_det').validate({
        submitHandler: function(form)
        {
            $("#btn_next").on("click", function (e)
            {
                $("#btn_next").attr("disabled", true);
                e.preventDefault();
            });

            $(".spinner").removeClass('d-none');
            $("#btn_next-text").text(nextText);
            return true;
        }
    });
 } else if(page == 'location') {
    //Location
    function updateControls(addressComponents) {

        $('#street_number').val(addressComponents.streetNumber);
        $('#route').val(addressComponents.streetName);
        if (addressComponents.city) {
            $('#city').val(addressComponents.city);
        }
        $('#state').val(addressComponents.stateOrProvince);
        $('#postal_code').val(addressComponents.postalCode);
        $('#country').val(addressComponents.country);
    }
    $('#map_view').locationpicker({
        location: {
            latitude: latitude,
            longitude: longitude
        },
        radius: 0,
        addressFormat: "",
        inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude'),
            locationNameInput: $('#address_line_1')
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
    $('#lis_location').validate({
        rules: {
            address_line_1: {
                required: true,
                maxlength: 255
            },
            address_line_2: {
                maxlength: 255
            },
            city: {
                required: true
            },
            state: {
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
            $("#btn_next-text").text(nextText);
            return true;
        },
        messages: {
            'amenities[]': {
                required: fieldRequiredText,
            }
        },
        messages: {
            address_line_1: {
                required:  fieldRequiredText,
                maxlength: maxlengthText,
                },
            address_line_2: {
                required:  fieldRequiredText,
                maxlength: maxlengthText,
                },
            city: {
                required: fieldRequiredText,
            },
            state: {
                required: fieldRequiredText,
            }
        }
    });

 } else if (page == 'amenities') {
    // Amenities
    $(document).on('click', '#btn_next', function(e){

        $(".spinner").removeClass('d-none');
        $("#btn_next-text").text(nextText);

        $("#btn_next").attr("disabled", true);
        e.preventDefault();

        let checkboxs = $("[name='amenities[]']");
        let values = [];

        let commom_amenities = 0;
        let other_amenities  = 0;

        let type_id = $("#amenity_type_id").val();

        jQuery.each( checkboxs, function(checkbox) {

            if ($(this).is(':checked')) {
                values.push($(this).attr('data-saving'));
            }

        });

        $.each(values, function(index, value) {
            if (value == type_id) {
                commom_amenities++;
            } else {
                other_amenities++;
            }
        });


        if ( commom_amenities >= 1 ) {
            $('#amenities_id').submit();
        } else {

            $("#at_least_one").css("color", "red");
            $("#at_least_one").css("padding-top", "0.625rem");
            $("#at_least_one").html(mendatoryAmenitiesText);
            $("#at_least_one").css("fontSize", "14px");

            $(".spinner").addClass('d-none');
            $("#btn_next-text").text(next);

            $("#btn_next").attr("disabled", false);
            e.preventDefault();

            $("html,body").animate({
                scrollTop:$('#at_least_one').offset().top-700
            }, 1000);

        }

    });
} else if (page == 'photos') {
    // Photos
    $(document).on('submit', '#photo-form', function(e){
        e.preventDefault();
        $('#photo').hide();
        
        var form_data = new FormData(this);
        var photo_file = $('#photo_file').val();
        if (photo_file != ''){
            $.ajax({
            url: photoUploadURL,
            data: {
                form_data,
                '_token': token
            },
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.status) {
                    var photo_div = '<div class="col-md-4 margin-top10" id="photo-div-'+result.photo_id+'">'
                    +'<div class="room-image-container200" style="background-image:url('+photoRoomURl+'/'+result.photo_name+');">'
                    +'<a class="photo-delete" href="#" data-rel="'+result.photo_id+'"><p class="photo-delete-icon"><i class="fa fa-trash-o"></i></p></a>'
                    +'</div>'
                    +'<div class="margin-top5">'
                    +'<textarea data-rel="'+result.photo_id+'" class="form-control photo-highlights" placeholder="'+highlightsPhotoText+'"></textarea>'
                    +'</div>'
                    +'</div>';
                    $('#photo-list-div').append(photo_div);
                }
                else
                $('#photo').show();

            },
            error: function (request, error) {
                // This callback function will trigger on unsuccessful action
                show_error_message(networkErrorText);
                }
            });
            $('#photo_file').val('');
        }
    });
    
    $(document).on('focusout', '.photo-highlights', function(e){
        var photo_id = $(this).attr('data-rel');
        var messages = $(this).val();
        $.ajax({
            url: photoMessageURL,
            data: {'photo_id':photo_id, 'messages':messages, '_token': token},
            type: 'post',
            dataType: 'json',
            success: function (result) {
            },
            error: function (request, error) {
                // This callback function will trigger on unsuccessful action
                show_error_message(networkErrorText);
            }
        });
    })

    $(document).on('click', '.photo-delete', function(e){
        gl_photo_id = $(this).attr('data-rel');
        event.preventDefault();
        swal({
            title: areYouSureText,
            text: deleteForeverText,
            icon: "warning",
            buttons: {
                cancel: {
                    text: cancelText,
                    value: null,
                    visible: true,
                    className: "btn btn-outline-danger text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5",
                    closeModal: true,
                },
                confirm: {
                    text: okText,
                    value: true,
                    visible: true,
                    className: "btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5",
                    closeModal: true
                }
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var dataURL  = photoDeleteURL;
                var photo_id = gl_photo_id;
                $.ajax({
                    url: dataURL,
                    data: {'photo_id':photo_id, '_token': token},
                    type: 'post',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success){
                            $('#photo-div-'+photo_id).remove();
                            swal({
                              icon: "success",
                              buttons: {
                                    confirm: {
                                        text: deletedText,
                                        value: true,
                                        visible: true,
                                        className: "btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5",
                                        closeModal: true
                                    }
                                },
                            });
                        }
                    },
                    error: function (request, error) {
                        show_error_message(request.statusText);
                    }
                });
            }
        });
    });

    $(document).on('change', '#photoId', function(ev){
        var option_value = $(this).val();
        var photo_id     = $('option:selected', this).attr('image_id');
        var property_id  = $('option:selected', this).attr('property_id');
        $.ajax({
            url: makeDefaultPhotoURL,
            data: {'photo_id':photo_id, 'property_id':property_id, 'option_value':option_value, '_token': token},
            type: 'post',
            dataType: 'json',
            success: function (result) {
            location.reload();
            }
        });
    });

    $(document).on('change', '.serial', function(ev){
				
        var serial = $(this).val();
        var id     = $(this).attr('image_id');

        $.ajax({
                url: makePhotoSerialURL,
                data: {'id':id, 'serial':serial, '_token': token},
                type: 'post',
                dataType: 'json',
                success: function (result) {
                location.reload();
            }
        });
    });

    $('#img_form').validate({
        rules: {
            'photos[]': {
                required:true,
                accept: "image/jpg,image/jpeg,image/png,image/gif,image/JPG"
            }
        },
        submitHandler: function(form)
        {
            $("#up_button").on("click", function (e)
            {
                $("#up_button").attr("disabled", true);
                e.preventDefault();
            });

            $("#up_spin").removeClass('d-none');
            $("#up_button_txt").text(uploadText);
            return true;
        },
        messages: {
            'photos[]': {
                accept: imageMendatoryTypeText,
            }
        }
    });

    $(document).on('click', '#btnnext', function() {
        $(this).addClass('disabled');
        $("#btn_spin").removeClass('d-none');
        $("#btnnext-text").text(nextText);

    });

    $('#photo_file').on('change', function() {
        var canvas  = $("#canvas"),
            context = canvas.get(0).getContext("2d"),
            result = $('#result img');
        let name = this.files[0].name;
        if (this.files && this.files[0]) {
            if ( this.files[0].type.match(/^image\//) ) {
                $(".crop-modal").modal('toggle');
                var reader = new FileReader();
                reader.onload = function(evt) {
                    var img = new Image();
                    img.onload = function() {
                        context.canvas.height = img.height;
                        context.canvas.width  = img.width;
                        context.drawImage(img, 0, 0);
                        $('#img_name').val(name);
                        var cropper = canvas.cropper({
                        });

                        $(document).on('click', '#crop', function() {
                            var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
                            result.attr('src', croppedImageDataURL);
                            $('#result').show();
                            $('#photo').val(croppedImageDataURL);
                            $('#type').val('crop');
                            canvas.cropper('destroy');
                            $(".crop-modal").modal('toggle');
                            $("#up_button").click();

                        });

                        $(document).on('click', '#restore', function() {
                            canvas.cropper('destroy');
                            result.empty();
                            $('#type').val('original');
                            $("#up_button").click();
                        });
                    };
                    img.src = evt.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
            else {
                show_error_message(invalidImagetypeText);
            }
        }
        else {
            show_error_message(noFileSelectedText);
        }
    });

    function show_error_message(msg) {
        $('#notice').show();
        $('#notice span').html(msg);

    }

} else if (page == 'pricing') {

    $(document).on('change', '.pricing_checkbox', function() {
        if (this.checked){
            var name = $(this).attr('data-rel');
            $('#'+name).show();
        } else {
            var name = $(this).attr('data-rel');
            $('#'+name).hide();
            $('#price-'+name).val(0);
        }
    });

    $(document).on('click', '#show_long_term', function(){
        $('#js-set-long-term-prices').hide();
        $('#long-term-div').show();
    });

    $(document).on('change', '#price-select-currency_code', function(){
        var currency = $(this).val();

        $.ajax({
            url: currencySymbolURL,
            data: {
                    "_token": token,
                    'currency': currency
                },
            type: 'post',
            dataType: 'json',
            success: function (result) {
                if (result.success == 1)
                    $('.pay-currency').html(result.symbol);
            },
            error: function (request, error) {
                // This callback function will trigger on unsuccessful action
            }
        });
    });

    $('#lis_pricing').validate({
        rules: {
            price: {
                required: true,
                number: true,
                min: 5
            },
            weekly_discount: {
                number: true,
                max: 99,
                min: 0
            },
            monthly_discount: {
                number: true,
                max: 99,
                min: 0
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "price") {
                error.appendTo("#price-error");
            } else {
                error.insertAfter(element)
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
            $("#btn_next-text").text(nextText);
            return true;
        },
        messages: {
            price: {
                required:  fieldRequiredText,
                number: validNumberText,
                min: priceMinValue,
            },
            weekly_discount: {
                number: validNumberText,
                max: discountsMaxValue,
                min: discountsMinValue,
            },
            monthly_discount: {
                number: validNumberText,
                max: discountsMaxValue,
                min: discountsMinValue,
            }
        }
    });
} else if (page == 'booking') {
    // Booking
    $('#booking_id').validate({
        rules: {
            booking_type: {
                required: true,
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
            $("#btn_next-text").text(nextText);
            return true;
        },
        messages: {
            booking_type: {
                required:  fieldRequiredText,
            }
        }
    });
} else if (page == 'calendar') {
    // Calendar
    $(document).on('click', '#cal_sync', function() {
		$(this).addClass('disabled');
		$("#cal_sync_spinner").removeClass('d-none');
	});

	$(document).on('click', '#btn_next', function() {
		$(this).addClass('disabled');
        $("#btn_next_spinner").removeClass('d-none');
        $("#btn_next-text").text(nextText);

	});

	$('#icalendar_form').validate({
			rules: {
				url: {
					required: true,
					maxlength: 255,
				},
				name: {
					required:true,
					maxlength:255,
				}
	        },
	        submitHandler: function(form)
	        {
	            $("#import_btn").on("click", function (e)
                {
                	$("#import_btn").attr("disabled", true);
                    e.preventDefault();
                });

	            $("#import_spinner").removeClass('d-none');
	            $("#import_btn-text").text(importCalendarText);
	            return true;

	        },
		    messages: {
	            url: {
	                required:  fieldRequiredText,
	                minlength: minLengthText,
	            },

	            name: {
	                required:  fieldRequiredText,
	                minlength: minLengthText,
	            }
	        }
	    });
}
    
    
    
