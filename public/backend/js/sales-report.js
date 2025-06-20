"use strict"
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Sales of Past 12 Months'
    },
    subtitle: {
        text: 'Total Income ' + currencyCode +' '+ totalIncome +' for ' + totalNight + ' Nights'
    },
    xAxis: {
        categories: jQuery.parseJSON(months)
    },
    yAxis: {
        title: {
            text: 'Nights per Month'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    }, // optional
    series: [{
        name: 'Nights',
        data: jQuery.parseJSON(monthlyNights) //[22.0, 4.9, 4.5, 54.5, 8.4, 11.5, 24.2, 21.5, 28.3, 28.3, 12.9, 3.6]
    }]
});