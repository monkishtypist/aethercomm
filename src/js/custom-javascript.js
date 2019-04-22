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

    searchform.submit(function(e){                 // 0.  When attempting to submit the form...
        e.preventDefault();
        e.stopPropagation();

        if (searchform.is(".show") ){              // 1a  If the form is already visible...
            if ($.trim(searchinput.val()) != "" ){ // -2a and has some value...
                searchform[0].submit();            // --3 submit the form.
            } else {                               // -2b and has no value...
                searchform.removeClass("show");    // --3 hide the form.
            }
        } else {                                   // 1b  If the form is not visible...
            searchform.addClass("show");           // -2  show the form.
        }
    });
    $(document).on("click", function(event) {
        var target = $(event.target);
        if (target.parents().addBack().is("#searchform") === false) { // If clicking outside the search form...
            searchform.removeClass("show");                           // hide the form...
            searchinput.val("");                                      // and remove any stored value.
        }
    });

})(jQuery);
