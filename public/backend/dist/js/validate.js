"use strict";
$(document).ready(function () {

    if (typeof message == 'undifined') {
        var message = '';
        var message_ico = '';
    }
    $('#edit_meta').validate({
        rules: {
            url: {
                required: true
            },
            title: {
                required: true
            },
            description: {
                required: true
            }
        }
    });


    $(document).on('submit', '#msg_reply', function() {
        $('#reply_message').attr('disabled', 'disabled');
    });


    $('#msg_reply').validate({
        rules: {
            message: {
                required: true,
            },
        }
    });

    $(document).on('submit', '#send_email', function() {
        $('button').attr('disabled', 'disabled');
    });

    $('#send_email').validate({
        rules: {
            content: {
                required: true,
            }
        }
    });

    $('#add_language').validate({
        rules: {
            name: {
                required: true
            },
            short_name: {
                required: true
            }
        }
    });
    
    $('#edit_language').validate({
        rules: {
            name: {
                required: true
            },
            short_name: {
                required: true
            }
        }
    });

    $('#edit_payout').validate({
        rules: {
           amount: { 
                    required:true,
                    digits:true
                }
         
            }
    });

    $('#add_page').validate({
        ignore: [],
        rules: {
            name: {
                required: true
            },
            url: {
                required: true
            },
            content: {

                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                    return editorcontent.length === 0;
                }
            }
        },
        errorPlacement: function(error, element) {
            if (element.prop('type') === 'textarea') {
                $('#content-validation-error').html(error);
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('#edit_page').validate({
        ignore: [],
        rules: {
            name: {
                required: true
            },
            url: {
                required: true
            },
            content: {

                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                    return editorcontent.length === 0;
                }
            }
        },
        errorPlacement: function(error, element) {
            if (element.prop('type') === 'textarea') {
                $('#content-validation-error').html(error);
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $('#rev_form').validate({
        rules: {
            message: {
                required: true
            }
         
        }
    });

    $('#edit_role').validate({
        rules: {
            name: {
                required: true
            },
            display_name: {
                required: true
            },
            description: {
                required: true
            },
            "permission[]": {
              required: true,
              minlength: 1
            },
        },
        messages: {
          "permission[]": {
            required: message,
          },
        },
    });

    $('#add_role').validate({
        rules: {
            name: {
                required: true
            },
            display_name: {
                required: true
            },
            description: {
                required: true
            },
            "permission[]": {
              required: true,
              minlength: 1
            },

        },
        messages: {
          "permission[]": {
            required: message,
          },
        },
    });

    $('#add_amen').validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            symbol: {
                required: true
            }
        }
    });

    $('#edit_amen').validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            symbol: {
                required: true
            }
        }
    });

    $('#add_amenity').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            }
        }
    });

    $('#amenity_type').validate({
        rules: {
            name: {
                required: true,
            },
            description: {
                required: true,
            }
        }
    });

    $('#add_currency').validate({
        rules: {
            name: {
                required: true
            },
            code: {
                required: true
            },
            symbol: {
                required: true
            },
            rate: {
                required: true
            }
        }
    });

    $('#edit_currency').validate({
        rules: {
            name: {
                required: true
            },
            code: {
                required: true
            },
            symbol: {
                required: true
            },
            rate: {
                required: true
            }
        }
    });

    $('#add_city').validate({
        rules: {
            name: {
                required: true
            },
            image: {
                required: true,
                accept: "image/jpg,image/jpeg,image/png"
            }
        },
        messages: {
            image: {
                accept: message
            }
        }  
    });

    $('#edit_staritng_city').validate({
        rules: {
            name: {
                required: true
            },
            image: {
                accept: "image/jpg,image/jpeg,image/png"
            }
        },
        messages: {
            image: {
                accept: message
            }
        }
    });

    $('#add_space').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            }
        }
    });

    $('#edit_space').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            }
        }
    });

    $('#edit_bed').validate({
		rules: {
			name: {
				required: true
			}
		}
	});

    $('#add_bed').validate({
        rules: {
            name: {
                required: true
            }
        }
    });

    $('#edit_property').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            }
        }
    });

    $('#add_property').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            }
        }
    });

    $('#add_country').validate({
        rules: {
            short_name: {
                required: true
            },
            name: {
                required: true
            },
            iso3: {
                required: true
            },
            number_code: {
                required: true
            },
            phone_code: {
                required: true
            }
        }
    });
    
    $('#icalendar_form').validate({
        rules: {
            url: {
                required: true,
                maxlength: 255,
                minlength: 6,
            },
            name: {
                required:true,
                maxlength:255,
                minlength:6,
            }
        },
        submitHandler: function(form)
        {
            $("#import_btn").on("click", function (e)
            {
                $("#import_btn").attr("disabled", true);
                e.preventDefault();
            });

            
            return true;

        },
        messages: {
            url: {
                minlength: message,
            },

            name: {
                minlength: message,
            }
        }
    });

    $('#listing_location').validate({
        rules: {
            country: {
                required: true
            },
            address_line_1: {
                required: true
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
        }
    });

    $('#list_des').validate({
        rules: {
            name: {
                required: true
            },
            summary: {
                required: true
            }
        }
    });

    $('#general_form').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true
            },
            'photos[logo]': {
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            },
            'photos[favicon]': {
                extension: "jpg|png|jpeg|ico"
            },
            default_currency: {
                required: true
            },
            default_language: {
                required: true
            }
        },
        messages: {
            'photos[logo]': {
                accept: message
            },
            'photos[favicon]': {
                extension: message_ico
            }
        }
    });

    $('#fees_setting').validate({
        rules: {
            guest_service_charge: {
                required: true
            }
        }
    });

    $('#api_credentials').validate({
        rules: {
            facebook_client_id: {
                required: true
            },
            facebook_client_secret: {
                required: true
            },
            google_client_id: {
                required: true
            },
            google_client_secret: {
                required: true
            },
            google_map_key: {
                required: true
            }
        }
    });

    $('#social_setting').validate({
        rules: {
            facebook: {
                required: true
            },
            google_plus: {
                required: true
            },
            twitter: {
                required: true
            },
            linkedin: {
                required: true
            },
            pinterest: {
                required: true
            },
            youtube: {
                required: true
            },
            instagram: {
                required: true
            }

        }
    });

    $('#email_setting').validate({
        rules: {
            host: {
                required: true
            },
            port: {
                required: true
            },
            from_address: {
                required: true
            },
            from_name: {
                required: true
            },
            encryption: {
                required: true
            },
            username: {
                required: true
            },
            password: {
                required: true
            }
        }
    });

    $('#img_form').validate({
        rules: {
            'photos[]': {
                required: true,
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }
        },
        messages: {
            'photos[]': {
                accept: message
            }
        }
    });

    $('#listing_pricing').validate({
        rules: {
            price: {
                required: true
            }
        }
    });

    $('#edit_customer').validate({
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
                laxEmail: true
            },
        }
    });

    $('#add_customer').validate({
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
    $('#edit_country').validate({
        rules: {
            short_name: {
                required: true
            },
            name: {
                required: true
            },
            iso3: {
                required: true
            },
            number_code: {
                required: true
            },
            phone_code: {
                required: true
            }
        }
    });

    $('#edit_admin').validate({
        rules: {
            username: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                maxlength: 255,
                laxEmail: true
            },
            password: {
                maxlength: 50,
                minlength: 6,
            }
        }
    });

    

    $('#add_admin').validate({
        rules: {
            username: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                maxlength: 255,
                laxEmail: true
            },
            password: {
                required: true,
                maxlength: 50,
                minlength: 6
            }
        }
    });

    
    $('#profile_edit').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                maxlength: 255
            },
            password: {
                maxlength: 50
            },
            password_confirmation: {
                equalTo: ".new_password"
            },
            profile_pic: {
                extension: "jpg|png|gif"
                
            }
        },
        messages: {
            profile_pic: {
                extension: message
            }
        }
    });

    $('.icon-click').on('click', function(){
        var temp = $(this).attr('id');
        var i;
        temp     = temp.split('-');
        var name = temp[0];
        var val  = temp[1];
        var prv  = $('#'+name).val();
        $('#'+name).val(val);
        $('#rating_1').val(val);
        for(i = 1; i <= prv; i++){
          $('#'+name+'-'+i).removeClass('fa-star-beach');
          $('#'+name+'-'+i).addClass('icon-light-gray');
        }
        for(i = 1; i <= val; i++){
          $('#'+name+'-'+i).removeClass('icon-light-gray');
          $('#'+name+'-'+i).addClass('fa-star-beach');
        }
      })

    jQuery.validator.addMethod("laxEmail", function(value, element) {
        return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
        }, "Please enter a valid email address." );
    
    jQuery.validator.addMethod("letters_with_spaces", function(value, element)
    {
      return this.optional(element) || /^[A-Za-z ]+$/i.test(value); //only letters
    }, "Please enter letters only!");
  
    $.validator.setDefaults({
        highlight: function(element) {
          $(element).parent('div').addClass('has-error');
        },
        unhighlight: function(element) {
         $(element).parent('div').removeClass('has-error');
       },
       errorPlacement: function (error, element) {
        if (element.prop('type') === 'checkbox') {
          $('#error-message').html(error);
        } else {
          error.insertAfter(element);
        }
      }
    });


});