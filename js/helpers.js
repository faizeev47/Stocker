function getPrefix(largeNumber){
  if(largeNumber){
    let num = largeNumber.toString().split(".")[0].length;
    let pow;
    let prefix;
    if (num > 12){pow=12;prefix="T";}
    else if (num > 9){pow=9;prefix="B";}
    else if (num > 6){pow=6;prefix="M";}
    else{return addCommas(largeNumber);}
    let prefixed =  largeNumber / Math.pow(10,pow);
    prefixed = prefixed.toFixed(3).toString() + prefix;
    return prefixed;
  }
  else {
    return "N/A";
  }
}

function addCommas(number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatNumber(number) {
  var number = parseFloat(number).toFixed(2)
  var parts = number.toString().split(".");
  parts[0] = addCommas(parts[0]);
  return parts.join(".");
}

function formatChange(change, type){
  if (!change){
    return "N/A";
  }
  else {
    var s = document.createElement('span');
    if (change > 0) {
      $(s).css('color', "#27ae60");
      s.innerHTML = "+" + formatNumber(change.toFixed(2));
    }
    else if (change < 0){
      $(s).css('color', "red");
      s.innerHTML =  formatNumber(change.toFixed(2));
    }
    else {
      s.innerHTML =  formatNumber(change);
    }

    if (type == "cash"){
      $(s).addClass('cash-text');
      s.innerHTML = "$" + s.innerHTML;
    }
    else if (type == "percent"){
      $(s).addClass('cash-text');
      s.innerHTML = s.innerHTML + "%";
    }
    return s;

  }
}

function getNumber(x) {
  var parts = x.split(".");
  parts[0] = parts[0].replace(',','');
  var s = parts.join(".");
  return parseFloat(s).toFixed(2);
}

function formatDigits(d){
  if (d < 10) {
    d = "0" + d;
  }
  return d;
}

function getReadableDate(date){
  return days[date.getDay()] + "  "
        + date.getDate()
        + "<sup>"+determineSup(date.getDate())+"</sup> of "
         +months[date.getMonth()] + ", "+ date.getFullYear();
}

function getReadableTime(time){
  var hrs = time.getHours();
  var prd = "";
  if (hrs == 12) {
    prd = "pm";
  }
  else if (hrs > 12) {
    prd = "pm"
    hrs = hrs - 12;
  }
  else if (hrs < 12) {
    prd = "am";
  }
  return formatDigits(hrs)
      +":"+
      formatDigits(time.getMinutes())
      +":<span id='seconds'>"+
      formatDigits(time.getSeconds()) +"</span> "+ prd
}

function determineSup(date){
  var lastDigit = date - (10 * parseInt(date / 10));
  if (lastDigit == 1 && date != 11){return 'st';}
  else if (lastDigit == 2 && date != 12){return 'nd';}
  else if (lastDigit == 3 && date != 13){return 'rd';}
  else{return 'th';}
}

function min(v1, v2){
  if (v1 < v2){return v1;}
  else{return v2;}
}
