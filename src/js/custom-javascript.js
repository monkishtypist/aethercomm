/**
 * Custom javaScripts
 *
 * Use this file to manage custom scripts for the child theme
 */
(function($) {

    // Main Menu: transition background based on scroll position

    var wrapperNavbar = $("#wrapper-navbar"); //caches a jQuery object containing the header element

    var scrollOffset = 100;
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

    searchform.submit(function(event){             // 0.  When attempting to submit the form...
        event.preventDefault();                    //
        event.stopPropagation();                   //
        if (searchform.is(".show") ){              // 1a  If the form is already visible...
            if ($.trim(searchinput.val()) != "" ){ // -2a and has some value...
                searchform[0].submit();            // --3 submit the form.
            } else {                               // -2b and has no value...
                searchform.removeClass("show");    // --3 hide the form.
            }                                      //
        } else {                                   // 1b  If the form is not visible...
            searchform.addClass("show");           // -2  show the form...
            searchinput.focus();                   // -3  and focus the element.
        }
    });
    $(document).on("click", function(event) {                         // When clicking anywhere on the site...
        var target = $(event.target);                                 //
        if (target.parents().addBack().is("#searchform") === false) { // if clicking outside the search form...
            searchform.removeClass("show");                           // hide the search form...
            searchinput.val("");                                      // and remove any stored value.
        }
    });

    // Datatables
    var table = $('#products-table').DataTable( {
        "columnDefs": [
            {
                "order": [[ 1, "asc" ]]
            },
            {
                "targets": [ 0 ],
                "orderable": false
            },
            {
                "targets": [ 5 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "orderable": false
            }
        ],
        "oSearch": {
            "sSearch": $('#productsearch').val()
        }
    });

    $('#productsearch').on( 'keyup', function () {
        table.search( this.value ).draw();
    } );

    $('#product-cats-nav').on( 'click', 'a', function( event ) {
        event.preventDefault();
        if ( $(this).hasClass('active') ) {
            table.columns( 5 ).search( '' ).draw();
            $(this).removeClass('active');
        } else {
            table.columns( 5 ).search( '^'+$(this).data('cat-slug')+'$', true, false ).draw();
            $(this).addClass('active').siblings().removeClass('active');
        }
    } );

    // RFQ

    $('.product-queue-link').on( 'click', function( event ) {
        event.preventDefault();
        var modelNumber = $(this).data('model-number');
        var queued = $(this).data('queued');
        if ( ! queued ) {
            $(this).html("Queued");
        } else {
            $(this).html("Add to Queue");
        }
        console.log( modelNumber );
        console.log( queued );
        queued = ! queued;
    })

})(jQuery);
