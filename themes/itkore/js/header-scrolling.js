/**
 *
 * Header changes when the users scrolls
 *
 */

(function($) {
  'use strict';

  function headerScrolling() {
    var scroll = $(window).scrollTop();
    var threshold = 200;

    // Header elements
    var header              = $('.js-layout-header');
    var hamburgerMenu       = $('.js-menus-burger');
    var hamburgerMenuToggle = $('.js-burger-toggle');

    // Opening hours elements.
    var openingHoursLink  = $('.js-opening-hours-link');

    // When the user scrolls and reaches the threshold.
    if (scroll >= threshold) {
      // Make header sticky.
      header.addClass('is-sticky');
      hamburgerMenu.addClass('is-sticky');
      hamburgerMenuToggle.addClass('is-sticky');

      // Hide opening hours link.
      openingHoursLink.addClass('is-hidden');
      openingHoursLink.removeClass('is-visible');
    }
    else {
      // Make header not sticky.
      header.removeClass('is-sticky');
      hamburgerMenu.removeClass('is-sticky');
      hamburgerMenuToggle.removeClass('is-sticky');

      // Show opening hours link.
      openingHoursLink.addClass('is-visible');
      openingHoursLink.removeClass('is-hidden');
    }
  }

  // Run function when the user scrolls.
  $(window).on('scroll', headerScrolling);

})(jQuery);
