"use strict"
var autocomplete = '';

$(document).on('submit', '#accept_reservation_form', function() {
	$('#accept_submit').attr('disabled', 'disabled');
});

$('#accept-modal-trigger').on('click', function(){
	expirationTimeSet()
	$('#accept-modal').modal();
})

$(document).on('click', '#status', function(){
  var id = $(this).attr('data-id');
  var datastatus = $(this).attr('data-status');
  var dataURL = APP_URL + '/listing/update_status';
  
  $('#messages').empty();
  $.ajax({
      url: dataURL,
      data:{
          "_token": token,
          'id':id,
          'status':datastatus,
      },
      type: 'post',
      dataType: 'json',
      success: function(data) {
          $("#status").attr('data-status', data.status)
          $("#messages").append("");
          $("#alert").removeClass('d-none');
          $("#messages").append(data.name + " " + hasBeen + " " + data.prop_status + ".");
          var header = $('#alert');
          setTimeout(function() {
              header.addClass('d-none');
          }, 4000);
      }
  });
});

$(document).on('change', '#listing_select', function(){

  $("#listing-form").trigger("submit");

});

$('#decline-modal-trigger').on('click', function(){
	$('#decline-modal').modal();
})

$('#discuss-modal-trigger').on('click', function(){
	$('#discuss-modal').modal();
})

$(document).on('change', '#trip_select', function(){

  $("#my-trip-form").trigger("submit");

});

$(document).on('click', '.book_mark_change', function(event){
  event.preventDefault();
  var property_id = $(this).data("id");
  var property_status = $(this).data("status");
  
  var dataURL = APP_URL + '/add-edit-book-mark';
  var that = this;
  if (property_status == "1") {
      var title = remove;

  } else {

      var title = add;
  }

  if (user_id == '') {

    window.location.href = BaseURL + '/unauthentication-favourite/' + property_id;
    
  } else {
      swal({
        title: title,
        icon: "warning",
        buttons: {
            cancel: {
                text: no,
                value: null,
                visible: true,
                className: "btn btn-outline-danger text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5",
                closeModal: true,
            },
            confirm: {
                text: yes,
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
              

                $.ajax({
                    url: dataURL,
                    data:{
                        "_token": token,
                        'id':property_id,
                        'user_id':user_id,
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {

                        $(that).removeData('status')
                        if (data.favourite.status == 'Active') {
                            $(that).css('color', 'forestgreen');
                            $(that).attr("data-status", 1);
                            swal(success, added);

                        } else {
                            $(that).css('color', 'black');
                            $(that).attr("data-status", 0);
                            swal(success, removed);


                        }
                    }
                });

            }
        });
  }

  
});

function print_receipt()
{
  document.getElementById("print-div").classList.add("d-none");
  document.getElementById("footer").classList.add("d-none");
  window.print();

    $("#print-div").removeClass("d-none");
}

$('#decline_reason').on('change', function(){
	var res = $('#decline_reason').val();
	if (res == 'other') $('#cancel_reason_other_div').show();
});


if (typeof(expireTime) == 'undefined') {
  var expireTime = '';
} 

var expiration_time  = expireTime;
var _second = 1e3;
var _minute = 60 * _second;
var _hour = 60 * _minute;
var _day = 24 * _hour, timer;


var expirationTimeSet = function() { 
    
};


if (expireTime !== '') {
  expirationTimeSet = function() {
    var date_ele = new Date;
    var present_time = new Date(date_ele.getUTCFullYear(), date_ele.getUTCMonth(), date_ele.getUTCDate(), date_ele.getUTCHours(), date_ele.getUTCMinutes(), date_ele.getUTCSeconds()).getTime();
    
    var expiration_time = new Date(expireTime).getTime();

    var time_remaining = expiration_time - present_time;

    if (time_remaining < 0)

      return clearInterval(interval), document.getElementById("countdown_1").innerHTML = "Expired!";

    else {
        var hours = (Math.floor(time_remaining / _day), Math.floor(time_remaining % _day / _hour));
        var minutes = Math.floor((time_remaining % _hour) / _minute);
        var seconds = Math.floor((time_remaining % _minute) / _second);

        document.getElementById("countdown_1").innerHTML = `${hours}h ${minutes}m ${seconds}s`;
    }
  };
}


var interval = setInterval(expirationTimeSet, 1e3);


$(document).on('change', '#calendar_dropdown', function(){
  var year_month = $(this).val();
  year_month     = year_month.split('-');
  var year       = year_month[0];
  var month      = year_month[1];
  set_calendar(month, year);
});

$(document).on('click', '.month-nav-next', function(e){
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendar(month, year);
});

$(document).on('click', '.month-nav-previous', function(e){
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendar(month, year);
});

$(document).on('keyup', '#header-search-form', function(){
  autocomplete = new google.maps.places.Autocomplete(document.getElementById("header-search-form"));
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    mapDropDownActive();
  });
});

