/**
 * Custom javaScripts
 *
 * Use this file to manage custom scripts for the child theme
 */
(function($) {

    var wrapperNavbar = $("#wrapper-navbar"); //caches a jQuery object containing the header element

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 200) {
            wrapperNavbar.removeClass("nav-transparency");
        } else {
            wrapperNavbar.addClass("nav-transparency");
        }
    });

})(jQuery);
