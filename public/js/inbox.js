"use strict"
    var ls = localStorage.getItem("selected");
	var selected = false;
	var list = document.querySelectorAll(".list"),
	content = document.querySelector(".content-inbox"),
	input = document.querySelector(".message-footer input"),
	open = document.querySelector(".open a");
	//process
	function process() {
	    if (ls != null) {
	        selected = true;
	        click(list[ls], ls);
	    }
	    if (!selected) {
	        click(list[0], 0);
	    }

	    list.forEach ((l,i) => {
	        l.addEventListener("click", function() {
	            click(l, i);
	        });
	    });

	    try {
	        document.querySelector(".list.active").scrollIntoView(false);
	    }
	    catch {}

	}
	process();

	//list click
	function click(l, index) {
	    list.forEach(x => { x.classList.remove("active"); });
	        if (l) {
	            l.classList.add("active");
	            document.querySelector("sidebar").classList.remove("opened");
	            open.innerText="UP";
	        document.querySelector(".message-wrap").scrollTop = document.querySelector(".message-wrap").scrollHeight;
	        localStorage.setItem("selected", index);
	    }
	}

	open.addEventListener("click", (e) => {
	    const sidebar = document.querySelector("sidebar");
	    sidebar.classList.toggle("opened");
	    if (sidebar.classList.value == 'opened')
	        e.target.innerText = "DOWN";
	    else
	        e.target.innerText = "UP";
	});

	$(document).on('click', '.conversassion', function(){
	    var id = $(this).data('id');
	    var dataURL = APP_URL+'/messaging/booking';
	    $.ajax({
	        url: dataURL,
	        data:{
	            "_token": token,
	            'id':id,
	        },
	        type: 'post',
	        dataType: 'json',
	        success: function(data) {
	            $('#msg-'+id).removeClass('text-success');
	            $('#messages').empty().html(data['inbox']);
	            $('#booking').empty().html(data['booking']);
	        }
	    })
	});

	$(document).on('click', '.chat', function(){
		var msg 		= $('.cht_msg').val();
		var booking_id  = $(this).data('booking');
		var receiver_id = $(this).data('receiver');
		var property_id = $(this).data('property');

		var result = '<div class="msg pl-2 pr-2 pb-2 pt-2 mb-2">'
						+'<p class="m-0">'+sanitize(msg)+'</p>'
					+'</div>'
					+'<div class="time">just now</div>'

		var dataURL = APP_URL+'/messaging/reply';
		$.ajax({
			url: dataURL,
			data:{
				"_token": token,
				'msg':msg,
				'booking_id':booking_id,
				'receiver_id':receiver_id,
				'property_id':property_id,
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {

				$('.msg_txt').append(result);
				$('.cht_msg').val("");
			}
		})
	});

	$(".cht_msg").on('keyup', function(event) {
	    if (event.which===13) {
	        $('.chat').trigger("click");
	    }
	});
    function sanitize(string) {
        const symbols = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;',
            "/": '&#x2F;',
        };
        const regex = /[&<>"'/]/ig;
        return string.replace(regex, (match)=>(symbols[match]));
    }