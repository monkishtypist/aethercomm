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

    /**
     * RFQ
     */

    // Add/remove models from Queue
    $('.product-queue-link').on( 'click', function( event ) {
        event.preventDefault();
        // get the model number and check if queued
        var modelNumber = $(this).data('model-number');
        var queued = $(this).data('queued');
        // add/remove model number from queue
        if ( ! queued ) {
            $(this).html( "Queued" );
            modelNumberAdd( modelNumber );
        } else {
            $(this).html("Add to Queue");
            modelNumberRemove( modelNumber );
        }
        // modify queued state
        queued = ! queued;
        $(this).data( 'queued', queued ).attr( 'data-queued', queued );
    });

    // Load models in form
    $('.product-request').on( 'click', function( event ) {
        event.preventDefault();
        // add model number to queue
        var modelNumber = $(this).data('model-number');
        modelNumberAdd( modelNumber );
        // updated the 'queued' status
        var queued = $(this).siblings('.product-queue-link').data('queued');
        if ( ! queued ) {
            $(this).siblings('.product-queue-link').html( "Queued" );
            queued = ! queued;
        }
        $(this).siblings('.product-queue-link').data( 'queued', queued ).attr( 'data-queued', queued );
        // send data to form
        sendModelsToForm();
    });

    // unique()
    Array.prototype.unique = function() {
        var a = this.concat();
        for( var i=0; i<a.length; ++i ) {
            for( var j=i+1; j<a.length; ++j ) {
                if( a[i] === a[j] )
                    a.splice( j--, 1 );
            }
        }
        return a;
    };

    // Send queued models to Form
    var sendModelsToForm = function() {
        var modelsQueued = getModelsQueued();
        var modelsQueuedString = modelsQueued.join();
        $('.gfield.gform_hidden input').val( modelsQueuedString );
        $('form.contact-form')[0].scrollIntoView();
    }

    // Get Models Queued
    var getModelsQueued = function() {
        if ( localStorage ) {
            var modelsQueued = JSON.parse( localStorage.getItem( 'modelsQueued' ) );
        } else {
            var modelsQueued = JSON.parse( $('body').data( 'modelsQueued' ) );
        }
        return modelsQueued;
    }

    // Add Models to Queue
    var modelNumberAdd = function( modelNumber ) {
        var modelsArray = [ modelNumber ];
        if ( localStorage ) {
            var modelsQueued = JSON.parse( localStorage.getItem( 'modelsQueued' ) );
            if ( modelsQueued ) {
                var newModelsQueued = modelsQueued.concat( modelsArray ).unique();
            } else {
                var newModelsQueued = modelsArray;
            }
            localStorage.setItem( 'modelsQueued' , JSON.stringify( newModelsQueued ) );
        } else {
            var modelsQueued = JSON.parse( $('body').data( 'modelsQueued' ) );
            if ( modelsQueued ) {
                var newModelsQueued = modelsQueued.concat( modelsArray ).unique();
            } else {
                var newModelsQueued = modelsArray;
            }
            $('body').data( 'modelsQueued', JSON.stringify( newModelsQueued ) );
        }
    }

    // Remove Models from Queue
    var modelNumberRemove = function( modelNumber ) {
        if ( localStorage ) {
            var modelsQueued = JSON.parse( localStorage.getItem( 'modelsQueued' ) );
            if ( modelsQueued ) {
                var newModelsQueued = modelsQueued.filter( function( value, index, arr ) {
                    return value != modelNumber;
                });
            } else {
                var newModelsQueued = [];
            }
            localStorage.setItem( 'modelsQueued' , JSON.stringify( newModelsQueued ) );
        } else {
            var modelsQueued = JSON.parse( $('body').data( 'modelsQueued' ) );
            if ( modelsQueued ) {
                var newModelsQueued = modelsQueued.filter( function( value, index, arr ) {
                    return value != modelNumber;
                });
            } else {
                var newModelsQueued = [];
            }
            $('body').data( 'modelsQueued', JSON.stringify( newModelsQueued ) );
        }
    }

    // Remove All Models from Queue
    var modelNumbersRemoveAll = function() {
        var newModelsQueued = [];
        if ( localStorage ) {
            localStorage.setItem( 'modelsQueued' , JSON.stringify( newModelsQueued ) );
        } else {
            $('body').data( 'modelsQueued', JSON.stringify( newModelsQueued ) );
        }
    }

    // Update model queue links
    var preloadQueuedModels = function() {
        var modelsQueued = getModelsQueued();
        var arrayLength = modelsQueued.length;
        $('.product-queue-link').each( function() {
            var modelNumber = $(this).data('model-number');
            if ( modelNumber.indexOf( $(this).data( 'model-number' ) ) ) {
                $(this).data( 'queued', true ).attr( 'data-queued', true ).html( "Queued" );
            } else {
                $(this).data( 'queued', false ).attr( 'data-queued', false ).html( "Add to Queue" );
            }
        });
    }
    preloadQueuedModels();

    // After GForm submit success
    $(document).on("gform_confirmation_loaded", function (e, form_id) {
        if ( form_id === 1 ) {
            modelNumbersRemoveAll();
            preloadQueuedModels();
        }
    });

    /* END: RFQ */

})(jQuery);
