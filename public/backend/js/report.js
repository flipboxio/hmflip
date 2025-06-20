"use strict"
$('.select2').select2({
    // minimumInputLength: 3,
      ajax: {
        url: 'reports/property-search',
        processResults: function (data) {
          $('#property').val('DSD');
          return {
            results: data
          };
        }
      }
  
  
    });
    // based on prepared DOM, initialize echarts instance
	var myChart = echarts.init(document.getElementById('main'));
	var app = {};
	var option = null;
	
	// specify chart configuration item and data
	option = {
		title: {
			text: "{{ $totalReservations }} Reservations",
			subtext: "Reservation Numbers from \nAll Customers Rigions",
			left: 'center',
			top: 'top'
		},
		tooltip: {
			trigger: 'item',
			formatter: function (params) {
				var value = (params.value + '').split('.');  
				if (value[0] == "NaN") {
					value[0] = 0;
				} else {
					value = value[0];
				}       
				return params.seriesName + '<br/>' + params.name + ' : ' + value;
			}
		},
		toolbox: {
			show: false,
			orient: 'vertical',
			left: 'right',
			top: 'center',
			feature: {
				dataView: {
					show: true,
					lang: ['Data view', 'Turn Off', 'Refresh'],  
					title: "View",
					readOnly: false,
				},
				restore: {
					title: "Restore"
				},
				saveAsImage: {
					title: 'Save'
				},
				
			}
		},
		visualMap: {
			min: 0,
			max: 1000000,
			text:['High','Low'],
			realtime: false,
			calculable: true,
			inRange: {
				color: ['lightskyblue','yellow', 'orangered']
			}
		},
		series: [
		{
			name: 'Total Reservations',
			type: 'map',
			mapType: 'world',
			roam: true,
			itemStyle:{
				emphasis:{label:{show:true}}
			},
			data: jQuery.parseJSON($('#collections').val())
		}
		]
	};
	
	// use configuration item and data specified to show chart
	if (option && typeof option === "object") {
		myChart.setOption(option, true);
	}
	
	$(window).on('resize', function(){
		if(myChart != null && myChart != undefined){
			myChart.resize();
		}
	});
	
	// Select 2 for property search
	$('.select2').select2({
		ajax: {
			url: 'reports/property-search',
			processResults: function (data) {
				$('#property').val('DSD');
				return {
					results: data
				};
			}
		}
	});
	
	// Date Time range picker for filter
	$(function() {
		// * Set the time range for daterangepicker
		var startDate      = $('#startDate').val();
		var endDate        = $('#endDate').val();
		dateRangeBtn(startDate,endDate, 1);
		formDate (startDate, endDate);
	});

    
