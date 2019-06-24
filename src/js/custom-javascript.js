/**
 * Custom javaScripts
 *
 * Use this file to manage custom scripts for the child theme
 */
(function($) {
    'use strict';

    var delay = function(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

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

    // Reps filter form
    var repSearchFilter = $('#reps-filter');
    var repSearchResult = $('#reps-card-deck');
    var repNoResult = repSearchResult.html();
    var repSearchFilterInput = repSearchFilter.find('#rep-filter-input');
    // var repSearchFilterSubmit = repSearchFilter.find('#rep-filter-submit');
    // var repSearchFilterSubmitText = repSearchFilterSubmit.text();
    var repSearchFilterReset = repSearchFilter.find('#rep-filter-reset');
    var repSearchFilterResetText = repSearchFilterReset.text();

    repSearchFilterInput.on('keyup keypress keydown',delay(function(e){
        var keyCode = e.keyCode || e.which;
        console.log(keyCode);
        if (keyCode === 13){
            e.preventDefault();
            return false;
        }
		$.ajax({
			url:repSearchFilter.attr('ajax-url'),
			data:repSearchFilter.serialize(), // form data
			type:repSearchFilter.attr('method'), // POST
			beforeSend:function(xhr){
                repSearchFilterReset.text('Searching...'); // changing the button label
                repSearchResult.toggleClass('searching');
			},
			success:function(data){
                repSearchFilterReset.text(repSearchFilterResetText); // changing the button label back
                if(data){
                    repSearchResult.html(data); // insert data
                } else {
                    repSearchResult.html(repNoResult); // insert default
                }
                repSearchResult.toggleClass('searching');
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                repSearchResult.html(repNoResult); // insert default
                repSearchResult.toggleClass('searching');
            }
		});
		return false;
    }, 200));

    repSearchFilterReset.click(function(e){
        e.preventDefault();
        repSearchFilterInput.val('');
        repSearchResult.html(repNoResult); // insert default
		// $.ajax({
        //     url:repSearchFilter.attr('action'),
		// 	data:repSearchFilter.serialize(), // form data
		// 	type:repSearchFilter.attr('method'), // POST
        //     beforeSend:function(xhr){
        //         repSearchFilterReset.text('Clearing...'); // changing the button label
        //         repSearchResult.toggleClass('searching');
        //     },
		// 	success:function(data){
        //         repSearchFilterReset.text(repSearchFilterResetText); // changing the button label back
		// 		repSearchResult.html(data); // insert data
        //         repSearchResult.toggleClass('searching');
		// 	}
		// });
		return false;
    });

    // Video Button
    $('.play-video-button').on('click', function(event){
        event.preventDefault();
        var embedCode = $(this).data('embed-code');
        drawVideoModal( embedCode );
        var theModal = $('#video-modal');
        theModal.modal('show');
    });

    $(document).on('hidden.bs.modal', '#video-modal', function (event) {
        $(this).remove();
    });

    var drawVideoModal = function( embedCode ) {
        var html = '<!-- Modal -->' +
            '<div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="video-modal-title" aria-hidden="true">' +
                '<div class="modal-dialog modal-dialog-centered" role="document">' +
                    '<div class="modal-content">' +
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<span aria-hidden="true"><i class="fal fa-times"></i></span>' +
                        '</button>' +
                        '<div class="modal-body">' + embedCode + '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('#page').after( html );
    }

    /**
     * Share
     */
    $('.product-share.share-link').on( 'click', function( event ) {
        event.stopPropagation();
        var link = $(this).data('link');
        var html = '<div id="product-share-alert" class="alert alert-dark alert-dismissible fade show" role="alert">' +
            '<strong>Copy this link to share:</strong> <input type="text" value="' + link + '" />' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
            '</button></div>';
        $(this).after( html );
        $('#product-share-alert').show().find('input').select();
    });

    /**
     * RFQ
     */

    // Add/remove models from Queue
    $(document).on( 'click', '.product-queue-link', function( event ) {
        event.preventDefault();
        // get the model number and check if queued
        var modelNumber = $(this).data('model-number');
        var queued = $(this).data('queued');
        // add/remove model number from queue
        if ( ! queued ) {
            // $(this).html( "Queued" );
            modelNumberAdd( modelNumber );
        } else {
            // $(this).html("Add to Queue");
            modelNumberRemove( modelNumber );
        }
        // modify queued state
        queued = ! queued;
        // $(this).data( 'queued', queued ).attr( 'data-queued', queued );
        updateQueuedModels();
        if ( table ) {
            // console.log(table);
            table.cell( $(this).parent('td') ).invalidate().draw( 'page' );
        }
        sendModelsToForm();
    });

    // Load models in form on product request click
    $(document).on( 'click', '.product-request', function( event ) {
        event.preventDefault();
        // add model number to queue
        var modelNumber = $(this).data('model-number');
        modelNumberAdd( modelNumber );
        // updated the 'queued' status
        updateQueuedModels();
        // send data to form
        sendModelsToForm();
        goToForm();
    });

    // Load single model in form on product request click
    $(document).on( 'click', '.product-request-single', function( event ) {
        event.preventDefault();
        // get model number and queue
        var modelNumber = $(this).data('model-number');
        var modelsQueued = getModelsQueued();
        console.log( modelsQueued );

        // check if model already in queue
        if ( modelsQueued !== null && modelsQueued.indexOf( modelNumber ) > -1 ) {
            console.log( 'indexOf: ' + modelsQueued.indexOf( modelNumber ) );
            // send dueued data to form
            sendModelsToForm();
        } else {
            // send just this model to the form
            sendModelsToForm( modelNumber );
            console.log( 'noindex' );
        }

        // scroll to the form
        goToForm();
    });

    // Load models in form
    $(document).on( 'click', '.product-request-all', function( event ) {
        event.preventDefault();
        updateQueuedModels();
        sendModelsToForm();
        goToForm();
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
    var sendModelsToForm = function( model ) {
        $('.gfield.products-requested-field input').val( '' );
        $('.gfield.products-requested-field textarea').val( '' );
        $('.gfield.products-requested-field textarea').text( '' );
        if ( model ) {
            var modelsQueued = model;
        } else {
            var modelsQueued = getModelsQueued();
        }
        if ( $.isArray( modelsQueued ) ) {
            var modelsQueuedString = modelsQueued.join( "\r\n" );
        } else {
            var modelsQueuedString = model;
        }
        $('.gfield.products-requested-field input').val( modelsQueuedString );
        $('.gfield.products-requested-field textarea').val( modelsQueuedString );
        $('.gfield.products-requested-field textarea').text( modelsQueuedString );
    }

    // Go to the form
    var goToForm = function() {
        $('form.request-product-form')[0].scrollIntoView();
        $('form.request-product-form').find('li.gfield:first-of-type input').focus();
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
            if ( modelsQueued !== null ) {
                var newModelsQueued = modelsQueued.concat( modelsArray ).unique();
            } else {
                var newModelsQueued = modelsArray;
            }
            localStorage.setItem( 'modelsQueued' , JSON.stringify( newModelsQueued ) );
        } else {
            var modelsQueued = JSON.parse( $('body').data( 'modelsQueued' ) );
            if ( modelsQueued !== null ) {
                var newModelsQueued = modelsQueued.concat( modelsArray ).unique();
            } else {
                var newModelsQueued = modelsArray;
            }
            $('body').data( 'modelsQueued', JSON.stringify( newModelsQueued ) );
        }
        sendModelsToForm();
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
        var modelsQueued = getModelsQueued();
        sendModelsToForm();
    }

    // Remove All Models from Queue
    var modelNumbersRemoveAll = function() {
        var newModelsQueued = [];
        if ( localStorage ) {
            localStorage.setItem( 'modelsQueued' , JSON.stringify( newModelsQueued ) );
        } else {
            $('body').data( 'modelsQueued', JSON.stringify( newModelsQueued ) );
        }
        sendModelsToForm();
    }

    // Update model queue links
    var updateQueuedModels = function() {
        var modelsQueued = getModelsQueued();
        $('.product-queue-link').each( function() {
            var modelNumber = $(this).data('model-number');
            if ( modelsQueued !== null && modelsQueued.indexOf( modelNumber ) > -1 ) {
                $(this).data( 'queued', true ).attr( 'data-queued', true ).html( "Queued" );
            } else {
                $(this).data( 'queued', false ).attr( 'data-queued', false ).html( "Add to Queue" );
            }
        });
        updateRequestAllButton();
        // sendModelsToForm();
    }

    // Update the Request All button styles based on queue
    var updateRequestAllButton = function() {
        var thebutton = $('.product-request-all');
        var modelsQueued = getModelsQueued();
        // console.log(modelsQueued);
        if ( modelsQueued !== null && modelsQueued.length > 0 ) {
            thebutton.removeClass('btn-outline-gray').addClass('btn-secondary');
        } else {
            thebutton.removeClass('btn-secondary').addClass('btn-outline-gray');
        }
    }

    // After GForm submit success
    $(document).on("gform_confirmation_loaded", function (e, form_id) {
        if ( form_id === 3 ) {
            modelNumbersRemoveAll();
            updateQueuedModels();
        }
    });

    /* END: RFQ */

    /**
     * Datatables
     */
    var table = $('#products-table').DataTable( {
        "responsive": true,
        "order": [[ 1, "asc" ]],
        "columnDefs": [
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
        },
        "drawCallback": updateQueuedModels()
    });

    $('#productsearch').on( 'keyup', function () {
        table.search( this.value ).draw();
    } );

    $('#product-cats-nav').on( 'click', 'a', function( event ) {
        event.preventDefault();
        if ( $(this).hasClass('active') ) {
            table.columns( 5 ).search( '' ).draw();
            if ( ! $(this).data('show-all') ) {
                $(this).removeClass('active');
                $('#product-cats-nav').find('a[data-show-all]').addClass('active');
            }
        } else {
            table.columns( 5 ).search( '^'+$(this).data('cat-slug')+'$', true, false ).draw();
            $(this).addClass('active').siblings().removeClass('active');
        }
    } );

    /**
     * Timeline
     */

    // Next element in timeline
    var timelineNext = function( timeline ) {
        // get the current dial and focus index
        var dial = timeline.find('.timeline-dial');
        var currentFocusIndex = dial.data('focus');
        if ( typeof( currentFocusIndex ) === 'undefined' ) {
            currentFocusIndex = 0;
        }
        // Get the first and last index
        var dialElements = dial.find('.timeline-element');
        var firstIndex = dialElements.index( dialElements.first() );
        var lastIndex = dialElements.index( dialElements.last() );
        // set the next focus index
        if ( currentFocusIndex < lastIndex ) {
            var newFocusIndex = currentFocusIndex + 1;
            dial.data( 'focus', newFocusIndex );
            timelineRefocus( timeline, newFocusIndex );
        } else {
            // console.log('already showing last timeline element');
        }
    }

    // Next element in timeline
    var timelinePrev = function( timeline ) {
        // get the current dial and focus index
        var dial = timeline.find('.timeline-dial');
        var currentFocusIndex = dial.data('focus');
        if ( typeof( currentFocusIndex ) === 'undefined' ) {
            currentFocusIndex = 0;
        }
        // Get the first and last index
        var dialElements = dial.find('.timeline-element');
        var firstIndex = dialElements.index( dialElements.first() );
        var lastIndex = dialElements.index( dialElements.last() );
        // set the next focus index
        if ( currentFocusIndex > firstIndex ) {
            var newFocusIndex = currentFocusIndex - 1;
            dial.data( 'focus', newFocusIndex );
            timelineRefocus( timeline, newFocusIndex );
        } else {
            // console.log('already showing first timeline element');
        }
    }

    // Set timeline focus and rotation
    var timelineRefocus = function( timeline, index ) {
        // get the current dial and set the focus index
        var dial = timeline.find('.timeline-dial');
        dial.data('focus', index).attr('data-focus', index);
        // update current rotation
        var rotate = index * -34.5;
        dial.data('rotate', rotate).css('transform', 'rotate('+rotate+'deg)');
        // remove classes from dial elements
        var dialElements = dial.find('.timeline-element');
        dialElements.removeClass('focus near');
        // add classes to newly focused elements
        var focusedElement = dialElements.eq( index );
        focusedElement.addClass('focus');
        focusedElement.next().addClass('near');
        focusedElement.prev().addClass('near');
    }

    // Setup timelines on document ready
    $('.timeline-dial').each(function(){
        var dial = $(this);
        var timeline = dial.closest('.timeline-wrapper');
        // set the default data vals
        dial.data('focus', 0);
        dial.data('rotate', 0);
        // fan out the dial elements
        var dialElements = dial.find('.timeline-element');
        dialElements.each(function(i){
            var rotate = i * 34.5;
            $(this).css('transform', 'rotate(' + rotate + 'deg)');
        });
        // set initial focus
        timelineRefocus( timeline, 0 );
    });

    // Timeline arrows next/prev actions
    $('.timeline-arrow').on('click', function(event){
        event.preventDefault();
        var timelineID = $(this).data('timeline');
        var timeline   = $('#timeline-' + timelineID);
        if ( $(this).hasClass('timeline-next') ) {
            // console.log('timeline next');
            timelineNext( timeline );
        }
        if ( $(this).hasClass('timeline-prev') ) {
            // console.log('timeline previous');
            timelinePrev( timeline );
        }
    });
    /* END Timeline */

    /**
     * Nav Fix for Dropdown Gaps (Bootstrap)
     *
     * This jQuery fixes hover state issues when the menu dropdown
     * has a gap from its parent nav item, thus closing the dropdown
     * before the cursor can span the gap. This adds a slight delay
     * to allow the cursor to cross the gap before the dropdown is
     * closed.
     */
	var navTimer;
	var navRef; // .dropdown

	$(".dropdown")
		.on("mouseover", showDropdown)
		.on("mouseleave", function(){
			navTimer = setTimeout( hideDropdown, 250);
		});

	function showDropdown() {
		clearTimeout(navTimer);
		hideDropdown();
		navRef = $(this);
        navRef.addClass("show")
            .children('.dropdown-toggle').attr('aria-expanded', "true")
            .siblings('.dropdown-menu').addClass("show");
        }

    function hideDropdown() {
        if (navRef)
            navRef.removeClass("show")
                .children('.dropdown-toggle').attr('aria-expanded', "true")
                .siblings('.dropdown-menu').removeClass("show");
	}

    /**
     * PAGE INIT
     */
    updateQueuedModels(); // set the default queued products on page load

})(jQuery);
