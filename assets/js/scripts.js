jQuery(document).ready(function( $ ){
	let btnWrapper = $.find( '.single-product .jet-woo-btn-with-custom-icon-wrapper' );

	if ( btnWrapper.length > 0 ) {
		let content = $( btnWrapper ).data( 'content' );

		$( btnWrapper ).find( '.single_add_to_cart_button' ).html( content );
	}
});