"use strict"
    $(function() {
            var checkin = $('#startDate').val();
            var checkout = $('#endDate').val();
			dateRangeBtn(checkin,checkout, null, dateFormat);
	});
    $.fn.slider = null;


    $("#price-range").on("slideStop", function(slideEvt) {
        var range       = $('#price-range').attr('data-value');
        range           = range.split(',');
        var min_price       = range[0];
        var max_price       = range[1];
        $('#minPrice').html(min_price);
        $('#maxPrice').html(max_price);
    });

    $('#header-search-form').on('change', function(){
        allowRefresh = true;
        deleteMarkers();
        getProperties($('#map_view').locationpicker('map').map);
    });

    $("#search-pg-checkin").datepicker({
        minDate: 0,
        onSelect: function(e) {
            var t = $("#search-pg-checkin").datepicker("getDate");
            t.setDate(t.getDate() + 1), $("#search-pg-checkout").datepicker("option", "minDate", t), setTimeout(function() {
                $("#search-pg-checkout").datepicker("show")
            }, 20);
            allowRefresh = true;
            loadPage = loadPage;
            getProperties($('#map_view').locationpicker('map').map);
        }
    });

    $("#search-pg-checkout").datepicker({
        dateFormat:dateFormat,
        minDate: 1,
        onClose: function() {
            var e = $("#checkin").datepicker("getDate"),
                t = $("#header-search-checkout").datepicker("getDate");
            if (e >= t) {
                var a = $("#search-pg-checkout").datepicker("option", "minDate");
                $("#search-pg-checkout").datepicker("setDate", a)
            }
        }, onSelect: function(){
            allowRefresh = true;
            loadPage = loadPage;
            getProperties($('#map_view').locationpicker('map').map);
        }
    });

    $(document.body).on('click', '.page-data', function(e){
        e.preventDefault();
        var hr = $(this).attr('href');
        loadPage = hr;
        allowRefresh = true;
        getProperties($('#map_view').locationpicker('map').map, hr);
    });

    function addMarker(map, features){

        var infowindow = new google.maps.InfoWindow();
        for (var i = 0, feature; feature = features[i]; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(feature.latitude, feature.longitude),
                icon: feature.icon !== undefined ? feature.icon : undefined,
                map: map,
                title: feature.title !== undefined? feature.title : undefined,
                content: feature.content !== undefined? feature.content : undefined,
            });
            markers.push(marker);

            google.maps.event.addListener(marker, 'click', function (e) {

                if (this.content){
                    infowindow.setContent(this.content);
                    infowindow.open(map, this);
                }
            });

        }
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }

    function moneyFormat(symbol, value) {
        var val = '';
        if (symbolPosition == "before") {
            val = symbol + ' ' + value;
        } else {
            val = value + ' ' + symbol;
        }
        return val;
    }

       
    function getProperties(map, url){

        if (loadPage) {
            url = url||'';
        var p = map;
        var t = p.getBounds();
        if (t != undefined) {
            var a = p.getZoom(),
                o = t.getSouthWest().lat(),
                i = t.getSouthWest().lng(),
                s = t.getNorthEast().lat(),
                r = t.getNorthEast().lng(),
                l = t.getCenter().lat(),
                n = t.getCenter().lng();
            var map_details = a + "~" + t + "~" + o + "~" + i + "~" + s + "~" + r + "~" + l + "~" + n;
        } else {

            var map_details = '';

        }


        map_loc = t;
        var range       = $('#price-range').attr('data-value');
        range           = range.split(',');
        var location    = $('#front-search-field').val();

        //Input Search value set
        $('#header-search-form').val(location);
        //Input Search value set
        var min_price       = range[0];
        var max_price       = range[1];
        $('#minPrice').html(min_price);
        $('#maxPrice').html(max_price);

        var amenities       = getCheckedValueArray('amenities');
        var property_type   = getCheckedValueArray('property_type');
        var book_type       = getCheckedValueArray('book_type');
        var space_type      = getCheckedValueArray('space_type');
        var beds            = $('#map-search-min-beds').val();
        var bathrooms       = $('#map-search-min-bathrooms').val();
        var bedrooms        = $('#map-search-min-bedrooms').val();
        var checkin         = $('#startDate').val();
        var checkout        = $('#endDate').val();
        var guest           = $('#front-search-guests').val();
        var dataURL = loadPage;
        if ($('#more_filters').css('display') != 'none'){
            $.ajax({
                url: dataURL,
                data: {
                    "_token": token,
                    'location': location,
                    'min_price': min_price,
                    'max_price': max_price,
                    'amenities': amenities,
                    'property_type': property_type,
                    'book_type':book_type,
                    'space_type': space_type,
                    'beds': beds,
                    'bathrooms': bathrooms,
                    'bedrooms': bedrooms,
                    'checkin': checkin,
                    'checkout': checkout,
                    'guest': guest,
                    'map_details': map_details
                },
                type: 'post',
                dataType: 'json',
                beforeSend: function (){
                    $('#properties_show').html("");
                    show_loader();
                },
                success: function (result) {
                    $('#page-total').html(result.total);
                    $('#page-from').html(result.from);
                    $('#page-to').html(result.to);

                    allowRefresh = false;

                    var pager = '';
                    if (result.total > 0) {
                        if (result.current_page > 1 ) pager +=  '<li class="page-item"><a class="page-data page-link" href="'+result.prev_page_url+'">Previous</a></li>';
                        if (result.current_page){
                            for (var i=1; i<= result.last_page; i++){
                                if (result.current_page == i) {
                                    pager +=  '<li class="page-item active"><a  href="'+APP_URL+'/search/result?page='+i+'" class="page-data page-link">'+i+'</a></li>';
                                } else {
                                    pager +=  '<li class="page-item"><a  href="'+APP_URL+'/search/result?page='+i+'" class="page-data page-link">'+i+'</a></li>';

                                }
                            }
                        }

                        if (result.next_page_url) pager +=  '<li class="page-item"><a class="page-data page-link" href="'+result.next_page_url+'">Next</a></li>';
                        $('#pager').html(pager);
                        $('#pagination').removeClass('d-none');
                    } else {
                        $('#pagination').addClass('d-none');
                    }


                    var properties = result.data;
                    var room_point = [];
                    var room_div   = "";
                    for (var key in properties) {
                        if (properties.hasOwnProperty(key)) {
                            room_point[key] = {
                                latitude: properties[key].property_address.latitude,
                                longitude: properties[key].property_address.longitude,
                                title: properties[key].name,

                                content: '<a href="'+APP_URL+'/properties/'+properties[key].slug+'?checkin='+checkin+'&checkout='+checkout+'&guests='+guest+'" class="media-cover" target="_blank">'
                                +'<img class="map-property-img" src="'+properties[key].cover_photo+'"alt="'+properties[key].name+'">'
                                +'</a>'
                                +'<div class="map-property-name">'
                                    +'<div class="col-xs-12 p-1">'
                                        +'<div class="location-title"><h5>'+properties[key].name+'</h5></div>'
                                    +'</div>'
                                +'</div>'
                            };

                            var avg_rating = properties[key].avg_rating;
                            var reviews_count = 0;
                            if(properties[key].reviews_count == 1) reviews_count = properties[key].reviews_count;
                            else if(properties[key].reviews_count > 0) reviews_count = properties[key].reviews_count;

                                var moneySymbol = properties[key].property_price.default_symbol;
                                var price       = properties[key].property_price.price;
                                var symbolWithPrice = moneyFormat(moneySymbol, price);
                                var color = properties[key].book_mark ? '#1dbf73' : '';
                                var colDiv ='col-md-6 col-lg-4 p-2';
                                var divCol = $('#listCol').hasClass('col-md-7');
                                if (user_id != "") {
                                    var div =  '<a class="btn btn-sm book_mark_change" data-status="'+properties[key].book_mark +'" data-id="'+properties[key].id+'" style="color:'+ color +'">'
                                    +'<span style="font-size: 22px;">'
                                    +'<i class="fas fa-heart pl-2"></i></span></a>'
                                } else {
                                    var div = '<a class="btn btn-sm book_mark_change" data-id="'+properties[key].id+'" style="color: #">'
                                            +'<span style="font-size: 22px;">'
                                            +'<i class="fas fa-heart pl-2"></i></span></a>';
                                }

                                if (divCol == false) {
                                    room_div += '<div class="col-md-6 col-lg-3 p-2 pl-4 pr-4 mt-4">'
                                                +'<div class="card h-100">'
                                                    +'<div class="grid">'
                                                        +'<a href="'+APP_URL+'/properties/'+properties[key].slug+'?checkin='+checkin+'&checkout='+checkout+'&guests='+guest+'" target="_blank">'
                                                        +'<figure class="effect-milo">'
                                                            +'<img src="'+properties[key].cover_photo+'" class="room-image-container200 rounded " alt="'+properties[key].name+'"/>'
                                                            +'<figcaption>'
                                                            +'</figcaption>'
                                                        +'</figure>'
                                                        +'</a>'
                                                    +'</div>'
                                                    +'<div class="card-body p-0 pl-1 pr-1">'
                                                        +'<div class="d-flex">'
                                                            +'<div>'
                                                                +'<div class="pl-2 pr-1">'
                                                                    +'<a href="'+APP_URL+'/users/show/'+properties[key].host_id+'"><img src="'+properties[key].users.profile_src+'" class="img-60x60 rounded-circle" alt="profile-image"></a>'
                                                                +'</div>'
                                                            +'</div>'

                                                            +'<div class="p-2 text">'
                                                                +'<a class="text-color text-color-hover" href="'+APP_URL+'/properties/'+properties[key].slug+'?checkin='+checkin+'&checkout='+checkout+'&guests='+guest+'" target="_blank">'
                                                                    +'<h4 class="text-16 font-weight-700 text">' +properties[key].name+'</h4>'
                                                                +'</a>'
                                                                +'<p class="text-13 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> '+ properties[key].property_address.address_line_1+'</p>'
                                                            +'</div>'
                                                        +'</div>'

                                                        +'<div class="review-0 p-3">'
                                                            +'<div class="d-flex justify-content-between">'
                                                                +'<div class="d-flex">'
                                                                    +'<div class="d-flex align-items-center">'
                                                                        +'<span><i class="fa fa-star text-14 secondary-text-color"></i>'+' '+ avg_rating
                                                                        +' '+ '('+reviews_count+')</span>'
                                                                    +'</div>'
                                    +'<div>'
                                    +div
                                        +'</div>'
                                        +'</div>'
                                                                
                                                                +'<div>'
                                                                    +'<span class="font-weight-700 text-18">'+symbolWithPrice+'</span> /' + nightText
                                                                +'</div>'
                                                            +'</div>'
                                                        +'</div>'

                                                        +'<div class="card-footer text-muted p-0 border-0">'
                                                            +'<div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">'
                                                                +'<div>'
                                                                +'<ul class="list-inline">'
                                                                    +'<li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-1 bg-light text-dark">'
                                                                        +'<div class="vtooltip"> <i class="fas fa-user-friends"></i> '+properties[key].accommodates +''
                                                                        +'<span class="vtooltiptext text-14">'+properties[key].accommodates +guestText+'</span>'
                                                                    +'</div>'
                                                                +'</li>'

                                                                    +'<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-1 bg-light">'
                                                                    +'<div class="vtooltip"> <i class="fas fa-bed"></i> '+properties[key].bedrooms+''
                                                                        +'<span class="vtooltiptext  text-14">' +properties[key].bedrooms+ bedroomsText+'</span>'
                                                                    +'</div>'
                                                                    +'</li>'

                                                                    +'<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-1 bg-light">'
                                                                    +'<div class="vtooltip"> <i class="fas fa-bath"></i> '+' '+properties[key].bathrooms+''
                                                                        +'<span class="vtooltiptext  text-14 p-2">'+properties[key].bathrooms+ bedroomsText +'</span>'
                                                                    +'</div>'
                                                                    +'</li>'
                                                                +'</ul>'
                                                                +'</div>'
                                                            +'</div>'
                                                        +'</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                +'</div>';
                                } else {
                                    room_div +='<div class="col-sm-6 col-md-12 col-lg-12  p-0 mb-4">'
                                                +'<div class=" row  border p-2 rounded-3">'
                                                    +'<div class="col-lg-5 p-2">'
                                                        +'<div class="img-event">'
                                                            +'<a href="'+APP_URL+'/properties/'+properties[key].slug+'?checkin='+checkin+'&checkout='+checkout+'&guests='+guest+'" target="_blank">'
                                                                +'<img class="room-image-container200 rounded" src="'+properties[key].cover_photo+'" alt="'+properties[key].name+'">'
                                                            +'</a>'
                                                        +'</div>'
                                                    +'</div>'

                                                    +'<div class="col-lg-7 p-2">'
                                                        +'<div class="row justify-content-between">'
                                                            +'<div class="col-sm-12 pl-0">'
                                                                +'<a href="'+APP_URL+'/properties/'+properties[key].slug+'?checkin='+checkin+'&checkout='+checkout+'&guests='+guest+'" target="_blank">'
                                                                    +'<p class="mb-0 text-18 text-color font-weight-700 text-color-hover text">' +properties[key].name+'</p>'
                                                                +'</a>'
                                                            +'</div>'
                                                        +'</div>'

                                                        +'<p class="text-14 mt-3 text-muted">'
                                                            +'<i class="fas fa-map-marker-alt"></i>'
                                                            +' ' + properties[key].property_address.address_line_1
                                                        +'</p>'

                                                        +'<div class="review-0 p-3">'
                                                            +'<div class="d-flex justify-content-between">'
                                                               
                                                                    +'<div class="d-flex align-items-center">'
                                                                    +'<div class="d-flex">'
                                                                        +'<span><i class="fa fa-star text-14 secondary-text-color"></i>'+' '+ avg_rating
                                                                        +' '+ '('+reviews_count+')</span>'
                                                                    +'</div>'
                                    +'<div>'
                                    +div
                                        +'</div>'
                                        +'</div>'

                                                                
                                                                +'<div>'
                                                                    +'<span class="font-weight-700 text-18">'+symbolWithPrice+'</span> /' + nightText
                                                                +'</div>'
                                                            +'</div>'
                                                        +'</div>'

                                                        +'<ul class="list-inline mt-2 pb-3">'
                                                            +'<li class="list-inline-item border rounded-3 p-1 mt-4 pl-3 pr-3">'
                                                                +'<p class="text-center mb-0">'
                                                                    +'<i class="fas fa-user-friends text-20 d-none d-sm-inline-block text-muted"></i> '
                                                                    +properties[key].accommodates
                                                                    +'<span class=" text-14 font-weight-700">'+guestText+'</span>'
                                                                +'</p>'
                                                            +'</li>'
                                                            +'<li class="list-inline-item  border rounded-3 mt-4 p-1  pl-3 pr-3">'
                                                                +'<p  class="text-center mb-0" >'
                                                                    +'<i class="fas fa-bed d-none d-sm-inline-block text-20 text-muted"></i> '
                                                                    +properties[key].bedrooms
                                                                    +'<span class=" text-14 font-weight-700"> '+bedroomsText+'</span>'
                                                                +'</p>'
                                                            +'</li>'
                                                            +'<li class="list-inline-item  border rounded-3 mt-4 p-1  pl-3 pr-3">'
                                                                +'<p  class="text-center mb-0">'
                                                                    +'<i class="fas fa-bath text-20  d-none d-sm-inline-block  text-muted"></i> '
                                                                    +properties[key].bathrooms
                                                                    +'<span class="text-14 font-weight-700"> '+bathroomsText+'</span>'
                                                                +'</p>'
                                                            +'</li>'
                                                        +'</ul>'
                                                    +'</div>'
                                                +'</div>'
                                            +'</div>'
                            }
                        }
                    }

                        if (room_div != '') $('#properties_show').html(room_div);
                        else $('#properties_show').html(' <div class="text-center justify-content-center w-100 position-center"><img src="'+notFoundImage+'" class="img-fluid not-found" alt="not-found"><h4 class="text-center text-20 font-weight-700">'+noResult+'</h4></div>');

                        //deleteMarkers();
                        addMarker(map, room_point);
                    },
                    error: function (request, error) {
                        allowRefresh = false;
                        // This callback function will trigger on unsuccessful action
                    },
                    complete: function(){
                        hide_loader();
                    }
            });
        }

        }


    }

    $('#btnBook, #btnRoom, #btnPrice, .filter-apply').on('click', function(){
        allowRefresh = true;
        deleteMarkers();
        loadPage = loadPage;
        getProperties($('#map_view').locationpicker('map').map);
        $('.room_filter').addClass('display-off');
        $('#more_filters').show();
        $('.dropdown-menu-price').removeClass('show');
    });


    function getCheckedValueArray(field_name){
        var array_Value = '';
        array_Value = $('input[name="' + field_name + '[]"]:checked').map(function() {
            return this.value;
        })
            .get()
            .join(',');

        return array_Value;
    }

    $(document.body).on('click','#map_view',function(){
        allowRefresh = true;
        loadPage = loadPage;
        getProperties($('#map_view').locationpicker('map').map);
    });

    var zoom = 12;

    if (screen.width < 1366) { 

        if (screen.height < 768) { 
            zoom = 10;
        } else {
            zoom = 11;
        }
    } else if (screen.height < 768) {

        if (screen.width < 1366) {

             zoom = 11;

        } else {

            zoom = 10;
        }
    }

    $('#map_view').locationpicker({
        
        location: {
            latitude: latitude,
            longitude: longitude
        },
        radius: 0,
        zoom: zoom,
        addressFormat: "",
        markerVisible: false,
        markerInCenter: false,
        inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude'),
            locationNameInput: $('#address_line_1')
        },
        enableAutocomplete: true,
        draggable: true,
        onclick: function (currentLocation, radius, isMarkerDropped) {
            if (allowRefresh == true) {
                getProperties($(this).locationpicker('map').map);
            }
        },

        oninitialized: function (component) {
            var addressComponents = $(component).locationpicker('map').location.addressComponents;
        }
    });

    $('.slider-selection').trigger('click');

    function show_loader(){
        $('#loader').removeClass('display-off');
        $('#pagination').hide();
    }

    function hide_loader(){
        $('#loader').addClass('display-off');
        $('#pagination').show();
    }

    // Map Close
    $('#closeMap').on('click', function(){
        $('#listCol').removeClass('col-md-7');
        $('#listCol').addClass('col-md-12');
        $('#mapCol').addClass('d-none');
        $('#showMap').removeClass('d-none');

        allowRefresh = true;
        loadPage = loadPage;
        getProperties($('#map_view').locationpicker('map').map);

    });
    // Map show
    $('#showMap').on('click', function(){
        $('#listCol').removeClass('col-md-12');
        $('#listCol').addClass('col-md-7');
        $('#mapCol').removeClass('d-none');
        $('#showMap').addClass('d-none');
        allowRefresh = true;
        loadPage = loadPage;
        getProperties($('#map_view').locationpicker('map').map);
    });

    $( window ).on( "load", function() {
            allowRefresh = true;
            loadPage = loadPage;
            getProperties($('#map_view').locationpicker('map').map);
    });

    $(document).on('click', '.dropdown-menu-price', function (e) {
        e.stopPropagation();
    });

