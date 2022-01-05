(function( $ ){

	'use strict';

	let JetWooBuilderCustomIcon = {

		init: function() {

			let widgets = {
				'jet-single-add-to-cart.default' : JetWooBuilderCustomIcon.widgetSingleAddToCart,
			};

			$.each( widgets, function( widget, callback ) {
				window.elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			} );

		},

		widgetSingleAddToCart: function( $scope ) {

			let btnWrapper = $scope.find( '.jet-woo-btn-with-custom-icon-wrapper' );

			if ( btnWrapper.length > 0 ) {
				let content = $( btnWrapper ).data( 'content' );

				$( btnWrapper ).find( '.single_add_to_cart_button' ).html( content );
			}

		}

	}

	$( window ).on( 'elementor/frontend/init', JetWooBuilderCustomIcon.init );

}( jQuery ) );