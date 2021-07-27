<?php
/**
 * Loop add to cart button
 */

if ( 'yes' !== $this->get_attr( 'show_button' ) ) {
	return;
}

$classes = array(
	'jet-woo-product-button',
);

if ( 'yes' === $this->get_attr( 'button_use_ajax_style' ) ) {
	array_push( $classes, 'is--default' );
}

$btn_classes     = array();
$enable_quantity = 'yes' === $this->get_attr( 'show_quantity' );

do_action( 'jet-woo-builder/templates/jet-woo-products-list/custom-button-icon', $settings );
?>

<div class="<?php echo implode( ' ', $classes ); ?>"><?php jet_woo_builder_template_functions()->get_product_add_to_cart_button( $btn_classes, $enable_quantity ); ?></div>