$(document).on('keyup', '#sidenav-search-form', function(){
  autocomplete = new google.maps.places.Autocomplete(document.getElementById("sidenav-search-form"));
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    document.getElementById("sidenav-search-drop-down").classList.toggle("sm-show");
    $("#sidenav-search-checkin").datepicker("show");
  });
});

$(document).on('keyup', '#front-search-field', function(){
  autocomplete = new google.maps.places.Autocomplete(document.getElementById("front-search-field"));
});

$(document).on('keyup', '#location-search-google', function(){
  autocomplete = new google.maps.places.Autocomplete(document.getElementById("location-search-google"));
});

function set_calendar(month, year){
  var property_id = $('#dtpc_property_id').val();
  var dataURL     = APP_URL + '/ajax-calender/' + property_id;
  var calendar    = '';
  $.ajax({
    url: dataURL,

    data: {
      "_token":  $('meta[name="csrf-token"]').attr('content'),
      'month': month,
      'year': year
    },
    type: 'post',
    dataType: 'json',
    success: function (result) {
      $('#calender-dv').html(result.calendar);
      $("#hotel_date_package").modal("hide");
    },
    error: function (request, error) {
    }
  });
}

$(document.body).on('click', '.date-package-modal', function(){
    $('#model-message').html("");
        var sdate  = $(this).attr('id');
        var div    = sdate.split('-');
        var day    = div[2];
        var month  = div[1];
        var year   = div[0];
        var price  = $(this).attr('data-price');
        var status = $(this).attr('data-status');
        var minday = $(this).attr('data-minday');

        if (day.length < 2) {
          day = '0' + day;
        }
        var date   = day + '-' + month + '-' + year;
        var dateFormat = frontDateFormatType;
        date = $.datepicker.formatDate(dateFormat, $.datepicker.parseDate('dd-mm-yy', date));

        $('#dtpc_start').val(date);
        $('#dtpc_end').val(date);

        $('#dtpc_price').val(price);
        $('#dtpc_stay').val(minday);
        $('#dtpc_status').val(status).change();
        $("#dtpc_start").datepicker({
            dateFormat: dateFormat,
            onSelect: function(date) {
                var a = $('#dtpc_start').val();
                var b = $('#dtpc_end').val();
                $('#error-dtpc-start_date').html('');
                $('#error-dtpc-end_date').html('');
                if (dateConvert(a, dateFormat) >dateConvert(b, dateFormat)){
                    $('#error-dtpc-start_date').html(startDateError);
                }
            },
        });
        $("#dtpc_end").datepicker({
            dateFormat: dateFormat,
            onSelect: function(date) {

                var a = $('#dtpc_start').val();
                var b = $('#dtpc_end').val();
                $('#error-dtpc-start').html('');
                $('#error-dtpc-end').html('');

                if (dateConvert(a, dateFormat) >dateConvert(b, dateFormat)){
                    $('#error-dtpc-end_date').html(endDateError);
                }

            },
        });
        $('#price_btn').removeClass('disabled');
        $("#price_spinner").addClass('d-none');
        $("#price_next-text").text(submit);

        $('#hotel_date_package').modal();

});

//Icalenar Modal Code Starts here

$(document.body).on('click', '.imporpt_calendar', function(){
    $('#import_calendar_package').modal();
});
$(document.body).on('change','#color',function(){
  var color          = $('#color').val();
  if(color=='custom'){
    $('.colorCustom').css('display','block');
  }else{
    $('.colorCustom').css('display','none');
  }

});

