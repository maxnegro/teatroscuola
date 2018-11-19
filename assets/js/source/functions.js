/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */
( function( $ ) {
    //FitVids Initialize
    if ( jQuery.isFunction( jQuery.fn.fitVids ) ) {
        jQuery('.hentry, .widget').fitVids();
    }

    // Add header video class after the video is loaded.
    $( document ).on( 'wp-custom-header-video-loaded', function() {
        $( 'body' ).addClass( 'has-header-video' );
    });

    //Equal Height Initialize
    $( function() {
        $( document ).ready( function() {
            $('.featured-content-wrapper .entry-container, .team-content-wrapper .hentry-inner').matchHeight();
        });
    });

    /**
     * Functionality for scroll to top button
     */
    $( function() {
        $(window).scroll( function () {
            if ( $( this ).scrollTop() > 100 ) {
                $( '#scrollup' ).fadeIn('slow');
                $( '#scrollup' ).show();
            } else {
                $('#scrollup').fadeOut('slow');
                $("#scrollup").hide();
            }
        });

        $( '#scrollup' ).on( 'click', function () {
            $( 'body, html' ).animate({
                scrollTop: 0
            }, 500 );
            return false;
        });
    });

    /*
     * Test if inline SVGs are supported.
     * @link https://github.com/Modernizr/Modernizr/
     */
    function supportsInlineSVG() {
        var div = document.createElement( 'div' );
        div.innerHTML = '<svg/>';
        return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
    }

    $( function() {
        $( document ).ready( function() {
            if ( true === supportsInlineSVG() ) {
                document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
            }
        });
    });


    var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

    function initMainNavigation( container ) {

        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
            .append( screenReaderText.icon )
            .append( $( '<span />', { 'class': 'screen-reader-text', text: screenReaderText.expand }) );

        container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

        // Set the active submenu dropdown toggle button initial state.
        container.find( '.current-menu-ancestor > button' )
            .addClass( 'toggled-on' )
            .attr( 'aria-expanded', 'true' )
            .find( '.screen-reader-text' )
            .text( screenReaderText.collapse );
        // Set the active submenu initial state.
        container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

        // Add menu items with submenus to aria-haspopup="true".
        container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

        container.find( '.dropdown-toggle' ).click( function( e ) {
            var _this            = $( this ),
                screenReaderSpan = _this.find( '.screen-reader-text' );

            e.preventDefault();
            _this.toggleClass( 'toggled-on' );
            _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

            // jscs:disable
            _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
            screenReaderSpan.text( screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
        } );
    }

    //For Primary Menu
    menuToggleSecondary     = $( '#menu-toggle-primary' ); // button id
    siteSecondaryMenu       = $( '#site-primary-menu' ); // wrapper id
    siteNavigationSecondary = $( '#site-primary-navigation' ); // nav id
    initMainNavigation( siteNavigationSecondary );

    // Enable menuToggleSecondary.
    ( function() {
        // Return early if menuToggleSecondary is missing.
        if ( ! menuToggleSecondary.length ) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggleSecondary.add( siteNavigationSecondary ).attr( 'aria-expanded', 'false' );

        menuToggleSecondary.on( 'click', function() {
            $( this ).add( siteSecondaryMenu ).toggleClass( 'toggled-on' );

            $('body').toggleClass('menu-is-open');

            // jscs:disable
            $( this ).add( siteNavigationSecondary ).attr( 'aria-expanded', $( this ).add( siteNavigationSecondary ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
        } );
    } )();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    ( function() {
        if ( ! siteNavigationSecondary.length || ! siteNavigationSecondary.children().length ) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if ( window.innerWidth >= 1024 ) {
                $( document.body ).on( 'touchstart', function( e ) {
                    if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
                        $( '.main-navigation li' ).removeClass( 'focus' );
                    }
                } );
                siteNavigationSecondary.find( '.menu-item-has-children > a' ).on( 'touchstart', function( e ) {
                    var el = $( this ).parent( 'li' );

                    if ( ! el.hasClass( 'focus' ) ) {
                        e.preventDefault();
                        el.toggleClass( 'focus' );
                        el.siblings( '.focus' ).removeClass( 'focus' );
                    }
                } );
            } else {
                siteNavigationSecondary.find( '.menu-item-has-children > a' ).unbind( 'touchstart' );
            }
        }

        if ( 'ontouchstart' in window ) {
            $( window ).on( 'resize', toggleFocusClassTouchScreen );
            toggleFocusClassTouchScreen();
        }

        siteNavigationSecondary.find( 'a' ).on( 'focus blur', function() {
            $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
        } );
    })();
    //Primary Menu End

    // Close menus when somewhere else in the document is clicked.
    $( document ).click( function() {
        $( 'body' ).removeClass( 'menu-is-open' );
        $( '.menu-toggle, .menu-search-toggle' ).removeClass( 'toggled-on' );
        $( '.site-primary-menu' ).removeClass( 'toggled-on' );
        $('.search-social-container').removeClass('displayblock');
        $('.search-social-container').addClass('displaynone');
    } );

    // Stop propagation if clicking inside of our main menu.
    $( '.menu-toggle, .dropdown-toggle, .search-social-container, .site-primary-menu' ).on( 'click', function( e ) {
        e.stopPropagation();
    } );


    //For Footer Menu
    menuToggleFooter       = $( '#menu-toggle-footer' ); // button id
    siteFooterMenu         = $( '#footer-menu-wrapper' ); // wrapper id
    siteNavigationFooter   = $( '#site-footer-navigation' ); // nav id
    initMainNavigation( siteNavigationFooter );

    // Enable menuToggleFooter.
    ( function() {
        // Return early if menuToggleFooter is missing.
        if ( ! menuToggleFooter.length ) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggleFooter.add( siteNavigationFooter ).attr( 'aria-expanded', 'false' );

        menuToggleFooter.on( 'click', function() {
            $( this ).add( siteFooterMenu ).toggleClass( 'toggled-on' );

            // jscs:disable
            $( this ).add( siteNavigationFooter ).attr( 'aria-expanded', $( this ).add( siteNavigationFooter ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
        } );
    } )();
    //Footer Menu End

    // Add the default ARIA attributes for the menu toggle and the navigations.
    function onResizeARIA() {
        if ( window.innerWidth < 1024 ) {
            if ( menuToggle.hasClass( 'toggled-on' ) ) {
                menuToggle.attr( 'aria-expanded', 'true' );
            } else {
                menuToggle.attr( 'aria-expanded', 'false' );
            }

            if ( siteHeaderMenu.hasClass( 'toggled-on' ) ) {
                siteNavigation.attr( 'aria-expanded', 'true' );
                socialNavigation.attr( 'aria-expanded', 'true' );
            } else {
                siteNavigation.attr( 'aria-expanded', 'false' );
                socialNavigation.attr( 'aria-expanded', 'false' );
            }

            if ( siteSecondaryMenu.hasClass( 'toggled-on' ) ) {
                siteNavigationSecondary.attr( 'aria-expanded', 'true' );
            } else {
                siteNavigationSecondary.attr( 'aria-expanded', 'false' );
            }

            if ( siteTopMenu.hasClass( 'toggled-on' ) ) {
                siteNavigationTop.attr( 'aria-expanded', 'true' );
            } else {
                siteNavigationTop.attr( 'aria-expanded', 'false' );
            }

            if ( siteFooterMenu.hasClass( 'toggled-on' ) ) {
                siteNavigationFooter.attr( 'aria-expanded', 'true' );
            } else {
                siteNavigationFooter.attr( 'aria-expanded', 'false' );
            }


            menuToggle.attr( 'aria-controls', 'site-navigation social-navigation' );
        } else {
            menuToggle.removeAttr( 'aria-expanded' );
            siteNavigation.removeAttr( 'aria-expanded' );
            socialNavigation.removeAttr( 'aria-expanded' );
            siteNavigationSecondary.removeAttr( 'aria-expanded' );
            siteNavigationTop.removeAttr( 'aria-expanded' );
            siteNavigationFooter.removeAttr( 'aria-expanded' );
            menuToggle.removeAttr( 'aria-controls' );
        }
    }

    //Search Toggle
    $( '.search-toggle' ).on( 'click', function() {

        $(this).toggleClass('toggled-on');

         $('body').toggleClass('menu-is-open');

        var jQuerythis_el_search = $(this),
            jQueryform_search = jQuerythis_el_search.siblings( '.search-social-container' );

        if ( jQueryform_search.hasClass( 'displaynone' ) ) {
            jQueryform_search.removeClass( 'displaynone' ).addClass( 'displayblock' );
        } else {
            jQueryform_search.removeClass( 'displayblock' ).addClass( 'displaynone' );
        }
    });

    //Header Media and Slider Disabled
    if ( !$('.header-media').length && !$('#feature-slider-section').length ) {
        $('body').addClass('header-top-disabled');
    }

    //Header Media Disabled
    if ( !$('.header-media').length ) {
        $('body').addClass('header-media-disabled');
    }

    /*Fixed Nav on Scroll*/
    var  mainNav = $("#header-content");
    scrolledNav = "main-nav-scrolled";
    navOffset = $('#header-content').offset().top;
    navHeight = $('#header-content').height() - 10;
    navOffsetHeight = navOffset + navHeight;

    var fixedNav = function(){
//qui
  // if( ( $(this).scrollTop() >= navOffsetHeight )) {
  if( ( $(this).scrollTop() >= navOffsetHeight ) || ( ! $('#fullpage').length ) ) {

        mainNav.addClass(scrolledNav);

        $('.header-top-disabled #header-content.main-nav-scrolled').parents('#masthead').next().css('margin-top', navHeight);
        $('body').not('.home').find('#masthead').next().css('margin-top', navHeight);
        $('body.home.page').find('#masthead').next().css('margin-top', navHeight);

        $('.remove-sticky-menu.header-top-disabled #header-content.main-nav-scrolled').parents('#masthead').next().css('margin-top', 0);
        $('body.remove-sticky-menu').not('.home').find('#masthead').next().css('margin-top', 0);
        $('body.home.page.remove-sticky-menu').find('#masthead').next().css('margin-top', 0);

      } else if( $(this).scrollTop() <= navOffset ) {

        mainNav.removeClass(scrolledNav);

        $('.header-top-disabled #header-content').parent().next().removeAttr('style');
        $('body').not('.home').find('#masthead').next().removeAttr('style');
      }

    }

    // Call on Load
    fixedNav();

    // Call on Scroll and resize
    $(window).on('scroll resize', function() {
        fixedNav();
    });

    // Add Class on sections which has background image.
    $('.section').each(function(){
        // Get background-image css property of section
        var section_style = $(this).attr('id') + ':' + $(this).css('background-image');
        var key = "url";
        // Since background-image css property returns both image and gradient, only set class for section with background-image actual image not gradient.
        if(section_style.indexOf(key) != -1){
            $(this).addClass('has-section-background-image');
        }
    });

} )( jQuery );
