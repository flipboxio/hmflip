"use strict"
$(document).ready(function(){
 
  $("#dataTableBuilder").on("click", ".edit_meta", function(){
      var id          = this.id;
      var url         = APP_URL+'/admin/edit_meta';
    $.ajax({
          type: "POST",
          url: url,
          data: {'id':id,method:'get_meta'},
          dataType:'JSON',
          success: function(msg) {
             if(msg.status_check==1){
                $('.edit_id').val(msg.id);
                $('#input_url').val(msg.url);
                $('#input_title').val(msg.title);
                $('#input_description').val(msg.description);
                $('#input_keywords').val(msg.keywords);
             }
          },
          error: function(request, error) {
          }
      });
  });

  if($('#driver').val() == 'sendmail') {
      $('.host').hide();
      $('.port').hide();
      $('.from_address').hide();
      $('.from_name').hide();
      $('.encryption').hide();
      $('.username').hide();
      $('.password').hide();
      $('.email_status').hide();
      $('.error_email_settings').hide();
  }

  $('#driver').on('change',function(){
    var emailProtocol = $('#driver').val();
    var emailStatus   = $('.email_status_check').val();

    if (emailProtocol=='sendmail') {
        $('.host').hide();
        $('.port').hide();
        $('.from_address').hide();
        $('.from_name').hide();
        $('.encryption').hide();
        $('.username').hide();
        $('.password').hide();
        $('.email_status').hide();
        $('.error_email_settings').hide();
    } else if (emailProtocol=='smtp') {
        $('.host').show();
        $('.port').show();
        $('.from_address').show();
        $('.from_name').show();
        $('.encryption').show();
        $('.username').show();
        $('.password').show();
        if (emailStatus==1) {
            $('.email_status').show();
            $('.error_email_settings').hide();
        } else {
            $('.error_email_settings').show();
            $('.email_status').hide();
        }
    } else {
            $('.email_status').hide();
            $('.error_email_settings').hide();
    }
  });

  $('.remove_logo_preview').on("click", function(){
    var image = $('#hidden_company_logo').attr('data-rel');
    var token = $('input[name="_token"]').val();

    if(image){
            $.ajax({
            url : "settings/delete_logo",
            type : "post",
            async : false,
            data: {
                'company_logo' : image,
                "_token": token
            },
            dataType : 'json',
            success: function(reply)
            {
                if (reply.success == 1){
                    alert(reply.message);
                    location.reload();

                }else{
                    alert(reply.message);
                    location.reload();

                }
            }
            });
        }

    });

    $('.remove_favicon_preview').on("click", function(){
    var image = $('#hidden_company_favicon').attr('data-rel');
    var token = $('input[name="_token"]').val();
    if(image){
            $.ajax({
            url : "settings/delete_favicon",
            type : "post",
            async : false,
            data: { 'company_favicon' : image, '_token' : token},
            dataType : 'json',
            success: function(reply)
            {
                if (reply.success == 1){
                    alert(reply.message);
                    location.reload();

                }else{
                    alert(reply.message);
                    location.reload();

                }
            }
            });
        }

    });

  $(document.body).on('click', '.modal-admin', function() {
    $('#add_modal').modal();
  });

  $(document).on('click', '.edit_bank', function(e) {
      e.preventDefault();
      var formdata = [];
      var url = $(this).attr('action');
      $.ajax({
          url: e.target.dataset.url,
          type: "get",
          async: false,
          data: formdata,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(data, textStatus, jqXHR) {
              document.querySelector('#name').value = data.account_name;
              document.querySelector('#iban').value = data.iban;
              document.querySelector('#swift').value = data.swift_code;
              document.querySelector('#bank').value = data.bank_name;
              document.querySelector('#branch').value = data.branch_name;
              document.querySelector('#br_city').value = data.branch_city;
              document.querySelector('#route').value = data.routing_no;
              document.querySelector('#br_address').value = data.branch_address;
              document.querySelector('#description').innerHTML = data.description;
              document.querySelector('#logo').src = data.logo;
              document.querySelector('#country').value = data.country;
              document.querySelector('#status').value = data.status;
              document.querySelector('#edit_form').action = e.target.dataset.edit;
              $('#edit_modal').modal();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              throw 'Bank details not found';
          }
      });
  });

  $(document).on('change', '.pricing_checkbox', function(){
    if (this.checked){
      var name = $(this).attr('data-rel');
      $('#'+name).show();
    }else{
      var name = $(this).attr('data-rel');
      $('#'+name).hide();
      $('#price-'+name).val(0);
    }
  });
  
  $(document).on('click', '#show_long_term', function(){
    $('#js-set-long-term-prices').hide();
    $('#long-term-div').show();
  });

  $(".editor").wysihtml5();

  $("#available").on('click', function() {
    var className = $('#variable').attr('class');
    if (className == 'box-header d-none') {
        $("#variable").removeClass('d-none');
    } else {
      $("#variable").addClass('d-none');
    }
  });

  $(document).on('change', '#calendar_dropdown', function(){
      var year_month = $(this).val();
      year_month     = year_month.split('-');
      var year       = year_month[0];
      var month      = year_month[1];
      set_calendars(month, year);
  });

  $("#update_meta").on("click", function(){

    var edit_id     = $('.edit_id').val();
    var page_url    = $('#input_url').val();
    var title       = $('#input_title').val();
    var description = $('#input_description').val();
    var keywords    = $('#input_keywords').val();
    var url         = APP_URL+'/admin/edit_meta';
    $.ajax({
        type: "POST",
        url: url,
        data: {'edit_id':edit_id,'url':page_url,'title':title,'description':description,'keywords':keywords,method:'update_meta'},
        dataType:'JSON',
        success: function(msg) {
           if(msg.status_check==1){
              $('.edit_id').val(msg.id);
              $('#input_url').val(msg.url);
              $('#input_title').val(msg.title);
              $('#input_description').val(msg.description);
              $('#input_keywords').val(msg.keywords);
              $('#meta_message').css({'display':'block','text-align':'center'});
              $('#meta_message').html(msg.message);
           }else{
              $('#meta_message').css({'display':'none','text-align':'center'});
              $('.input_url').html(msg.url);
              $('.input_title').html(msg.title);
              $('.input_description').html(msg.description);
              $('.input_keywords').html(msg.keywords);
              
           }
        },
        error: function(request, error) {
        }
    });
  });
});



