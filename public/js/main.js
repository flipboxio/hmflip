$(function() {
  "use strict";

  var nav_offset_top = $('header').height() + 50; 
    /*-------------------------------------------------------------------------------
	  Navbar 
	-------------------------------------------------------------------------------*/

	//* Navbar Fixed  
    function navbarFixed(){
        if ( $('.header_area').length ){ 
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();   
                if (scroll >= nav_offset_top ) {
                    $(".header_area").addClass("navbar_fixed");
                } else {
                    $(".header_area").removeClass("navbar_fixed");
                }
            });
        };
    };
    navbarFixed();


    /*-------------------------------------------------------------------------------
	  testimonial slider
	-------------------------------------------------------------------------------*/
    if ($('.testimonial').length) {
        $('.testimonial').owlCarousel({
            loop: true,
            margin: 30,
            items: 5,
            nav: false,
            dots: true,
            responsiveClass: true,
            slideSpeed: 300,
            paginationSpeed: 500,
            responsive: {
                0: {
                    items: 1
                }
            }
        })
    }

});


// List Grid Control
$(document).ready(function () {

    $('#open-review').on( 'click', function(){
		$('.opening-div').addClass('display-off');
		$('.review-div').removeClass('display-off');
	});


	$('.icon-click').on('click', function(){
		var temp = $(this).attr('id');
		temp     = temp.split('-');
		var name = temp[0];
		var val  = temp[1];
		var prv  = $('#'+name).val();
		$('#'+name).val(val);
		for (i = 1; i <= prv; i++){
			$('#'+name+'-'+i).removeClass('icon-beach');
			$('#'+name+'-'+i).addClass('icon-light-gray');
		}

		for (i = 1; i <= val; i++){
			$('#'+name+'-'+i).removeClass('icon-light-gray');
			$('#'+name+'-'+i).addClass('icon-beach');
		}
	})

	$('.thumb-icon').on('click', function(){
		$('.thumb-icon').removeClass('icon-select');
		$('.thumb-icon').removeClass('icon-unselect');
		var rec = $(this).attr('data-rel');
		$('#recommend').attr('value', rec);
		if (rec == 0)
			$(this).addClass('icon-unselect');
		else
			$(this).addClass('icon-select');
	});

	$('#guest-review-form1').on('submit', function(e){
		e.preventDefault();

	var booking_id = $('#booking_id').val();
	var review_id  = $('#review_id').val();
	var message    = $('#message').val();
	var secret_feedback   = $('#secret_feedback').val();
	var improve_message = $('#improve_message').val();
	var rating     = $('#rating').val();
	var dataURL    = APP_URL + "/reviews/edit/" + booking_id;
	if (message == ''){
		$('#error-comments').removeClass('d-none');
	}
	else {

		$(this).addClass('disabled');
        $("#btn_spin").removeClass('d-none');
        $("#btnnext-text1").text(nextText);

		$.ajax({
			url: dataURL,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				'review_id': review_id,
				'message': message,
				'secret_feedback': secret_feedback,
				'improve_message': improve_message,
				'rating': rating,
			},
			type: 'post',
			dataType: 'json',
			success: function (result) {
				if (result.success){
					$('#review-guest-1').addClass('display-off');
					$('#review-guest-2').removeClass('display-off');
					$('#review_id').val(result.review_id);
				}
			},
			error: function (request, error) {
			// This callback function will trigger on unsuccessful action
		},
	});
	}
});

	$('#guest-review-form2').on('submit', function(e){
		e.preventDefault();

		$(this).addClass('disabled');
        $("#btn_spin2").removeClass('d-none');
        $("#btnnext-text2").text(submitText);

		var booking_id = $('#booking_id').val();

		var review_id = $('#review_id').val();
		var accuracy = $('#accuracy').val();
		var accuracy_message = $('#accuracy_message').val();
		var cleanliness = $('#cleanliness').val();
		var cleanliness_message = $('#cleanliness_message').val();
		var checkin = $('#checkin').val();
		var checkin_message = $('#checkin_message').val();
		var amenities = $('#amenities').val();
		var amenities_message = $('#amenities_message').val();
		var communication = $('#communication').val();
		var communication_message = $('#communication_message').val();
		var location = $('#location').val();
		var location_message = $('#location_message').val();
		var value = $('#value').val();
		var value_message = $('#value_message').val();
		var recommend = $('#recommend').val();
		var dataURL = APP_URL + "/reviews/edit/" + booking_id;
		$.ajax({
			url: dataURL,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				'review_id': review_id,
				'accuracy': accuracy,
				'accuracy_message': accuracy_message,
				'cleanliness': cleanliness,
				'cleanliness_message': cleanliness_message,
				'checkin': checkin,
				'checkin_message': checkin_message,
				'amenities': amenities,
				'amenities_message': amenities_message,
				'communication': communication,
				'communication_message': communication_message,
				'location': location,
				'location_message': location_message,
				'value': value,
				'value_message': value_message,
				'recommend': recommend,
			},
			type: 'post',
			dataType: 'json',
			success: function (result) {
				if (result.success){
					window.location.href = APP_URL + "/users/reviews_by_you"
				}
			},
			error: function (request, error) {
				// This callback function will trigger on unsuccessful action
			},
		});
	});
    
    $(document).on('click', '#list', function() {
        event.preventDefault(); 
        $('#products .item').addClass('list-group-item');
        $('#list-tag').removeClass('justify-content-center');
        $('#list').removeClass('inactive-list');
        $('#grid').addClass('inactive-list');
     });

	 $(document).on('click', '#grid', function() {
        event.preventDefault(); 
        $('#products .item').removeClass('list-group-item'); 
        $('#products .item').addClass('grid-group-item');
        $('#list-tag').addClass('justify-content-center');
        $('#grid').removeClass('inactive-list');
        $('#list').addClass('inactive-list');
     });

     $(document).on('click', '#reviewIcon', function() {
		var a=   $('#collapseReviews').hasClass( "show" );
		if(a) {
				$('#reviewArrow').removeClass( "fa-angle-down" );
				$('#reviewArrow').addClass( "fa-angle-right" );
			} else {
				$('#reviewArrow').removeClass( "fa-angle-right" );
				$('#reviewArrow').addClass( "fa-angle-down" );
			}
     });

    
});


