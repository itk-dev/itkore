/**
 *
 * Itk menu example file
 *
 * An example of using itk menu component.
 *
 */



/**
 *
 * Toggle  navigation
 *
 */

(function($) {
  // Function for toggle burger navigation.
  function toggle_nav() {
    var overlay = $('.js-example-overlay');
    var nav = $('.js-example-menu');

    $('.js-example-click-me').click(function() {
      // If nav is open we close it.
      if (nav.hasClass('is-visible')) {

        // Hide menu.
        nav.addClass('is-hidden');
        nav.removeClass('is-visible');

        // Hide overlay.
        overlay.addClass('is-hidden');
        overlay.removeClass('is-visible');

        // We unlock the html and body element.
        $('html').removeClass('is-locked');
        $('body').removeClass('is-locked');
      }

      // If nav is closed we open it.
      else {

        // show menu.
        nav.removeClass('is-hidden');
        nav.addClass('is-visible');

        // Show overlay.
        overlay.removeClass('is-hidden');
        overlay.addClass('is-visible');

        // We lock the html and body element to only scroll the menu.
        $('html').addClass('is-locked');
        $('body').addClass('is-locked');
      }
    });
  }

  // Start the show
  $(document).ready(function () {
    toggle_nav();
  });

})(jQuery);
