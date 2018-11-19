/**
 * Theme functions file.
 *
 * Full Page Custom Supporting Scripts
 */
( function( $ ) {

    $(document).ready(function() {
        var anchor = [];
        var i;

        for (i = 0; i < $("#fullpage > .section").length; i++) {
            anchor.push( 'section' + i );
        }

        // Full page initialize.
        $('#fullpage').fullpage({
            //options here
            anchors: anchor,
            licenseKey: 'OPEN-SOURCE-GPLV3-LICENSE',
            navigation: true,
            slidesNavigation: true,
            controlArrows: true,
            navigationPosition: 'right',
            scrollOverflow: true,
            css3: false,
            scrollOverflowOptions:{
                 preventDefault: false
            },
            onLeave: function(origin, destination, direction){
                var leavingSection = this;

                if( destination.index > 0 ){
                    $( '#header-wrapper' ).addClass( 'header-top' );
                } else {
                    $( '#header-wrapper' ).removeClass( 'header-top' );
                }
            }
        });

        // Add Arrow Down and Arrow Up for page navigation.
        $('#fp-nav').prepend('<span class="arrow-up"></span>');
        $('#fp-nav').append('<span class="arrow-down"></span>');

        $('.arrow-up').on('click', function(){
            $.fn.fullpage.moveSectionUp();
        });

        $('.arrow-down').on('click', function(){
            $.fn.fullpage.moveSectionDown();
        });
    });
} )( jQuery );

