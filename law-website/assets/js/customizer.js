/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
    // Logo Width
    wp.customize( 'logo_width', function( value ) {
        value.bind( function( newval ) {
            $( '.custom-logo' ).css( 'width', newval + 'px' );
        } );
    } );
    
    // Logo Height
    wp.customize( 'logo_height', function( value ) {
        value.bind( function( newval ) {
            $( '.custom-logo' ).css( 'height', newval + 'px' );
        } );
    } );
} )( jQuery );