$(document.body).on('submit', "#icalendar_form", function(e){
  e.preventDefault();
  $('#error-icalendar-url').html('');
  $('#error-icalendar-name').html('');
  var url            = $('#icalendar_url').val();
  var name           = $('#icalendar_name').val();
  var property_id    = $('#icalendar_property_id').val();
  var color          = $('#color').val();
  var customColor    = $('#customcolor').val();
  if(color=='custom'){
    if(customColor == '') {
        $('#error-dtpc-customcolor').html(fieldRequiredText);
      }
  } else {
    customColor ='none';
  }
  if(url == '') $('#error-icalendar-url').html(fieldRequiredText);
  if(name == '') $('#error-icalendar-name').html(fieldRequiredText);
  if(color == '') $('#error-dtpc-color').html(fieldRequiredText);
  
  else
  $.ajax({
      type: "POST",
      url: APP_URL + '/ajax-icalender-import/' + property_id,
      data: { "_token":  $('meta[name="csrf-token"]').attr('content'),'url':url, 'name':name,'property_id':property_id,'color':color,'customcolor':customColor},
      success: function(msg){
          if(msg.status==1){
            $('#icalendar-model-message').html(msg.success_message);
            $('#icalendar-model-message').removeClass('d-none');
            $("#import_calendar_package").modal("hide");

          }else{
            $('#error-icalendar-url').html(msg.error.url);
            $('#error-icalendar-name').html(msg.error.name);
            $('#error-dtpc-customcolor').html(msg.error.customcolor);
            return false;
          }
      },
      error: function(request, error) {
      }
  });
});

function dateConvert(date, format) {
    const months = {
        "Jan": 1,
        "Feb": 2,
        "Mar": 3,
        "Apr": 4,
        "May": 5,
        "Jun": 6,
        "Jul": 7,
        "Aug": 8,
        "Sep": 9,
        "Oct": 10,
        "Nov": 11,
        "Dec": 12,
    };
    let day = "";
    let mon = "";
    let year = "";
    let formats = format.split(/[./-]/g);
    let dateParts = date.split(/[./-]/g);
    formats.forEach((element, index) => {
        if(element === 'dd') {
            day = dateParts[index];
        }
        else if(element === 'mm') {
            mon = dateParts[index];
        }
        else if(element === 'M') {
            mon = months[dateParts[index]]
        }
        else if(element.includes("yy")) {
            year = dateParts[index];
        }
    });
    return Date.parse(year+"-"+mon+"-"+day);
}

//Icalendar Modal Code End here

//Icalendar Export Modal Code Starts here

$(document.body).on('click', '#export_icalendar', function(){
    $('#calendar_export_package').modal();
});

//Icalendar Export Modal Code Ends here

$(document.body).on('submit', "#dtpc_form", function(e) {
  e.preventDefault();
  
  // Clear previous error messages
  $('#error-dtpc-start').html('');
  $('#error-dtpc-end').html('');
  $('#error-dtpc-price').html('');
  $('#error-dtpc-status').html('');
  $('#error-dtpc-stay').html('');
  $('#model-message').html('').removeClass('d-none bg-success bg-danger');

  var start_date = $('#dtpc_start').val();
  var end_date = $('#dtpc_end').val();
  var price = $('#dtpc_price').val();
  var status = $('#dtpc_status').val();
  var property_id = $('#dtpc_property_id').val();
  var min_stay = $('#dtpc_stay').val();
  var url = APP_URL + '/ajax-calender-price/' + property_id;
  
  // Simple client-side validation (optional, can be adjusted)
  if (start_date == '') $('#error-dtpc-start_date').html(startDateBlankError);
  if (end_date == '') $('#error-dtpc-end_date').html(endDateBlankError);
  if (price == '') $('#error-dtpc-price').html(priceBlankError);
  if (status == '') $('#error-dtpc-status').html(statusBlankError);

  if (start_date && end_date && price && status) {
      $('#price_btn').addClass('disabled');
      $("#price_spinner").removeClass('d-none');
      $("#price_next-text").text(submittingText);

      $.ajax({
          type: "POST",
          url: url,
          data: {
              "_token": $('meta[name="csrf-token"]').attr('content'),
              'start_date': start_date,
              'end_date': end_date,
              'price': price,
              'min_stay': min_stay,
              'status': status
          },
          success: function(response) {
              var year_month = $('#calendar_dropdown').val();
              year_month = year_month.split('-');
              var year = year_month[0];
              var month = year_month[1];
              
              set_calendar(month, year);
              
              $('#model-message').html(dataSaveMessage).removeClass('d-none bg-danger').addClass('bg-success');
              $('#dtpc_form')[0].reset(); // Reset the form
              $('#hotel_date_package').modal('hide'); // Close the modal
          },
          error: function(request) {
            
            $('#error-dtpc-start_date, #error-dtpc-end_date, #error-dtpc-price, #error-dtpc-status, #error-dtpc-stay').html('');
        
            if ([400, 422].includes(request.status) && request.responseJSON.errors) {
                let errors = request.responseJSON.errors;
                for (var field in errors) {
                    $('#error-dtpc-' + field).html(errors[field][0]);
                }
            } else {

                let errorMessage = request.responseJSON?.message || errorOccuredMessage;
                $('#model-message').html(errorMessage).removeClass('d-none bg-success').addClass('bg-danger');
            }
        
            $('#price_btn').removeClass('disabled');
            $("#price_spinner").addClass('d-none');
            $("#price_next-text").text(submit);
        }
        
      });
  }
});


