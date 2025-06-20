"use strict"
$(function() {
    var from         = $('#startDate').val();
    var to           = $('#endDate').val();
    if (from) {
        var startDate = moment(from,'MMMM D, YYYY');
        var endDate   = moment(to,'MMMM D, YYYY');
    } else {
        var startDate = moment().subtract(29, 'days');
        var endDate   = moment();
    }

    $('#daterange-btn').daterangepicker(
        {
        ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: startDate,
        endDate  : endDate
        }, function (start, end) {
            var sessionDateFinal = sessionDate.toUpperCase();
            var startDate        = moment(start, 'MMMM D, YYYY').format(sessionDate);
            $('#startfrom').val(startDate);
            var endDate          = moment(end, 'MMMM D, YYYY').format(sessionDate);
            $('#endto').val(endDate);
            $('#daterange-btn span').html(startDate + ' - ' +endDate )
        }
    )

    $(document).ready(function(){
        $('#dataTableBuilder_length').after('<div id="exportArea" class="col-md-4 col-sm-4 "><div class="row mt-m-2"><div class="btn-group btn-margin f-14"><button type="button" class="form-control dropdown-toggle w-60 f-14" data-bs-toggle="dropdown" aria-haspopup="true">Export</button><ul class="dropdown-menu d-menu-min-w"><li><a class="d-block px-3 f-14" href="" title="CSV" id="csv">CSV</a></li><li><a class="d-block px-3 f-14" href="" title="PDF" id="pdf">PDF</a></li></ul></div><div class="btn btn-group btn-refresh w-60 f-14"><a href="" id="tablereload" class="form-control f-14 border-start-0"><span><i class="fa fa-refresh"></i></span></a></div></div></div>');

        if (typeof from == 'undefined') {
             startDate = '';
             endDate   = '';
             from = '';
             to = '';
        } else {
            startDate = from;
             endDate   = to;
        }
        if(startDate=='' && endDate==''){
            $('#daterange-btn span').html('<i class="fa fa-calendar"></i> &nbsp;&nbsp; Pick a date range');
        } else {
            $('#daterange-btn span').html(startDate + ' - ' +endDate );
        }
    });

    //csv convert
    $(document).on("click", "#csv", function(event){
        event.preventDefault();
        if (page == 'booking') {
            var property = $('#property').val();
            var customer = $('#customer').val();
            var status = $('#status').val();
            window.location = "booking/booking_list_csv?to="+to+"&from="+from+"&property="+property+"&status="+status+"&customer="+customer;

        } else if (page == 'review') {
            var property = $('#property').val();
            var reviewer = $('#reviewer').val();
            window.location = "reviews/review_list_csv?to="+to+"&from="+from+"&property="+property+"&reviewer="+reviewer;

        } else if (page == 'customer') {
            var status = $('#status').val();
			var customer = $('#customer').val();
            window.location = "customer/customer_list_csv?to="+to+"&from="+from+"&status="+status+"&customer="+customer;

        } else if (page == 'properties') {
            var space_type = $('#space_type').val();
            var status = $('#status').val();
            window.location = "properties/property_list_csv?to="+to+"&from="+from+"&space_type="+space_type+"&status="+status;

        } else if (page == 'customer_booking') {
            var property = $('#property').val();
		    var status = $('#status').val();
            window.location = user_id+"/booking_list_csv?to="+to+"&from="+from+"&property="+property+"&status="+status+"&user_id="+user_id;

        } else if (page == 'payout') {
            var status = $('#status').val();
            window.location = "payouts/payouts_list_csv?to="+to+"&from="+from+"&status="+status;

        } else if (page == 'customer_payout') {
            var status = $('#status').val();
            window.location = user_id+"/payouts_list_csv?to="+to+"&from="+from+"&status="+status+"&user_id="+user_id;

        } else {
            var space_type = $('#space_type').val();
            var status = $('#status').val();
            window.location = user_id+"/property_list_csv?to="+to+"&from="+from+"&space_type="+space_type+"&status="+status+"&user_id="+user_id;

        }
    });
    //pdf convert
    $(document).on("click", "#pdf", function(event){
        event.preventDefault();
        
        if (page == 'booking') {
            var property = $('#property').val();
            var customer = $('#customer').val();
            var status = $('#status').val();
            window.location = "booking/booking_list_pdf?to="+to+"&from="+from+"&property="+property+"&status="+status+"&customer="+customer;

        } else if (page == 'review') {
            var property = $('#property').val();
            var reviewer = $('#reviewer').val();
            window.location = "reviews/review_list_pdf?to="+to+"&from="+from+"&property="+property+"&reviewer="+reviewer;

        } else if (page == 'customer') {
            var status = $('#status').val();
			var customer = $('#customer').val();
            window.location = "customer/customer_list_pdf?to="+to+"&from="+from+"&status="+status+"&customer="+customer;

        } else if (page == 'properties') {
            var space_type = $('#space_type').val();
            var status = $('#status').val();
            window.location = "properties/property_list_pdf?to="+to+"&from="+from+"&space_type="+space_type+"&status="+status;

        } else if (page == 'customer_booking') {
            var property = $('#property').val();
		    var status = $('#status').val();
            window.location = user_id+"/booking_list_pdf?to="+to+"&from="+from+"&property="+property+"&status="+status+"&user_id="+user_id;

        } else if (page == 'payout') {
            var status = $('#status').val();
            window.location = "payouts/payouts_list_pdf?to="+to+"&from="+from+"&status="+status;

        } else if (page == 'customer_payout') {
            var status = $('#status').val();
            window.location = user_id+"/payouts_list_pdf?to="+to+"&from="+from+"&status="+status+"&user_id="+user_id;

        } else {
            var space_type = $('#space_type').val();
            var status = $('#status').val();
            window.location = user_id+"/property_list_pdf?to="+to+"&from="+from+"&space_type="+space_type+"&status="+status+"&user_id="+user_id;
        }
    });
    //reload Datatable
    $(document).on("click", "#tablereload", function(event){
        event.preventDefault();
        $("#dataTableBuilder").DataTable().ajax.reload();
    });
});