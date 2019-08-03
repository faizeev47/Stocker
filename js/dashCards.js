function makeStockCard(symbol, companyName, latestPrice, close, open, changePercent, change, latestVolume, volume, avgTotalVolume, cardSet){
  var cardTitle = document.createElement('h5');
  $(cardTitle).addClass('card-title');
  $(cardTitle).text(companyName);

  var cardText = document.createElement('p');
  if(cardSet){
    $(cardText).addClass('card-text');
    var color = "white";
    var img;
    if (changePercent > 0.00){
      img = $(caretUp).clone();
      color = "#2ecc71";
    }
    else if (changePercent < 0.00){
      img = $(caretDown).clone();
      color = "red";
    }
    var lpSpan = document.createElement('span');
    $(lpSpan).addClass('cash-text');
    $(lpSpan).text("$" + formatNumber(latestPrice));
    if(open){
      var opSpan = document.createElement('span');
      $(opSpan).addClass('cash-text');
      $(opSpan).text("$" + formatNumber(open));
    }

    if(close){
      var clSpan = document.createElement('span');
      $(clSpan).addClass('cash-text');
      $(clSpan).text("$" + formatNumber(close));
    }

    var changeSpan = document.createElement('span');
    $(changeSpan).addClass('cash-text');
    $(changeSpan).css('color',color);
    $(changeSpan).append($(img).clone());
    $(changeSpan).append(document.createElement('br'));
    $(changeSpan).append(formatChange(change, "cash"));
    $(changeSpan).append("(");
    $(changeSpan).append(formatChange(changePercent, "percent"));
    $(changeSpan).append(")");

    $(cardText).append("Latest: ");
    $(cardText).append(lpSpan);
    $(cardText).append(document.createElement('br'));
    if(open){
      $(cardText).append("Opening: ");
      $(cardText).append(opSpan);
      $(cardText).append(document.createElement('br'));
    }
    if(close){
      $(cardText).append("Closing: ");
      $(cardText).append(clSpan);
    }
    $(cardText).append(document.createElement('hr'));
    $(cardText).append(changeSpan);
    $(cardText).append(document.createElement('hr'));
    var string = latestVolume ? "Latest Volume: " + getPrefix(latestVolume) :
                volume ? "Volume" + getPrefix(volume) :
                avgTotalVolume ? "Average Volume: " + getPrefix(avgTotalVolume) :
                "N/A";
    $(cardText).append(string);
  }
  var cardBody = document.createElement('div');
  $(cardBody).addClass('card-body text-secondary');
  $(cardBody).append(cardTitle);
  $(cardBody).append(document.createElement('hr'));
  $(cardBody).append(cardText);
  var cardHeader = document.createElement('div');
  $(cardHeader).addClass('card-header trade-font');
  $(cardHeader).text(symbol);
  var card = document.createElement('div');
  $(card).attr('data-content-tippy','Go to '+companyName+' stock');
  $(card).addClass('card border-secondary');
  $(card).append(cardHeader);
  $(card).append(cardBody);
  if(cardSet){
    var link = document.createElement('a');
    $(link).append(card);
    $(link).attr('href',"detailedQuote?symbol=" + symbol);
    return link;
  }
  else {
    return card;
  }

}
function makeStockSection(heading, className){
  var label = document.createElement('label');
  $(label).addClass('display-4');
  $(label).html(heading);
  var br = document.createElement('br');
  var badge = document.createElement('span');
  $(badge).addClass('badge badge-pill badge-success');
  $(badge).html('Live');
  var hr = document.createElement('hr');
  var container = document.createElement('div');
  $(container).addClass('container-fluid');
  var cardCols = document.createElement('div');
  $(cardCols).addClass(className+"-stocks card-columns");
  $(container).append(cardCols);
  $('#' + className + "-section").append(label);
  $('#' + className + "-section").append(br);
  $('#' + className + "-section").append(badge);
  $('#' + className + "-section").append(hr);
  $('#' + className + "-section").append(container);
}
