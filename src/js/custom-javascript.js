/**
 * Custom javaScripts
 *
 * Use this file to manage custom scripts for the child theme
 */
(function($) {

    // Main Menu: transition background based on scroll position

    var wrapperNavbar = $("#wrapper-navbar"); //caches a jQuery object containing the header element

    var scrollOffset = 200;
    var scroll = $(window).scrollTop();

    if (scroll < scrollOffset) {
        wrapperNavbar.addClass("nav-transparency");
    }

    $(window).scroll(function() {
        scroll = $(window).scrollTop();

        if (scroll >= scrollOffset) {
            wrapperNavbar.removeClass("nav-transparency");
        } else {
            wrapperNavbar.addClass("nav-transparency");
        }
    });

    // Search Form: open/close input field actions

    var searchform = $("#searchform");
    var searchinput = $("#s");
    var searchsubmit = $("#searchsubmit");

    searchsubmit.click(function(){
        e.preventDefault();

        if (searchform.is(".show") ){
            if ($.trim(searchinput.val()) != "" ){
                searchform.submit();
            } else {
                searchform.removeClass("show");
            }
        } else {
            searchform.addClass("show");
        }
    });

})(jQuery);
