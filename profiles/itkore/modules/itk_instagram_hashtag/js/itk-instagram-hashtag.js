(function($) {
  function initInstafeed(tag, id) {
    var clientId = drupalSettings.itkInstagramHashtag.clientId;
    var enableCaption = drupalSettings.itkInstagramHashtag.enableCaption;
    var limit = drupalSettings.itkInstagramHashtag.limit;
    var resolution = drupalSettings.itkInstagramHashtag.resolution;
    var sortBy = drupalSettings.itkInstagramHashtag.sortBy;

    var feed = new Instafeed({
      "get": 'tagged',
      "tagName": tag,
      "target": id,
      "clientId": clientId,
      "enableCaption": enableCaption,
      "limit": limit,
      "resolution": resolution,
      "sortBy": sortBy,
      "template":
        '<figure class="instagram-gallery--figure">' +
          '<a href="{{link}}" title="{{caption}}" class="instagram-gallery--link">' +
            '<img src="{{image}}" class="instagram-gallery--image">' +
          '</a>' +
          (enableCaption ? '<figcaption class="instagram-gallery--caption">{{caption}}</figcaption>' : '') +
        '</figure>'
    });
    feed.run();
  }

  $('.instagram-gallery--wrapper').each(function() {
    initInstafeed((this.id.split('instafeed--'))[1], this.id);
  });
}(jQuery));
