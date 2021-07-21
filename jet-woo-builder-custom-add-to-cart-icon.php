<?php
/**
 * Plugin Name: JetWooBuilder - Custom Add to Cart Icon
 * Plugin URI:
 * Description:
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-woo-builder
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Jet_Woo_Builder_Custom_Add_To_Cart_Icon {

	public $quantity = '';
	public $icon     = '';

	public function __construct() {

		define( 'JET_CATCI__FILE__', __FILE__ );

		// enqueue plugin styles
		add_action( 'wp_enqueue_scripts', [ $this, 'jet_woo_catci_styles' ] );

		// register controls for Products Grid widget
		add_action( 'elementor/element/jet-woo-products/section_general/after_section_end', [ $this, 'register_custom_add_to_cart_icon_controls' ], 10, 2 );
		add_action( 'elementor/element/jet-woo-products/section_not_found_message_style/after_section_end', [ $this, 'register_custom_add_to_cart_icon_style_controls' ], 10, 2 );
		// register controls for Products List widget
		add_action( 'elementor/element/jet-woo-products-list/section_general/after_section_end', [ $this, 'register_custom_add_to_cart_icon_controls' ], 10, 2 );
		add_action( 'elementor/element/jet-woo-products-list/section_not_found_message_style/after_section_end', [ $this, 'register_custom_add_to_cart_icon_style_controls' ], 10, 2 );
		// register controls for Archive Add to Cart widget
		add_action( 'elementor/element/jet-woo-builder-archive-add-to-cart/section_archive_add_to_cart_content/after_section_end', [ $this, 'register_custom_add_to_cart_icon_controls' ], 10, 2 );
		add_action( 'elementor/element/jet-woo-builder-archive-add-to-cart/section_archive_add_to_cart_style/after_section_end', [ $this, 'register_custom_add_to_cart_icon_style_controls' ], 10, 2 );

		// handle custom icon settings
		add_filter( 'jet-woo-builder/jet-woo-products-grid/settings', [ $this, 'get_products_grid_icon_settings' ], 10, 2 );
		add_filter( 'jet-woo-builder/jet-woo-products-list/settings', [ $this, 'get_products_grid_icon_settings' ], 10, 2 );
		add_filter( 'jet-woo-builder/jet-woo-archive-add-to-cart/settings', [ $this, 'get_products_grid_icon_settings' ], 10, 2 );

		// trigger widget settings
		add_action( 'jet-woo-builder/templates/jet-woo-products/custom-button-icon', [ $this, 'trigger_products_grid_settings' ] );
		add_action( 'jet-woo-builder/templates/jet-woo-products-list/custom-button-icon', [ $this, 'trigger_products_grid_settings' ] );

		// rewrite add to cart loop template
		add_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'custom_add_to_cart_icon_for_woocommerce_loop_add_to_cart_link' ], 20, 3 );

		// add custom add to cart icon settings to providers settings list
		add_filter( 'jet-smart-filters/providers/jet-woo-products-grid/settings-list', [ $this, 'add_custom_add_to_cart_icon_settings_to_list' ] );
		add_filter( 'jet-smart-filters/providers/jet-woo-products-list/settings-list', [ $this, 'add_custom_add_to_cart_icon_settings_to_list' ] );

	}

	/**
	 * Enqueue plugin styles
	 */
	public function jet_woo_catci_styles() {
		wp_enqueue_style( 'jet-woo-catci-styles', plugins_url( '/assets/css/styles.min.css', JET_CATCI__FILE__ ) );
	}

	/**
	 * Register custom Add to Cart icon controls
	 *
	 * @param $obj
	 */
	public function register_custom_add_to_cart_icon_controls( $obj ) {

		$obj->start_controls_section(
			'section_custom_add_to_cart_icon',
			[
				'label' => esc_html__( 'Custom Add to Cart Icon', 'jet-woo-builder' ),
			]
		);

		$obj->add_control(
			'enable_custom_add_to_cart_icon',
			[
				'label' => esc_html__( 'Enable Custom Icon', 'jet-woo-builder' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$obj->__add_advanced_icon_control(
			'custom_add_to_cart_icon',
			[
				'label'       => esc_html__( 'Select Icon', 'jet-woo-builder' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-shopping-cart',
				'fa5_default' => [
					'value'   => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'enable_custom_add_to_cart_icon' => 'yes',
				],
			]
		);

		$obj->add_control(
			'icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => [
					'row'         => esc_html__( 'Before', 'jet-woo-builder' ),
					'row-reverse' => esc_html__( 'After', 'jet-woo-builder' ),
				],
				'selectors' => [
					'{{WRAPPER}} .jet-woo-button-content' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'enable_custom_add_to_cart_icon' => 'yes',
				],
			]
		);

		$obj->add_control(
			'icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .jet-woo-button-content' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_custom_add_to_cart_icon' => 'yes',
				],
			]
		);

		$obj->end_controls_section();

	}

	public function register_custom_add_to_cart_icon_style_controls( $obj ) {

		$obj->start_controls_section(
			'section_style_custom_icon',
			[
				'label' => esc_html__( 'Custom Icon', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$obj->add_control(
			'custom_icon_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jet-woo-button-content .button-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jet-woo-button-content .button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$obj->add_control(
			'custom_icon_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a:hover .jet-woo-button-content .button-icon'          => 'color: {{VALUE}};',
					'{{WRAPPER}} a:hover .jet-woo-button-content .button-icon svg'      => 'fill: {{VALUE}};',
					'{{WRAPPER}} button:hover .jet-woo-button-content .button-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} button:hover .jet-woo-button-content .button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$obj->add_responsive_control(
			'custom_icon_size',
			[
				'label'     => esc_html__( 'Size', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .jet-woo-button-content .button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$obj->end_controls_section();

	}

	/**
	 * Adding Add to Cart button custom icon settings.
	 *
	 * @param $settings
	 * @param $widget
	 *
	 * @return mixed
	 */
	public function get_products_grid_icon_settings( $settings, $widget ) {

		if ( isset( $settings['selected_custom_add_to_cart_icon'] ) || isset( $settings['custom_add_to_cart_icon'] ) ) {
			$settings['selected_custom_add_to_cart_icon'] = htmlspecialchars( $widget->__render_icon( 'custom_add_to_cart_icon', '%s', '', false ) );
		}

		if ( is_a( $widget, 'Elementor\Jet_Woo_Builder_Archive_Add_To_Cart' ) ) {
			$this->quantity = 'yes' === $settings['show_quantity'];
			$this->icon     = htmlspecialchars_decode( $settings['selected_custom_add_to_cart_icon'] );
		}

		return $settings;

	}

	/**
	 * Set global variables for wc hook handling.
	 *
	 * @param $settings
	 */
	public function trigger_products_grid_settings( $settings ) {

		$this->quantity = 'yes' === $settings['show_quantity'];
		$this->icon     = htmlspecialchars_decode( $settings['selected_custom_add_to_cart_icon'] );

	}

	/**
	 * Override loop add to cart template and show icon next to add to cart label
	 *
	 * @param $html
	 * @param $product
	 * @param $args
	 *
	 * @return string
	 */
	public function custom_add_to_cart_icon_for_woocommerce_loop_add_to_cart_link( $html, $product, $args ) {

		if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
			if ( $this->quantity && $this->icon ) {
				$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
				$html .= woocommerce_quantity_input( [], $product, false );
				$html .= '<button type="submit" class="alt ' . $args['class'] . '" data-product_id="' . $product->get_id() . '" data-quantity="1"><span class="jet-woo-button-content"><span class="button-icon">' . $this->icon . '</span><span class="button-label">' . esc_html( $product->add_to_cart_text() ) . '</span></span></button>';
				$html .= '</form>';
			} elseif ( $this->icon ) {
				$html = sprintf(
					'<a href="%s" data-quantity="%s" class="%s" %s><span class="jet-woo-button-content"><span class="button-icon">' . $this->icon . '</span><span class="button-label">%s</span></span></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				);
			}
		}

		return $html;

	}

	/**
	 * Returns merged custom icon settings with JetSmartFilters providers settings list
	 *
	 * @param $list
	 *
	 * @return array
	 */
	public function add_custom_add_to_cart_icon_settings_to_list( $list ) {

		$custom_icon_settings = [
			'show_quantity',
			'enable_custom_add_to_cart_icon',
			'custom_add_to_cart_icon',
			'selected_custom_add_to_cart_icon',
		];

		return array_merge( $list, $custom_icon_settings );

	}

}

new Jet_Woo_Builder_Custom_Add_To_Cart_Icon();