/**
 * Custom javaScripts
 *
 * Use this file to manage custom scripts for the child theme
 */
$(function() {
    //caches a jQuery object containing the header element
    var wrapperNavbar = $("#wrapper-navbar");
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 200) {
            wrapperNavbar.addClass("nav-transparent");
        } else {
            wrapperNavbar.removeClass("nav-transparent");
        }
    });
});
