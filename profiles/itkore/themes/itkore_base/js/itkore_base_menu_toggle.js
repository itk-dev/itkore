/**
 * @file
 * Toggle hamburger menu.
 */
(function ($) {
  "use strict";

  var hamburger_button = $('.nav-toggle');
  var hamburger_menu = $('.hamburger-menu');
  var html = $('html');
  var body = $('body');
  var overlay = $('.hamburger-menu--overlay');

  $('.js-menu-toggle').click(function() {
    hamburger_button.toggleClass("is-open");

    // Toggle hamburger menu.
    hamburger_menu.toggleClass("is-open");

    // Toggle overlay.
    overlay.toggleClass('is-visible');

    // Toggle html and body element.
    html.toggleClass('is-locked');
    body.toggleClass('is-locked');
  });
})(jQuery);
