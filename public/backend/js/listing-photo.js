"use strict"
$(document).on('submit', '#photo-form', function (e) {
    e.preventDefault();
    $('#photo').hide();
    var form_data = new FormData(this);
    var photo_file = $('#photo_file').val();
    if (photo_file != '') {
        // page_loader_start();
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
                    var photo_url = '{{ url("images/rooms/$result->id") }}' + '/' + result.photo_name;
                    var photo_div = '<div class="col-md-4 margin-top10" id="photo-div-' + result.photo_id + '">'
                        + '<div class="room-image-container200" style="background-image:url(' + photo_url + ');">'
                        + '<a class="photo-delete" href="#" data-rel="' + result.photo_id + '"><p class="photo-delete-icon"><i class="fa fa-trash-o"></i></p></a>'
                        + '</div>'
                        + '<div class="margin-top5">'
                        + '<textarea data-rel="' + result.photo_id + '" class="form-control f-14 photo-highlights" placeholder="' + highlightsPhotoText + '"></textarea>'
                        + '</div>'
                        + '</div>';
                    $('#photo-list-div').append(photo_div);
                } else
                    $('#photo').show();

            },
            error: function (request, error) {
                // This callback function will trigger on unsuccessful action
                show_error_message(networkErrorText);
            }
        });
        $('#photo_file').val('');
        page_loader_stop();
    }
});

$(document).on('click', '.photo-delete', function (e) {
    e.preventDefault();
    gl_photo_id = $(this).attr('data-rel');
    var con = bootbox.confirm(areYouSureText, location_image_upload);
});

$(document).on('focusout', '.photo-highlights', function (e) {
    var dataURL = photoMessageURL;
    var photo_id = $(this).attr('data-rel');
    var messages = $(this).val();
    $.ajax({
        url: dataURL,
        data: {'photo_id': photo_id, 'messages': messages, '_token': token},
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

function location_image_upload(result) {
    if (result) {
        var photo_id = gl_photo_id;

        //page_loader_start();
        $.ajax({
            url: photoDeleteURL,
            data: {'photo_id': photo_id, '_token': token},
            type: 'post',
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $('#photo-div-' + photo_id).remove();
                }
            },
            error: function (request, error) {
                // This callback function will trigger on unsuccessful action
            }
        });
        //page_loader_stop();
    }
}


$(document).on('change', '.photoId', function (ev) {
    // alert('ok');
    var dataURL = makeDefaultPhotoURL;
    var option_value = $(this).val();
    var photo_id = $('option:selected', this).attr('image_id');
    var property_id = $('option:selected', this).attr('property_id');

    $.ajax({
        url: dataURL,
        data: {
            'photo_id': photo_id,
            'property_id': property_id,
            'option_value': option_value,
            '_token': token
        },
        type: 'post',
        dataType: 'json',
        success: function (result) {
            location.reload();
        }
    });


});

$(document).on('change', '.serial', function (ev) {
    var dataURL = makePhotoSerialURL;
    var serial = $(this).val();
    var id = $(this).attr('image_id');

    $.ajax({
        url: dataURL,
        data: {'id': id, 'serial': serial, '_token': token},
        type: 'post',
        dataType: 'json',
        success: function (result) {
            location.reload();
        }
    });

});


$('#photo_file').on('change', function () {
    $("#crop-modal").modal('show');
    var canvas = $("#canvas"),
        context = canvas.get(0).getContext("2d"),
        result = $('#result img');
    let name = this.files[0].name;
    if (this.files && this.files[0]) {
        if (this.files[0].type.match(/^image\//)) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                var img = new Image();
                img.onload = function () {
                    context.canvas.height = img.height;
                    context.canvas.width = img.width;
                    context.drawImage(img, 0, 0);
                    var cropper = canvas.cropper({});

                    $(document).on('click', '#crop', function() {
                        // Get a string base 64 data url
                        var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
                        result.attr('src', croppedImageDataURL);
                        $('#result').toggleClass('hide');
                        $('#photo').val(croppedImageDataURL);
                        $('#img_name').val(name);
                        $('#type').val('crop');
                        canvas.cropper('destroy');
                        $("#crop-modal").modal('toggle');
                        $("#submit").click();

                    });

                    $(document).on('click', '#restore', function() {
                        canvas.cropper('destroy');
                        result.empty();
                        $('#type').val('original');
                        $("#submit").click();
                    });
                };
                img.src = evt.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            alert("Invalid file type! Please select an image file.");
        }
    } else {
        alert('No file(s) selected.');
    }
});
