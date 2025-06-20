"use strict"
if (page == 'customer_booking') {

    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    
    $('.select2').select2({
		ajax: {
			url: 'property_search',
			type:'post',
			processResults: function (data) {
				$('#property').val('DSD');
				return {
					results: data
				};
			}
		}
	});
} else if(page == 'customer') {

    $('.select2').select2({
        ajax: {
            url: 'bookings/customer_search',
            processResults: function (data) {
                $('#customer').val('DSD');
                return {
                    results: data
                };
            }
        }
    });

} else {
    $('.select2').select2({
        ajax: {
            url: 'bookings/property_search',
            processResults: function (data) {
                $('#property').val('DSD');
                return {
                    results: data
                };
            }
        }
    });
    
}

$('.select2customer').select2({
ajax: {
    url: 'bookings/customer_search',
    processResults: function (data) {
    $('#customer').val('DSD');
    return {
        results: data
    };
    }
}
});
