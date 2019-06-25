jQuery( document ).ready( function() {
	console.info( 'DFM WP Public' );
	console.log( 'Loading plugin javascript...' );

	jQuery( '#sports-content-item a' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( this ).tab( 'show' );
	} );

	jQuery( '#animals-content-item a' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( this ).tab( 'show' );
	} );
} );
