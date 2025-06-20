"use strict"
$(function() {
    var checkin = $('#startDate').val();
    var checkout = $('#endDate').val();
    var page = 'single'
    dateRangeBtn(checkin,checkout,page, dateFormat);

});

$("#view-calendar").on("click", function() {
    return $("#startDate").trigger("select");
})

$(function(){
	var checkin     = $('#url_checkin').val();
	var checkout    = $('#url_checkout').val();
	var guest       = $('#url_guests').val();
	price_calculation(checkin, checkout, guest);
});

$('#number_of_guests').on('change', function(){
	price_calculation('', '', '');
});

function price_calculation(checkin, checkout, guest) {
	var checkin = checkin != ''? checkin:$('#startDate').val();
	var checkout = checkout != ''? checkout:$('#endDate').val();
	var guest = guest != ''? guest:$('#number_of_guests').val();
	if (checkin != '' && checkout != '' &&  guest != '') {
	var property_id     = $('#property_id').val();
	var dataURL = getPriceURL;
		$.ajax({
			url: dataURL,
			data: {
				"_token": token,
				'checkin': checkin,
				'checkout': checkout,
				'guest_count': guest,
				'property_id': property_id,
			},
			type: 'post',
			dataType: 'json',
			beforeSend: function (){
				show_loader();
			},
			success: function (result) {
				console.log(result);
				$('.append_date').remove();
				if (result.status == 'Not available'){
					$('.book_btn , .booking-subtotal').addClass('d-none');
					$('#book_it_disabled').removeClass('d-none');
					$('#book_it_disabled_message').text(result.message);
				}
				else if (result.status == 'minimum stay')
				{
					$('.book_btn, .booking-subtotal, #book_it_disabled').addClass('d-none');
					$('#minimum_disabled').removeClass('d-none');
					$('#minimum_disabled_message').text(result.minimum);


				}
				else
				{

					//showing custom price in info icon
					if (!jQuery.isEmptyObject(result.different_price_dates)){
						var output = customPriceText+"<br/>";
						for (var ical_date in result.different_price_dates) {
							output += dateText+": "+ical_date+" | "+priceText+": "+symbolText+ result.different_price_dates[ical_date]+" <br>";
						}

						$("#custom_price").attr("data-original-title", output);
						$('#custom_price').tooltip({ 'placement': 'top' });
						$('#custom_price').show();

					} else {
						$('#custom_price').addClass('d-none');
					}


					var append_date = ""

					for(var i=0; i<result.date_with_price.length; i++){

					append_date +=		'<tr class="append_date">'
											+ '<td class="pl-4">'
												+ result.date_with_price[i]['date']+
											'</td>'
											+ '<td class="pl-4 text-right"> <span  id="" value="">' + result.date_with_price[i]['price'] +'</span></td>'
										+ '</tr>';

					}

					var tableBody = $("table tbody");
	                tableBody.first().prepend(append_date);


					$('.additional_price, .security_price, .cleaning_price, .iva_tax, .accomodation_tax').removeClass('d-none');
					$("#total_night_count").html(result.total_nights);
					$('#total_night_price').html(result.total_night_price_with_symbol);
					$('#service_fee').html(result.service_fee_with_symbol);
					$('#discount').html(result.discount_with_symbol);

					if (result.iva_tax != 0) {
						$('#iva_tax').html(result.iva_tax_with_symbol);
					} else {
						$('.iva_tax').addClass('d-none');
					}

					if (result.accomodation_tax != 0) {
						$('#accomodation_tax').html(result.accomodation_tax_with_symbol);
					} else {
						$('.accomodation_tax').addClass('d-none');
					}

					if (result.additional_guest != 0) {
						$('#additional_guest').html(result.additional_guest_fee_with_symbol);
					} else {
						$('.additional_price').addClass('d-none');
					}

					if (result.security_fee != 0) {
						$('#security_fee').html(result.security_fee_with_symbol);
					} else { 
						$('.security_price').addClass('d-none');
					}

					if (result.cleaning_fee != 0) {
						$('#cleaning_fee').html(result.cleaning_fee_with_symbol);
					} else { 
						$('.cleaning_price').addClass('d-none');
					}
					$('#total').html(result.total_with_symbol);
					//$('#total_night_price').html(result.total_night_price);

					$('.booking-subtotal').removeClass('d-none');
					$('#book_it_disabled, #minimum_disabled').addClass('d-none');
					$('.book_btn').removeClass('d-none');
				}

				if (host == '1') $('.book_btn').addClass('d-none');
			},
			error: function (request, error) {
				// This callback function will trigger on unsuccessful action
			},
			complete: function(){
				$('.price_table').removeClass('d-none');
				hide_loader();
			}
		});
	}
}

$("#save_btn").on("click", function (e)
{
    $("#save_btn").attr("disabled", true);
    $(".spinner").removeClass('d-none');
    $('#booking_form').submit();
});

window.onbeforeunload = function (evt) {
    if (back) {
        $("#save_btn").attr("disabled", false);
        $(".spinner").addClass('d-none');
        back = 0;
    }
    else {
        back++;
    }

}

$('.more-btn').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger').addClass('d-none');
	$('#'+name+'_after').removeClass('d-none');
});

$('.more-btn-mobile').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger_mobile').addClass('d-none');
	$('#'+name+'_after_mobile').removeClass('d-none');
});

$('.less-btn').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger').removeClass('d-none');
	$('#'+name+'_after').addClass('d-none');
});

$('.less-btn-mobile').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger_mobile').removeClass('d-none');
	$('#'+name+'_after_mobile').addClass('d-none');
});

setTimeout(function(){

	$('#room-detail-map').locationpicker({
		location: {
			latitude: latitude,
			longitude: longitude
		},
		radius: 0,
		addressFormat: "",
		markerVisible: false,
		markerInCenter: false,
		enableAutocomplete: true,
		scrollwheel: false,
		oninitialized: function (component) {
			setCircle($(component).locationpicker('map').map);
		}

	});

}, 5000);

function setCircle(map){
	var citymap = {
	loccenter: {
		center: {lat: 41.878, lng: -87.629},
		population: 240
	},
	};

	var cityCircle = new google.maps.Circle({
		strokeColor: '#329793',
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: '#329793',
		fillOpacity: 0.35,
		map: map,
		center: {lat: latitude, lng: longitude },
		radius: citymap['loccenter'].population
	});
}

function lightbox(idx) {
	//show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
	$('#showSlider').removeClass("d-none");
	nslider.init(idx);
	$("#ninja-slider").addClass("fullscreen");
}

function fsIconClick(isFullscreen) { //fsIconClick is the default event handler of the fullscreen button
	if (isFullscreen) {
		$('#showSlider').addClass("d-none");
	}
}

function show_loader(){
	$('#loader').removeClass('d-none');
	$('#pagination').addClass('d-none');
}

function hide_loader(){
	$('#loader').addClass('d-none');
	$('#pagination').removeClass('d-none');
}

window.twttr = (function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0],
		t = window.twttr || {};
	if (d.getElementById(id)) return t;
	js = d.createElement(s);
	js.id = id;
	js.src = "https://platform.twitter.com/widgets.js";
	fjs.parentNode.insertBefore(js, fjs);
	t._e = [];
	t.ready = function(f) {
		t._e.push(f);
	};

	return t;
	}(document, "script", "twitter-wjs"));