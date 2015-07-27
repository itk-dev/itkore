/**
 *
 * Open / Close items in the navigation menu
 *
 */

(function($) {
  // Function opening/ closing nav menu items.
  function toggle_menu_open() {
    $('.js-click-open').click(function() {
       $(this).parent().parent().toggleClass('is-open');
    });
  }

  // Start the show.
  $(document).ready(function () {
    toggle_menu_open();
    // Open menu item if active sub menu item.
    if ($('.menus--site-nav-items-first .menus--site-nav-item').hasClass("menu-item--active-trail")) {
      $('.menus--site-nav-items-first .menus--site-nav-item.menu-item--active-trail').toggleClass('is-open');
    }
  });

})(jQuery);
