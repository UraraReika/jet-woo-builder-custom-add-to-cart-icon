(function( $ ){

	'use strict';

	var JetWooBuilderCustomIcon = {

		init: function() {

			let btnWrapper = $.find( '.single-product .jet-woo-btn-with-custom-icon-wrapper' );

			if ( btnWrapper.length > 0 ) {
				let content = $( btnWrapper ).data( 'content' );

				$( btnWrapper ).find( '.single_add_to_cart_button' ).html( content );
			}

			elementor.channels.editor.on( 'section:activated', function ( sectionName, editor ) {
				let editedElement = editor.getOption( 'editedElementView' ),
					editorBtnWrapper = editedElement.$el.find( '.elementor-jet-single-add-to-cart .jet-woo-btn-with-custom-icon-wrapper' );

				if ( editorBtnWrapper.length > 0 ) {
					let content = $( editorBtnWrapper ).data( 'content' );

					$( editorBtnWrapper ).find( '.single_add_to_cart_button' ).html( content );
				}
			} );

		}

	}

	$( window ).on( 'elementor:init', JetWooBuilderCustomIcon.init );

	window.JetWooBuilderCustomIcon = JetWooBuilderCustomIcon;

}( jQuery ) );