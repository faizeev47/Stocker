function getArrays(chart){
  let labels = [];
  let high = [];
  let low = [];
  let open = [];
  let close = [];
  let prices = [];
  let l = chart.length;
  for (let i = 0; i < l; i++){
    labels[i] = chart[i].label;
    high[i] = chart[i].high;
    low[i] = chart[i].low;
    open[i] = chart[i].open;
    close[i] = chart[i].close;
    prices[i] = (chart[i].high + chart[i].low)/2;
  }
  return {"labels":labels, "high":high, "low":low, "open":open, "close":close, "prices":prices};
}

function next100Days(dateString){
  var dates = [];
  let date_array = dateString.split('-');
  let startDate = new Date();
  startDate.setFullYear(parseInt(date_array[0]), parseInt(date_array[1]), parseInt(date_array[2]));
  startDate.setDate(startDate.getDate() + 1);
  for(var i = 1; i <= 365; i++){
    let ith_date = new Date();
    ith_date.setDate(startDate.getDate() + i);
    dates[i] =  months[ith_date.getMonth()] + " " + ith_date.getDate() + ", " + ith_date.getFullYear();
  }
  return dates;
}

function regressionAnalysis(arrays, days){
  let l = arrays.labels.length;
  let y = arrays.prices.slice(l-parseInt(days), l);
  let x = [];
  for (let i = 0; i < parseInt(days) ; i++){
    x[i] = i + 1;
  }

  let sum_xy = 0;
  let sum_x = 0;
  let sum_y = 0;
  let sum_xsqr = 0;
  let n = x.length;
  for(let i = 0; i < n; i++){
    sum_xy += (x[i] * y[i]);
    sum_x += x[i];
    sum_y += y[i];
    sum_xsqr += (x[i]*x[i]);
  }
  let m = ( (n * sum_xy) - ( sum_x * sum_y) ) / ( (n * sum_xsqr) - (sum_x * sum_x));
  let c = ( (sum_y * sum_xsqr) - (sum_x * sum_xy)) / ( (n * sum_xsqr) - (sum_x * sum_x));

  let y_pred = []
  for(let i = n,  day = 1; i < n + 365; i++, day++){
    x[i] = i + 1;
    y_pred[day-1] = (m * x[i]) + c;
  }
  return {'y':y_pred, 'days':parseInt(days)};
}



function createDayGraph(canvas, timeString, arrays, days){
  days = parseInt(days);
  let totalDays =  arrays.labels.length;
  Highcharts.chart(canvas,{
    chart: {
        zoomType: 'x'
    },
    subtitle: {
        text: document.ontouchstart === undefined ?
            'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
    },
    tooltip: {
      valueDecimals: 2,
      valuePrefix: '$'
    },
    xAxis: {categories: arrays.labels.slice(totalDays - days + 1, totalDays),
            title: {
              text: 'Dates'
            }},
    title: {text: 'Price History for '+timeString},
    yAxis: {title: {
              text: 'Prices ($)'
    }},
    series: [{
        type: 'line',
        name: 'Average',
        data: arrays.prices.slice(totalDays - days + 1, totalDays),
        marker: {enabled: false},
        states: { hover: {lineWidth: 0}}
    },{
        type: 'line',
        name: 'High',
        data: arrays.high.slice(totalDays - days + 1, totalDays),
        marker: {enabled: false},
    },{
        type: 'line',
        name: 'Low',
        data: arrays.low.slice(totalDays - days + 1, totalDays),
        marker: {enabled: false},
        states: { hover: {lineWidth: 0}}
    },{
        type: 'line',
        name: 'Open',
        data: arrays.open.slice(totalDays - days + 1, totalDays),
        marker: {enabled: false},
        states: { hover: {lineWidth: 0}}
    },{
        type: 'line',
        name: 'Close',
        data: arrays.close.slice(totalDays - days + 1, totalDays),
        marker: {enabled: false},
        states: { hover: {lineWidth: 0}}
    }
  ]
  });
}