function mapDropDownActive(){
    document.getElementById("search-drop-down").classList.toggle("sm-show");
    $("#header-search-checkin").datepicker("show");
}

// edit_reviews_host
$('#open-review').on('click', function () {
  $('.opening-div').addClass('display-off');
  $('.review-div').removeClass('display-off');
});

$('.icon-click').on('click', function () {
  var temp = $(this).attr('id');
  temp = temp.split('-');
  var i = 0;
  var name = temp[0];
  var val = temp[1];
  var prv = $('#' + name).val();
  $('#' + name).val(val);
  for (i = 1; i <= prv; i++) {
      $('#' + name + '-' + i).removeClass('icon-beach');
      $('#' + name + '-' + i).addClass('icon-light-gray');
  }
  for (i = 1; i <= val; i++) {
      $('#' + name + '-' + i).removeClass('icon-light-gray');
      $('#' + name + '-' + i).addClass('icon-beach');
  }
});

$('.thumb-icon').on('click', function () {
  $('.thumb-icon').removeClass('icon-select');
  $('.thumb-icon').removeClass('icon-unselect');
  var rec = $(this).attr('data-rel');
  $('#recommend').attr('value', rec);
  if (rec == 0)
      $(this).addClass('icon-unselect');
  else
      $(this).addClass('icon-select');
})
$('#guest-form').on('submit', function (e) {
  e.preventDefault();
  $('#save_button').addClass('disabled');
  $(".spinner").removeClass('d-none');
  $("#save_button_text").text(submit);

  var booking_id = $('#booking_id').val();
  var review_id = $('#review_id').val();
  var message = $('#review_message').val();
  var secret_feedback = $('#secret_feedback').val();
  var cleanliness = $('#cleanliness').val();
  var rating = $('#rating').val();
  var communication = $('#communication').val();
  var house_rules = $('#house_rules').val();
  var recommend = $('#recommend').val();
  var dataURL = APP_URL + "/reviews/edit/" + booking_id;

  $.ajax({
      url: dataURL,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
          'review_id': review_id,
          'message': message,
          'secret_feedback': secret_feedback,
          'cleanliness': cleanliness,
          'rating': rating,
          'communication': communication,
          'house_rules': house_rules,
          'recommend': recommend,
      },
      type: 'post',
      dataType: 'json',
      success: function (result) {
          if (result.success) {
              window.location.href = APP_URL + "/users/reviews_by_you"
          }
      },
      error: function (request, error) {
          // This callback function will trigger on unsuccessful action
      },
  });
})

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('#search-map') && !event.target.matches('.sm-dropdown-content') && !$(event.target).parents(".sm-dropdown-content").length && !event.target.matches(".ui-state-default")
  && !event.target.matches('.ui-icon') && !event.target.matches('.ui-datepicker-month') && !event.target.matches('.ui-datepicker-year') && !event.target.matches('.month')) {
    var dropdowns = document.getElementsByClassName("sm-dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('sm-show')) {
        openDropdown.classList.remove('sm-show');
      }
    }
  }
}

