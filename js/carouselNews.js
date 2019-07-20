function createListItem(slideIndex, isActive){
  var li = document.createElement('li');
  $(li).attr('data-target','#carouselCaptions');
  $(li).attr('data-slide-to', slideIndex);
  if (isActive){
    $(li).addClass('active');
  }
  return li;
}

function createCarouselItem(headline, url, source, summary, date, image, isActive){
  // make the headline
  var hDiv = document.createElement('h6');
  $(hDiv).html(headline);
  // make the badge
  if (source != ""){
    var badge = document.createElement('span');
    $(badge).addClass('badge badge-pill badge-secondary pointer');
    $(badge).html('source');
    tippy(badge,{
      content: source + ": <a href='"+url+"'>Go</a>",
      animation: 'fade',
      arrow: true,
      arrowType: 'sharp',
      delay: [500,5],
      followCursor: false,
      interactive: true
    });
  }

  // make the summary
  if (summary != ""){
    var sH = document.createElement('span');
    $(sH).addClass('badge badge-pill badge-dark pointer');
    $(sH).html('summary');
    tippy(sH,{
      content: summary,
      animation: 'fade',
      arrow: true,
      arrowType: 'sharp',
      delay: [500,5],
      followCursor: false,
      interactive: true
    });
  }

  // make the date
  var dH = document.createElement('p');
  $(dH).css('padding','50px');
  $(dH).html(getReadableDate(date) + " " + getReadableTime(date));

  // create the media body
  var mBody = document.createElement('div');
  $(mBody).addClass('mediaBody');
  $(mBody).append(hDiv);
  $(mBody).append(document.createElement('hr'));
  if(source != ""){
    $(mBody).append(badge);
  }
  $(mBody).append(document.createElement('br'));
  if(summary)
  $(mBody).append(sH)
  $(mBody).append(document.createElement('hr'));
  $(mBody).append(dH);

  // make the image
  var img = document.createElement('img');
  $(img).addClass('img-fluid align-self-center mr-3');
  $(img).css('width','50%');
  $(img).css('height','50%');
  $(img).attr('src','/static/favicon.png');
  $(img).attr('alt',headline);

  // make the media
  var mDiv = document.createElement('div');
  $(mDiv).addClass('media');
  $(mDiv).append(img);
  $(mDiv).append(mBody);

  // make the carousel createCarouselItem
  var cDiv = document.createElement('div');
  $(cDiv).addClass('carousel-item');
  if (isActive){
    $(cDiv).addClass('active');
  }
  $(cDiv).append(mDiv);

  return cDiv;
}
