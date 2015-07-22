/**
 *
 * Toggle burger menu navigation
 *
 */

(function($) {
  // Function for toggle burger navigation.
  function toggleNav() {
    var lockedElements = $('html, body');
    var leftNav = $('.js-menus-burger');
    var overlay = $('.js-nav-overlay');
    overlay.addClass('is-hidden');

    $('.js-burger-toggle').click(function() {
      if (leftNav.hasClass('is-visible')) {
        leftNav.addClass('is-hidden');
        leftNav.removeClass('is-visible');

        // Removed locked class to body
        lockedElements.removeClass('is-locked');

        // Hide overlay.
        overlay.addClass('is-hidden');
        overlay.removeClass('is-visible');

      } else {
        leftNav.removeClass('is-hidden');
        leftNav.addClass('is-visible');

        // Show overlay.
        overlay.removeClass('is-hidden');
        overlay.addClass('is-visible');

        // Added locked class to body
        lockedElements.addClass('is-locked');
      }
    });

    // Overlay click.
    $('.js-nav-click-overlay').click(function() {
      leftNav.addClass('is-hidden');
      leftNav.removeClass('is-visible');

      // Removed locked class to body
      lockedElements.removeClass('is-locked');

      // Hide overlay.
      overlay.addClass('is-hidden');
      overlay.removeClass('is-visible');
    });
  }

  // Start the show
  $(document).ready(function () {
    toggleNav();
  });

})(jQuery);