$(document.body).on('click', '.date-package-modal-admin', function(){
    var fl = $(this).hasClass('tile-previous');
    $('#model-message').html("");
    if(!fl){
        var sdate = $(this).attr('id');
        var div = sdate.split('-');
        var day = div[2];
        var month = div[1];
        var year = div[0];
        var price = $(this).attr('data-price');
        var minstay = $(this).attr('data-minday');
        var status = $(this).attr('data-status');
        var date = day+'-'+month+'-'+year;
        $('#dtpc_start_admin').val(date);
        $('#dtpc_end_admin').val(date);
        $('#dtpc_price').val(price);
        $('#dtpc_minstay_admin').val(minstay);
        $('#dtpc_status').val(status).change();

        $("#dtpc_start_admin").datepicker({
            format: "dd-mm-yyyy",
            onSelect: function(date) {
               
            },
        });
        $("#dtpc_end_admin").datepicker({
            format: "dd-mm-yyyy",
            onSelect: function(date) {
                
            },
        });
        $('#hotel_date_package_admin').modal();
    }
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
  //$('#error-dtpc-frequency-time').html('');
  var url            = $('#icalendar_url').val();
  var name           = $('#icalendar_name').val();
  var property_id    = $('#icalendar_property_id').val();
  //var frequency_time = $('#frequency_time').val();
  var color          = $('#color').val();
  var customColor    = $('#customcolor').val();
  if(color=='custom'){
    if(customColor == '') {
        $('#error-dtpc-customcolor').html('This field is required.');
      }
  }else{
    customColor ='none';
  }
  if(url == '') $('#error-icalendar-url').html('This field is required.');
  if(name == '') $('#error-icalendar-name').html('This field is required.');
  if(color == '') $('#error-dtpc-color').html('This field is required.');
  //checkCustomColor();
  else
  $.ajax({
      type: "POST",
      url: APP_URL+'/admin/ajax-icalender-import/'+property_id,
      data: {'url':url, 'name':name,'property_id':property_id,'color':color,'customcolor':customColor},
      success: function(msg){
          if(msg.status==1){
            $('#icalendar-model-message').html(msg.success_message);
            $('#icalendar-model-message').show();
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


//Icalendar Modal Code End here

//Icalendar Export Modal Code Starts here

$(document.body).on('click', '#export_icalendar', function(){
    $('#calendar_export_package').modal();
});

//Icalendar Export Modal Code Ends here

$(document.body).on('submit', "#dtpc_form", function(e){
  e.preventDefault();

  $('#error-dtpc-start').html('');
  $('#error-dtpc-end').html('');
  $('#error-dtpc-price').html('');
  $('#error-dtpc-minstay').html('');
  var start_date  = $('#dtpc_start_admin').val();
  var end_date    = $('#dtpc_end_admin').val();
  var price       = $('#dtpc_price').val();
  var status      = $('#dtpc_status').val();
  var min_stay    = $('#dtpc_minstay_admin').val();
  var property_id = $('#dtpc_property_id').val();
  var url         = APP_URL + '/admin/ajax-calender-price/' + property_id;
  var token       = $('input[name="_token"]').val();

  if(start_date == '') $('#error-dtpc-start').html('Start date not given.');
  if(end_date == '') $('#error-dtpc-end').html('End date not given.');
  if(price == '') $('#error-dtpc-price').html('Price not given.');
  if(start_date != '' && end_date != '' && price != '' && status != ''){
    $.ajax({
        type: "POST",
        url: url,
        data: { "_token": token, 'start_date':start_date, 'end_date':end_date, 'price':price, 'min_stay':min_stay, 'status':status},
        success: function(msg) {
              var year_month = $('#calendar_dropdown').val();
              year_month = year_month.split('-');
              var year = year_month[0];
              var month = year_month[1];
              set_calendars(month, year);
              $('#model-message').removeClass('alert-danger');
              $('#model-message').addClass('alert-success');
              $('#model-message').html("Data save successfully");
              $("#hotel_date_package_admin").modal("hide");
        },
        error: function(request, error) {

          $('#error-dtpc-start_date, #error-dtpc-end_date, #error-dtpc-price, #error-dtpc-status, #error-dtpc-stay').html('');
          console.log(request);
          if ([400, 422].includes(request.status) && request.responseJSON.errors) {
                let errors = request.responseJSON.errors;
                for (var field in errors) {
                    $('#error-dtpc-' + field).html(errors[field][0]);
                }
            } else {

                let errorMessage = request.responseJSON?.message || 'An error occurred';
                $('#model-message').html(errorMessage).removeClass('d-none bg-success').addClass('bg-danger');
            }
        
            $('#price_btn').removeClass('disabled');
            $("#price_spinner").addClass('d-none');
            $("#price_next-text").text("Submit");
        }
    });
  }
});

function set_calendars(month, year){
  var property_id = $('#dtpc_property_id').val();
  var dataURL = APP_URL+'/admin/ajax-calender/'+property_id;
  var token = $('input[name="_token"]').val();
  var calendar = '';
  $.ajax({
    url: dataURL,
    data: {"_token":token, 'month': month, 'year': year},
    type: 'post',
    dataType: 'json',
    success: function (result) {
      $('#calender-dv').html(result.calendar);
    },
    error: function (request, error) {
    }
  });
}

$(document).on('click', '.month-nav-next', function(e){
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendars(month, year);
});

$(document).on('click', '.month-nav-previous', function(e){
  e.preventDefault();
  var year = $(this).attr('data-year');
  var month = $(this).attr('data-month');
  set_calendars(month, year);
});