$(document).on('submit', '.search-form', function() {
    var t = $("#header-search-checkin").val(),
        a = $("#header-search-checkout").val(),
        o = $("#header-search-guests").val(),
        i = "";
    var n = $("#header-search-form").val(),
        c = n.replace(" ", "+");
    window.location.href = APP_URL + "/s?location=" + c + "&checkin=" + t + "&checkout=" + a + "&guest=" + o, e.preventDefault()
})

function page_loader_start(){
  $('body').prepend('<div id="preloader"></div>');
}
function page_loader_stop(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
}

function modal_alert(message, call_back){
  $('#alert_model').modal('show');

}

$('#ok_id').on('click', function(e){
    e.preventDefault()
});
$(document).on('submit', '#front-search-form', function() {
  e.preventDefault()
    var t = $("#startDate").val(),
        a = $("#endDate").val(),
        o = $("#front-search-guests").val(),
        i = "";
    var n = $("#front-search-field").val(),
        c = n.replace(" ", "+");
    window.location.href = APP_URL + "/search?location=" + c + "&checkin=" + t + "&checkout=" + a + "&guest=" + o, e.preventDefault()
});



$(document).on('submit', '.search-form', function(e) {
    var t = $("#header-search-checkin").val(),
        a = $("#header-search-checkout").val(),
        o = $("#header-search-guests").val(),
        i = "";

    var n = $("#header-search-form").val();
        if(n==''){
          var t = $("#sidenav-search-checkin").val(),
              a = $("#sidenav-search-checkout").val(),
              o = $("#sidenav-search-guests").val(),
              i = "";
          n = $("#sidenav-search-form").val();

        }
        c = n.replace(" ", "+");
    window.location.href = APP_URL + "/search?location=" + c + "&checkin=" + t + "&checkout=" + a + "&guest=" + o, e.preventDefault()
});




$('.room-list-status').on('change', function(){
  var status = $(this).val();
  var property = $(this).attr('data-room-id');
  $.ajax({
    type: "POST",
    url: APP_URL + "/listing/" + property + "/update_status",
    data: { "_token": "{{ csrf_token() }}", 'status': status},
    success: function() {
      location.reload()
    },
  });
});

$(document).on('click', '.review_detials', function(){
  var id = $(this).data("id");
  var name = $(this).data("name");
  $('#name').html(name);
  var dataURL = APP_URL+ '/reviews/details';
  $.ajax({
      url: dataURL,
      data:{
          "_token": token,
          'id':id,
      },
      type: 'post',
      dataType: 'text',
      success: function(data) {
          $('#heading').html(data);
      }
  })
});

$(document).on('click', '.review_detials', function(){
  var id = $(this).data("id");
  var name = $(this).data("name");
  $('#name').html(name);
  var dataURL = APP_URL+ '/reviews/details';
  $.ajax({
    url: dataURL,
    data:{
      "_token": token,
      'id':id,
    },
    type: 'post',
    dataType: 'text',
    success: function(data) {
      $('#heading').html(data);
    }
  })
});

$(document).on('submit', '#message-form', function(e) {
  e.preventDefault()
  var message = $('#message_text').val();
  if(message != '')
    $.ajax({
      type: "POST",
      url: APP_URL + "/messaging/qt_reply/" + $("#reservation_id").val(),
      data: { "_token": "{{ csrf_token() }}",'message': message},
      success: function(msg) {
        $("#message-list").prepend(msg);
      },
    });
});

$(document).on('submit', '#host-message-form', function(e) {
  e.preventDefault()
  var message = $('#message_text').val();
  if(message != '')
    $.ajax({
      type: "POST",
      url: APP_URL + "/messaging/qt_reply/" + $("#reservation_id").val(),
      data: {
        "_token": "{{ csrf_token() }}",
        'message': message,
        pricing_room_id: $("#pricing_room_id").val(),
        pricing_checkin: $("#pricing_start_date").val(),
        pricing_checkout: $("#pricing_end_date").val(),
        pricing_guests: 1,
        pricing_price: $("#pricing_price").val()
      },
      success: function(msg) {
        $("#message-list").prepend(msg);
      },
    });
});


function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  document.getElementById("copied").innerHTML = "Copied";

}

dateRangeBtn(moment(),moment(), null, dateFormat);