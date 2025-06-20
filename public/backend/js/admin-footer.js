"use strict"

$(document).on('click', '.delete-warning', function(e){
	e.preventDefault();
	var url = $(this).attr('href');
	$('#delete-modal-yes').attr('href', url)
	$('#delete-warning-modal').modal('show');
});

$('.email_status').hide();
$('.error_email_settings').hide();
	
$(".flash-container").fadeTo(20000, 500).slideUp(500, function(){
	$(".flash-container").slideUp(500);
});