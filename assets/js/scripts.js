(function ( $ ) {

	'use strict';

	let JetWooBuilderCustomIcon = {

		init: function () {

			let widgets = {
				'jet-single-add-to-cart.default': JetWooBuilderCustomIcon.widgetSingleAddToCart,
				'jet-wishlist.default': JetWooBuilderCustomIcon.widgetWishlist,
			};

			$.each( widgets, function ( widget, callback ) {
				window.elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			} );

			$( document ).on( 'jet-cw-loaded', function () {
				const widgets = document.querySelectorAll( '.elementor-widget-jet-wishlist' );

				if ( widgets.length ) {
					widgets.forEach( scope => {
						JetWooBuilderCustomIcon.widgetWishlist( $( scope ) );
					} )
				}
			} );
		},

		widgetSingleAddToCart: function ( $scope ) {

			let btnWrapper = $scope.find( '.jet-woo-btn-with-custom-icon-wrapper' );

			if ( btnWrapper.length > 0 ) {
				let content = $( btnWrapper ).data( 'content' );

				$( btnWrapper ).find( '.single_add_to_cart_button' ).html( content );
			}

		},

		widgetWishlist: function ( $scope ) {

			const
				settings = JetWooBuilderCustomIcon.getElementorElementSettings( $scope ),
				iconEnable = settings.enable_custom_add_to_cart_icon;

				if ( ! iconEnable ) {
					return;
				}

			const
				settingsCustomIcon = settings.selected_custom_add_to_cart_icon,
				iconType = settingsCustomIcon.library;

			if ( iconEnable === 'yes' && iconType !== '' ) {
				const
					node = $scope[ 0 ],
					btns = node.querySelectorAll( '.product_type_simple' );

				if ( btns.length ) {
					btns.forEach( btn => {
						const
							btnOuterDiv = document.createElement( 'div' ),
							btnInnerDiv = document.createElement( 'span' ),
							btnIcon = document.createElement( 'span' ),
							btnText = btn.querySelector( '.button-text' ) || $( btn ).text();

						if ( btnText ) {
							$( btn ).text('');

							// Added Classes
							btnOuterDiv.classList.add( 'jet-woo-btn-with-custom-icon-wrapper' );
							btnInnerDiv.classList.add( 'jet-woo-button-content' );
							btnIcon.classList.add( 'button-icon' );

							if ( iconType === 'svg' ) {
								const url = settingsCustomIcon.value.url;

								const ajax = new XMLHttpRequest();
								ajax.open( "GET", url, true );
								ajax.send();
								ajax.onload = () => btnIcon.innerHTML = ajax.responseText;
							} else {
								const iconFont = document.createElement( 'i' );
								const iconClass = settingsCustomIcon.value.split( ' ' );
								iconFont.setAttribute( 'aria-hidden', 'true' )
								iconFont.classList.add( ...iconClass );
								btnIcon.append( iconFont );
							}

							// Structure Change
							btn.after( btnOuterDiv );
							btnInnerDiv.append( btnIcon );
							btnInnerDiv.append( btnText );
							btn.append( btnInnerDiv );
							btnOuterDiv.append( btn );
						}
					} );
				}
			}
		},

		getElementorElementSettings: function ( $scope ) {

			if ( window.elementorFrontend && window.elementorFrontend.isEditMode() && $scope.hasClass( 'elementor-element-edit-mode' ) ) {
				return JetWooBuilderCustomIcon.getEditorElementSettings( $scope );
			}

			return $scope.data( 'settings' ) || {};

		},

		getEditorElementSettings: function ( $scope ) {

			let modelCID = $scope.data( 'model-cid' ), elementData;

			if ( ! modelCID ) {
				return {};
			}

			if ( ! window.elementorFrontend.hasOwnProperty( 'config' ) ) {
				return {};
			}

			if ( ! window.elementorFrontend.config.hasOwnProperty( 'elements' ) ) {
				return {};
			}

			if ( ! window.elementorFrontend.config.elements.hasOwnProperty( 'data' ) ) {
				return {};
			}

			elementData = window.elementorFrontend.config.elements.data[ modelCID ];

			if ( ! elementData ) {
				return {};
			}

			return elementData.toJSON();

		},

	};

	$( window ).on( 'elementor/frontend/init', JetWooBuilderCustomIcon.init );

}( jQuery ));