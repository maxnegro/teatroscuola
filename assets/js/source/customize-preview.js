/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var style = $( '#catch-fullscreen-color-scheme-css' ),
		api = wp.customize;

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="catch-fullscreen-color-scheme-css" />' )
		                    .find( '#catch-fullscreen-color-scheme-css' );
	}

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site tagline.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Add custom-background-image body class when background image is added.
	api( 'background_image', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'custom-background-image', '' !== to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-identity' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-identity' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .custom-header .entry-title,	.custom-header,	.custom-header-media .wp-custom-header-video-button, .custom-header-media .wp-custom-header-video-button.wp-custom-header-video-pause, .custom-header-media .wp-custom-header-video-button:hover, .custom-header-media .wp-custom-header-video-button:focus' ).css( {
					'color': to
				} );

				var c;

			    if( /^#([A-Fa-f0-9]{3}){1,2}$/.test( to ) ){
			        c= to.substring(1).split('');
			        if(c.length== 3){
			            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
			        }
			        c= '0x'+c.join('');
			        to_rgb = 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',.55)';
			    }

				$( '.site-description' ).css( {
					'color': to_rgb
				} );

			}
		} );
	} );
} )( jQuery );
