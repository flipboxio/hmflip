"use strict"
if (page == 'payout') {
    $('.delete-confirm').on("click", function(event) {
        var form =  $(this).closest("form");
        var name = $(this).data("name");
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
                $('#payoutAccountId').val($(this).data("id"))
                $("#delete-payout-form").trigger("submit");
            }
        });
    });

    $("select#payout_type").on('change', function(){
        var payout = $( "#payout_type" ).val();
        if (payout == 1) {

            $("#acc_holder, #branch, #branch_c, #acc_number, #swift, #branch_ad, #bank, #country_id").addClass("d-none");
            $("#email_id").removeClass("d-none");

        } else {

            $("#acc_holder, #branch, #branch_c, #acc_number, #swift, #branch_ad, #bank, #country_id").removeClass("d-none");
            $("#email_id").addClass("d-none");
        }
    });

    $('#add_payout_setting').validate({
        rules: {
            bank_account_holder_name: {
                required: true,
                maxlength: 255
            },
            bank_account_number: {
                required: true,
                maxlength: 255
            },
            swift_code: {
                required: true,
                maxlength: 255
            },
            branch_city: {
                required: true,
                maxlength: 255
            },
            branch_address: {
                required: true,
                maxlength: 255
            },
            branch_name: {
                required: true,
                maxlength: 255
            },
            bank_name: {
                required: true,
                maxlength: 255
            }
        },
        submitHandler: function(form)
        {
            $("#save_btn").on("click", function (e)
            {
                $("#save_btn").attr("disabled", true);
                e.preventDefault();
            });

            $(".spinner").removeClass('d-none');
            $("#save_btn-text").text(saveText);
            return true;
        },

    });

    $('#add_payout_setting').validate({
        rules:{
            email:{
                required:true,
            }
        }
    });

    $(document).on('click', '.editmodal', function() {
        var obj = $(this).data("obj");
        $('#edit_id').val(obj['id']);
        $('#edit_acc_holder').val(obj['account_name']);
        $('#edit_branch_name').val(obj['bank_branch_name']);
        $('#edit_branch_address').val(obj['bank_branch_address']);
        $('#edit_bank_name').val(obj['bank_name']);
        $('#edit_swift_code').val(obj['swift_code']);
        $('#edit_branch_city').val(obj['bank_branch_city']);
        $('#edit_account_number').val(obj['account_number']);
        $('#edit_country').val(obj['country']);
        $('#edit_payout_setting').validate({
            rules: {
                bank_account_holder_name: {
                    required: true,
                    maxlength: 255,
                    minlength: 5,

                },
                bank_account_number: {
                    required: true,
                    maxlength: 255,
                    minlength: 3,

                },
                swift_code: {
                    required: true,
                    maxlength: 255,
                    minlength: 3,

                },
                branch_city: {
                    required: true,
                    maxlength: 255,
                    minlength: 5,

                },
                branch_address: {
                    required: true,
                    maxlength: 255,
                    minlength: 5,

                },
                branch_name: {
                    required: true,
                    maxlength: 255,
                    minlength: 5,

                },
                bank_name: {
                    required: true,
                    maxlength: 255,
                    minlength: 5,

                }
            },
            submitHandler: function(form)
            {
                $("#edit_save_btn").on("click", function (e)
                {
                    $("#edit_save_btn").attr("disabled", true);
                    e.preventDefault();
                });

                $(".spinner").removeClass('d-none');
                $("#edit_save_btn-text").text(saveText);
                return true;
            }
        });

    });

    $(document).on('click', '.editmodal2', function() {
        var obj = $(this).data("obj");
        $('#edit_id2').val(obj['id']);
        $('#edit_email').val(obj['email']);
        $('#edit_payout_setting2').validate({
            rules:{
                email:{
                    required:true,
                }
            },
            submitHandler: function(form)
            {
                $("#edit_save_btn2").on("click", function (e)
                {
                    $("#edit_save_btn2").attr("disabled", true);
                    e.preventDefault();
                });

                $(".spinner").removeClass('d-none');
                $("#edit_save_btn-text2").text(saveText);
                return true;
            }
        });
    });
} else if (page == 'payoutlists') {
    var dt = 1;
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    dateRangeBtn(startDate,endDate, dt);
    formDate (startDate, endDate);

    $('.no-payout').on('click', function(event) {
		event.preventDefault();
		swal({
			title: noPayoutSettingsText,
			text: addMethodText,
			icon: "warning",
			buttons: {
				cancel: false,
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
	});

    $('#add_payout_request').validate({
        rules: {
            amount: {
                required: true,
                number: true,
                maxlength: 255
            }
        },
        submitHandler: function(form)
        {
             $("#save_btn").on("click", function (e)
            {
                $("#save_btn").attr("disabled", true);
                e.preventDefault();
            });

            $(".spinner").removeClass('d-none');
            $("#save_btn-text").text(saveText);
            return true;
        }
    });

    $('#amount').on('keyup', function() {
        var amount = $(this).val();
        var balance = parseFloat($("#balance").val());
            if ( amount > balance ) {
                    $("#amount_high").removeClass('d-none');
                    $("#next_btn").attr("disabled", true);
            } else if (amount > 0) {
                    $("#next_btn").attr("disabled", false);
                    $("#amount_high").addClass('d-none');
            } else {
                $("#next_btn").attr("disabled", true);
            }
    });

    $('#next_btn').on('click', function(){
			if ($('#next_btn').prop('disabled')) {
					//
				} else {
					$('#paymentDiv').addClass('d-none');
					$('#confirmDiv').removeClass('d-none');

					var payment_method_id = $('#payment_method_id').val();
					var item = payouts.find(item => item.id == payment_method_id );
					var amount = $('#amount').val();

					$('#confirmDiv').html('');

					if (item.type == 4) {
						$('#confirmDiv').html('<div class="row">'
											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700">'+ bank_holder + '  :</strong> ' + item.account_name +'</label>'
												+'</div>'
											+'</div'
											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700">'+ bank_account_num + ' :</strong> '+ item.account_number +'</label>'
												+'</div>'
											+'</div>'

											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700">'+ swift_code +' :</strong> ' +item.swift_code +'</label>'
												+'</div>'
											+'</div>'

											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700">'+ bank_name +':</strong> '+ item.bank_name +'</label>'
												+'</div>'
											+'</div>'

											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label class="font-weight-700">'+totalPayoutText+': <strong  class="pul-right">'+ symbol + ' '+ amount +' </strong></label>'
												+'</div>'
											+'</div>'
										+'</div>'
										+'<div class="row w-100">'
											+'<div class="col-md-12 text-right mt-4">'
												+'<button type="button" class="btn btn-outline-danger text-14 mt-2 pl-4 pr-4 mr-2"  id="back_btn">  Back </button>'
												+'<button type="submit" class="btn vbtn-outline-success text-14 mt-2 pl-4 pr-4 ml-2" id="save_btn"> <i class="spinner fa fa-spinner fa-spin d-none"></i> <span id="save_btn-text">'+ submit +'</span> </button>'
											+'</div>'
										+'</div>'
						);
					} else if (item.type == 1){
						$('#confirmDiv').html('<div class="row">'
											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700">'+ bank_holder + '  :</strong> ' + item.account_name +'</label>'
												+'</div>'
											+'</div'

											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label><strong class="font-weight-700"> Email :</strong> ' +item.email +'</label>'
												+'</div>'
											+'</div>'

											+'<div class="col-md-12">'
												+'<div class="form-group">'
													+'<label class="font-weight-700">'+totalPayoutText+': <strong  class="pul-right">'+ symbol + ' '+ amount +' </strong></label>'
												+'</div>'
											+'</div>'
										+'</div>'
										+'<div class="row w-100">'
											+'<div class="col-md-12 text-right mt-4">'
												+'<button type="button" class="btn btn-outline-danger text-14 mt-2 pl-4 pr-4 mr-2"  id="back_btn">  Back </button>'
												+'<button type="submit" class="btn vbtn-outline-success text-14 mt-2 pl-4 pr-4 ml-2" id="save_btn"> <i class="spinner fa fa-spinner fa-spin d-none"></i> <span id="save_btn-text">'+ submit +'</span> </button>'
											+'</div>'
										+'</div>'
						);
					}
				}
		});

		$(document).on('click','#back_btn', function(){
			$('#paymentDiv').removeClass('d-none');
			$('#confirmDiv').addClass('d-none');
		});

		$('#modalClose, #close').on('click', function(){
			$('#paymentDiv').removeClass('d-none');
			$('#confirmDiv').addClass('d-none');
			$('#amount').val('');
			$("#next_btn").attr("disabled", true);
		});
}